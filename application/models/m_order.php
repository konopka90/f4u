<?

class M_Order extends CI_Model { 


	function __construct() { 
		parent::__construct();
	} 
	
	function get_order($order_id) {
	
		$q = $this->db->get_where('order', array('order_id' => $order_id), 1);
		return $q->row();
	
	}
	
	function get_order_with_products($order_id) {
		
		$this->benchmark->mark('start');
	
		//daj zamowienie
		$this->db->select('o.*, product_id, up.meals, up.meals_selected, up.days, up.payed_days, up.free_days, of.order_form_id');
		$this->db->from('order o');
		$this->db->join('order_product op', 'o.order_id = op.order_id', 'left');
		$this->db->join('order_form of', 'o.order_id = of.order_id', 'left');
		$this->db->join('user_packets up', 'o.order_id = up.order_id', 'left');
		
		$this->db->where('o.status', '1');
		$this->db->where('o.order_id', $order_id);
		
		$q = $this->db->get();
		$orders = $q->result();
		
		//elementy
		$products = array();
		foreach($orders as $i => $order) {
			
			$product = $this->db->get_where('product', array('product_id' => $order->product_id), 1);
			$product = $product->row();
			$product->price = $order->price;
			
			array_push($products, $product);
		
		}
		
		$order->products = $products;
		
		$this->benchmark->mark('end');
		$this->firephp->log($this->benchmark->elapsed_time('start', 'end'));
		
		return $order;
	
	}
	
	public function get_user_orders($user_id) {
		
		$this->db->select('o.*, op.product_id');
		$this->db->from('order o');
		$this->db->join('order_product op', 'op.order_id = o.order_id', 'left');
		
		$this->db->where('o.status', '1');
		$this->db->where('o.user_id', $user_id);
		$this->db->order_by('o.date', 'DESC');
		
		$q = $this->db->get();
		$result = $q->result();

		return $result;
	}
	
	public function get_all_orders($where = array(), $no_escape_char = FALSE) {
		
		$this->benchmark->mark('start');
		
		$this->db->select('o.*, up.packet_id, up.meals, up.meals_selected, up.days, of.order_form_id, suo.seller_id');
		$this->db->from('order o');
		$this->db->join('user_packets up', 'o.order_id = up.order_id', 'left');
		$this->db->join('order_form of', 'of.order_id = o.order_id', 'left');
		$this->db->join('seller_user_order suo', 'o.user_id = suo.user_id AND o.date > suo.assigned', 'left');
		
		$this->db->where('o.status', '1');
		if(count($where) > 0) {
			foreach($where as $key => $value) {
				if(!is_string($key)) {
					$this->db->where($value, NULL, (($no_escape_char == true)?false:true));
				} else {
					$this->db->where($key, $value, (($no_escape_char == true)?false:true));	
				}
			}
		}
		
		$this->db->order_by('o.date', 'DESC');
		
		$q = $this->db->get();
		$result = $q->result();
		
		if($result) {
			foreach($result as $i => $order) {
				$d = $this->delivery->get_deliveries(FALSE, $order->order_id);
				$result[$i]->first_delivery = reset($d)->date;
				$result[$i]->last_delivery = end($d)->date;
				$result[$i]->deliveries_count = count($d);
			}
		}
		
		$this->benchmark->mark('end');
		$this->firephp->log($this->benchmark->elapsed_time('start', 'end'));

		return $result;
	}
	
	
	public function get_consultations_with_products($where = array(), $no_escape_char = FALSE) {
		
		//pobieram konsultacje
		$this->db->select('o.*, c.name_surname as first_name_surname, c.skype');
		$this->db->from('order o');
		$this->db->join('user_packets up', 'o.order_id = up.order_id', 'left');
		$this->db->join('consultation c', 'c.email = o.email', 'left');
		
		$this->db->where('o.status', '1');
		$this->db->where('up.packet_id IS NULL');
		
		if(count($where) > 0) {
			foreach($where as $key => $value) {
				if(!is_string($key)) {
					$this->db->where($value, NULL, (($no_escape_char == true)?false:true));
				} else {
					$this->db->where($key, $value, (($no_escape_char == true)?false:true));	
				}
			}
		}
		
		$this->db->order_by('o.date', 'DESC');
		
		$q = $this->db->get();
		$consultations = $q->result();
		
		//pobieram produkty do konsultacji
		$products = array();
		foreach($consultations as $i => $consultation) {
			
				
			$this->db->select('op.*, p.name');
			$this->db->from('order_product op');
			$this->db->join('product p', 'p.product_id = op.product_id', 'left');
			$this->db->where('op.order_id', $consultation->order_id);
			
			$q = $this->db->get();
			
			$consultations[$i]->products = $q->result();
		
		}

		return $consultations;
	}
	

	function create_dotpay_url($order) {
		
		//pierwsze wystapnie spacji rozdziela imie z nazwiskiem
		$name = rtrim(substr($order->name_surname, 0, strpos($order->name_surname, " ")), " ");
		$surname = ltrim(strchr($order->name_surname, " "), " "); 
		
		$text = "https://ssl.dotpay.pl?id=";
		$text .= $this->config->item('dotpay_id');
		$text .= "&kwota=";
		$text .= $order->price;
		$text .= "&waluta=";
		$text .= "PLN";
		$text .= "&opis=";
		$text .= $order->order_number;
		$text .= "&lang=";
		$text .= "pl";
		$text .= "&control=";
		$text .= $order->order_number;
		$text .= "&URL=";
		$text .= base_url() . 'page/order/after_payment/' . $order->order_id;
		$text .= "&typ=";
		$text .= "3";
		$text .= "&email=";
		$text .= urlencode($order->email);
		$text .= "&imie=";
		$text .= $name;
		$text .= "&nazwisko=";
		$text .= $surname;
		$text .= "&txtguzik=";
		$text .= urlencode('Powrót do F4U');

		return $text;

	}
	
	
	
}

<?

class M_Packet extends CI_Model { 


	function __construct() { 
		parent::__construct();
	} 
	
	public function get_catering_products() {
		
		
		$this->db->select('*');
		$this->db->from('product');
		$this->db->where('type', 'delivery');
		$this->db->where('status', '1');
		
		$q = $this->db->get();
		$r = $q->result();

		return $r;
		
	}
	

	public function get_packet($packet_id = FALSE, $packet_name = FALSE, $packet_weeks = FALSE, $packet_days_per_week = FALSE, $packet_meals_per_day = FALSE) {
		
		$this->db->select('*');
		
		if($packet_id) {
			$this->db->where('product_id', $packet_id);	
		}
		if($packet_name) {
			$this->db->where('name', $packet_name);	
		}
		if($packet_weeks) {
			$this->db->where('weeks', $packet_weeks);	
		}
		if($packet_days_per_week) {
			$this->db->where('days_per_week', $packet_days_per_week);	
		}
		if($packet_meals_per_day) {
			$this->db->where('meals_per_day', $packet_meals_per_day);	
		}
		
		$this->db->where('type', 'packet');
		$this->db->where('status', '1');
		
		$q = $this->db->get('product');
		$r = $q->result();

		return $r;
		
	}
	
	public function get_active_user_packet($user_id) {
		
		$this->db->select('p.*, up.buyed, up.start, up.expires, o.payment');
		$this->db->from('user_packets up');
		$this->db->join('product p', 'up.packet_id = p.product_id', 'left');
		$this->db->join('order o', 'o.order_id = up.order_id', 'left');
		
		$this->db->where('up.start <=', date("Y-m-d"));
		$this->db->where('up.expires >=', date("Y-m-d"));
		$this->db->where('up.user_id', $user_id);
		$this->db->where('p.status', '1');
		$this->db->where('up.status', '1');
		$this->db->where('o.status', '1');
		$this->db->limit(1);
		
		$q = $this->db->get();
	
		return $q->row();
		
	}
	
	public function get_packets() {
		
		$this->db->select('*');
		
		$this->db->where('type', 'packet');
		$this->db->where('status', '1');
		
		$q = $this->db->get('product');
		$r = $q->result();

		return $r;
	}
	
	public function get_user_packets($user_id, $packet_id = FALSE) {
		
		$this->db->select('up.*, p.*, o.order_number, o.payment, o.price');
		$this->db->from('user_packets up');
		
		$this->db->join('order o', 'up.order_id = o.order_id', 'left');
		$this->db->join('product p', 'up.packet_id = p.product_id', 'left');
		
		$this->db->where('p.status', '1');
		$this->db->where('o.status', '1');
		$this->db->where('up.status', '1');
		$this->db->where('up.user_id', $user_id);
		if($packet_id) {
			$this->db->where('up.packet_id', $packet_id);	
		}
		
		$this->db->order_by('o.date', 'asc');
		
		$q = $this->db->get();
		$result = $q->result();

		return $result;
		
	}
	
	public function get_product($product_id) {
		
		$this->db->select('*');
		$this->db->where('product_id', $product_id);	
		$this->db->where('status', '1');
		
		$q = $this->db->get('product');
		$r = $q->row();

		return $r;
			
	}
	
	public function get_user_payments() {
		
	}
	
	public function get_delivery() {
		
	}
	
	public function get_deliveries() {
		
		
		
	}
	
	public function get_deliveries_on_days() {
		
	}
	
	public function get_delivery_avalible_days() {
		
	}

	
	
}

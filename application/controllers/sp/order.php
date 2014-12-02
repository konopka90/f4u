<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends Sp {

	public function __construct() {
		
		parent::__construct();

	}
	
	
	public function index() {
		
		//Wszystkie zamówienia
		$this->data['all_orders'] = $this->seller->get_clients_orders($this->user->user_id);

		//Wszystkie produkty
		$this->data['products'] = set_array_keys($this->table->get_rows('product'), 'product_id');
		
		//Wszystkie historie wyplat
		$this->data['payouts'] = $this->seller->get_payouts($this->user->user_id);
		
		$this->data['template'] = $this->load->view('sp/order/order', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
	public function create($user_id = FALSE) {

		//wybor uzytkownika
		if($this->input->post('select_user') == 1) {
			redirect(base_url() . 'sp/order/create/' . $this->input->post('order_user'));	
		}
		
		//Uzytkownicy
		$this->data['users'] = $this->seller->get_clients($this->user->user_id);
		
		//Dane
		if($user_id) {
			$this->data['order_user'] = $this->table->get_row('user', array('user_id' => $user_id));	
			$this->data['user_packets'] = $this->packet->get_user_packets($user_id);
			$this->data['user_seller'] = $this->seller->get_user_seller($user_id);
		}

		//Wszystkie produkty
		$this->data['products'] = set_array_keys($this->table->get_rows('product'), 'product_id');
	
		$this->data['access'] = 'seller';
		$this->data['template'] = $this->load->view('admin/order/create', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
	public function update($order_id = FALSE) {
		
		$this->data['order'] = $this->order->get_order_with_products($order_id);
		
	
		$this->data['access'] = 'seller';
		$this->data['template'] = $this->load->view('admin/order/create', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
	public function read($order_id) {
		
		//Zamowienie i produkty
		$this->data['order'] = $this->order->get_order_with_products($order_id);

		//Gramatura
		$this->data['all_deliveries'] = $this->delivery->get_deliveries(FALSE, $order_id);
		$this->data['all_deliveries_grammage'] = $this->table->get_rows('delivery_grammage', array('order_id' => $order_id));
		$this->data['all_deliveries_grammage'] = set_array_keys($this->data['all_deliveries_grammage'], 'delivery_id');
	
		$this->data['access'] = 'seller';
		$this->data['template'] = $this->load->view('admin/order/read', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	public function remove($order_id) {
		
		redirect(		base_url() . 'admin/order/remove/' . $order_id .'/'. 		base64_encode(base_url() . 'sp/order')		);
		
	}
	

	public function payment($order_id) {
		
		if($this->input->post('save') == 1) {
			
			$order = $this->table->get_row('user_packets', array('order_id' => $order_id));
			
			$data = array(	'payment' => $this->input->post('payment'),
							'payment_date' => $this->input->post('payment_date'),
						   	'payment_channel' => $this->input->post('payment_channel')
						);
			
			$this->db->where('order_id', $order_id);
			$this->db->update('order', $data); 
			
			if($order) {
				redirect(base_url() . 'admin/order/read/' . $order_id);
			} else {
				redirect(base_url() . 'admin/consultation/read/' . $order_id);
			}
		}
		
		$this->data['order'] = $this->order->get_order_with_products($order_id);
	
		echo $this->load->view('admin/order/read_payment', $this->data, true);
		
	}
	
	/**/
	
	public function read_form($order_id) {
		
		$this->data['order'] = $this->order->get_order_with_products($order_id);
		$this->data['food_form'] = $this->table->get_row('order_form', array('order_id' => $order_id));
	
		echo $this->load->view('admin/order/read_form', $this->data, true);
		
	}
	
	public function delivery($order_id) {
		
		$this->data['order'] = $this->order->get_order_with_products($order_id);
		$this->data['all_deliveries'] = $this->delivery->get_deliveries(FALSE, $order_id);
	
		$this->data['access'] = 'seller';
		$this->data['template'] = $this->load->view('admin/order/delivery', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
	public function grammage($order_id) {
		
		$this->data['order'] = $this->order->get_order_with_products($order_id);

		$this->data['all_deliveries'] = $this->delivery->get_deliveries(FALSE, $order_id);
		$this->data['all_deliveries_grammage'] = $this->table->get_rows('delivery_grammage', array('order_id' => $order_id));
		$this->data['all_deliveries_grammage'] = set_array_keys($this->data['all_deliveries_grammage'], 'delivery_id');
		$this->data['food_form'] = $this->table->get_row('order_form', array('order_id' => $order_id));
	
		$this->data['access'] = 'seller';
		$this->data['template'] = $this->load->view('admin/order/grammage', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
}
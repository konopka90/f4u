<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Packets extends Cp {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {

		//wez aktualne pakiety
		$this->data['user_packets'] = $this->packet->get_user_packets($this->user->user_id);
		$this->data['first_avalible_day'] = $this->delivery->get_first_avalible_day_for_order_calendar($this->data['user_packets']);
		
		//wez zamowienia
		$this->data['orders'] = $this->order->get_user_orders($this->user->user_id);
		
		//Wszystkie produkty
		$this->data['products'] = set_array_keys($this->table->get_rows('product'), 'product_id');
		
		$this->data['template'] = $this->load->view('cp/packets/packets', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}


	public function prolong() {
		
		//wez aktualne pakiety
		$this->data['user_packets'] = $this->packet->get_user_packets($this->user->user_id);
		$this->data['first_avalible_day'] = $this->delivery->get_first_avalible_day_for_order_calendar($this->data['user_packets']);
		
		//wez nazwy pakietów
		$this->data['products'] = $this->packet->get_catering_products();
		
		$this->data['template'] = $this->load->view('cp/packets/prolong', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	public function order($order_id) {
		
		$this->data['order'] = $this->order->get_order_with_products($order_id);
		
		$this->data['template'] = $this->load->view('cp/packets/read', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	public function order_pdf($order_id) {


		$this->data['order'] = $this->order->get_order_with_products($order_id);
	
		if($this->data['order']) {
			
			$this->load->helper('dompdf');
		
			$html = $this->load->view('cp/packets/_elements/invoice', $this->data, true);
			pdf_create($html, 'faktura_', TRUE, 0);
			
		} else {
			show_404();
		}	
		
	}

}

/* End of file */
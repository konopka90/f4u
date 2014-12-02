<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Training extends Cp {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {


		$this->data['template'] = $this->load->view('cp/training/training', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	public function get_training_pdf($training_pdf) {


		$this->data['order'] = $this->order->get_order_full($order_id);
	
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
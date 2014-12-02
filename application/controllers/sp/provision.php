<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Provision extends Sp {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		
		//Wyplata
		if($this->input->post('payout') == 1) {
			
			$payout_provision = $this->input->post('payout_provision');
					
			if(!$payout_provision) {
				$this->session->set_flashdata('message', 'Nie wybrałeś kwoty!'); 
				redirect(base_url() . 'sp/order');	
			}
			
			if($payout_provision > $this->seller->get_saldo($this->user->user_id)) {
				$this->session->set_flashdata('message', 'Kwota którą chcesz wypłacić jest zbyt duża!'); 
				redirect(base_url() . 'sp/order');	
			}
			
			$data = array(
				'seller_id' => $this->user->user_id,
				'payout_account_number' => $this->input->post('payout_account_number'),
				//'provision_saldo_before' => $this->seller->get_provision($this->user->user_id),
				'provision_payout' => $payout_provision,
				'date' => date("Y-m-d H:i:s"),
				'realisation' => 1
			);
			$this->db->insert('f4u_seller_payout', $data);
				
			$this->session->set_flashdata('message', 'Administrator został powiadomiony o chęci wypłaty, odezwiemy się niebawem!'); 
			redirect(base_url() . 'sp/provision');	
				
		}

		//Wszystkie historie wyplat
		$this->data['payouts'] = $this->seller->get_payouts($this->user->user_id);
		
		$this->data['template'] = $this->load->view('sp/provision/provision', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	

}

/* End of file */
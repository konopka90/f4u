<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consultation extends Admin {

	public function __construct() {
		parent::__construct();
		
		//sprawdza poziom
		if($this->user->access < 5) {
			redirect(base_url().  "admin");	
		}
		
		
	}
	
	public function index() {
		
		$this->data['all_consultations'] = $this->order->get_consultations_with_products();
	
		$this->data['template'] = $this->load->view('admin/consultation/consultation', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
	public function read($consultation_id) {
		
		$this->data['consultation'] = reset($this->order->get_consultations_with_products(array('o.order_id' => $consultation_id)));
		
		if($this->input->post('send_email') == 1) {

			$name = explode(' ', $this->data['consultation']->name_surname);
			$title = 'FitLab - kontakt w sprawie konsultacji!';
			$text = '<h2 style="margin-top: 0">Kontaktujemy się z Tobą w sprawie konsultacji, które zamówiłeś</h2>';
			$message = $this->input->post('text') . "<p style='background: #f2f2f2;padding: 10px'>Napisał <strong>".$this->user->name_surname."</strong>, jego email to <strong>" . $this->user->email . "</strong>.</p><p>Pozdrawiamy!<br />FitLab<br/>tel. 506 608 680</p>";
			
			$this->common->send_mail(	$this->input->post('email'), 
										$title, 
										$text,
										$message,
										$this->user->email,
										$this->user->name_surname
									);
			//kopia do mnie
			if($this->input->post('copy') == 1) {
				$this->common->send_mail(	$this->user->email, 
											$title, 
											$text,
											$message,
											$this->user->email,
											$this->user->name_surname
										);
			}
									
			$this->session->set_flashdata('message', 'Zrobione! Email kontaktowy został wysłany, niedługo się z Tobą skontaktujemy.'); 
			
			redirect(current_url());
		}
		
		
	
		$this->data['template'] = $this->load->view('admin/consultation/read', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
}
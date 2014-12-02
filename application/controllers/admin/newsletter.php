<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter extends Admin {

	public function __construct() {
		parent::__construct();
		
		//sprawdza poziom
		if($this->user->access < 5) {
			redirect(base_url().  "admin");	
		}
		
		
	}
	
	public function index() {
		
		if($this->input->post('send_to_me') == 1) {
			
			$title = 'F4U Newsletter - ' . $this->input->post('title');
			$text = '<h2 style="margin-top: 0">'.$this->input->post('title').'</h2>';
			$message = $this->input->post('text') . "<p>Pozdrawiamy!<br />Fit4You<br/>tel. 515 046 567</p>";
			
			$this->common->send_mail(	$this->user->email, 
										$title, 
										$text,
										$message,
										$this->user->email,
										$this->user->name_surname
									);

			$data = array(	'date' => date("Y-m-d H:i:s"),
							'title' => $this->input->post('title'),
							'text' => $this->input->post('text'),
							'sended_to' => serialize(array($this->user->email => $this->user->email)),
						);
			$this->db->insert('newsletter', $data); 
						
			$this->session->set_flashdata('message', 'Zrobione! Newsletter został wysłany tylko do Ciebie ('.$this->user->email.')!'); 
			redirect(current_url());
			
		}
		
		if($this->input->post('send') == 1) {

			//printr($this->input->post());
			
			$title = 'F4U Newsletter - ' . $this->input->post('title');
			$text = '<h2 style="margin-top: 0">'.$this->input->post('title').'</h2>';
			$message = $this->input->post('text') . "<p>Pozdrawiamy!<br />Fit4You<br/>tel. 515 046 567</p>";
			
			//email
			$emails = array();
			if(is_array($this->input->post('email')) && count($this->input->post('email')) > 0) {
				
				foreach($this->input->post('email') as $email => $one) {
					$emails[base64_decode($email)] = base64_decode($email);	
				}
			
				foreach($emails as $email) {
					
					$this->common->send_mail(	$email, 
												$title, 
												$text,
												$message,
												$this->data['config']->contact_email, 
												$this->data['config']->name
											);
					/**/
				}
				$this->firephp->log($emails);
			}

			
			

			//zapis do bazy
			$data = array(	'date' => date("Y-m-d H:i:s"),
							'title' => $this->input->post('title'),
							'text' => $this->input->post('text'),
							'sended_to' => serialize($emails),
						);
			$this->db->insert('newsletter', $data); 
			
									
			$this->session->set_flashdata('message', 'Zrobione! Newsletter został wysłany!'); 
			redirect(current_url());
		
		}
		
		
		$this->data['newsletters'] = $this->table->get_rows('newsletter', array(), true, array('date', 'desc'));
		$this->data['emails'] = $this->table->get_rows('newsletter_emails', array('removed IS NULL'), true);
		$this->data['emails_users'] = $this->table->get_rows('user', array(), true);
	
		$this->data['template'] = $this->load->view('admin/newsletter/newsletter', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	public function read($newsletter_id) {
		
		$this->data['newsletter'] = $this->table->get_row('newsletter', array('newsletter_id' => $newsletter_id), true);
		
		echo $this->load->view('admin/newsletter/read', $this->data, true);
		
	}
	
	public function remove($newsletter_id) {
		
		$this->db->where('newsletter_id', $newsletter_id);
		$this->db->update('newsletter', array('status' => '0')); 
		
		$this->session->set_flashdata('message', 'Usunięto'); 
		redirect(base_url() . 'admin/newsletter');
		
	}
	
	
	public function email() {
		
		if($this->input->post('add') == 1) {
			
			$data = array(	'name_surname' => $this->input->post('name_surname'),
							'email' => $this->input->post('email'),
							'added' => date("Y-m-d H:i:s")
						);
			$this->db->insert('newsletter_emails', $data); 
			
			$this->session->set_flashdata('message', 'Adres email został dodany do newslettera!'); 
			redirect(current_url());
		
		}
		
		$this->data['emails'] = $this->table->get_rows('newsletter_emails', array(), false, array('added', 'desc'));
		
		$this->data['template'] = $this->load->view('admin/newsletter/email', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
		
	public function email_remove($newsletter_emails_id) {
		
		$this->db->where('newsletter_emails_id', $newsletter_emails_id);
		$this->db->update('newsletter_emails', array('status' => '0')); 
		
		$this->session->set_flashdata('message', 'Usunięto'); 
		redirect(base_url() . 'admin/newsletter/email');
		
	}
	
}
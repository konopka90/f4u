<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Root {

	
	
	public function login($redirect = FALSE) {
		
		
		if($this->input->post()) {
			
			if($this->input->post('email') && $this->input->post('password')) {

				$this->db->select('*');
				$this->db->from('user');
				$this->db->where('email', $this->input->post('email'));
				$this->db->where('password', sha1($this->input->post('password')));
				
				$query = $this->db->get();
				
				if($query->num_rows() > 0) {
					
					//SESJA
					$this->session->unset_userdata('user');
					$u = $query->row();
					$this->session->set_userdata(array('user' => $u));
					
					//$this->firephp->log('SESSION SETTED');
					//$this->firephp->log($this->session->userdata);
					
					if($this->input->post('ajax') == true) {
						
						echo json_encode('OK');	
						
					} else {
						
						if($u->password_to_change) {
							redirect(base_url() . 'user/first_login');		
						}
						
						switch($redirect) {
							case 'page' :
								redirect(base_url() . 'page');	
								break;
							case 'cp' :
								redirect(base_url() . 'cp');	
								break;
							case 'admin' :
								redirect(base_url() . 'admin');	
								break;
							default:
								if($redirect) {
									redirect(base64_decode($redirect));	
								} else {
									redirect(base_url());
								}
						}
		
					}

				} else {
					
					$this->firephp->log('SESSION NOT SETTED ' . ' Takiego użytkownika nie ma w naszej bazie');
					
					if($this->input->post('ajax') == true) {
						
						echo json_encode('ERROR');	
						
					} else {
						redirect(base_url() . 'user/login/' . $this->input->post('redirect'));	
					}
				
				}

			} else {
				
				$this->firephp->log('SESSION NOT SETTED ' . ' Brak email lub password.');
				
				if($this->input->post('ajax') == true) {
					
					echo json_encode('ERROR');	
					//redirect(base_url() . 'user/login/' . base64_decode($this->input->post('redirect')));	
					
				} else {
					redirect(base_url() . 'user/login/' . base64_decode($this->input->post('redirect')));	
				}
			}
			
			return;
			
		}


		$this->data['template'] = $this->load->view('user/login', array('redirect' => $redirect), true);
		
		$this->data['no_slider'] = true;
		$this->load->view('index', $this->data);

	}
	
	
	public function email_exists($email, $except = FALSE) {
		
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('email', base64_decode($email));
		if($except) {
			$this->db->where('email !=', base64_decode($except));
		}
		$this->db->limit(1);
		
		$q = $this->db->get();	

		if($this->input->post('ajax') == "true") {
			if($q->num_rows() > 0) {
				echo json_encode('EXIST');	
			} else {
				echo json_encode('NOT_FOUND');		
			}
		} else {
			return $q->row();	
		}
		
		
	}
	
	public function first_login() {
		
		//sprawdza zalogowanie
		if($this->user->access < 1) {
			redirect(base_url().  "user/login/".base64_encode(base_url() . 'user/first_login'));	
		}
		
		if($this->input->post()) {
		
			if($this->input->post('new_password') == $this->input->post('new_password_repeated')) {
			
				$this->db->where('user_id', $this->user->user_id);
				$this->db->update('user', array('password_to_change' => '0', 'password' => sha1($this->input->post('new_password')))); 
			
				$this->session->set_flashdata('message', 'Hasło zostało zmienione! Teraz Twoje konto jest w pełni aktywne!'); 	
				redirect(base_url() . 'cp');	
			
			} else {
				$this->session->set_flashdata('message', 'Podane hasła nie są identyczne!'); 	
				redirect(base_url() . 'user/first_login');	
			}
			
		}
	
		$this->data['no_slider'] = true;
		$this->data['template'] = $this->load->view('user/first_login', $this->data, true);
		$this->load->view('index', $this->data);
		
	}
	
	
	public function update() {
		
		//sprawdza zalogowanie
		if($this->user->access < 1) {
			redirect(base_url().  "user/login/".base64_encode(base_url() . 'user/update'));	
		}
		
		if($this->input->post('save') == 1) {
			
			$data = array();
			
			//zmiana hasła
			if($this->input->post('password') && $this->input->post('new_password') && $this->input->post('new_password_repeated')) {
				
				if($this->input->post('new_password') == $this->input->post('new_password_repeated')) {
					$data['password'] = sha1($this->input->post('new_password'));
				} else {
					$this->session->set_flashdata('message', 'Podane hasła nie są identyczne!'); 	
					redirect(base_url() . 'user/update');	
				}
					
			}
			
			//czy email unikatowy
			if(!$this->usera->email_exist($this->input->post('email'), $this->user->email)) {
				$data['email'] = $this->input->post('email');	
			} else {
				$this->session->set_flashdata('message', 'Taki email już istnieje w naszej bazie!'); 	
				redirect(base_url() . 'user/update');	
			}
			
			$data['name_surname'] = $this->input->post('name_surname');	
			$data['address'] = $this->input->post('address');	
			$data['postcode'] = $this->input->post('postcode');	
			$data['city'] = $this->input->post('city');	
			$data['phone'] = $this->input->post('phone');	
			$data['skype'] = $this->input->post('skype');	
			$data['account_number'] = $this->input->post('account_number');	
			
			$this->db->where('user_id', $this->user->user_id);
			$this->db->limit(1);
			$this->db->update('user', $data);
			
			//aktualizacja sesji
			$user = $this->table->get_row('user', array('user_id' => $this->user->user_id));
			$this->session->unset_userdata('user');
			$this->session->set_userdata(array('user' => $user));
					
			$this->session->set_flashdata('message', 'Twój profil został zaaktualizowany!'); 	
			redirect(base_url() . 'user/update');	
			
		}
	
		$this->data['template'] = $this->load->view('user/update', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	public function password_remind($code = FALSE) {
		
		//sprawdza zalogowanie
		if($this->user->access > 0) {
			redirect(base_url().  'cp');	
		}
		
		if($this->input->post('send_code') == 1 && $this->input->post('email')) {
			
			$code = uniqid();
			
			$this->db->where('email', $this->input->post('email'));
			$this->db->limit(1);
			$this->db->update('user', array('password_reset_code' => $code), FALSE);
			
			$title = 'F4U - resetowanie hasła';
			$text = '<h2 style="margin-top: 0">Resetowanie hasła</h2>';
			$message = '<p>Otrzymałeś tego emaila ponieważ rozpocząłeś proces resetowania hasła. Kliknij w poniższy kod, aby zresetować hasło (otrzymasz je w drugim emailu) lub przepisz go na stronie <a href="'.base_url().'user/password_remind">resetowania hasła</a>.</p><p><a href="'.base_url().'user/password_remind/'.$code.'">'.$code.'</a></p><p>Jeżeli to nie Ty prosiłeś o zmianę hasła po prostu zignoruj tego emaila.</p><p>Pozdrawiamy!<br />Fit4You<br/>tel. 515 046 567</p>';
			
			$this->common->send_mail(	$this->input->post('email'), 
										$title, 
										$text,
										$message,
										$this->data['config']->contact_email, 
										$this->data['config']->name
									);
									
			$this->session->set_flashdata('message', 'Email z kodem resetującym został wysłany! Sprawdź pocztę.'); 	
			redirect(base_url() . 'user/password_remind');	
			
		}
		
		if($code || ($this->input->post('reset_password') == 1 && $this->input->post('code'))) {
			
			if($this->input->post('code')) {
				$code = $this->input->post('code');	
			} else {
				$code = $code;	
			}
			
			$user = $this->table->get_row('user', array('password_reset_code' => $code));
			
			if(!empty($user)) {
				
				$new_password = uniqid();
				$this->db->where('user_id', $user->user_id);
				$this->db->limit(1);
				$this->db->set('password_reset_code', 'NULL', FALSE);
				$this->db->update('user', array('password' => sha1($new_password), 'password_to_change' => '1'));
				
				$title = 'F4U - hasło zostało zresetowane hasła';
				$text = '<h2 style="margin-top: 0">Tak jak prosiłeś - zresetowaliśmy Twoje hasło w naszym serwisie</h2>';
				$message = '<p>Twoje nowe hasło:<br />'.$new_password.'</p><p><a href="'.base_url().'user/login">Zaloguj się</a> korzystając ze swojego nowego hasła!</p><p>Pozdrawiamy!<br />Fit4You<br/>tel. 515 046 567</p>';
				
				$this->common->send_mail(	$user->email, 
											$title, 
											$text,
											$message,
											$this->data['config']->contact_email, 
											$this->data['config']->name
										);
				
				$this->session->set_flashdata('message', 'Nowe hasło zostało wysłane na adres email. <a href="'.base_url().'user/login">Zaloguj się</a>.'); 	
				redirect(base_url() . 'user/password_remind');	
				
			} else {
				$this->session->set_flashdata('message', 'Podany kod jest nieprawidłowy. Hasło nie zostało zmienione.'); 	
				redirect(base_url() . 'user/password_remind');	
			}
			
		}
		
		$this->data['no_slider'] = true;
		$this->data['template'] = $this->load->view('user/password_remind', $this->data, true);
		$this->load->view('index', $this->data);
		
	}
	
	public function logout() {
		
		$this->session->set_userdata(array('user' => 'logouted'));	
		redirect(base_url().'page');
		
	}

}

/* End of file */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends Root {

	public function __construct() {
		parent::__construct();
	}
	
	public function get_prices() {
		echo json_encode(offer_values());	
	}
	
	public function make_order($consultation = FALSE) {
	
		//jakas weryfikacja danych
		if($this->input->post() && $this->input->post('order_form_hash') == $this->session->userdata('order_form_hash')) {
			
			if($consultation == 'consultation') {
				
				//wybrane pozycje dla konsultacji
				$consultation_products = $this->session->userdata('consultation_products');
				
				$order_price = 0.00;
				foreach($consultation_products as $cp) {
					$order_price += $cp->price;	
				}
				
			} else { 
				
				//wybrany produkt
				$packet = $this->session->userdata('order_product');
				//dni w kalendarzu z wysylka
				$delivery = $this->session->userdata('order_delivery');
				//posilki w ciagu dnia, pory
				//$delivery_meal = $this->input->post('delivery_meal');
				
				$order_price = $packet->price;

			}
			
			//printr($this->session->userdata('order_packet'));
			//printr($this->session->userdata('order_delivery'));
			//printr($this->input->post());
			
			//tworze konto jesli niezalogowany
			if(!$this->user->user_id) {
				$new_user_password = uniqid();
				$new_user = array(
					'email' => $this->input->post('email'),
					'password' => sha1($new_user_password),
					'name_surname' => $this->input->post('name_surname'),
					'name' => $this->input->post('name'),
					'nip' => $this->input->post('nip'),
					'address' => $this->input->post('address'),
					'postcode' => $this->input->post('postcode'),
					'city' => $this->input->post('city'),
					'phone' => $this->input->post('phone'),
					'joined' => date("Y-m-d H:i:s"),
				);
				$this->db->insert('user', $new_user); 
				$user_id = $this->db->insert_id();	
				
			
				//powiadomienie email
				$name = explode(' ', $new_user['name_surname']);
				$title = 'F4U - ' . reset($name) . ', Twoje konto jest aktywne!';
				$text = '<h2 style="margin-top: 0">Cześć ' . reset($name) . '! Specjalnie dla Ciebie założyliśmy konto w Panelu Klienta!</h2>';
				$message = "<p>Zaloguj się korzystając z poniższych danych:</p><p>Adres: <a href='".base_url()."cp/login'>".base_url()."cp/login</a><br />Login: ".$new_user['email']." <br />Hasło: ".$new_user_password."</p><p>Możesz tam m.in. sprawdzać i modyfikować swoje pakiety, zarządzać płatnościami i fakturowaniem. Mamy tez kilka niespodzianek, ale musisz je sprawdzić sam!</p><p>Pozdrawiamy!<br />FitLab<br/>tel. 506 608 680</p>";
				
				$this->common->send_mail(	$new_user['email'], 
											$title, 
											$text,
											$message,
											$this->data['config']->contact_email, 
											$this->data['config']->name
										);
				
			} else {
				$user_id = $this->user->user_id;
			}
			
			//zapisuje zamowienie
			$order = array(
			
				'order_number' => uniqid(),
				'user_id' => $user_id,
			
				'name_surname' => $this->input->post('name_surname') ,
				'address' => $this->input->post('address'),
				'postcode' => $this->input->post('postcode'),
				'city' => $this->input->post('city'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				
				'delivery_name_surname' => $this->input->post('delivery_name_surname') ,
				'delivery_address' => $this->input->post('delivery_address'),
				'delivery_postcode' => $this->input->post('delivery_postcode'),
				'delivery_city' => $this->input->post('delivery_city'),
				'delivery_phone' => $this->input->post('delivery_phone'),
				
				//'delivery_meal' => serialize($this->input->post('delivery_meal')),
				
				'date' => date("Y-m-d H:i:s"),
				'price' => $order_price,
				
				'how_about_f4u' => $this->input->post('how_about_f4u')
				
				
			);
			$this->db->insert('order', $order); 
			$order_id = $this->db->insert_id();
			
			if($consultation == 'consultation') {

				foreach($consultation_products as $cp) {
					$order_product = array(
						'order_id' => $order_id,
						'user_id' => $user_id,
						'product_id' => $cp->product_id,
						'buyed' => date("Y-m-d H:i:s")
					);
					$this->db->insert('order_product', $order_product); 
				}
				
				
			} else {
			
				//zapisuje dni dostawy
				$first_delivery = array();
				//gramature jak jest cos to też zapisuje
				$old_last_delivery_grammage = $this->delivery->last_order_last_delivery_last_grammage($user_id, $order_id);
				foreach($delivery as $year => $months) {
					foreach($months as $month => $days) {
						foreach($days as $day => $class) {
							
							$first_delivery[] = $year . '-' . $month . '-' . $day;
							$d = explode('_', $packet->meals_per_day);
							//for($i = 1; $i <= end($d); $i++) {
							
								$last_delivery = array(
									'order_id' => $order_id,
									'user_id' => $user_id,
									'packet_id' => $packet->product_id,
									'date' => $year . '-' . $month . '-' . $day,
									'hours' => $this->input->post('delivery_hours'),
									'user_notice' => $this->input->post('delivery_user_notice'),
									'meals' => end($d),
									'stopped' => "0",
									'name_surname' => $this->input->post('delivery_name_surname'),
									'address' => $this->input->post('delivery_address'),
									'postcode' => $this->input->post('delivery_postcode'),
									'city' => $this->input->post('delivery_city'),
									'phone' => $this->input->post('delivery_phone')	
								);
								$this->db->insert('delivery', $last_delivery); 
								$last_delivery_id = $this->db->insert_id();
								
								//dodawanie gramatury na podstawie ostatniego zamowienia
								if(!empty($old_last_delivery_grammage)) {
									unset($old_last_delivery_grammage->delivery_grammage_id);
									unset($old_last_delivery_grammage->status);
									$old_last_delivery_grammage->order_id = $order_id;
									$old_last_delivery_grammage->delivery_id = $last_delivery_id;
									
									for($i = 1; $i <= 5; $i++) {	
										$w = 'meal_' . $i . '_w';
										$b = 'meal_' . $i . '_b';
										if(!in_array($i, $packet->meals_selected_unserialized)) {
											//czyli jesli posiłek nie wybrany
											unset($old_last_delivery_grammage->$w);
											unset($old_last_delivery_grammage->$b);
										}
									}
									
									$this->db->insert('delivery_grammage', $old_last_delivery_grammage); 
									log_message('debug', 'created delivery_grammage_id ' . $this->db->insert_id());	
								}
								
							//}
						}
					}
				}
					
				if(!empty($old_last_delivery_grammage)) {
					//aktualizacja wypelnienia gramatury
					$this->delivery->recalculate_grammage_filled($order_id);	
					log_message('debug', 'grammage percentage recalculated');
				}
				
				//przypisuje produkt do zamowienia
				$order_product = array(
					'order_id' => $order_id,
					'user_id' => $user_id,
					'product_id' => $packet->product_id,
					'buyed' => date("Y-m-d H:i:s")
				);
				$this->db->insert('order_product', $order_product); 
				
				//przypisuje usera do pakietu
				$user_packets = array(
					'order_id' => $order_id,
					'user_id' => $user_id,
					'packet_id' => $packet->product_id,
					'buyed' => date("Y-m-d H:i:s"),
					'start' => $first_delivery[0],
					'expires' => $last_delivery['date'],
					'days' => ($packet->days + get_free_days($packet->days)),
					'payed_days' => $packet->days,
					'free_days' => get_free_days($packet->days),
					'meals' => end(explode('_', $packet->meals_per_day)),
					'meals_selected' => $packet->meals_selected
				);
				$this->db->insert('user_packets', $user_packets); 

				//zapisuje wyslany kwestionariusz
				$order_form = array(
				
					'order_id' => $order_id,
					'user_id' => $user_id,
					
					'form_born' => $this->input->post('form_born'),
					'form_height' => $this->input->post('form_height'),
					'form_weight' => $this->input->post('form_weight'),
					
					'form_alergy' => $this->input->post('form_alergy'),
					'form_illness' => $this->input->post('form_illness'),
					'form_therapy' => $this->input->post('form_therapy'),
					'form_over' => $this->input->post('form_over'),
					'form_diets_effects' => $this->input->post('form_diets_effects'),
					'form_operation' => $this->input->post('form_operation'),
					'form_notices_1' => $this->input->post('form_notices_1'),
					
					'form_meals_per_day' => $this->input->post('form_meals_per_day'),
					'form_meals_time' => $this->input->post('form_meals_time'),
					'form_meals_additional' => $this->input->post('form_meals_additional'),
					'form_water_count' => $this->input->post('form_water_count'),
					'form_suplements' => $this->input->post('form_suplements'),
					
					'form_coffee' => $this->input->post('form_coffee'),
					'form_tea' => $this->input->post('form_tea'),
					'form_sugar' => $this->input->post('form_sugar'),
					'form_saltz' => $this->input->post('form_saltz'),
					'form_drinks' => $this->input->post('form_drinks'),
					'form_fastfood' => $this->input->post('form_fastfood'),
					'form_alcohol' => $this->input->post('form_alcohol'),
					'form_cigarettes' => $this->input->post('form_cigarettes'),
					
					'form_breakfast' => $this->input->post('form_breakfast'),
					'form_breakfast_2' => $this->input->post('form_breakfast_2'),
					'form_dinner' => $this->input->post('form_dinner'),
					'form_dinner_2' => $this->input->post('form_dinner_2'),
					'form_supper' => $this->input->post('form_supper'),
					'form_snacks' => $this->input->post('form_snacks'),
					
					'form_cereal' => $this->input->post('form_cereal'),
					'form_meat' => $this->input->post('form_meat'),
					'form_fish' => $this->input->post('form_fish'),
					'form_vegetables' => $this->input->post('form_vegetables'),
					'form_fruits' => $this->input->post('form_fruits'),
					'form_milk' => $this->input->post('form_milk'),
					'form_other' => $this->input->post('form_other'),
					
					'form_work' => $this->input->post('form_work'),
					'form_activity' => $this->input->post('form_activity'),
					
					'form_harmonogram_5' => $this->input->post('form_harmonogram_5'),
					'form_harmonogram_6' => $this->input->post('form_harmonogram_6'),
					'form_harmonogram_7' => $this->input->post('form_harmonogram_7'),
					'form_harmonogram_8' => $this->input->post('form_harmonogram_8'),
					'form_harmonogram_9' => $this->input->post('form_harmonogram_9'),
					'form_harmonogram_10' => $this->input->post('form_harmonogram_10'),
					'form_harmonogram_11' => $this->input->post('form_harmonogram_11'),
					'form_harmonogram_12' => $this->input->post('form_harmonogram_12'),
					'form_harmonogram_13' => $this->input->post('form_harmonogram_13'),
					'form_harmonogram_14' => $this->input->post('form_harmonogram_14'),
					'form_harmonogram_15' => $this->input->post('form_harmonogram_15'),
					'form_harmonogram_16' => $this->input->post('form_harmonogram_16'),
					'form_harmonogram_17' => $this->input->post('form_harmonogram_17'),
					'form_harmonogram_18' => $this->input->post('form_harmonogram_18'),
					'form_harmonogram_19' => $this->input->post('form_harmonogram_19'),
					'form_harmonogram_20' => $this->input->post('form_harmonogram_20'),
					'form_harmonogram_21' => $this->input->post('form_harmonogram_21'),
					'form_harmonogram_22' => $this->input->post('form_harmonogram_22'),
					'form_harmonogram_23' => $this->input->post('form_harmonogram_23'),
					
					'form_fat' => $this->input->post('form_fat'),
					'form_morphism' => $this->input->post('form_morphism'),
					'form_target' => $this->input->post('form_target'),
					'form_notices_2' => $this->input->post('form_notices_2'),
	
				);
				$this->db->insert('order_form', $order_form); 
				
				
				//jesli zaznaczyl newsletter to dodaje do newslettera
				if($this->input->post('newsletter')) {
						
					$newsletter = array(
						'name_surname' => $this->input->post('name_surname'),
						'email' => $this->input->post('email'),
						'added' => date("Y-m-d H:i:s"),
					);
					$this->db->insert('newsletter_emails', $newsletter); 
						
				}
				
			}
			
			
			//powiadomienie ze zlozyl zamowienie
			$name = explode(' ', $this->input->post('name_surname'));
			$title = 'F4U - ' . reset($name) . ', złożyłeś zamówienie';
			$text = '<h2 style="margin-top: 0">Zamówienie zostało złożone!</h2>';
			if($consultation == 'consultation') {
				$message = "<p>Twoje zamówienie na kwotę ".$order_price." zostało pomyślnie złożone! Zaloguj się do <a href='".base_url()."cp'>Panelu Klienta</a>, aby uzyskać więcej informacji.</p><p>Pozdrawiamy!<br />FitLab<br/>tel. 506 608 680</p>";
			} else {
				$message = "<p>Twoje zamówienie na kwotę ".$order_price." zł (słownie: ".say_number($order_price).") zostało pomyślnie złożone!</p><p>Zamówiłeś pakiet ".$user_packets['payed_days'].(($user_packets['free_days'])?' + '.$user_packets['free_days'].' GRATIS ':'')." dostaw po ".$user_packets['meals']." posiłków dziennie. Pierwsza dostawa będzie miała miejsce ".date("Y-m-d", strtotime($first_delivery[0])).", a ostatnia ".date("Y-m-d", strtotime(end($first_delivery))).".</p>Zaloguj się do <a href='".base_url()."cp'>Panelu Klienta</a>, aby uzyskać więcej informacji. Możesz tam pobrać fakturę za zamówienie, opłacić je - jeśli jeszcze tego nie zrobiłeś i zarządzać swoimi dostawami.</p><p>Pozdrawiamy!<br />Fit4You<br/>tel. 515 046 567</p>";	
			}
			
			$this->common->send_mail(	$this->input->post('email'), 
										$title, 
										$text,
										$message,
										$this->data['config']->contact_email, 
										$this->data['config']->name
									);
			/**/
									
			//powiadomienie administratora ze zlozono zamowienie
			$name = explode(' ', $this->input->post('name_surname'));
			$title = 'F4U - ' . reset($name) . ' złożył zamówienie';
			$text = '<h2 style="margin-top: 0">' . reset($name) . ' złożył zamówienie</h2>';
			$message = "<p>Przejdź do <a href='".base_url()."admin'>Panelu Administratora</a> i sprawdź szczegóły.</p><p>Pozdrawiamy!<br />FitLab<br/>tel. 506 608 680</p>";
			
			$this->common->send_mail(	$this->data['config']->contact_email, 
										$title, 
										$text,
										$message,
										$this->data['config']->contact_email, 
										$this->data['config']->name
									);
										
													
			//chyba tyle, przekierowanie do platnosci
			$this->session->unset_userdata('order_product');
			$this->session->unset_userdata('order_delivery');
			$this->session->unset_userdata('consultation');
			
			//antyflood
			$this->session->set_userdata('order_form_hash', uniqid());

			$current_order = $this->order->get_order($order_id);
			redirect($this->order->create_dotpay_url($current_order));
			
		} else {
		
			//kliknal wyslanie formularza, ale kontrola antyodswiezeniowa sie wlaczyla
			redirect(base_url() . 'cp/packets');
			
		}
		
	}
	
	
	public function dotpay() {


		if($this->input->post()) {

			//loguje do pliku WSZYSTKO
			$foo = fopen($this->config->item('dotpay_log'), "a");
			flock($foo, 2);
			$data = "-----------------" . date("Y-m-d H:i:s") . "------------------\r\n";
			if($_POST) {
				foreach ($_POST as $key => $value) {
					$data .= $key . "	=>	" . $value . "\r\n";
				}
			}
			
			fwrite($foo, $data);
			fwrite($foo, 'dotpay_md5 => ' . $dotpay_md5 . "\r\n\r\n\r\n\r\n");
			flock($foo, 3);
			fclose($foo);
			
			//loguje do bazy WSZYSTKO
			$data = array(
				'status' => $this->input->post('status'),
				'control' => $this->input->post('control'),
				'amount' => $this->input->post('amount'),
				'id' => $this->input->post('id'),
				'transaction_id' => $this->input->post('transaction_id'),
				't_id' => $this->input->post('t_id'),
				't_date' => $this->input->post('t_date'),
				'o_id' => $this->input->post('o_id'),
				'email' => $this->input->post('email'),
				't_status' => $this->input->post('t_status'),
				'description' => $this->input->post('description'),
				'version' => $this->input->post('version'),
				'orginal_amount' => $this->input->post('orginal_amount'),
				'channel' => $this->input->post('channel'),
				'md5' => $this->input->post('md5'),
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password'),
				'p_info' => $this->input->post('p_info'),
				'p_email' => $this->input->post('p_email'),

			);
			$this->db->insert('order_payments', $data); 
			
			//tylko dotpay może dalej wchodzic
			if($_SERVER['REMOTE_ADDR'] != $this->config->item('dotpay_ip')) {
				exit('ONLY FOR DOTPAY SERVICE!');
			}
			
			//poprawnosc danych
			$dotpay_md5 = md5($this->config->item('dotpay_pin').':'.$this->config->item('dotpay_id').':'.$this->input->post('control').':'.$this->input->post('t_id').':'.$this->input->post('amount').':'.$this->input->post('email').':::::'.$this->input->post('t_status'));
			
			
			if($this->input->post('md5') == $dotpay_md5) {

				//jesli poprawna to zmieniam statusy platnosci
				$data = array(	'payment' => ($this->input->post('t_status')?$this->input->post('t_status'):0),
								'payment_date' =>  ($this->input->post('t_date')?$this->input->post('t_date'):date("Y-m-d H:i:s")),
								'payment_channel' =>  ($this->input->post('channel')?$this->input->post('channel'):0),
								);
				
				//$this->db->where('order_id', $this->input->post('description'));
				$this->db->where('order_number', $this->input->post('control'));
				$this->db->limit(1);
				$this->db->update('order', $data);
			
			
				//platnosc WYKONANA/ZAKSIEGOWANA!
				if($this->input->post('t_status') == 2) {
				
					//fajnie by bylo powiadomic uzytkownika emailem
					$this->common->send_mail(	$this->input->post('email'), 
												'Zaksięgowano płatność za zamówienie numer #' . $this->input->post('description'), 
												'Zaksięgowano płatność za zamówienie numer #' . $this->input->post('description'), 
												'<p>Twoja płatność za zamówienie numer <strong>#' . $this->input->post('description') . '</strong> na kwotę <strong>' . $this->input->post('amount') . ' zł</strong> została zaksięgowana!</p><p>Zaloguj się do swojego <a href="'.base_url().'cp">panelu użytkownika</a> i bądź na bieżąco!</p><p>Pozdrawiamy!<br />Fit4You<br/>tel. 515 046 567</p>',
												$this->data['config']->contact_email, 
												$this->data['config']->name,
												true
											);
				
				}
				
				echo 'OK';
			
			} else {
				echo 'ERROR';	
			}

		}
	
	}
	
	
	
	
	public function after_payment($order_id) {
		
		$this->data['order'] = $this->order->get_order_with_products($order_id);
		$this->data['dotpay_url'] = $this->order->create_dotpay_url($this->data['order']);
		
		$this->data['template'] = $this->load->view('order/payed', $this->data, true);
		$this->load->view('index', $this->data);
		
	}

}

/* End of file */
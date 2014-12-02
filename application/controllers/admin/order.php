<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends Admin {

	public function __construct() {
		parent::__construct();
		
		//sprawdza poziom
		if($this->user->access < 5) {
			redirect(base_url().  "admin");	
		}
		
		
	}
	
	public function index() {
		
		//FILTRY
		if(!$this->session->userdata('orders_start') || !$this->session->userdata('orders_end')) {
			
			$this->session->set_userdata(array('orders_start' => date("Y-m-d",  strtotime("-30days"))));
			$this->session->set_userdata(array('orders_end' => FALSE));

		}
		
		if($this->input->post('save') == 1 || $this->input->post('reset') == 1) {
			
			if($this->input->post('reset') == 1) {
				$this->session->set_userdata(array('orders_start' => date("Y-m-d",  strtotime("-30days"))));
				$this->session->set_userdata(array('orders_end' => FALSE));
			} else {
				
				$t = explode(" do ", $this->input->post('orders_range'));
				
				$this->session->set_userdata(array('orders_start' => $t[0]));
				$this->session->set_userdata(array('orders_end' => $t[1]));
			}
			
		}
		
		$date_start = $this->session->userdata('orders_start');
		$date_end = $this->session->userdata('orders_end');
		$days_forward = ((strtotime($date_end)-strtotime($date_start))/(3600*24))+1;

		$this->data['date_start'] = $date_start;
		$this->data['date_end'] = $date_end;
		$this->data['days_forward'] = $days_forward;
		
		if($date_end) {
			$this->data['all_orders'] = $this->order->get_all_orders(array('up.packet_id IS NOT NULL', 'DATE_FORMAT(o.date, "%Y-%m-%d") >= ' => '"'.$date_start.'"', 'DATE_FORMAT(o.date, "%Y-%m-%d") <= ' => '"'.$date_end.'"'), true);
		} else {
			$this->data['all_orders'] = $this->order->get_all_orders(array('up.packet_id IS NOT NULL', 'DATE_FORMAT(o.date, "%Y-%m-%d") >= ' => '"'.$date_start.'"'), true);
		}
		
		$this->data['filter_view'] = $filter_view;
		//$this->firephp->log($this->db->last_query());

		//Wszystkie produkty
		$this->data['products'] = set_array_keys($this->table->get_rows('product'), 'product_id');
		
		$this->data['template'] = $this->load->view('admin/order/order', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}

	public function create($user_id = FALSE) {
		

		//Wybor uzytkownika
		if($this->input->post('select_user') == 1) {
			redirect(base_url() . 'admin/order/create/' . $this->input->post('order_user'));	
		}
		
				
		//Zapis zamówienia
		if($user_id && $this->input->post('save') == 1 || $this->input->post('save_client_order') == 1) {
			
			log_message('debug', 'POCZATEK SKŁADANIA ZAMÓWIENIA');

			$packet = $this->table->get_row('product', array('product_id' => $this->input->post('delivery_product')));
			
			log_message('debug', 'ID PRODUKTU '. $packet->product_id);
			
			//tablica dni
			if($this->input->post('mode') == 'range') {
				
				log_message('debug', 'TRYB range');
						
				$t = explode(" do ", $this->input->post('delivery_range')); //przedzial
				$delivery_start = $date = $t[0];
				$delivery_expires = $t[1];
				
				log_message('debug', 'ZAKRES DATY OD ' . $delivery_start . ' do ' . $delivery_expires);
		
				$i = 1;
				while( strtotime($date) <= strtotime($delivery_expires)	) {
					
					if(in_array(	date("N", strtotime($date)), $this->input->post('day')	)) { //w wybrane dni
						$days[$date] = $i;	
						log_message('debug', 'DODANO DZIEŃ ' . $date . ' nr. ' . $i);
						$i++;
					}
				
					$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
					
				}
				
			} elseif($this->input->post('mode') == 'days') {
				
				log_message('debug', 'TRYB days');
				
				$delivery_start = $date = $this->input->post('delivery_start'); 	//start
				$delivery_days = $this->input->post('delivery_days');	//ilosc dni
		
				log_message('debug', 'ZAKRES DATY OD ' . $delivery_start . ' do ' . $delivery_expires);
		
				$i = 1;
				while( $i <= $delivery_days	) {
					
					if(in_array(	date("N", strtotime($date)), $this->input->post('day')	)) { //w wybrane dni
						$days[$date] = $i;
						log_message('debug', 'DODANO DZIEŃ ' . $date . ' nr. ' . $i);
						$i++;
					}
				
					$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
					
				}
				
			} elseif($this->input->post('mode') == 'calendar') {

				log_message('debug', 'TRYB calendar');

				foreach($this->input->post('delivery_mode_calendar_day') as $i => $date) {
					$days[$date] = $i;	
					log_message('debug', 'DODANO DZIEŃ ' . $date . ' nr. ' . $i);
				}
				
				
			}
			
			//obliczam cene
			$price = count($days)*$packet->price_for_day;
			
			log_message('debug', 'CENA ' . $price);
			
			//zapisuje zamowienie
			$order = array(
			
				'order_number' => uniqid(),
				'user_id' => $user_id,
			
				'name_surname' => $this->input->post('name_surname'),
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

				'date' => date("Y-m-d H:i:s"),
				'price' => $price,
				
				'payment' => '2'
					
			);
			$this->db->insert('order', $order); 
			$order_id = $this->db->insert_id();
		
			log_message('debug', 'new order id ' . $order_id);
	
			//zapisuje dostawy i gramature?
			$d = explode('_', $packet->meals_per_day);
						
			//teraz dla kazdej dostawy przydaloby sie zapisac dor azu gramature - wzorem beddzie gramatura z ostatniego dnia ostatniego oplaconego zamowienia
			$old_last_delivery_grammage = $this->delivery->last_order_last_delivery_last_grammage($user_id, $order_id);
			
			foreach($days as $date => $number) {
				
				$last_delivery = array(
					'order_id' => $order_id,
					'user_id' => $user_id,
					'packet_id' => $packet->product_id,
					'date' => $date,
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
				log_message('debug', 'created delivery_id ' . $last_delivery_id);	
				
				//dodawanie gramatury na podstawie ostatniej
				if(!empty($old_last_delivery_grammage)) {
					unset($old_last_delivery_grammage->delivery_grammage_id);
					unset($old_last_delivery_grammage->status);
					$old_last_delivery_grammage->order_id = $order_id;
					$old_last_delivery_grammage->delivery_id = $last_delivery_id;
					
					for($i = 1; $i <= 5; $i++) {	
						$w = 'meal_' . $i . '_w';
						$b = 'meal_' . $i . '_b';
						if(!in_array($i, $this->input->post('meal'))) {
							//czyli jesli posiłek nie wybrany
							unset($old_last_delivery_grammage->$w);
							unset($old_last_delivery_grammage->$b);
						}
					}
					
					$this->db->insert('delivery_grammage', $old_last_delivery_grammage); 
					log_message('debug', 'created delivery_grammage_id ' . $this->db->insert_id());	
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
			log_message('debug', 'order_product filled');	
			
			//przypisuje usera do pakietu
			$user_packets = array(
				'order_id' => $order_id,
				'user_id' => $user_id,
				'packet_id' => $packet->product_id,
				'buyed' => date("Y-m-d H:i:s"),
				'days' => count($days),
				'payed_days' => count($days),
				'meals' => end(explode('_', $packet->meals_per_day)),
				'meals_selected' => serialize($this->input->post('meal'))
			);
			$this->db->insert('user_packets', $user_packets); 
			log_message('debug', 'user_packets filled, now redirect...');
			
			$this->session->set_flashdata('adding_order', '1'); 
			
			//Redirect
			if($this->input->post('save_client_order') == 1) {
				redirect(base_url() . 'sp/order/delivery/' . $order_id);	
			} else {
				redirect(base_url() . 'admin/order/delivery/' . $order_id);		
			}
			
	
		}
		
		//Dane
		if($user_id) {
			$this->data['order_user'] = $this->table->get_row('user', array('user_id' => $user_id));	
			$this->data['user_packets'] = $this->packet->get_user_packets($user_id);
			$this->data['user_seller'] = $this->seller->get_user_seller($user_id);
		}
		$this->data['users'] = $this->table->get_rows('user', array(), FALSE, array('name_surname', 'ASC'));

		//Wszystkie produkty
		$this->data['products'] = set_array_keys($this->table->get_rows('product'), 'product_id');
	
		$this->data['template'] = $this->load->view('admin/order/create', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	public function update($order_id = FALSE) {
		
		$this->data['order'] = $this->order->get_order_with_products($order_id);
		
		if($this->input->post('save') == 1 || $this->input->post('save_client_order') == 1) {
		
			//zapisuje zamowienie
			$order = array(

				'name_surname' => $this->input->post('name_surname'),
				'address' => $this->input->post('address'),
				'postcode' => $this->input->post('postcode'),
				'city' => $this->input->post('city'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				
				'order_number' => $this->input->post('order_number'),
				'date' => $this->input->post('date'),
				'price' => $this->input->post('price'),
					
			);
			$this->db->where('order_id', $order_id);
			$this->db->update('order', $order); 
		
			$this->session->set_flashdata('updating_order', '1'); 
			
			if($this->input->post('save_client_order')) {
				redirect(base_url() . 'sp/order/update/' . $order_id);	
			} else {
				redirect(base_url() . 'admin/order/update/' . $order_id);	
			}
		}
	
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
	
		$this->data['template'] = $this->load->view('admin/order/read', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
	public function remove($order_id, $redirect = false) {
		
		$data = array('status' => '0');

		//zamowienie
		$this->db->where('order_id', $order_id);
		$this->db->update('order', $data); 
		
		
		$this->db->where('order_id', $order_id);
		$this->db->update('delivery', $data);
		
		
		$this->db->where('order_id', $order_id);
		$this->db->update('delivery_grammage', $data); 
		
		
		$this->db->where('order_id', $order_id);
		$this->db->update('order_form', $data); 
		
		
		$this->db->where('order_id', $order_id);
		$this->db->update('order_product', $data); 
		
		
		$this->db->where('order_id', $order_id);
		$this->db->update('user_packets', $data); 

		if($redirect) {
			redirect(base64_decode($redirect));	
		} else {
			redirect(base_url() . 'admin/order');
		}
		
	}
	
	
	public function read_form($order_id) {
		
		$this->data['order'] = $this->order->get_order_with_products($order_id);
		$this->data['food_form'] = $this->table->get_row('order_form', array('order_id' => $order_id));
	
		echo $this->load->view('admin/order/read_form', $this->data, true);
		
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
	
	
	public function delivery($order_id, $action = FALSE, $param = FALSE) {
		
		$this->data['order'] = $this->order->get_order_with_products($order_id);
		
		//dodawania dnia
		if($action == "add" || $action == "add_by_seller") {
			
			//ostatnia wysylka to wzor
			$delivery = $this->table->get_row('delivery', array('order_id' => $order_id), FALSE, array('date', 'DESC'));
			$delivery_grammage = $this->table->get_row('delivery_grammage', array('delivery_id' => $delivery->delivery_id));
			
			//post ma pierwszenstwo
			if($this->input->post('date')) {
				$date = date("Y-m-d", strtotime($this->input->post('date')));
			} else {
				$date = date("Y-m-d", strtotime($param));
			}
			
			//czy jest już w tym dniu?
			if(!$this->delivery->delivery_exist(FALSE, $date, $delivery->user_id)) {
				
				//dodawanie wysylki
				unset($delivery->delivery_id);
				unset($delivery->stopped);
				unset($delivery->status);
				unset($delivery->number);
				$delivery->date = $date;
				$this->db->insert('delivery', $delivery); 
				$delivery_id = $this->db->insert_id();
				
				//dodawanie gramatury
				if(!empty($delivery_grammage)) {
					unset($delivery_grammage->delivery_grammage_id);
					unset($delivery_grammage->status);
					$delivery_grammage->delivery_id = $delivery_id;
					$this->db->insert('delivery_grammage', $delivery_grammage); 
					
					//aktualizacja wypelnienia gramatury
					$this->delivery->recalculate_grammage_filled($order_id);
					
				}
							
				//aktualizacja
				$this->db->set('days', 'days+1', FALSE);
				$this->db->where('order_id', $order_id);
				$this->db->update('user_packets'); 
				
				$this->session->set_flashdata('message', 'Dostawa została dodana!'); 
				
			} else {
				
				$this->session->set_flashdata('message', 'Dostawa nie została dodana, ponieważ użytkownik w ten dzień już ma inną dostawę!'); 
				
			}

			//Redirect
			if($action == "add_by_seller") {
				redirect(base_url() . 'sp/order/delivery/'. $order_id);
			} else {
				redirect(base_url() . 'admin/order/delivery/'. $order_id);
			}
			
		}
		
		//usuwanie dnia
		if(($action == "remove" || $action == "remove_by_seller") && $param) {
			
			$last_delivery = $this->table->get_row('delivery', array('order_id' => $order_id), FALSE, array('date', 'DESC'));
			$delivery = $this->table->get_row('delivery', array('delivery_id' => $param), FALSE, array('date', 'DESC'));
			
			//usuwanie wysylki
			$this->db->where('delivery_id', $delivery->delivery_id);
			$this->db->limit(1);
			$this->db->delete('delivery'); 
			
			//usuwanie gramatury
			$this->db->where('delivery_id', $delivery->delivery_id);
			$this->db->limit(1);
			$this->db->delete('delivery_grammage'); 
			
			//aktualizacja wypelnienia gramatury
			$this->delivery->recalculate_grammage_filled($order_id);
					
			//aktualizacja
			$this->db->set('days', 'days-1', FALSE);
			$this->db->where('order_id', $order_id);
			$this->db->update('user_packets'); 
			
			//Redirect
			if($action == "remove_by_seller") {
				redirect(base_url() . 'sp/order/delivery/'. $order_id);
			} else {
				redirect(base_url() . 'admin/order/delivery/'. $order_id);
			}
			
			
		}
		
		//zapisywanie dostaw
		if($this->input->post('save') || $this->input->post('save_and_grammage') || $this->input->post('save_client_order') || $this->input->post('save_client_order_and_grammage')) { 

			foreach($this->input->post('delivery') as $delivery_id => $d) {
				
				$data = array(
								'name_surname' => $d['name_surname'],
								'address' => $d['address'],
								'phone' => $d['phone'],
								'city' => $d['city'],
								'postcode' => $d['postcode'],
								'stopped' => $d['stopped'],
								'hours' => $d['hours'],
								'notice' => $d['notice']
								);
				
				$this->db->where('delivery_id', $delivery_id);
				$this->db->update('delivery', $data); 
				
			}
	
			if($this->input->post('save_and_grammage')) {
				redirect(base_url() . 'admin/order/grammage/' . $order_id);	
			} elseif($this->input->post('save')) {
				redirect(base_url() . 'admin/order/delivery/' . $order_id);	
			} elseif($this->input->post('save_client_order_and_grammage')) {
				redirect(base_url() . 'sp/order/grammage/' . $order_id);	
			} elseif($this->input->post('save_client_order')) {
				redirect(base_url() . 'sp/order/delivery/' . $order_id);	
			}
		}
		
		
		$this->data['all_deliveries'] = $this->delivery->get_deliveries(FALSE, $order_id);
	
		$this->data['template'] = $this->load->view('admin/order/delivery', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
	public function grammage($order_id) {
		
		$this->data['order'] = $this->order->get_order_with_products($order_id);
		
		if($this->input->post('save') || $this->input->post('save_client_order') || $this->input->post('save_and_invoice')) { 

			//usuwam stare
			$this->db->delete('delivery_grammage', array('order_id' => $order_id)); 	

			//dodaje nowe = aktualizuje
			foreach($this->input->post('delivery') as $delivery_id => $day_grammage) {

				$data = array();
				$data['order_id'] = $order_id;
				$data['delivery_id'] = $delivery_id;
				for($i=1;$i<=5;$i++) {

					$data['meal_' . $i . '_w'] = $day_grammage[$i]['w'];
					$data['meal_' . $i . '_b'] = $day_grammage[$i]['b'];
					$data['meal_' . $i] = $day_grammage[$i]['name'];

				}
				$data['notice'] = $day_grammage['notice'];
				$data['keyword'] = $day_grammage['keyword'];
				$data['price'] = $day_grammage['price'];
				$this->db->insert('delivery_grammage', $data); 
			}
			
			//aktualizacja wypelnienia gramatury
			$this->delivery->recalculate_grammage_filled($order_id);
				
			if($this->input->post('save_and_invoice')) {
				redirect(base_url() . 'admin/order/invoice/' . $order_id);	
			} elseif($this->input->post('save')) {
				redirect(base_url() . 'admin/order/grammage/' . $order_id);	
			} elseif($this->input->post('save_client_order')) {
				redirect(base_url() . 'sp/order/grammage/' . $order_id);	
			}
		}
		
		
		$this->data['all_deliveries'] = $this->delivery->get_deliveries(FALSE, $order_id);
		$this->data['all_deliveries_grammage'] = $this->table->get_rows('delivery_grammage', array('order_id' => $order_id));
		$this->data['all_deliveries_grammage'] = set_array_keys($this->data['all_deliveries_grammage'], 'delivery_id');
		$this->data['food_form'] = $this->table->get_row('order_form', array('order_id' => $order_id));
	
		$this->data['template'] = $this->load->view('admin/order/grammage', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
	public function invoice($order_id) {
		
		if($this->input->post('save') == 1) {
					
			$data = array(
						   'invoice_date' => $this->input->post('invoice_date'),
						   'invoice_number' => $this->input->post('invoice_number'),
						   'invoice_payment_method' => $this->input->post('invoice_payment_method'),
						   'invoice_payment_deadline' => $this->input->post('invoice_payment_deadline')
						);
			
			$this->db->where('order_id', $order_id);
			$this->db->update('order', $data); 

		
		}
		
		$this->data['order'] = $this->order->get_order_with_products($order_id);
		$this->data['invoice'] = $this->load->view('cp/packets/_elements/invoice', $this->data, true);
	
		$this->data['template'] = $this->load->view('admin/order/invoice', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	public function download_invoices() {

		$date_start = $this->session->userdata('orders_start');
		$date_end = $this->session->userdata('orders_end');
		$all_orders = FALSE;

		//Jeśli wybrany przedział
		if($date_start && $date_end) {
			$all_orders = $this->order->get_all_orders(array('up.packet_id IS NOT NULL', 'DATE_FORMAT(o.date, "%Y-%m-%d") >= ' => '"'.$date_start.'"', 'DATE_FORMAT(o.date, "%Y-%m-%d") <= ' => '"'.$date_end.'"'), true);
		} elseif($date_start) {
			$all_orders = $this->order->get_all_orders(array('up.packet_id IS NOT NULL', 'DATE_FORMAT(o.date, "%Y-%m-%d") >= ' => '"'.$date_start.'"'), true);
		} else {
			//Wystarczy przekierowac i przedział już się ustawi
			redirect(base_url() . 'admin/order');	
		}
		
		//Jeśli w tym przedziale coś jest
		if(!empty($all_orders)) {
			
			//Czyszcze folder, gdzie wszystko bedzie ladowac
			$this->load->helper("file");
			delete_files(FCPATH . 'invoices', true);
			
			//No to dla każdego pobieramy kompletne dane, generujemy pdf i zapisujemy na dysk, dodajemy do archiwum
			$this->load->library('zip');
			foreach($all_orders as $o) {
				
				$this->data['order'] = $order = $this->order->get_order_with_products($o->order_id);
			
				if($order) {
					
					$this->load->helper('dompdf');
				
					$html = $this->load->view('cp/packets/_elements/invoice', $this->data, true);
					$pdf_created = pdf_create($html, 'faktura', FALSE, 0);
					$file_path = FCPATH . 'invoices/' . clean_chars($order->date) . '_' . clean_chars($order->name_surname) . '.pdf';
					//Tworze plik
					file_put_contents($file_path, $pdf_created); 
					//Dodaje do archiwum
					$this->zip->read_file($file_path); 
					
				}
				
			}
			
			//Czyszcze folder (dla bezpieczenstwa)
			delete_files(FCPATH . 'invoices', true);
			
			//Pobieram zip
			if($date_start && $date_end) {
				$this->zip->download('faktury_od_' . clean_chars($date_start) . '_do_' . clean_chars($date_end) . '.zip');
			} else {
				$this->zip->download('faktury_od_' . clean_chars($date_start) . '.zip');	
			}
			
			
		} else {
			
			//Ustaw komunikat
			$this->session->set_flashdata('message', 'Brak zamówień w wybranym okresie.'); 
			redirect(base_url() . 'admin/order');	
			
		}
		
	}
	
}
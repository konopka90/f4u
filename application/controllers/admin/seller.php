<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seller extends Admin {

	public function __construct() {
		parent::__construct();
		
		//sprawdza poziom
		if($this->user->access < 5 && $this->user->user_id != 12 ) {
			redirect(base_url().  "admin");	
		}
		
	}
	
	public function index() {
		
		$this->data['sellers'] = $this->seller->get_sellers();

		$this->data['template'] = $this->load->view('admin/seller/seller', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
	public function create($seller_id = FALSE) {
		
		//Wszyscy uzytkownicy, którzy nie maja 
		$this->data['users'] = $this->seller->get_free_users($seller_id);
		
		//Wszystkie zamowienia
		$this->data['orders'] = $this->order->get_all_orders(array('up.packet_id IS NOT NULL'), true);
		//Wszystkie produkty
		$this->data['products'] = set_array_keys($this->table->get_rows('product'), 'product_id');
		
		//Edytowany
		$this->data['seller'] = FALSE;
		$this->data['seller_users_orders'] = array();
		if($seller_id) {
			//Uzytkownik
			$this->data['seller'] = $this->table->get_row('user', array('user_id' => $seller_id, 'is_seller' => '1'));
			//Jego przypisane rzeczy
			$seller_users_orders = $this->table->get_rows('seller_user_order', array('seller_id' => $seller_id));
			if(!empty($seller_users_orders)) {
				foreach($seller_users_orders as $suo) {
					$this->data['seller_users_orders'][$suo->mode]['ids'][] = ($suo->mode == 'user')?$suo->user_id:$suo->order_id;
					$this->data['seller_users_orders'][$suo->mode][($suo->mode == 'user')?$suo->user_id:$suo->order_id] = $suo;
				}
			}
		}
		
		
		if($this->input->post('add') == 1 || $this->input->post('save') == 1) {
			
			//printr($this->input->post());
			
			//Uzytkownik MUSI BYĆ wybrany
			if(!$this->input->post('seller_id')) {
				$this->session->set_flashdata('message', 'Musisz wybrać użytkownika, którego chcesz mianować sprzedawcą!'); 	
				redirect(base_url() . 'admin/seller/' . ( ($this->input->post('save'))?'update/'.$id:'create'));	
			}
			
			//Zapisuje usera
			$user = array(
				'is_seller' =>'1',
				'account_number' => $this->input->post('account_number'),
				'seller_provision' => $this->input->post('seller_provision')
			);
			$this->db->where('user_id', $this->input->post('seller_id'));
			$this->db->update('user', $user); 
			
			//Czy przypisano mu klientow?
			//Jakich ma przypisanych?
			$old_clients = array();
			$old_clients_ = $this->seller->get_clients($this->input->post('seller_id'), 'user');
			if(!empty($old_clients_)) {
				foreach($old_clients_ as $oc) {
					array_push($old_clients, $oc->user_id);	
				}
			}
			//printr($old_clients);
			
			//Aktualni 
			$new_clients = array();	
			if($this->input->post('user_id')) {
				$new_clients = $this->input->post('user_id');		
			}
			//printr($new_clients);
			
			//Czesc wspolna - zostaja
			$actual_clients = array_intersect($old_clients, $new_clients);
			//printr($actual_clients);
			
			//Jacy ubyli
			$deleted_clients = array_diff($old_clients, $new_clients);
			//printr($deleted_clients);
			if(!empty($deleted_clients)) {
				$this->db->where('seller_id', $this->input->post('seller_id'));
				$this->db->where('mode', 'user');
				$this->db->where_in('user_id', $deleted_clients);
				//$this->db->limit(count($deleted_clients));
				$this->db->delete('seller_user_order');
			}
			
			//Jacy doszli
			$new_clients = array_diff($new_clients, $old_clients);
			//printr($new_clients);
			if(!empty($new_clients)) {
				foreach($new_clients as $i => $user_id) {
					$data = array(
						'seller_id' => $this->input->post('seller_id'),
						'user_id' => $user_id,
						'mode' => 'user',
						'assigned' => date("Y-m-d H:i:s")
					);
					$this->db->insert('seller_user_order', $data); 		
				}
			}
			
			//exit;
			
			//Czy przypisano mu zamowienie?
			$this->db->where('user_id IS NULL');
			$this->db->where('mode', 'order');
			$this->db->delete('seller_user_order'); 
			if($this->input->post('order_id')) {
				if(count($this->input->post('order_id')) > 0) {
					foreach($this->input->post('order_id') as $i => $order_id) {
						$data = array(
							'seller_id' => $this->input->post('seller_id'),
							'order_id' => $order_id,
							'mode' => 'order',
						);
						$this->db->insert('seller_user_order', $data); 		
					}
				}
			}
			
			//Przekierowuje
			if($this->input->post('save')) {
				redirect(base_url() . 'admin/seller/update/'.$seller_id);	
			} else {
				redirect(base_url() . 'admin/seller/update/'.$seller_id);	
			}

		}
	
		$this->data['template'] = $this->load->view('admin/seller/create', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
	public function details($seller_id) {
		
		//Zapis
		if($this->input->post('payout')) {
			
			if($this->input->post('payout') == 'realise') {
				
				$before_saldo = $this->seller->get_saldo($seller_id, false, true);
				$after_saldo  = ($before_saldo - floatval($this->input->post('provision_payout')));
				
				//var_dump($before_saldo);
				//var_dump($after_saldo);
				//exit;
				
				$data = array(
					'realisation' => '2',
					'provision_saldo_before' =>  $before_saldo,
					'provision_saldo_after' =>  $after_saldo,
					'provision_payout' => $this->input->post('provision_payout'),
					'realisation_date' => $this->input->post('realisation_date'),
					'desc' => $this->input->post('desc')
				);
				
			} elseif($this->input->post('payout') == 'deny') {
				
				$data = array(
					'realisation' => '3',
					'provision_payout' => $this->input->post('provision_payout'),
					'realisation_date' => $this->input->post('realisation_date'),
					'desc' => $this->input->post('desc')
				);
				
			}
			$this->db->where('seller_payout_id', $this->input->post('seller_payout_id'));
			$this->db->update('seller_payout', $data);
			
			//printr($this->input->post());
			//exit;
			
			redirect(current_url());
				
		}
	
		//Seller
		$this->data['seller'] = $this->seller->get_sellers($seller_id);
		
		//Klienci i zamowienia
		/*
		$this->data['seller_users_orders'] = array();
		$seller_users_orders = $this->table->get_rows('seller_user_order', array('seller_id' => $seller_id));
		if(!empty($seller_users_orders)) {
			foreach($seller_users_orders as $suo) {
				$this->data['seller_users_orders'][$suo->mode]['ids'][] = ($suo->mode == 'user')?$suo->user_id:$suo->order_id;
				$this->data['seller_users_orders'][$suo->mode][($suo->mode == 'user')?$suo->user_id:$suo->order_id] = $suo;
			}
		}
	
		//Klienci
		$this->data['users'] = $this->table->get_rows('user', array('user_id IN('.implode(',', $this->data['seller_users_orders']['user']['ids']).')'));
		
		//Zamowienia
		//$this->data['order'] = $this->table->get_rows('user', array('user_id' => $seller_id, 'is_seller' => '1'));
		/**/
		
		//Klienci
		$this->data['users'] = $this->seller->get_clients($seller_id);
		
		//Wszystkie zamówienia
		$this->data['all_orders'] = $this->seller->get_clients_orders($seller_id);

		//Wszystkie produkty
		$this->data['products'] = set_array_keys($this->table->get_rows('product'), 'product_id');
		
		//Wszystkie historie wyplat
		$this->data['payouts'] = $this->seller->get_payouts($seller_id);
		
		
		$this->data['template'] = $this->load->view('admin/seller/details', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
	public function remove($user_id) {
		
		//User
		$data = array(
			'is_seller' => '0',
			'seller_provision' => 0.00
		);
		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data); 
		
		//Seller
		$this->db->delete('seller_user_order', array('seller_id' => $user_id)); 
		
		//Seller provision payouts
		$this->db->delete('seller_payout', array('seller_id' => $user_id)); 
		
		redirect(base_url() . 'admin/seller');
		
	}
	
}
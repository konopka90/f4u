<?

class M_Seller extends CI_Model { 


	function __construct() { 
		parent::__construct();
	} 
	
	
	function get_sellers($user_id = false) {
		
		$this->benchmark->mark('start');
	
		$this->db->select('u.*, u.user_id as seller_id, suo.user_id as client_id, suo.assigned, sp.realisation as waiting_payout');

		$this->db->from('user u');
		$this->db->join('seller_user_order suo', 'u.user_id = suo.seller_id', 'left');
		$this->db->join('seller_payout sp', 'u.user_id = sp.seller_id AND sp.realisation = "1"', 'left');
	
		$this->db->where('u.is_seller', '1'); //Jeśli sprzedawca istnieje
		$this->db->where('u.status', '1');
		if($user_id) {
			$this->db->where('u.user_id', $user_id);	
		}
	
		$q = $this->db->get();
		$result_ = $q->result();	
		
		//Poznaje klientów
		$sellers = array();
		if(!empty($result_)) {
			
			foreach($result_ as $r) {
				
				$sellers[$r->seller_id]['waiting_payout'] = $r->waiting_payout;
				$sellers[$r->seller_id]['user_id'] = $r->user_id;
				$sellers[$r->seller_id]['name_surname'] = $r->name_surname;
				$sellers[$r->seller_id]['address'] = $r->address;
				$sellers[$r->seller_id]['postcode'] = $r->postcode;
				$sellers[$r->seller_id]['city'] = $r->city;
				$sellers[$r->seller_id]['email'] = $r->email;
				$sellers[$r->seller_id]['phone'] = $r->phone;
				$sellers[$r->seller_id]['seller_provision'] = $r->seller_provision;
				$sellers[$r->seller_id]['account_number'] = $r->account_number;
				
				if(!is_array($sellers[$r->seller_id]['clients'])) {
					$sellers[$r->seller_id]['clients'] = array();
				}
				
				if($r->client_id) {
					array_push($sellers[$r->seller_id]['clients'], array(
						'client_id' => $r->client_id,
						'assigned' => $r->assigned,
						'seller_provision' => $r->seller_provision,
					));
				}
				
			}

			//Dla każdego sellera obliczam liczbe klientów, liczbe zamowien, kwote zamowien i prowizje
			foreach($sellers as $seller_id => $data) {
				
				$sellers[$seller_id]['clients_count'] = 0;
				$sellers[$seller_id]['orders_count'] = 0;
				$sellers[$seller_id]['orders_price'] = 0.00;
				$sellers[$seller_id]['orders_provision'] = 0.00;
				
				if($data['clients']) {
					foreach($data['clients'] as $c) {
						
						if($c['assigned'] && $c['client_id']) {
							
							$this->db->select('COUNT(o.order_id) as orders_count, SUM(o.price) as orders_price');	
							$this->db->from('order o');
							$this->db->where('o.user_id', $c['client_id']);
							$this->db->where('o.date >=', $c['assigned']);
							$this->db->where('o.payment', '2');
							$this->db->where('o.status', '1');
							$q = $this->db->get();
							$r = $q->row();	
							
							$sellers[$seller_id]['orders_count'] += $r->orders_count;
							$sellers[$seller_id]['orders_price'] += $r->orders_price;
						
						}
						
						//Czy klient istnieje?
						if(!empty($this->users[$c['client_id']]->user_id)) {
							//$this->firephp->log($c['client_id']);
							$sellers[$seller_id]['clients_count']++;
						}
					}
				}
				
				$sellers[$seller_id]['orders_provision'] = $sellers[$seller_id]['orders_price'] * ($c['seller_provision']/100);
				$sellers[$seller_id]['saldo_fridge'] = $this->get_saldo($seller_id, false, false);
				$sellers[$seller_id]['saldo'] = $this->get_saldo($seller_id, false, true);
				
			}
			
		}
		
		
		
		$this->benchmark->mark('end');
		$this->firephp->log($this->benchmark->elapsed_time('start', 'end'));
		
		if($user_id) {
			if(!empty($sellers[$user_id])) {
				return array_to_object($sellers[$user_id]);
			} else {
				return new stdClass();	
			}
		} else {
			return array_to_object($sellers);	
		}
		
		
	}
	
	function get_clients($seller_id, $mode = false, $client_id = false) {
	
		$this->db->select('u.*, suo.assigned, COUNT(o.order_id) as orders_count, SUM(o.price) as orders_price, (SELECT uu.seller_provision FROM f4u_user uu WHERE uu.user_id = "'.$seller_id.'") as seller_provision');
		$this->db->from('seller_user_order suo');
		$this->db->join('user u', 'suo.user_id = u.user_id', 'right');
		//Zamowienia zaplacone i zlozone PO przypisaniu
		$this->db->join('order o', 'suo.user_id = o.user_id AND o.date > suo.assigned AND o.payment = "2" AND o.status ="1"', 'left');
		
		$this->db->where('u.status', '1');
		if($mode) {
			$this->db->where('suo.mode', $mode);	
		}
		
		$this->db->where('suo.seller_id', $seller_id);
		if($client_id) {
			$this->db->where('suo.user_id', $client_id);	
		}
		
		$this->db->group_by('suo.user_id');
		
		$q = $this->db->get();
		
		if($client_id) {
			$result = $q->row();
		} else {
			$result = $q->result();
		}
		
		return $result;
	
	}
	
	
	function get_clients_orders($seller_id, $mode = false) {
		
		$this->db->select('suo.mode, o.*, up.packet_id, up.meals, up.meals_selected, up.days, u.seller_provision');
		$this->db->from('seller_user_order suo');
		$this->db->join('order o', 'suo.user_id = o.user_id OR suo.order_id = o.order_id');
		$this->db->join('user_packets up', 'o.order_id = up.order_id', 'left');
		$this->db->join('user u', 'suo.seller_id = u.user_id', 'left');

		if($mode) {
			$this->db->where('suo.mode', $mode);	
		}
		$this->db->where('suo.seller_id', $seller_id);
		$this->db->where('suo.assigned IS NOT NULL');
		$this->db->where('o.status', '1');
		//Po przypisaniu
		$this->db->where('o.date >= suo.assigned');
		
		$this->db->order_by('o.date', 'DESC');
		
		
		$q = $this->db->get();
		$result = $q->result();
		
		//Dopisauje date
		if($result) {
			foreach($result as $i => $order) {
				$d = $this->delivery->get_deliveries(FALSE, $order->order_id);
				$result[$i]->first_delivery = reset($d)->date;
				$result[$i]->last_delivery = end($d)->date;
				$result[$i]->deliveries_count = count($d);
			}
		}
	
		return $result;
	
	}
	
	
	function get_clients_orders_price_sum($seller_id, $mode = false) {
	
		$clients_orders = $this->get_clients_orders($seller_id, $mode);
		
		$price = 0.00;
		if(!empty($clients_orders)) {
			foreach($clients_orders as $co) {
				
				//Tylko zapłacone zamówienia
				if($co->payment == '2') {
					$price += $co->price;
				}
				
			}
		} 
		
		return $price;
		
	}
	
	
	function get_saldo($seller_id, $mode = false, $only_payouted = false) {
	
		//User
		$user = $this->table->get_row('user', array('user_id' => $seller_id));
		
		//Dotychczas uzyskana prowizja
		//Zaplacone i po przypisaniu
		$provision = $this->get_clients_orders_price_sum($seller_id, $mode);
		
		//Dotychczasowe wypłaty
		$this->db->select('SUM(sp.provision_payout) as provision_payouts', false);
		$this->db->from('seller_payout sp');
		$this->db->where('sp.seller_id', $seller_id);
		//Tylko zrealizowane i oczekujace
		if($only_payouted) {
			$this->db->where_in('sp.realisation', array('2'));
		} else {
			$this->db->where_in('sp.realisation', array('1', '2'));	
		}
		
		$q = $this->db->get();
		$payouts = $q->row();
		
		$total = ( $provision * ($user->seller_provision/100) ) - $payouts->provision_payouts;
		
		return $total; 
		
	}
	
	
	function get_payouts($seller_id) {
	
		//Wez wszystkie wyplaty
		$this->db->select('sp.*');
		$this->db->from('seller_payout sp');
		
		$this->db->where('sp.seller_id', $seller_id);
		$this->db->order_by('sp.date', 'DESC');
		$this->db->limit(10);
		
		$q = $this->db->get();
		$result = $q->result();
	
		return $result;
		
	}
	
	function get_free_users($except_seller_id = false) {
	
		$this->db->select('u.*, suo.seller_id');	
		$this->db->from('user u');
		$this->db->join('seller_user_order suo', 'u.user_id = suo.user_id', 'left');
		
		if($except_seller_id) {
			$this->db->where('(suo.seller_id IS NULL OR suo.seller_id = "'.$except_seller_id.'")');	
		} else {
			$this->db->where('suo.seller_id IS NULL');	
		}
		$this->db->order_by('name_surname', 'ASC');
		
		$q = $this->db->get();
		$result = $q->result();
		
		//echo $this->db->last_query();
		
		return $result;
		
	}
	
	
	function get_user_seller($user_id) {
		
		$this->db->select('u.name_surname, u.seller_provision, suo.seller_id, suo.assigned');	
		$this->db->from('seller_user_order suo');
		$this->db->join('user u', 'u.user_id = suo.seller_id', 'left');
		
		$this->db->where('suo.user_id', $user_id);	
		
		$q = $this->db->get();
		$result = $q->row();
		
		return $result;
		
	}
	
	
}

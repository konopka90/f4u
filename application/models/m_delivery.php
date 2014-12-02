<?

class M_Delivery extends CI_Model { 


	function __construct() { 
		parent::__construct();
	} 
	
	public function get_delivery($delivery_id) {
		
		$this->db->select('d.*, o.payment');
		$this->db->from('delivery d');
		$this->db->join('order o', 'd.order_id = o.order_id', 'left');
		
		$this->db->where('d.delivery_id', $delivery_id);
		$this->db->where('d.status', '1');
		$this->db->where('o.status', '1');
		
		$q = $this->db->get();

		return $q->row();
			
	}
	
	public function get_deliveries($user_id = FALSE, $order_id = FALSE) {
		
		$this->db->select('d.*, o.payment');
		$this->db->distinct();
		$this->db->from('delivery d');
		$this->db->join('order o', 'o.order_id = d.order_id', 'left');
		
		if($user_id) {
			$this->db->where('d.user_id', $user_id);
		}
		if($order_id) {
			$this->db->where('d.order_id', $order_id);
		}
		$this->db->where('d.status', '1');
		$this->db->where('o.status', '1');
		
		$this->db->order_by('d.date', 'ASC');
		
		$query = $this->db->get();

		return $query->result();
			
	}
	
	public function get_delivery_by_date($user_id, $date) {
		
		$this->db->select('*');
		$this->db->where('date', $date);
		$this->db->where('user_id', $user_id);
		$this->db->where('status', '1');
		$this->db->order_by('date', 'ASC');
		
		$q = $this->db->get('delivery');

		return $q->result();
			
	}
	
	
	public function get_deliveries_users_for_admin_calendar($start_date, $end_date) {
		
		$this->db->select('	u.user_id, 
							u.name_surname, 
							u.phone, 
							dg.meal_1_w + dg.meal_1_b as meal_1_sum,
							dg.meal_2_w + dg.meal_2_b as meal_2_sum,
							dg.meal_3_w + dg.meal_3_b as meal_3_sum,
							dg.meal_4_w + dg.meal_4_b as meal_4_sum,
							dg.meal_5_w + dg.meal_5_b as meal_5_sum,
							dg.meal_1_w + dg.meal_1_b + dg.meal_2_w + dg.meal_2_b + dg.meal_3_w + dg.meal_3_b + dg.meal_4_w + dg.meal_4_b + dg.meal_5_w + dg.meal_5_b as meal_sum
						', FALSE);
		$this->db->distinct();
		$this->db->from('user u');
		$this->db->join('delivery d', 'u.user_id = d.user_id', 'left');
		$this->db->join('delivery_grammage dg', 'd.delivery_id = dg.delivery_id', 'left');
		$this->db->join('order o', 'o.order_id = d.order_id', 'left');
		$this->db->join('user_packets up', 'u.user_id = up.user_id', 'left');
		
		$this->db->where('d.date >=', $start_date);
		$this->db->where('d.date <=', $end_date);
		$this->db->where('d.stopped !=', '1');
		
		$this->db->where('o.payment', '2');
		$this->db->where('o.grammage', '1');
		
		$this->db->where('d.status', '1');
		$this->db->where('up.status', '1');
		$this->db->where('o.status', '1');
		$this->db->where('u.status', '1');
		
		//KLUCZOWE SORTOWANIE
		//$this->db->order_by('dg.keyword', 'ASC');
		//$this->db->order_by('d.meals', 'DESC');
		
		$this->db->order_by('meal_sum', 'DESC');
		$this->db->order_by('meal_1_sum', 'DESC');
		$this->db->order_by('meal_2_sum', 'DESC');
		$this->db->order_by('meal_3_sum', 'DESC');
		$this->db->order_by('meal_4_sum', 'DESC');
		$this->db->order_by('meal_5_sum', 'DESC');
		/*
		$this->db->order_by('dg.meal_1_b', 'ASC');
		$this->db->order_by('dg.meal_2_b', 'ASC');
		$this->db->order_by('dg.meal_3_b', 'ASC');
		$this->db->order_by('dg.meal_4_b', 'ASC');
		$this->db->order_by('dg.meal_5_b', 'ASC');
		
		$this->db->order_by('dg.meal_1_w', 'ASC');
		
		$this->db->order_by('dg.meal_2_w', 'ASC');
		
		$this->db->order_by('dg.meal_3_w', 'ASC');
		
		$this->db->order_by('dg.meal_4_w', 'ASC');
	
		$this->db->order_by('dg.meal_5_w', 'ASC');
		/**/
		
		$q = $this->db->get();
		$result = $q->result();

		return $result;

		
	}
	
	
	public function get_deliveries_for_admin_calendar($start_date, $end_date) {
		
		//o.payment, 
		
		$this->db->select(	'd.*, d.user_notice, d.notice as delivery_notice, YEAR(d.date) as year, MONTH(d.date) as month, DAY(d.date) as day, 
							
							p.name, 
							dg.notice, dg.keyword, dg.price, dg.meal_1, dg.meal_1_w, dg.meal_1_b, dg.meal_2, dg.meal_2_w, dg.meal_2_b, dg.meal_3, dg.meal_3_w, dg.meal_3_b, dg.meal_4, dg.meal_4_w, dg.meal_4_b, dg.meal_5, dg.meal_5_w, dg.meal_5_b
						');

		$this->db->from('delivery d');
		$this->db->join('delivery_grammage dg', 'dg.delivery_id = d.delivery_id', 'left');
		$this->db->join('order o', 'o.order_id = d.order_id', 'left');
		$this->db->join('product p', 'd.packet_id = p.product_id', 'left');
		
		$this->db->where('d.date >=', $start_date);
		$this->db->where('d.date <=', $end_date);
		$this->db->where('d.stopped !=', '1');
		
		$this->db->where('o.payment', '2');
		$this->db->where('o.grammage', '1');
		
		$this->db->where('d.status', '1');
		$this->db->where('dg.status', '1');
		$this->db->where('o.status', '1');
		$this->db->where('p.status', '1');
		
		$this->db->order_by('d.date', 'ASC');
		$this->db->order_by('p.name', 'ASC');
		
		$q = $this->db->get();
		$r = $q->result();
		
		//flog($this->db->last_query());
		
		foreach($r as $i => $d) {
			
			$result[$d->date][$d->user_id][] = $d;
			
		}
		
		//flog($result);
		
		return $result;

	}
	
	public function get_deliveries_selected_meals_for_admin_calendar($all_deliveries) {
		
		$all_deliveries_selected_meals = array();
		
		//ID ZAMOWIEN
		$orders_ids = array();
		if(!empty($all_deliveries)) {
			foreach($all_deliveries as $day => $user) {
				foreach($user as $user_id => $v) {
					array_push($orders_ids, $v[0]->order_id);
				}
			}
		}
		
		if(!empty($orders_ids)) {
		//WYBRANE POSILKI
			$this->db->select('order_id, meals_selected');
			$this->db->from('user_packets');
			$this->db->where_in('order_id', $orders_ids);
			$q = $this->db->get();
			$r = $q->result();
			$all_deliveries_selected_meals = set_array_keys($r, 'order_id');
		}
		
		return $all_deliveries_selected_meals;
		
	}


	public function get_deliveries_for_user_calendar($user_id, $offer = true, $from_date = false) {
		
		$this->db->select('d.delivery_id, d.moved_to, YEAR(d.date) as year, MONTH(d.date) as month, DAY(d.date) as day, d.address, d.date, d.stopped, d.meals, o.order_number, o.payment, p.name');
		$this->db->distinct();
		
		$this->db->from('delivery d');
		$this->db->join('order o', 'o.order_id = d.order_id', 'left');
		$this->db->join('product p', 'd.packet_id = p.product_id', 'left');
		
		$this->db->where('d.status', '1');
		$this->db->where('d.user_id', $user_id);
		//Od kiedy te zamówienia?
		if($from_date) {
			$this->db->where('o.date >=', $from_date);
		}

		
		$this->db->order_by('d.date', 'ASC');
		
		$q = $this->db->get();
		$r = $q->result();
		
		foreach($r as $i => $delivery) {
			
			$result[$delivery->year][$delivery->month][$delivery->day] = array(	'template' => $this->load->view('cp/delivery/_elements/calendar_day', array('delivery' => $delivery), true));												
			$last_day = $delivery->year . '-' . $delivery->month . '-' . $delivery->day;
			
		}
		
		if($offer == true) {
			if($user_id == $this->user->user_id) {
				$buy_day = strtotime('+1 day', strtotime($last_day));
				$result[date("Y", $buy_day)][date("n", $buy_day)][date("j", $buy_day)] = array(	'template' => $this->load->view('cp/delivery/_elements/calendar_buy', array(), true));
			}
		}
		
		return $result;

	}
	
	
	public function get_deliveries_for_order_calendar_new($product) {
		
		$user = $this->session->userdata('user');
		
		$deliveries = array();
		$busy = array();
		$both = array();
		$count = 0;
		
		//dni ktore user wybral
		foreach($product->days_selected as $i => $date) {
			//czy nie istnieje juz w tym dniu?
			$key_1 = date("Y", strtotime($date));
			$key_2 = date("n", strtotime($date));
			$key_3 = date("j", strtotime($date));
			if(!$this->delivery_exist(FALSE, $date, $user->user_id)) {
				$deliveries[$key_1][$key_2][$key_3] = $both[$key_1][$key_2][$key_3] = array(	'template' => $this->load->view('order/_elements/calendar_day', array('delivery_exist' => false), true));
				$count++;
			} else {
				$busy[$key_1][$key_2][$key_3] = $both[$key_1][$key_2][$key_3] = array(	'template' => $this->load->view('order/_elements/calendar_day', array('delivery_exist' => true), true));
			}
			$last_day = $date;
		}
		//dni aby wyrownac te zajete
		if($count < $product->days) {
			$start_date = $date = date("Y-m-d", strtotime("+1 days", strtotime($last_day)));
			$i = 1;
			while($count < $product->days) {
				$key_1 = date("Y", strtotime($date));
				$key_2 = date("n", strtotime($date));
				$key_3 = date("j", strtotime($date));
				//czy nie istnieje juz w tym dniu?
				if(!$this->delivery_exist(FALSE, $date, $user->user_id)) {
					$deliveries[$key_1][$key_2][$key_3] = $both[$key_1][$key_2][$key_3] = array(	'template' => $this->load->view('order/_elements/calendar_day', array('delivery_exist' => false), true));
					$count++;
				} else {
					$busy[$key_1][$key_2][$key_3] = $both[$key_1][$key_2][$key_3] = array(	'template' => $this->load->view('order/_elements/calendar_day', array('delivery_exist' => true), true));
				}
	
				$date = date("Y-m-d", strtotime("+$i days", strtotime($start_date)));
				$i++;
			}
				
		}
		
		//dni gratisowe
		$product_free_days = get_free_days($product->days);
		if($product_free_days > 0) {
			$start_date = $date;
			$count = $i = 1;
			while($count <= $product_free_days) {
				$key_1 = date("Y", strtotime($date));
				$key_2 = date("n", strtotime($date));
				$key_3 = date("j", strtotime($date));
				if(!$this->delivery_exist(FALSE, $date, $user->user_id)) {
					$deliveries[$key_1][$key_2][$key_3] = $both[$key_1][$key_2][$key_3] = array(	'template' => $this->load->view('order/_elements/calendar_day', array('delivery_exist' => false), true));
					$count++;
				} else {
					$busy[$key_1][$key_2][$key_3] = $both[$key_1][$key_2][$key_3] = array(	'template' => $this->load->view('order/_elements/calendar_day', array('delivery_exist' => true), true));
				}
				$date = date("Y-m-d", strtotime("+$i days", strtotime($start_date)));
				$i++;
			}
		}

		return array('deliveries' => $deliveries, 'busy' => $busy, 'both' => $both);
		
	}
	
	
	
	public function get_deliveries_for_order_calendar($year = FALSE, $month = FALSE, $product, $user_start_date = FALSE) {
		
		$user = $this->session->userdata('user');
		
		//od kiedy tak naprawde moge zaczac pakiet
		$user_packets = $this->packet->get_user_packets($user->user_id);
		$start_date = $date = $this->get_first_avalible_day_for_order_calendar($user_packets, $user_start_date);
		
		//gratisowe dni
		$product_days = $product->days + get_free_days($product->days);
		
		
		$end_date = date("Y-m-d", strtotime("+$product_days days", strtotime($start_date)));
		$i = $count = 1;
		while($count <= $product_days) {

			if(!$this->delivery_exist(FALSE, $date, $user->user_id)) {
				$deliveries[date("Y", strtotime($date))][date("n", strtotime($date))][date("j", strtotime($date))] = array(	'template' => $this->load->view('order/_elements/calendar_day', array(), true));
				$count++;
			}
			$date = date("Y-m-d", strtotime("+$i days", strtotime($start_date)));
			$i++;
		}
		
		return $deliveries;
		
	}
	
	public function get_incoming_deliveries($user_id, $limit = 5) {
		
		
		$this->db->select('d.delivery_id, YEAR(d.date) as year, MONTH(d.date) as month, DAY(d.date) as day, d.name_surname, d.address, d.postcode, d.city, d.phone, d.date, d.user_notice, d.notice, d.stopped, d.meals, d.number, o.payment, p.name');
		$this->db->from('delivery d');
		$this->db->join('order o', 'o.order_id = d.order_id', 'left');
		$this->db->join('product p', 'd.packet_id = p.product_id', 'left');
		
		$this->db->where('d.user_id', $user_id);
		$this->db->where('d.status', '1');
		$this->db->where('d.date >=', date("Y-m-d"));

		$this->db->order_by('d.date', 'ASC');
		$this->db->limit($limit);
		
		$q = $this->db->get();
		$r = $q->result();
		
		return $r;
		
	}
	
	
	public function get_closest_delivery($user_id, $limit = 5) {
		
		
		$this->db->select('d.delivery_id, YEAR(d.date) as year, MONTH(d.date) as month, DAY(d.date) as day, d.name_surname, d.address, d.postcode, d.city, d.phone, d.date, d.stopped, d.meals, o.payment, o.order_id');
		$this->db->from('delivery d');
		$this->db->join('order o', 'o.order_id = d.order_id', 'left');
		
		$this->db->where('o.payment', '2');
		$this->db->where('d.user_id', $user_id);
		$this->db->where('d.date >=', date("Y-m-d"));
		$this->db->where('d.stopped !=', '1');
		$this->db->where('d.status', '1');
		
		$this->db->order_by('d.date', 'ASC');
		$this->db->limit(1);
		
		$q = $this->db->get();
		$r = $q->row();
		
		//$this->firephp->log($this->db->last_query());
		
		return $r;
		
	}
	
	public function delivery_exist($order_id = FALSE, $date, $user_id = FALSE) {
		
		//pusty user czyli niezalogowany, nie mozemy nic powiedziec czyli ZAWSZE false
		if(empty($user_id)) {
			return false;	
		}
		
		//a czy jest order_id
		if($order_id) {
			$where = array('order_id' => $order_id, 'date' => $date, 'user_id' => $user_id);
		} else {
			$where = array('date' => $date, 'user_id' => $user_id);
		}
		
		//sprawdzam
		$check = $this->table->get_row('delivery', $where);
		if(empty($check)) {
			return false;
		} else {
			return true;
		}
		
	}
	
	public function get_first_avalible_day_for_order_calendar($deprecated = FALSE, $user_start_date = FALSE, $three_days_forward = TRUE) {
		
	
		//dzisiaj!
		$first_avalible_day = date("Y-m-d");
		
		//domyslnie troyue, wiec dosmylnie 3 dni naprzod
		if($three_days_forward) {
			$first_avalible_day = date("Y-m-d", strtotime("+3 days"));	
		}

		//chyba ze user wybral pozniej to pozniej
		if($user_start_date) {
			if(strtotime($user_start_date) > strtotime($first_avalible_day)) {
				$first_avalible_day = date("Y-m-d", strtotime($user_start_date));	
			}
		}
		
		//sprawdzam czy ten dzien jest wogole wolny
		if($this->user->user_id) {
			$date = $first_avalible_day;
			while(true) {
				if(!$this->delivery_exist(FALSE, $date, $this->user->user_id)) {
					$first_avalible_day = $date;
					break;
				}
				$date = date("Y-m-d", strtotime("+1 days", strtotime($date)));
			}
		}

		return $first_avalible_day;
		
	}

	public function recalculate_grammage_filled($order_id) {
		
		$all_deliveries_grammage = $this->table->get_rows('delivery_grammage', array('order_id' => $order_id));
	
		$blank = true;
		$count = 0;
		foreach($all_deliveries_grammage as $i => $dg) {

			for($i = 1; $i <= 5; $i++) {
				
				$w = 'meal_' . $i . '_w';
				$b = 'meal_' . $i . '_b';

				if($dg->$w || $dg->$w === '0') {
					$count++;
					$blank = false;
				}
				if($dg->$b  || $dg->$b === '0') {
					$count++;	
					$blank = false;
				}
			}
			
			//aktualizuje zamowienie ze ma uzupelniona gramature
			if($blank == false) {
				$data = array('grammage' => '1', 'grammage_filled' => $count);			
			} else {
				$data = array('grammage' => '0', 'grammage_filled' => $count);			
			}
			$this->db->where('order_id', $order_id);
			$this->db->update('order', $data); 
			
		}
	
	}
	
	public function last_order_last_delivery_last_grammage($user_id, $order_id = FALSE) {
		
		$old_last_order = $this->table->get_row('order', array('user_id' => $user_id, 'payment' => '2', 'order_id !=' => $order_id), FALSE, array('date', 'DESC'));
		log_message('debug', 'old_last_order id ' . $old_last_order->order_id);
		//ostatni dzien dostaw tego zamowienia
		if(!empty($old_last_order)) {
			
			$old_last_delivery = $this->table->get_row('delivery', array('order_id' => $old_last_order->order_id), FALSE, array('date', 'DESC'));
			log_message('debug', 'old_last_delivery id ' . $old_last_delivery->delivery_id);
			
			//ostatnia gramatura
			if(!empty($old_last_delivery)) {
				$old_last_delivery_grammage = $this->table->get_row('delivery_grammage', array('delivery_id' => $old_last_delivery->delivery_id));
				log_message('debug', 'old_last_delivery_grammage id ' . $old_last_delivery_grammage->delivery_grammage_id);	
				
				return $old_last_delivery_grammage;
				
			}
			
		}
	
	}
}

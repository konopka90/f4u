<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Delivery extends Cp {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
				
		$prefs = array (
					   'start_day'    => 'monday',
					   'month_type'   => 'long',
					   'day_type'     => 'short'
					 );				 
		
					 	 
		$prefs['template'] = '
		
		   {table_open}<table class="table table-condensed table-bordered delivery_calendar" >{/table_open}
		
		   {heading_row_start}<tr>{/heading_row_start}
		
		   {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
		   {heading_title_cell}<th colspan="{colspan}" class="bg_success text-center">{heading}</th>{/heading_title_cell}
		   {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
		
		   {heading_row_end}</tr>{/heading_row_end}
		
		   {week_row_start}<tr>{/week_row_start}
		   {week_day_cell}<td class="bg_line">{week_day}</td>{/week_day_cell}
		   {week_row_end}</tr>{/week_row_end}
		
		   {cal_row_start}<tr>{/cal_row_start}
		   {cal_cell_start}<td>{/cal_cell_start}
		
		   {cal_cell_content}{template}{/cal_cell_content}
		   {cal_cell_content_today}<div class="today">{template}</div>{/cal_cell_content_today}
		
		   {cal_cell_no_content}<span class="">{day}</span>{/cal_cell_no_content}
		   {cal_cell_no_content_today}<div class="today"><span class="">{day}</span></div>{/cal_cell_no_content_today}
		
		   {cal_cell_blank}&nbsp;{/cal_cell_blank}
		
		   {cal_cell_end}</td>{/cal_cell_end}
		   {cal_row_end}</tr>{/cal_row_end}
		
		   {table_close}</table>{/table_close}
		';
		$this->load->library('calendar', $prefs);

		//calendarsy
		$data = $this->delivery->get_deliveries_for_user_calendar($this->user->user_id);
		
		//printr($data);
		
		$this->data['calendar_curr'] = $this->calendar->generate(date("Y"), date("n"), $data[date("Y")][date("n")]);
		
		$next_month = strtotime("+1 month");
		$this->data['calendar_next'] = $this->calendar->generate(date("Y", $next_month), date("n", $next_month), $data[date("Y", $next_month)][date("n", $next_month)]);
		
		$next_month_2 = strtotime("+2 month");
		$this->data['calendar_next_2'] = $this->calendar->generate(date("Y", $next_month_2), date("n", $next_month_2), $data[date("Y", $next_month_2)][date("n", $next_month_2)]);
		
		$next_month_3 = strtotime("+3 month");
		$this->data['calendar_next_3'] = $this->calendar->generate(date("Y", $next_month_3), date("n", $next_month_3), $data[date("Y", $next_month_3)][date("n", $next_month_3)]);
		
		$next_month_4 = strtotime("+4 month");
		$this->data['calendar_next_4'] = $this->calendar->generate(date("Y", $next_month_4), date("n", $next_month_4), $data[date("Y", $next_month_4)][date("n", $next_month_4)]);
		
		$next_month_5 = strtotime("+5 month");
		$this->data['calendar_next_5'] = $this->calendar->generate(date("Y", $next_month_5), date("n", $next_month_5), $data[date("Y", $next_month_5)][date("n", $next_month_5)]);

		//pakiety
		$this->data['user_packets'] = $this->packet->get_user_packets($this->user->user_id);
		$this->data['first_avalible_day'] = $this->delivery->get_first_avalible_day_for_order_calendar();

		$this->data['template'] = $this->load->view('cp/delivery/delivery', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
	public function update($delivery_id) {
		
		//max za 2 dni edycje
		$this->data['delivery'] = $delivery = $this->delivery->get_delivery($delivery_id);
		
		if(strtotime($delivery->date) > strtotime("+2 day")) {
			if(count($delivery) == 0 || $delivery->payment != 2) {
				redirect(base_url() . 'cp/delivery');		
			} else {
				//OK	
			}
		} else {
			redirect(base_url() . 'cp/delivery');	
		}
		
		
		//PRZENIESIENIE
		if($this->input->post('move') == 1) {

			//SZABLON
			$delivery = $this->table->get_row('delivery', array('delivery_id' => $delivery_id));
			$delivery_grammage = $this->table->get_row('delivery_grammage', array('delivery_id' => $delivery_id));

			//DODAJE W NOWYM DNIU
			$delivery->moved_from = $delivery->delivery_id;
			$delivery->date = $this->input->post('new_date');
			unset($delivery->delivery_id);
			unset($delivery->moved_to);
			$this->db->insert('delivery', $delivery);
			$new_delivery_id = $this->db->insert_id();
			
			//KOPIUJE GRAMATURE
			if(!empty($delivery_grammage)) {
				unset($delivery_grammage->delivery_grammage_id);
				$delivery_grammage->delivery_id = $new_delivery_id;
				$this->db->insert('delivery_grammage', $delivery_grammage);
			}
			
			//STOP STAREJ
			$this->db->where('delivery_id', $this->input->post('delivery_id'));
			$this->db->update('delivery', array('stopped' => '1', 'moved_to' => $new_delivery_id));
			
			//AKTUALIZACJA WYPELNIENIA GRAMATURY
			$this->delivery->recalculate_grammage_filled($this->data['delivery']->order_id);
			
			//powiadomienie email
			$title = 'F4U - dostawa z dnia ' . $this->data['delivery']->date . ' została przeniesiona';
			$text = '<h2 style="margin-top: 0">Dostawa z dnia ' . $this->data['delivery']->date . ' została przeniesiona na dzień ' . $this->input->post('new_date') . '!</h2>';
			$message = "<p><a href='".base_url()."cp/delivery'>Zobacz swój kalendarz dostaw</a></p><p>Pozdrawiamy!<br />Fit4You<br/>tel. 515 046 567</p>";
			
			$this->common->send_mail(	$this->user->email, 
										$title, 
										$text,
										$message,
										$this->data['config']->contact_email, 
										$this->data['config']->name
									);
									
			
			//powiadomienie konrada i kucharza				
			$title = 'F4U - ' . $this->user->name_surname . ' zmienił termin dostawy';
			$text = '<h2 style="margin-top: 0">Dostawa dla użytkownika ' . $this->user->name_surname . ' z dnia ' . $this->data['delivery']->date . ' została przeniesiona na dzień ' . $this->input->post('new_date') . '!</h2>';
			$message = "<p><a href='".base_url()."admin/user/details/".$this->user->user_id."'>Zobacz kalendarz dostaw użytkownika</a></p><p>Pozdrawiamy!<br />Fit4You<br/>tel. 515 046 567</p>";
			
			$this->common->send_mail(	'konrad@fit4you.pl', 
										$title, 
										$text,
										$message,
										$this->data['config']->contact_email, 
										$this->data['config']->name
									);
									
			$this->common->send_mail(	'kucharzdostawca@fit4you.pl', 
										$title, 
										$text,
										$message,
										$this->data['config']->contact_email, 
										$this->data['config']->name
									);
			
			$this->session->set_flashdata('message', 'Dostawa została przeniesiona na wybrany dzień!'); 
			redirect(base_url() . 'cp/delivery');
			
		}

		//POWROT
		if($this->input->post('undo') == 1) {

			//USUWANIE KOLEJNYCH
			$mt = $this->input->post('moved_to');
			$further_deliveries = array();
			while($mt) {
				
				$d = $this->table->get_row('delivery', array('delivery_id' => $mt));

				//USUWANIE AKTUALNEJ
				$this->db->where('delivery_id', $d->delivery_id);
				$this->db->limit(1);
				$this->db->delete('delivery'); 
	
				//USUWANIE GRAMATURY
				$this->db->where('delivery_id', $d->delivery_id);
				$this->db->limit(1);
				$this->db->delete('delivery_grammage'); 
				
				$further_deliveries[$d->date] = $d->date;
				$mt = $d->moved_to;
			}
	
			//START TEJ
			$this->db->where('delivery_id', $this->input->post('delivery_id'));
			$this->db->update('delivery', array('stopped' => '0', 'moved_to' => NULL));
			
			//AKTUALIZACJA WYPELNIENIA GRAMATURY
			$this->delivery->recalculate_grammage_filled($this->data['delivery']->order_id);
			
			//powiadomienie email
			$title = 'F4U - dostawa z dnia ' . $this->data['delivery']->date . ' została aktywowana';
			$text = '<h2 style="margin-top: 0">Dostawa w dniu ' . $this->data['delivery']->date . ' znów jest aktywna!</h2>';
			$message = "<p>Jednocześnie informujemy, że dostawa w dniu/dniach ".implode(", ", $further_deliveries).", <u>na które wcześniej przenosiłeś(łaś) tą dostawę</u> została anulowana.</p><p><a href='".base_url()."cp/delivery'>Zobacz swój kalendarz dostaw</a></p><p>Pozdrawiamy!<br />Fit4You<br/>tel. 515 046 567</p>";
			
			$this->common->send_mail(	$this->user->email, 
										$title, 
										$text,
										$message,
										$this->data['config']->contact_email, 
										$this->data['config']->name
									);
									
			//powiadomienie konrada						
			$title = 'F4U - ' . $this->user->name_surname . ' zmienił termin dostawy';
			$text = '<h2 style="margin-top: 0">Dostawa dla użytkownika ' . $this->user->name_surname . ' z dnia ' . end($further_deliveries) . ' została przeniesiona na dzień ' . $this->data['delivery']->date . '!</h2>';
			$message = "<p><a href='".base_url()."admin/user/details/".$this->user->user_id."'>Zobacz kalendarz dostaw użytkownika</a></p><p>Pozdrawiamy!<br />Fit4You<br/>tel. 515 046 567</p>";
			
			$this->common->send_mail(	'konrad@fit4you.pl', 
										$title, 
										$text,
										$message,
										$this->data['config']->contact_email, 
										$this->data['config']->name
									);
									
			$this->common->send_mail(	'kucharzdostawca@fit4you.pl', 
										$title, 
										$text,
										$message,
										$this->data['config']->contact_email, 
										$this->data['config']->name
									);
			
			$this->session->set_flashdata('message', 'Dostawa została przeniesiona na wybrany dzień!'); 
			redirect(base_url() . 'cp/delivery');
			
		}
		
		//POWROT 2
		if($this->input->post('back') == 1) {

			//USUWANIE AKTUALNEJ
			$this->db->where('delivery_id', $delivery_id);
			$this->db->limit(1);
			$this->db->delete('delivery'); 

			//USUWANIE GRAMATURY
			$this->db->where('delivery_id', $delivery_id);
			$this->db->limit(1);
			$this->db->delete('delivery_grammage'); 
	
			//START STAREJ
			$this->db->where('delivery_id', $this->input->post('moved_from'));
			$this->db->update('delivery', array('stopped' => '0', 'moved_to' => NULL));
			
			//AKTUALIZACJA WYPELNIENIA GRAMATURY
			$this->delivery->recalculate_grammage_filled($this->data['delivery']->order_id);
			
			//powiadomienie email
			$d = $this->delivery->get_delivery($this->input->post('moved_from'));
			$title = 'F4U - dostawa z dnia ' . $this->data['delivery']->date . ' została przeniesiona';
			$text = '<h2 style="margin-top: 0">Dostawa z dnia ' . $this->data['delivery']->date . ' została przeniesiona z powrotem na dzień ' . $d->date . '!</h2>';
			$message = "<p><a href='".base_url()."cp/delivery'>Zobacz swój kalendarz dostaw</a></p><p>Pozdrawiamy!<br />Fit4You<br/>tel. 515 046 567</p>";
			
			$this->common->send_mail(	$this->user->email, 
										$title, 
										$text,
										$message,
										$this->data['config']->contact_email, 
										$this->data['config']->name
									);
									
			//powiadomienie konrada						
			$title = 'F4U - ' . $this->user->name_surname . ' zmienił termin dostawy';
			$text = '<h2 style="margin-top: 0">Dostawa dla użytkownika ' . $this->user->name_surname . ' z dnia ' . $this->data['delivery']->date . ' została przeniesiona na dzień ' . $d->date . '!</h2>';
			$message = "<p><a href='".base_url()."admin/user/details/".$this->user->user_id."'>Zobacz kalendarz dostaw użytkownika</a></p><p>Pozdrawiamy!<br />Fit4You<br/>tel. 515 046 567</p>";
			
			$this->common->send_mail(	'konrad@fit4you.pl', 
										$title, 
										$text,
										$message,
										$this->data['config']->contact_email, 
										$this->data['config']->name
									);
									
			$this->common->send_mail(	'kucharzdostawca@fit4you.pl', 
										$title, 
										$text,
										$message,
										$this->data['config']->contact_email, 
										$this->data['config']->name
									);
			
			
			$this->session->set_flashdata('message', 'Dostawa została przeniesiona na wybrany dzień!'); 
			redirect(base_url() . 'cp/delivery');
			
		}

		//ZAPIS EDYCJI
		if($this->input->post('save') == 1) {
			
			$data = array(
			
				'name_surname' => $this->input->post('name_surname'),
				'address' => $this->input->post('address'),
				'postcode' => $this->input->post('postcode'),
				'city' => $this->input->post('city'),
				'phone' => $this->input->post('phone'),
				'hours' => $this->input->post('hours'),
				'user_notice' => $this->input->post('user_notice'),
					
			);
			$this->db->where('delivery_id', $delivery_id);
			$this->db->update('delivery', $data); 
			
			//uwagi dla kolejnych dostaw
			if($this->input->post('user_notice_remember') == 1) {
				
				$start_date = $this->data['delivery']->date;
								
				$this->db->where('date >', $start_date);
				$this->db->where('user_id', $this->data['delivery']->user_id);
				$this->db->update('delivery', array('user_notice' => $this->input->post('user_notice'))); 
				
			}
			
			$this->session->set_flashdata('message', 'Adres dostawy został zaaktualizowany!'); 
			redirect(base_url() . 'cp/delivery/update/' . $delivery_id);
			
		}

		//WOLNE DNI DLA ZMIANY TERMINU DOSTAWY
		$all_deliveries = set_array_keys($this->delivery->get_deliveries(FALSE, $delivery->order_id), 'date');
		$free_days = array();
		
		//ostatni nieprzeniesiony dzien z TEGO zamowienia
		$order = $this->order->get_order($delivery->order_id);
		$this->db->select('*');
		$this->db->from('delivery');
		$this->db->where('order_id', $order->order_id);
		$this->db->where('moved_from', NULL);
		$this->db->order_by('date', 'desc');
		$this->db->limit(1);
		$q = $this->db->get();
		$d = $q->row();
		
		//generuje zakres
		$date_limit = date("Y-m-d", strtotime("+30 days", strtotime($d->date)));
		$date = date("Y-m-d", strtotime("+3 days"));
		while(strtotime($date) <= strtotime($date_limit)) {
			if(!$this->delivery->delivery_exist(FALSE, $date, $this->user->user_id)) {
				$free_days[$date] = $date; 		
			}
			$date = date("Y-m-d", strtotime("+1 days", strtotime($date)));
		}
		$this->data['free_days'] = $free_days;
		
		$this->data['template'] = $this->load->view('cp/delivery/update', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	 
	public function read($date, $pay = FALSE) {
		
		$user_id = $this->user->user_id;

		$this->data['delivery'] = $this->delivery->get_delivery_by_date($user_id, $date);
		$this->data['order'] = $this->order->get_order(reset($this->data['delivery'])->order_id);
		
		//$this->data['user_packets'] = $this->packet->get_user_packets($this->user->user_id);
		$this->data['user_packets'] = $this->packet->get_user_packets($user_id, end($this->data['delivery'])->packet_id);
		
		$this->data['dotpay_url'] = $this->order->create_dotpay_url($this->data['order']);
		$this->data['date'] = $date;
		$this->data['pay'] = $pay;
				
		echo $this->load->view('cp/delivery/read', $this->data, true);
		
	}


	public function change_address() {
		
		$this->data['template'] = $this->load->view('cp/delivery/change_address', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}

}

/* End of file */
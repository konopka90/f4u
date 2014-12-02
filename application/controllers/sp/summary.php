<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Summary extends Sp {

	public function __construct() {
		parent::__construct();
	}
	
	public function index($client_id = FALSE) {
		
		//Pobieram klientów
		$this->data['clients'] = $clients = set_array_keys($this->seller->get_clients($this->user->user_id), 'user_id');
		
		
		
		//Domyślnie
		if(empty($client_id)) {
			
			if(!$this->session->userdata('client_id')) {
				$client_id = reset($clients)->user_id;	
				$this->session->set_userdata('client_id', $client_id);
			} else {
				$client_id = $this->session->userdata('client_id');
			}
	
		}
		$this->session->set_userdata('client_id', $client_id);
	
		//printr($this->session->userdata('client_id'));
	
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

		//Dostawy
		
		$data = $this->delivery->get_deliveries_for_user_calendar($client_id, true, $clients[$client_id]->assigned);
		
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

		//Wszystkie produkty
		$this->data['products'] = set_array_keys($this->table->get_rows('product'), 'product_id');
		//Zamowienia klientow
		$this->data['clients_orders'] = $this->seller->get_clients_orders($this->user->user_id);

		$this->data['template'] = $this->load->view('sp/summary/summary', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
	public function create() {
		
		
		$this->data['access'] = 'seller';
		$this->data['template'] = $this->load->view('admin/user/create', $this->data, true);
		$this->load->view('cp/index', $this->data);
			
	}
	
	 
		
	public function read($date, $pay = FALSE) {
		
		if($this->input->post('user_id')) {
			$user_id = $this->input->post('user_id');	
		} else {
			$user_id = $this->user->user_id;
		}
		
		$this->data['delivery'] = $this->delivery->get_delivery_by_date($user_id, $date);
		$this->data['order'] = $this->order->get_order(reset($this->data['delivery'])->order_id);
		
		//$this->data['user_packets'] = $this->packet->get_user_packets($this->user->user_id);
		$this->data['user_packets'] = $this->packet->get_user_packets($user_id, end($this->data['delivery'])->packet_id);
		$this->data['controler'] = $this->input->post('controler');	
		
		$this->data['date'] = $date;
		$this->data['pay'] = $pay;
				
		echo $this->load->view('sp/summary/read', $this->data, true);
		
	}



	public function change_address() {
		
		$this->data['template'] = $this->load->view('cp/delivery/change_address', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}

}

/* End of file */
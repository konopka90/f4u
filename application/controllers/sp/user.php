<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Sp {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		
		$this->data['users'] = $this->seller->get_clients($this->user->user_id);
		
		$this->data['template'] = $this->load->view('sp/user/user', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	public function create() {
		
		$this->data['access'] = 'seller';
		$this->data['template'] = $this->load->view('admin/user/create', $this->data, true);
		$this->load->view('cp/index', $this->data);
			
	}


	public function details($user_id) {
	
		//USER
		$this->data['usera'] = $this->table->get_row('user', array('user_id' => $user_id));
		
		//KLIENT
		$client = $this->seller->get_clients($this->user->user_id, false, $user_id);
	
		//CATERING
		$this->data['user_orders'] = $this->order->get_all_orders(array('up.packet_id IS NOT NULL', 'o.user_id' => $user_id, 'o.date >= ' => '"'.$client->assigned.'"'), true);
		
		//Wszystkie produkty
		$this->data['products'] = set_array_keys($this->table->get_rows('product'), 'product_id');
		
		//KALENDARZE
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
		$data = $this->delivery->get_deliveries_for_user_calendar($user_id, true, $client->assigned);

		$this->data['calendar_curr'] = $this->calendar->generate(date("Y"), date("n"), $data[date("Y")][date("n")]);
		$next_month = strtotime("+1 month");
		$this->data['calendar_next'] = $this->calendar->generate(date("Y", $next_month), date("n", $next_month), $data[date("Y", $next_month)][date("n", $next_month)]);
		$next_month_2 = strtotime("+2 month");
		$this->data['calendar_next_2'] = $this->calendar->generate(date("Y", $next_month_2), date("n", $next_month_2), $data[date("Y", $next_month_2)][date("n", $next_month_2)]);

		$this->data['access'] = 'seller';
		$this->data['template'] = $this->load->view('admin/user/details', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
	
	public function update($user_id) {
		
		$this->data['update_user'] = $this->table->get_row('user', array('user_id' => $user_id));
		
		$this->data['access'] = 'seller';
		$this->data['template'] = $this->load->view('admin/user/create', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	public function remove($user_id) {
	
		redirect(		base_url() . 'admin/user/remove/' . $user_id .'/'. 		base64_encode(base_url() . 'sp/user')		);
		
	}

}

/* End of file */
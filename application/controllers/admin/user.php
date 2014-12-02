<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Admin {

	public function __construct() {
		parent::__construct();
		
		//sprawdza poziom
		if($this->user->access < 5) {
			redirect(base_url().  "admin");	
		}
		
	}
	
	public function index() {
		
		$this->data['users'] = $this->table->get_rows('user', array(), FALSE, array('user_id', 'DESC'));
		
		//email kontaktowy
		if($this->input->post('send_email') == 1) {

			$name = explode(' ', $this->data['users']->name_surname);
			$title = 'F4U - kontakt z administratorem!';
			$text = '<h2 style="margin-top: 0">Kontaktujemy się z Tobą ponieważ...</h2>';
			$message = $this->input->post('text') . "<p style='background: #f2f2f2;padding: 10px'>Napisał <strong>".$this->user->name_surname."</strong>, jego email to <strong>" . $this->user->email . "</strong>.</p><p>Pozdrawiamy!<br />Fit4You<br/>tel. 515 046 567</p>";
			
			$this->common->send_mail(	$this->input->post('email'), 
										$title, 
										$text,
										$message,
										$this->data['config']->contact_email, 
										$this->data['config']->name
									);
			//kopia do mnie
			if($this->input->post('copy') == 1) {
				$this->common->send_mail(	$this->user->email, 
											$title, 
											$text,
											$message,
											$this->data['config']->contact_email, 
											$this->data['config']->name
										);
			}
									
			$this->session->set_flashdata('message', 'Zrobione! Email został wysłany.'); 
			
			if($this->input->post('controler') == 'user_details') {
				redirect(base_url() . 'admin/user/details/' . $this->input->post('user_id'));
			} else {
				redirect(current_url());	
			}
		}
		
		$this->data['template'] = $this->load->view('admin/user/user', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}

	public function create() {

		if($this->input->post('save') == 1 || $this->input->post('save_and_order') == 1 || $this->input->post('save_client_and_order') == 1 || $this->input->post('save_client') == 1) {
			
			//czy hasła takie same
			if($this->input->post('password') != $this->input->post('password_repeated')) {
				$this->session->set_flashdata('message', 'Hasła nie są identyczne!'); 	
				redirect(base_url() . 'admin/user/create');	
			}
			
			//czy email unikatowy
			if($this->usera->email_exist($this->input->post('email'))) {
				$this->session->set_flashdata('message', 'Podany adres email juz jest w naszej bazie. Nie możesz dodać kolejnego użytkownika z takim adresem email.'); 	
				redirect(base_url() . 'admin/user/create');	
			}
			
			//zapisuje usera
			$user = array(
			
				'access' => (($this->input->post('access'))?$this->input->post('access'):'1'),
				'password_to_change' => (($this->input->post('password_to_change'))?$this->input->post('password_to_change'):'0'),
				'is_seller' => (($this->input->post('is_seller'))?$this->input->post('is_seller'):'0'),
				'seller_provision' => (($this->input->post('seller_provision'))?$this->input->post('seller_provision'):'0'),
				'account_number' => (($this->input->post('account_number'))?$this->input->post('account_number'):''),
			
				'name_surname' => $this->input->post('name_surname'),
				'address' => $this->input->post('address'),
				'postcode' => $this->input->post('postcode'),
				'city' => $this->input->post('city'),
				'phone' => $this->input->post('phone'),
				'skype' => $this->input->post('skype'),
				'user_notice' => $this->input->post('user_notice'),
				
				'email' => $this->input->post('email'),
				'password' => sha1($this->input->post('password')),

				'joined' => $this->input->post('joined'),
					
			);
			$this->db->insert('user', $user); 
			$user_id = $this->db->insert_id();
			
			//Przypisuje do partnera
			if(($this->input->post('save_client_and_order') == 1 || $this->input->post('save_client') == 1) && $this->input->post('seller_id')) {
				$seller_user_order_data = array(
					'seller_id' => $this->input->post('seller_id'),
					'user_id' => $user_id,
					'mode' => 'user'
				);
				$this->db->insert('seller_user_order', $seller_user_order_data); 
			}
			
			$this->session->set_flashdata('adding_user', '1'); 
			
			if($this->input->post('save_and_order')) {
				redirect(base_url() . 'admin/order/create/' . $user_id);	
			} elseif($this->input->post('save')) {
				redirect(base_url() . 'admin/user');
				
			} elseif($this->input->post('save_client_and_order')) {
				redirect(base_url() . 'sp/summary/create_order/' . $user_id);	
			} elseif($this->input->post('save_client')) {
				redirect(base_url() . 'sp/summary');	
			}
			
		}
	
		$this->data['template'] = $this->load->view('admin/user/create', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
	public function update($user_id) {
		
		$this->data['update_user'] = $this->table->get_row('user', array('user_id' => $user_id));
		
		if($this->input->post('save') == 1 || $this->input->post('save_and_order') == 1 || $this->input->post('save_client') == 1 || $this->input->post('save_client_and_order') == 1) {
			
			//czy hasła takie same
			if($this->input->post('password') && $this->input->post('password_repeated') && $this->input->post('password') != $this->input->post('password_repeated')) {
				$this->session->set_flashdata('message', 'Hasła nie są identyczne!'); 	
				redirect(base_url() . 'admin/user/update/' . $user_id);	
			}
			
			//czy email unikatowy
			if($this->usera->email_exist($this->input->post('email'), $this->data['update_user']->email)) {
				$this->session->set_flashdata('message', 'Podany adres email juz jest w naszej bazie.'); 	
				redirect(base_url() . 'admin/user/update/' . $user_id);	
			}
			
			//zapisuje usera
			$user = array(
			
				'access' => $this->input->post('access'),
				'is_seller' => (($this->input->post('is_seller'))?$this->input->post('is_seller'):'0'),
				'seller_provision' => (($this->input->post('is_seller'))?$this->input->post('seller_provision'):'0'),
				'account_number' => (($this->input->post('account_number'))?$this->input->post('account_number'):''),
				'password_to_change' => (($this->input->post('password_to_change'))?$this->input->post('password_to_change'):'0'),
			
				'name_surname' => $this->input->post('name_surname'),
				'address' => $this->input->post('address'),
				'postcode' => $this->input->post('postcode'),
				'city' => $this->input->post('city'),
				'phone' => $this->input->post('phone'),
				'skype' => $this->input->post('skype'),
				
				'email' => $this->input->post('email'),
				
				'joined' => $this->input->post('joined'),
					
			);
			if($this->input->post('password')) {
				$user = $user + array('password' => sha1($this->input->post('password')));	
			}
			
			$this->db->where('user_id', $user_id);
			$this->db->update('user', $user); 
			
			$this->session->set_flashdata('message', 'Edycja zapisana!'); 	
			
			if($this->input->post('save_and_order')) {
				redirect(base_url() . 'admin/order/create/' . $user_id);	
			} elseif($this->input->post('save')) {
				redirect(base_url() . 'admin/user/update/' . $user_id);		
			} elseif($this->input->post('save_client_and_order')) {
				redirect(base_url() . 'sp/order/create/' . $user_id);	
			} elseif($this->input->post('save_client')) {
				redirect(base_url() . 'sp/user/update/' . $user_id);		
			}

		}
	
		$this->data['template'] = $this->load->view('admin/user/create', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
	public function details($user_id) {
	
		//USER
		$this->data['usera'] = $this->table->get_row('user', array('user_id' => $user_id));
	
		//CATERING
		$this->data['user_orders'] = $this->order->get_all_orders(array('up.packet_id IS NOT NULL', 'o.user_id' => $user_id), true);
		
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
		$data = $this->delivery->get_deliveries_for_user_calendar($user_id);

		$this->data['calendar_curr'] = $this->calendar->generate(date("Y"), date("n"), $data[date("Y")][date("n")]);
		$next_month = strtotime("+1 month");
		$this->data['calendar_next'] = $this->calendar->generate(date("Y", $next_month), date("n", $next_month), $data[date("Y", $next_month)][date("n", $next_month)]);
		$next_month_2 = strtotime("+2 month");
		$this->data['calendar_next_2'] = $this->calendar->generate(date("Y", $next_month_2), date("n", $next_month_2), $data[date("Y", $next_month_2)][date("n", $next_month_2)]);
		
		//CONSULTACJE
		$this->data['user_consultations'] = $this->order->get_consultations_with_products(array('o.user_id' => $user_id));
	
		$this->data['template'] = $this->load->view('admin/user/details', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	
	public function remove($user_id, $redirect = false) {
		
		$data = array('status' => '0');
		
		//user
		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data); 
		
		$orders = $this->table->get_rows('order', array('user_id' => $user_id));
		
		foreach($orders as $i => $order) {
			//zamowienie
			$this->db->where('order_id', $order->order_id);
			$this->db->update('order', $data); 
			
			
			$this->db->where('order_id', $order->order_id);
			$this->db->update('delivery', $data);
			
			
			$this->db->where('order_id', $order->order_id);
			$this->db->update('delivery_grammage', $data); 
			
			
			$this->db->where('order_id', $order->order_id);
			$this->db->update('order_form', $data); 
			
			
			$this->db->where('order_id', $order->order_id);
			$this->db->update('order_product', $data); 
			
			
			$this->db->where('order_id', $order->order_id);
			$this->db->update('user_packets', $data); 
		}

		if($redirect) {
			redirect(base64_decode($redirect));	
		} else {
			redirect(base_url() . 'admin/user');
		}
		
	}
	
	
	public function message($user_id) {
	
		$this->data['usera'] = $this->table->get_row('user', array('user_id' => $user_id));
	
		echo $this->load->view('admin/user/message', $this->data, true);	
		
	}
	
}
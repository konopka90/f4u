<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Root {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		
		$this->data['template'] = $this->load->view('about_us', $this->data, true);
		$this->load->view('index', $this->data);
		
	}
	
	
	public function any($link) {

		//ktore to link komunikat strona? reszte odrzucam
		//np. http://beta.signsfactory.co.uk/news/tournaments/page/34/message/no_users_in_database
		$link = $page = array();
		foreach($segments = $this->uri->segment_array() as $i => $s) {

			if(in_array(@$segments[$i - 1], array('p'))) { //strone zawsze poprzedza 'page'
				array_push($page, $s);		
			} elseif(!in_array($s, array('p', 'page')) && !is_numeric($s)) { //czyli reszta
				array_push($link, $s);	
			}

		}
		$link = implode('/', $link);
		$page = implode('/', $page);

		///...DALEJ
		//pobieram info o stronie zeby zaladowac wlasciwy szablon
		$this->data['page'] = $this->table->get_row('structure', array('publication' => '1', 'link' => $link), FALSE);
		if(empty($this->data['page'])) {
			show_404();
		} else {
			$this->data['page_elements'] = $this->table->get_elements('structure', $this->data['page']->structure_id);
			$this->data['page_elements_photos'] = $this->table->get_photos('structure', $this->data['page']->structure_id);
		}
		
		//breadcrumbsy
		//$this->data['breadcrumb'] = $this->tree->get_breadcrumb('structure', $link);
		
		//inkrementacja wyswietleń
		$this->db->where('structure_id', $this->data['page']->structure_id);
		$this->db->set('views', 'views + 1', FALSE);
		$this->db->update('structure');
		
		//laduje szablon
		if($this->data['page']->template == 1) {	//DYNAMICZNY

			$this->data['template'] = $this->load->view('dynamic', $this->data, true);
			
		} elseif($this->data['page']->template == 2) {	//DYNAMICZNY Z PANELEM
			
			$this->dynamic();
			
		} elseif($this->data['page']->template == 3) {	//ORDER
			
			//if(in_array($this->user->user_id, array(12, 35, 36, 102))) {
				$this->order_new();	
			//} else {
			//	$this->order();
			//}
			
		} elseif($this->data['page']->template == 4) {	//KONTAKT
		
			$this->contact();
		
		} elseif($this->data['page']->template == 5) {	//CENNIK
		
			$this->pricing();
		
		} elseif($this->data['page']->template == 6) {	//O NAS
		
			$this->data['template'] = $this->load->view('about_us', $this->data, true);
		
		}
		elseif($this->data['page']->template == 7) {	// FITLAB
		
			$this->data['template'] = $this->load->view('fitlab', $this->data, true);
		
		}
		
		$this->load->view('index', $this->data);
		
	}

	public function order_new($make_order = FALSE, $diet = FALSE) {
		
		//To chyba nie bedzie potrzebne
		$this->data['products'] = $products = $this->packet->get_catering_products();
		
		//Ustawiam wybrana diete
		if(!empty($diet)) {
			$diet = offer_values($diet);
		} else {
			$diet = FALSE;
		}
		
		if($make_order == 'make_order') {
			
			//dni i cena
			$product = $this->table->get_row('product', array('product_id' => $this->input->post('product_id')));
			$product->days = count($this->input->post('days_selected'));
			$product->days_selected = $this->input->post('days_selected');
			$product->price = $product->price_for_day * $product->days;
			
			$product->meals_selected = serialize($this->input->post('meals_selected'));
			
			$product->meals_selected_unserialized = $this->input->post('meals_selected');
			//zapisuje
			$this->session->unset_userdata('order_product');
			$this->session->set_userdata(array('order_product'  => $product));

			//formularz
			$prefs = array (
						   'start_day'    => 'monday',
						   'month_type'   => 'long',
						   'day_type'     => 'short'
						 );			 
			$prefs['template'] = '
			
			   {table_open}<table class="table table-condensed">{/table_open}
			
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
			   {cal_cell_content_today}{template}{/cal_cell_content_today}
			
			   {cal_cell_no_content}{day}{/cal_cell_no_content}
			   {cal_cell_no_content_today}<div class="today">{day}</div>{/cal_cell_no_content_today}
			
			   {cal_cell_blank}&nbsp;{/cal_cell_blank}
			
			   {cal_cell_end}</td>{/cal_cell_end}
			   {cal_row_end}</tr>{/cal_row_end}
			
			   {table_close}</table>{/table_close}
			';
			$this->load->library('calendar', $prefs);

			//dane do formularza
			$this->data['order_product'] = $order_product = $this->session->userdata('order_product');
		
			//DNI DOSTAW
			// w $order_product nadpisuje kilka rzeczy dzieki czemu mam tylko jeden argument
			$deliveries = $this->delivery->get_deliveries_for_order_calendar_new($order_product);
			$data = $deliveries['both'];
			
			
			if(count($data[date("Y")][date("n")]) > 0) {
				$this->data['calendars'][0] = $this->calendar->generate(date("Y"), date("n"), $data[date("Y")][date("n")]);	
			}
			//miesiac do przodu
			$next_month = strtotime("+1 month");
			if(count($data[date("Y", $next_month)][date("n", $next_month)]) > 0) {
				$this->data['calendars'][1] = $this->calendar->generate(date("Y", $next_month), date("n", $next_month), $data[date("Y", $next_month)][date("n", $next_month)]);	
			
			}
			//2 miechy do przodu
			$next_month_2 = strtotime("+2 month");
			if(count($data[date("Y", $next_month_2)][date("n", $next_month_2)]) > 0) {
				$this->data['calendars'][2] = $this->calendar->generate(date("Y", $next_month_2), date("n", $next_month_2), $data[date("Y", $next_month_2)][date("n", $next_month_2)]);	
			}
			//3 miechy do przodu
			$next_month_3 = strtotime("+3 month");
			if(count($data[date("Y", $next_month_3)][date("n", $next_month_3)]) > 0) {
				$this->data['calendars'][3] = $this->calendar->generate(date("Y", $next_month_3), date("n", $next_month_3), $data[date("Y", $next_month_3)][date("n", $next_month_3)]);	
			}
			//4 miechy do przodu
			$next_month_4 = strtotime("+4 month");
			if(count($data[date("Y", $next_month_4)][date("n", $next_month_4)]) > 0) {
				$this->data['calendars'][4] = $this->calendar->generate(date("Y", $next_month_4), date("n", $next_month_4), $data[date("Y", $next_month_4)][date("n", $next_month_4)]);	
			}
			//5 miechy do przodu
			$next_month_5 = strtotime("+5 month");
			if(count($data[date("Y", $next_month_5)][date("n", $next_month_5)]) > 0) {
				$this->data['calendars'][5] = $this->calendar->generate(date("Y", $next_month_5), date("n", $next_month_5), $data[date("Y", $next_month_5)][date("n", $next_month_5)]);	
			}
			
			//wysylka do sesji
			$this->session->unset_userdata('order_delivery');
			$this->session->set_userdata(array('order_delivery' => $deliveries['deliveries']));
			/**/

			$this->firephp->log($this->session->userdata('order_delivery'));
			$this->firephp->log($this->session->userdata('order_product'));
			
			//anty refresh
			$this->session->set_userdata('order_form_hash', uniqid());
			
			echo $this->load->view('order/form', $this->data, true);
			
			return;
			
		}
		
		$this->data['template'] = $this->load->view('order/order_new', $this->data, true);
		
		
	}

	public function order($change = FALSE, $packet_meals_per_day = FALSE, $packet_days = FALSE) {
		
		//wez nazwy pakietów
		$this->data['products'] = $this->packet->get_catering_products();
		$this->data['first_avalible_day'] = $this->delivery->get_first_avalible_day_for_order_calendar();
		
		//wez pakiet coraz bardziej
		if($change == 'change_packet') {
			
			if($packet_days != 'null' && $packet_meals_per_day != 'null') {
				
				$product_id = $packet_meals_per_day;
				$product = $this->table->get_row('product', array('product_id' => $product_id));
				$product->days = $packet_days;
				$product->meals_selected = serialize($this->input->post('meals_selected'));
				$product->meals_selected_unserialized = $this->input->post('meals_selected');
				$product->price = $product->price_for_day * $packet_days;
				
				//zapisuje
				$this->session->unset_userdata('order_product');
				$this->session->set_userdata(array('order_product'  => $product));
				
				//INFO
				$data = array(	'days' => $packet_days,
								'free_days' => $packet_days,
								'price_for_day' => $product->price_for_day,
								'price' => $product->price,
								);
				
				echo json_encode($data);	
				
					
			} elseif($packet_meals_per_day != 'null') {
				
				echo json_encode(true);		
				
			}
			
			return;
			
			
		} elseif($change == 'form') {

			//kalendarz
			$prefs = array (
						   'start_day'    => 'monday',
						   'month_type'   => 'long',
						   'day_type'     => 'short'
						 );			 
			$prefs['template'] = '
			
			   {table_open}<table class="table table-condensed">{/table_open}
			
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
			   {cal_cell_content_today}{template}{/cal_cell_content_today}
			
			   {cal_cell_no_content}{day}{/cal_cell_no_content}
			   {cal_cell_no_content_today}<div class="today">{day}</div>{/cal_cell_no_content_today}
			
			   {cal_cell_blank}&nbsp;{/cal_cell_blank}
			
			   {cal_cell_end}</td>{/cal_cell_end}
			   {cal_row_end}</tr>{/cal_row_end}
			
			   {table_close}</table>{/table_close}
			';
			$this->load->library('calendar', $prefs);

			
			//dane do formularza
			$this->data['order_product'] = $order_product = $this->session->userdata('order_product');
		
			//DNI DOSTAW
			// w $order_product->days nadpisuje liczbe wybranych rpzez usera dni
			$data = $this->delivery->get_deliveries_for_order_calendar(date("Y"), date("n"), $order_product, $this->input->post('delivery_start_date'));
			
			if(count($data[date("Y")][date("n")]) > 0) {
				$this->data['calendars'][0] = $this->calendar->generate(date("Y"), date("n"), $data[date("Y")][date("n")]);	
			}
			//miesiac do przodu
			$next_month = strtotime("+1 month");
			if(count($data[date("Y", $next_month)][date("n", $next_month)]) > 0) {
				$this->data['calendars'][1] = $this->calendar->generate(date("Y", $next_month), date("n", $next_month), $data[date("Y", $next_month)][date("n", $next_month)]);	
			
			}
			//2 miechy do przodu
			$next_month_2 = strtotime("+2 month");
			if(count($data[date("Y", $next_month_2)][date("n", $next_month_2)]) > 0) {
				$this->data['calendars'][2] = $this->calendar->generate(date("Y", $next_month_2), date("n", $next_month_2), $data[date("Y", $next_month_2)][date("n", $next_month_2)]);	
			}
			//3 miechy do przodu
			$next_month_3 = strtotime("+3 month");
			if(count($data[date("Y", $next_month_3)][date("n", $next_month_3)]) > 0) {
				$this->data['calendars'][3] = $this->calendar->generate(date("Y", $next_month_3), date("n", $next_month_3), $data[date("Y", $next_month_3)][date("n", $next_month_3)]);	
			}
			//4 miechy do przodu
			$next_month_4 = strtotime("+4 month");
			if(count($data[date("Y", $next_month_4)][date("n", $next_month_4)]) > 0) {
				$this->data['calendars'][4] = $this->calendar->generate(date("Y", $next_month_4), date("n", $next_month_4), $data[date("Y", $next_month_4)][date("n", $next_month_4)]);	
			}
			//5 miechy do przodu
			$next_month_5 = strtotime("+5 month");
			if(count($data[date("Y", $next_month_5)][date("n", $next_month_5)]) > 0) {
				$this->data['calendars'][5] = $this->calendar->generate(date("Y", $next_month_5), date("n", $next_month_5), $data[date("Y", $next_month_5)][date("n", $next_month_5)]);	
			}
			
			//wysylka do sesji
			$this->session->unset_userdata('order_delivery');
			$this->session->set_userdata(array('order_delivery' => $data));
			/**/
			
			
			$this->firephp->log($this->session->userdata('order_delivery'));
			$this->firephp->log($this->session->userdata('order_product'));
			
			//anty refresh
			$this->session->set_userdata('order_form_hash', uniqid());
			
			echo $this->load->view('order/form', $this->data, true);
			
			return;
			
		}

		$this->data['template'] = $this->load->view('order/order', $this->data, true);

	}
	
	
	public function contact() {

		
		//wyslij maila kontaktowego
		if($this->input->post()) {

			$name = explode(' ', $this->input->post('name_surname'));
			$title = 'F4U - ' . reset($name) . ' chce się z Tobą skontaktować!';
			$text = '<h2 style="margin-top: 0">' . reset($name) . ' skorzystał z formularza kontaktowego i napisał:</h2>';
			$message = "<p style='background: #f2f2f2;padding: 10px'>" . nl2br($this->input->post('text')) . "</p><p>Jego adres email to: <strong>" . $this->input->post('email') . "</strong>. Nie czekaj i odpowiedz na pytanie!</p><p>Pozdrawiamy!<br />Fit4You<br/>tel. 515 046 567</p>";
			
			$this->common->send_mail(	$this->data['config']->contact_email, 
										$title, 
										$text,
										$message,
										$this->input->post('email'), 
										$this->input->post('name_surname')
									);
									
			$this->session->set_flashdata('message', 'Zrobione! Email kontaktowy został wysłany, niedługo się z Tobą skontaktujemy.'); 
			
			redirect(current_url());
		}
		
		/*
		$this->firephp->log($this->session->userdata);
		printr($this->session->flashdata);
		printr($this->session->flashdata('message'));
		/**/
		
		$this->data['template'] = $this->load->view('contact', $this->data, true);
		
	}
	
	
	public function pricing() {
		
		/*
		
		$packets = $this->packet->get_packet();
		$result = array();
		foreach($packets_names as $i => $pn) {
			foreach($packets as $p) {
				if($pn->name == $p->name) {
					$result[$pn->name][$p->weeks][$p->days_per_week][$p->meals_per_day] = $p;
				}
			}
		}
		
		$this->data['packets'] = $result;
		/*
		printr($result);
		printr($this->data['packets_names']);
		printr($this->data['packets']);
		/**/
		$this->data['packets'] = $this->packet->get_catering_products();
		
		if(true /*in_array($this->user->user_id, array(12, 36, 102))*/) {
			$this->data['template'] = $this->load->view('pricing_new', $this->data, true);
		} else {
			$this->data['template'] = $this->load->view('pricing', $this->data, true);
		}
	}
	
	

	
	public function search($keyword = FALSE, $search_in_structure = FALSE, $search_in_articles = FALSE, $search_in_offer = FALSE) {
	
		//FRIENDLY URL
		if($this->input->post('search')) {
			
			$keyword = $this->input->post('keyword');
			$search_in_structure = $this->input->post('search_in_structure');
			$search_in_articles = $this->input->post('search_in_articles');
			$search_in_offer = $this->input->post('search_in_offer');
			
			redirect(base_url() . 'search/' . "$keyword/$search_in_structure/$search_in_articles/$search_in_offer", 'location', 301);
		}
		
		$search_results = array();
		
		if($keyword) {
		
			$this->data['lang'] = $lang = $this->session->userdata('lang');
			$search_in_structure_array = $search_in_articles_array = $search_in_offer_1_array = $search_in_offer_2_array = array();
		
			if($search_in_structure) {
				$search_in_structure_array = $this->table->search('struktura', $keyword, array('tytul'), array('publikacja' => '1', 'jezyk' => $lang));	
			}
			
			if($search_in_articles) {
				$search_in_articles_array = $this->table->search('artykul', $keyword, array('tytul'), array('publikacja' => '1', 'jezyk' => $lang));	
			}
			if($search_in_offer) {
				$search_in_offer_1_array = $this->table->search('produktkategoria', $keyword, array("tytul_$lang"));	
				$search_in_offer_2_array =  $this->table->search('produkt', $keyword, array("tytul"), array('publikacja' => '1', 'jezyk' => $lang));	
			}

			$search_results = array_merge($search_in_structure_array, $search_in_articles_array, $search_in_offer_1_array, $search_in_offer_2_array);
			
		}
	
		$this->data['keyword'] = $keyword;
		$this->data['search_in_structure'] = $search_in_structure;
		$this->data['search_in_articles'] = $search_in_articles;
		$this->data['search_in_offer'] = $search_in_offer;
		$this->data['search_results'] = $search_results;
		
		$this->data['template'] = $this->load->view('search', $this->data, true);
		$this->load->view('index', $this->data);
			
	}
	
	public function files($plikId) {
		
		$f = $this->table->get_row('plik', array('status' => '1', 'plikId' => $plikId));
		
		$this->load->helper('file');
		$this->load->helper('download');

		if(!empty($f) && file_exists(FCPATH . 'files/' . $f->plik)) { 
		
			force_download($f->plik, read_file(FCPATH . 'files/' . $f->plik)); 
			
		} else {

			show_404();
		
		}
			
	}
	
	public function change_language($language = 'english') {
		
		switch($language) {
			case 'polish':
				$this->session->set_userdata(array('language' => 'polish'));
				$this->session->set_userdata(array('lang' => 'pl'));
				break;
			default:
				$this->session->set_userdata(array('language' => 'english'));
				$this->session->set_userdata(array('lang' => 'en'));
		}

		redirect(base_url());
		
	}
	
	
	public function save_to_newsletter() {
		
		//save to newsletter
		if($this->input->post('email')) {
			
			//sprawdzam czy juz nie jest zapisany
			$this->db->select('newslettermailId');
			$this->db->from('newslettermail');
			$this->db->where('adresMail', $this->input->post('email'));
			$this->db->where('status', '1');

			$query = $this->db->get();
									
			if($query->num_rows() > 0) {
			
				//jest już zapisany
				$this->data['newsletter_message'] = lang('main_This_email_exist_in_database');
				$this->data['newsletter_message_status'] = 1;
				
			} else {	
			
				$data = array(	'adresMail' => $this->input->post('email'),
								'dopisal' => date("Y-m-d H:i:s"));	
								
				$this->db->insert('newslettermail', $data);
				
				$this->data['newsletter_message'] = lang('main_You_have_been_saved_to_newsletter');
				$this->data['newsletter_message_status'] = 3;
				
			}
			
			echo json_encode(array('message' => $this->load->view('_elements/message', array('message' => $this->data['newsletter_message'], 'message_status' => $this->data['newsletter_message_status']), true), 'status' => $this->data['newsletter_message_status']));
			return;
		}
		
		echo json_encode(array('message' => $this->load->view('_elements/message', array('message' => lang('main_You_dont_filled_all_fields'), 'message_status' => 1), true), 'status' => 1));
			
	}
	
	
	public function unsubscribe_newsletter($email) {

		$this->db->where('email', base64_decode($email));
		$this->db->update('newsletter_emails', array('removed' => date("Y-m-d H:i:s")));
				
		redirect(base_url() . 'page');				
			
	}
	
	
		
	
	//FOR ORDER CALENDAR
	public function calendar($date, $user_id = FALSE) {
		
		$datetime = strtotime($date);
		$date = date("Y-m-d", $datetime);

		if($user_id) {
			$user_id;	
		} else {
			//NIEZALOGOWANY	
		}
		
		$prefs = array (
						'start_day'    => 'monday',
						'month_type'   => 'long',
						'day_type'     => 'short'
						);				 			
					 	 
		$prefs['template'] = '	
		   {table_open}<table class="table table-condensed table-bordered delivery_calendar text-center margin_b_0">{/table_open}
		
			   {heading_row_start}<tr>{/heading_row_start}
			
			   {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
			   {heading_title_cell}<th colspan="{colspan}" class="bg_success text-center">{heading}</th>{/heading_title_cell}
			   {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
			
			   {heading_row_end}</tr>{/heading_row_end}
			
			   {week_row_start}<tr>{/week_row_start}
			   {week_day_cell}<td class="bg_line" style="width: '.(100/7).'%">{week_day}</td>{/week_day_cell}
			   {week_row_end}</tr>{/week_row_end}
			
			   {cal_row_start}<tr>{/cal_row_start}
			   {cal_cell_start}<td>{/cal_cell_start}
			
			   {cal_cell_content}<span class="muted disabled tooltipa" title="W ten dzień już jest dostawa!">{day}</span>{/cal_cell_content}
			   {cal_cell_content_today}<div class="muted disabled tooltipa" title="W ten dzień już jest dostawa!">{day}</div>{/cal_cell_content_today}
			
			   {cal_cell_no_content}<span class="free pointer" data-date="{year}-{month}-{day}" id="delivery_calendar_day_{year}-{month}-{day}">{day}</span>{/cal_cell_no_content}
			   {cal_cell_no_content_today}<div class="today pointer"><span class="free" data-date="{year}-{month}-{day}" id="delivery_calendar_day_{year}-{month}-{day}">{day}</span></div>{/cal_cell_no_content_today}
			
			   {cal_cell_blank}&nbsp;{/cal_cell_blank}
			
			   {cal_cell_end}</td>{/cal_cell_end}
			   {cal_row_end}</tr>{/cal_row_end}
			
		   {table_close}</table>{/table_close}
		';
		$this->load->library('calendar', $prefs);

		//calendarsy
		$data = array();
		if($user_id) {
			$data = $this->delivery->get_deliveries_for_user_calendar($user_id, false);
		}
		
		$calendar = $this->calendar->generate(date("Y", strtotime($date)), date("n", strtotime($date)), $data[date("Y", strtotime($date))][date("n", strtotime($date))]);
		
		echo $calendar;
		
	}

}

/* End of file */
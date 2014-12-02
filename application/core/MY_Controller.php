<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Root extends CI_Controller {
	
	public $data = array();
	public $user = FALSE;
	public $users = array();
	
    public function __construct() {
		
        parent::__construct(); //to robi jakies headersy
		
		//FIRST LANGUAGE
		if(!$this->session->userdata('language') || !$this->session->userdata('lang')) {
			$this->session->set_userdata(array('language' => 'polish'));
			$this->session->set_userdata(array('lang' => 'pl'));
		}
		if($this->session->userdata('language') == 'english') {
			$this->config->set_item('language', 'english');	
		} else {
			$this->config->set_item('language', 'polish');	
		} 
		$this->lang->load('main');
		setlocale( LC_TIME, 'pl_PL.UTF-8' );
		date_default_timezone_set('Europe/Warsaw');

		$this->load->model('M_Common', 'common');
		$this->load->model('M_Table', 'table');
		$this->load->model('M_Tree', 'tree');
		
		$this->load->model('M_Packet', 'packet');
		//$this->load->model('M_Product', 'product');
		$this->load->model('M_Usera', 'usera');
		$this->load->model('M_Delivery', 'delivery');
		$this->load->model('M_Order', 'order');
		$this->load->model('M_Seller', 'seller');
		

		$this->data['message'] = FALSE;
		$this->data['message_status'] = FALSE;
		
		//jesli zalogowany to aktualizuje dane
		$this->user = $this->session->userdata('user');
		$this->data['user'] = $this->user;
		if($this->user) {
			
			//gdzie widziany
			$this->db->where('user_id', $this->user->user_id);
			$this->db->update('user', array('last_seen' => date("Y-m-d H:i:s"), 'last_seen_where' => current_url())); 
			
			//pakiety
			$user_packets = $this->table->get_rows('user_packets', array('user_id' => $this->user->user_id));
			$this->session->set_userdata(array('user_packets' => $user_packets));
			
			//aktywny pakiet
			$user_packets = $this->packet->get_active_user_packet($this->user->user_id);
			$this->data['active_packet'] = $user_packets;

			//najblizsze dostawy
			$this->data['deliveries'] = $this->delivery->get_incoming_deliveries($this->user->user_id);
			$this->data['closest_delivery'] = $this->delivery->get_closest_delivery($this->user->user_id);
		}

		$this->data['config'] = $this->table->get_row('settings');

		//MENU STRONY
		$menu = $this->tree->get_tree('structure', array('publication' => '1', 'in_menu' => '1', 'lang' => $this->session->userdata('lang') ), FALSE, array('order', 'ASC'));
		$menu_tree = create_multidimensional_array('structure_id', 'parent_id', 0, $menu);
		$this->data['menu_tree'] = $menu_tree;

		//$this->firephp->log($this->session->userdata);
		//Bannery
		$this->data['page_banners'] = $this->table->get_photos('banner', '1');
		
		//Wszyscy uzytkownicy
		$users = $this->table->get_rows('user');
		$this->users = set_array_keys($users, 'user_id');
		
    }
	
	public function index() {
		
	}
	

	
	
}


//PANEL KLIENTA
class Cp extends Root {
	
    public function __construct() {
		
        parent::__construct();

		//sprawdza zalogowanie
		if($this->user->access < 1) {
			redirect(base_url().  "cp/login");	
		}
		
		//sprawdza poziom
		if($this->user->access == 4) {
			redirect(base_url().  "admin");	
		}
		
    }
	
	public function index() {
		
	}
	
}


//PANEL PARTNERA
class Sp extends Root {
	
    public function __construct() {
		
        parent::__construct();

		//sprawdza zalogowanie
		if($this->user->access < 1) {
			redirect(base_url().  "cp/login");	
		}
		
		//sprawdza poziom
		if($this->user->access == 4) {
			redirect(base_url().  "admin");	
		}
		
		//PROWIZJA
		$this->data['seller_provision'] = $this->seller->get_saldo($this->user->user_id);
		
    }
	
	public function index() {
		
	}
	
}


//PANEL ADMINA
class Admin extends Root {
	
    public function __construct() {
		
        parent::__construct();
		
		//sprawdza zalogowanie
		if($this->user->access < 1) {
			redirect(base_url().  "admin/login");	
		}
		
		//sprawdza poziom
		if($this->user->access < 3) {
			redirect(base_url().  "cp");	
		}
		
    }
	
	public function index() {
		
	}
	
}
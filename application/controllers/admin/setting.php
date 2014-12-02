<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends Admin {

	public function __construct() {
		parent::__construct();
		
		//sprawdza poziom
		if($this->user->access < 5) {
			redirect(base_url().  "admin");	
		}
		
		
	}
	
	public function index() {
		
		
	}
	
	public function banner() {


		$this->data['page_elements'] = $this->table->get_elements('banner', '1');
		$this->data['page_elements_photos'] = $this->table->get_photos('banner', '1');
		
		$this->data['template'] = $this->load->view('admin/setting/banner', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
}
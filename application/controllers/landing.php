<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends Root {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {

		$this->data['template'] = $this->load->view('landing_page', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}

}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Cp {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {

		//GET ARTICLES
		//$this->data['articles'] = $this->table->get_rows('artykul', array('publikacja' => '1', 'jezyk' => $this->session->userdata('lang')), FALSE, array('dataDodania', 'DESC'), array(3,0));
		
		//GET LAST REALISATION
		//$this->data['last_realisations'] = $this->table->get_rows('realizacja', array('publikacja' => '1'), FALSE, array('pozycja', 'ASC'));

		$this->data['template'] = $this->load->view('cp/home', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}


}

/* End of file */
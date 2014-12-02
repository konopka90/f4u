<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Structure extends Admin {

	public function __construct() {
		
		parent::__construct();
		
		//sprawdza poziom
		if($this->user->access < 5) {
			redirect(base_url().  "admin");	
		}
		
		
   }
	
	public function index() {

		$structure = $this->tree->get_tree('structure', array('status' => '1'), FALSE, array('order', 'ASC'));
		$structure_tree = create_multidimensional_array('structure_id', 'parent_id', 0, $structure);
		$this->data['structure_tree'] = $structure_tree;

		$this->data['template'] = $this->load->view ('admin/structure/structure', $this->data, TRUE);
		$this->load->view('cp/index', $this->data);
		
	}
	
	public function edit($structure_id) {

		$templates = $this->table->get_rows('structure_template', array('status' => '1'));
		$this->data['templates'] = $templates;
		
		$page = $this->table->get_row('structure', array('structure_id' => $structure_id));
		$page_elements = $this->table->get_elements('structure', $structure_id);
		$page_elements_photos = $this->table->get_photos('structure', $id);
		$page_elements_files = $this->table->get_files('structure', $id);
		//$users = $this->user->get_all_id_to_nick();
		$pages = $this->table->get_rows('structure');
		
		$this->data['page'] = $page;
		$this->data['pages'] = $this->table->get_rows('structure', array('status' => '1', 'structure_id !=' => (($structure_id)?$structure_id:0)));
		$this->data['page_elements'] = $page_elements;
		$this->data['page_elements_photos'] = $page_elements_photos;
		$this->data['page_elements_files'] = $page_elements_files;
		$this->data['users'] = $users;

		$this->data['template'] = $this->load->view ('admin/structure/edit', $this->data, TRUE);
		$this->load->view('cp/index', $this->data);
	
	}
	
	public function add() {
		
		$templates = $this->table->get_rows('structure_template', array('status' => '1'));
		$this->data['templates'] = $templates;
		
		$this->db->update('element', array('status' => '0'), array('module' => 'structure', 'module_id' => '0', 'user_id' => $this->user->user_id)); 


		$this->data['page'] = new stdClass();
		$this->data['pages'] = $this->table->get_rows('structure', array('status' => '1', 'structure_id !=' => (($structure_id)?$structure_id:0)));
		$this->data['page_elements'] = new stdClass();
		$this->data['page_elements_photos'] = new stdClass();
		$this->data['page_elements_files'] = new stdClass();
		$this->data['users'] = $users;
									
		$this->data['template'] = $this->load->view ('admin/structure/edit', $this->data, TRUE);
		$this->load->view('cp/index', $this->data);

	}
	
	public function remove($structure_id) {
		
		if($structure_id) {
			$this->db->update('structure', array('status' => '0'), array('structure_id' => $structure_id));	
		}
		
		if($this->input->post('ajax') == true) {
			
			$data = array('id' => $structure_id);
			echo json_encode($data);
				
		} else {
			redirect('admin/structure');
		}

	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
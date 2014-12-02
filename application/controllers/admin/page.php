<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Admin {

	public function __construct() {
		
		parent::__construct();
		
		//sprawdza poziom
		if($this->user->access < 5) {
			redirect(base_url().  "admin");	
		}
		
		
   }
   
	public function update_order() {
		
		//JAKA TABELA?
		if($this->input->post('table')) {
			$table = $this->input->post('table');
		} else {
			$table = 'structure';
		}
		
		//OBROBKA
		$tree = array();
		if(is_array($this->input->post('tree'))) {
			foreach($this->input->post('tree') as $k => $v) {
				if($k != null) {
					if($v['parent_id'] == 'null') {
						$v['parent_id'] = 0;	
					}
					array_push($tree, $v);	
				}
			}
		}
		
		$title_multidimensional_array = create_multidimensional_array('item_id', 'parent_id', 0, $tree);
		$link_array = make_link_structure('item_id', $table, $title_multidimensional_array);
		ksort($link_array);
		
		//LINK
		foreach($link_array as $id => $v) {
			
			$link_ = '';
			foreach($v as $link_id => $link_v) {
				$link_ .= link_exist($link_v, $link_id, $table).'/';	
			}
			$link = rtrim($link_, '/');
			$id_to_link[$link_id] = $link;
			
			//echo $link."\n";
			
		} 
		
		//UPDATE
		if(is_array($tree)) {
			foreach($tree as $order => $v) {
				$this->db->update($table, array(	'order' => $order, 
													'parent_id' => $v['parent_id'], 
													'link' => $id_to_link[(string)$v['item_id']],
													'depth' => $v['depth'] - 1
												), 
												$table . '_id = "'.$v['item_id'].'"'
								); 
				echo $this->db->last_query() . "\n";
			}
		}
		
		return;

	}
	
	
	
	
   
	public function add_element_box() {
		
		$data = array(
		   'module' => $this->input->post('module'),
		   'module_id' => $this->input->post('module_id') ,
		   'type' => $this->input->post('type'),
		);
		
		$this->db->insert('element', $data);
		$element_id = $this->db->insert_id();

		$this->db->insert( $this->input->post('type'), array('element_id' => $element_id));
		$id = $this->db->insert_id();
		
		$data = array(	'element_id' => $element_id, 
						$this->input->post('type').'_id' => $id,
						'id' => $id,
						'data' => $this->load->view('admin/_elements/'.$this->input->post('type').'_box', 
													array('element_id' => $element_id,  $this->input->post('type').'_id' => $id), 
													true
													)
					);
		
		echo json_encode($data);
		
	}
	
	
	public function remove_element($id, $type) {

		if($type == 'text') {
			
			//$this->db->update('element', array('status' => '0'), array('element_id' => end(explode('_', $id)))); 
			$this->db->update('text', array('status' => '0'), array('element_id' => end(explode('_', $id)))); 
			
		} else {
	
			//$this->db->update('element', array('status' => '0'), array('element_id' => $id)); 
			$this->db->update($type, array('status' => '0'), array($type . '_id' => $id)); 

		}
		
		echo json_encode(array('id' => $id, 'type' => $type));
				
	}
	
	
	public function gallery_upload() {
		
		if (!empty($_FILES)) {
			
			$target_folder_original = 'img/upload/original/';
			$target_folder_thumb = 'img/upload/thumb/';
			$target_folder_mini = 'img/upload/mini/';
			$target_folder_medium = 'img/upload/medium/';
			$tmp_filename = $_FILES['Filedata']['name'];
			$tmp_file = $_FILES['Filedata']['tmp_name'];		
			
			$target_filename = convert_accented_characters($tmp_filename);
			$target_path = $_SERVER['DOCUMENT_ROOT'].'/'.$target_folder_original.$target_filename;
	
			$file_types = array('jpg','jpeg','gif','png', 'JPG', 'JPEG', 'GIF', 'PNG');
			$about_file = pathinfo($tmp_filename);
			
			if (in_array($about_file['extension'], $file_types)) {
				
				//zapisuje w oryginale
				move_uploaded_file($tmp_file, $target_path);
				
				//zapisuje mini
				$mini_filename = uniqid().'.'.$about_file['extension'];
				$config['image_library'] = 'gd2';
				$config['source_image'] = $target_path;
				$config['maintain_ratio'] = TRUE;
				$config['quality'] = 100;
				$config['width'] = 150;
				$config['height'] = 1500;
				$config['new_image'] = $target_folder_mini.$mini_filename;
				
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();		

				//zapisuje thumba
				$thumb_filename = uniqid().'.'.$about_file['extension'];
				$config['image_library'] = 'gd2';
				$config['source_image'] = $target_path;
				$config['maintain_ratio'] = TRUE;
				$config['quality'] = 100;
				$config['width'] = 500;
				$config['height'] = 5000;
				$config['new_image'] = $target_folder_thumb.$thumb_filename;
				
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				
					//CROPUJE GO
					$config['image_library'] = 'gd2';
					$config['source_image'] = $target_folder_thumb.$thumb_filename;
					$config['maintain_ratio'] = FALSE;
					$config['quality'] = 100;
					$config['width'] = 250;
					$config['height'] = 250;
					$config['new_image'] = $target_folder_thumb.$thumb_filename;
					
					$this->image_lib->initialize($config);
					$this->image_lib->crop();
				
				//zapisujemy medium
				$medium_filename = uniqid().'.'.$about_file['extension'];
				$config['image_library'] = 'gd2';
				$config['source_image'] = $target_path;
				$config['maintain_ratio'] = TRUE;
				$config['quality'] = 100;
				$config['width'] = 1000;
				$config['height'] = 10000;
				$config['new_image'] = $target_folder_medium.$medium_filename;
				
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				
				$data = array(
				   'gallery_id' => $this->input->post('id'),
				   'original_path' => ltrim($target_folder_original.$target_filename, 'img/'),
				   'thumb_path' => ltrim($target_folder_thumb.$thumb_filename, 'img/'),
				   'medium_path' => ltrim($target_folder_medium.$medium_filename, 'img/'),
				   'mini_path' => ltrim($target_folder_mini.$mini_filename, 'img/'),
				);
				$this->db->insert('photo', $data);
				$insert_id = $this->db->insert_id();
				
				$q = $this->db->get_where('photo', array('photo_id' => $insert_id));
				
				echo $this->load->view('admin/_elements/photo_row', $q->row(), true);
				
			} else {
				echo 'Zły typ pliku';
			}
		}
		//*/	
	}
	
	
	public function save_editor() {
		
		$form = $this->input->post('form_obj');

			
		
		/*
		//save admin history
		$data = array(
					   'user_id' => 1,
					   'title' => 'Zapis edycji modulu `'.$this->input->post('module').'`, nazwa: '.(($form_name)?$form_name:'<i>bez tytułu</i>').'.'
					);
					
		$this->db->insert('admin_action_history', $data); 
		
		$data = array();
		*/			
		//link
		
		if($this->input->post('module') == 'structure') {

			if($form['parent_id'] != 0) {
				
				$page_parent = $this->table->get_row('structure', array('structure_id' => $form['parent_id']));
				
				$this->db->update('structure', array(	'parent_id' => $form['parent_id'], 
														'link' => $page_parent->link . '/' . clean_chars($form['name']),
														'depth' => $page_parent->depth + 1
													), 
												array('structure_id' => $this->input->post('module_id'))
								); 
			} else {
				$this->db->update('structure', array(	'parent_id' => 0, 
														'link' => clean_chars($form['name']),
														'depth' => 0
													), 
												array('structure_id' => $this->input->post('module_id'))
								); 
			}
		}
		
		
		//SAVE FORM FIELDS
		$data = array();
		if(is_array($form)) {
			foreach($form as $name => $value) {
				$data[$name] = $value;
			}
		}
		
		$this->firephp->log($data);
		
		//zapis lub aktualizacja
		if($this->input->post('module_id')) {
			$module_id = $this->input->post('module_id');
			$this->db->update($this->input->post('module'), $data, array($this->input->post('module').'_id' => $module_id)); 
		} else {
			$this->db->insert($this->input->post('module'), $data);
			$module_id = $this->db->insert_id();
			$this->db->update('element', array('module_id' => $module_id), array("module_id" => '0', 'status' => '1'));  
		}
		
		
		$data = array();	
		//save texts
		if(is_array($this->input->post('text_obj'))) {
			foreach($this->input->post('text_obj') as $field => $text) {
				$t = explode('_', $field);
				$data = array( 'text' => $text );
				$this->db->update('text', $data, 'element_id = '.$t[1]); 
			}
		}
		
		/*
		$data = array();	
		//save quotes
		if(is_array($this->input->post('quote_obj'))) {
			foreach($this->input->post('quote_obj') as $i => $v) {
				$data = array('author' => $v['0'], 'quote' => $v['1']);
				$this->db->update('quote', $data, 'quote_id = '.$v['2']); 
			}
		}
		
		$data = array();	
		//save videos
		print_r($this->input->post('video_obj'));
		if(is_array($this->input->post('video_obj'))) {
			foreach($this->input->post('video_obj') as $i => $v) {
				$data = array('url' => $v['0'], 'desc' => $v['1']);
				$this->db->update('video', $data, 'video_id = '.$v['2']); 
			}
		}
		*/

		echo $module_id;

	}
	
	
	public function change_publication($id, $publication) {
		
		if($publication == 1) {
			
			$this->db->update('structure', array('publication' => '0'), array('structure_id' => $id)); 
			echo json_encode(array('publication' => '0'));
			
		} else {
 
			$this->db->update('structure', array('publication' => '1'), array('structure_id' => $id)); 
			echo json_encode(array('publication' => '1'));

		}
		
		
		
	}

	public function update_field() {
		
		$table = $this->input->post('table');
		$field = $this->input->post('field');
		$value = $this->input->post('value');
		$id = $this->input->post('id');
		
		if($table && $field && $value && $id) {
			$this->db->update($table, array($field => $value), array($table . '_id' => $id)); 
			echo 'OK';
		} else {
			echo 'ERROR';
		}
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
<?

class M_Table extends CI_Model { 


	function __construct() { 
		parent::__construct();
	} 
	
	function get_rows($table, $where = array(), $no_escape_char = FALSE, $order_by = FALSE, $pagination = FALSE) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('status', '1');
		
		if(count($where) > 0) {
			foreach($where as $key => $value) {
				if(!is_string($key)) {
					$this->db->where($value, NULL, (($no_escape_char == true)?false:true));
				} else {
					$this->db->where($key, $value, (($no_escape_char == true)?false:true));	
				}
			}
		}
		
		if($order_by) {
			$this->db->order_by($order_by[0], $order_by[1]);	
		}
		
		if($pagination) {
			$this->db->limit($pagination[0], $pagination[1]);	
		}

		$query = $this->db->get();
		
		return $query->result();
	}
	
	
	function get_row($table, $where = array(), $no_escape_char = FALSE, $order_by = FALSE) {
		
		$this->db->select('*');
		
		$this->db->from($table);
		
		$this->db->where('status', '1');
		
		if(count($where) > 0) {
			foreach($where as $key => $value) {
				if(!is_string($key)) {
					$this->db->where($value, NULL, (($no_escape_char == true)?false:true));
				} else {
					$this->db->where($key, $value, (($no_escape_char == true)?false:true));	
				}
			}
		}
		
		if($order_by) {
			$this->db->order_by($order_by[0], $order_by[1]);	
		}

		$query = $this->db->get();

		return $query->row();
	}
	
	function count_rows($table, $where = array(), $no_escape_char = FALSE) {
		
		$this->db->select('COUNT(*) as count');
		$this->db->from($table);
		
		if(count($where) > 0) {
			foreach($where as $key => $value) {
				if(!is_string($key)) {
					$this->db->where($value, NULL, (($no_escape_char == true)?false:true));
				} else {
					$this->db->where($key, $value, (($no_escape_char == true)?false:true));	
				}
			}
		}

		$this->db->where('status', '1');	
		$query = $this->db->get();
		$q = $query->row();
		return $q->count;
		
	}

	function get_rows_assigned_array($table, $key, $value) {
		
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('status', '1');
		$query = $this->db->get();

		
		$results['0'] = '<i> -- wybierz -- </i>';
		foreach($query->result() as $row) {
			$results[$row->$$key] = $row->$$value;		
		}
							
		return $results;
	}

	public function search($table, $keyword, $where_search = array(), $where = array(), $no_escape_char = FALSE) {
		
		$this->db->select("*");	

		$this->db->from("$table");

		$this->db->where('status', '1');
		if(count($where) > 0) {
			foreach($where as $key => $value) {
				if(!is_string($key)) {
					$this->db->where($value, NULL, (($no_escape_char == true)?false:true));
				} else {
					$this->db->where($key, $value, (($no_escape_char == true)?false:true));	
				}
			}
		}
		
		foreach($where_search as $field) {
			$this->db->like($field, $keyword, 'both'); 
		}
		
		$query = $this->db->get();
		return $query->result();		
	}

	
	function get_elements($module, $module_id) {
		$this->db->select('	e.type, e.element_id, 
							t.text, 
							g.gallery_id, q.quote_id, q.quote, q.author, 
							v.url, v.video_id, v.desc as video_desc, 
							f.folder_id', false
						);
		$this->db->from('element e');
		$this->db->join('text t', 't.element_id = e.element_id', 'left');
		$this->db->join('gallery g', 'g.element_id = e.element_id', 'left');
		$this->db->join('quote q', 'q.element_id = e.element_id', 'left');
		$this->db->join('video v', 'v.element_id = e.element_id', 'left');
		$this->db->join('folder f', 'f.element_id = e.element_id', 'left');
		$where = "e.module = '".$module."' AND e.module_id = '".$module_id."' AND e.status = '1' AND (t.status = '1' OR g.status = '1' OR q.status = '1' OR v.status = '1' OR f.status = '1')";
		$this->db->where($where);
		$query = $this->db->get();
	
		return $query->result();
	}
	
	function get_photos($module, $module_id = null) {
		$this->db->select('p.photo_id, e.element_id, p.gallery_id, p.original_path, p.medium_path, p.thumb_path, p.mini_path, p.desc', false);
		$this->db->from('photo p');
		$this->db->join('gallery g', 'g.gallery_id = p.gallery_id', 'left');
		$this->db->join('element e', 'e.element_id = g.element_id', 'left');
		if(isset($module_id)) {
			$this->db->where('e.module_id', $module_id);
		}
		$this->db->where('e.module', $module);
		$this->db->where('p.status', '1');
		$this->db->order_by('p.position');

		$query = $this->db->get();

		$result = array();
		foreach($query->result_array() as $i => $v) {
			$result[$v['gallery_id']][$v['photo_id']] = (object)$v;
		}
		
		return $result;
	}
	
	
	
	
	function get_files($module, $module_id) {
		$this->db->select('f.file_id, f.folder_id, f.path, f.extension, f.name, f.desc, f.pass', false);
		$this->db->from('file f');
		$this->db->join('folder fo', 'fo.folder_id = f.folder_id', 'left');
		$this->db->join('element e', 'e.element_id = fo.element_id', 'left');
		$this->db->where('e.module_id', $module_id);
		$this->db->where('e.module', $module);
		$this->db->where('f.status', '1');

		$query = $this->db->get();

		$result = array();
		foreach($query->result_array() as $i => $v) {
			$result[$v['folder_id']][$v['file_id']] = $v;
		}
		
		return $result;
	}
	
	
}

?>
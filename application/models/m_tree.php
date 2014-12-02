<?

class M_Tree extends CI_Model { 

	public $table;

	function __construct() { 
		parent::__construct();
	} 
	
	function get_tree($table, $where = array(), $no_escape_char = FALSE, $order_by = FALSE) {
		$this->db->select('*');
		
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
		
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	function get_breadcrumb($table, $link) {
		
		$names_clean = explode('/', $link);
		foreach($names_clean as $i => $name) {
			if($i == 0) $pages[$i] = $name;
			else $pages[$i] = $pages[$i - 1] . '/' . $name;	
		}

		$this->db->select('*');
		$this->db->from($table);
		
		foreach($pages as $link) {
			$this->db->or_where('link', $link);	
		}
		
		$this->db->order_by('pozycja', 'asc');
		
		$query = $this->db->get();
		return $query->result();
		
	}
	
	function show($array, $view_template, $elements = FALSE) {

		if(is_array($array)) {
			foreach ($array as $v) { ?>
            
            	<? $this->show_start_li($v, $array); ?>
                
					<?=$this->load->view($view_template, array('v' => $v, 'elements' => $elements), true)?>
                    
                    <? if(count($v['childs']) > 0) { ?>
                        <? $this->show_start_ul($v, $array); ?>
                            <? $this->show($v['childs'], $view_template, $elements); ?>
                        <? $this->show_end_ul($v, $array); ?>
                    <? } ?>
                    
            	<? $this->show_end_li($v, $array); ?>
                
			<? }
		}
		
	}

	
	function show_start_li() { echo '<li>'; }
	function show_end_li() { echo '</li>'; }
	function show_start_ul() { echo '<ul>';}
	function show_end_ul() { echo '</ul>'; }
	
}

<?

class M_Usera extends CI_Model { 


	function __construct() { 
		parent::__construct();
	} 
	

	

	public function email_exist($email, $except = FALSE) {
		
		$this->db->select('user_id');
		$this->db->from('user');
		$this->db->where('email', $email);
		$this->db->where('status', '1');
		if($except) {
			$this->db->where('email !=', $except);
		}
		$this->db->limit(1);
		
		$q = $this->db->get();	

		if($q->num_rows() > 0) {
			return true;	
		} else {
			return false;		
		}

		
	}

	
}

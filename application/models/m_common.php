<?

class M_Common extends CI_Model { 

	private $config = FALSE;

	function __construct() { 
		parent::__construct();
		
		$query = $this->db->get('settings');
		$this->config = $query->row();
		
	} 

	public function send_mail($to, $subject, $title, $message, $from, $from_name ) {
		
		
		$this->load->library('email');
		
		$config['mailtype'] = 'html';
		$config['protocol'] = 'sendmail';
		$config['charset'] = 'utf-8';
		$this->email->initialize($config);
		
		$this->email->from($from, $from_name);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($this->load->view('_elements/email', array('config' => $this->config, 'text' => $message, 'title' => $title, 'email' => $to), true));
		
		$this->email->send();
			
	}
	
	
	
}

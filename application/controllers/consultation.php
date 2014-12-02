<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consultation extends Root {

	public function __construct() {
		parent::__construct();
	}
	
	//pozyskujemy adres email zioma
	public function index() {
		
		//jesli zalogowany to od razu do wyboru kieruje
		if($this->user->user_id) {
			$name = reset(explode(" ", $this->user->name_surname));
			redirect(base_url() . "consultation/offer/" . base64_encode($name));
		}
		
		if($this->input->post()) {

			$name_surname = $this->input->post('name_surname');
			$email = $this->input->post('email');
			$skype = $this->input->post('skype');
			
			//do bazy
			$data = array(
				'name_surname' => $name_surname,
				'email' => $email,
				'skype' => $skype,
				'date' => date("Y-m-d H:i:s")
			);
			
			$this->db->insert('consultation', $data); 
			
			//powiadomienie email
			$name = explode(' ', $name_surname);
			$title = 'F4U Konsultacja - ' . reset($name) . ' odwiedź tę stronę!';
			$text = '<h2 style="margin-top: 0">Cześć ' . reset($name) . '! Wejdź na tą stronę, aby kontynuować:</h2>';
			
			$this->common->send_mail(	$email, 
										$title, 
										$text,
										"<p><a href='" . base_url() . 'consultation/offer/' . base64_encode(reset($name)) . "'>" . base_url() . 'consultation/offer/' . base64_encode(reset($name)) . "</a></p><p>Pozdrawiamy!<br />Fit4You<br/>tel. 515 046 567</p>",
										$email, 
										$name_surname
									);
			
			//przekierowanie
			
			redirect(base_url() . 'consultation/sended/' . base64_encode(reset($name)));
			
		}

		$this->data['template'] = $this->load->view('consultation/consultation', $this->data, true);
		$this->load->view('index', $this->data);
		
	}
	
	//informacje ze zlozono zamowienie i zeby sprawdzic poczte
	public function sended($name_surname) {
		
		//jesli zalogowany to od razu do wyboru kieruje
		if($this->user->user_id) {
			$name = reset(explode(" ", $this->user->name_surname));
			redirect(base_url() . "consultation/offer/" . base64_encode($name));
		}
		
		$this->data['name_surname'] = $name_surname;
		
		$this->data['template'] = $this->load->view('consultation/sended', $this->data, true);
		$this->load->view('index', $this->data);
		
	}
	
	//tu ma oferte produktow
	public function offer($name_surname = FALSE) {
		
		//imie
		if($this->user->user_id) {
			$this->data['name_surname'] = base64_encode(reset(explode(" ", $this->user->name_surname)));
		} else { 
			$this->data['name_surname'] = $name_surname;
		}
		
		//pobieram oferte
		$consultation_offer = $this->tree->get_tree('product',  array('type' => 'consultation'), FALSE, array('order', 'ASC'));
		$consultation_offer_tree = create_multidimensional_array('product_id', 'parent_id', 0, $consultation_offer);
		$this->data['consultation_offer_tree'] = $consultation_offer_tree;
		
		//zamowienie sie sklada w kontrolerze order
		$this->data['template'] = $this->load->view('consultation/offer', $this->data, true);
		$this->load->view('index', $this->data);
		
	}
	
	//podsumowanie i zapis w sesji
	public function summary() {

		//tu mam tablice name'ow produktow
		$product_ids = $this->input->post('products');
		
		$consultation_products = array();
		if(is_array($product_ids) && count($product_ids) > 0) { 
			foreach($product_ids as $id) {
				
				$product = $this->packet->get_product($id);	
		
				array_push($consultation_products, $product);
			}
		}
		$this->data['consultation_products'] = $consultation_products;
		
		//zapisuje w sesji
		$this->session->unset_userdata('consultation_products');
		$this->session->set_userdata(array('consultation_products' => $consultation_products));
		$this->firephp->log($consultation_products);
		
		//wyswietlam podsumowanie
		echo $this->data['template'] = $this->load->view('consultation/_elements/summary', $this->data, true);
		
	}
	
	//info ze kupiono i zeby sie zalogowal do konta
	public function buyed($name_surname = FALSE) {

		//imie
		if($this->user->user_id) {
			$this->data['name_surname'] = base64_encode(reset(explode(" ", $this->user->name_surname)));
		} else { 
			$this->data['name_surname'] = $name_surname;
		}
		
		$this->data['template'] = $this->load->view('consultation/buyed', $this->data, true);
		$this->load->view('index', $this->data);
		
	}

}

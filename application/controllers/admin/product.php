<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends Admin {

	public function __construct() {
		
		parent::__construct();
		
	}
	
	public function index() {
		
		//consultation products
		$products = $this->tree->get_tree('product', array('type' => 'consultation'), FALSE, array('order', 'ASC'));
		$products_tree = create_multidimensional_array('product_id', 'parent_id', 0, $products);
		$this->data['products_tree'] = $products_tree;
		
		//catering products
		$this->data['products'] = $this->table->get_rows('product', array('type' => 'diet'));	
		
		$this->data['template'] = $this->load->view('admin/product/product', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}

	public function create($product_id = FALSE, $catering = FALSE) {
		
		$this->data['catering'] = $catering;

		if($this->input->post('save') == 1 || $this->input->post('save_and_redirect') == 1) {

			//dane
			if($catering == 'catering') {
				
				$product = array(
					'type' => 'delivery',
					'name' => $this->input->post('name'),
					'vat' => '23',
					//'desc' => $this->input->post('desc'),
					'meals_per_day' => $this->input->post('meals_per_day'),	
					'price_for_day' => $this->input->post('price'),		
				);
				
			} else {
				
				$product = array(
					'type' => 'consultation',
					'name' => $this->input->post('name'),
					'vat' => '23',
					'desc' => $this->input->post('desc'),
					'price' => $this->input->post('price'),	
				);
				
			}
			
			//insert czy update
			if($product_id) {
				$this->db->update('product', $product, array('product_id' => $product_id)); 
			} else {
				$this->db->insert('product', $product); 
				$product_id = $this->db->insert_id(); 
			}
			
			if($this->input->post('save_and_redirect')) {
				redirect(base_url() . 'admin/product');		
			} else {
				redirect(base_url() . 'admin/product/update/' . (($catering)?'catering/':'') . $product_id);	
			}
			
		}
	
		if($product_id) {
			$this->data['product'] = $this->table->get_row('product', array('product_id' => $product_id));	
		}
	
		$this->data['template'] = $this->load->view('admin/product/create', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}

	
	public function remove($product_id) {
		
		if($this->input->post('ajax') == true) {
			
			$this->db->update('product', array('status' => '0'), array('product_id' => $product_id)); 
			echo json_encode(array('id' => $product_id));
				
		}

	}

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Products extends APP_Frontend {

	public function __construct() {
		parent::__construct();
		// $this->_data['header'] = $this->load->view('frontend/header',array(),TRUE);
	}

	public function index() {
		$this->_data['meta_title_custom'] = "Products | Parasol";

		$this->_addContent($this->_data);
		$this->_render();
	}

	public function detail($id) {
		$this->_data['meta_title_custom'] = "Parasol UV White | Parasol";

		if ($id < 1 OR $id > 7) {
			redirect('products');
		}

		$this->_addContent($this->_data,"products_detail_".$id);
		$this->_render();
	}

}
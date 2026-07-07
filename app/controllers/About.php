<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class About extends APP_Frontend {

	public function __construct() {
		parent::__construct();
		// $this->_data['header'] = $this->load->view('frontend/header',array(),TRUE);
	}

	public function index() {
		$this->_data['meta_title_custom'] = "About | Parasol";
		$this->_data['meta_desc_custom'] = "Kenali tipe kulitmu dan kombinasi perlindungan yang tepat di bawah cuaca & tempat yang berbeda.";

		$this->_addContent($this->_data);
		$this->_render();
	}

}
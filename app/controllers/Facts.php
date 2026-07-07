<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Facts extends APP_Frontend {

	public function __construct() {
		parent::__construct();
		// $this->_data['header'] = $this->load->view('frontend/header',array(),TRUE);
	}

	public function index() {
		$this->_data['meta_title_custom'] = "Sun Facts | Parasol";
		$this->_data['meta_desc_custom'] = "";

		$this->_addContent($this->_data);
		$this->_render();
	}

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Home extends APP_Frontend {

	public function __construct() {
		parent::__construct();
		// $this->_data['header'] = $this->load->view('frontend/header',array(),TRUE);
	}

	public function index() {
		$this->_data['meta_title_custom'] = "Parasol";
		// $this->_data['meta_desc_custom'] = "Parasol Desc";

		// slide data
		$slide_data = $this->db->get_where('slides',array('is_active'=>1))->result();

		$latest_qry = "SELECT * FROM mf_articles WHERE type = 1 AND is_active = 1 ORDER BY created_date DESC LIMIT 0,3";
		$latest_articles = $this->db->query($latest_qry)->result();

		$this->_data['slide_data'] = $slide_data;
		$this->_data['latest_articles'] = $latest_articles;

		$this->_addContent($this->_data);
		$this->_render();
	}

	public function javascript() {
		//masukan javascript dari luar
		$this->_addScript('https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js','outer');

		//masukan javascript dari dalam
		$this->_addScript('assets/libs/jquery.masonry.min.js');

		//embed javascript
		$this->_addScript("alert('test')",'embed');


		$this->_addContent($this->_data);
		$this->_render();
	}

	public function css() {
		//masukan javascript dari luar
		$this->_addStyle('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css','outer');

		//masukan javascript dari dalam
		$this->_addStyle('assets/css/reset.css');

		//embed javascript
		$this->_addStyle("*{background-color:#c1c1c1;}",'embed');

		$this->_addContent($this->_data);
		$this->_render();
	}
}
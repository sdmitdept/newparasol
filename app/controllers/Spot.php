<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Spot extends APP_Frontend {

	public function __construct() {
		parent::__construct();
		// $this->_data['header'] = $this->load->view('frontend/header',array(),TRUE);
	}

	public function index() {

		// mobile detection
		$this->load->library('Mobile_Detect');

		$detect = new Mobile_Detect();
		if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS() ) {
			redirect('spot/mobile');
		}

		$this->_data['meta_title_custom'] = "Parasol";
		// $this->_data['meta_desc_custom'] = "Parasol Desc";

		$this->_addStyle('assets/libs/jvectormap/jquery-jvectormap-2.0.3.css');
		$this->_addScript('assets/libs/jvectormap/jquery-jvectormap-2.0.3.min.js');
		$this->_addScript('assets/libs/jvectormap/jquery-jvectormap-indonesia-mill.js');

		$spot_data = $this->db->get_where('spot',array('is_active'=>1))->result();

		$this->_data['spots'] = $spot_data;
		

		$this->_addContent($this->_data);
		$this->_render();
	}

	public function mobile() {
		$this->_data['meta_title_custom'] = "Parasol";

		$spot_data = $this->db->get_where('spot',array('is_active'=>1))->result();
		$this->_data['spots'] = $spot_data;

		$this->_addContent($this->_data);
		$this->_render();
	}

	public function get_data() {
		if (!$this->input->is_cli_request()) {
			echo "You are not permitted!";
		} else {
			echo "permitted";
		}
		
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
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Webtools.php';
class Dashboard extends APP_Webtools {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->_template_master_data['page_title'] = 'Dashboard';
		$this->_template_master_data['page_subtitle'] = 'Control panel';
		$this->_addContent($this->_data);
		$this->_render();
	}
}
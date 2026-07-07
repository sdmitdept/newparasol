<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Profile extends APP_Frontend {

	public function __construct()
	{
		parent::__construct();
		
		if(!$this->_is_login()){
			redirect('home?err=not-login','refresh');exit;
		}
	}

	public function index()
	{
		$this->_data['user'] = $this->user_model->profile($this->_user->id);
		$this->_addContent($this->_data);
		$this->_render();
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Webtools_Login.php';
class Auth extends APP_Webtools_Login {

	public function index()
	{
		if(!$this->_check_session()){
			redirect('webtools/auth/login');	
		}
		
		redirect('webtools/'.$this->config->item('app_webtools_default_page'));
	}

	public function login($err=0)
	{       	   
		if($this->_check_session()){
			redirect('webtools/'.$this->config->item('app_webtools_default_page'));
		}

		$this->_data['err'] = $err;
		$this->_data['msg'] = $this->session->flashdata('msg');

		$this->_data['csrf_name'] = md5('w4yHG8GG571RAq4VogND526R4xXA8ReJ'.date('UYmhijs'));
	    $this->_data['csrf_hash'] = md5('ujxV7i2P95CV2UZo30o9yet2RB25otIh'.date('UYmihsij'));

	    $this->session->set_flashdata('csrf_name', $this->_data['csrf_name']);
	    $this->session->set_flashdata('csrf_hash', $this->_data['csrf_hash']);

		$this->_addContent($this->_data);
		$this->_render(false);
	}

	public function login_process()
	{
	          	   
		if($this->_check_session()){
			redirect('webtools/'.$this->config->item('app_webtools_default_page'));
		}

		$csrf_name_ori = $this->session->flashdata('csrf_name');
		$csrf_hash_ori = $this->session->flashdata('csrf_hash');
		$csrf_hash = $this->input->post($csrf_name_ori);

		//var_dump($csrf_hash.' = '.$csrf_hash_ori);exit;

		if( $csrf_hash!=$csrf_hash_ori  ){
			$this->session->set_flashdata('msg', 'invalid username or password');
			redirect('webtools/auth/login/1');
		}

		$username = strtolower($this->input->post('username'));
		$password = $this->input->post('password');

		if(empty($username) || empty($password)){
			$this->session->set_flashdata('msg', 'invalid username or password');
			redirect('webtools/auth/login/2');
		}

		$this->db->select('admin.*, admin_group.name AS group_name');
		$this->db->from('admin');
		$this->db->join('admin_group','admin.group=admin_group.id','left');
		$this->db->where(array('admin.username'=>$username));
		$this->db->limit(1);
		$res = $this->db->get()->row();

		if( isset($res->id) && intval($res->id) > 0 ){

			//cek apakah tidak active?
			if( $res->is_active==0 ){
				$this->session->set_flashdata('msg', 'Your account is inactive');
				redirect('webtools/auth/login/5');
			}
			
			$this->load->library('password',array(
				'rotations' => $this->config->item('app_password_rotations'),
				'salt' => $this->config->item('app_password_salt')
			));

			if( $this->password->is_valid_password($password,$res->password) )
			{
				$this->_set_session($res);
				redirect('webtools/'.$this->config->item('app_webtools_default_page'));
			}else{
				$this->session->set_flashdata('msg', 'invalid username or password');
				redirect('webtools/auth/login/4');	
			}
		}else{
			$this->session->set_flashdata('msg', 'invalid username or password');
			redirect('webtools/auth/login/3');
		}

		exit;
	}

	function create_password()
	{
		$username = 'admin';
		$password = 'nimda2014';

		$this->load->library('password',array(
				'rotations' => $this->config->item('app_password_rotations'),
				'salt' => $this->config->item('app_password_salt')
			));
		$passwd = $this->password->encrypt_password($password,$username);

		echo strlen($passwd) . '<hr />';
		echo $passwd;
		exit;
	}

	function logout()
	{
		$this->_unset_session();
		redirect('webtools/auth');
	}
}
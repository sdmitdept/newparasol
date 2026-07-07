<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Webtools.php';
class Admin extends APP_Webtools {

	public function __construct()
	{
		parent::__construct();
	}

	public function index($error='')
	{
		$this->_data['error'] = $error;
		$this->_data['error_msg'] = $this->session->flashdata('error');
		$this->_data['success_msg'] = $this->session->flashdata('success');

		$qry = "SELECT 
					a.*,
					ag.name 
				FROM 
					{$this->db->dbprefix('admin')} a 
					LEFT JOIN {$this->db->dbprefix('admin_group')} ag 
					ON a.group=ag.id 
				WHERE 
					a.is_delete=0
					and a.id>1
				";
		$this->_data['list'] = $this->db->query($qry)->result();

		$this->_addStyle('assets/libs/adminlte/plugins/datatables/dataTables.bootstrap.css');
		$this->_addScript('assets/libs/adminlte/plugins/datatables/jquery.dataTables.min.js');
		$this->_addScript('assets/libs/adminlte/plugins/datatables/dataTables.bootstrap.min.js');

		$js = "
			$(document).ready(function() {
			    $('.datatable').DataTable();
			} );
		";
		$this->_addScript($js,'embed');

		$this->_template_master_data['page_title'] = 'Admin';
		$this->_template_master_data['page_subtitle'] = 'list';
		$this->_addContent($this->_data);
		$this->_render();
	}

	public function add($error='')
	{
		$this->_data['error'] = $error;
		$this->_data['error_msg'] = $this->session->flashdata('error');

		$this->_data['group'] = $this->db->get_where('admin_group', array('id>'=>1) )->result();

		$this->_template_master_data['page_title'] = 'Admin';
		$this->_template_master_data['page_subtitle'] = 'add';
		$this->_addContent($this->_data);
		$this->_render();
	}

	public function addprocess()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('group', 'Group', 'required|numeric');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|max_length[12]|callback_username_check');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('webtools/admin/add/error');
		}

		$d = array(
				'username' => strtolower($this->input->post('username',true)),
				'group' => intval($this->input->post('group',true)),
				'created_date' => date('Y-m-d H:i:s')
			);

		//generate password
    	$this->load->library('password',array(
				'rotations' => $this->config->item('app_password_rotations'),
				'salt' => $this->config->item('app_password_salt')."webt00ls"
			));
		$d['password'] = $this->password->encrypt_password($this->input->post('password',true),$d['username']);
		
		if( $this->db->insert('admin',$d) ){
			$id = $this->db->insert_id();
			$this->session->set_flashdata('success', 'Add admin success');
			redirect("webtools/admin/edit/{$id}/success");
		}else{
			$this->session->set_flashdata('error', 'Add admin failed, please try again!');
			redirect('webtools/admin/add/error');
		}
	}
	public function username_check($str)
   	{
   		$u = $this->db->get_where('admin', array('username' => $str) )->row();
   		if( !empty($u->id) && intval($u->id)>0 ){
   			$this->form_validation->set_message('username_check', 'The {field} already used');
            return FALSE;
   		}else{
   			return TRUE;
   		}
    }

	public function edit($id=0,$error='')
	{
		$id=intval($id);
		if($id<=0){
			redirect('webtools/admin');
		}

		$admin = $this->db->get_where('admin',array('id'=>$id))->row();

		$this->_data['group'] = $this->db->get_where('admin_group', array('id>'=>1) )->result();

		$this->_data['admin'] = $admin;
		$this->_data['id'] = $id;
		$this->_data['error'] = $error;
		$this->_data['error_msg'] = $this->session->flashdata('error');
		$this->_data['success_msg'] = $this->session->flashdata('success');

		$this->_template_master_data['page_title'] = 'Admin';
		$this->_template_master_data['page_subtitle'] = 'edit';
		$this->_addContent($this->_data);
		$this->_render();
	}

	public function editprocess($id=0)
	{
		$id=intval($id);
		if($id<=0){
			redirect('webtools/admin');
		}

		$this->load->library('form_validation');

		$this->form_validation->set_rules('group', 'Group', 'required|numeric');
		$this->form_validation->set_rules('active', 'Active', 'required|numeric');

		if( $this->input->post('password') != '' ){
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		}
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect("webtools/admin/edit/{$id}/error");
		}

		$admin = $this->db->get_where('admin',array('id'=>$id))->row();

		$d = array(
				'group' => intval($this->input->post('group',true)),
				'is_active' => intval($this->input->post('active',true))
			);

		if( $this->input->post('password') != '' ){
			//generate password
	    	$this->load->library('password',array(
					'rotations' => $this->config->item('app_password_rotations'),
					'salt' => $this->config->item('app_password_salt')."webt00ls"
				));
			$d['password'] = $this->password->encrypt_password($this->input->post('password',true),$admin->username);
		}		
		
		if( $this->db->update('admin',$d,"id = $id") ){
			$this->session->set_flashdata('success', 'Edit admin success');
			redirect("webtools/admin/edit/{$id}/success");
		}else{
			$this->session->set_flashdata('error', 'Edit admin failed, please try again!');
			redirect("webtools/admin/edit/{$id}/error");
		}
	}

	public function delete($id=0)
	{
		$id=intval($id);
		if($id<=0){
			redirect('webtools/admin');
		}

		if( $this->db->update('admin',array('is_delete'=>1),"id = $id") ){
			$this->session->set_flashdata('success', 'Delete admin success!');
			redirect("webtools/admin/index/success");
		}else{
			$this->session->set_flashdata('error', 'Delete admin failed, please try again!');
			redirect("webtools/admin/index/error");
		}
	}
}
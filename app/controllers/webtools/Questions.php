<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Webtools.php';
class Questions extends APP_Webtools {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->_template_master_data['page_title'] = 'Questions';
		$this->_template_master_data['page_subtitle'] = 'List';

		$this->_addStyle('assets/libs/adminlte/plugins/datatables/dataTables.bootstrap.css');
		$this->_addScript('assets/libs/adminlte/plugins/datatables/jquery.dataTables.min.js');
		$this->_addScript('assets/libs/adminlte/plugins/datatables/dataTables.bootstrap.min.js');


		$this->_addContent($this->_data);
		$this->_render();
	}

	public function answered() {
		$this->_template_master_data['page_title'] = 'Questions';
		$this->_template_master_data['page_subtitle'] = 'Answered';

		$this->_addStyle('assets/libs/adminlte/plugins/datatables/dataTables.bootstrap.css');
		$this->_addScript('assets/libs/adminlte/plugins/datatables/jquery.dataTables.min.js');
		$this->_addScript('assets/libs/adminlte/plugins/datatables/dataTables.bootstrap.min.js');


		$this->_addContent($this->_data);
		$this->_render();
	}

	public function get_questions() {
    	header('Content-Type: application/json');
		$data = $this->db->get_where('questions',array('is_active'=>1,'status'=>0))->result();
		
		$json = array();
		$json['data'] = array();

		foreach($data as $key => $d){

			$action ="<a href='".base_url('webtools/questions/answer/'.$d->question_id)."'><button class='btn btn-primary'>Answer</button></a> ";
			$action .="<a href='".base_url('webtools/questions/delete_question/'.$d->question_id)."'><button class='btn btn-danger'>Delete</button></a>";

			$json['data'][] = array(
				'question_id'  => $d->question_id,
				'name'  => $d->name,
				'email'  => $d->email,
				'question'  => $d->question,
				'ip_address'  => $d->ip_address,
				'status'  => $d->status,
				'created_date'  => date("d-m-Y H:i:s",strtotime($d->created_date)),
				'action' => $action
			);
		}

		header('Content-Type: application/json');
		echo json_encode($json);
		exit;
	}

	public function get_answered() {
    	header('Content-Type: application/json');
		$data = $this->db->get_where('questions',array('is_active'=>1,'status'=>1))->result();
		
		$json = array();
		$json['data'] = array();

		foreach($data as $key => $d){

			$action ="<a href='".base_url('webtools/questions/delete_question/'.$d->question_id)."'><button class='btn btn-danger'>Delete</button></a>";

			$json['data'][] = array(
				'question_id'  => $d->question_id,
				'name'  => $d->name,
				'email'  => $d->email,
				'question'  => $d->question,
				'ip_address'  => $d->ip_address,
				'status'  => $d->status,
				'created_date'  => date("d-m-Y H:i:s",strtotime($d->created_date)),
				'action' => $action
			);
		}

		header('Content-Type: application/json');
		echo json_encode($json);
		exit;
	}

	public function answer($question_id) {
		if (empty($question_id)) {
			redirect('webtools/questions');
		}

		$this->_template_master_data['page_title'] = 'Answer';
		$this->_template_master_data['page_subtitle'] = 'the Question';

		// $this->_addScript('assets/libs/tinymce/jquery.tinymce.min.js');
		// $this->_addScript('assets/libs/tinymce/tinymce.min.js');

		$question_data = $this->db->get_where('questions',array('question_id'=>$question_id))->row();

		$this->_data['question_id'] = $question_id;
		$this->_data['question_data'] = $question_data;

		$this->_addContent($this->_data);
		$this->_render();
	}

	public function save_answer($question_id) {
		if (empty($question_id)) {
			redirect('webtools/questions');
		}

		$answer = $this->input->post('answer',TRUE);

		$insert_data = array(
				"question_id" => $question_id,
				"answer" => $answer,
				"created_date" => date('Y-m-d H:i:s')
			);

		$insert = $this->db->insert('answer',$insert_data);

		if ($insert) {

			// change status
			$stat = array('status'=>1);

			$change = $this->db->update('questions',$stat,array('question_id'=>$question_id));

			if ($change) {

				$response = array(
			        'code'  => 200,
			        'status' => 'success',
			        'head' => '<i class="icon fa fa-check"></i> Success',
			        'msg'     => 'Answer saved!'
				);

				$this->session->set_flashdata("web_res",$response);

				$response_ajax = array(
					"code" => 200,
					"msg" => "Answer saved!",
					"redirect" => base_url('webtools/questions')
				);

				echo json_encode($response_ajax);
				exit;

			} else {

				$response = array(
			        'code'  => 6001,
			        'status' => 'success',
			        'head' => '<i class="icon fa fa-close"></i> Failed',
			        'msg'     => 'Server error (6001)'
				);

				$this->session->set_flashdata("web_res",$response);

				$response_ajax = array(
					"code" => 6001,
					"msg" => "Server error (6001)"
				);

				echo json_encode($response_ajax);
				exit;

			}

		} else {
			$response = array(
			    'code'  => 6002,
			    'status' => 'success',
			    'head' => '<i class="icon fa fa-close"></i> Failed',
			    'msg'     => 'Server error (6002)'
			);

			$this->session->set_flashdata("web_res",$response);

			$response_ajax = array(
				"code" => 6002,
				"msg" => "Server error (6002)"
			);

			echo json_encode($response_ajax);
			exit;
		}

	}

	public function delete_question($question_id) {
		if (empty($question_id)) {
			redirect('webtools/questions');
		}

		$del = array(
				"is_active" => 0
			);

		$del_status = $this->db->update('questions',$del,array('question_id'=>$question_id));

		$response = array(
	        'code'  => 200,
	        'status' => 'success',
	        'head' => '<i class="icon fa fa-check"></i> Success',
	        'msg'     => 'Question deleted'
		);

		$this->session->set_flashdata("web_res",$response);

		redirect('webtools/questions');

	}

}
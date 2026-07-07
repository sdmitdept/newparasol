<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Webtools.php';
class Slider extends APP_Webtools {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->_template_master_data['page_title'] = 'Slides';
		$this->_template_master_data['page_subtitle'] = 'Control panel';

		$this->_addStyle('assets/libs/adminlte/plugins/datatables/dataTables.bootstrap.css');
		$this->_addScript('assets/libs/adminlte/plugins/datatables/jquery.dataTables.min.js');
		$this->_addScript('assets/libs/adminlte/plugins/datatables/dataTables.bootstrap.min.js');

		$this->_addContent($this->_data);
		$this->_render();
	}

	public function delete($slide_id) {

		if(empty($slide_id)) {
			redirect('webtools/slider');
		}

		$this->db->update('slides',array('is_active'=>0),array('slide_id'=>$slide_id));

		redirect('webtools/slider');
	}

	public function add($mode="add",$slide_id=0) {
		$this->_template_master_data['page_title'] = 'Add New Slide';
		$this->_template_master_data['page_subtitle'] = 'Control panel';

		$formurl = base_url('webtools/slider/save/'.$mode."/".$slide_id);

		$slide_data = array();

		if ($mode=="add") {
			# code...
		} else if ($mode=="edit" AND $slide_id > 0) {

			$slide_data = $this->db->get_where('slides',array('slide_id'=>$slide_id))->row();

		} else {
			redirect('webtools/slider/add');
		}


		$this->_data['formurl'] = $formurl;
		$this->_data['slide_data'] = $slide_data;

		$this->_addContent($this->_data);
		$this->_render();
	}

	public function get_slides() {
    	header('Content-Type: application/json');
		$data = $this->db->get_where('slides',array('is_active'=>1))->result();
		
		$json = array();
		$json['data'] = array();

		foreach($data as $key => $d){

			$background = "<a target='_BLANK' href='".base_url('uploads/slider/bg/'.$d->background)."'><img src='".base_url('uploads/slider/bg/'.$d->background)."' width='300px' ></a>";

			if (!empty($d->image)) {
				$image = "<a target='_BLANK' href='".base_url('uploads/slider/img/'.$d->image)."'><img src='".base_url('uploads/slider/img/'.$d->image)."' height='100px' ></a>";
			} else {
				$image = "";
			}


			$action ="<a href='".base_url('webtools/slider/add/edit/'.$d->slide_id)."'><button class='btn btn-primary'>Edit</button></a> ";
			$action .="<a href='".base_url('webtools/slider/delete/'.$d->slide_id)."'><button class='btn btn-danger'>Delete</button></a>";

			$json['data'][] = array(
				'slide_id'  => $d->slide_id,
				'title'  => $d->title,
				'desc'  => $d->desc,
				'background'  => $background,
				'image'  => $image,
				'link'  => $d->link,
				'action' => $action
			);
		}

		header('Content-Type: application/json');
		echo json_encode($json);
		exit;
	}

	public function save($mode="add",$slide_id=0) {
		header('Content-Type: application/json');

		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', 'Title', 'required');

		if ($this->form_validation->run() == FALSE) {

			$response = array(
					"code" => 5001,
					"msg" => validation_errors('<div class="error-box">', '</div>')
				);
			echo json_encode($response);
			exit;

		} else {

			$title = $this->input->post("title",TRUE);
			$desc = $this->input->post('desc',TRUE);
			$link = $this->input->post('link',TRUE);

			// proses image

			$this->load->library('upload');

			if ($mode=="edit" AND $slide_id > 0 ) {

				$d = array(
					"title" => $title,
					"desc" => $desc,
					"link" => $link,
					"is_active" => 1
					);

				if (isset($_FILES['background']) AND $_FILES['background']['size'] > 0 ) {

					$configbg['upload_path'] 	= './uploads/slider/bg/';
					$configbg['allowed_types'] 	= 'jpg|png';
					$configbg['max_size']     	= '4048';
					$configbg['min_width'] 		= '1500';
					$configbg['min_height'] 	= '390';
					$configbg['encrypt_name'] 	= TRUE;

					$this->upload->initialize($configbg);

					if (! $this->upload->do_upload('background')) {

						$error = $this->upload->display_errors('div class="alert alert-warning alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>','</div>');

						$response = array(
							"code" => 5001,
							"msg" => $error
						);
						echo json_encode($response);
						exit;

					} else {

						$bg_name = $this->upload->data("file_name");

						$d['background'] = $bg_name;

					}

				}

				if (isset($_FILES['image']) AND $_FILES['image']['size'] > 0 ) {

					$config_img['upload_path'] 		= './uploads/slider/img/';
					$config_img['allowed_types'] 	= 'jpg|png';
					$config_img['max_size']     	= '2048';
					$config_img['max_width'] 		= '1000';
					$config_img['max_height'] 		= '600';
					$config_img['encrypt_name'] 	= TRUE;

					$this->upload->initialize($config_img);

					if (! $this->upload->do_upload('image')) {

						$error = $this->upload->display_errors('<div class="alert alert-warning alert-dismissible">
                    	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    	<h4><i class="icon fa fa-warning"></i> Alert!</h4>','</div>');
					

						$response = array(
							"code" => 5001,
							"msg" => $error
						);
						echo json_encode($response);
						exit;

					} else {

						$img_name = $this->upload->data("file_name");
						$d['image'] = $img_name;

					}
				}

				$this->db->update('slides',$d,array('slide_id'=>$slide_id));

				$response = array(
					"code" => 200,
					"msg" => "Slide saved!",
					"redirect" => base_url('webtools/slider')
				);

				echo json_encode($response);
				exit;

			/*
			* =========================
			* ADD MODE
			*
			*/

			} else {

				if (isset($_FILES['background']) AND $_FILES['background']['size'] > 0 ) {

					$configbg['upload_path'] 	= './uploads/slider/bg/';
					$configbg['allowed_types'] 	= 'jpg|png';
					$configbg['max_size']     	= '2048';
					$configbg['min_width'] 		= '1500';
					$configbg['min_height'] 	= '390';
					$configbg['encrypt_name'] 	= TRUE;

					$this->upload->initialize($configbg);

					if (! $this->upload->do_upload('background')) {

						$error = $this->upload->display_errors('div class="alert alert-warning alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>','</div>');

						$response = array(
							"code" => 5001,
							"msg" => $error
						);
						echo json_encode($response);
						exit;

					} else {

						$bg_name = $this->upload->data("file_name");

					}

				} else {
					$response = array(
						"code" => 5001,
						"msg" => '<div class="alert alert-warning alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>Background image is required!</div>'
					);
					echo json_encode($response);
					exit;
				}

				if (isset($_FILES['image']) AND $_FILES['image']['size'] > 0 ) {

					$config_img['upload_path'] 		= './uploads/slider/img/';
					$config_img['allowed_types'] 	= 'jpg|png';
					$config_img['max_size']     	= '2048';
					$config_img['max_width'] 		= '1000';
					$config_img['max_height'] 		= '600';
					$config_img['encrypt_name'] 	= TRUE;

					$this->upload->initialize($config_img);

					if (! $this->upload->do_upload('image')) {

						$error = $this->upload->display_errors('<div class="alert alert-warning alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>','</div>');

						$response = array(
							"code" => 5001,
							"msg" => $error
						);
						echo json_encode($response);
						exit;

					} else {

						$img_name = $this->upload->data("file_name");

					}

				} else {
					$img_name = "";
				}


				// image finish

				$d = array(
					"title" => $title,
					"desc" => $desc,
					"background" => $bg_name,
					"image" => $img_name,
					"link" => $link,
					"is_active" => 1
					);

				$this->db->insert('slides',$d);

				$response = array(
					"code" => 200,
					"msg" => "Slide saved!",
					"redirect" => base_url('webtools/slider')
				);

				echo json_encode($response);
				exit;

			}

		}

	}

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Webtools.php';
class Articles extends APP_Webtools {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->_template_master_data['page_title'] = 'Articles';
		$this->_template_master_data['page_subtitle'] = 'Control panel';

		$this->_addStyle('assets/libs/adminlte/plugins/datatables/dataTables.bootstrap.css');
		$this->_addScript('assets/libs/adminlte/plugins/datatables/jquery.dataTables.min.js');
		$this->_addScript('assets/libs/adminlte/plugins/datatables/dataTables.bootstrap.min.js');

		$this->_addContent($this->_data);
		$this->_render();
	}

	public function get_articles() {
    	header('Content-Type: application/json');
		$data = $this->db->get_where('articles',array('is_active'=>1))->result();
		
		$json = array();
		$json['data'] = array();

		foreach($data as $key => $d){

			$header_image = "<a target='_BLANK' href='".base_url('uploads/articles/'.$d->header_image)."'><img src='".base_url('uploads/articles/r/600x300-'.$d->header_image)."' width='300px' ></a>";

			$featured_image = "<a target='_BLANK' href='".base_url('uploads/articles/'.$d->featured_image)."'><img src='".base_url('uploads/articles/r/600x300-'.$d->featured_image)."' width='300px' ></a>";

			$action ="<a href='".base_url('webtools/articles/add/edit/'.$d->article_id)."'><button class='btn btn-primary'>Edit</button></a> ";
			$action .="<a href='".base_url('webtools/articles/delete/'.$d->article_id)."'><button class='btn btn-danger'>Delete</button></a>";

			$json['data'][] = array(
				'article_id'  => $d->article_id,
				'title'  => $d->title,
				'short_desc'  => $d->short_desc,
				'header_image'  => $header_image,
				'featured_image'  => $featured_image,
				'created_date'  => date("d-m-Y H:i:s",strtotime($d->created_date)),
				'action' => $action
			);
		}

		header('Content-Type: application/json');
		echo json_encode($json);
		exit;
	}

	public function add($mode="add",$article_id=0)
	{
		$this->_template_master_data['page_title'] = 'Add Articles';
		$this->_template_master_data['page_subtitle'] = 'Control panel';

		$formurl = base_url('webtools/articles/save/'.$mode."/".$article_id);

		$article_data = array();

		if ($mode=="add") {
			# code...
		} else if ($mode=="edit" AND $article_id > 0) {

			$article_data = $this->db->get_where('articles',array('article_id'=>$article_id))->row();

		} else {
			redirect('webtools/slider/add');
		}

		$this->_data['formurl'] = $formurl;
		$this->_data['article_data'] = $article_data;

		$this->_addContent($this->_data);
		$this->_render();
	}

	public function save($mode="add",$article_id=0) {
		
		$title = $this->input->post('title');
		$short_desc = $this->input->post('desc');
		$content = $this->input->post('content');
		$type = (int) $this->input->post('type');

		if ($mode=="add") {
			
			$data = array(
				"title" => $title,
				"short_desc" => $short_desc,
				"content" => $content,
				"type" => $type,
				"created_date" => date("Y-m-d H:i:s"),
				"modified_date" => date("Y-m-d H:i:s"),
				"is_active" => 1
			);

			$this->load->library(array("image_lib","upload"));

			if (empty($_FILES['header_image'])) {

				$error = '<div class="alert alert-warning alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>'."Header Image is Required".'</div>';

				$response = array(
					"code" => 6001,
					"msg" => $error
				);
				echo json_encode($response);
				exit;
			} else {

				$fext = explode(".",$_FILES['header_image']['name']);
				$fext = end($fext);

				$filename = md5($_FILES['header_image']['name'].date('d-m-Y H:i:s')."mobileheader").".".$fext;

				$config_header['upload_path'] 	= './uploads/articles/';
				$config_header['allowed_types'] = 'jpg|png';
				$config_header['max_size']     	= '2048';
				$config_header['min_width'] 	= '1500';
				$config_header['min_height'] 	= '400';
				$config_header['file_name'] 	= $filename;

				$this->upload->initialize($config_header);

				if (! $this->upload->do_upload('header_image')) {
					$error = $this->upload->display_errors('<div class="alert alert-warning alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4> Header Image: ','</div>');

					$response = array(
						"code" => 5001,
						"msg" => $error
					);
					echo json_encode($response);
					exit;
					
				} else {

					$ori_image = $this->upload->data("file_name");
					$image_600x300 = "600x300-".$filename;

					$reconfig["source_image"] 	= './uploads/articles/'.$ori_image;
					$reconfig['new_image'] 		= './uploads/articles/r/'.$image_600x300;
					$reconfig['master_dim'] 	= "auto";
					$reconfig["width"] 			= 600;
					$reconfig["height"] 		= 300;

					$this->image_lib->initialize($reconfig);
					$this->image_lib->fit();

					$data['header_image'] = $ori_image;

				}

			}

			if (empty($_FILES['header_image_m'])) {

				$error = '<div class="alert alert-warning alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>'."Header Image is Required".'</div>';

				$response = array(
					"code" => 6001,
					"msg" => $error
				);
				echo json_encode($response);
				exit;
			} else {

				$fext = explode(".",$_FILES['header_image_m']['name']);
				$fext = end($fext);

				$filename = md5($_FILES['header_image_m']['name'].date('d-m-Y H:i:s')."mobileheaderm").".".$fext;

				$config_header['upload_path'] 	= './uploads/articles/';
				$config_header['allowed_types'] = 'jpg|png';
				$config_header['max_size']     	= '2048';
				$config_header['min_width'] 	= '400';
				$config_header['min_height'] 	= '400';
				$config_header['file_name'] 	= $filename;

				$this->upload->initialize($config_header);

				if (! $this->upload->do_upload('header_image_m')) {
					$error = $this->upload->display_errors('<div class="alert alert-warning alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4> Header Image: ','</div>');

					$response = array(
						"code" => 5001,
						"msg" => $error
					);
					echo json_encode($response);
					exit;
					
				} else {

					$ori_image = $this->upload->data("file_name");
					$image_600x300 = "600x300-".$filename;

					$reconfig["source_image"] 	= './uploads/articles/'.$ori_image;
					$reconfig['new_image'] 		= './uploads/articles/r/'.$image_600x300;
					$reconfig['master_dim'] 	= "auto";
					$reconfig["width"] 			= 600;
					$reconfig["height"] 		= 300;

					$this->image_lib->initialize($reconfig);
					$this->image_lib->fit();

					$data['header_image_m'] = $ori_image;

				}

			}

			// featured image
			if (empty($_FILES['featured_image'])) {

				

			} else {

				$fext = explode(".",$_FILES['featured_image']['name']);
				$fext = end($fext);

				$filename = md5($_FILES['featured_image']['name'].date('d-m-Y H:i:s')."featured").".".$fext;

				$config_header['upload_path'] 	= './uploads/articles/';
				$config_header['allowed_types'] = 'jpg|png';
				$config_header['max_size']     	= '2048';
				$config_header['min_width'] 	= '400';
				$config_header['min_height'] 	= '400';
				$config_header['file_name'] 	= $filename;

				$this->upload->initialize($config_header);

				if (! $this->upload->do_upload('featured_image')) {
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

					$ori_image = $this->upload->data("file_name");
					$image_600x300 = "600x300-".$filename;

					$reconfig["source_image"] 	= './uploads/articles/'.$ori_image;
					$reconfig['new_image'] 		= './uploads/articles/r/'.$image_600x300;
					$reconfig['master_dim'] 	= "auto";
					$reconfig["width"] 			= 600;
					$reconfig["height"] 		= 300;

					$this->image_lib->initialize($reconfig);
					$this->image_lib->fit();

					$data['featured_image'] = $ori_image;

				}

			}

			$this->db->insert('articles',$data);

			$response = array(
				"code" => 200,
				"msg" => "Slide saved!",
				"redirect" => base_url('webtools/articles')
			);

			echo json_encode($response);
			exit;

		} else if($mode=="edit" AND !empty($article_id)) {

			$data = array(
				"title" => $title,
				"short_desc" => $short_desc,
				"content" => $content,
				"type" => $type,
				"modified_date" => date("Y-m-d H:i:s"),
				"is_active" => 1
			);

			$this->load->library(array("image_lib","upload"));

			if (!empty($_FILES['header_image_m'])) {
				$fext = explode(".",$_FILES['header_image_m']['name']);
				$fext = end($fext);

				$filename = md5($_FILES['header_image_m']['name'].date('d-m-Y H:i:s')."headermobile").".".$fext;

				$config_header['upload_path'] 	= './uploads/articles/';
				$config_header['allowed_types'] = 'jpg|png';
				$config_header['max_size']     	= '2048';
				$config_header['min_width'] 	= '400';
				$config_header['min_height'] 	= '400';
				$config_header['file_name'] 	= $filename;

				$this->upload->initialize($config_header);

				if (! $this->upload->do_upload('header_image_m')) {
					$error = $this->upload->display_errors('<div class="alert alert-warning alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4> Header Image: ','</div>');

					$response = array(
						"code" => 5001,
						"msg" => $error
					);
					echo json_encode($response);
					exit;
					
				} else {

					$ori_image = $this->upload->data("file_name");
					$image_600x300 = "600x300-".$filename;

					$reconfig["source_image"] 	= './uploads/articles/'.$ori_image;
					$reconfig['new_image'] 		= './uploads/articles/r/'.$image_600x300;
					$reconfig['master_dim'] 	= "auto";
					$reconfig["width"] 			= 600;
					$reconfig["height"] 		= 300;

					$this->image_lib->initialize($reconfig);
					$this->image_lib->fit();

					$data['header_image_m'] = $ori_image;
				}
			}

			if (!empty($_FILES['header_image'])) {
				$fext = explode(".",$_FILES['header_image']['name']);
				$fext = end($fext);

				$filename = md5($_FILES['header_image']['name'].date('d-m-Y H:i:s')."header").".".$fext;

				$config_header['upload_path'] 	= './uploads/articles/';
				$config_header['allowed_types'] = 'jpg|png';
				$config_header['max_size']     	= '2048';
				$config_header['min_width'] 	= '1500';
				$config_header['min_height'] 	= '400';
				$config_header['file_name'] 	= $filename;

				$this->upload->initialize($config_header);

				if (! $this->upload->do_upload('header_image')) {
					$error = $this->upload->display_errors('<div class="alert alert-warning alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4> Header Image: ','</div>');

					$response = array(
						"code" => 5001,
						"msg" => $error
					);
					echo json_encode($response);
					exit;
					
				} else {

					$ori_image = $this->upload->data("file_name");
					$image_600x300 = "600x300-".$filename;

					$reconfig["source_image"] 	= './uploads/articles/'.$ori_image;
					$reconfig['new_image'] 		= './uploads/articles/r/'.$image_600x300;
					$reconfig['master_dim'] 	= "auto";
					$reconfig["width"] 			= 600;
					$reconfig["height"] 		= 300;

					$this->image_lib->initialize($reconfig);
					$this->image_lib->fit();

					$data['header_image'] = $ori_image;
				}
			}

			if (!empty($_FILES['featured_image'])) {
				$fext = explode(".",$_FILES['featured_image']['name']);
				$fext = end($fext);

				$filename = md5($_FILES['featured_image']['name'].date('d-m-Y H:i:s')."featured").".".$fext;

				$config_header['upload_path'] 	= './uploads/articles/';
				$config_header['allowed_types'] = 'jpg|png';
				$config_header['max_size']     	= '2048';
				$config_header['min_width'] 	= '400';
				$config_header['min_height'] 	= '400';
				$config_header['file_name'] 	= $filename;

				$this->upload->initialize($config_header);

				if (! $this->upload->do_upload('featured_image')) {
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

					$ori_image = $this->upload->data("file_name");
					$image_600x300 = "600x300-".$filename;

					$reconfig["source_image"] 	= './uploads/articles/'.$ori_image;
					$reconfig['new_image'] 		= './uploads/articles/r/'.$image_600x300;
					$reconfig['master_dim'] 	= "auto";
					$reconfig["width"] 			= 600;
					$reconfig["height"] 		= 300;

					$this->image_lib->initialize($reconfig);
					$this->image_lib->fit();

					$data['featured_image'] = $ori_image;

				}
			}

			$this->db->update('articles',$data,array('article_id'=>$article_id));
			
			$response = array(
				"code" => 200,
				"msg" => "Slide saved!",
				"redirect" => base_url('webtools/articles')
			);

			echo json_encode($response);
			exit;

		}

	}

	function delete($article_id) {
		$d = array("is_active"=>0);
		$this->db->update('articles',$d,array('article_id'=>$article_id));
		redirect('webtools/articles');
	}

}
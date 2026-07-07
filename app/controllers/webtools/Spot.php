<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Webtools.php';
class Spot extends APP_Webtools {

	public function __construct()
	{
		parent::__construct();
	}

	public function index() {
		$this->_template_master_data['page_title'] = 'Spots';
		$this->_template_master_data['page_subtitle'] = 'Control panel';
		
		$this->_addStyle('assets/libs/adminlte/plugins/datatables/dataTables.bootstrap.css');
		$this->_addScript('assets/libs/adminlte/plugins/datatables/jquery.dataTables.min.js');
		$this->_addScript('assets/libs/adminlte/plugins/datatables/dataTables.bootstrap.min.js');

		$this->_addContent($this->_data);
		$this->_render();
	}

	public function get_spots() {
    	header('Content-Type: application/json');

		$data = $this->db->get_where('spot',array('is_active'=>1))->result();

		$json = array();
		$json['data'] = array();

		foreach($data as $key => $d){

			$picture = "<a target='_BLANK' href='".base_url('uploads/places/'.$d->picture)."'><img src='".base_url('uploads/places/r/600x300-'.$d->picture)."' width='300px' ></a>";

			$action ="<a href='".base_url('webtools/spot/add/edit/'.$d->spot_id)."'><button class='btn btn-primary'>Edit</button></a> ";
			$action .="<a href='".base_url('webtools/spot/delete/'.$d->spot_id)."'><button class='btn btn-danger'>Delete</button></a>";

			$json['data'][] = array(
				'spot_id'  => $d->spot_id,
				'name'  => $d->name,
				'temp'  => $d->temp,
				'city'  => $d->city,
				'spf'  => $d->spf,
				'lat'  => $d->lat,
				'lon'  => $d->lon,
				'picture'  => $picture,
				'action' => $action
			);
		}

		header('Content-Type: application/json');
		echo json_encode($json);
		exit;

	}

	public function add($mode="add",$spot_id=0)
	{
		$this->_template_master_data['page_title'] = 'Add Beauty Spot';
		$this->_template_master_data['page_subtitle'] = 'Control panel';

		$spot_data = array();

		$formurl = base_url('webtools/spot/save_spot/'.$mode."/".$spot_id);

		if ($mode=="add") {
			# code...
		} else if ($mode=="edit" AND $spot_id > 0) {

			$spot_data = $this->db->get_where('spot',array('spot_id'=>$spot_id))->row();

		} else {
			redirect('webtools/slider/add');
		}

		$this->_data['formurl'] = $formurl;
		$this->_data['spot_data'] = $spot_data;

		$this->_addContent($this->_data);
		$this->_render();
	}

	public function save_spot($mode="add",$spot_id=0) {
		
		$name = $this->input->post('name');
		$city = $this->input->post('city');
		$lat = $this->input->post('lat');
		$lon = $this->input->post('lon');
		$spf = $this->input->post('spf');

		$data = array(
				"name" => $name,
				"city" => $city,
				"lat" => $lat,
				"lon" => $lon,
				"spf" => $spf
			);

		if ($mode=="add") {

			$this->load->library(array("image_lib","upload"));

			if (empty($_FILES['featured_image'])) {

				$error = '<div class="alert alert-warning alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>'."Featured Image is Required".'</div>';

				$response = array(
					"code" => 6001,
					"msg" => $error
				);
				echo json_encode($response);
				exit;
			} else {

				$fext = explode(".",$_FILES['featured_image']['name']);
				$fext = end($fext);

				$filename = md5($_FILES['featured_image']['name'].date('d-m-Y H:i:s')).".".$fext;

				$config_header['upload_path'] 	= './uploads/places/';
				$config_header['allowed_types'] = 'jpg|png';
				$config_header['max_size']     	= '4048';
				$config_header['min_width'] 	= '800';
				$config_header['min_height'] 	= '800';
				$config_header['file_name'] 	= $filename;

				$this->upload->initialize($config_header);

				if (! $this->upload->do_upload('featured_image')) {
					$error = $this->upload->display_errors('<div class="alert alert-warning alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4> Featured Image: ','</div>');

					$response = array(
						"code" => 5001,
						"msg" => $error
					);
					echo json_encode($response);
					exit;
					
				} else {

					$ori_image = $this->upload->data("file_name");
					$image_600x300 = "600x300-".$filename;

					$reconfig["source_image"] 	= './uploads/places/'.$ori_image;
					$reconfig['new_image'] 		= './uploads/places/r/'.$image_600x300;
					$reconfig['master_dim'] 	= "auto";
					$reconfig["width"] 			= 600;
					$reconfig["height"] 		= 300;

					$this->image_lib->initialize($reconfig);
					$this->image_lib->fit();

					$data['picture'] = $ori_image;

				}

			}

			$this->db->insert('spot',$data);

			$this->get_data();

			$response = array(
				"code" => 200,
				"msg" => "Slide saved!",
				"redirect" => base_url('webtools/spot')
			);

			echo json_encode($response);
			exit;


		} else if($mode=="edit" AND !empty($spot_id)) {

			$this->load->library(array("image_lib","upload"));

			if (!empty($_FILES['featured_image'])) {
				$fext = explode(".",$_FILES['featured_image']['name']);
				$fext = end($fext);

				$filename = md5($_FILES['featured_image']['name'].date('d-m-Y H:i:s')).".".$fext;

				$config_header['upload_path'] 	= './uploads/places/';
				$config_header['allowed_types'] = 'jpg|png';
				$config_header['max_size']     	= '4048';
				$config_header['min_width'] 	= '800';
				$config_header['min_height'] 	= '800';
				$config_header['file_name'] 	= $filename;

				$this->upload->initialize($config_header);

				if (! $this->upload->do_upload('featured_image')) {
					$error = $this->upload->display_errors('<div class="alert alert-warning alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4> Featured Image: ','</div>');

					$response = array(
						"code" => 5001,
						"msg" => $error
					);
					echo json_encode($response);
					exit;
					
				} else {

					$ori_image = $this->upload->data("file_name");
					$image_600x300 = "600x300-".$filename;

					$reconfig["source_image"] 	= './uploads/places/'.$ori_image;
					$reconfig['new_image'] 		= './uploads/places/r/'.$image_600x300;
					$reconfig['master_dim'] 	= "auto";
					$reconfig["width"] 			= 600;
					$reconfig["height"] 		= 300;

					$this->image_lib->initialize($reconfig);
					$this->image_lib->fit();

					$data['picture'] = $ori_image;

				}
			}

			$this->db->update('spot',$data, array('spot_id'=>$spot_id));

			$response = array(
				"code" => 200,
				"msg" => "Slide saved!",
				"redirect" => base_url('webtools/spot')
			);

			echo json_encode($response);
			exit;

		} else {
			$error = '<div class="alert alert-warning alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>'."FAILED URL".'</div>';

			$response = array(
				"code" => 6001,
				"msg" => $error
			);
			echo json_encode($response);
			exit;
		}
	}

	private function get_data() {

        $this->load->database();
        $app_id = "5e507b19cf5602a25fb264090ebdc2e6";

        $spot_data = $this->db->get_where('spot',array('is_active'=>1))->result();

        foreach ($spot_data as $key => $value) {
            
            $lat = $value->lat;
            $lon = $value->lon;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&units=metric&appid=".$app_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {

            } else {
                $decode_response = json_decode($response);
                $temp = $decode_response->main->temp;

                $this->db->update('spot',array('temp'=>$temp),array('spot_id'=> $value->spot_id));
            }
        }
	}

	function delete($spot_id) {
		$d = array("is_active"=>0);
		$this->db->update('spot',$d,array('spot_id'=>$spot_id));
		redirect('webtools/spot');
	}

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Ask extends APP_Frontend {

	public function __construct() {
		parent::__construct();
		// $this->_data['header'] = $this->load->view('frontend/header',array(),TRUE);
	}

	public function index() {
		$this->_data['meta_title_custom'] = "Ask Expert | Parasol";
		$this->_data['meta_desc_custom'] = "";

		$this->_addScript('https://www.google.com/recaptcha/api.js','outer');
		$this->_addScript('assets/libs/masonry.pkgd.min.js');

		$this->_addContent($this->_data);
		$this->_render();
	}

	public function submit() {
		header('Content-Type: application/json');

		$secret = "6Lfwmg8UAAAAADMJ8yLl9O0CI5CQZr44W-lOUAvN";

		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('question', 'Question', 'required');
		$this->form_validation->set_rules('g-recaptcha-response', 'Recapthca', 'required');

		if ($this->form_validation->run() == FALSE) {
			$response = array(
					"code" => 5001,
					"msg" => validation_errors('<div class="error-box">', '</div>')
				);
			echo json_encode($response);
			exit;
		}
		else {

			// populate POST data to variable

			$name = $this->input->post('name',TRUE);
			$email = $this->input->post('email',TRUE);
			$question = $this->input->post('question',TRUE);

			$cap_response = $this->input->post('g-recaptcha-response',TRUE);

			// validate the recapcay
			$server_output = $this->verify_recaptcha($secret,$cap_response);

			$capcay_state = $server_output->success;

			if (!$capcay_state) {
				$response = array(
					"code" => 5001,
					"msg" => "Recaptcha response is invalid"
				);
				echo json_encode($response);
				exit;
			} else {

				// input not from robot then populate the array

				$ip = $this->input->ip_address();

				$ask_data = array(
						"name" => $name,
						"email" => $email,
						"question" => $question,
						"ip_address" => $ip,
						"created_date" => date('Y-m-d H:i:s'),
						"status" => 0,
						"is_active" => 1
					);

				$sql = $this->db->insert('questions',$ask_data);

				$response = array(
					"code" => 200,
					"msg" => "Pertanyaan anda telah berhasil dikirim"
				);

				echo json_encode($response);
				exit;
			}
		}
	}

	private function verify_recaptcha($secret,$response) {
        $url = "https://www.google.com/recaptcha/api/siteverify";
        // $secret = $this->_recaptcha_secret_config;

        $data_post = array(
                'secret' => $secret,
                'response' => $response
            );

        $fields = http_build_query($data_post);

        try {
            $ch = curl_init();

            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
            $server_output = curl_exec ($ch);


            if (FALSE === $server_output)
                //throw exception
                //ganti json?
                throw new Exception(curl_error($ch), curl_errno($ch));

        } catch(Exception $e) {

            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);

        }

        curl_close($ch);
        $response = json_decode($server_output);
        return $response;
    }

    public function get_answer($page=0) {
    	header('Content-Type: application/json');

		$item_count = 5;
		$offset = $page * $item_count;
		$next_page = $page+1;

				// WHERE is_active = 1 AND TYPE = 1 

		$sql = "SELECT q.created_date AS qdate, q.*, a.* FROM mf_questions q
				LEFT JOIN mf_answer a ON q.question_id = a.question_id
				WHERE q.status = 1 AND q.is_active = 1
				ORDER BY a.created_date DESC
				LIMIT ?,?";
		$query = $this->db->query($sql, array($offset,$item_count));

		$result = $query->result();

		if (!empty($result)) {
			$html_res = array();

			foreach ($result as $key => $value) {
				$html_res[] = $this->load->view('frontend/ajax_html/answer_box',$value,TRUE);
			}

			$response = array(
					"page" => (int) $page,
					"next_page" => (int) $next_page,
					"next_url" => base_url('ask/get_answer/'.$next_page),
					"data" => $html_res
				);
		} else {
			$response = array(
					"page" => (int) $page,
					"next_page" => (int) $page,
					"next_url" => '',
					"data" => []
				);
		}

		echo json_encode($response);
    }

}
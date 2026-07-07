<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class News extends APP_Frontend {

	public function __construct() {
		parent::__construct();
		// $this->_data['header'] = $this->load->view('frontend/header',array(),TRUE);
	}

	public function index() {
		$this->_data['meta_title_custom'] = "News & Promo | Parasol";
		$this->_data['meta_desc_custom'] = "";

		$this->_addContent($this->_data);
		$this->_render();
	}

	public function get_article($page=0) {
		header('Content-Type: application/json');

		$item_count = 5;
		$offset = $page * $item_count;
		$next_page = $page+1;

		$sql = "SELECT * FROM mf_articles 
				WHERE is_active = 1 AND TYPE = 2 
				ORDER BY created_date DESC, article_id DESC 
				LIMIT ?,?";
		$query = $this->db->query($sql, array($offset,$item_count));
		// $query = $this->db->get_where('articles',array('is_active'=>1,"type"=>1),$item_count,$offset);

		$result = $query->result();

		if (!empty($result)) {
			$html_res = array();

			foreach ($result as $key => $value) {
				$html_res[] = $this->load->view('frontend/ajax_html/news_box',$value,TRUE);
			}

			$response = array(
					"page" => (int) $page,
					"next_page" => (int) $next_page,
					"next_url" => base_url('articles/get_article/'.$next_page),
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

	public function detail($article_id) {
		$article_data = $this->db->get_where('articles',array('article_id'=>$article_id))->row();

		if (empty($article_data)) {
			redirect('news');
		}

		$this->_data['meta_title_custom'] = $article_data->title." | Parasol";

		$this->_data['article_data'] = $article_data;
		
		$this->_addContent($this->_data);
		$this->_render();
	}

}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'core/APP_Core.php';
class APP_Frontend extends APP_Core {

	private $_template_folder = 'frontend';

	private $_logthis = true;

	var $_social_config = array();

    function __construct()
    {
        parent::__construct(array(
        	'folder' => $this->_template_folder,
        	'log' => $this->_logthis
        ));

        $this->load->model('user_model');

        $this->_social_config = $this->config->item('app_social');

        $this->load->library('social/facebook',array(
                'appId' => $this->_social_config['facebook']['appId'],
                'secret' => $this->_social_config['facebook']['secret']
            ));

        $this->_template_master_data['facebook_appid'] = $this->_social_config['facebook']['appId'];

        // popup
        $popup_terkirim = $this->load->view('frontend/popup_pertanyaanterkirim',$this->_data,true);
        $this->_template_master_data['popup'] = $popup_terkirim;

    }
}
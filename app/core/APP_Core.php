<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class APP_Core extends CI_Controller {

	protected $_FOLDER = '';

	protected $_tmp;

	protected $_tmp_object = array(
		'styles' => '',
		'scripts' => '',
		'content' => ''
	);

    var $_template_master_data = array();

    var $_template_master_name = 'master';

    protected $_isLog = false;

    protected $_session_name = '';

    protected $_user; //pastikan $this->_user->id untuk id user guna keperluan log

    protected $_data;

    function __construct($param=array())
    {
        parent::__construct();

        /* load helper/library/model */
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');

        /* Load App config*/
        $this->config->load('app');
        $this->config->load('social');

        $this->_session_name = $this->config->item('app_session_name');

        /* META TAG */
        $meta_title = $this->config->item('app_meta_title');
        if( isset($meta_title) && $meta_title!='' ){
            $this->_template_master_data['meta_title'] = $meta_title;   
        }
        $meta_description = $this->config->item('app_meta_description');
        if( isset($meta_description) && $meta_description!='' ){
            $this->_template_master_data['meta_description'] = $meta_description;
        }
        $meta_keywords = $this->config->item('app_meta_keywords');
        if( isset($meta_keywords) && $meta_keywords!='' ){
            $this->_template_master_data['meta_keywords'] = $meta_keywords;
        }
        
        /* GOOGLE ANALYTIC */
        $google_analytic = $this->config->item('app_google_analytic');
        if( isset($google_analytic) && $google_analytic!='' ){
            $this->_template_master_data['google_analytic'] = "<script>".$google_analytic."</script>";   
        }

        $this->_FOLDER = isset($param['folder']) ? $param['folder'] : '' ;

        $this->_isLog = isset($param['log']) ? $param['log'] : FALSE;

        $this->_tmp = (object) $this->_tmp_object;

        $this->_template_master_data['login'] = false;
        $this->_data['login'] = false;
        if($this->_check_session()){
            $this->_template_master_data['login'] = true;
            $this->_data['login'] = true;
        }

        if( $this->_isLog )
        {
            $this->_log();
        }

        //HTTP CACHING
        $this->output->set_header("Cache-Control: no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0, public, max-age=". (60*60*8) );
    }

    /*
     *  _render view
     *
     *  - tambah param master untuk kasih option pake master template atau tidak (25/09/2014)
     * 
     */
    protected function _render($master=true)
    {
        if($master)
        {
        	$data = array();
            
            $this->_tmp->user = $this->_user; 

        	foreach($this->_tmp as $label => $value){
        		$data[$label] = $value;
        	}

            $this->_template_master_data['user'] = $this->_user;

            foreach ($this->_template_master_data as $key => $value) {
                $data[$key] = $value;
            }

        	$this->load->view($this->_FOLDER .'/'. $this->_template_master_name,$data);
        }
        else
        {
            echo $this->_tmp->content;
        }
    }

    protected function _addContent($data=array(),$tmp=false)
    {
        if(!$tmp)
        {
            $template = strtolower($this->router->class.'_'.$this->router->method);
    	}
        else
        {
            $template = $tmp;
        }
        $this->_tmp->content = $this->load->view($this->_FOLDER.'/'.$template,$data,TRUE);
    }

    /*
     * Add Style (CSS)
     * 
     * $data = Bisa berupa multi url (array) atau sigle url css. Ini berlaku jika type = inline
     * $type = inline (base url style) dan embed (manual style)
     * 
     * Modified by haris 19-07-2016
     */
    protected function _addStyle($data=null,$type='inline')
    {
        $html = "";
    	if($type=='embed'){
            $html .= '<style type="text/css">
                        '.$data.'
                    </style>'; 
    	}
        else{
            if(is_array($data)){
                foreach ($data as $r){
                    $html .= '<link rel="stylesheet" type="text/css" href="'.base_url().$r.'" />';
                }
            }
            else{
                $html .= '<link rel="stylesheet" type="text/css" href="'.base_url().$data.'" />';
            }
    	}

    	$this->_tmp->styles .= $html;
    }

    /*
     * Add Script (Javascript)
     * 
     * $data = Bisa berupa multi url (array) atau sigle url js. Ini berlaku jika type = inline dan outer. Untuk type view $data adalah path view.
     * $type:
     *      inline  = base url javascript
     *      embed   = manual javascript
     *      outer   = full url javascript
     *      view    = javascript ada didalam view html
     * $parse = untuk parsing data jika type adalah view
     * 
     * Modified by haris 19-07-2016
     */
    protected function _addScript($data=null,$type='inline',$parse=array())
    {
        $html = "";
    	if($type == 'embed'){
            $html .= '<script type="text/javascript">
                        '.$data.'
                    </script>';
        }
        else if($type == 'view'){
            $template = empty($data) ? strtolower($this->router->class.'_'.$this->router->method."_js") : $data;
            $html .= $this->load->view($this->_FOLDER.'/'.$template,$parse,TRUE);
        }
        else if($type=='outer'){
            if(is_array($data)){
                foreach ($data as $r){
                    $html .= '<script src="'.$r.'"></script>';
                }
            }
            else{
                $html .= '<script src="'.$data.'"></script>';
            }
    	}
        else{
            if(is_array($data)){
                foreach ($data as $r){
                    $html .= '<script src="'.base_url().$r.'"></script>';
                }
            }
            else{
                $html .= '<script src="'.base_url().$data.'"></script>';
            }
    	}

    	$this->_tmp->scripts .= $html;
    }

    protected function _log()
    {
        // $raw_data = array(
        //     'url'       => current_url(),
        //     'request'   => $_REQUEST,
        //     'server'    => $_SERVER
        // );

        $raw_data = array();

        $user = $this->session->userdata($this->_session_name);
        if(isset($user->id)){
            $uid = $user->id;
        }else{
            $uid = 0;
        }

        $this->load->library('user_agent');
        
        /*
            Dapatkan referrer url
         */
        $referrer_url = '';
        if($this->agent->is_referral())
        {
            $referrer_url = $this->agent->referrer();
        }

        /*
            Dapatkan REFID (BANNER ADS ID)
         */
        $refid = '';
        if($this->input->get('ref'))
        {
            $refid = $this->input->get('ref');
        }

        $data = array(
            'user_id'   =>  $uid,
            'ip_address'=>  $this->input->ip_address(),
            'controller'=>  $this->router->class,
            'function'  =>  $this->router->method,
            'referrer'  =>  $referrer_url,
            'browser'   =>  $this->agent->browser(),
            'version'   =>  $this->agent->version(),
            'mobile'    =>  $this->agent->mobile(),
            'refid'     => $refid,
            'raw_data'  =>  json_encode($raw_data),
            'created_date' => date('Y-m-d H:i:s'),
            'timestamp' => date('U')
        );

        // Cek session visitor (seperti GA)
        $session = $this->session->userdata('visitorsession');
        if(empty($session)){
            $session = md5( $data['ip_address'].date('U').$data['browser'].$data['version'] );
            $this->session->set_userdata('visitorsession',$session);
            $this->session->mark_as_temp('visitorsession', (60*30)); //30 menit
        }else{
            $this->session->set_userdata('visitorsession',$session);
            $this->session->mark_as_temp('visitorsession', (60*30)); //30 menit
        }
        $data['session'] = $session;

        /* 
         * KALO MO SAVE KE DATABASE PAKE INI
         */
        $this->db->insert('logs',$data);
        
       
        /* 
         * KALO MO SAVE KE FILE PAKE INI
         */
        /*
        $csv = '';
        $first = true;
        foreach ($data as $k => $v) {
            if(!$first){
                $csv .= "\t";
            }
            $csv .= $v;
            if($first){
                $first = false;
            }
        }
        $csv .= "\n";
        $csv_handler = fopen('./assets/lox/'.date('dmY').'.csv','a+');
        fwrite($csv_handler,$csv);
        fclose($csv_handler);
        */
    }

    protected function _set_session($data)
    {
        $this->session->set_userdata($this->_session_name, $data);
    }

    protected function _unset_session()
    {
        $this->session->sess_destroy();
    }

    protected function _check_session()
    {
        $this->_user = $this->session->userdata($this->_session_name);
        if(isset($this->_user->id)){
            return intval($this->_user->id);
        }else{
            return FALSE;
        }
    }

    protected function _is_login()
    {
        if(isset($this->_user->id) && isset($this->_user->id)>0){
            return intval($this->_user->id);
        }else{
            return FALSE;
        }
    }

    protected function _error($msg)
    {
        //error_log(date('d-m-Y H:i:s') . " " . $msg . "\n", 3, APPPATH . "logs/err.log");
    }
}
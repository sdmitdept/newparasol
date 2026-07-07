<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'core/APP_Core.php';
class APP_Webtools_Login extends APP_Core {

	private $_template_folder = 'webtools';

	private $_logthis = false;

    function __construct()
    {
        parent::__construct(array(
        	'folder' => $this->_template_folder,
        	'log' => $this->_logthis
        ));
    }

    /*
     *	OVERRIDE BEBERAPA METHOD KHUSUS UNTUK ADMIN
     */
    protected function _log()
    {
        $raw_data = array(
            'url'       => current_url(),
            'request'   => $_REQUEST,
            'server'    => $_SERVER
        );

        $user = $this->session->userdata($this->_session_name.md5('4dm1nw3bt00ls'));
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

        $raw_data_hash = json_encode($raw_data);

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
            'raw_data'  =>  $raw_data_hash,
            'created_date' => date('Y-m-d H:i:s')
        );

        /* 
         * KALO MO SAVE KE DATABASE PAKE INI
         */
        $this->db->insert('admin_logs',$data);
        
       
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
        $this->session->set_userdata($this->_session_name.md5('4dm1nw3bt00ls'), $data);
    }
    protected function _check_session()
    {
        $this->_user = $this->session->userdata($this->_session_name.md5('4dm1nw3bt00ls'));
        if(isset($this->_user->id)){
            return intval($this->_user->id);
        }else{
            return FALSE;
        }
    }
}
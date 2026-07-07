<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'core/APP_Core.php';
class Webtools extends APP_Core {

	private $_template_folder = 'webtools';

	private $_logthis = FALSE;

	function __construct()
    {
        parent::__construct(array(
        	'folder' => $this->_template_folder,
        	'log' => $this->_logthis
        ));

        $this->load->library('ion_auth');

        if (!$this->ion_auth->logged_in())
		{
			redirect('webtools/auth', 'refresh');
		}

        $this->db->where('is_read = ',0);
        $config = $this->db->get('notif_admin')->num_rows();        

        $this->_template_master_data['notification'] = $config;

        $this->_check_access();
    }

    protected function _is_group($group)
    {
        return $this->ion_auth->in_group($group);
    }

    protected function _check_access()
    {
        if( $this->_is_group('super') ){
            return true;
        }

        $user_groups = $this->ion_auth->get_users_groups()->result();
        $groups = "";
        $i=0;
        foreach ($user_groups as $k => $v) {
            if($i>0){
                $groups .= " OR ";
            }
            $groups .= " groups LIKE '%".$v->name."%' ";
            $i++;
        }
        $groups = " ( ".$groups." ) ";

        $controller = $this->router->class;
        $method = $this->router->method;

        $qry = "SELECT count(*) as total FROM mf_admin_access WHERE controller='{$controller}' AND method='{$method}' and {$groups} LIMIT 1;";
        $r = $this->db->query($qry)->row();

        if(!intval($r->total)){
            redirect('webtools/auth','refresh');
        }
    }
}
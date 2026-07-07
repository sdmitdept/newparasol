<?php
class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function check_user($provider,$provider_uid)
    {
    	$this->db->select('user.*,user_auth.user_id,user_auth.provider,user_auth.provider_uid');
    	$this->db->from('user_auth');
    	$this->db->join('user','user_auth.user_id=user.id','left');
    	$this->db->where('user_auth.provider_uid',$provider_uid);
		$this->db->where('user_auth.provider',$provider);
		$this->db->limit(1);
		$user = $this->db->get()->row();

        if( isset($user->user_id) && intval($user->user_id) )
		{
			return $user;
		}else{
			return false;
		}
    }

    function get_user_email($token)
    {
        $qry = "SELECT 
                    * 
                FROM 
                    {$this->db->dbprefix('user_auth')} ua
                WHERE
                    ua.provider='email'
                    and ( ua.provider_uid='{$token}' or ua.token='{$token}' )
                LIMIT 1
                ";
        $user = $this->db->query($qry)->row();

        if( isset($user->user_id) && intval($user->user_id) )
        {
            return $user;
        }else{
            return false;
        }
    }

    function check_user_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('user_auth');
        $this->db->join('user','user_auth.user_id=user.id','left');
        $this->db->where('user_auth.user_id',$id);
        $this->db->limit(1);
        $user = $this->db->get()->row();

        if( isset($user->user_id) && intval($user->user_id) )
        {
            return $user;
        }else{
            return false;
        }
    }

    function check_user_by_uid($id)
    {
        $this->db->select('*');
        $this->db->from('user_auth');
        $this->db->join('user','user_auth.user_id=user.id','left');
        $this->db->where('user.uid',$id);
        $this->db->limit(1);
        $user = $this->db->get()->row();

        if( isset($user->user_id) && intval($user->user_id) )
        {
            return $user;
        }else{
            return false;
        }
    }

    function add($provider,$provider_uid,$token='',$secret='',$additional=array())
    {
    	$user = $this->check_user($provider,$provider_uid);
    	if( $user ){
    		return false;
    	}

    	$d = array(
    		'uid' => hash('crc32', (date('U').$provider_uid) ),
    		'created_date' => date('Y-m-d H:i:s')
    	);

        if( isset($additional['email']) ){
            $d['email_provider'] = $additional['email'];
        }

        foreach($additional as $k => $v){
            $d[$k] = $v;
        }

    	if( $this->db->insert('user',$d) ){
    		$new_id = $this->db->insert_id();
    		if( $this->new_auth($new_id,$provider,$provider_uid,$token,$secret,$additional,1) )
    		{
                return true;
    		}else{
    			$this->db->where('id',$new_id);
    			$this->db->delete('user');
    			return false;
    		}
    	}else{
            //echo $this->db->last_query();exit;
    		return false;
    	}
    }

    function new_auth($user_id,$provider,$provider_uid,$token='',$secret='',$additional=array(),$primary=0)
    {
    	$user = $this->check_user($provider,$provider_uid);
    	if( $user ){
    		return false;
    	}

    	$d = array(
    		'user_id' => $user_id,
    		'provider' => $provider,
    		'provider_uid' => $provider_uid,
    		'token' => $token,
    		'secret' => $secret,
    		'primary' => $primary,
    		'created_date' => date('Y-m-d H:i:s')
    	);

    	if( $this->db->insert('user_auth',$d) ){
    		return true;
    	}else{
    		return false;
    	}
    }
    
    function update_token($user_id,$provider,$token,$secret='')
    {
        $this->db->where('user_id',$user_id);
        $this->db->where('provider',$provider);

        if($provider=='email'){
            $token = md5($token);
        }

        $d = array('token' => $token);

        if($secret!=''){
            $d['secret'] = $secret;
        }

        $update = $this->db->update('user_auth',$d);

        if($update){
            return true;
        }else{
            return false;
        }
    }

    function profile($user_id)
    {
    	$user_id = intval($user_id);
        $this->db->where('id',$user_id);

        $user = $this->db->get('user')->row();

        return $user;
    }

    function profile_by_uid($uid)
    {
        $this->db->where('uid',$uid);
        $user = $this->db->get('user')->row();
        return $user;
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $u = $this->db->delete('user');

        $this->db->where('user_id',$id);
        $a = $this->db->delete('user_auth');
        
        if($u && $a){
            return true;
        }

        return false;
    }

    function check_auth($user_id,$provider)
    {
        $user_id = intval($user_id);
        $this->db->where('user_id',$user_id);
        $this->db->where('provider',$provider);
        $this->db->limit(1);
        $user = $this->db->get('user_auth')->row();

        if( isset($user->user_id) && intval($user->user_id) )
        {
            return true;
        }else{
            return false;
        }
    }

    /*
     *  Check Username Auth
     *  true = ada
     *  false = tidak ada
     */
    function check_username_auth($username)
    {
        $this->db->where('token',$username);
        $this->db->where('provider','email');
        $this->db->limit(1);
        $user = $this->db->get('user_auth')->row();

        if( !empty($user->user_id) && intval($user->user_id)>0 )
        {
            return true;
        }

        return false;
    }

    /* ===========================================================
        FUNGSI-FUNGSI TAMBAHAN UNTUK APLIKASI DITARUH DIBAWAH SINI
    ============================================================== */

    
}
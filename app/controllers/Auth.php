<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'core/APP_Frontend.php';
class Auth extends APP_Frontend {

	public function __construct()
	{
		parent::__construct();
	}

	public function login()
	{
		$data = array('msg' => $this->session->flashdata('msg'));

		$data['fb_login_url'] = $this->facebook->getLoginUrl(array(
			'scope' => $this->_social_config['facebook']['scope'],
			'redirect_uri' => base_url().$this->_social_config['facebook']['callback']
		));

		$data['tw_login_url'] = base_url('auth/twitter_login');

		$this->_addContent($data);
		$this->_render();
	}

	public function login_process()
	{
		$token = strtolower($this->input->post('token',true));
		$password = $this->input->post('password',true);

		if( empty($token) || empty($password) ){
			$this->session->set_flashdata('msg','Wrong login data');
			redirect( $this->config->item('app_login_page') .'?errno=1' );
		}

		$cuser = $this->user_model->get_user_email($token);

		if(!$cuser){
			$this->session->set_flashdata('msg','Wrong login data');
			redirect( $this->config->item('app_login_page') .'?errno=2');
		}

		//cek password
		$this->load->library('password',array(
				'rotations' => $this->config->item('app_password_rotations'),
				'salt' => $this->config->item('app_password_salt')
			));

		if( !$this->password->is_valid_password($password,$cuser->secret) )
		{
			$this->session->set_flashdata('msg', 'Wrong login data');
			redirect( $this->config->item('app_login_page') .'?errno=3');
		}

		$user = $this->user_model->check_user('email',$cuser->provider_uid);

		if( $user && 0<intval($user->id)){
			/* berhasil login, bikin session */
			$this->_set_session($user);
			redirect( $this->config->item('app_after_login_page'), 'refresh' );
		}
		
		$this->session->set_flashdata('msg', 'Wrong login data');
		redirect( $this->config->item('app_login_page') .'?errno=4');
		exit;
	}

	public function register()
	{
		$data = array('msg' => $this->session->flashdata('msg'));
		$this->_addContent($data);
		$this->_render();
	}

	public function register_process()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|min_length[6]|max_length[20]');
		$this->form_validation->set_rules('name', 'Name', 'required|min_length[2]|max_length[35]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('msg', validation_errors());
			redirect( $this->config->item('app_register_page') );
		}

		//cek username
		$username = strtolower($this->input->post('username',true));
		if( $this->user_model->check_username_auth($username) ){
			$this->session->set_flashdata('msg','Username already exist');
			redirect( $this->config->item('app_register_page') );
		}

		$provider = 'email'; //$this->input->post('provider'); //sudah pasti email
		$provider_uid = $this->input->post('email',true);
		$email = $this->input->post('email',true);
		$token = $username;
		
		//check email sudah ada belum?
		$u = $this->user_model->check_user($provider,$provider_uid);
    	if( $u ){
    		$this->session->set_flashdata('msg','Email already registered');
			redirect( $this->config->item('app_register_page') );
    	}

    	//generate password
    	$this->load->library('password',array(
				'rotations' => $this->config->item('app_password_rotations'),
				'salt' => $this->config->item('app_password_salt')
			));
		$secret = $this->password->encrypt_password($this->input->post('password',true),$username);

		$fullname = $this->input->post('name',true);
		$name = explode(' ',$fullname);
		$first_name = $name[0];
		unset($name[0]);
		$last_name = implode(' ',$name);

    	$additional = array(
    			'username' => $username,
    			'email' => $email,
    			'fullname' => $fullname,
    			'first_name' => $first_name,
    			'last_name' => $last_name
    		);

		if( $this->user_model->add($provider,$provider_uid,$username,$secret,$additional) ){

			//KIRIM Email Confirmation
			//========================

			$this->session->set_flashdata('msg','Register success');
			redirect( $this->config->item('app_register_page') );
		}else{
			$this->session->set_flashdata('msg','Register failed');
			redirect( $this->config->item('app_register_page') );
		}
	}

	public function facebook()
	{
		try {
		 	$fbuser = $this->facebook->api('/me?fields=id,name,email,gender');
    	} catch (FacebookApiException $e) {
			$this->_error($e);
			redirect( $this->config->item('app_login_page') . '?err=login-fb','refresh');
			exit;
		}

		$refid = '';
		if($this->input->get('ref'))
		{
			$refid = $this->input->get('ref');
		}

		$user = $this->user_model->check_user('facebook',$fbuser['id']);

		if( $user && 0<intval($user->id)){
			$this->user_model->update_token($user->id,'facebook',$this->facebook->getAccessToken());
		}else{

			//add new user from facebook
			if( isset($fbuser['email']) && ''!=$fbuser['email'] ){
				$emailnya = $fbuser['email'];
			}else{
				$emailnya = 'nomail@facebook.com';
			}

			$birthdate = isset($fbuser['birthday']) ? $fbuser['birthday'] : '';

			$name = explode(' ',$fbuser['name']);
			$first_name = $name[0];
			unset($name[0]);
			$last_name = implode(' ',$name);

			$gender = '';
			if( isset($fbuser['gender']) ){
				$gender = ($fbuser['gender'] == 'male' ? 'M' : 'F');
			}

			//daftarkan user baru
			$additional = array(
				'username'	=>	(isset($fbuser['username']) ? $fbuser['username'] : $fbuser['name']),
				'fullname' => $fbuser['name'],
				'first_name'=>	$first_name,
				'last_name'=>	$last_name,
				'birthdate'	=>	date('y-m-d',strtotime($birthdate)),
				'gender'	=>	$gender,
				'email'		=>	$emailnya
			);

			if( $this->user_model->add('facebook',$fbuser['id'],$this->facebook->getAccessToken(),'',$additional) ){
				$user = $this->user_model->check_user('facebook',$fbuser['id']);

				//ambil avatar facebook nya
				$url = 'https://graph.facebook.com/'.$fbuser['id'].'/picture?type=large';
				$img = './uploads/avatar/'.$user->uid.'.jpg';
				@file_put_contents($img, file_get_contents($url));

				/*
					MASUKAN REFID NYA
				 */
		   		$this->db->where('id',$user->id);
		   		$this->db->update('user',array('refid' => $refid));

			}else{
				$this->session->set_flashdata('msg','Login failed');
				redirect( $this->config->item('app_login_page') . '?err=login-fb&errno=2' );
				exit;
			}

			/* berhasil login, bikin session */
			$this->_set_session($user);
			$this->session->set_userdata('afterlogin', 1);
			redirect('home', 'refresh' );
			exit;
		}

		/* berhasil login, bikin session */
		$this->_set_session($user);
		$this->session->set_userdata('afterlogin', 1);

		$goback = $this->input->get('goback');
		if( isset($goback) && $goback != ''  ){
			redirect( urldecode($goback), 'refresh' );
		}else{
			redirect('home', 'refresh' );
		}
	}

	function twitter()
	{

		$_oauth_token = $this->session->userdata('oauth_token');
		$_oauth_token_secret = $this->session->userdata('oauth_token_secret');

		$refid = $this->session->userdata('refid');
		$goback = $this->session->userdata('goback');

		if(!empty($_GET['oauth_verifier']) && !empty($_oauth_token) && !empty($_oauth_token_secret))
		{
		  // We've got everything we need
			$this->load->library('social/twitteroauth');
			$this->twitteroauth->create($this->_social_config['twitter']['appId'], $this->_social_config['twitter']['secret'],$_oauth_token,$_oauth_token_secret);

			// Let's request the access token
			$access_token = $this->twitteroauth->getAccessToken($_GET['oauth_verifier']);
			// Save it in a session var
			$this->session->set_userdata('access_token',$access_token);
			// Let's get the user's info
			$user_info = $this->twitteroauth->get('account/verify_credentials');
			// Print user's info
			//print_r($user_info);
			//exit;

			if(isset($user_info->error)){
			 	// Something's wrong, go back to square 1
			  redirect( $this->config->item('app_login_page') . '?err=login-tw' );
			} else {
			    
			  $user = $this->user_model->check_user('twitter',$user_info->id);

				if( $user && 0<intval($user->id)){

					$this->user_model->update_token($user->id,'twitter',$access_token['oauth_token'],$access_token['oauth_token_secret']);

				}else{
					//belum terdaftar, daftarkan user baru
					
					$emailnya = 'nomail@twitter.com';
					$birthdate = '0000-00-00';

					$name = explode(' ',$user_info->name);
					$first_name = $name[0];
					unset($name[0]);
					$last_name = implode(' ',$name);

					//daftarkan user baru
					$additional = array(
						'username'	=>	$user_info->screen_name,
						'first_name'=>	$first_name,
						'last_name'=>	$last_name,
						'birthdate'	=>	date('y-m-d',strtotime($birthdate)),
						'gender'	=>	'O',
						'email'		=>	$emailnya
					);

					if( $this->user_model->add('twitter',$user_info->id,$access_token['oauth_token'],$access_token['oauth_token_secret'],$additional) ){
						$user = $this->user_model->check_user('twitter',$user_info->id);

						//ambil avatar facebook nya
						$url = $user_info->profile_image_url;
						$img = './uploads/avatar/'.$user->uid.'.jpg';
						@file_put_contents($img, file_get_contents($url));

						/*
							MASUKAN REFID NYA
						 */
				   		$this->db->where('id',$user->id);
				   		$this->db->update('user',array('refid' => $refid));

				   	}else{
						$this->session->set_flashdata('msg','Login failed');
						redirect( $this->config->item('app_login_page') . '?err=login-tw&errno=2');
						exit;
					}
				}
			}
		}else{
		 	// Something's missing, go back to square 1
		 	redirect( $this->config->item('app_login_page') . '?err=login-tw' );
		}

		/* berhasil login, bikin session */
		$this->_set_session($user);
		$this->session->set_userdata('afterlogin', 1);

		if( isset($goback) && $goback != ''  ){
			redirect( urldecode($goback), 'refresh' );
		}else{
			redirect( $this->config->item('app_after_login_page'), 'refresh' );
		}
	}

	function twitter_login()
	{
		$this->load->library('social/twitteroauth');
		$this->twitteroauth->create($this->_social_config['twitter']['appId'], $this->_social_config['twitter']['secret']);
		
		$request_token = $this->twitteroauth->getRequestToken(base_url('auth/twitter'));
		
		$this->session->set_userdata('oauth_token',$request_token['oauth_token']);
		$this->session->set_userdata('oauth_token_secret',$request_token['oauth_token_secret']);

		$refid = '';
		if($this->input->get('ref'))
		{
			$this->session->set_userdata('refid',$this->input->get('ref'));
		}
		$goback = '';
		if($this->input->get('goback'))
		{
			$this->session->set_userdata('goback',$this->input->get('goback'));
		}

		// If everything goes well..
		if($this->twitteroauth->http_code==200){
		    // Let's generate the URL and redirect
		    $url = $this->twitteroauth->getAuthorizeURL($request_token['oauth_token'],'itscool');
		    header('Location: '. $url);
		} else {
		    // It's a bad idea to kill the script, but we've got to know when there's an error.
		    redirect( $this->config->item('app_login_page') . '?err=login-tw' );
		}
		exit;
	}

	public function logout()
	{
		$this->_unset_session();
		sleep(1);
		redirect( $this->config->item('app_login_page'), 'refresh' );
	}

	public function facebook_additional($backurl='')
	{
		$backurl = urldecode(base64_decode($backurl));

		try {
		 	$fbuser = $this->facebook->api('/me');
    	} catch (FacebookApiException $e) {
			$this->_error($e);
			redirect( $backurl . '?error=1','refresh');
			exit;
		}

		$user = $this->user_model->check_user('facebook',$fbuser['id']);

		if( $user && 0<intval($user->id)){
			
			redirect( $backurl . '?error=2','refresh');
			exit;

		}else{
			//add new auth to the user 
			if( $this->user_model->new_auth($this->_user->id,'facebook',$fbuser['id'],$this->facebook->getAccessToken()) ){
				redirect( $backurl . '?error=0','refresh');
				exit;
			}else{
				redirect( $backurl . '?error=3','refresh');
				exit;
			}
		}
	}

	function twitter_login_additional($backurl='')
	{
		$backurl_decode = urldecode(base64_decode($backurl));

		$this->load->library('social/twitteroauth');
		$this->twitteroauth->create($this->_social_config['twitter']['appId'], $this->_social_config['twitter']['secret']);
		
		$request_token = $this->twitteroauth->getRequestToken(base_url('auth/twitter_additional/'.$backurl));
		
		if(isset($request_token['oauth_token']) && isset($request_token['oauth_token_secret']) ){
			$this->session->set_userdata('oauth_token',$request_token['oauth_token']);
			$this->session->set_userdata('oauth_token_secret',$request_token['oauth_token_secret']);
		}else{
			redirect( $backurl_decode . '?error=1' );
			exit;
		}

		// If everything goes well..
		if($this->twitteroauth->http_code==200){
		    // Let's generate the URL and redirect
		    $url = $this->twitteroauth->getAuthorizeURL($request_token['oauth_token'],'itscool');
		    header('Location: '. $url);
		} else {
		    // It's a bad idea to kill the script, but we've got to know when there's an error.
		    redirect( $backurl_decode . '?error=1' );
		}
		exit;
	}

	function twitter_additional($backurl='')
	{
		$backurl = urldecode(base64_decode($backurl));

		$_oauth_token = $this->session->userdata('oauth_token');
		$_oauth_token_secret = $this->session->userdata('oauth_token_secret');

		if(!empty($_GET['oauth_verifier']) && !empty($_oauth_token) && !empty($_oauth_token_secret))
		{
		  // We've got everything we need
			$this->load->library('social/twitteroauth');
			$this->twitteroauth->create($this->_social_config['twitter']['appId'], $this->_social_config['twitter']['secret'],$_oauth_token,$_oauth_token_secret);

			$access_token = $this->twitteroauth->getAccessToken($_GET['oauth_verifier']);
			$this->session->set_userdata('access_token',$access_token);
			$user_info = $this->twitteroauth->get('account/verify_credentials');
			
			if(isset($user_info->error)){
			 	// Something's wrong, go back to square 1
			  redirect($backurl . '?error=1');
			} else {
			    
			  $user = $this->user_model->check_user('twitter',$user_info->id);

				if( $user && 0<intval($user->id)){
					redirect($backurl . '?error=2');
				}else{
					//add new auth to the user 
					if( $this->user_model->new_auth($this->_user->id,'twitter',$user_info->id,$access_token['oauth_token'],$access_token['oauth_token_secret']) ){
						redirect( $backurl . '?error=0','refresh');
						exit;
					}else{
						redirect( $backurl . '?error=3','refresh');
						exit;
					}
				}
			}
		}else{
		 	redirect($backurl . '?error=1');
		}
	}

	public function instagram()
	{
		$oauth_uri = array(
				'client_id' => $this->_social_config['instagram']['appId'],
				'redirect_uri' => site_url('auth/instagram_callback'),
				'response_type' => 'code',
				'scope' => 'likes'
			);

		$url =  'https://api.instagram.com/oauth/authorize?' . http_build_query($oauth_uri);

		header('Location: '.$url);
		exit;
	}
	public function instagram_callback()
	{
		if(isset($_GET['error'])){
			redirect('home?err=login-ig&errno=1');
			exit;
		}

		if(!isset($_GET['code']) || $_GET['code']==''){
			redirect('home?err=login-ig&errno=2');
			exit;
		}

		$oauth_uri = array(
				'client_id' => $this->_social_config['instagram']['appId'],
				'client_secret' => $this->_social_config['instagram']['secret'],
				'grant_type' => 'authorization_code',
				'redirect_uri' => site_url('auth/instagram_callback'),
				'code' => $_GET['code']
			);

		$ig = $this->_instagram_curl('https://api.instagram.com/oauth/access_token',$oauth_uri);
		$ig = json_decode($ig);
		//var_dump($ig);exit;

		$user = $this->user_model->check_user('instagram',$ig->user->id);

		if( $user && 0<intval($user->id)){
			$this->user_model->update_token($user->id,'instagram',$ig->access_token);
		}else{

			//add new user from instagram
			$emailnya = '';
			$birthdate = '';

			$name = explode(' ',$ig->user->full_name);
			$first_name = $name[0];
			unset($name[0]);
			$last_name = implode(' ',$name);

			//daftarkan user baru
			$additional = array(
				'username'	=>	(isset($ig->user->username) ? $ig->user->username : $ig->user->full_name),
				'first_name'=>	$first_name,
				'last_name'=>	$last_name,
				'birthdate'	=>	date('y-m-d',strtotime($birthdate)),
				'gender'	=>	'',
				'email'		=>	$emailnya
			);

			if( $this->user_model->add('instagram',$ig->user->id,$ig->access_token,'',$additional) ){
				$user = $this->user_model->check_user('instagram',$ig->user->id);

				//ambil avatar instagram nya
				$url = $ig->user->profile_picture;
				$img = './uploads/avatar/'.$user->uid.'.jpg';
				@file_put_contents($img, file_get_contents($url));

				//bikin user point nya
		   		$this->load->model('point_model');
				$this->point_model->create_userpoint($user->uid,1);
				//MASUKAN POINT
				$this->point_model->add(1,2,$user->uid,'tribe web');

			}else{
				$this->session->set_flashdata('msg','Login failed');
				redirect( $this->config->item('app_login_page') . '?err=login-ig&errno=3' );
				exit;
			}

			/* berhasil login, bikin session */
			$this->_set_session($user);
			$this->session->set_userdata('afterlogin', 1);
			redirect('home', 'refresh' );
			exit;
		}

		/* berhasil login, bikin session */
		$this->_set_session($user);
		$this->session->set_userdata('afterlogin', 1);

		$goback = $this->input->get('goback');
		if( isset($goback) && $goback != ''  ){
			redirect( urldecode($goback), 'refresh' );
		}else{
			redirect('home', 'refresh' );
		}
	}
	public function instagram_additional($backurl='')
	{
		$oauth_uri = array(
				'client_id' => $this->_social_config['instagram']['appId'],
				'redirect_uri' => site_url('auth/instagram_additional_callback?backurl='.$backurl),
				'response_type' => 'code',
				'scope' => 'likes'
			);

		$url =  'https://api.instagram.com/oauth/authorize?' . http_build_query($oauth_uri);

		header('Location: '.$url);
		exit;
	}
	public function instagram_additional_callback()
	{
		$backurl = urldecode(base64_decode($_GET['backurl']));

		if(isset($_GET['error'])){
			redirect($backurl.'?error=1');
			exit;
		}

		if(!isset($_GET['code']) || $_GET['code']==''){
			redirect($backurl.'?error=1');
			exit;
		}

		$oauth_uri = array(
				'client_id' => $this->_social_config['instagram']['appId'],
				'client_secret' => $this->_social_config['instagram']['secret'],
				'grant_type' => 'authorization_code',
				'redirect_uri' => site_url('auth/instagram_additional_callback?backurl='.$_GET['backurl']),
				'code' => $_GET['code']
			);

		$ig = $this->_instagram_curl('https://api.instagram.com/oauth/access_token',$oauth_uri);
		$ig = json_decode($ig);
		//var_dump($ig);exit;

		$user = $this->user_model->check_user('instagram',$ig->user->id);

		if( $user && 0<intval($user->id)){
			
			redirect( $backurl . '?error=2','refresh');
			exit;

		}else{
			//add new auth to the user 
			if( $this->user_model->new_auth($this->_user->id,'instagram',$ig->user->id,$ig->access_token) ){
				redirect( $backurl . '?error=0','refresh');
				exit;
			}else{
				redirect( $backurl . '?error=3','refresh');
				exit;
			}
		}
	}
	protected function _instagram_curl($url,$params)
	{
	   	$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url);
		curl_setopt( $curl, CURLOPT_POST, 1);
		curl_setopt( $curl, CURLOPT_POSTFIELDS, $params);
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $curl, CURLINFO_HEADER_OUT, false );
		
		// EXECUTE THE CURL CALL
		$htm = curl_exec($curl);
		$err = curl_errno($curl);
		$inf = curl_getinfo($curl);

		return $htm;
	}

}
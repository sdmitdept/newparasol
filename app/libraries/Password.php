<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Password{

	//Number of times to rehash
	private $rotations = 7;
	private $presalt = 'm031leFoRC3!2014$';
	private $salt = '1z9!SHWSA3P{nk6o6L8bq]E1B47.s]Xu7ELldmP82i/v1W[5y6X_z(5f24sq[8';

	function __construct($params=array()){
		$this->rotations = isset($params['rotations']) ? intval($params['rotations']) : $this->rotations;
		$this->salt = isset($params['salt']) ? $params['salt'] : $this->salt;
		$this->salt = $this->presalt.$this->salt;
	}

	function encrypt_password($password, $username){
		$salt = hash('sha256', uniqid(mt_rand(), true) . hash('sha256',$this->salt) . strtolower($username));
		$hash = $salt . $password . $salt;
		for ( $i = 0; $i < $this->rotations; $i ++ ) {
		  $hash = hash('sha256', $hash);
		}
		return $salt . $hash . $salt;
	}
	function is_valid_password($password,$dbpassword){
		$salt = substr($dbpassword, 0, 64);
		$hash = $salt . $password . $salt;
		for ( $i = 0; $i < $this->rotations; $i ++ ) {
				$hash = hash('sha256', $hash);
		}
		//Sleep a bit to prevent brute force
		time_nanosleep(0, 400000000);
		$hash = $salt . $hash . $salt;
		return $hash == $dbpassword;
	}
}
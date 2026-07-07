<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
	Config untuk social media
 */
$config['app_social'] = array(
	'facebook' => array(
			'appId' => '261910274147201',
			'secret' => 'e2be157d7a2512ae30099672863e5dd9',
			'scope' => 'public_profile,email',
			'callback' => 'auth/facebook'
		),
	'twitter' => array(
			'appId' => 'RVYHK8hPbeS5nwfZ3QBTDg',
			'secret' => 'YTqINyxMIK7A3EXG0aSpq38jmS0IiJtUhlyDrFX48'
		)
);
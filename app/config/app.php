<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| META TAG
|--------------------------------------------------------------------------
|
|	untuk config meta tag aplikasi
|
*/
$config['app_meta_title'] = 'Mobileforce Web Framework';										// maksimal 12 words, best 3-5 words
$config['app_meta_description'] = 'Mobileforce Web Framework';	// 150 karakter
$config['app_meta_keywords'] = 'Mobileforce Web Framework';			// maksimal 30 keywords

/*
|--------------------------------------------------------------------------
| Session name
|--------------------------------------------------------------------------
|
|	Nama session user
|
*/
$config['app_session_name'] = 'mobileforce&%*&%hsajhfdjhsfa';

/*
|--------------------------------------------------------------------------
| Login page
|--------------------------------------------------------------------------
|
|	Halaman untuk login
|
*/
$config['app_login_page'] = 'auth/login';

/*
|--------------------------------------------------------------------------
| Register page
|--------------------------------------------------------------------------
|
|	Halaman register
|
*/
$config['app_register_page'] = 'auth/register';

/*
|--------------------------------------------------------------------------
| After login page
|--------------------------------------------------------------------------
|
|	Setelah login user akan dilempar kesini, kecuali yang telah di set callback url nya
|
*/
$config['app_after_login_page'] = 'home';

/*
|--------------------------------------------------------------------------
| Google Analytic
|--------------------------------------------------------------------------
|
|	code google analytic (javascript)
|
*/
$config['app_google_analytic'] = "";

/*
|--------------------------------------------------------------------------
| REST API SETTING
|--------------------------------------------------------------------------
|
|	settingan buat REST API
|
*/
$config['app_api_appname'] = ""; //API APP NAME

/*
|--------------------------------------------------------------------------
| WEBTOOLS CONFIG
|--------------------------------------------------------------------------
|
|	Webtools Configurations
|
*/
$config['app_webtools_default_page'] = 'dashboard';

/*
|--------------------------------------------------------------------------
| PASSWORD HASH CONFIG
|--------------------------------------------------------------------------
|
|	Password HASH Configuration
|
*/
$config['app_password_rotations'] = 7;
$config['app_password_salt'] = '1z9!SHWSA3P{nk6o6Lmobileforce8bq]E1B47.s]Xu7ELldmP82i/v1W[5y6X_z(5f24sq[8';

/*
|--------------------------------------------------------------------------
| CONFIG LAIN_LAIN
|--------------------------------------------------------------------------
|
*/
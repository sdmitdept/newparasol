<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Update_weather extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function get_data() {

        $this->load->database();
        $app_id = "5e507b19cf5602a25fb264090ebdc2e6";

        $spot_data = $this->db->get_where('spot',array('is_active'=>1))->result();

        foreach ($spot_data as $key => $value) {
            
            $lat = $value->lat;
            $lon = $value->lon;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&units=metric&appid=".$app_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {

            } else {
                $decode_response = json_decode($response);
                $temp = $decode_response->main->temp;

                $this->db->update('spot',array('temp'=>$temp),array('spot_id'=> $value->spot_id));
            }
        }
	}
}
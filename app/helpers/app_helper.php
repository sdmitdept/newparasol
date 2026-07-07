<?php

if( !function_exists('aph_shorttext') ){
    function aph_shorttext($text,$numb) {
        if (strlen($text) > $numb) { 
          $text = substr($text, 0, $numb); 
          $text = substr($text,0,strrpos($text," ")); 
          $etc = " ...";  
          $text = $text.$etc; 
        }
        return $text; 
    }
}

/* Get assets URL */
if( !function_exists('assets_url') ){
    function assets_url($path=''){
        return base_url('assets/'.$path);
    }
}

/* Get shortname */
if( !function_exists('aph_shortname') ){
	function aph_shortname($fullname,$long=10){
		$name = '';
		if(strlen($fullname)<=$long){
			$name = $fullname;
		}else{
			$fn = explode(' ',$fullname);
			
            if( count($fn) > 1){
                if(strlen($fn[0] .' '. $fn[1])<=$long){
                    $name = $fn[0] .' '. $fn[1];
                }else{
                    $name = $fn[0];
                }
            }else{
                $name = $fn[0]; 
            }
            /*
            foreach($fn as $f){
				if(strlen($f)>1){
					$name = $f;
					break;
				}
			}
            */
		}
		return $name;
	}
}

/* Cut fullname */
if( !function_exists('aph_cut_name') ){
	function aph_cut_name($fullname,$word=2){
		$n = explode(' ',$fullname);
		$name = '';
		$f = true;
		for($i=0;$i<$word;$i++){
            if(isset($n[$i])){
    			if(!$f){
    				$name .= ' ';
    			}else{
    				$f = false;
    			}
    			$name .= $n[$i];
		    }
        }
		return $name;
	}
}

/* seconds to time string */
if( !function_exists('aph_seconds_to_time') ){
	function aph_seconds_to_time($time){
		$menit_text = '0m';
    $menit = floor($time/60);
    if($menit>0){
        $menit_text = $menit.'m';
    }
    $detik_text = '0s';
    $detik = $time%60;
    if($detik>0){
        $detik_text = $detik.'s';
    }		
		return $menit_text.' '.$detik_text;
	}
}

if ( ! function_exists('array_to_csv'))
{
    function array_to_csv($array, $download = "")
    {
        if ($download != "")
        {    
            header('Content-Type: application/csv');
            header('Content-Disposition: attachement; filename="' . $download . '"');
        }        

        ob_start();
        $f = fopen('php://output', 'w') or show_error("Can't open php://output");
        $n = 0;        
        foreach ($array as $line)
        {
            $n++;
            if ( ! fputcsv($f, $line))
            {
                show_error("Can't write line $n: $line");
            }
        }
        fclose($f) or show_error("Can't close php://output");
        $str = ob_get_contents();
        ob_end_clean();

        if ($download == "")
        {
            return $str;    
        }
        else
        {    
            echo $str;
        }        
    }
}

if ( ! function_exists('query_to_csv'))
{
    function query_to_csv($query, $download = "")
    {
        $new_array = array();
        
        //first line
        $str = array();
        foreach ($query[0] as $k => $v) {
            $str[] = $k;
        }
        $new_array[] = $str;
        $str = array();
        
        //other line
        foreach ($query as $key => $value) {
            foreach ($value as $k => $v) {
                $str[] = $v;
            }

            $new_array[] = $str;
            $str = array();
        }

        array_to_csv($new_array,$download);
    }
}

if ( ! function_exists('aph_string_url'))
{
	function aph_string_url($text,$target='_BLANK') {
	    $text = @eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '<a target="'.$target.'" href="\\1">\\1</a>', $text);
	    $text = @eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '\\1<a target="'.$target.'" href="http://\\2">\\2</a>', $text);
	    $text = @eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})', '<a target="'.$target.'" href="mailto:\\1">\\1</a>', $text);
	    return $text;
	}
}

if ( ! function_exists('render_month_dropdown'))
{
    function render_month_dropdown($first_label="",$mo_selected=0) {
        $month = array(
                    'all' => 'Sepanjang Waktu',
                    'week' => '7 Hari Terakhir',
                    'month' => '30 Hari Terakhir',
                    'year' => '1 Tahun Terakhir',
                    'set' => 'Rentang Tanggal'
                 );

        $drop = "";

        if(!empty($first_label)) {
            echo '<option value="">'.$first_label.'</option>';
        }
        foreach ($month as $key => $value) {
            $select = ($i != 0 and $i == $key) ? 'selected' : '';
            echo '<option value="'.$key.'" '.$select.'>'.$value.'</option>';
        }
    }


    
}

if ( ! function_exists('render_month_dropdown_2'))
{
    function render_month_dropdown_2($first_label="",$mo_selected=0) {
        $month = array(
                    'all' => 'Sepanjang Waktu',
                    '1' => 'Januari',
                    '2' => 'Februari',
                    '3' => 'Maret',
                    '4' => 'April',
                    '5' => 'Mei',
                    '6' => 'Juni',
                    '7' => 'Juli',
                    '8' => 'Agustus',
                    '9' => 'September',
                    '10' => 'Oktober',
                    '11' => 'November',
                    '12' => 'Desember'
                 );

        $drop = "";

        if(!empty($first_label)) {
            echo '<option value="">'.$first_label.'</option>';
        }
        foreach ($month as $key => $value) {
            $select = ($mo_selected != 0 and $mo_selected == $key) ? 'selected' : '';
            echo '<option value="'.$key.'" '.$select.'>'.$value.'</option>';
        }
    }


    
}

if ( ! function_exists('render_month_dropdown_3'))
{
    function render_month_dropdown_3($first_label="",$mo_selected=0) {
        $month = array(
                    'all' => 'Sepanjang Waktu',
                    '2015' => '2015',
                    '2016' => '2016',
                    '2017' => '2017',
                    '2018' => '2018',
                    '2019' => '2019',
                    '2020' => '2020',
                    '2021' => '2021',
                    '2022' => '2022',
                    '2023' => '2023',
                    '2024' => '2024',
                    '2025' => '2025'
                 );

        $drop = "";

        if(!empty($first_label)) {
            echo '<option value="">'.$first_label.'</option>';
        }
        foreach ($month as $key => $value) {
            $select = ($mo_selected != 0 and $mo_selected == $key) ? 'selected' : '';
            echo '<option value="'.$key.'" '.$select.'>'.$value.'</option>';
        }
    }


    
}

if ( ! function_exists('render_city_dropdown'))
{
    function render_city_dropdown($first_label="",$mo_selected=0) {
        $CI =& get_instance();
        $cities = $CI->api_model->get_where('kota',array('is_actived'=>1,'is_deleted'=>0))->result_array();

        $month = array(
                    'all' => 'Semua Kota'
                 );

        foreach ($cities as $key => $value) {
            $month[$value['id']] = $value['name'];
        }

        $drop = "";

        if(!empty($first_label)) {
            echo '<option value="">'.$first_label.'</option>';
        }
        foreach ($month as $key => $value) {
            $select = ($mo_selected != 0 and $mo_selected == $key) ? 'selected' : '';
            echo '<option value="'.$key.'" '.$select.'>'.$value.'</option>';
        }
    }
}
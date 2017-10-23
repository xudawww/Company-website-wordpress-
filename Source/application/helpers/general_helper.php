<?php
function check_installer(){
  
  $file = "INSTALLER_TRUE.php";
    if(file_exists($file)){
        redirect(base_url().'Installer/installer.php');
    } 
}
function get_airports(){

	$ci = & get_instance();

	//$settings = $ci->db->select('country')->get('settings')->row();

	

	$results = $ci->db->query('SELECT airport_list.name,airport_list.code FROM airport_list INNER JOIN settings ON airport_list.iso = settings.country ORDER BY airport_list.name ASC')->result();	

	return json_encode($results);



}

function get_stations(){
	$ci = & get_instance();
	$results = $ci->db->order_by('package','ASC')->get('round_trip_package')->result();	
	return json_encode($results);
}

function get_cab_info(){
	$ci = & get_instance();
	$results = $ci->db->order_by('package','ASC')->get('round_trip_package')->result();	
	return json_encode($results);
}

function get_wallet($user){
	$ci = & get_instance();
	$settings = $ci->db->select('currency')->get('settings')->row();
	$results = $ci->db->select('wallet_amount')->where('username',$user)->get('userdetails')->row();	
	list($word,$code) = explode(',', $settings->currency);
	$amount = $results->wallet_amount>0?$results->wallet_amount:0;
	return $code.$amount;
}



function convert_to_usd($amount,$from_Currency){	

		$to_Currency = 'USD';

		$amount = urlencode($amount);

		$from_Currency = urlencode($from_Currency);

		$to_Currency = urlencode($to_Currency);

		$get = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency");

		$get = explode("<span class=bld>",$get);

		$get = explode("</span>",$get[1]);

		return $converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);

	}

?>
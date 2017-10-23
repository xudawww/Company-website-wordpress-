<?php
$ci =& get_instance();
$ci->load->model('model_admin');

function getsettingsdetails(){
	
	$ci =& get_instance();
	$s =$ci->model_admin->settings_details();
	
	//print json_encode( $s );
	return $s;
}

function is_logged() {
	$obj = & get_instance();
	$type = $obj->session->userdata('type');
    $sessionData = $obj->session->userdata('username');
    if($sessionData) {
		$obj->db->select('*');
		if($type=='user'){
	
    $obj->db->where('username', $sessionData);
	$query = $obj->db->get('userdetails');
	$result = $query->row();
	$result->username = $result->username;
		}
		else{
		$obj->db->where('user_name', $sessionData);
	    $query = $obj->db->get('driver_details');
		$result = $query->row();
		$result->username = $result->user_name;
		}
	
	
	if($result){
		$result->status = 'success';
		return $result;
	} else {
		return false;
	}
	}
	 else {
		return false;
	}
}


?>
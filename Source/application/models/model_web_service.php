<?php

class model_web_service extends CI_Model{
	function __construct() {
	parent::__construct();
}

	function login($request){
		
		
		$table = 'userdetails';	
		$select_data = "*";
	
		$this->db->select($select_data);
		$this->db->where("(email = '$request->Email' OR username = '$request->Email' OR mobile = '$request->Email' )");
     
               $this->db->where('Password', md5($request->Password));
	
//		$this->db->where('password', $request->Password);
		$query  = $this->db->get($table);  //--- Table name = User
		$result = $query->result_array(); 
	
		if(count($result) > 0){ // user credential is success 
		
			return $result[0];
		
		}
		else{ // user credential failed
			return false;
		}  
	
	}
	function update_device_id($device_id, $user_id){
		$table = 'userdetails';	
		
		$update_data = array(
			'device_id'     => $device_id
		);
		
		$where_data = array(
			'id'            => $user_id,
		);
		
		$this->update_table_where( $update_data, $where_data, $table);
	}
	function authenticate_key($request){
		$table = 'settings';	
		$select_data = "serv_secret_key";
	
		$this->db->select($select_data);
		$this->db->where( 'serv_secret_key', $request->secret_key );
    
		$query  = $this->db->get($table);  //--- Table name = User
		$result = $query->result_array(); 
	
		if(count($result) > 0){ // user credential is success 
		
			return true;
		
		}
		else{ // user credential failed
			return false;
		}  
	
	}
	
	function social_login(  $request ){
		
		$table = 'userdetails';	
		$select_data = "*";
	
		$this->db->select($select_data);
		$this->db->where("(email = '$request->Email' OR username = '$request->Email' OR mobile = '$request->Email' )");
    
		$query  = $this->db->get($table);  //--- Table name = User
		$result = $query->result_array(); 
	
		if(count($result) > 0){ // user credential is success 
		
			return $result[0];
		
		}
		else{ // user credential failed
			return false;
		}  
	
	}
	
	function fetch_cabs($request){
		
		$table = 'cabdetails';	
		$select_data = "*";
	
		$this->db->select($select_data);
		
		$this->db->where('transfertype', $request->transfertype);
		$this->db->where('timetype', $request->timetype);
		
		$query  = $this->db->get($table);  //--- Table name = User
		$result = $query->result_array(); 
	
		return $result;
		
	}
	function load_trips($request){
		
		$table = 'bookingdetails';	
		$select_data = "uneaque_id ,purpose, pickup_area, pickup_date, drop_area, pickup_time, taxi_type, status,distance,amount,item_status,km,timetype";
	
		$this->db->select($select_data);
		
		$this->db->where('username', $request->token);
		$this->db->order_by("id","desc");
		
		$query  = $this->db->get($table);  //--- Table name = User
		$result = $query->result_array(); 
	
		return $result;
		
	}
	function load_all_cabs($request){
		
		$table = 'cabdetails';	
		$select_data = "*";
	
		$this->db->select($select_data);
		
		$this->db->where('transfertype', $request->transfertype );
		
		$query  = $this->db->get($table);  //--- Table name = User
		$result = $query->result_array(); 
	
		return $result;
		
	}
	
	function load_settings(){
		
		$table = 'settings';	
		$select_data = "country,places";
	
		$this->db->select($select_data);
		
		$this->db->where('id', 1 );
		
		$query  = $this->db->get($table);  //--- Table name = User
		$result = $query->result_array(); 
	
		return $result;
		
	}
	
	function update_pwd($request){
		
		$table = 'userdetails';	
		
		$update_data = array(
			'password'     => md5($request->Password )
		);
		
		$where_data = array(
			'username'            => $request->token,
		);
		
		$this->update_table_where( $update_data, $where_data, $table);
		
	}
	
	
	
	function is_mail_exists($mail){ 
		/* function return
		 ---------------------------------	 
		 'true'   if user exist
		 'false'  if user does not exist
		
		*/
		
		$select_data = "*"; 
		
		$where_data = array(	// ----------------Array for check data exist ot not
			'email'     => $mail
		);
		
		$table = "userdetails";  //------------ Select table
		$result = $this->get_table_where( $select_data, $where_data, $table );
		
		if( count($result) > 0 ){ // check if user exist or not
			
			return true;
		}
		
		return false;
	 }
   
	 function is_username_exists($user_name){ 
			/* function return
			 ---------------------------------	 
			 'true'   if user exist
			 'false'  if user does not exist
			 
			*/
			
			$select_data = "*"; 
			
			$where_data = array(	// ----------------Array for check data exist ot not
				'username'     => $user_name
			);
			
			$table = "userdetails";  //------------ Select table
			$result = $this->get_table_where( $select_data, $where_data, $table );
			
			if( count($result) > 0 ){ // check if user exist or not
				
				return true;
			}
			
			return false;
	 }
   function is_mobile_exists($mobile){ 
			/* function return
			 ---------------------------------	 
			 'true'   if mobile exist
			 'false'  if mobile does not exist
			 
			*/
			
			$select_data = "*"; 
			
			$where_data = array(	// ----------------Array for check data exist ot not
				'mobile'     => $mobile
			);
			
			$table = "userdetails";  //------------ Select table
			$result = $this->get_table_where( $select_data, $where_data, $table );
			
			if( count($result) > 0 ){ // check if user exist or not
				
				return true;
			}
			
			return false;
	 }
   
   function insert_user_details( $request ){
	
			$table = 'userdetails';
			$insert_data = array(
				'username'	  => $request->User_name,
				'mobile'	    => $request->Mobile,
				'email'	      => $request->Email,
				'password'	  => md5 ($request->Password),
				'user_status'	=> "Active",
//				'device_id'	=> $request->device_id,
			);
			
			$this->insert_table($insert_data, $table);
			
										
	 }
   function insert_user_social( $request ){
	
			$table = 'userdetails';
			$insert_data = array(
				'username'	  => $request->Email,
				'user_status'	=> "Active",
				
			);
			
			$this->insert_table($insert_data, $table);
			
										
	 }
   
	 function book( $request ){
	
		  $table = 'bookingdetails';
			
			$insert_data = array(
				'username'	  => $request->token,
				'uneaque_id'	=> $request->uneaque_id,
				'purpose'   	=> "Point to Point Transfer",
				'pickup_date' => $request->book_date,
				'pickup_time' => $request->pickup_time,
				
				'drop_area'  	=> $request->drop_area,
				'pickup_area' => $request->pickup_area,
				
				'taxi_type'   => $request->taxi_type,
				'status'			=> "Booking",
				// 'item_status' => "Pending",
				
				'timetype'		=> $request->timetype,
				'amount'		  => $request->amount,
				'km'					=> $request->km
			);
			
			$this->insert_table($insert_data, $table);
			
			$finresult = array( 'status'  => 'success','message' => 'Successfully registered',
											'code'    => 'registered' 
										);
			print json_encode($finresult);								
	 }

   	
 
 /* ------------------- COMMON --------------------------------------------------------
 ******************************************************************************************/

/*  WHETHER TABLE EXIST A DATA
===================================================*/
 function is_exists( $data, $table )
 {
	$this->db->where( $data );
	$query = $this->db->get($table);
	
	if ($query->num_rows() > 0){
		return true;
	}
	else{
		return false;
	}
 }

/*	INSERT INTO TABLE 
 *=========================================================================*/
	function insert_table( $insert_data, $table ){	
		$this->db->insert($table, $insert_data);
	}	

/* GET FROM TABLE 
 *=====================================*/
 
   function get_table_where( $select_data, $where_data, $table){
  
		$this->db->select($select_data);
		$this->db->where($where_data);
		$query  = $this->db->get($table);  //--- Table name = User
		$result = $query->result_array(); 
		return $result;	
   }	
/* GET WHERE IN*/   
 function get_table_where_in_Q( $select_data, $where_data, $table){
  
		$this->db->select($select_data);
		$this->db->where_in('Q_id',$where_data);
		$query  = $this->db->get($table);  //--- Table name = User
		$result = $query->result_array(); 
		return $result;	
   }	
/* GET FROM TABLE OR WHERE
*=====================================*/
	
   function get_table_or_where( $select_data, $where_data,$or_where_data, $table ){
  
		$this->db->select($select_data);
		$this->db->where($where_data);
		$this->db->or_where($or_where_data);
		$query  = $this->db->get($table);  //--- Table name = User
		$result = $query->result_array(); 
		return $result;	
   }	
   
/* UPDATE TABLE
===================================*/	
 function update_table_where( $update_data, $where_data, $table){	
	$this->db->where($where_data);
	$this->db->update($table, $update_data);
	
	
 }
 
/* JOIN TABLE
=======================*/
function get_table_join($select_data, $table, $join_table, $join_data, $join_type, $where_data){
	
	$this->db->select($select_data);
	$this->db->from($table);
	$this->db->join($join_table, $join_data, $join_type);
	$this->db->where($where_data);
	$this->db->order_by("sub1_id","asc");
	
	$query = $this->db->get();
	$result = $query->result_array(); 
	return $result;	
}

function delete_roles( $id ){
	
	$table = 'user_role';
	$where_data = array( 'User_Id' => $id );
	
	$this->delete_table($table, $where_data);
}
function delete_instituts( $id ){
	
	$table = 'users_institutions';
	$where_data = array( 'User_Id' => $id );
	
	$this->delete_table($table, $where_data);
} 
function delete_table($table, $where_data){
	$this->db->delete($table, $where_data); 
} 
 
 /* Arun common */
 /*	INSERT INTO TABLE with Return
 *=========================================================================*/
	function insert_table_r( $insert_data, $table ){	
		return $this->db->insert($table, $insert_data);
	}
	
	/*Web services for call my cab driver App ****Edited by shajeer*/
function driver_login($request)
{
       $table = 'driver_details';	
		$select_data = "*";
	
		$this->db->select($select_data);
		$this->db->where("(user_name = '$request->Email' )");
		$this->db->where('password', $request->Password);
		$query  = $this->db->get($table);  //--- Table name = User
		$result = $query->result_array(); 
	
		if(count($result) > 0){ // user credential is success 
		
			return $result[0];
		
		}
		else{ // user credential failed
			return false;
		}  
}
    function driver_sign_up_model($request)
    {
         $table='driver_details';
        	$insert_data = array(
				'user_name'	  => $request->User_name,
				'phone'	    => $request->Mobile,
				'email'	      => $request->Email,
				'password'	  => $request->Password,
                'name'        => $request->Name  
			);
			
			return $this->db->insert($table, $insert_data);
    }
    
    function driver_id_exist($email,$user_name)
    {
        $table='driver_details';
        $select_data = "*";
        
        $this->db->select($select_data);
        $this->db->where("(user_name = '$user_name' )");
        $query  = $this->db->get($table);  //--- Table name = User
		$result = $query->result_array(); 
        
        $this->db->select($select_data);
        $this->db->where("(user_name = '$email' )");
        $query  = $this->db->get($table);  //--- Table name = User
		$result2 = $query->result_array(); 
        
        if(count($result) > 0 || count($result2) > 0 ){
          return 0;  //already exist
        }
        else
        {
            return 1; //Not exist
        }
    }
    
    function driver_bookings($request)
    {
        $table = 'bookingdetails';	
		$select_data = "*";
	
		$this->db->select($select_data);
		//$this->db->where("(assigned_for = '$request->driver_id' )");
		$this->db->where('assigned_for', $request->driver_id);
        $this->db->order_by("pickup_date","asc");
		$query  = $this->db->get($table);  //--- Table name = User
		$result = $query->result_array(); 
	    
        return $result;
      
		
    }
    
    function update_driver_password($request){
		
		$table = 'driver_details';	

		$select_data = "*";
	
		$this->db->select($select_data);
		$this->db->where("(user_name = '$request->username' )");
		$this->db->where('password', $request->old_pass);
		$query  = $this->db->get($table);  
		$result = $query->result_array(); 
	
		if(count($result) > 0){ // user credential is success 
		
			     $update_data = array(
			'password'     => $request->Password
		               );
		
		         $where_data = array(
			      'user_name'            => $request->username,
		              );
		
		          $this->update_table_where( $update_data, $where_data, $table);
                           return 1;
		
		}
		else{ 
			return 0;
		}  




		
		
		
	}
/*Callmycab driver app webservice ends here */

}//--------------- END Class
?> 
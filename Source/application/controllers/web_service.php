<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  // Allow from any origin
	if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

	// Access-Control headers are received during OPTIONS requests
	if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
			header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
			header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

		exit(0);
	}


class web_service extends CI_Controller
{

	public function __construct()
	{
	parent::__construct();

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('file');
		$this->load->helper('JWT');
		// $this->load->library('form_validation');
		$this->load->model('model_web_service');
		$this->load->database();
		// $this->load->library('session');
		$this->load->library('image_lib');
		// $this->load->helper('cookie');
		$this->load->library('email');
		 // $this->load->library('pagination');

		date_default_timezone_set("Asia/Kolkata");
		// session_start();
	}
	public function index()
	{
		// echo "dd";
	}
	
	public function login(){
			
			$postdata = file_get_contents("php://input");
			$request = json_decode($postdata);
			
			$key_status    = $this->model_web_service->authenticate_key($request);
			
			if( $key_status ){
					$this->do_login($request);
			}else{
				
				$finresult[] = array( 'status'  => 'failed','message' => 'Secret key miss match', 'code'    => 'Login failed' ,
								
								);
				print json_encode($finresult);
			}
			
	}
	
	function do_login($request){
		
		$result = $this->model_web_service->login($request);
			
		if($result){
			//$this->model_web_service->update_device_id($request->device_id, $result['id']);
			$finresult[] = array( 'status'  => 'success','message' => 'Successfully Logged in', 'code'    => 'success' ,
								
									'id'    		=> $result['id'],
									'mobile'		=> $result['mobile'],
									'username'	=> $result['username'],
									'email'			=> $result['email'],
									'token'			=> $this->token_gen( $result['username'] )
								);
			print json_encode($finresult);
		}else{
			$finresult[] = array( 'status'  => 'failed','message' => 'Unknown credential , please try again!', 'code'    => 'Login failed' ,
								
								);
			print json_encode($finresult);
		}
	}
	
	public function social_login(){
			
			$postdata = file_get_contents("php://input");
			$request = json_decode($postdata);
			
			$result = $this->model_web_service->social_login($request);
			
			if($result){
				
				$finresult = array( 'status'  => 'success','message' => 'Successfully Logged in', 'code'    => 'success' ,
									
										'id'    		=> $result['id'],
										'username'	=> $result['username'],
										'token'			=> $this->token_gen( $result['username'] )
										
									);
				print json_encode($finresult);
				
			}else{
				
				$this->model_web_service->insert_user_social($request);
				
				$finresult = array( 'status'  => 'success','message' => 'Successfully registered','code'    => 'registered' ,
													'token'			=> $this->token_gen( $request->Email )
										);
										
				print json_encode($finresult);	
			}
	}
	
	public function sign_up(){
			
			$postdata = file_get_contents("php://input");
			$request = json_decode($postdata);
			
			$key_status    = $this->model_web_service->authenticate_key($request);
			
			if( $key_status ){
					$this->do_sign_up($request);
			}else{
				$error_list[] = array(
										'message' => 'Secret key miss match',
										'code'    => 'Secret key miss match'		
									);
				$finresult = array( 
					'status'  => 'failed',
					'error_list' => $error_list
				);
				print json_encode($finresult);
			}
			
	}
	
	function do_sign_up($request){
	
			
			$mail_status    = $this->model_web_service->is_mail_exists($request->Email);
			$user_status    = $this->model_web_service->is_username_exists($request->User_name);
			$mobile_status  = $this->model_web_service->is_mobile_exists($request->Mobile);
			
			if( $mail_status || $user_status || $mobile_status ) //CHECK MAIL ID OR USER NAME EXIST
			{	
				
				//$error_list = array();
				
				if($mail_status){
					$error_list[] = array(
										'message' => 'Mail Id already in use',
										'code'    => 'exists'		
									);
				}
				if($user_status){
					$error_list[] = array(
										'message' => 'User Name already in use',
										'code'    => 'exists'		
									);
				}
				if($mobile_status){
					$error_list[] = array(
										'message' => 'Mobile number already in use',
										'code'    => 'exists'		
									);
				}
				
				$finresult = array( 
								'status'  => 'failed',
								'error_list' => $error_list
							);
				
				print json_encode($finresult);
				
				
			}else{
				
				$this->model_web_service->insert_user_details($request);
				
				$finresult = array( 'status'  => 'success','message' => 'Successfully Signed up', 'code'    => 'success' ,
										'token'			=> $this->token_gen( $request->User_name )
								);
								
				print json_encode($finresult);
				
			}	
	}
	
	public function fetch_cab_details(){
		
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		
		$myDate = new DateTime();
		$myDate->setTimestamp( strtotime( $request->book_date) );
		
		$time =  $myDate->format("H");
		
		if( $time >= 22 ||  $time <= 6){
			$timetype = 'night';
		}else{
			$timetype = 'day';
		}
		
		$request->timetype	= $timetype;
		
		$result = $this->model_web_service->fetch_cabs( $request );
		
		$finresult = array( 
													'status'  => 'success', 
													'cabs'		=> $result
									 );
		print json_encode( $finresult );
		
	}
	public function load_trips(){
		
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		
		$myDate = new DateTime();
		
		$current_date =  $myDate->format("m/d/Y");
		
		$request->token = $this->extract_token( $request->token );
		
		$result = $this->model_web_service->load_trips( $request );
		
		$success 		= array();
		$booking 		= array();
		$Cancelled	= array();
		
		foreach( $result as $item ){
			if( $item['status'] == 'Complete'){
				$success[] = $item;
			}else if( $item['status'] == 'Booking' ){
				$booking[] = $item;	
			}else if( $item['status'] == 'Cancelled' ){
				$Cancelled[] = $item;	
			}
			
		}
		
		$finresult = array( 
													'status'    => 'success', 
													'all'			  => $result,
													'booking'   => $booking,
													'Cancelled' => $Cancelled,
													'success'   => $success,
													
									 );
		print json_encode( $finresult );
		
	}
	public function load_card_rate(){
		
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		
		$result = $this->model_web_service->load_all_cabs( $request );
		
		$day 		= array();
		$night 	= array();
		
		foreach( $result as $item ){
			if( $item['timetype'] == 'day'){
				$day[] = $item;
			}else if( $item['timetype'] == 'night' ){
				$night[] = $item;	
			}
		}
		
		$finresult = array( 
													'status'    => 'success', 
													'day'			  => $day,
													'night'   	=> $night
									 );
		print json_encode( $finresult );
	}
	
	public function update_pwd(){
			
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		
		$request->token = $this->extract_token( $request->token );
		
		$result = $this->model_web_service->update_pwd($request);
		
		$finresult = array( 
												'status'    => 'success', 
											);
		print json_encode( $finresult );
	}
	
  public function book_cab(){
		
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
			
		$request->uneaque_id = 'CMC'.strtotime(date('m/d/Y H:i:s'));
		
		
		
		$myDate = new DateTime();
		$myDate->setTimestamp( strtotime( $request->book_date) );
		
		$time =  $myDate->format("H");
		
		if( $time >= 22 ||  $time <= 6){
			$request->timetype = 'night';
		}else{
			$request->timetype = 'day';
		}
		
		$request->book_date   =  $myDate->format("m/d/Y");
		$request->pickup_time =  $myDate->format("h:i a");
		
		$request->token = $this->extract_token( $request->token );
		var_dump($request );
		$this->model_web_service->book($request);
	}
	
	function token_gen($item){
		
		// $token = array();
		// $token['id'] = 1;
		return JWT::encode($item, APP_SECRET_KEY );
	
	}
	function extract_token($item){
		$token = JWT::decode($item, APP_SECRET_KEY );
		
		return $token;
	}
	
	public function settings(){
		$result = $this->model_web_service->load_settings();
		print json_encode($result[0]);
	}
	
	/*Shajeer Callmycab driver app starts here*/
    public function driver_login(){
		$postdata = file_get_contents("php://input");
    	$request = json_decode($postdata);
        $result = $this->model_web_service->driver_login($request);
        
        if($result){
			
			$finresult[] = array( 'status'  => 'success','message' => 'Successfully Logged in', 'code'    => 'success' ,					
									'id'    		=> $result['id'],
									'mobile'		=> $result['phone'],
									'username'	=> $result['user_name'],
									'email'			=> $result['email']
									
								);
			print json_encode($finresult);
		}else{
			$finresult[] = array( 'status'  => 'failed','message' => 'Unknown credential , please try again!', 'code'    => 'Login failed' ,
								
								);
			print json_encode($finresult);
		}
        
     //var_dump($request);
    }
    
    
    
    public function driver_sign_up()
    {
        $postdata = file_get_contents("php://input");
			$request = json_decode($postdata);
       
        $already_exist=$this->model_web_service->driver_id_exist($request->Email,$request->User_name);

			if( $already_exist ){  //new user
					$driver_register=$this->model_web_service->driver_sign_up_model($request);
                          $success_msg=array( 'message' => 'Successfully registered',
                                      'status'  => 'success'
                                    );
                          print json_encode($success_msg);  
			}else{
				$error_list[] = array(
										'message' => 'User Name or Email id Already exists',
										'code'    => 'User Name or Email id Allready exists'		
									);
				$finresult = array( 
					'status'  => 'failed',
					'error_list' => $error_list
				);
				print json_encode($finresult);
			}
        
        
       
        

    }
    
    
    
    public function driver_bookings()
    {
        $postdata = file_get_contents("php://input");
    	$request = json_decode($postdata);
         $result = $this->model_web_service->driver_bookings($request);
        
        $new_rade 	= array();
		$complete 	= array();
		$Cancelled	= array();
        
        //var_dump($result);
        
        foreach($result as $item ){
			if( $item['status'] == 'Processing'){
				$new_rade[] = $item;
			}else if( $item['status'] == 'Complete' ){
				$complete[] = $item;	
			}else if( $item['status'] == 'Cancelled' ){
				$Cancelled[] = $item;	
			}
			
		}

             $settings_table = 'settings';	
		$select_data = "measurements,currency";
	
		$this->db->select($select_data);
		
		$this->db->where('id', 1 );
		
		$query  = $this->db->get($settings_table); 
		$settings_result = $query->result_array(); 
            

		
		$finresult = array( 
								'status'      => 'success', 
								'all'		  => $result,
								'new_rade'    => $new_rade,
								'complete'    => $complete,
								'Cancelled'   => $Cancelled,
								'settings'    => $settings_result
									 );
		print json_encode( $finresult );
        
        //var_dump($result);
    }
    /*Fetch data ride rate 
    sends JSON as Post data, which holds the entire row data of current booking
    */
    public function getRide_rate()
    {
        $postdata = file_get_contents("php://input");
    	$request = json_decode($postdata);
        
         $booking_id= $request->uneaque_id;
        
         $purpose=$request->purpose;
         $taxi_type=$request->taxi_type;
         $package=$request->package;
         $transfer=$request->transfer;
         $timetype=$request->timetype;
        
        $table='cabdetails';
        $select_data="";
       // echo $transfer;
        
        if($purpose=="Point to Point Transfer")
        { 
               $select_data="intialkm,intailrate,standardrate" ; 
        }
        
        if($purpose=="Airport Transfer")
        { 
               
            if($transfer=="going")
            {
                $select_data="intialkm,intailrate,standardrate" ; 
            }
            
            if($transfer=="coming")
            {
                $select_data="fromintialkm,fromintailrate,fromstandardrate";
            }
        }
        
        if($purpose=="Outstation Transfer")
        { 
              
            if($transfer=="oneway")
            {
                $select_data="standardrate" ; 
            }
            
            if($transfer=="round")
            {
                $select_data="fromstandardrate";
            }
        }
        
        if($purpose=="Hourly Rental")
        { 
            $select_data="standardrate" ;   
        }

       $where_con= array();
             
        if($purpose!="")
        {
            $where_con = array_merge($where_con, array('transfertype' => $purpose));
        }
          if($taxi_type!="")
        {
            $where_con = array_merge($where_con, array('cartype'=>$taxi_type));
        }
         if($taxi_type!="")
        {
            $where_con = array_merge($where_con, array('cartype'=>$taxi_type));
        }
        if($package!="")
        {
            $where_con = array_merge($where_con, array('package' => $package));
        }
        if($timetype!="")
        {
             $where_con = array_merge($where_con, array('timetype' => $timetype));
        }
            
                $this->db->select($select_data);
                $this->db->where($where_con);
                $query  = $this->db->get($table);
                $result = $query->result_array(); 
        if(count($result)>0)
        {
            $final_result= array(
              'status' => "success",
              'purpose'   => $purpose,
              'transfer_tyepe'=>$transfer,  
              'booking_id'    =>$booking_id,
              'raw_data' => $result
            );
        }
        else
        {
            $final_result= array(
              'status' => "failed",
               'message'=> "No fields exist"
            );
        }
   
     print json_encode($final_result);
        
    }
    
    public function update_driver_pwd(){
			
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		
		//$request->token = $this->extract_token( $request->token );
		
		$result = $this->model_web_service->update_driver_password($request);
                
                 if($result==1)
                  {
                  $finresult = array( 'status' => 'success', );
                  }
                  else{
                    $finresult = array( 'status' => 'fail', );
                   }
		
		 
                print json_encode( $finresult );
	}


         public function set_ride_as_complete()
        {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $table="bookingdetails";
        $data = array(   
               'status' => 'Complete'
            );

        $this->db->where('uneaque_id', $request->current_ride_id);
       $result= $this->db->update($table, $data);
        if(1)
           {
            echo "success";
           }

        
          }

         public function fetchDriverAppLanguage(){
			$this->db->select('language_meta');
			$this->db->where('status','1');
			$query  = $this->db->get('app_languages');
			$result = $query->row();
			if(count($result)){
				echo  $result->language_meta;
			}else{
				echo "No data";
			}
		}
		
		  public function fetchUserAppLanguage(){
			$this->db->select('language_meta');
			$this->db->where('status','1');
			$query  = $this->db->get('user_app_language');
			$result = $query->row();
			if(count($result)){
				echo  $result->language_meta;
			}else{
				echo "No data";
			}
		}


    /*Shajeer Callmycab driver app ends here*/
}			
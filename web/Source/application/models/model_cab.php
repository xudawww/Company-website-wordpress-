<?php
ob_start();
class Model_cab extends CI_Model{

function __construct() {

parent::__construct();

}
//forgot password start
 function forgot_password($email){
    $query = $this->db->query("SELECT * FROM userdetails WHERE email='$email'")->row();



    if(count($query)>0){
       $unique_id = md5(mt_rand(100000,999999));
      $this->db->where('email',$email)->update('userdetails',array('unique_id'=> $data['unique_id']=$unique_id));
      return $this->forgot_mail($email);
    } else {
      return 0;
    }
   }


   function forgot_mail($email){

$setting = getSettings();


    $this->db->where('email', $email);
    $query = $this->db->get('customer_registration');
    $result = $query->row(); 
    $unique_id  =$result->unique_id;  

    $this->load->library('email');
            $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => $setting->smtp_host,
                    'smtp_port' => 587,
                    'smtp_user' => $setting->smtp_username, // change it to yours
                    'smtp_pass' => $setting->smtp_password, // change it to yours
                    'smtp_timeout'=>20,
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1',
                    'wordwrap' => TRUE
                   );

             $this->email->initialize($config);// add this line

            $subject = 'Forgot Password Request'; 
            $urls= base_url().'Home/password_reset/'.$unique_id; 
            $name=$setting->title;
            $mailTemplate='<div style="width:660px; height:230px; margin:0 auto; background:#874da3; 
              padding:20px 20px 20px 20px; font-family: Century Gothic,Verdana,Geneva,sans-serif; 
              border:solid #c79e13 1px;"> <div style="width:100%; float:left; padding:0 0 10px 0;"> 
              

              </div> 
              <div style="background:#fff; float:left; width:96.3%; border-top-right-radius: 8px; 
              border-top-left-radius: 8px; padding:15px 12px 0 12px; "> <div style="width:100%; 
              padding:10px 0 10px 0; float:left; color:#666261; font-size:14px;"> 
              Hi , thanks for registering with Clickkart.</div> 
              <div style="width:100%; float:left; padding:20px 0 20px 0; border-bottom:solid #cdcdcd 1px; 
              border-top:solid #cdcdcd 1px;"> <div style="width:100%; float:left; font-size:17px;"> Your Password Reset Link# '.$urls.'</div> 
              <div style="width:30%; float:left;"> </div> 
              </div> 
              </div> 
             
              
              
            <div style="width:100%; float:left;"> 
             
              </div> 
              
              </div>';

              //$this->email->set_newline("\r\n");
              $this->email->from($setting->admin_email, $name);
              $this->email->to($result->email);
              $this->email->subject($subject);
              $this->email->message($mailTemplate);  
              echo $this->email->send();
   }
   
//forgot password end



function cmc_sms($mob_no,$msg)

   {

	   $query = $this->db->query(" SELECT * FROM `settings` order by id DESC ");

		$row = $query->row('settings');

		

		

       $sender_id = $row->sender_id; // sender id    

       $pwd = $row->sms_password;  

	   $user = $row->sms_username; //your SMS gatewayhub account password        

       $str = trim(str_replace(" ", "%20", $msg));

       // to replace the space in message with  ‘%20’

       $url="http://api.smsgatewayhub.com/smsapi/pushsms.aspx?user=".$user."&pwd=".$pwd."&to=91".$mob_no."&sid=".$sender_id."&msg=".$str."&fl=0&gwid=2";

       // create a new cURL resource

       $ch = curl_init();

       

       // set URL and other appropriate options

       curl_setopt($ch, CURLOPT_URL,$url);

       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

       // grab URL and pass it to the browser

       curl_exec($ch);

       // close cURL resource, and free up system resources

       curl_close($ch);

	   //return true;

     }

	 

/*	 function sign_up($data)

{

	  $username = $data['username'];

	  $email = $data['email'];

	  $mobile =  $data['mobile'];

	  if($data['type']=='user'){

		

		$this->db->where('username', $username);

		$query = $this->db->get('userdetails');

	 

		if($query->num_rows == 0)

			{

			 $this->db->where('email',  $email);

			 $query1 = $this->db->get('userdetails');

			 if($query1->num_rows == 0)

				{

				 $this->db->where('mobile', $mobile);

				 $query1 = $this->db->get('userdetails');

				 if($query1->num_rows == 0)

				  {

					$data['active_id'] = mt_rand(100000,999999); 

					$smobile = $data['mobile'];

					$code = $data['active_id'];

					  

					$query3 = $this->db->query("SELECT * FROM `settings` order by id DESC");

					$row3 = $query3->row('settings');

					$communication1 = $row3->communication;

					$verification = $row3->verification;

					if($verification == 'on'){

					  if($communication1 == 'sms'){

						$sms="Your Call MY Cab verification code is ".$code." ";

						$this->Model_cab->cmc_sms($smobile,$sms);

					  }else{

						$from= $row3->smtp_username;

						$name=$row3->title;

						$msg="Your Call MY Cab verification code is ".$code."";

						$sub="Verification Code";

						$email = $email;

						$this->Model_cab->send_mail($from,$name,$email,$sub,$msg);

					   }

					 $this->session->set_userdata('last_reg_details',json_encode($data));

					}else{

					   $data['user_status'] = 'Active';

					   $data['password'] =md5($data['password']);

					   if($this->db->insert('userdetails',$data))

						 {

							$this->session->set_userdata('username',$data['username']);

							$this->session->set_userdata('type',$data['type']);

							$user1 = $this->session->userdata('username');

							echo $user1;

						 }else{

							echo 2;

							}

						 }

				   }else{

					echo 5;

						}

				}else{

				  echo 4;

					 }

		    }else{

				echo 3;

			  }

		}else{

			$this->db->where('user_name', $username);

			$query = $this->db->get('driver_details');

			if($query->num_rows == 0)

			 {

				$this->db->where('email',  $email);

				$query1 = $this->db->get('	driver_details');

				if($query1->num_rows == 0)

				 {

					$this->db->where('phone', $mobile);

					$query1 = $this->db->get('	driver_details');

					if($query1->num_rows == 0)

					 {

						$data['active_id'] = mt_rand(100000,999999); 

						$smobile = $data['mobile'];

						$code = $data['active_id'];

					    $query3 = $this->db->query(" SELECT * FROM `settings` order by id DESC ");

						$row3 = $query3->row('settings');

						$communication1 = $row3->communication;

						$verification = $row3->verification;

						if($verification == 'on'){

						  if($communication1 == 'sms'){

							  $sms="Your Call MY Cab verification code is ".$code." ";

							  $this->Model_cab->cmc_sms($smobile,$sms);

						   }else{	

							 $from= $row3->smtp_username;

							 $name=$row3->title;

						     $msg="Your Call MY Cab verification code is ".$code."";

                             $sub="Verification Code";

							 $email = $email;

							 $this->Model_cab->send_mail($from,$name,$email,$sub,$msg);

							  }

						  $this->session->set_userdata('last_reg_details',json_encode($data));

						  }else{

							$datas = array(

							'user_status'=>'Inactive',

							'user_name'=>$data['username'],

							'phone'=>$data['mobile'],

							'email'=>$data['email'],

							'password'=>$data['password']

							);

						if($this->db->insert('driver_details',$datas))

						  {

							$this->session->set_userdata('username',$data['username']);

							$this->session->set_userdata('type',$data['type']);

							$user1 = $this->session->userdata('username');

							echo 'driver';

						  }else{

							echo 2;

								}

							  }

							}else{

								echo 5;

								}

							}else{

								echo 4;

								}

							}else{

								echo 3;

								} 

			 }

	}

	*/

	 

/* function sign_up($data)

{  

	  $username = $data['username'];

	  $email = $data['email'];

	  $mobile =  $data['mobile'];

	  if($data['type']=='user'){

		

		$this->db->where('username', $username);

		$query = $this->db->get('userdetails');

	 

		if($query->num_rows == 0)

			{   

			 $this->db->where('email',  $email);

			 $query1 = $this->db->get('userdetails');

			 if($query1->num_rows == 0)

				{

				 $this->db->where('mobile', $mobile);

				 $query1 = $this->db->get('userdetails');

				 if($query1->num_rows == 0)

				  {

					$data['active_id'] = mt_rand(100000,999999); 

					$smobile = $data['mobile'];

					$code = $data['active_id'];

					  

					$query3 = $this->db->query("SELECT * FROM `settings` order by id DESC");

					$row3 = $query3->row('settings');

					$communication1 = $row3->communication;

					$verification = $row3->verification;

					if($verification == 'on'){

						

						

						$fields = array(

                        'id' => array(

                                                 'type' => 'INT',

                                                 'constraint' => 5,

                                                 'unsigned' => TRUE,

                                                 'auto_increment' => TRUE

                                          ),

                        'verification_code' => array(

                                                 'type' => 'VARCHAR',

                                                 'constraint' => '100',

                                          ),

                        'username' => array(

                                                 'type' =>'VARCHAR',

                                                 'constraint' => '100',

                                                  

                                          ), );



						$this->dbforge->add_field($fields);

						$this->dbforge->add_key('id', TRUE);

						$this->dbforge->create_table('verification_code', TRUE);

						

						 $datas['verification_code'] =$code;

						 $datas['username'] = $username ;

						$this->db->insert('verification_code',$datas);

						

					    if($communication1 == 'sms'){

						$sms="Your Call MY Cab verification code is ".$code." ";

						$this->Model_cab->cmc_sms($smobile,$sms);

					  }else{

						$from= $row3->smtp_username;

						$name=$row3->title;

						$msg="Your Call MY Cab verification code is ".$code."";

						$sub="Verification Code";

						$email = $email;

						$this->Model_cab->send_mail($from,$name,$email,$sub,$msg);

					   }

					    echo "verify";

					 //$this->session->set_userdata('last_reg_details',json_encode($data));

					}else{

					   $data['user_status'] = 'Active';

					   $data['password'] =md5($data['password']);

					   if($this->db->insert('userdetails',$data))

						 {

							$this->session->set_userdata('username',$data['username']);

							$this->session->set_userdata('type',$data['type']);

							$user1 = $this->session->userdata('username');

							echo $user1;

						 }else{

							echo 2;

							}

						 }

				   }else{

					echo 5;

						}

				}else{

				  echo 4;

					 }

		    }else{

				echo 3;

			  }

		}else{

			$this->db->where('user_name', $username);

			$query = $this->db->get('driver_details');

			if($query->num_rows == 0)

			 {

				$this->db->where('email',  $email);

				$query1 = $this->db->get('	driver_details');

				if($query1->num_rows == 0)

				 {

					$this->db->where('phone', $mobile);

					$query1 = $this->db->get('	driver_details');

					if($query1->num_rows == 0)

					 {

						$data['active_id'] = mt_rand(100000,999999); 

						$smobile = $data['mobile'];

						$code = $data['active_id'];

					    $query3 = $this->db->query(" SELECT * FROM `settings` order by id DESC ");

						$row3 = $query3->row('settings');

						$communication1 = $row3->communication;

						$verification = $row3->verification;

						if($verification == 'on'){

						  if($communication1 == 'sms'){

							  $sms="Your Call MY Cab verification code is ".$code." ";

							  $this->Model_cab->cmc_sms($smobile,$sms);

						   }else{	

							 $from= $row3->smtp_username;

							 $name=$row3->title;

						     $msg="Your Call MY Cab verification code is ".$code."";

                             $sub="Verification Code";

							 $email = $email;

							 $this->Model_cab->send_mail($from,$name,$email,$sub,$msg);

							  }

						  $this->session->set_userdata('last_reg_details',json_encode($data));

						  }else{

							$datas = array(

							'user_status'=>'Inactive',

							'user_name'=>$data['username'],

							'phone'=>$data['mobile'],

							'email'=>$data['email'],

							'password'=>$data['password']

							);

						if($this->db->insert('driver_details',$datas))

						  {

							$this->session->set_userdata('username',$data['username']);

							$this->session->set_userdata('type',$data['type']);

							$user1 = $this->session->userdata('username');

							echo 'driver';

						  }else{

							echo 2;

								}

							  }

							}else{

								echo 5;

								}

							}else{

								echo 4;

								}

							}else{

								echo 3;

								} 

			 }

	}*/

	
function call_back_func($data)
{   
$result = array('phone'=>$data);
$ress=$this->db->insert('callback',$result);
if($ress)
{
	echo 1;
}
else{
	echo 0;
}
}

	function sign_up($data)

{  
unset($data['sign_show']);
 $username = $data['username'];
 $email = $data['email'];
 $mobile =  $data['mobile'];
  
 if($data['type']=='user'){
 $this->db->where('username', $username);
 $query = $this->db->get('userdetails');
 if($query->num_rows == 0)
	{   
		$this->db->where('email',  $email);
		$query1 = $this->db->get('userdetails');
		if($query1->num_rows == 0)
		{
			$this->db->where('mobile', $mobile);
			$query1 = $this->db->get('userdetails');
			if($query1->num_rows == 0)
			{
				$data['active_id'] = mt_rand(100000,999999); 
				$smobile = $data['mobile'];
				$code = $data['active_id'];
				$query3 = $this->db->query("SELECT * FROM `settings` order by id DESC");
				$row3 = $query3->row('settings');
				$communication1 = $row3->communication;
				$verification = $row3->verification;
				if($verification == 'on'){
				if($communication1 == 'sms'){
				$sms="Your Call MY Cab verification code is ".$code." ";
				$this->Model_cab->cmc_sms($smobile,$sms);
				}else{
				$from= $row3->smtp_username;
				$name=$row3->title;
				$sub="Verification Code";
						
						
						 $msg='<div style="width:660px; height:400px; margin:0 auto; background:#F7941E; padding:20px 20px 20px 20px; font-family: Century Gothic,Verdana,Geneva,sans-serif; border:solid #de851b 1px;">
	
    <div style="width:100%; float:left; padding:0 0 10px 0;">
     
    <div style="width:350px; float:left; padding:25px 0 0 0; text-align:center; font-size:18px; "> CONTACT DETAILS </div>
     </div>
     <div style="background:#fff;  float:left; width:96.3%;   border-top-right-radius: 8px; border-top-left-radius: 8px; padding:15px 12px 0 12px;  ">
    		<div style="width:100%; padding:10px 0 10px 0; float:left; color:#666261; font-size:14px; text-align:center;">Thank you for choosing our service. We are happy to serve you!!!</div>
                 <div style="width:100%; float:left; padding:15px 0 15px 0; border-bottom:solid #cdcdcd 1px; border-top:solid #cdcdcd 1px;"> 
                 <div style="width:100%; float:left; font-size:14px; text-align:center;">Your Call MY Cab verification code is'.$code.'</div>
            </div>
        </div></div>
        <div style="background:#fff;  float:left; width:96.3%;    border-bottom-right-radius: 8px; border-bottom-left-radius: 8px; padding:20px 12px 20px 12px;  "></div>
          </div>';

						$email = $email;

						$mail_res=$this->Model_cab->send_mail($from,$name,$email,$sub,$msg);
						
						if($mail_res!="success")
						{
							echo "mail_smtp_incorrect";
							exit;
						}
						 
					   }

					    echo "verify";

					 $this->session->set_userdata('last_reg_details',json_encode($data));

					}else{

					   $data['user_status'] = 'Active';

					   $data['password'] =md5($data['password']);

					   if($this->db->insert('userdetails',$data))

						 {

							$this->session->set_userdata('username',$data['username']);

							$this->session->set_userdata('type',$data['type']);

							$user1 = $this->session->userdata('username');

							echo $user1;

						 }else{

							echo 2;

							}

						 }

				   }else{

					echo 5;

						}

				}else{

				  echo 4;

					 }

		    }else{

				echo 3;

			  }

		}else{
 
			$this->db->where('user_name', $username);

			$query = $this->db->get('driver_details');

			if($query->num_rows == 0)

			 {

				$this->db->where('email',  $email);

				$query1 = $this->db->get('driver_details');

				if($query1->num_rows == 0)

				 {

					$this->db->where('phone', $mobile);

					$query1 = $this->db->get('driver_details');

					if($query1->num_rows == 0)

					 {

						$data['active_id'] = mt_rand(100000,999999); 

						$smobile = $data['mobile'];

						$code = $data['active_id'];

					    $query3 = $this->db->query(" SELECT * FROM `settings` order by id DESC ");

						$row3 = $query3->row('settings');

						$communication1 = $row3->communication;

						$verification = $row3->verification;

						if($verification == 'on'){

						  if($communication1 == 'sms'){

							  $sms="Your Call MY Cab verification code is ".$code." ";

							  $this->Model_cab->cmc_sms($smobile,$sms);

						   }else{	

							 $from= $row3->smtp_username;

							 $name=$row3->title;

						     $msg='<div style="width:660px; height:400px; margin:0 auto; background:#F7941E; padding:20px 20px 20px 20px; font-family: Century Gothic,Verdana,Geneva,sans-serif; border:solid #de851b 1px;">
	
    <div style="width:100%; float:left; padding:0 0 10px 0;">
    
    <div style="width:350px; float:left; padding:25px 0 0 0; text-align:center; font-size:18px; "> OTP Verification </div>
     </div>
     <div style="background:#fff;  float:left; width:96.3%;   border-top-right-radius: 8px; border-top-left-radius: 8px; padding:15px 12px 0 12px;  ">
    		<div style="width:100%; padding:10px 0 10px 0; float:left; color:#666261; font-size:14px; text-align:center;">Thank you for choosing our service. We are happy to serve you!!!</div>
                 <div style="width:100%; float:left; padding:15px 0 15px 0; border-bottom:solid #cdcdcd 1px; border-top:solid #cdcdcd 1px;"> 
                 <div style="width:100%; float:left; font-size:14px; text-align:center;">Your Call MY Cab verification code is'.$code.'</div>
            </div>
        </div></div>
        <div style="background:#fff;  float:left; width:96.3%;    border-bottom-right-radius: 8px; border-bottom-left-radius: 8px; padding:20px 12px 20px 12px;  "></div>
          </div>';

                             $sub="Verification Code";

							 $email = $email;

							 $this->Model_cab->send_mail($from,$name,$email,$sub,$msg);

							  }

						  $this->session->set_userdata('last_reg_details',json_encode($data));
							  echo "verify";
						  }else{

							$datas = array( 

							'user_status'=>'Active',

							'user_name'=>$data['username'],
							'name'=>$data['username'],

							'phone'=>$data['mobile'],

							'email'=>$data['email'],

							'password'=>$data['password']

							);
							
						if($this->db->insert('driver_details',$datas))

						  {

							$this->session->set_userdata('username',$data['username']);

							$this->session->set_userdata('type',$data['type']);

							$user1 = $this->session->userdata('username');

							echo 'driver';

						  }else{
							echo 2;
								}
							  }
							}else{
								echo 5;
								}
							}else{
								echo 4;
								}
							}else{
								echo 3;
								}  

			 }

	}



function selected_cartype($data){
	
	$query1 = $this->db->query("select * from driver_details where user_name ='$data'");
	return $row3 = $query1->row();
	// $cartype=$row3->car_type;
}
	
function login($data){

	 // grab user input

	//print_r($data);exit;
unset($data['log_show']);
        $username = $data['username'];
       // print_r($username);
       //  exit;

        $password = md5($data['password']);

		$remember='';

		if(isset($data['rememberme'])){

        $remember = $data['rememberme'];

		}

        // Prep the query

		

        if($data["user"]=='user')

		{

		// Run the query

		$query = $this->db->query("select * from userdetails where binary username ='$username' and binary password = '$password' and user_status='Active'");
		// echo $this->db->last_query();

        }else{

			$password1=$data['password'];

			$query = $this->db->query("select * from driver_details where binary user_name ='$username' and binary password = '$password1' ");

		}

        // Let's check if there are any results

	 

        if($query->num_rows == 1)

        { 

            // If there is a user, then create session data

            //$row = $query->result_array();

		if($remember=='on' && $remember!=''){

			

	$cookie = array(

                'name'   => 'username',

                'value'  => $username,

                'expire' => 86500

            );

        //  $this->ci->db->insert("UserCookies", array("CookieUserEmail"=>$userEmail, "CookieRandom"=>$randomString));

        $this->input->set_cookie($cookie);

		$this->input->cookie('username', false);    

		}

		$this->session->set_userdata('username',$data['username']);

		$this->session->set_userdata('type',$data["user"]);

		$user = $this->session->userdata('username');

		$type = $this->session->userdata('type');

        //return $row;

		if($type=="user"){

				echo $user;	

			}else{

				echo $type;

			}

        }

        // If the previous process did not validate

        // then return false.

		else

		{

        //return false;

		echo 1;

		}



}

function booking($data){

	//var_dump($data);

	 $query3 = $this->db->query(" SELECT * FROM `settings` order by id DESC ");

	$row3 = $query3->row('settings');

	if($this->session->userdata('username') || $this->input->cookie('username', false)){

		if($this->session->userdata('username')){

		$data['username']=$this->session->userdata('username');

		}else{

			$data['username']= $this->input->cookie('username', false);

		}

		$data['uneaque_id'] = 'CMC'.strtotime(date('m/d/Y H:i:s'));

		

		

		$wh="";

		if(isset($data['timetype'])){

		$timetype=$data['timetype'];

		$type=$data['timetype'];

		$wh ="AND timetype='$type'";

		}

		if(isset($data['package'])){

		$pack =$data['package'];

		$wh ="AND package='$pack'";

        }

		 $username =$data['username'];

		 $purpose = $data['purpose'];

		 $car= $data['taxi_type'];

        $time =$data['pickup_time'];

		

		$query = $this->db->query("SELECT * FROM  cabdetails WHERE     cartype ='$car' AND transfertype ='$purpose' ".$wh);

        $row = $query->row('cabdetails');

		

		if($purpose =='Point to Point Transfer'){

			if($query->num_rows > 0){

			$km=$data['km'];

			$Ik = $row->intialkm;

		$Ir = $row->intailrate;

		$Sr= $row->standardrate;

			if($Ik > $km){

				$amount1 = ($Ik-$km)*$Sr + $Ir;

			}else if($km > $Ik){

				$amount1 = ($km-$Ik)*$Sr + $Ir;

			}else{

				$amount1 =  $Ir;

			}

			

			}

		}elseif($purpose =='Airport Transfer'){

			$km=$data['km'];

			$transfertype = $data["transfer"];

			if($query->num_rows > 0){

			if($transfertype='going'){

				$Ik = $row->intialkm;

		        $Ir = $row->intailrate;

		        $Sr= $row->standardrate;

		     if($Ik > $km){

				$amount1 = ($Ik-$km)*$Sr + $Ir;

			}else if($km > $Ik){

				$amount1 = ($km-$Ik)*$Sr + $Ir;

			}else{

				$amount1 =  $Ir;

			}

		

			

				

			}else{

				$Ik = $row->fromintialkm;

		        $Ir = $row->fromintialrate;

		        $Sr= $row->fromstandardrate;

		     if($Ik > $km){

				$amount1 = ($Ik-$km)*$Sr + $Ir;

			  }else if($km > $Ik){

				$amount1 = ($km-$Ik)*$Sr + $Ir;

			  }else{

				$amount1 =  $Ir;

			    }

			}

			}

			

		}else if($purpose =='Outstation Transfer'){

			$transfertype = $data["transfer"];

			if($query->num_rows > 0){

			if($transfertype=='oneway'){

				

				 $Sr= $row->standardrate;

				

				  $amount1 = $Sr;

				

			}else{

				

				 $Sr= $row->fromstandardrate;

				

				  $amount1 = $Sr;

				

			}

			}

		}else{

			

			

		if($query->num_rows > 0){

			 $Sr=$row->standardrate;

			 $amount1 = $Sr;

		}

		}

		if(isset($data['promo_code'])){

			$select_data="*";

			$table = "promocode";  //------------ Select table

			$where_data = array(

				'promocode'     => $data['promo_code']

			);

			$result = $this->get_table_where( $select_data, $where_data, $table );

			$today =date('Y-m-d H:i:s');

			

			if($today <=$result[0]['enddate']){

              if($result[0]['type'] =='Fixed'){

				  $newAmount = $amount1 - $result[0]['amount'];

				

			  }else{

				   $newAmount=$amount1*$result[0]['amount']/100;

				 

			  }

			}else{

				$newAmount=$amount1;

			}

		}

		$data['amount']=$newAmount;

		

		

	if($this->db->insert('bookingdetails',$data))

{

	$this->session->set_userdata('uneaqueid',$data['uneaque_id']);

	$id= $this->db->insert_id();

 $this->session->set_userdata('bookid',$id);

 $this->session->set_userdata('amount',$newAmount);

 // $this->session->userdata('bookid');

 $this->db->where('username', $data['username']);

	$query2 = $this->db->get('userdetails');

	

	$from= $row3->smtp_username;

	$paypal = $row3->paypal_option;

    $name=$row3->title;

    $msg='Booking';

    $sub="Booking Details";

	$email = $query2->row('email');

    $km1 =	$row3->measurements;

	$str = $row3->currency;

	$curr = explode(',',$str);

	$mailTemplate='<div style="width:660px; height:640px; margin:0 auto; background:#F7941E; padding:20px 20px 20px 20px; font-family: Century Gothic,Verdana,Geneva,sans-serif; border:solid #c79e13 1px;">
	<div style="width:100%; float:left; padding:0 0 10px 0;">
 

    <div style="width:350px; float:left; padding:25px 0 0 0; text-align:center; font-size:18px; "> BOOKING DETAILS </div>
	</div>
	<div style="background:#fff;  float:left; width:96.3%;   border-top-right-radius: 8px; border-top-left-radius: 8px; padding:15px 12px 0 12px;  ">

    		<div style="width:100%; padding:10px 0 10px 0; float:left; color:#666261; font-size:14px;"> Hi '. $this->session->userdata('username').' , thank you for booking with us. </div>

                 <div style="width:100%; float:left; padding:20px 0 20px 0; border-bottom:solid #cdcdcd 1px; border-top:solid #cdcdcd 1px;"> 

                 <div style="width:30%; float:left; font-size:17px;"> Trip#1 </div>

                 <div style="width:40%; float:left; font-size:17px;">'.$data['uneaque_id'].' </div>

                 <div style="width:30%; float:left;">  

                 

                 <a href="#"> <div style="width:100px; height:30px; background:#58585a; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; font-size:12px; color:#fff; 

                 text-align:center; line-height:25px; text-decoration:none; float:right;"> Track Booking </div> </a>

                 

                  </div>

            </div>

        </div>
		<div style="background:#3a3a3c;     float:left; width:96.3%;  padding:0px 12px 10px 12px;">

        	<div style="width:100%; float:left; padding:35px 0 30px 0;">

            <div style="width:43%; float:left; color:#ffdd1a; font-size:16px; padding:5px 0 0 0; line-height:22px;">';

			if(isset($data["pickup_area"])){ $data["pickup_area"];}else{$data["pickup_address"]; }

		$mailTemplate .=' </div>

            <div style="width:15%; float:left; text-align:center;"> <img src="images/arrow.png" alt="" /> </div>

            <div style="width:42%; float:left; color:#ffdd1a; font-size:16px; padding:5px 0 0 0; line-height:22px;">'; 

			if (isset($data["drop_area"])){ $data["drop_area"]; } 

			$mailTemplate .= '</div>

            </div>
  <div style="width:100%; float:left;">

                <div style="width:32%;   float:left; background:#585858; padding:24px 0 24px 0; "> 

                <div style="width:100%; float:left; text-align:center; color:#fff; font-size:15px;"> '. $data["taxi_type"].'  </div>

                <div style="width:100%; float:left; text-align:center; color:#bbbbbb; font-size:14px; padding:5px 0 0 0;"> AC </div> 

                </div>';

				$car= $data["taxi_type"];

				     if(isset($data['timetype'])){

						 	$package =$data['timetype'];

					$this->db->where('timetype', $timetype);

					}

					if(isset($data['package'])){

						$package =$data['package'];

					$this->db->where('package', $package);

					}

					$purpose = $data['purpose'];

					$this->db->where('transfertype', $purpose);

					$this->db->where('cartype', $car);

					

	                $query4 = $this->db->get('cabdetails');

					$row4 = $query4->row();

	               

                if($data['purpose']=='Point to Point Transfer'){

					

               $mailTemplate .= '<div style="width:32%; margin:0 12px 0 12px;   float:left; background:#585858; padding:24px 0 24px 0; "> 

                <div style="width:100%; float:left; text-align:center; color:#fff; font-size:15px;">

				'. $curr[1].''. $row4->intailrate.' for '.$row4->intialkm.' '.$km1.''; 

				$mailTemplate .='</div>

                <div style="width:100%; float:left; text-align:center; color:#bbbbbb; font-size:14px; padding:5px 0 0 0; ">

				'. $curr[1].''. $row4->standardrate.'.00 per extra '.$km1.' ';

				$mailTemplate .='</div> 

                </div>';

               

				}

				

				else if($data['purpose']=='Airport Transfer'){

					 $mailTemplate .= '<div style="width:32%; margin:0 12px 0 12px;   float:left; background:#585858; padding:24px 0 24px 0; "> 

                <div style="width:100%; float:left; text-align:center; color:#fff; font-size:15px;">';

				if($data['transfer'] == 'going'){

				$mailTemplate .= ''. $curr[1].'.'.$row4->intailrate.'.00 for'. $row4->intialkm.''.$km1.''; 

				}else{

				$mailTemplate .= ''. $curr[1].'.'.$row4->fromintailrate.'.00 for'. $row4->fromintialkm.''.$km1.'';	

				}

			$mailTemplate .= '	</div>

			

                <div style="width:100%; float:left; text-align:center; color:#bbbbbb; font-size:14px; padding:5px 0 0 0; ">';

				if($data['transfer'] == 'going'){

				$mailTemplate .= ''. $curr[1].'.'. $row4->standardrate.'.00 per extra '.$km1.'';

				}else{

				$mailTemplate .= ''. $curr[1].'.'.$row4->fromstandardrate.'.00 per extra '.$km1.' ';

				}

				$mailTemplate .= '	</div> 

                </div>';

				

				

				}else if($data['purpose']=='Hourly Rental'){

					 $mailTemplate .= '<div style="width:32%; margin:0 12px 0 12px;   float:left; background:#585858; padding:24px 0 24px 0; "> 

                <div style="width:100%; float:left; text-align:center; color:#fff; font-size:15px;">'. $curr[1].'.'.$row4->standardrate.'.00 for '.$row4->package.' </div>

                 

                </div>';

				}else {

					$mailTemplate .= '<div style="width:32%; margin:0 12px 0 12px;   float:left; background:#585858; padding:24px 0 24px 0; "> 

                <div style="width:100%; float:left; text-align:center; color:#fff; font-size:15px;">';

				if($data['transfer'] == 'oneway'){

				$mailTemplate .= 'ONEWAY TRIP ';

				}else{

				$mailTemplate .= '	ROUND TRIP';

				}

				$mailTemplate .= '</div>

                <div style="width:100%; float:left; text-align:center; color:#bbbbbb; font-size:14px; padding:5px 0 0 0; ">';

				if($data['transfer'] == 'oneway'){

			$mailTemplate .= '	'. $curr[1].'.'.  $row4->standardrate.'.0' ;

                }else{

			$mailTemplate .= '	'. $curr[1].'.'.  $row4->fromstandardrate.' .0 ';

				}

				$mailTemplate .= '</div> 

                </div>';
 
				}

			    $mailTemplate .= '<div style="width:32%;   float:left; background:#585858; padding:24px 0 24px 0; "> 

                <div style="width:100%; float:left; text-align:center; color:#fff; font-size:15px;"> '. $data["pickup_time"].'. </div>

                <div style="width:100%; float:left; text-align:center; color:#bbbbbb; font-size:14px; padding:5px 0 0 0;">'. date('D, d M',strtotime( $data["pickup_date"])).' </div> 

                </div>

            </div>

            

            <div style="width:100%; float:left; color:#bbbbbb; padding:14px 0 8px 0; font-size:12px;"> *The driver’s details will be sent to you 15 mins prior to pick up time. </div>

       </div>
  <div style="background:#fff;  float:left; width:96.3%;    border-bottom-right-radius: 8px; border-bottom-left-radius: 8px; padding:20px 12px 20px 12px;  ">

        <div style="width:100%; float:left; font-size:16px; padding:0 0 10px 0;"> Extra Charges: </div> 

        <div style="width:100%; float:left; color:#666262; font-size:11px; line-height:22px;">

        

        * Maximum of 4 passengers allowed for Indica & Sedan. <br />

        * Cancellation charges of Rs.100 applicable if cancelled within 30 mins of pickup time. <br />

        * Any Toll, Parking, as applicable. <br />

        * No waiting charges upto 15 mins after scheduled pickup time. Rs.50 per 30 mins after that. <br /> 

        * Final fare payable will include Service Tax
		</div> </div> </div>';

 if ($this->Model_cab->send_mail($from,$name,$email,$sub,$mailTemplate)) {

                      echo "";

                    }	

	$this->session->set_userdata('last_booking_details',json_encode($data));

 $this->load->view('select_payment');				

					

	/*if($paypal=='PayPal'){

$data = $_POST;

 $this->load->view('paypal');

	}else{

		$data = $_POST;

		 $this->load->view('confirm_book');

	}*/

}

else{

echo 0;

}

}else{

	echo 2;

}

}



function contacted($data){

	 

	$username = $this->session->userdata('username');

	$type= $this->session->userdata('type');

	if($type =="user"){

		 $this->db->where('username', $username);

	if($this->db->update('userdetails',$data)){

		

		echo 1;

	}else{

		echo 0;

	}

	}else{

			 $datas = array(



'user_name'=>$data['username'],

'phone'=>$data['mobile'],

'email'=>$data['email'],

'gender'=>$data['gender'],

 'latitude'=>$data['lat'],

'longitude'=>$data['lng'],

'timetype'=>$data['timetype'],

'car_type'=>$data['car_type'],
'preffered_location'=>$data['preffered_location']

 );

		 $this->db->where('user_name', $username);

	if($this->db->update('driver_details',$datas)){

		

		echo 1;

	}else{

		echo 0;

	}

	}

	

}



function update_book($data){

	

	    if($username = $this->session->userdata('username')){

		$username = $this->session->userdata('username');

		}else{

		$username = $this->input->cookie('username', false);

		}

		

		$id = $data['id'];

		if(isset($data['timetype'])){

		$timetype=$data['timetype'];

		$type=$data['timetype'];

		$wh ="AND timetype='$type'";

		}

		if(isset($data['package'])){

		$pack =$data['package'];

		$wh ="AND package='$pack'";

		}

		 $purpose = $data['purpose'];

		 $car= $data['taxi_type'];

        $time =$data['pickup_time'];

		

		$query = $this->db->query("SELECT * FROM  cabdetails WHERE     cartype ='$car' AND transfertype ='$purpose' ".$wh);

        $row = $query->row('cabdetails');

		

		if($purpose =='Point to Point Transfer'){

			if($query->num_rows > 0){

			$km=$data['km'];

			$Ik = $row->intialkm;

		$Ir = $row->intailrate;

		$Sr= $row->standardrate;

			if($Ik > $km){

				echo $amount1 = ($Ik-$km)*$Sr + $Ir;

			}else if($km > $Ik){

				echo $amount1 = ($km-$Ik)*$Sr + $Ir;

			}else{

				echo $amount1 =  $Ir;

			}

			

			}

		}elseif($purpose =='Airport Transfer'){

			$km=$data['km'];

			$transfertype = $data["transfer"];

			if($query->num_rows > 0){

			if($transfertype='going'){

				$Ik = $row->intialkm;

		        $Ir = $row->intailrate;

		        $Sr= $row->standardrate;

		     if($Ik > $km){

				$amount1 = ($Ik-$km)*$Sr + $Ir;

			}else if($km > $Ik){

				$amount1 = ($km-$Ik)*$Sr + $Ir;

			}else{

				$amount1 =  $Ir;

			}

		

			

				

			}else{

				$Ik = $row->fromintialkm;

		        $Ir = $row->fromintialrate;

		        $Sr= $row->fromstandardrate;

		     if($Ik > $km){

				$amount1 = ($Ik-$km)*$Sr + $Ir;

			  }else if($km > $Ik){

				$amount1 = ($km-$Ik)*$Sr + $Ir;

			  }else{

				$amount1 =  $Ir;

			    }

			}

			}

			

		}else if($purpose =='Outstation Transfer'){

			$transfertype = $data["transfer"];

			if($query->num_rows > 0){

			if($transfertype='oneway'){

				

				 $Sr= $row->standardrate;

				

				$amount1 = $Sr;

				

			}else{

				

				 $Sr= $row->fromstandardrate;

				

				$amount1 = $Sr;

				

			}

			}

		}else{

			

			

		if($query->num_rows > 0){

			 $Sr=$row->standardrate;

			$amount1 = $Sr;

		}

		}

		$data['amount']=$amount1;

		$this->db->where('username', $username);

		$this->db->where('id', $id);

	if($this->db->update('bookingdetails',$data))

	

{

	 $this->db->where('username', $username);

	$query2 = $this->db->get('userdetails');

	 $query3 = $this->db->query(" SELECT * FROM `settings` order by id DESC ");

	$row3 = $query3->row('settings');

	$from= $row3->smtp_username;

	$paypal = $row3->paypal_option;

	$str = $row3->currency;

	$s = explode(',',$str);

	$km1 =	$row3->measurements;

    $name=$row3->title;

    $msg='Booking';

    $sub="Booking Details";

	 $km1 =	$row3->measurements;

	 foreach ($query2->result() as $row)

   {

      $email= $row->email;

     

   }

  

   $this->db->where('username', $username);

   	$this->db->where('id', $id);

	$urls= base_url();

	$query3 = $this->db->get('bookingdetails');

	 foreach ($query3->result() as $row1)

   {

	    $this->session->set_userdata('uneaqueid',$row1->uneaque_id);

	

 $this->session->set_userdata('bookid',$id);

 if(isset($row1->pickup_area)){ 

 $pickup_area =$row1->pickup_area;

 }

 else{

	 

$pickup_area =$row1->pickup_address; 

}

	$mailTemplate='<div style="width:660px; height:640px; margin:0 auto; background:#f2c21e; padding:20px 20px 20px 20px; font-family: Century Gothic,Verdana,Geneva,sans-serif; border:solid #c79e13 1px;">

	

    <div style="width:100%; float:left; padding:0 0 10px 0;">

    <div style="width:138px; height:73px; float:left; margin:0 0 0 20px;"> <img src="'.$urls.'assets/images/carss.png" alt="" /></div>

    <div style="width:350px; float:left; padding:25px 0 0 0; text-align:center; font-size:18px; "> BOOKING DETAILS </div>

    

    

    </div>

    

    

    

    

        <div style="background:#fff;  float:left; width:96.3%;   border-top-right-radius: 8px; border-top-left-radius: 8px; padding:15px 12px 0 12px;  ">

    		<div style="width:100%; padding:10px 0 10px 0; float:left; color:#666261; font-size:14px;"> Hi '. $this->session->userdata('username').' , thanks for booking with us. </div>

                 <div style="width:100%; float:left; padding:20px 0 20px 0; border-bottom:solid #cdcdcd 1px; border-top:solid #cdcdcd 1px;"> 

                 <div style="width:30%; float:left; font-size:17px;"> Trip#1 </div>

                 <div style="width:40%; float:left; font-size:17px;">'. $this->session->userdata('bookid').' </div>

                 <div style="width:30%; float:left;">  

                 

                 <a href="#"> <div style="width:100px; height:30px; background:#58585a; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; font-size:12px; color:#fff; 

                 text-align:center; line-height:25px; text-decoration:none; float:right;"> Track Booking </div> </a>

                 

                  </div>

            </div>

        </div>

        

        

        

        

        

        <div style="background:#3a3a3c;     float:left; width:96.3%;  padding:0px 12px 10px 12px;">

        	<div style="width:100%; float:left; padding:35px 0 30px 0;">

            <div style="width:43%; float:left; color:#ffdd1a; font-size:16px; padding:5px 0 0 0; line-height:22px;">'.$pickup_area.' </div>

            <div style="width:15%; float:left; text-align:center;"> <img src="'.$urls.'assets/images/arrow.png" alt="" /> </div>

            <div style="width:42%; float:left; color:#ffdd1a; font-size:16px; padding:5px 0 0 0; line-height:22px;">'. $row1->drop_area.'</div>

            </div>

            

            

            <div style="width:100%; float:left;">

                <div style="width:32%;   float:left; background:#585858; padding:24px 0 24px 0; "> 

                <div style="width:100%; float:left; text-align:center; color:#fff; font-size:15px;"> '. $row1->taxi_type.'  </div>

                <div style="width:100%; float:left; text-align:center; color:#bbbbbb; font-size:14px; padding:5px 0 0 0;"> AC </div> 

                </div>';

				$car= $row1->taxi_type;

					$purpose = $row1->purpose;

					$this->db->where('transfertype', $purpose);

					

					$this->db->where('cartype', $car);

					if(isset($timetype)){

					$this->db->where('timetype', $timetype);

					}

	                $query4 = $this->db->get('cabdetails');

	                foreach ($query4->result() as $row4)

               {

                if($data['purpose']=='Point to Point Transfer'){

					

               $mailTemplate .= '<div style="width:32%; margin:0 12px 0 12px;   float:left; background:#585858; padding:24px 0 24px 0; "> 

                <div style="width:100%; float:left; text-align:center; color:#fff; font-size:15px;">

				'. $s[1].''. $row4->intailrate.' for '.$row4->intialkm.' '.$km1.''; 

				$mailTemplate .='</div>

                <div style="width:100%; float:left; text-align:center; color:#bbbbbb; font-size:14px; padding:5px 0 0 0; ">

				'. $s[1].'.'. $row4->standardrate.'.00 per extra '.$km1.' ';

				$mailTemplate .='</div> 

                </div>';

               

				}

				

				else if($data['purpose']=='Airport Transfer'){

					 $mailTemplate .= '<div style="width:32%; margin:0 12px 0 12px;   float:left; background:#585858; padding:24px 0 24px 0; "> 

                <div style="width:100%; float:left; text-align:center; color:#fff; font-size:15px;">';

				if($data['transfer'] == 'going'){

				$mailTemplate .= ''. $s[1].'.'.$row4->intailrate.'.00 for'. $row4->intialkm.' '.$km1.''; 

				}else{

				$mailTemplate .= ''. $s[1].'.'.$row4->fromintailrate.'.00 for'. $row4->fromintialkm.''.$km1.' ';	

				}

			$mailTemplate .= '	</div>

			

                <div style="width:100%; float:left; text-align:center; color:#bbbbbb; font-size:14px; padding:5px 0 0 0; ">';

				if($data['transfer'] == 'going'){

				$mailTemplate .= ''. $s[1].'.'. $row4->standardrate.'.00 per extra '.$km1.' ';

				}else{

				$mailTemplate .= '	'. $s[1].'.'.$row4->fromstandardrate.'.00 per extra '.$km1.' ';

				}

				$mailTemplate .= '	</div> 

                </div>';

				

				

				}else if($data['purpose']=='Hourly Rental'){

					 $mailTemplate .= '<div style="width:32%; margin:0 12px 0 12px;   float:left; background:#585858; padding:24px 0 24px 0; "> 

               <div style="width:100%; float:left; text-align:center; color:#fff; font-size:15px;"> Rs.'.$row4->standardrate.'.00 for '.$row4->package.' </div>

                </div>';

				}else {

					$mailTemplate .= '<div style="width:32%; margin:0 12px 0 12px;   float:left; background:#585858; padding:24px 0 24px 0; "> 

                <div style="width:100%; float:left; text-align:center; color:#fff; font-size:15px;">';

				if($data['transfer'] == 'oneway'){

				$mailTemplate .= 'ONEWAY TRIP ';

				}else{

				$mailTemplate .= '	ROUND TRIP';

				}

				$mailTemplate .= '</div>

                <div style="width:100%; float:left; text-align:center; color:#bbbbbb; font-size:14px; padding:5px 0 0 0; ">';

				if($data['transfer'] == 'oneway'){

			$mailTemplate .= ''. $s[1].'.'.  $row4->standardrate.'.0' ;

                }else{

			$mailTemplate .= ''. $s[1].'.'.  $row4->fromstandardrate.' .0 ';

				}

				$mailTemplate .= '</div> 

                </div>';

					

					

					

					

				}

			   }

				

                

               $mailTemplate .= '<div style="width:32%;   float:left; background:#585858; padding:24px 0 24px 0; "> 

                <div style="width:100%; float:left; text-align:center; color:#fff; font-size:15px;"> '. $row1->pickup_time.'. </div>

                <div style="width:100%; float:left; text-align:center; color:#bbbbbb; font-size:14px; padding:5px 0 0 0;">'. date('D, d M',strtotime( $row1->pickup_date)).' </div> 

                </div>

            </div>

            

            <div style="width:100%; float:left; color:#bbbbbb; padding:14px 0 8px 0; font-size:12px;"> *The driver’s details will be sent to you 15 mins prior to pick up time. </div>

       </div>

            

            

            

            

        <div style="background:#fff;  float:left; width:96.3%;    border-bottom-right-radius: 8px; border-bottom-left-radius: 8px; padding:20px 12px 20px 12px;  ">

        <div style="width:100%; float:left; font-size:16px; padding:0 0 10px 0;"> Extra Charges: </div> 

        <div style="width:100%; float:left; color:#666262; font-size:11px; line-height:22px;">

        

        * Maximum of 4 passengers allowed for Indica & Sedan. <br />

        * Cancellation charges of Rs.100 applicable if cancelled within 30 mins of pickup time. <br />

        * Any Toll, Parking, as applicable. <br />

        * No waiting charges upto 15 mins after scheduled pickup time. Rs.50 per 30 mins after that. <br /> 

        * Final fare payable will include Service Tax

        

        </div>

 

        </div>

            

            

            

            

            

            

            

        </div>';

   }

		 if ($this->Model_cab->send_mail($from,$name,$email,$sub,$mailTemplate)) {

                      echo "";

                    }	

	

		$data = $_POST;

		 $this->load->view('confirm_book');

	

  

}

else{

	

echo 0;

}

}

function rating($data){

	/*$data['ip'] =$_SERVER['REMOTE_ADDR'];

	

	$this->db->where('ip', $data['ip']);

	$query = $this->db->get('visits');

	if($query->num_rows == 0)

	

    {

	  if($this->db->insert('visits',$data))

      {

		  echo 0;

	  }

    }*/

}

function update_change($data){

	

	//print_r($data);

		 if($username = $this->session->userdata('username')){

		$username = $this->session->userdata('username');

		}else{

		$username = $this->input->cookie('username', false);

		}

		$type = $this->session->userdata('type');

		

		$select_data = "*"; 

		if($type =="user"){

				$where_data = array(	// ----------------Array for check data exist ot not

				'username'     => $username,

				'password'     => md5($data['current'])

			);

			

			$table = "userdetails";  //------------ Select table

			$update_data = array(

				'password'     => md5($data['newpass'])

			);

			

			$where_datas = array(

				'username'     => $username

			);

		}else{

				$where_data = array(	// ----------------Array for check data exist ot not

				'user_name'     => $username,

				'password'     => $data['current']

			);

			

			$table = "driver_details";  //------------ Select table

			$update_data = array(

				'password'     => $data['newpass']

			);

			

			$where_datas = array(

				'user_name'     => $username

			);

		}

		

		$result = $this->get_table_where( $select_data, $where_data, $table );

		

	if( count($result) == 1)

	

{

	



if($data['newpass'] == $data['confirmpass'])

{

	

	

	

		

		

	$s =	$this->update_table_where( $update_data, $where_datas, $table);





	echo 2;



}else{

	echo 0;

}



}else{

	echo 3;

}

}

 function update_table_where( $update_data, $where_datas, $table){	

	$this->db->where($where_datas);

	$this->db->update($table, $update_data);

         

   }    





function update_status($data){

	

	 if($username = $this->session->userdata('username')){

		$username = $this->session->userdata('username');

		}else{

		$username = $this->input->cookie('username', false);

		}

		$id = $data['id'];

		$status = $data['status'];

		

		$this->db->where('username', $username);

		$this->db->where('id', $id);

	if($this->db->update('bookingdetails',$data))

	

{

	

	$query3 = $this->db->get('userdetails');

	$this->db->where('username',$username);

	$query2 = $this->db->get('userdetails');

	 $query3 = $this->db->query(" SELECT * FROM `settings` order by id DESC ");

	$row3 = $query3->row('settings');

	$from= $row3->smtp_username;

    $name=$row3->title;

   

    $sub="Cancel Details";

	 foreach ($query2->result() as $row)

   {

      $email= $row->email;

     

   }

    $this->db->where('username', $username);

   	$this->db->where('id', $id);

	$query3 = $this->db->get('bookingdetails');

    foreach ($query3->result() as $row1)

   {

   $mailTemplate='<div style="width:660px; height:355px; margin:0 auto; background:#f2c21e; padding:20px 20px 20px 20px; font-family: Century Gothic,Verdana,Geneva,sans-serif; border:solid #c79e13 1px;">

	

    <div style="width:100%; float:left; padding:0 0 10px 0;">

    <div style="width:138px; height:73px; float:left; margin:0 0 0 20px;"> <img src="images/logo.png" alt="" /></div>

    <div style="width:350px; float:left; padding:25px 0 0 0; text-align:center; font-size:18px; "> BOOKING DETAILS </div>

    

    

    </div>

    

    

    

    

        <div style="background:#fff;  float:left; width:96.3%;   border-top-right-radius: 8px; border-top-left-radius: 8px; padding:15px 12px 0 12px;  ">

    		<div style="width:100%; padding:10px 0 10px 0; float:left; color:#666261; font-size:14px; text-align:center;"> Booking is cancelled</div>

                 <div style="width:100%; float:left; padding:2px 0 0px 0; border-bottom:solid #cdcdcd 1px; border-top:solid #cdcdcd 1px;"> 

                  

            </div>

        </div>

        

        

        

        

        

        <div style="background:#3a3a3c;     float:left; width:96.3%;  padding:5px 12px 10px 12px;">

          <div style="width:100%; float:left;">

            

              <div style="width:100%;   float:left; background:#585858; padding:15px 0 15px 0; margin:5px 0 0 0; "> 

                <div style="width:100%; float:left; text-align:center; color:#ffdd1a; font-size:16px;"> Pickup: <div style="color:#fff; font-size:14px; display:inline;"> '.$row1->pickup_area.' </div></div>

                </div>

                

          <div style="width:100%;   float:left; background:#585858; padding:15px 0 15px 0; margin:5px 0 0 0; "> 

                <div style="width:100%; float:left; text-align:center; color:#ffdd1a; font-size:16px;"> Drop: <div style="color:#fff; font-size:14px; display:inline;"> '.$row1->drop_area.'</div></div>

                </div>

                

          <div style="width:100%;   float:left; background:#585858; padding:15px 0 15px 0; margin:5px 0 0 0; "> 

                <div style="width:100%; float:left; text-align:center; color:#ffdd1a; font-size:16px;"> Pickup Time: <div style="color:#fff; font-size:14px; display:inline;"> '. date('D, d M',strtotime($row1->pickup_date)).', '. $row1->pickup_time.'</div></div>

                </div>

                

                

                

                

            </div>

       </div>

            

            

            

            

        <div style="background:#fff;  float:left; width:96.3%;    border-bottom-right-radius: 8px; border-bottom-left-radius: 8px; padding:20px 12px 20px 12px;  "></div>

            

            

            

            

            

            

            

        </div>';

   }

	

 if ($this->Model_cab->send_mail($from,$name,$email,$sub,$mailTemplate)) {

                      echo "dd";

                    }	

	

	

echo 1;

}

else{

	

echo 0;

}



}

function send_mail($from,$name,$mail,$sub, $msg)
{
 $this->db->order_by("id","desc");
 $query2 = $this->db->get('settings');
 foreach ($query2->result() as $row)
 {
 $host= $row->smtp_host;
 $pass= $row->smtp_password;
 $username = $row->smtp_username;
	}
$config['protocol'] = 'smtp';
$config['smtp_host'] = $host;
$config['smtp_user'] = $username;
$config['smtp_pass'] = $pass;
$config['smtp_port'] = 25;
$config['mailtype'] = 'html';

$this->email->initialize($config);
$this->email->from($from, $name);
$this->email->to($mail);
$this->email->subject($sub);
$this->email->message($msg);
 
if($this->email->send()){
	// echo	 $this->email->print_debugger();

	return "success";
}
else {
	return "l";
}
echo $this->email->print_debugger();
 }



function promocode($data)

{

    

    $promocode = $data['promocode'];

    $this->db->where('promocode',$promocode);

     $query2 = $this->db->get('promocode');

    if($query2->num_rows == 0)

    {

        echo 0;

    }

    else

    {

        

        $today =date('Y-m-d H:i:s');

        if($today <=$query2->row('enddate')  ){

			echo 1;

		}else{

			echo 0;

		}

    }

}

function update_address($data){

    

        if($username = $this->session->userdata('username')){

        $username = $this->session->userdata('username');

        }else{

        $username = $this->input->cookie('username', false);

        }

        

        $this->db->where('username', $username);

        

    if($this->db->update('userdetails',$data))

    

{

    

echo 1;

}

else{

    

echo 0;

}

}



function update_otp($data){

	

	$details=$this->session->userdata('last_reg_details');

	$datails_arr=json_decode($details,true);

	$otp = $data['otp'];

	

	

    if($otp == $datails_arr['active_id'])

    {    

if($datails_arr['type']=='user'){

	   $datails_arr['active_id']='0';
	     

	     $datails_arr['user_status'] = 'Active';

		 $datails_arr['password']=md5($datails_arr['password']);

	    

         if($this->db->insert('userdetails',$datails_arr))

    

{

	 $this->session->set_userdata('username',$datails_arr['username']);

	 $this->session->set_userdata('type',$datails_arr['type']);

	 $user1 = $this->session->userdata('username');

	

	echo $user1;

}else{

	echo 3;

}

}else{

	   

		

		

		 $datas = array(

'user_status'=>'Active',
'name'=>$datails_arr['username'],
'user_name'=>$datails_arr['username'],

'phone'=>$datails_arr['mobile'],

'email'=>$datails_arr['email'],

'active_id'=>'0',

'password'=>$datails_arr['password']

);

         if($this->db->insert('driver_details',$datas))

    

{

	 $this->session->set_userdata('username',$datails_arr['username']);

	 $this->session->set_userdata('type',$datails_arr['type']);

	 $user1 = $this->session->userdata('username');

	

	echo 'driver';

}else{

	echo 3;

}

}

      

    }else{                                                                                                                         

		echo 1;

		}	 

}





function update_resend_otp($data){

	

	

	

	        $username = $data['username'];

	

	        $data['active_id'] = mt_rand(100000,999999); 

			

	      

	   $details=$this->session->userdata('last_reg_details');

	    $datails_arr=json_decode($details,true);

         $datails_arr['active_id']=  $data['active_id'];

		 

                $smobile=  $datails_arr['mobile'];

     

        $this->session->set_userdata('last_reg_details',json_encode($datails_arr));

	                  

					  $code = $data['active_id'];

					  $sms="Your Call MY Cab verification code is ".$code." ";

        $this->Model_cab->cmc_sms($smobile,$sms);

			echo 1;

  	 

}



 function getMovies($limit=null,$offset=NULL){

	   if($username = $this->session->userdata('username')){

        $username = $this->session->userdata('username');

        }else{

        $username = $this->input->cookie('username', false);

        }

	 

 $this->db->where('username', $username);

 $this->db->where('status', 'Booking');

$query = $this->db->get('bookingdetails');

  

  

  return $query->num_rows();

 }

function record_count() {

	  if($username = $this->session->userdata('username')){

        $username = $this->session->userdata('username');

        }else{

        $username = $this->input->cookie('username', false);

        }

	 

 $this->db->where('username', $username);

 $this->db->where('status', 'Booking');

$query = $this->db->get('bookingdetails');

  

  

  return $query->num_rows();

 } 

 function fetch_countries($limit, $start) {

	  if($username = $this->session->userdata('username')){

        $username = $this->session->userdata('username');

        }else{

        $username = $this->input->cookie('username', false);

        }

         $this->db->where('username', $username);

        $this->db->where('status', 'Booking');  

        $this->db->limit($limit, $start);

            

        $query = $this->db->get("bookingdetails");





        if ($query->num_rows() > 0) {



            foreach ($query->result() as $row) {



                $data[] = $row;



            }

            return $data;



        }



        return false;



   }

   function record_count1() {

	   $details=$this->session->userdata('status_date');

	$datails_arr=json_decode($details,true);

	    $status =$datails_arr['status'];

        $date =$datails_arr['date'];

	  if($username = $this->session->userdata('username')){

        $username = $this->session->userdata('username');

        }else{

        $username = $this->input->cookie('username', false);

        }

	 if($date){

 $this->db->where('pickup_date', $date);

 }

 $this->db->where('username', $username);

 

 $this->db->where('status', $status); 

 

$query = $this->db->get('bookingdetails');

  

  return $query->num_rows();

 } 

 

  function  fetch_details($username,$type) {

	 

     

	  if($type=='user')

	  {		 $this->db->select('*, username as user_name, mobile as phone');

		   $this->db->where('username', $username);

		   $query = $this->db->get('userdetails');

	  }else{

		   $this->db->select('*');

		   $this->db->where('user_name', $username);

		   $query = $this->db->get('driver_details');

	  }

	  return $results = $query->row();

	   

  }



   function  booking_tab($username,$type) {

	  if($type=='user')

	  {		 $this->db->select('*');

		   $this->db->where('username', $username);

		    // $this->db->where('item_status', 'Pending');

			// $this->db->where('status', 'Complete');

			$this->db->where('status ', 'Complete'); 

			//$this->db->or_where_in('status', 'Cancelled');

			// $this->db->where('item_status', 'Processing');

			//$this->db->where('status', 'Booking');

			 $query = $this->db->get('bookingdetails');

	  }else{

		   $this->db->select('*');

		   $this->db->where('user_name', $username);	

		   $this->db->from('bookingdetails a'); 

		   $this->db->where('status', 'Complete');

			  $this->db->join('driver_details b', 'b.id=a.assigned_for', 'left');

				$query = $this->db->get(); 

	  }

	  return $results = $query->result();

	   

  }

     function  active_tab($username,$type) {
  if($type=='user')

	  {		 $this->db->select('*');

  

		   $this->db->where('username', $username);

		//  $this->db->where('status', 'Processing');

			$this->db->where('item_status', 'Completed');

			// $this->db->where('item_status', 'Completed');

			// $this->db->where('item_status', 'Cancelled');

			//$this->db->where('item_status', 'Completed');

			 $query = $this->db->get('bookingdetails');

	  }else{

		   $this->db->select('*');

		   $this->db->where('user_name', $username);	

		   $this->db->from('bookingdetails a'); 

		  $this->db->where('item_status', 'Completed');

			  $this->db->join('driver_details b', 'b.id=a.assigned_for', 'left');

				$query = $this->db->get(); 

	  }

	  return $results = $query->result();

	   

  }

  
     function  booking_tab_sort($username,$type,$dates) {
		if($type=='user')
			{		 
				$this->db->select('*');
				$this->db->where('username', $username);
				$this->db->where('pickup_date', $dates);
				$this->db->where('status ', 'Complete'); 
				$query = $this->db->get('bookingdetails');
			}else{

					$this->db->select('*');
					$this->db->where('user_name', $username);	
					$this->db->where('pickup_date', $dates);
					$this->db->from('bookingdetails a'); 
					$this->db->where('status', 'Complete');
					$this->db->join('driver_details b', 'b.id=a.assigned_for', 'left');
					$query = $this->db->get(); 
				}
			  return $results = $query->result();
			  
				}

     function  active_tab_sort($username,$type,$dates) {
  if($type=='user')

	  {		 $this->db->select('*');
			$this->db->where('username', $username);
			$this->db->where('pickup_date', $dates);
			$this->db->where('item_status', 'Completed');
			$query = $this->db->get('bookingdetails');
		}else{

			$this->db->select('*');
			$this->db->where('user_name', $username);	
			$this->db->where('pickup_date', $dates);
			$this->db->from('bookingdetails a'); 
			$this->db->where('item_status', 'Completed');
			$this->db->join('driver_details b', 'b.id=a.assigned_for', 'left');
			$query = $this->db->get(); 
			} 
		  return $results = $query->result();
	 
			}
 

 function fetch_countries1($limit,$start) {

	 $details=$this->session->userdata('status_date');

	 $datails_arr=json_decode($details,true);

	 $status =$datails_arr['status'];

     $date =$datails_arr['date'];



	  if($username = $this->session->userdata('username')){

        $username = $this->session->userdata('username');

        }else{

        $username = $this->input->cookie('username', false);

        }

		  if($date){

  $this->db->where('pickup_date', $date);

  }

         $this->db->where('username', $username);



  

 $this->db->where('status', $status); 

        $this->db->limit($limit, $start);

            

        $query = $this->db->get("bookingdetails");





        if ($query->num_rows() > 0) {



            foreach ($query->result() as $row) {



                $data[] = $row;



            }

            return $data;



        }



        return false;



   }

   function update_reset_pass($data){

	

	     $scomunicatn = $data['communictn'];

		 

		 if($data['type']=='user'){

		 if($scomunicatn =='sms'){

	

	     $smobile = $data['email'];

	       

	         $query1 = $this->db->query("select * from userdetails where mobile ='$smobile'");

			  if ($query1->num_rows() =='1'){

			$row3 = $query1->row('userdetails');

	

	$username=$row3->username;

	$password = mt_rand(100000,999999); 

	 

	$code = $password;

     $sms="Your new password is ".$code."Please change your password next time you log in. ";

       $data1=array('password'=>md5($password));

	   $this->db->where('mobile',$smobile);

	if($this->db->update('userdetails',$data1)){	

	  

	

		$this->Model_cab->cmc_sms($smobile,$sms);

		

		echo 4;

	}else{

		echo 2;

		}}else{

				  echo 1;

			  }

		 }else{

			 

			 

			 $sub="Password Recovery";

	     $smobile = $data['email'];

		  $query3 = $this->db->query(" SELECT * FROM `settings` order by id DESC ");

	$row3 = $query3->row('settings');

	$from= $row3->smtp_username;

		

		 $name=$row3->title;

	       

	         $query1 = $this->db->query("select * from userdetails where email ='$smobile'");

			  if ($query1->num_rows() =='1'){

			$row3 = $query1->row('userdetails');

	

	$username=$row3->username;

	$password = mt_rand(100000,999999); 

	 

	$code = $password;

     $sms="Your new password is ".$code." Please change your password next time you log in. ";

      	 $data1=array('password'=>md5($password));

	   $this->db->where('email',$smobile);

	if($this->db->update('userdetails',$data1)){	

	   $this->Model_cab->send_mail($from,$name,$smobile,$sub,$sms);

		echo 3;

	}else{

		echo 2;

		}}else{

				  echo 0;

			  }
 
		 }

		 }else{

			 

			if($scomunicatn =='sms'){

	

	     $smobile = $data['email'];

	       

	         $query1 = $this->db->query("select * from driver_details where phone ='$smobile'");

			  if ($query1->num_rows() =='1'){

			$row3 = $query1->row('driver_details');

	

	$username=$row3->user_name;

	$password = mt_rand(100000,999999); 

	 

	$code = $password;

     $sms="Your new password is ".$code."Please change your password next time you log in. ";

       $data1=array('password'=>$password);

	   $this->db->where('phone',$smobile);

	if($this->db->update('driver_details',$data1)){	

	  

	

		$this->Model_cab->cmc_sms($smobile,$sms);

		

		echo 4;

	}else{

		echo 2;

		}}else{

				  echo 1;

			  }

		 }else{

			 

			 

			 $sub="Password Recovery";

	     $smobile = $data['email'];

		  $query3 = $this->db->query(" SELECT * FROM `settings` order by id DESC ");

	$row3 = $query3->row('settings');

	$from= $row3->smtp_username;

		

		 $name=$row3->title;

	       

	         $query1 = $this->db->query("select * from driver_details where email ='$smobile'");

			  if ($query1->num_rows() =='1'){

			$row3 = $query1->row('driver_details');

	

	$username=$row3->user_name;

	$password = mt_rand(100000,999999); 

	 

	$code = $password;

     $sms="Your new password is ".$code." Please change your password next time you log in. ";

      	 $data1=array('password'=>$password);

	   $this->db->where('email',$smobile);

	if($this->db->update('driver_details',$data1)){	

	  

	



     

        

		$this->Model_cab->send_mail($from,$name,$smobile,$sub,$sms);

		echo 3;

	}else{

		echo 2;

		}}else{

				  echo 0;

			  }

  	  

			 

			 

			 

			 

			 

			 

			 

			 

			 

			 

		 } 

			 

			 

		 }

  	 

}















function update_paypal($data){

	

         $bookid =$data['c'];

		 $transaction =$data['a'];

		 $status =$data['b'];

		

		 

        if($username = $this->session->userdata('username')){

        $username = $this->session->userdata('username');

        }else{

        $username = $this->input->cookie('username', false);

        }

       $value = array(

			                'item_status'=>$status,

							'transaction'=>$transaction,

							'status'=>'Booking'

							

							

							

							

			 );

        $this->db->where('username', $username);

		$this->db->where('uneaque_id', $bookid);

        

    if($this->db->update('bookingdetails', $value))

    

{

	$table="userdetails";

	$wallet=$this->session->userdata('wallet-balance');

	$update_data = array(

			'wallet_amount'     => $wallet

		);

		

		$where_datas = array(

			'username'     => $username,

		);

	$this->update_table_where( $update_data, $where_datas, $table);

    

echo 1;

}

else{

    

echo 0;

}

}



   

function update_itemstatus($data){

	

        

		 $item_status =$data['item_status'];

		 

		 

        if($username = $this->session->userdata('username')){

        $username = $this->session->userdata('username');

        }else{

        $username = $this->input->cookie('username', false);

        }

       $value = array(

			                 

							'item_status'=>"Cancelled",

							'status'=>"Cancelled"

							

			 );

        $this->db->where('id', $item_status);

		

        

    if($this->db->update('bookingdetails', $value))

    

{

    

echo 1;

}

else{

    

echo 0;

}

}

function get_values($page){

 $this->db->where('page_name', $page);

  $query = $this->db->get('static_pages');	    

//$query = $this->db->query("SELECT * FROM  static_pages WHERE page_title='$page'");

	return $query->row();

 	

}

function update_contact_us_details($data){
	 $query3 = $this->db->query(" SELECT * FROM `settings` order by id DESC ");

	$row3 = $query3->row('settings');
  // $email=$row3->email;
  // var_dump($email);exit;
	//$email = $row3->smtp_username;
	$email= 'anju.techware@gmail.com';
 // $email = 'oliviya.techware@gmail.com';
  //$from = $data['email'];
  $from ='oliviya.techware@gmail.com';
  $msg ="Contact us";

  $subject ='<div style="width:660px; height:400px; margin:0 auto; background:#F7941E; padding:20px 20px 20px 20px; font-family: Century Gothic,Verdana,Geneva,sans-serif; border:solid #de851b 1px;">
	
    <div style="width:100%; float:left; padding:0 0 10px 0;">
    <div style="width:138px; height:73px; float:left; margin:0 0 0 20px;"> <img src="'.base_url().'assets/img/home/logo.png" alt="" /></div>
    <div style="width:350px; float:left; padding:25px 0 0 0; text-align:center; font-size:18px; "> CONTACT DETAILS </div>
     </div>
     <div style="background:#fff;  float:left; width:96.3%;   border-top-right-radius: 8px; border-top-left-radius: 8px; padding:15px 12px 0 12px;  ">
    		<div style="width:100%; padding:10px 0 10px 0; float:left; color:#666261; font-size:14px; text-align:center;">Thank you for choosing our service. We are happy to serve you!!!</div>
                 <div style="width:100%; float:left; padding:15px 0 15px 0; border-bottom:solid #cdcdcd 1px; border-top:solid #cdcdcd 1px;"> 
                 <div style="width:100%; float:left; font-size:14px; text-align:center;">Your enquiry has been successfully registered !!!</div>
            </div>
        </div></div>
        <div style="background:#fff;  float:left; width:96.3%;    border-bottom-right-radius: 8px; border-bottom-left-radius: 8px; padding:20px 12px 20px 12px;  "></div>
          </div>';
  
  
  $phone = $data['phone'];

  $name=$data['name'];
  $from=$data['email'];
 $mailTemplate='<div style="width:660px; height:400px; margin:0 auto; background:#F7941E; padding:20px 20px 20px 20px; font-family: Century Gothic,Verdana,Geneva,sans-serif; border:solid #de851b 1px;">
	
    <div style="width:100%; float:left; padding:0 0 10px 0;">
    <div style="width:138px; height:73px; float:left; margin:0 0 0 20px;"> <img src="'.base_url().'assets/img/home/logo.png" alt="" /></div>
    <div style="width:350px; float:left; padding:25px 0 0 0; text-align:center; font-size:18px; "> CONTACT DETAILS </div>
     </div>
     <div style="background:#fff;  float:left; width:96.3%;   border-top-right-radius: 8px; border-top-left-radius: 8px; padding:15px 12px 0 12px;  ">
    		<div style="width:100%; padding:10px 0 10px 0; float:left; color:#666261; font-size:14px; text-align:center;">Thank you for choosing our service. We are happy to serve you!!!</div>
                 <div style="width:100%; float:left; padding:15px 0 15px 0; border-bottom:solid #cdcdcd 1px; border-top:solid #cdcdcd 1px;"> 
                 <div style="width:100%; float:left; font-size:14px; text-align:center;">'. $name.' has tried to contact you</div>
            </div>
        </div>
         <div style="background:#3a3a3c;     float:left; width:96.3%;  padding:5px 12px 10px 12px;">
          <div style="width:100%; float:left;">
            
              <div style="width:100%;   float:left; background:#585858; padding:15px 0 15px 0; margin:5px 0 0 0; "> 
                <div style="width:100%; float:left; text-align:center; color:#ffdd1a; font-size:16px;">Name:  <div style="color:#fff; font-size:14px; display:inline;">'. $name.'</div></div>
                </div>
                
          <div style="width:100%;   float:left; background:#585858; padding:15px 0 15px 0; margin:5px 0 0 0; "> 
                <div style="width:100%; float:left; text-align:center; color:#ffdd1a; font-size:16px;"> Mobile: <div style="color:#fff; font-size:14px; display:inline;">'. $data['phone'].'</div></div>
                </div>
                
          <div style="width:100%;   float:left; background:#585858; padding:15px 0 15px 0; margin:5px 0 0 0; "> 
                <div style="width:100%; float:left; text-align:center; color:#ffdd1a; font-size:16px;"> Email: <div style="color:#fff; font-size:14px; display:inline;">'. $data['email'].'</div></div>
                </div>
              </div>
			  
			   <div style="width:100%;   float:left; background:#585858; padding:15px 0 15px 0; margin:5px 0 0 0; "> 
                <div style="width:100%; float:left; text-align:center; color:#ffdd1a; font-size:16px;"> Suggestion: <div style="color:#fff; font-size:14px; display:inline;">'. $data['message'].'</div></div>
                </div>
              </div>
       </div>
        <div style="background:#fff;  float:left; width:96.3%;    border-bottom-right-radius: 8px; border-bottom-left-radius: 8px; padding:20px 12px 20px 12px;  "></div>
          </div> </div>';
	
$this->Model_cab->send_mail($email,$name,$email,$msg,$mailTemplate);
$this->Model_cab->send_mail($from,$name,$email,$msg,$subject);

// $this->Model_cab->send_mail($email,$msg,$mailTemplate,$from);

echo $this->email->print_debugger();

return true;

}

function get_table_where( $select_data, $where_data, $table){

        

		$this->db->select($select_data);

		$this->db->where($where_data);

		$query  = $this->db->get($table);  //--- Table name = User

		$result = $query->result_array(); 

		

		return $result;	

   }	

//olu

function fetch_car( $data){

	

$current_time = $data['shift'];

$day = "6:00 AM";

$night = "10:00 PM";

$date1 = DateTime::createFromFormat('H:i a', $current_time);

$date2 = DateTime::createFromFormat('H:i a', $day);

$date3 = DateTime::createFromFormat('H:i a', $night);

if ($date1 > $date2 && $date1 < $date3)

{

    $timetype='day';

}else{

	  $timetype='night';

}

 
$this->db->select('*');
		 $this->db->from('cabdetails a'); 

		$this->db->where('a.transfertype', $data['type']);

		$this->db->where('a.timetype', $timetype);
		$this->db->join('car_categories c', 'c.car_type=a.cartype', 'left');

		$query = $this->db->get();
		
  return $results = $query->result_array();
		  
		  
   }

   

   function fetch_car_search( $data){

 
$current_time = $data['shift'];

$day = "6:00 AM";

$night = "10:00 PM";

$date1 = DateTime::createFromFormat('H:i a', $current_time);

$date2 = DateTime::createFromFormat('H:i a', $day);

$date3 = DateTime::createFromFormat('H:i a', $night);

if ($date1 > $date2 && $date1 < $date3)

{

    $timetype='day';

}else{

	  $timetype='night';

}

  $hour=$data['hour_package'];

$string = preg_replace('/\s+/', '', $hour);

   $this->db->select('*');

		  $this->db->from('cabdetails a'); 

		  	$this->db->where('a.transfertype', $data['type']);

		  $this->db->where('a.timetype', $timetype);

		    $this->db->where('a.package', $string);

			  $this->db->join('package_details b', 'b.id=a.package', 'left');
			   $this->db->join('car_categories c', 'c.car_type=a.cartype', 'left');


				$query = $this->db->get(); 
				  // echo $this->db->last_query();
				

				  return $results = $query->result();
			 
   }

    

   

   function fetch_distance( $data){

	 

  $pick_lng=$data['pick_lng'];

   $drop_lat=$data['drop_lat'];

   $pick_lat=$data['pick_lat'];

   $drop_lng=$data['drop_lng'];

    //$results['distance']='10';

		//	 $results['duration']='120';

			

			 $jsonResults = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$pick_lat,$pick_lng&destinations=$drop_lat,$drop_lng&key=AIzaSyCHc-JbPT5Fn-dGubkSs31cHjpxAc04JOA");

           $json_decode = json_decode($jsonResults);

		   

		   

			 $distance=ceil(($json_decode->rows[0]->elements[0]->distance->value)/1000);

			 $duration=round(($json_decode->rows[0]->elements[0]->duration->value)/60);

			$results['distance']=$distance;

			$results['duration']=$duration;

			 

			return $results;

			// return $results;

 	// exit;



 $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&sensor=false&origins=$pick_lat,$pick_lng&destinations=$drop_lat,$drop_lng&key=AIzaSyCHc-JbPT5Fn-dGubkSs31cHjpxAc04JOA";

 $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=10.0158605,76.3418666&destinations=10.0177542,76.3333364&sensor=false&key=AIzaSyCHc-JbPT5Fn-dGubkSs31cHjpxAc04JOA';

 /*$myURL = 'https://maps.googleapis.com/maps/api/distancematrix/json?';   

$options = array("units"=>"imperial","sensor"=>"false","origins"=>"$pick_lat,$pick_lng","destinations"=>"$drop_lat,$drop_lng","key"=>"AIzaSyCHc-JbPT5Fn-dGubkSs31cHjpxAc04JOA");

$myURL .= http_build_query($options,'','&');



$myData = file_get_contents("$myURL");*/

 /*echo distance(10.0158605, 76.3418666, 10.0177542, 76.3333364, "M") . " Miles<br>";

echo distance(10.0158605, 76.3418666, 10.0177542, 76.3333364, "K") . " Kilometers<br>";

echo distance(10.0158605, 76.3418666, 10.0177542, 76.3333364, "N") . " Nautical Miles<br>";

exit;*/

 $jsonResults = file_get_contents($url);

 

// $jsonResults = file_get_contents($url);

           $json_decode = json_decode($jsonResults);

		   

		    

			 $distance=ceil(($json_decode->rows[0]->elements[0]->distance->value)/1000);

			

			 $duration=round(($json_decode->rows[0]->elements[0]->duration->value)/60);

			$results['distance']=$distance;

			$results['duration']=$duration;

			print_r($results);

		

			return $results;

		  

   }


   function fetch_out_car($data){	


		$settings = $this->db->get('settings')->row();

		list($word,$currency) = explode(',', $settings->currency);

		$car_info = array();

		$dep_date = strtotime($data['dep_date']);
		$ret_date = strtotime($data['ret_date']);
		$datediff = $ret_date - $dep_date;
		$package = $data['package'];
		$total_days = floor($datediff / (60 * 60 * 24));



		



		$result = $this->db->query("SELECT cabdetails.cartype,cabdetails.standardrate,car_categories.car_image FROM `cabdetails` LEFT JOIN car_categories ON cabdetails.cartype = car_categories.car_type  WHERE package = '$package' AND transfertype = 'Outstation Transfer'")->result();		

		$new_result = array();

		foreach ($result as $rs) {

			$standard_rate = $rs->standardrate;

			$total = 0;

			if($total_days>1){
				$total = $standard_rate * $total_days;
			} else {
				$total = $standard_rate;
			}

			$fare_details = $currency.$standard_rate.' per day';

			
			$total_days = $total_days>1?$total_days:1;
			



			$distance = $total_days." day(s)";



			$res = array('cartype'=>$rs->cartype,'car_image'=>$rs->car_image,'fare_details'=>$fare_details,'rate'=>$total,'currency'=>$currency,'distance'=>$distance);

			array_push($new_result,$res);

		}





		return $new_result;		



	}

  



	function fetch_air_car($data){



		$settings = $this->db->get('settings')->row();

		list($word,$currency) = explode(',', $settings->currency);

		$car_info = array();



		$day = "6:00 AM";

		$night = "10:00 PM";

		$current_time = $data['shift'];	

		$tran_type = $data['type'];		

		$select_time = DateTime::createFromFormat('H:i a', $current_time);

		$day = DateTime::createFromFormat('H:i a', $day);

		$night = DateTime::createFromFormat('H:i a', $night);

		if($day<$select_time && $select_time < $night){

			$time = 'day';

		} else {

			$time = 'night';

		}



		$result = $this->db->query("SELECT cabdetails.* ,car_categories.car_image
			FROM cabdetails LEFT JOIN car_categories ON car_categories.car_type = cabdetails.cartype WHERE timetype='$time' AND transfertype ='$tran_type' ORDER BY intailrate DESC")->result();		

		$new_result = array();

		foreach ($result as $rs) {

			if($data['select_type']=='going'){

				$intialkm = $rs->intialkm;

				$intailrate = $rs->intailrate;

				$standard_rate = $rs->standardrate;

				$total = 0;

				if($intialkm>0 && $intailrate>0){

					if($data['distance']>$intialkm){

						$total = (($data['distance']-$intialkm)*$standard_rate);

						$total = $total + $intailrate;

					} else {

						$total = $intailrate;

					}

				$fare_details = $currency.$intailrate.' for the first '.$intialkm.' '.$settings->measurements;

				$fare_details .= '('.$currency.$standard_rate.'/'.$settings->measurements.')';

				} else{

					$total = ($data['distance']*$standard_rate);

					$fare_details = $currency.$standard_rate.'/'.$settings->measurements;

				}

			} else {

				$intialkm = $rs->fromintialkm;

				$intailrate = $rs->fromintailrate;

				$standard_rate = $rs->fromstandardrate;

				$total = 0;

				if($intialkm>0 && $intailrate>0){

					if($data['distance']>$intialkm){

						$total = (($data['distance']-$intialkm)*$standard_rate);

						$total = $total + $intailrate;

					} else {

						$total = $intailrate;

					}

				$fare_details = $currency.$intailrate.' for the first '.$intialkm.' '.$settings->measurements;

				$fare_details .= '('.$currency.$standard_rate.'/'.$settings->measurements.')';

				} else{

					$total = ($data['distance']*$standard_rate);

					$fare_details = $currency.$standard_rate.'/'.$settings->measurements;

				}

			}



			$distance = $data['distance']." ".$settings->measurements;



			$res = array('cartype'=>$rs->cartype,'car_image'=>$rs->car_image,'fare_details'=>$fare_details,'rate'=>$total,'currency'=>$currency,'distance'=>$distance);

			array_push($new_result,$res);

		}





		return $new_result;		



	}



	function fetch_position($data){

			$code = $data['code'];

			$result = $this->db->select('lat,lon')->where('code',$code)->get('airport_list')->row();

			return $result;

	}

		function booking_point($data,$username){
			 

			 $data['username']=$username;

			 $data['uneaque_id'] = 'CMC'.strtotime(date('m/d/Y H:i:s'));

			 $data['km']=$data['distance'];
			 $data['assigned_for'] = $this->assigned_for($data['taxi_type'],$data['driver_lat'],$data['driver_lng']);
			 $data['item_status']='Pending';
			  $data['status']='Booking';
			  // $data['promo_status_point'] = '';
			   $data['promo_code']=$data['promo_status_point']=='1'?$data['point_promo']:'';
			  unset($data['driver_lat']);
			  unset($data['promo_status_point']);
			   unset($data['point_promo']);
  unset($data['driver_lng']);
    unset($data['drop_lng']);
	  unset($data['drop_lat']);
			$this->db->insert('bookingdetails',$data);
			
		     return $this->db->insert_id();
 
			 
 }
 


		function book_hourly($data,$username){
	 
		 $uneaque_id = 'CMC'.strtotime(date('m/d/Y H:i:s'));
		$username =$username;
		$purpose = 'Hourly Rental';
		$assigned_for = $this->assigned_for($data['hour_taxi_type'],$data['driver_lat_hour'],$data['driver_lng_hour']);
	 	$amount=$this->amount_cartype($purpose,$data['timetype'],$data['hour_taxi_type'],$data['hour_package']);
		//$data['promo_status_hour'] = '';
		$result = array('username'=>$username,
						'uneaque_id'=>$uneaque_id,
						'purpose'=>$purpose,
						'pickup_area'=>$data['hour_pickup_area'],
						'pickup_date'=>$data['hour_pickup_date'],
						'pickup_time'=>$data['hour_pickup_time'],
						'area'=>$data['hour_area'],
						'landmark'=>$data['hour_landmark'],
						'pickup_address'=>$data['hour_pickup_address'],
						'taxi_type'=>$data['hour_taxi_type'],
						'status'=>'Booking',
						'promo_code'=>$data['promo_status_hour']=='1'?$data['hour_promo']:'',
						'amount'=>$amount,
						'assigned_for'=>$assigned_for,
						'item_status'=>'Pending',
						'timetype'=>$data['timetype']
						);
		$this->db->insert('bookingdetails',$result);
		return $this->db->insert_id();


	}

function amount_cartype($purpose,$timetype,$cartype,$package){
	
	$string = preg_replace('/\s+/', '', $package);
	  $this->db->select('*');
 $this->db->from('cabdetails'); 
 $this->db->where('transfertype', $purpose);
 $this->db->where('timetype', $timetype);
 $this->db->where('package', $string);
 $this->db->where('cartype', $cartype);
 $query = $this->db->get(); 
  $results = $query->row();
 // print_r($results);
  return $results->standardrate;
 
   
}
 
function cartypess(){
	$this->db->select('*');
	$query = $this->db->get('car_categories');
	return $result = $query->result_array();
	 
}

	function get_package(){

	$this->db->select('*');

		 $query = $this->db->get('package_details');

		$result = $query->result_array();

		//print_r($result);

		//exit;

		 return $result;	

	}

	function airport_book($data){

		$uneaque_id = 'CMC'.strtotime(date('m/d/Y H:i:s'));
		$username = $this->session->userdata('username');
		$purpose = 'Airport Transfer';
		$timetype = $this->time_type($data['air_pickup_time']);
		$assigned_for = $this->assigned_for($data['car_type'],$data['current_lat'],$data['current_lng']);
		// $data['promo_status'] = '';
		$result = array('username'=>$username,
						'uneaque_id'=>$uneaque_id,
						'purpose'=>$purpose,
						'pickup_area'=>$data['air_pickup_area'],
						'pickup_date'=>$data['air_pickup_date'],
						'drop_area'=>$data['air_drop_area'],
						'pickup_time'=>$data['air_pickup_time'],
						'area'=>$data['air_area'],
						'landmark'=>$data['air_land'],
						'pickup_address'=>$data['air_address'],
						'taxi_type'=>$data['car_type'],
						'status'=>'Booking',
						'promo_code'=>$data['air_promo_status']=='1'?$data['air_promo']:'',
						'distance'=>$data['distance'],
						'amount'=>$data['amount'],
						'transfer'=>$data['air_trans'],
						'assigned_for'=>$assigned_for,
						'item_status'=>'Pending',
						'km'=>$data['distance'],
						'timetype'=>$timetype
						);
		$this->db->insert('bookingdetails',$result);
		
		return $this->db->insert_id();


	}


	function outstation_book($data){
		$uneaque_id = 'CMC'.strtotime(date('m/d/Y H:i:s'));
		$username = $this->session->userdata('username');
		$purpose = 'Outstation Transfer';
		$timetype = $this->time_type($data['out_pickup']);
		$assigned_for = $this->assigned_for_out($data['car_type']);
		// $data['out_promo_status'] = '';
		$result = array('username'=>$username,
						'uneaque_id'=>$uneaque_id,
						'purpose'=>$purpose,
						'pickup_area'=>$data['out_drop_area'],
						'pickup_date'=>$data['datepicker_dep'],
						'drop_area'=>$data['pickup_area'],
						'pickup_time'=>$data['out_pickup'],
						'area'=>$data['out_area'],
						'landmark'=>$data['out_land'],
						'pickup_address'=>$data['out_address'],
						'taxi_type'=>$data['car_type'],
						'status'=>'Booking',
						'promo_code'=>$data['out_promo_status']=='1'?$data['out_promo']:'',
						'distance'=>$data['distance'],
						'amount'=>$data['amount'],
						'assigned_for'=>$assigned_for,
						'item_status'=>'Pending',
						'km'=>$data['distance'],
						'timetype'=>$timetype
						);
		$this->db->insert('bookingdetails',$result);
		return $this->db->insert_id();
	}

	function assigned_for($car_type,$current_lat,$current_lng){
		$settings = getsettingsdetails();
		if($settings->mechanic_assigned=='on'){
			$result = $this->db->query("SELECT driver_details.id, 3956 * 2 * ASIN(SQRT(POWER(SIN(($current_lat - driver_details.latitude) * pi()/180 / 2), 2) + COS($current_lat * pi()/180 ) * COS(driver_details.latitude * pi()/180) * POWER(SIN(($current_lng - driver_details.longitude) * pi()/180 / 2), 2) )) as distance FROM `driver_details` WHERE driver_details.car_type ='$car_type' AND NOT EXISTS(select * from bookingdetails where driver_details.id=bookingdetails.assigned_for and bookingdetails.status='Processing') having distance < 25 ORDER BY distance ASC LIMIT 0,1")->row();
			if(count($result)>0){
				return $result->id;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
		
	}

	function assigned_for_out($car_type){
		$settings = getsettingsdetails();
		if($settings->mechanic_assigned=='on'){
			$result = $this->db->query("SELECT driver_details.id FROM `driver_details` WHERE driver_details.car_type ='$car_type' AND NOT EXISTS(select * from bookingdetails where driver_details.id=bookingdetails.assigned_for and bookingdetails.status='Processing') ORDER BY id ASC LIMIT 0,1")->row();
			if(count($result)>0){
				return $result->id;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}

	function time_type($current_time){
		$day = "6:00 AM";
		$night = "10:00 PM";
		$date1 = DateTime::createFromFormat('H:i a', $current_time); 
		$date2 = DateTime::createFromFormat('H:i a', $day);
		$date3 = DateTime::createFromFormat('H:i a', $night);
		if ($date1 > $date2 && $date1 < $date3) {
			$timetype='day';
		}else{
			$timetype='night';
		}

		return $timetype;
	}

	
	    public function changepassword($data,$type,$username) {

         

        $old_psw = md5($data['old_pass']);
		
        $password = md5($data['passwords']);

        $cpassword = md5($data['cpassword']);  
       $datas=array('password'=>$password);
	   if($type=='user')
	   {
		   $this->db->select('*');
		    $this->db->where('username', $username);
		   $query = $this->db->get('userdetails');
		   $results = $query->row();
		    if($results){
		 if ($old_psw == $results->password) {
		        if ($password == $cpassword) {
                $this->db->where('username', $username);
				if($this->db->update('userdetails',$datas)){

                 return 1;
                } else {
                    return 0;
                }
            } else {
                return 2;
            }
        } else {
            return 3;
			}}
	   }else{
		   
		   $this->db->select('*');
		   $this->db->where('password', $old_psw);
		    $this->db->where('user_name', $username);
		   $query = $this->db->get('driver_details');
		   $results = $query->row();
		    if($results){
		 if ($old_psw == $results['password']) {
		        if ($password == $cpassword) {
                $this->db->where('user_name', $username);
				if($this->db->update('driver_details',$datas)){

                 return 1;
                } else {
                    return 0;
                }
            } else {
                return 2;
            }
        } else {
            return 3;
        }
			}
	   }
		}
		
		 function  sort_by_date($username,$type,$data) {
	 
     
	  if($type=='user')
	  {		 $this->db->select('*');
  
		   $this->db->where('username', $username);
		//  $this->db->where('status', 'Processing');
			$this->db->where('status', 'Booking');
			// $this->db->where('item_status', 'Completed');
			// $this->db->where('item_status', 'Cancelled');
			//$this->db->where('item_status', 'Completed');
			 $query = $this->db->get('bookingdetails');
	  }else{
		   $this->db->select('*');
		   $this->db->where('user_name', $username);	
		   $this->db->from('bookingdetails a'); 
		  $this->db->where('item_status', 'Pending');
			  $this->db->join('driver_details b', 'b.id=a.assigned_for', 'left');
				$query = $this->db->get(); 
	  }
	  return $results = $query->result();
	   
  }

  function fetch_point_cab($data){

  	$settings = $this->db->get('settings')->row();

	list($word,$currency) = explode(',', $settings->currency);

	$new_result = array();

  	$where = '';

  	$timetype = $data['time_type'];
  	$search_amount = $data['search_amount'];

  	if($data['search_amount']!=''){
  		$where = "AND (intailrate = $search_amount OR standardrate=$search_amount OR fromintailrate = $search_amount OR fromstandardrate = $search_amount)";
  	}

  	
  	$result = $this->db->query("SELECT cabdetails.*,car_categories.car_image FROM cabdetails INNER JOIN car_categories ON cabdetails.cartype = car_categories.car_type WHERE transfertype='Point to Point Transfer' AND timetype = '$timetype' $where ORDER BY intailrate ASC")->result();

  	//echo $this->db->last_query();


  	foreach ($result as $rs) {
  		$intialkm = $rs->intialkm;
		$intailrate = $rs->intailrate;
		$standard_rate = $rs->standardrate;

  		$fare_details = $currency.$intailrate.' for the first '.$intialkm.' '.$settings->measurements;
		$fare_details .= '('.$currency.$standard_rate.'/'.$settings->measurements.')';

		$res = array('cartype'=>$rs->cartype,'car_image'=>$rs->car_image,'fare_details'=>$fare_details);



		array_push($new_result,$res);
  	}

  	return $new_result;

  

  }


  function fetch_airport_cab($data){

  	$settings = $this->db->get('settings')->row();

	list($word,$currency) = explode(',', $settings->currency);

	$new_result = array();

  	$where = '';

  	$timetype = $data['time_type'];

  	$search_amount = $data['search_amount'];

  	if($data['search_amount']!=''){
  		$where = "AND (intailrate = $search_amount OR standardrate=$search_amount OR fromintailrate = $search_amount OR fromstandardrate = $search_amount)";
  	}



  	$result = $this->db->query("SELECT cabdetails.*,car_categories.car_image FROM cabdetails INNER JOIN car_categories ON cabdetails.cartype = car_categories.car_type WHERE transfertype='Airport Transfer' AND timetype = '$timetype' $where ORDER BY intailrate ASC")->result();

  	foreach ($result as $rs) {
  		$intialkm = $rs->intialkm;
		$intailrate = $rs->intailrate;
		$standard_rate = $rs->standardrate;

  		$fare_to_details = $currency.$intailrate.' for the first '.$intialkm.' '.$settings->measurements;
		$fare_to_details .= '('.$currency.$standard_rate.'/'.$settings->measurements.')';

		$fare_from_details = $currency.$rs->fromintailrate.' for the first '.$rs->fromintialkm.' '.$settings->measurements;
		$fare_from_details .= '('.$currency.$rs->fromstandardrate.'/'.$settings->measurements.')';

		$res = array('cartype'=>$rs->cartype,'car_image'=>$rs->car_image,'fare_details'=>$fare_to_details,'fare_from_details'=>$fare_from_details);

		array_push($new_result,$res);
  	}

  	return $new_result;

  

  }


  function fetch_station_cab($data){

  	$settings = $this->db->get('settings')->row();

	list($word,$currency) = explode(',', $settings->currency);

	$new_result = array();

  	$where = '';

  	$search_amount = $data['search_amount'];

  	if($data['search_amount']!=''){
  		$where = " AND (intailrate = $search_amount OR standardrate=$search_amount OR fromintailrate = $search_amount OR fromstandardrate = $search_amount)";
  	}



  	$result = $this->db->query("SELECT  cabdetails.*,car_categories.car_image,round_trip_package.package FROM cabdetails INNER JOIN car_categories ON cabdetails.cartype = car_categories.car_type LEFT JOIN round_trip_package ON round_trip_package.id = cabdetails.package WHERE transfertype='Outstation Transfer' $where ORDER BY round_trip_package.package ASC")->result();

  	foreach ($result as $rs) {
  		
		$standard_rate = $rs->standardrate;

  		$fare_details = $currency.$standard_rate.' Per Day ('.$rs->package.')';

		$res = array('cartype'=>$rs->cartype,'car_image'=>$rs->car_image,'fare_details'=>$fare_details);

		array_push($new_result,$res);
  	}

  	return $new_result;

  

  }


  function fetch_hour_cab($data){

  	$settings = $this->db->get('settings')->row();

	list($word,$currency) = explode(',', $settings->currency);

	$new_result =array();


  	$where = '';

  	$search_amount = $data['search_amount'];

  	if($data['search_amount']!=''){
  		$where = "AND (intailrate = $search_amount OR standardrate=$search_amount OR fromintailrate = $search_amount OR fromstandardrate = $search_amount)";
  	}



  	$result = $this->db->query("SELECT  cabdetails.*,car_categories.car_image,package_details.package FROM cabdetails INNER JOIN car_categories ON cabdetails.cartype = car_categories.car_type LEFT JOIN package_details ON package_details.id = cabdetails.package WHERE transfertype='Hourly Rental' $where ORDER BY cabdetails.package ASC")->result();

  	foreach ($result as $rs) {
  		
		$standard_rate = $rs->standardrate;

  		$fare_details = $currency.$standard_rate.' ('.$rs->package.')';

		$res = array('cartype'=>$rs->cartype,'car_image'=>$rs->car_image,'fare_details'=>$fare_details);

		array_push($new_result,$res);
  	}

  	return $new_result;

  

  }


}

?>
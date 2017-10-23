<?php
class Model_admin extends CI_Model{
function __construct() {
parent::__construct();
}
function login($data){
	 // grab user input
	
        $username = $data['email'];
        $password = md5($data['password']);
		$remember='';
		if(isset($data['rememberme'])){
        $remember = $data['rememberme'];
		}
        // Prep the query
		
       
        
        // Run the query
        $query = $this->db->query("select * from adminlogin where binary username ='$username' and binary password = '$password'");
        // Let's check if there are any results
	
        if($query->num_rows == 1)
        {
            // If there is a user, then create session data
            //$row = $query->result_array();
		if($remember=='on' && $remember!=''){
			
	$cookie = array(
                'name'   => 'username-admin',
                'value'  => $username,
                'expire' => 86500
            );
        //  $this->ci->db->insert("UserCookies", array("CookieUserEmail"=>$userEmail, "CookieRandom"=>$randomString));
            $this->input->set_cookie($cookie);

                $this->input->cookie('username-admin', false);    
 

			
		}
	
           
         $this->session->set_userdata('username-admin',$data['email']);
		  $user = $this->session->userdata('username-admin');
		  
		 foreach($query->result_array() as $row){
		
		  $this->session->set_userdata('role-admin',$row['role']);
		 }
		  $user1 = $this->session->userdata('role-admin');
		  
		   $this->db->select('B.rolename as rolename,A.role_id,A.page_id as pages');
$this->db->from('role B');// I use aliasing make joins easier
$this->db->join('role_permission A', ' B.r_id = A.role_id');
$this->db->where('B.rolename',$user1);


$query1 = $this->db->get();
		  foreach($query1->result_array() as $row1){
		
		  $this->session->set_userdata('permission',$row1['pages']);
		 }
		 $user2 = $this->session->userdata('permission');
            //return $row;
			echo $user1;
			
			
        }
        // If the previous process did not validate
        // then return false.
		else
		{
        //return false;
		echo 1;
		}
		

}
function deleteuser($data){
	
	
		$id = $data['id'];
		
		$this->db->where('id', $id);
		 
	if($this->db->delete('userdetails'))
	
                  {
	
            echo 1;
                    }
               else{
	
              echo 0;
                    }

}
function userinsert($data)
{
	  $username = $data['username'];	  
	  $email = $data['email'];
	  $this->db->where('username', $username);
	  $query = $this->db->get('userdetails');
	 
	   if($query->num_rows == 0)
        {
			 $this->db->where('email',  $email);
			 $query1 = $this->db->get('userdetails');
			if($query1->num_rows == 0)
        {
			$data['user_status']='Active';
if($this->db->insert('userdetails',$data))
{
	 $this->session->set_userdata('username-admin',$data['username']);
	 $user1 = $this->session->userdata('username-admin');
echo 1;
}
else{
echo 0;
}
		}else{
			echo 4;
		}
		}else{
			echo 3;
		}
}



function deletebook($data){
	
	
		$id = $data['id'];
		
		$this->db->where('id', $id);
		 
	if($this->db->delete('bookingdetails'))
	
                  {
	
            echo 1;
                    }
               else{
	
              echo 0;
                    }

}

function edituser($data){
		$id = $data['id'];
	$username = $data['username'];	  
	  $email = $data['email'];
	  $this->db->where('username', $username);
	  $query = $this->db->get('userdetails');
	 
	 
			 $this->db->where('email',  $email);
			 $query1 = $this->db->get('userdetails');
		 				   			
		$this->db->where('id', $id);
	if($this->db->update('userdetails',$data))
	
{
	
echo 1;
}
else{
	
echo 0;
}
 

}

function pointupdate($data){
	    
		
		 $driver = $data['assigned_for'];
		 $username =$data['username'];
		
		if(isset($data['id'])){
			$id = $data['id'];
			$this->db->where('id', $id);
		}
		if(isset($data['uneaque_id'])){
			$bookid = $data['uneaque_id'];
			$this->db->where('uneaque_id', $bookid);
		}
		
	if($this->db->update('bookingdetails',$data))
	
{
	
	
	$query3 = $this->db->query(" SELECT * FROM `settings` order by id DESC ");
	$row3 = $query3->row('settings');
	$from= $row3->smtp_username;
    $name=$row3->title;
   $urls= base_url();
    $sub="Driver Details";
	 $query = $this->db->query("SELECT * FROM  userdetails WHERE  username ='$username'");
		 $row = $query->row('userdetails');
	$email= $row->email;
	 $query1 = $this->db->query("SELECT * FROM  driver_details WHERE  id ='$driver'");
		 $row1 = $query1->row('driver_details');
	 $mailTemplate='<div style="width:660px; height:400px; margin:0 auto; background:#f2c21e; padding:20px 20px 20px 20px; font-family: Century Gothic,Verdana,Geneva,sans-serif; border:solid #c79e13 1px;">
	
    <div style="width:100%; float:left; padding:0 0 10px 0;">
    <div style="width:138px; height:73px; float:left; margin:0 0 0 20px;"> <img src="'.$urls.'assets/images/carss.png" alt="" /></div>
    <div style="width:350px; float:left; padding:25px 0 0 0; text-align:center; font-size:18px; "> BOOKING DETAILS </div>
    
    
    </div>
    
    
    
    
        <div style="background:#fff;  float:left; width:96.3%;   border-top-right-radius: 8px; border-top-left-radius: 8px; padding:15px 12px 0 12px;  ">
    		<div style="width:100%; padding:10px 0 10px 0; float:left; color:#666261; font-size:14px; text-align:center;"> Driver Details </div>
                 <div style="width:100%; float:left; padding:15px 0 15px 0; border-bottom:solid #cdcdcd 1px; border-top:solid #cdcdcd 1px;"> 
                 <div style="width:100%; float:left; font-size:14px; text-align:center;"> Thank you for choosing our service. We are happy to serve you!!!</div>
            </div>
        </div>
        
        
        
        
        
        <div style="background:#3a3a3c;     float:left; width:96.3%;  padding:5px 12px 10px 12px;">
          <div style="width:100%; float:left;">
            
              <div style="width:100%;   float:left; background:#585858; padding:15px 0 15px 0; margin:5px 0 0 0; "> 
                <div style="width:100%; float:left; text-align:center; color:#ffdd1a; font-size:16px;">Driver Name:  <div style="color:#fff; font-size:14px; display:inline;">'. $row1->name.'</div></div>
                </div>
                
          <div style="width:100%;   float:left; background:#585858; padding:15px 0 15px 0; margin:5px 0 0 0; "> 
                <div style="width:100%; float:left; text-align:center; color:#ffdd1a; font-size:16px;"> Mobile: <div style="color:#fff; font-size:14px; display:inline;">'. $row1->phone.'</div></div>
                </div>
                
          <div style="width:100%;   float:left; background:#585858; padding:15px 0 15px 0; margin:5px 0 0 0; "> 
                <div style="width:100%; float:left; text-align:center; color:#ffdd1a; font-size:16px;"> Address: <div style="color:#fff; font-size:14px; display:inline;">'. $row1->address.'</div></div>
                </div>
                
                
                
                
            </div>
       </div>
            
            
            
            
        <div style="background:#fff;  float:left; width:96.3%;    border-bottom-right-radius: 8px; border-bottom-left-radius: 8px; padding:20px 12px 20px 12px;  "></div>
            
            
            
            
            
            
            
        </div>







</div>';
	
	$this->home->send_mail($from,$name,$email,$sub,$mailTemplate);
	
	
	$email1= $row1->email;
	$sub1="Passenger Details";
	
	if(isset($data['id'])){
			$id = $data['id'];
			$s ="WHERE  id ='$id'";
		}
		if(isset($data['uneaque_id'])){
			$bookid = $data['uneaque_id'];
			$s ="WHERE  uneaque_id ='$bookid'";
			
		}
	 $query31 = $this->db->query("SELECT * FROM  bookingdetails ".$s );
		 $row31 = $query31->row('bookingdetails');
	$mailTemplate1='<div style="width:660px; height:400px; margin:0 auto; background:#f2c21e; padding:20px 20px 20px 20px; font-family: Century Gothic,Verdana,Geneva,sans-serif; border:solid #c79e13 1px;">
	
    <div style="width:100%; float:left; padding:0 0 10px 0;">
    <div style="width:138px; height:73px; float:left; margin:0 0 0 20px;"> <img src="'.$urls.'assets/images/carss.png" alt="" /></div>
    <div style="width:350px; float:left; padding:25px 0 0 0; text-align:center; font-size:18px; "> BOOKING DETAILS </div>
    
    
    </div>
    
    
    
    
        <div style="background:#fff;  float:left; width:96.3%;   border-top-right-radius: 8px; border-top-left-radius: 8px; padding:15px 12px 0 12px;  ">
    		<div style="width:100%; padding:10px 0 10px 0; float:left; color:#666261; font-size:14px; text-align:center;"> Passenger Details </div>
                 <div style="width:100%; float:left; padding:15px 0 15px 0; border-bottom:solid #cdcdcd 1px; border-top:solid #cdcdcd 1px;"> 
                 <div style="width:100%; float:left; font-size:14px; text-align:center;"> Congrats!!! You got a new trip.</div>
            </div>
        </div>
        
        
        
        
        
        <div style="background:#3a3a3c;     float:left; width:96.3%;  padding:5px 12px 10px 12px;">
          <div style="width:100%; float:left;">
            
              <div style="width:100%;   float:left; background:#585858; padding:15px 0 15px 0; margin:5px 0 0 0; "> 
                <div style="width:100%; float:left; text-align:center; color:#ffdd1a; font-size:16px;">Passenger Name:  <div style="color:#fff; font-size:14px; display:inline;">'. $row->username.'</div></div>
                </div>
                
          <div style="width:100%;   float:left; background:#585858; padding:15px 0 15px 0; margin:5px 0 0 0; "> 
                <div style="width:100%; float:left; text-align:center; color:#ffdd1a; font-size:16px;">Pickup-Drop Area: <div style="color:#fff; font-size:14px; display:inline;">'. $row31->pickup_area.'-'. $row31->drop_area.'</div></div>
                </div>
                
          <div style="width:100%;   float:left; background:#585858; padding:15px 0 15px 0; margin:5px 0 0 0; "> 
                <div style="width:100%; float:left; text-align:center; color:#ffdd1a; font-size:16px;"> Pickup date & Time: <div style="color:#fff; font-size:14px; display:inline;">'. date('D, d M',strtotime($row31->pickup_date)).', '. $row31->pickup_time.'</div></div>
                </div>
                
                
                
                
            </div>
       </div>
            
            
            
            
        <div style="background:#fff;  float:left; width:96.3%;    border-bottom-right-radius: 8px; border-bottom-left-radius: 8px; padding:20px 12px 20px 12px;  "></div>
            
            
            
            
            
            
            
        </div>







</div>';
		
$this->home->send_mail($from,$name,$email1,$sub1,$mailTemplate1);
		echo 1;
	
	

	
}
else{
	
echo 0;
}

}
function pormoadd($data)
{
	  
if($this->db->insert('promocode',$data))
{
	 
echo 1;
}
else{
echo 0;
}
		
}
function deleteprom($data){
	
	
		$id = $data['id'];
		
		$this->db->where('id', $id);
		 
	if($this->db->delete('promocode'))
	
                  {
	
            echo 1;
                    }
               else{
	
              echo 0;
                    }

}


function promoupdate($data){
	    
		$id = $data['id'];
		
		$this->db->where('id', $id);
	if($this->db->update('promocode',$data))
	
{
	
echo 1;
}
else{
	
echo 0;
}

}

function taxiadd($data)
{
	
	$cartype= $data['cartype'];
	if(isset($data['timetype'])){
	$timetype= $data['timetype'];
	}
	
	$transfertype = $data['transfertype'];
	if(isset($data['package'])){
		$package = $data['package'];
		$this->db->where("package",$package);
	}
	if(isset($data['timetype'])){
	 $this->db->where('timetype', $timetype);
	}
	 $this->db->where('cartype', $cartype);
	  $this->db->where('transfertype', $transfertype);
	  $query = $this->db->get('cabdetails');  
	  if($query->num_rows == 0)
        {
if($this->db->insert('cabdetails',$data))
{
	 
echo 1;
}
else{
echo 0;
}
		}else{
			echo 2;
		}
		
}

function updatetaxi($data){
	    
	$id = $data['id'];
	$cartype= $data['cartype'];
	if(isset($data['timetype'])){
	$timetype= $data['timetype'];
	}
	$transfertype = $data['transfertype'];
	if(isset($data['package'])){
		$package = $data['package'];
		$this->db->where("package",$package);
	}
	if(isset($data['timetype'])){
	 $this->db->where('timetype', $timetype);
	}
	 $this->db->where("id !=",$id);
	
	 $this->db->where('cartype', $cartype);
	  $this->db->where('transfertype', $transfertype);
	   $query = $this->db->get('cabdetails');  
	  /*if($query->num_rows > 0){
		 echo 2;
	  }else{*/
		  $this->db->where('id', $id);
	if($this->db->update('cabdetails',$data))
	
{
	
echo 1;
}
else{
	
echo 0;
}
		  
		  
		 
	 // }

}
function delcabdetails($data){
	
	
		$id = $data['id'];
		
		$this->db->where('id', $id);
		 
	if($this->db->delete('cabdetails'))
	
                  {
	
            echo 1;
                    }
               else{
	
              echo 0;
                    }

}

function updatepass($data){
	     if($username = $this->session->userdata('username-admin')){
		$username = $this->session->userdata('username-admin');
		}else{
		$username = $this->input->cookie('username-admin', false);
		}
		$pass = md5($data['password']);
		$change = md5($data['change']);
		$confirma = $data['confirma'];
		$this->db->where('username', $username);
		$this->db->where('password', $pass);
		$query = $this->db->get('adminlogin');
		if($query->num_rows == 1){
	if($data['change'] == $data['confirma'])
{
			
		$value = array('password'=>$change );
      $this->db->where('username',$username);
	if($this->db->update('adminlogin',$value))
	
{
	
echo 1;
}
else{
	
echo 0;
}

} else{
	echo 2;
	//not e
}

		}else{
			echo 3;
			//current pas no
		}

}
function driveradd($data)
{
	$username= $data['user_name'];
	$license= $data['license_no'];
	
	$this->db->where('user_name', $username);
	  $query = $this->db->get('driver_details');  
	  if($query->num_rows == 0)
        {
	  $this->db->where('license_no', $license);
	  $query = $this->db->get('driver_details');  
	  if($query->num_rows == 0)
        {
			$data['user_status']='Active';
if($this->db->insert('driver_details',$data))
{
	 
echo 1;
}
else{
echo 0;
}
		}else{
			echo 2;
		}
		}else{
			echo 3;
		}
		
}
function updatedriver($data){
	    
		$id = $data['id'];
		
		$this->db->where('id', $id);
	if($this->db->update('driver_details',$data))
	
{
	
echo 1;
}
else{
	
echo 0;
}

}

function deletedriver($data){
	
	
		$id = $data['id'];
		
		$this->db->where('id', $id);
		 
	if($this->db->delete('driver_details'))
	
                  {
	
            echo 1;
                    }
               else{
	
              echo 0;
                    }

}

function db_connect($data)

{ 

		$filename = 'sql/techwbzd_callmycab.sql';
// MySQL host
 $mysql_host = $data['dbhost'];
// MySQL username
$mysql_username = $data['dbuser'];
// MySQL password
$mysql_password = $data['dbpass'];
// Database name
 $mysql_database = $data['dbname'];
$con = mysqli_connect($mysql_host, $mysql_username, $mysql_password,$mysql_database) or die('Error connecting to MySQL server');
// Select database


// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line)
{
// Skip it if it's a comment
if (substr($line, 0, 2) == '--' || $line == '')
    continue;

// Add this line to the current segment
$templine .= $line;
// If it has a semicolon at the end, it's the end of the query
if (substr(trim($line), -1, 1) == ';')
{
    // Perform the query
    mysqli_query($con,$templine);
    // Reset temp variable to empty
    $templine = '';
}
}

 echo '<div id="dup-step1-dbconn-status" >
				<div style="padding: 0px 10px 10px 10px;">		
					<div id="dbconn-test-msg" style="min-height:80px;text-align:center"><div class="dup-db-test">Tables imported successfully</div><label>Database :</label>
<div class="dup-fail">"'.$mysql_database.'"</div><br><label>Username :</label>
<div class="dup-fail">"'.$mysql_username.'"</div><br><label>Password :</label>
<div class="dup-fail">"'.$mysql_password.'"</div></div>
				</div>
				</div>';
 
 

 $myfile = fopen("application/config/database.php", "w") or die("Unable to open file!");
 $active_record='';
$txt = '<?php  if ( ! defined("BASEPATH")) exit("No direct script access allowed");$active_group = "default";
$active_record = TRUE;'."\r\n";

$txt .='$db["default"]["hostname"] = "'.$mysql_host.'";'."\r\n";
$txt .='$db["default"]["username"] = "'.$mysql_username.'";'."\r\n";
$txt .='$db["default"]["password"] = "'. $mysql_password.'";'."\r\n";
$txt .='$db["default"]["database"] ="'.$mysql_database.'";'."\r\n";
$txt .='$db["default"]["dbdriver"] = "mysqli";
$db["default"]["dbprefix"] = "";
$db["default"]["pconnect"] = TRUE;
$db["default"]["db_debug"] = FALSE;
$db["default"]["cache_on"] = FALSE;
$db["default"]["cachedir"] = "";
$db["default"]["char_set"] = "utf8";
$db["default"]["dbcollat"] = "utf8_general_ci";
$db["default"]["swap_pre"] = "";
$db["default"]["autoinit"] = TRUE;
$db["default"]["stricton"] = FALSE;';

fwrite($myfile, $txt);
fclose($myfile);
}

function insta($data)
{ 
$id=$data['id'];
			$this->db->where('id', $id);
			if($this->db->update('settings',$data)){
			echo 0;	
			}else{
echo 1;	
}	
}
function settings($data)
{  
   if (!empty($_POST['paypal_option'])){
$data['paypal_option'] = implode(",", $_POST['paypal_option']);
			}

$query = $this->db->get('settings');  
	  if($query->num_rows == 0)
        {
    
	
if($this->db->insert('settings',$data))
{
	
	
 
	 
 $this->session->set_flashdata('item', array('message' => 'Record updated successfully','class' => 'success') );
$this->session->flashdata('item');

//redirect to some function
redirect("admin/add_settings");
}
else{
$this->session->set_flashdata('item', array('message' => 'Error','class' => 'error') );
$this->session->flashdata('item');
redirect("admin/add_settings");
}	
		}else{
			$id=$data['id'];
			$this->db->where('id', $id);
			if($this->db->update('settings',$data)){
				 $this->session->set_flashdata('item', array('message' => 'Record updated successfully','class' => 'success') );
$this->session->flashdata('item');

//redirect to some function
redirect("admin/add_settings");
			}else{
$this->session->set_flashdata('item', array('message' => 'Error','class' => 'error') );
$this->session->flashdata('item');
redirect("admin/add_settings");
}	
		}
		
}
function roleadd($data)
{
	$role= $data['rolename'];
	 
	
	  $this->db->where('rolename', $role);
	  $query = $this->db->get('role');  
	  if($query->num_rows == 0)
        {
		$data = array(
'created_date' => date('Y-m-d H:i:s',now()),
'rolename'  => $role
);	
if($this->db->insert('role',$data))
{
$insert_id = $this->db->insert_id();
/*foreach ($this->input->post('page_id') as $key => $value)
{
    echo "Index {$key}'s value is {$value}.";
}*/
/*foreach ($this->input->post('page_id') as $attribute){
        $data['page_id'] = implode(',',$attribute);
       
}
*/ 
/*if($this->input->post('page_id1')){
	$data1['page_id'] = implode(',',$this->input->post('page_id1'));
}else{
$data1['page_id'] =implode(',',$this->input->post('page_id'));
}*/

if($this->input->post('page_id1')){
	$page_id = explode(",", $this->input->post('page_id1'));
}else{
	$page_id = $this->input->post('page_id');
}

foreach ($page_id as $country)
{
$user_countries = array(
'page_id' => $country,
'rol_id' => $insert_id
);


		$this->db->insert('role_permission',$user_countries);
		
   
}

 

echo 1;
}
else{
echo 0;
}

		}else{
			echo 2;
		}
		

}
function deleterole($data){
	
	
		$id = $data['rolename'];
		
		$this->db->where('rolename', $id);
		 
	if($this->db->delete('role'))
	
                  {
	
            echo "Rolename Removed Successfully";
                    }
               else{
	
              echo "error";
                    }

}
function updaterole($data){
	    
		$role =$data['role_id'];
	
	$role_permission = $data['page_id'];
	$selects =$this->db->query("select * from role_permission where role_id ='$role' "); 
	if($selects->num_rows == 0) {
		$user_countries = array(
'role_id' => $role,
'page_id' => $role_permission

);
		if( $this->db->insert('role_permission',$user_countries)){
			echo 1;
		}else{
			echo 2;
		}
	} else{
		 foreach($selects->result_array() as $row){
			 $r_id= $row['r_id'];
		
	 $this->db->where('r_id', $r_id);
	if($this->db->update('role_permission',$data)){
	
		echo 3;
	}else{
		echo 4;
	}
		 }
	}

}

function addrole($data)
{
	$rolename= $data['rolename'];
	$created_date =date('Y-m-d H:i:s');
	 $this->db->where('rolename', $rolename);
	 
	  $query = $this->db->get('role');  
	  if($query->num_rows == 0)
        {
if($this->db->insert('role',$data))
{
	 
echo" Rolename Added successfully";
}
else{
echo "Error";
}
		}else{
			echo "Rolename Already Added";
		}
		
}
function delete_backend_user($data){
	
	
		$id = $data['id'];
		
		$this->db->where('id', $id);
		 
	if($this->db->delete('adminlogin'))
	
                  {
	
            echo 1;
                    }
               else{
	
              echo 0;
                    }

}
function user_backend_insert($data)
{
	
	  $username = $data['username'];
	  $email = $data['email'];
	  $data['password']=md5($data['password']);
	  $this->db->where('username', $username);
	  $query = $this->db->get('adminlogin');
	 $rolename=$data['role'];
	   if($query->num_rows == 0)
        {
			 $this->db->where('email',  $email);
			 $query1 = $this->db->get('adminlogin');
			if($query1->num_rows == 0)
        {
			
	$date =date('Y-m-d H:i:s');
	


if($this->db->insert('adminlogin',$data) )
{
	 $this->db->where('rolename',  $rolename);
	 $query3 = $this->db->get('role');
			if($query3->num_rows == 0)
        {
	$this->db->set('rolename', $rolename); 
	
    $this->db->insert('role');	
echo 1;
		}
}
else{
echo 0;
}
		}else{
			echo 4;
		}
		}else{
			echo 3;
		}
}
function edit_backend_user($data){
	    $email = $data['email'];
		$id = $data['id'];
		
		$this->db->where('id', $id);
	if($this->db->update('adminlogin',$data))
	
{
	
echo 1;
}
else{
	
echo 0;
}

}
function delete_air($data){
	
	
		$id = $data['id'];
		
		$this->db->where('id', $id);
		 
	if($this->db->delete('airport_list'))
	
                  {
	
            echo 1;
                    }
               else{
	
              echo 0;
                    }

}
function delete_package($data){
	
	
		$id = $data['id'];
		
		$this->db->where('id', $id);
		 
	if($this->db->delete('package_details'))
	
                  {
	
            echo 1;
                    }
               else{
	
              echo 0;
                    }

}
function air_insert($data)
{
	$name= $data['name'];
	
	
	  $this->db->where('name', $name);
	  $query = $this->db->get('airport_details');  
	  if($query->num_rows == 0)
        {
if($this->db->insert('airport_details',$data))
{
	 
echo 1;
}
else{
echo 0;
}
		}else{
			echo 2;
		}
		
}
function airmanage_update($data){
	    
		$id = $data['id'];
		
		$this->db->where('id', $id);
	if($this->db->update('airport_list',$data))
	
{
	
echo 1;
}
else{
	
echo 0;
}

}
function package_update($data){
	    
		$id = $data['id'];
		
		$this->db->where('id', $id);
	if($this->db->update('package_details',$data))
	
{
	
echo 1;
}
else{
	
echo 0;
}

}
function places_insert($data)
{
	$name= $data['location'];
	
	
	  $this->db->where('location', $name);
	  $query = $this->db->get('places');  
	  if($query->num_rows == 0)
        {
if($this->db->insert('places',$data))
{
	 
echo 1;
}
else{
echo 0;
}
		}else{
			echo 2;
		}
		
}
function deleteplaces($data){
	
	
		$id = $data['id'];
		
		$this->db->where('id', $id);
		 
	if($this->db->delete('places'))
	
                  {
	
            echo 1;
                    }
               else{
	
              echo 0;
                    }

}


function updateplace($data){
	    
		$id = $data['id'];
		$places = $data['location'];
		 $this->db->where("id !=",$id);
	 
	  $this->db->where('location', $places);
	   $query = $this->db->get('places');  
	  if($query->num_rows > 0){
		 echo 2;
	  }else{
		
		$this->db->where('id', $id);
	if($this->db->update('places',$data))
	
{
	
echo 1;
}
else{
	
echo 0;
}

}
}

function insertairport($data)
{
	$name= $data['name'];
	
	
	  $this->db->where('name', $name);
	  $query = $this->db->get('airport_details');  
	  if($query->num_rows == 0)
        {
if($this->db->insert('airport_details',$data))
{
	 
echo 1;
}
else{
echo 0;
}
		}else{
			echo 2;
		}
		
}
function insertpackage($data)
{
	$name= $data['package'];
	
	
	  $this->db->where('package', $name);
	  $query = $this->db->get('package_details');  
	  if($query->num_rows == 0)
        {
		
	
if($this->db->insert('package_details',$data))
{
	 
echo 1;
}
else{
echo 0;
}
		}else{
			echo 2;
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
        
        $this->email->send();
        
        //echo	 $this->email->print_debugger();
    }
function status_update($data){
	    
		$id = $data['id'];
		 
		$status ='Complete';
		$value=array('status'=>'Complete');
$book_details = $this->send_rating($id);
	if($book_details==true){
		$this->db->where('id', $id);
	if($this->db->update('bookingdetails',$value))
	
{
	
	echo 1;	
	

}
else{
	
echo 0;
}
}
}function send_rating($id){
	$book_details = $this->get_booking_details($id);
	$settings =$this->get_settings_details();
	$user_details =$this->get_user_details($book_details->username);
	$driver_details =$this->get_driver_details($book_details->assigned_for);
	$str = $settings->currency;
	$curr = explode(',',$str);
	$from= $settings->smtp_username;
	$s = base_url();
    $name=$settings->title;
    $msg='Rating';
    $sub="Rating Driver";
	$email = $user_details->email;
	 if(isset($book_details->pickup_area)){ 
			$pickup_area =$book_details->pickup_area;
			}else{
				$pickup_area =$book_details->pickup_address;
     }if(isset(	$driver_details->name)){
		 $driver_name=$driver_details->name;
	 }else{
		  $driver_name=$driver_details->email;
	 }
	$template='<div style="width:660px; height:900px; margin:0 auto; background:#f2c21e; padding:20px 20px 20px 20px; font-family: Century Gothic,Verdana,Geneva,sans-serif; border:solid #c79e13 1px;">
	
    <div style="width:100%; float:left; padding:0 0 10px 0;">
    <div style="width:138px; height:73px; float:left; margin:0 0 0 20px;"> <img src="'.$s.'assets/images/carss.png" alt="" /></div>
    <div style="width:350px; float:left; padding:25px 0 0 0; text-align:center; font-size:18px; "> BOOKING DETAILS </div>
    
    
    </div>
    
    
    
    
        <div style="background:#fff;  float:left; width:96.3%;   border-top-right-radius: 8px; border-top-left-radius: 8px; padding:15px 12px 0 12px;  ">
    		<div style="width:100%; padding:10px 0 10px 0; float:left; color:#666261; font-size:14px;"> Hi '.$book_details->username.', thanks for booking with us. </div>
                 <div style="width:100%; float:left; padding:20px 0 20px 0; border-bottom:solid #cdcdcd 1px; border-top:solid #cdcdcd 1px;"> 
                 <div style="width:30%; float:left; font-size:17px;"> Trip#1 </div>
                 <div style="width:40%; float:left; font-size:17px;"> '.$book_details->uneaque_id.'</div>
                 <div style="width:30%; float:left;">  
                 
                 <a href="#"> <div style="width:100px; height:30px; background:#58585a; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; font-size:12px; color:#fff; 
                 text-align:center; line-height:25px; text-decoration:none; float:right;"> Track Booking </div> </a>
                 
                  </div>
            </div>
        </div>
        
        
        
        
        
        <div style="background:#3a3a3c;     float:left; width:96.3%;  padding:0px 12px 10px 12px;">
        	<div style="width:100%; float:left; padding:35px 0 30px 0;">
            <div style="width:43%; float:left; color:#ffdd1a; font-size:16px; padding:5px 0 0 0; line-height:22px;">'.$pickup_area.'</div>
            <div style="width:15%; float:left; text-align:center;"> <img src="'.$s.'assets/images/arrow.png" alt="" /> </div>
            <div style="width:42%; float:left; color:#ffdd1a; font-size:16px; padding:5px 0 0 0; line-height:22px;">'.$book_details->drop_area.'</div>
            </div>
            
            
            <div style="width:100%; float:left;">
                <div style="width:32%;   float:left; background:#585858; padding:24px 0 24px 0; "> 
                <div style="width:100%; float:left; text-align:center; color:#fff; font-size:15px;"> '.$book_details->taxi_type.' </div>
                <div style="width:100%; float:left; text-align:center; color:#bbbbbb; font-size:14px; padding:5px 0 0 0;"> AC </div> 
                </div>
                
                <div style="width:32%; margin:0 12px 0 12px;   float:left; background:#585858; padding:24px 0 24px 0; "> 
                <div style="width:100%; float:left; text-align:center; color:#fff; font-size:15px;"> '. $curr[1].''.$book_details->amount.' </div>
                <div style="width:100%; float:left; text-align:center; color:#bbbbbb; font-size:14px; padding:5px 0 0 0; ">  </div> 
                </div>
                
                <div style="width:32%;   float:left; background:#585858; padding:24px 0 24px 0; "> 
                <div style="width:100%; float:left; text-align:center; color:#fff; font-size:15px;">'.$book_details->pickup_time.' </div>
                <div style="width:100%; float:left; text-align:center; color:#bbbbbb; font-size:14px; padding:5px 0 0 0;">'. date('D, d M',strtotime( $book_details->pickup_time)).'</div> 
                </div>
            </div>
            
            <div style="width:100%; float:left; color:#bbbbbb; padding:14px 0 8px 0; font-size:12px;"> *All complaints with regard to fares should be referred to us within 2 days of completion of the trip. </div>
       </div><div style="background:#fff;  float:left; width:96.3%;    border-bottom-right-radius: 8px; border-bottom-left-radius: 8px; padding:12px 12px 20px 12px;  ">
        
        
        
        
        
        
        
        
        <div style="background:#3a3a3c; float:left;  width:96.3%;  padding:18px 12px 10px 12px;  border-radius: 8px;">
          <div style="width:33%; height:175px; float:left; border-right: solid #585858 1px; ">
		  <form method="post" onsubmit="try {return window.confirm("You are submitting information to an external page.\nAre you sure?");} catch (e) {return false;}" target="_blank" action="'.base_url().'admin/rating">
            <div  style="width:100%; float:left">
			<input type="hidden" value="'.$user_details->id.'" name="users">
			<input type="hidden" value="'.$book_details->assigned_for.'" name="driver_id">
              <div style="width:15%; float:left;"><img src="'.$s.'assets/images/star.png" alt="" />
                <input name="rating" type="radio" value="1" />
              </div>
              <div style="width:15%; float:left;"><img src="'.$s.'assets/images/star.png" alt="" />
                <input name="rating" type="radio" value="2" />
              </div>
              <div style="width:15%; float:left;"><img src="'.$s.'assets/images/star.png" alt="" />
                <input name="rating" type="radio" value="3" />
              </div>
              <div style="width:15%; float:left;"><img src="'.$s.'assets/images/star.png" alt="" />
                <input name="rating" type="radio" value="4" />
              </div>
              <div style="width:15%; float:left;"><img src="'.$s.'assets/images/star.png" alt="" />
                <input name="rating" type="radio" value="5" />
              </div>
            </div>
            <div style="width:100%; margin:10px 0 0 0; float:left;">
              <textarea  placeholder=" Leave a comment..." cols="" rows=""></textarea>
            </div>
            <div style=" float:left;"> 
             
		<input type="submit" value="submit" style="width:80px; margin:5px 0 0 0; height:30px; background:#ffdd1a; 
        -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; font-size:12px; color:#1f1f1f; 
        text-align:center; line-height:25px; text-decoration:none; float:right;"
              ></div>
			  
          </div>
		  </form>
          <div style="width:32%; height:40px; float:left;   border-right: solid #585858 1px;  padding:65px 5px 65px 10px;">
            <div style="width:100%; float:left; color:#fff; font-size:12px;"> Billed by: </div>
            <div style="width:100%; float:left; color:#ffdd1a; font-size:16px;"> '.$driver_name.' </div>
            <div style="width:100%; float:left; color:#fff; font-size:13px;"> '.$driver_details->car_no.'  ('.$driver_details->car_type.') </div>
          </div>
          <div style="width:30%; height:40px; float:left; padding:65px 0 60px 10px;">
            <div style="width:100%; float:left; color:#fff; font-size:12px;"> Taxi Operator: </div>
            <div style="width:100%; float:left; color:#fff; font-size:16px;"> Sansar Media </div>
          </div>
        </div>




                
                
                
                
                
                
                
                
        
        
        <div style="width:100%; float:left; font-size:16px; padding:0 0 10px 0;"> Extra Charges: </div> 
        <div style="width:100%; float:left; color:#666262; font-size:11px; line-height:22px;">
        
        * Maximum of 4 passengers allowed for Indica & Sedan. <br />
        * Cancellation charges of Rs.100 applicable if cancelled within 30 mins of pickup time. <br />
        * Any Toll, Parking, as applicable. <br />
        * No waiting charges upto 15 mins after scheduled pickup time. Rs.50 per 30 mins after that. <br /> 
        * Final fare payable will include Service Tax
        
        </div>
 
        </div>
            
            
            
            
            
            
            
        </div>







</div>';
	   //$this->home->send_mail($from,$name,$email,$sub,$template);
	   return true;
}function get_driver_details($id){
	$select_data="*";
	$where_data = array(	// ----------------Array for check data exist ot not
				'id'     => $id
			);
			
	$table="driver_details";
	$result = $this->get_table_where( $select_data, $where_data, $table );
	return $result;
}
function get_user_details($username){
	$select_data="*";
	$where_data = array(	// ----------------Array for check data exist ot not
				'username'     => $username
			);
			
	$table="userdetails";
	$result = $this->get_table_where( $select_data, $where_data, $table );
	return $result;
}
function get_settings_details(){
	$select_data="*";
	$where_data = array(	// ----------------Array for check data exist ot not
				'id'     => 1
			);
			
	$table="settings";
	$result = $this->get_table_where( $select_data, $where_data, $table );
	return $result;
}
function get_booking_details($id){
	$select_data="*";
	$where_data = array(	// ----------------Array for check data exist ot not
				'id'     => $id
			);
			
	$table="bookingdetails";
	$result = $this->get_table_where( $select_data, $where_data, $table );
	return $result;
}	
function blog_upload($data){
	  //var_dump($data);
		$id = $data['id'];
		$content = $data['blog_content'];
		$name = $data['block_name'];
	    $value=array('blog_content'=>$content,'block_name'=>$name);


		$this->db->where('id', $id);
	if($this->db->update('blogs',$value))
	
{
	
echo 1;
}
else{
	
echo 0;
}

}

function book_admin($data){
	
        $data['uneaque_id'] = 'CMC'.strtotime(date('m/d/Y H:i:s'));
		$data['status'] = "Processing";
		
	if($this->db->insert('bookingdetails',$data))
{
	echo 0;
	}else{
		echo 1;
	}
		
	}
	
	
	function languagesetupdate($data){
	    
		$id = $data['id'];
		
		$this->db->where('id', $id);
	if($this->db->update('language_set',$data))
	
{
	
echo 1;
}
else{
	
echo 0;
}

}


function insertlanguage($data)
{
	$textFile= $data['languages'];
	// var_dump($textFile);
	 // var_dump($data);

  $extension = ".php";
  $filename='includes/'.$textFile.$extension;
  // var_dump($filename);
  
	  $myfile = fopen($filename, "wb") or die("Unable to open file!"); 
	  $txt = '<?php ';				
			 
		foreach ($data as $keys => $values) {
			 
			$txt .= '$'.$keys.'= "'.$values.'";'."\r\n";
			fwrite($myfile, $txt);
			 $txt="";
		   }
 fwrite($myfile, $txt);
fclose($myfile);
	$user = array(
'languages' => $textFile


);
      if(isset($data['id'])){
		  $id =  $data['id'];
		$this->db->where("id !=",$id);  
	  }
	  $this->db->where('languages', $textFile);
	  $query = $this->db->get('language_set');  
	  if($query->num_rows == 0)
        {
if(isset($data['id'])){
	$user1 = array(
'languages' => $textFile


);
	$this->db->where('id', $id);
	if($this->db->update('language_set',$user1)){

	 
echo 1;
}
else{
echo 0;
}
}else{

if($this->db->insert('language_set',$user))
{
	 
echo 1;
}
else{
echo 0;
}
}
		}else{
			echo 2;
		}
		
}


function delete_langauge($data){
	
	
		$id = $data['id'];
		
		$this->db->where('id', $id);
		 
	if($this->db->delete('language_set'))
	
                  {
	
            echo 1;
                    }
               else{
	
              echo 0;
                    }

}
	
function baners($data)

{  


		$id=$data['id'];
		$this->db->where('id', $id);
		if($this->db->update('blogs',$data)){
		   $this->session->set_flashdata('item', array('message' => 'Record updated successfully','class' => 'success') );
		   $this->session->flashdata('item');

			//redirect to some function
			redirect("admin/add_banner");
		}else{
			$this->session->set_flashdata('item', array('message' => 'Error','class' => 'error') );
			$this->session->flashdata('item');
			redirect("admin/add_banner");
		}	
}	
	
	
	function page_insert($data){
	
        
		
	if($this->db->insert('static_pages',$data))
{
	echo 0;
	}else{
		echo 1;
	}
		
	}
	function deletepages($data){
	
	
		$id = $data['id'];
		
		$this->db->where('id', $id);
		 
	if($this->db->delete('static_pages'))
	
                  {
	
            echo 1;
                    }
               else{
	
              echo 0;
                    }

}
	
	function pages_updates($data){
	    
		$id = $data['id'];
		
		$this->db->where('id', $id);
	if($this->db->update('static_pages',$data))
	
{
	
echo 1;
}
else{
	
echo 0;
}

}
function driver_assign_auto($data){
	$query1 = $this->db->query("SELECT driver_details.* FROM driver_details where NOT EXISTS(select * from bookingdetails where driver_details.id=bookingdetails.assigned_for and bookingdetails.status='Processing') group by driver_details.id ");
	$count = $query1->result_array();
	if(count($count)!=0){
		$datas['assigned_for'] =$count[0]['id'];
		$datas['username']= $this->session->userdata('username');
		$datas['uneaque_id']=$data['c'];
		$datas['status']='Processing';
		$result = $this->pointupdate( $datas);
		
	}
}
function settings_details(){
	$select_data = "*"; 
		$where_data = array(	// ----------------Array for check data exist ot not
			'id'     => 1
	    );
			
		$table = "settings";  //------------ Select table
		$result = $this->get_table_where( $select_data, $where_data, $table );
		return $result;
}
function get_table_where( $select_data, $where_data, $table){
        
		$this->db->select($select_data);
		$this->db->where($where_data);
		
		$query  = $this->db->get($table); 
       		//--- Table name = User
		$result = $query->row(); 
		
		return $result;	
   }
   function driver_approvel($data){
	   
		$id = $data['id'];
		
		$datas = array(
                'user_status'   => ''
               
            );
		$this->db->where('id', $id);
	if($this->db->update('driver_details',$datas))
	
{
	
echo 1;
}
else{
	
echo 0;
}

}
function delete_callback($data){
	
	
		$id = $data['id'];
		
		$this->db->where('id', $id);
		 
	if($this->db->delete('callback'))
	
                  {
	
            echo 1;
                    }
               else{
	
              echo 0;
                    }

}function get_driver_rating($id,$user){
	$select_data = "*"; 
		$where_data = array(	// ----------------Array for check data exist ot not
			'driver_id'     => $id,
			'username'     => $user
	    );
			
		$table = "driver_rating";  //------------ Select table
		$result = $this->get_table_where( $select_data, $where_data, $table );
		return $result;
}function get_average_rating($id){
	$select_data = "driver_id, AVG(rating) as average"; 
		
		$where_data = array(	// ----------------Array for check data exist ot not
			'driver_id'     => $id
		       );
		
		  $table       = "driver_rating"; //------------ Select table
		$result = $this->get_table_where( $select_data, $where_data, $table );
	 $this->update_average_driver($id,$result->average);
	 return true;
}
function update_average_driver($id,$average){
	      $table       = "driver_details";
             
             $update_data = array(
			 'rating'      => $average
		     );
		
		$where_data = array(
			'id'   => $id
			
		  );
		
		$this->update_table_where( $update_data, $where_data, $table);
		return true;
	
}
function rate_driver($data){
	$driver_details =$this->get_driver_details($data['driver_id']);
	$driver_rating =$this->get_driver_rating($data['driver_id'],$data['users']);
	if(count($driver_details)>0){
		if($data['rating']!=''){
		if(count($driver_rating)>0){
		
			  $table       = "driver_rating";
             
             $update_data = array(
			 'rating'      => $data['rating']
		     );
		
		$where_data = array(
			'driver_id'   => $data['driver_id'],
			'username'   => $data['users'],
		  );
		
		$this->update_table_where( $update_data, $where_data, $table);
		
		$driver_rating =$this->get_average_rating($data['driver_id']);
		
			 return true;
	}else{
			$table       = "driver_rating";
               $insert_data = array(
                'rating'      => $data['rating'],
               'username'     => $data['users'],
               'driver_id'    =>$data['driver_id']
                );
			$this->db->insert($table , $insert_data);
			
			$driver_rating =$this->get_average_rating($data['driver_id']);
			 return true;
		}
		}
		
	}
}
function update_table_where( $update_data, $where_data, $table){	
	$this->db->where($where_data);
	$this->db->update($table, $update_data);
         } 	
		 
	public

	function insert_car($data)
		{
		$data = array(
			'car_type' => $this->input->post('car_type')
		);
		$this->db->insert('car_categories', $data);
		}	 
		 public

	function get_car()
		{
		$this->db->select('*');
		$this->db->from('car_categories');
		$query = $this->db->get();
		return $law = $query->result();
		}
		 public

	function get_single_car($id)
		{
		$this->db->select('*');
		$query = $this->db->where('id', $id);
		$query = $this->db->get('car_categories');
		$result = $query->row();
		return $result;
		}
		 
		 public

	function edit_cartype($data, $id)
		{
		$data = array(
			'car_type' => $this->input->post('car_type')
		);
		$this->db->where('id', $id);
		$result = $this->db->update('car_categories', $data);
		return "Success";
		}
        function car_delete($id){
			$this->db->where('id', $id);
			$result = $this->db->delete('car_categories');
			return "success";
		}


/* NAJEELA- Add CAR
########################################################
--------------------------------------------------------*/		 
	function add_car($data){
		$this->db->select('*');
		$query = $this->db->where('car_type', $data['car_type']);
		$query = $this->db->get('car_categories');
		$result = $query->row();
		if($result){
			return "exist";
			}
		else{
			$query = $this->db->insert('car_categories',$data);
			 return $query;
			}
	}	

/* VIEW CAR DETAILS
########################################################
--------------------------------------------------------*/		 
	function getAllCarDetails(){
	     
	    $query = $this->db->get('car_categories');
	    $query = $query->result();

		return $query; 
	}		 

/* GET EDIT CAR DETAILS
########################################################
--------------------------------------------------------*/		 
	function getEditCarDetails($id){
	     
	    $this->db->where('id',$id); 
	    $query = $this->db->get('car_categories');
	    $query = $query->row();

		return $query; 
	}		 

/* UPDATE CAR DETAILS
########################################################
--------------------------------------------------------*/		 
	function update_car_details($data){
	     
	    $value=array(
	    	         'car_type' =>$data['car_type'] ,
	    	         'car_image' =>$data['car_image']
	                );

	    $this->db->where('id',$data['id']); 
	    $query = $this->db->update('car_categories',$value);
	    echo $this->db->last_query();

		return $query; 
	}
	function update_car_details11($data){
	     
	    $value=array(
	    	         'car_type' =>$data['car_type'] ,
	    	         
	                );

	    $this->db->where('id',$data['id']); 
	    $query = $this->db->update('car_categories',$value);

		return $query; 
	}

/* DELETE CAR
########################################################
--------------------------------------------------------*/		
	function deletecar($data){
	
		$id = $data['id'];
		$this->db->where('id', $id);
	    $query=$this->db->delete('car_categories');
	        
	        if($query){
	
                echo 1;
            }else{
	
                echo 0;
            }
    }
    
/* CALCULATE TOTAL AMOUNT
########################################################
--------------------------------------------------------*/  
    function calcTotalAmount($data){
	     
	    $this->db->where('transfertype','Point to Point Transfer');  
	    $this->db->where('cartype',$data['car_type']); 
	    $query = $this->db->get('cabdetails');
	    $query = $query->row();

		return $query;

	}

/* FETCH ASSIGNED DRIVER
########################################################
--------------------------------------------------------*/  
    function getAssignedDriver($data){
	     
	    $car_type = $data['car_type']; 
	    $query = $this->db->query("SELECT driver_details.id,driver_details.name FROM driver_details where NOT EXISTS(select * from bookingdetails where driver_details.id=bookingdetails.assigned_for and bookingdetails.status='Processing') and user_status!='Inactive' and driver_details.car_type='$car_type'")->result();

		return $query;

	}

/* GET AIRPORT VALUES
########################################################
--------------------------------------------------------*/ 
    function getAirportValues($data){
	     
        $this->db->where('name',$data['airport_place']);
        $query = $this->db->get('airport_list');
	    $query = $query->row();
        //$query = $this->db->last_query();
		return $query;

	}


/* ADD ROUND TRIP PACKAGE
########################################################
--------------------------------------------------------*/	
    function roundPackageAdd($data){
		
        $query = $this->db->insert('round_trip_package',$data);
	   
		return $query;
	}

	function getRoundPackage(){
      
        $query = $this->db->get('round_trip_package');
        $query = $query->result();
       
		return $query;
	}

/* EDIT VIEW ROUND - TRIP PACKAGE
########################################################
--------------------------------------------------------*/  
    function edit_view_round_car($id){
		
		$this->db->where('id',$id);
		$query = $this->db->get('round_trip_package');
        $query = $query->row();
       
		return $query;
	} 

/* EDIT ROUND - TRIP PACKAGE
########################################################
--------------------------------------------------------*/

    function round_package_edit($data,$id){
        
        $this->db->where('id',$id);
        $query = $this->db->update('round_trip_package',$data);
       
		return $query;
	}

/* DELETE ROUND TRIP PACKAGE
########################################################
--------------------------------------------------------*/		
	function round_package_delete($data){
	
		$id = $data['id'];
		$this->db->where('id', $id);
	    $query=$this->db->delete('round_trip_package');
	        
	        if($query){
	
                echo 1;
            }else{
	
                echo 0;
            }
    }

/* GET OUTSTATION TAXI DETAILS
########################################################
--------------------------------------------------------*/  
    function getOustationTaxiDetails(){
		
		$this->db->select('round.*,round.package as package_name,cabdetails.id as cab_id,cabdetails.package,cabdetails.cartype,cabdetails.standardrate');
		$this->db->from('cabdetails');
		$this->db->join('round_trip_package as round','round.id = cabdetails.package','left');
		$this->db->where('cabdetails.transfertype','Outstation Transfer');
		$this->db->order_by('cabdetails.id');
        $query = $this->db->get();
       //echo  $query = $this->db->last_query();
        $query = $query->result();
       
		return $query;
	}


/* GET CAR TYPE
########################################################
--------------------------------------------------------*/ 
	function getCarType(){
        
        $this->db->select('round.*,round.package as package_name,cabdetails.id as cab_id,cabdetails.package,cabdetails.cartype,cabdetails.standardrate');
		$this->db->from('cabdetails');
		$this->db->join('round_trip_package as round','round.id = cabdetails.package','left');
		$this->db->where('cabdetails.transfertype','Outstation Transfer');
		$this->db->order_by('cabdetails.id');
        $query = $this->db->get();
       // $query = $this->db->last_query();
        // echo $this->db->last_query();
        $query = $query->result();
       
		return $query;
	}
	/* GET  ALL CAR TYPE
########################################################
--------------------------------------------------------*/ 
	
	function getoutstation(){
		$this->db->select('*');
		$this->db->order_by('id');
        $query = $this->db->get('round_trip_package');
		$query = $query->result();
		return $query;
	}
	
	function getcarall(){
		$this->db->distinct();
		$this->db->select('car_type');
		$this->db->order_by('id');
        $query = $this->db->get('car_categories');
		$query = $query->result();
		//echo $this->db->last_query();
		return $query;
	}
	// function getcarall(){
	// 	$this->db->select('*');
	// 	$this->db->order_by('id');
 //        $query = $this->db->get('cabdetails');
	// 	$query = $query->result();
	// 	return $query;
	// }

/* ADD OUTSTATION PACKAGE
########################################################
--------------------------------------------------------*/ 
	function outstation_add_package($data){

        $data['transfertype'] = "Outstation Transfer";
       
        $this->db->where('cartype',$data['cartype']);
        $this->db->where('transfertype','Outstation Transfer');
        $check_exist_cartype = $this->db->get('cabdetails');

        $this->db->where('package',$data['package']);
        $this->db->where('transfertype','Outstation Transfer');
        $check_exist_package = $this->db->get('cabdetails');
        
        if($check_exist_cartype->num_rows == 0 && $check_exist_package->num_rows == 0){

	        $value = array('cartype' => $data['cartype'],
	        	           'package' => $data['package'],
	        	           'standardrate' => $data['standardrate'],
	        	           'transfertype' => $data['transfertype'],
	                        );
	        $query = $this->db->insert('cabdetails',$value);
       
		    return "success";
		}else{
			return "exist";
		}    

	}		 

}

?>
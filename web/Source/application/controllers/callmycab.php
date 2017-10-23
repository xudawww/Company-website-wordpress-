<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Callmycab extends CI_Controller
{

	public function __construct(){
		parent::__construct();
		$this->load->dbforge();
	 check_installer();
		$this->load->model('Model_cab');
		 header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
			 header("Pragma: no-cache"); // HTTP 1.0.
			 header("Expires: 0"); // Proxies.
		
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
	}

	public function index()
	{

		$s = file_exists(APPPATH.'controllers/installer.php');
		if($s ==1)
	{
		redirect('installer');
	}
	$template['page_title'] = "Home";
	$template['page_name'] = "callmycab_home";
	$airports = get_airports();
	$stations = get_stations();
	$cab_details = get_cab_info();
	$template['air_result'] = json_decode($airports);
	$template['out_result'] = json_decode($stations);
	$template['package_name'] = $this->Model_cab->get_package();
	//print_r($template['airports']);
	
    $this->load->view('template',$template);
  
	}

//edit upload

function check_logged_in(){
	 if($this->session->userdata('username'))
	 {
		 echo 1;
	  }
	 else
	 {
		  echo 0;
	 }
}
public function about()
	{
	$template['page_title'] = "About Us";
	$template['page_name'] = "about";
   $this->load->view('template', $template);

    }
	
	public function change_password()
	{
		 if($this->session->userdata('username'))
	 {
		 $myArray=array();
		 parse_str($_POST['value'],$myArray);
		 $type=$this->session->userdata('type');
		 $username=$this->session->userdata('username');
	     $result =  $this->Model_cab->changepassword($myArray,$type,$username);
         
		if ($result == 1) {
            echo "Success";
        } else if ($result == 0) {
            echo "failed";
        } else if ($result == 2) {
            echo "cpsw";
        } else if ($result == 3) {
            echo "current";
        }exit;
	 }else{
		  redirect('/', 'refresh');
	 }
    

    }
    //*******forgot password start
    public function forgot_password(){
  	$email = $_POST['email'];
  	$status = $this->Model_cab->forgot_password($email);
  	return $status;
  }
    //*******forgot password end
	public function contact_us()
	{
	$template['page_title'] = "Contact Us";
	$template['page_name'] = "contact";
    $this->load->view('template', $template);

    }
	
	public function show_404()
	{


	$template['page_title'] = "Error Page";
	$template['page_name'] = "404";
   	$this->load->view('template', $template);

    }
	public function sort_by_date()
	{
		$data=$_POST;
		 $type=$this->session->userdata('type');
		 $username=$this->session->userdata('username');
	$result=$this->Model_cab->sort_by_date($username,$type,$data);
	print_r($result);
    }
	
	//contact_us_details
	

	
		public function contact_us_details()
	{
		 $myArray=array();
		 parse_str($_POST['value'],$myArray);
		 // var_dump($myArray);exit;
		 

$result=$this->Model_cab->update_contact_us_details($myArray);

if($result=='true'){
           
            $finresult = array( 'status'  => 'success','message' => 'Mail send  Successfully ','code'    => 'registered');
          print json_encode( $finresult );
            }else{
				$finresult = array( 'status'  => 'failed','message' => 'error','code'    => 'registered');
         print json_encode( $finresult );
			}
	}
		//edit upload





	
	public function visits()
	{
		$data=$_POST;
//print_r($data);exit;
//echo $data['value'];exit;
$res=$this->Model_cab->rating($data);
// print_r($res);
echo $res;
	}




	public function check_logged_user()
		{  $user_type=$this->session->userdata('type');
		  if($user_type=='driver')
	 {
		 echo 'driver';
	  }
	  
		}

	
	public function sign_up()
		{  
			$data=$_POST;
			$res=$this->Model_cab->sign_up($data);
			// print_r($res);
			echo $res;
		}

    public function userlogin()
	{
		$data=$_POST;
		$result = $this->Model_cab->login($data);
		echo $result;
	}
	 public function select()
	 {
		 $this->load->view('cmc_selecttaxi');
	 }
		//User logged in, dothe magic
		 public function timepickera()
	{
		//$data=$_POST;
		$this->load->view('pickers');
	}	
	 public function convert()
	{
		//$data=$_POST;
		$this->load->view('convert');
	}		
		 public function timepicker()
	{
		//$data=$_POST;
		$this->load->view('picker');
	}
		 public function timepicker1()
	{
		//$data=$_POST;
		$this->load->view('picker1');
	}
	 public function timepicker2()
	{
		//$data=$_POST;
		$this->load->view('picker2');
	}
	 public function timepicker3()
	{
		//$data=$_POST;
		$this->load->view('picker3');
	}
	 public function timepicker4()
	{
		//$data=$_POST;
		$this->load->view('picker4');
	}
	 public function timepicker5()
	{
		//$data=$_POST;
		$this->load->view('picker5');
	}
	 public function paypal_select()
	{
		//$data=$_POST;
		$this->load->view('select_payment');
	}
	public function book()
	{
		$data=$_POST;
//print_r($data);exit;
//echo $data['value'];exit;
$book=$this->Model_cab->booking($data);
// print_r($res);
echo $book;
	}
	
	
	
		public function book_hourly()
	{
		 $myArray=array();
		 parse_str($_POST['value'],$myArray);
		 unset($myArray['pickuptime_']);
		 $username = $this->session->userdata('username');
		 $book=$this->Model_cab->book_hourly($myArray,$username);
		 echo $book;
	}
	
		public function book_point()
	{
		 $myArray=array();
		 parse_str($_POST['value'],$myArray);
		 unset($myArray['pickuptime_']);
		 $username = $this->session->userdata('username');
		 $book=$this->Model_cab->booking_point($myArray,$username);
		 echo $book;
	}
	
	public function logout()
	{   
		delete_cookie('username');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('type');
        redirect('/', 'refresh');
	}
	
	
	public function account($offset=0)
	{
			 if($this->session->userdata('username'))
	 {
		 
	$template['page_title'] = "Myaccount";
	$template['page_name'] = "myaccount";
		
	 $config['base_url'] = base_url()."callmycab/account";
     $config["total_rows"] = $this->Model_cab->record_count();

    $config['per_page'] = 4;
    $config["uri_segment"] = 3;
	$type=$this->session->userdata('type');
    $username=$this->session->userdata('username');
	 
	$template["details"] = $this->Model_cab->fetch_details($username,$type);
	$template["book_tab"] = $this->Model_cab->booking_tab($username,$type);
	$template["active_tab"] = $this->Model_cab->active_tab($username,$type);
	$template["cartypess"] = $this->Model_cab->cartypess();
	$template["selected_cartype"] = $this->Model_cab->selected_cartype($username);
	$this->pagination->initialize($config);
	$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $template["results"] = $this->Model_cab->fetch_countries($config["per_page"], $page);

        $template["links"] = $this->pagination->create_links();

 

        $this->load->view('template', $template);

    }else{
		 redirect('/', 'refresh');
	}
	}
  
			public function sort_date()
	{		
			$type=$this->session->userdata('type');
			$username=$this->session->userdata('username');
		$dates=$_POST['dates'];
		$tab_id=$_POST['tab_id'];
		 if($tab_id=='active1'){
		 $book_tab = $this->Model_cab->booking_tab_sort($username,$type,$dates);
		print json_encode($book_tab);
		 }
		 else if($tab_id=='past1'){
		$active_tab= $this->Model_cab->active_tab_sort($username,$type,$dates); 
		print json_encode($active_tab);
		}
	}
	public function contact()
	{
		$data=$_POST;
//print_r($data);exit;
//echo $data['value'];exit;
	$contact=$this->Model_cab->contacted($data);
// print_r($res);
		echo $contact;
	}
		
		 public function search()
	{
		//$data=$_POST;
		
		
		$data=$_POST;
//print_r($data);exit;
//echo $data['value'];exit;
$limit="";
$start="";

$cancel=$this->Model_cab->fetch_countries1($limit,$start,$data);

// print_r($res);
echo $cancel;
		
		
		
	}
	 public function search1($offset=0)
	{
		
		 $data=$_POST;
	if($data){
		   $this->session->set_userdata('status_date',json_encode($data));
	}
$config['base_url'] = base_url()."callmycab/search1";
$config["total_rows"] = $this->Model_cab->record_count1();
$config['per_page'] = 4;
$config["uri_segment"] = 3;
$choice = $config["total_rows"] / $config["per_page"];
$config["num_links"] = round($choice);
 

$this->pagination->initialize($config);
 
  $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["results"] = $this->Model_cab->

            fetch_countries1($config["per_page"], $page);

        $data["links"] = $this->pagination->create_links();

 
			 
			  $this->load->view('search',$data);
			   
		
	}
	
	
	
		 public function edit_booking()
	{
		//$data=$_POST;
		
		$this->load->view('edit_book');
		
	}
	
	public function update_booking()
	{
		$data=$_POST;
//print_r($data);exit;
//echo $data['value'];exit;
$cancel=$this->Model_cab->update_book($data);
// print_r($res);
echo $cancel;
	}
	
	
	
	public function cancel()
	{
		$data=$_POST;
//print_r($data);exit;
//echo $data['value'];exit;
$book1=$this->Model_cab->update_status($data);
// print_r($res);
echo $book1;
	}
	public function changepassword()
	{
		$data=$_POST;
//print_r($data);exit;
//echo $data['value'];exit;
$password=$this->Model_cab->update_change($data);
// print_r($res);
echo $password;
	}
		public function call_back_func()
	{
		$data=$_POST['callbck'];
//print_r($data);exit;
//echo $data['value'];exit;
$password=$this->Model_cab->call_back_func($data);
// print_r($res);
echo $password;
	}
	
	public function details()
	{
			
   $this->load->view('details');
	}
public function promo()
    {
        $data=$_POST;
        $res = $this->Model_cab->promocode($data);
        echo $res;
    }
	public function address()
    {
        $data=$_POST;
//print_r($data);exit;
//echo $data['value'];exit;
$add=$this->Model_cab->update_address($data);
// print_r($res);
echo $add;
    }
    public function pagination()
	{
			
   $this->load->view('pagination');
	}
	public function otp_verify()
	{
		$data=$_POST;
//print_r($data);exit;
//echo $data['value'];exit;
$otp=$this->Model_cab->update_otp($data);
// print_r($res);
echo $otp;
	}
	public function resend_otp()
	{
		$data=$_POST;
//print_r($data);exit;
//echo $data['value'];exit;
$otp=$this->Model_cab->update_resend_otp($data);
// print_r($res);
echo $otp;
	}
	 
function query(){
	$data=$_POST;
	if($data){
		   $this->session->set_userdata('status_date',json_encode($data));
	}
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
 
$result = $this->db->get('bookingdetails');
       

    $items_per_page =4;
    $this->load->library('pagination');
    $config['base_url'] =base_url()."callmycab/account";
    $config['total_rows'] = $result->num_rows;
    $config['per_page'] = $items_per_page;
    $this->pagination->initialize($config);

    $current_page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    $offset = $items_per_page * ($current_page - 1);
$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
  
 if($date){
 $this->db->where('pickup_date', $date);
 }
 $this->db->where('username', $username);
 
 $this->db->where('status', $status); 
 $this->db->limit($page, $items_per_page);

 $query2 = $this->db->get('bookingdetails');
   

    echo "<table border='1'>
    <tr>
    <th>date</th>";
    

    

   foreach($query2->result() as $row1){
   
        echo "<tr>";
        echo "<td>";echo $row1->pickup_area;echo "</td>";
       

        echo "</tr>";
   }
echo "<tr><td>" . $this->pagination->create_links() . "</td></tr>";
    echo "</table>";
}
public function reset_email()
	{
		$data=$_POST;
//print_r($data);exit;
//echo $data['value'];exit;
$otp=$this->Model_cab->update_reset_pass($data);
// print_r($res);
echo $otp;
	}
		// public function about()
	//{
		//$data=$_POST;
		//$this->load->view('about-us');
	//}
	 public function page_index($page = null)
	{
		$data = array();
		
		 $data['num']  = $this->db->query("SELECT * FROM  static_pages WHERE page_name='$page'")->num_rows();	
		$data['new']  = $this->db->query("SELECT * FROM  static_pages WHERE page_name='$page'")->row();	 
		  if($data['num']>0){
		  $this->load->view('about-us',$data);	
		  }else{
           redirect('callmycab/404');
		  }		  
	}
	
		 public function search_s()
	{
		$data=$_POST;
		$type =$this->session->userdata('type');
		if($type=="user"){
			$this->load->view('search1');
		}else{
			$this->load->view('driver');
		}
		
	}
	 public function paypal()
	{
	$data=$_POST;		
   $this->load->view('paypal');
	}
	public function result_paypal()
	{
		if($this->session->userdata('username')){
        
       
	$data=$_POST;
	
   $this->load->view('result_paypal');
		}else{
		redirect(base_url());
		}
	}
	public function addpaypal()
	{
		$data=$_POST;
//print_r($data);exit;
//echo $data['value'];exit;
$paypal=$this->Model_cab->update_paypal($data);
// print_r($res);
echo $paypal;
	}
	public function cancel_paypal()
	{
		if($this->session->userdata('username')){
	$data=$_POST;		
   $this->load->view('cancel_paypal');
		}else{
   redirect(base_url());
		}
	}
	public function update_itemstatus()
	{
		$data=$_POST;

$paypal=$this->Model_cab->update_itemstatus($data);

echo $paypal;
	}
/*	public function contact_us_details()
	{
		$data=$_POST;

$result=$this->Model_cab->update_contact_us_details($data);

if($result=='true'){
           
            $finresult = array( 'status'  => 'success','message' => 'Mail send  Successfully ','code'    => 'registered');
          print json_encode( $finresult );
            }else{
				$finresult = array( 'status'  => 'failed','message' => 'error','code'    => 'registered');
         print json_encode( $finresult );
			}
	}
	*/
	
public function first_show(){
	unlink(APPPATH.'controllers/installer.php');
	redirect(base_url());
}	
	
	public function select_driver()
	{
		$data=$_POST;

$paypal=$this->Model_cab->update_itemstatus($data);

echo $paypal;
	}
	
//You can edit here//	

public function fetch_air_car(){
	$data=$_POST;
	$fetch_cars=$this->Model_cab->fetch_air_car($data);
	print json_encode($fetch_cars);
}

public function fetch_out_car(){
	$data=$_POST;
	$fetch_cars=$this->Model_cab->fetch_out_car($data);
	print json_encode($fetch_cars);
}

public function fetch_position(){
	$data=$_POST;
	$fetch_cars=$this->Model_cab->fetch_position($data);
	print json_encode($fetch_cars);
}

public function fetch_distance(){
	$data=$_POST;
	$fetch_distance =$this->Model_cab->fetch_distance($data);
	print json_encode($fetch_distance);
}

public function airport_book(){

	$data = $_POST;
	
	$book_id = $this->Model_cab->airport_book($data);
	echo $book_id;
}

public function outstation_book(){
	$data = $_POST;
	$book_id = $this->Model_cab->outstation_book($data);
	echo $book_id;
}


	
		 public function fetch_car()
	{ 		$data=$_POST;
		  $fetch_cars=$this->Model_cab->fetch_car($data);
		  
		  $fetch_car_rate=$this->Model_cab->fetch_distance($data);
		 foreach($fetch_cars as $key => $fetchcar)
		 {
			  
		 
		  if($fetch_car_rate['distance'] > $fetchcar['intialkm'])
		  {
			$val=$fetch_car_rate['distance'] -$fetchcar['intialkm'];
			$fetch_cars[$key]['total_rate']=$val*$fetchcar['standardrate'];
			$fetch_cars[$key]['total_dist']=$fetch_car_rate['distance'];
		 }
		 else {
			 
		   $fetch_cars[$key]['total_rate']=$fetchcar['standardrate'];
		   $fetch_cars[$key]['total_dist']=$fetch_car_rate['distance'];
		  // $fetch_cars[$key]['total_rate']='120';
		   // $fetch_cars[$key]['total_dist']='12';
		 }
		 }
		 //$datas['fetch_car']=$fetch_cars;
			print json_encode($fetch_cars);
		
		 //$test=$this->load->view('point_car',$datas,true);
			 
	}
		
		public function fetch_car_search()
		{ 		
			$data=$_POST;
			$fetch_cars=$this->Model_cab->fetch_car_search($data);
			print json_encode($fetch_cars);
		}

		public function get_location(){
			$data = $_POST;
			$results = $this->db->where('id',$data['package'])->get('round_trip_package')->row();
			$location = explode(',', $results->pick_point);
			print json_encode($location);
		}

		public function fare_details(){
			$data = $_POST;
			
			$settings = getsettingsdetails();
			$point = $this->Model_cab->fetch_point_cab($data);

			$airport = $this->Model_cab->fetch_airport_cab($data);
			$hourly = $this->Model_cab->fetch_hour_cab($data);
			
			$station = $this->Model_cab->fetch_station_cab($data);

			$result = array('point'=>$point,'airport'=>$airport,'hourly'=>$hourly,'station'=>$station);



			print json_encode($result);


		}

               public function success(){

		$template['page_title'] = "Success";
		$template['page_name'] = "success_page";
		
	         $this->load->view('template',$template);
  
	        }

	        public function promo_verify(){
	        	$data = $_POST;
	        	//$this->Model_cab->promo_verify($data);
	        	$code = $data['code'];
	        	$date = date('Y-m-d H:i:s');
	        	$query = $this->db->query("SELECT * FROM promocode WHERE promocode='$code' AND status=1 AND startdate <= '$date' AND enddate >= '$date'");

	        	echo $query->num_rows();
	        }
	

	
 
} 




	


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{

public function __construct()
{
parent::__construct();
$this->load->helper(array('form', 'url'));
$this->load->helper('date');
$this->load->helper('file');
$this->load->library('form_validation');
$this->load->model('Model_admin','home');
$this->load->database();
$this->load->library('session');
$this->load->library('image_lib');
$this->load->helper('cookie');
$this->load->helper('url');
$this->load->library('email');
session_start();
}
	public function index()
	{
			
   $this->load->view('admin-login');
	}
	
	
	  public function adminlogin()
	{
		$data=$_POST;
		$result = $this->home->login($data);
		echo $result;
	}
	 
	 public function userlist()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		 $this->load->view('admin-dashboard');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function logout()
	{
		$this->session->unset_userdata('username-admin');
			 //redirect('/', 'refresh');
		delete_cookie('username-admin');
		 redirect('/admin', 'refresh');
	}
	public function delete()
	{
		$data=$_POST;
             //print_r($data);exit;
              //echo $data['value'];exit;
       $user=$this->home->deleteuser($data);
               // print_r($res);
       echo $user;
	}
	public function adduser()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		 $this->load->view('admin-add-userdetails');
		 }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function insertuser()
	{
		$data=$_POST;
   //echo $data['value'];exit;
   $data['password'] = md5($this->input->post('password'));	
   $res=$this->home->userinsert($data);
    // print_r($res);
    echo $res;
	}
	
	 public function pointview()
	{   
	   if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
		$permission=$this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		 $this->load->view('admin-point');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	 public function airportview()
	{   
	    if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission=$this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		 $this->load->view('admin-airport');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	 public function hourlyview()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission=$this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		 $this->load->view('admin-hourly');
		 }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	 public function outstationview()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission=$this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		 $this->load->view('admin-outstation');
		 }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function bookingdelete()
	{
		$data=$_POST;
             //print_r($data);exit;
              //echo $data['value'];exit;
       $user=$this->home->deletebook($data);
               // print_r($res);
       echo $user;
	}
	 public function edit_user()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission=$this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('admin-edit-userdetails');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function updateuser()
	{
		$data=$_POST;
       $data['password'] = md5($this->input->post('password'));	
        $user=$this->home->edituser($data);
       
           echo $user;
	}
	 public function edit_point()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission=$this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('edit-point');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function update_point()
	{
		$data=$_POST;
       //print_r($data);exit;
           //echo $data['value'];exit;
        $point=$this->home->pointupdate($data);
       // print_r($res);
           echo $point;
	}
	 public function edit_airport()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission=$this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('edit-airport');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	 public function edit_hourly()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('edit-hourly');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	 public function edit_outstation()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('edit-outstation');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	 public function promocode()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('add-promocode');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function insert_promocode()
	{
		$data=$_POST;
   //echo $data['value'];exit;
   $prom=$this->home->pormoadd($data);
    // print_r($res);
    echo $prom;
	}
	public function view_promocode()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('view-promocode');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function promo_delete()
	{
		$data=$_POST;
             //print_r($data);exit;
              //echo $data['value'];exit;
       $delete=$this->home->deleteprom($data);
               // print_r($res);
       echo $delete;
	}
	public function edit_promocode()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('edit-promocode');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function update_promocode()
	{
		$data=$_POST;
       //print_r($data);exit;
           //echo $data['value'];exit;
        $pt=$this->home->promoupdate($data);
       // print_r($res);
           echo $pt;
	}
	 public function taxi_details()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('add-taxi-details');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function insert_taxi()
	{
		$data=$_POST;
   //echo $data['value'];exit;
   $taxi=$this->home->taxiadd($data);
    // print_r($res);
    echo $taxi;
	}
	 public function taxi_view()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('view-cab-details');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function edit_taxi()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('edit-cab-details');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	
	
	public function update_taxi()
	{
		$data=$_POST;
       //print_r($data);exit;
           // echo $data['value'];exit;
        $taxi=$this->home->updatetaxi($data);
       // print_r($res);
           echo $taxi;
	}
	public function delete_taxi()
	{
		$data=$_POST;
             //print_r($data);exit;
              //echo $data['value'];exit;
       $user=$this->home->delcabdetails($data);
               // print_r($res);
       echo $user;
	}
	public function change_password()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
		
		$this->load->view('change-password');
		}else{
			redirect('admin/index');
		}
		
	}
	public function check_password()
	{
		$data=$_POST;
       //print_r($data);exit;
           //echo $data['value'];exit;
        $pass=$this->home->updatepass($data);
       // print_r($res);
           echo $pass;
	}
	 public function taxi_airport()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('view-cab-airport');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	 public function taxi_details_air()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('add-taxi-air');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	 public function edit_airport_taxi()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('edit-taxi-air');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	 public function taxi_hourly()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('view-cab-hourly');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	 public function taxi_details_hourly()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('add-taxi-hourly');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	 public function edit_hourly_taxi()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('edit-taxi-hourly');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	 public function  taxi_details_outstation()
	{   

		
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$template['package'] = $this->home->getoutstation();
		$template['allcar'] = $this->home->getcarall();

		$template['fetch_car'] = $this->home->getCarType();	
		
		//var_dump($template['package']);exit;
		$this->load->view('add_round_trip_package',$template);
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function taxi_outstation(){
		
		$template['taxi_data'] = $this->home->getOustationTaxiDetails();
		//var_dump($template['taxi_data']);exit;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('view-cab-outstation',$template);
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	  public function edit_outstation_taxi()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('edit-taxi-outstation');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	  public function add_driver()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('add-driver-details');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	
	public function insert_driver()
	{
		$data=$_POST;
   //echo $data['value'];exit;
   $taxi=$this->home->driveradd($data);
    // print_r($res);
    echo $taxi;
	}
	  public function view_driver()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('view-driver-details');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	  public function edit_driver()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
			
		$this->load->view('edit-driver');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function update_driver()
	{
		$data=$_POST;
       //print_r($data);exit;
           //echo $data['value'];exit;
        $taxi=$this->home->updatedriver($data);
       // print_r($res);
           echo $taxi;
	}
	public function delete_driver()
	{
		$data=$_POST;
             //print_r($data);exit;
              //echo $data['value'];exit;
       $user=$this->home->deletedriver($data);
               // print_r($res);
       echo $user;
	}
	  public function add_settings()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
			
		$this->load->view('add-settings',array('error'=>''));
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	
	
	public function upload()
	{
		$data=$_POST;
		
		
		
		if($_FILES['logo']['name']){
		
		$config = $this->set_upload_options();
		//load the upload library
		$this->load->library('upload');
   
        $this->upload->initialize($config);
    
 $imgInfo = getimagesize($_FILES["logo"]["tmp_name"]);
 
		
	 $extension = image_type_to_extension($imgInfo[2]);
if ($extension != '.png' ){
   $this->session->set_flashdata('item', array('message' => 'select only png image types','class' => 'error') );
		
			$d = $this->session->flashdata('item');

			redirect('admin/add_settings');
} else{
	if ( !$this->upload->do_upload('logo'))
		{
			
			$this->session->set_flashdata('item', array('message' => $this->upload->display_errors('logo') ,'class' => 'error') );
			
			$d = $this->session->flashdata('item');

			redirect('admin/add_settings');

		}
		else{
			$data2 = array('upload_data' => $this->upload->data('logo'));
			
			 $data['logo']=$config['upload_path']."/logo.png";
			
		}
}
}if($_FILES['favicon']['name']){
			$config = $this->set_upload_favicon();
		//load the upload library
		$this->load->library('upload');
    
            $this->upload->initialize($config);
	
			if ( !$this->upload->do_upload('favicon'))
		{
			
			$this->session->set_flashdata('item', array('message' => $this->upload->display_errors('favicon'),'class' => 'error') );
			
			$d = $this->session->flashdata('item');

			redirect('admin/add_settings');
		}
			else{
		 $this->upload->overwrite = true;
			$data1 = array('upload_datas' => $this->upload->data('favicon'));

         $data['favicon']=$config['upload_path']."/".$data1['upload_datas']['file_name'];
           	}
		}
		if(!$this->session->flashdata('item')){
			
			
			
		$taxi=$this->home->settings($data);
		}else{
			
			$d=$this->session->flashdata('item');
			redirect('admin/add_settings');
		}
		}
 public function set_upload_options()
	{
		$config['file_name']='logo';
		$config['upload_path'] = 'upload';
        $config['allowed_types'] = 'png';
	   
		$config['maintain_ratio'] = TRUE;
	   
		$config['overwrite'] = 'TRUE';
		return $config;
	}	
public function set_upload_favicon()
	{
		$config['file_name']='favicon';
		$config['upload_path'] = 'upload';
        $config['allowed_types'] = '*';
	   
		$config['maintain_ratio'] = TRUE;
	    
		$config['overwrite'] = 'TRUE';
		return $config;
	}	
	  public function dashboard()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
			
		$this->load->view('dashbord');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	 
	public function insert_role()
	{
		$data=$_POST;
   //echo $data['value'];exit;
        $role=$this->home->roleadd($data);
    // print_r($res);
    echo $role;
	}
	 
	public function role_delete()
	{
		$data=$_POST;
             //print_r($data);exit;
              //echo $data['value'];exit;
       $delete=$this->home->deleterole($data);
               // print_r($res);
       echo $delete;
	}
	 
	public function update_role()
	{
		$data=$_POST;
       //print_r($data);exit;
           //echo $data['value'];exit;
        $role=$this->home->updaterole($data);
       // print_r($res);
           echo $role;
	}
	public function add_role()
	{
		$data=$_POST;
       // print_r($data);exit;
           //echo $data['value'];exit;
        $role=$this->home->addrole($data);
       // print_r($res);
           echo $role;
	}
	public function not_admin()
	{
	
	 $this->load->view('admin-404');
	}
	public function role_management()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('role-management');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	        redirect('admin/index');
         }
	}
	
	public function permission()
	{
		//$data=$_POST;
		$permission="";
		
		if(($this->session->userdata('permission'))) {
     $ff = $this->router->fetch_method();
	 
	 $pm = $this->db->query("SELECT * FROM  pages WHERE pages='$ff'");
	 
    if($pm->num_rows == 1) {
     $upm = $pm->row('p_id'); 
	 $id=explode(',',$this->session->userdata('permission'));
	 if(in_array($upm,$id)) {
            $permission = "access";
        } else {
            $permission = "failed";
            redirect('admin/not_admin');
        }
    } else {
        $permission = "failed";
    }
	 }
	 return $permission;
    }
	
	public function backened_user()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
			
   $this->load->view('backend-user-lists');
		
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function delete_backend()
	{
		$data=$_POST;
             //print_r($data);exit;
              //echo $data['value'];exit;
       $user=$this->home->delete_backend_user($data);
               // print_r($res);
       echo $user;
	}
	 public function edit_bakend_user()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
		$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('backend-edit-userdetails');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	
 public function add_backend_user()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		 $this->load->view('backend-add-userdetails');
		 }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}	
	public function insert_backend_user()
	{
		$data=$_POST;
   //echo $data['value'];exit;
   $res=$this->home->user_backend_insert($data);
     // print_r($res);
    echo $res;
	}
		public function update_backend_user()
	{
		$data=$_POST;
       //print_r($data);exit;
           //echo $data['value'];exit;
        $user=$this->home->edit_backend_user($data);
       // print_r($res);
           echo $user;
	}
	 public function view_airmanage()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		 $this->load->view('airport-details');
		 }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	 public function view_package()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		 $this->load->view('package-details');
		 }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	 public function edit_air_manage()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
		$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('edit-air-manage');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}	
	public function edit_package()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
		$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('edit-package');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}	
	public function delete_air_manage()
	{
		$data=$_POST;
             //print_r($data);exit;
              //echo $data['value'];exit;
       $user=$this->home->delete_air($data);
               // print_r($res);
       echo $user;
	}
	public function delete_package()
	{
		$data=$_POST;
             //print_r($data);exit;
              //echo $data['value'];exit;
       $user=$this->home->delete_package($data);
               // print_r($res);
       echo $user;
	}
	public function add_airmanage()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		 $this->load->view('add-airmanage');
		 }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}	
	public function add_package()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		 $this->load->view('add-package');
		 }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}	
	
	public function update_airmanage()
	{
		$data=$_POST;
       //print_r($data);exit;
           //echo $data['value'];exit;
        $pt=$this->home->airmanage_update($data);
       // print_r($res);
           echo $pt;
	}
	public function update_package()
	{
		$data=$_POST;
       //print_r($data);exit;
           //echo $data['value'];exit;
        $pt=$this->home->package_update($data);
       // print_r($res);
           echo $pt;
	}
	public function places_add()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
			
   $this->load->view('add-places');
   }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function insert_places()
	{
		$data=$_POST;
   //echo $data['value'];exit;
   $res=$this->home->places_insert($data);
    // print_r($res);
    echo $res;
	}
	public function view_places()
	{
	if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
				
   $this->load->view('view-places');
   }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function delete_places()
	{
		$data=$_POST;
             //print_r($data);exit;
              //echo $data['value'];exit;
       $user=$this->home->deleteplaces($data);
               // print_r($res);
       echo $user;
	}
	public function update_places()
	{
		$data=$_POST;
       //print_r($data);exit;
           //echo $data['value'];exit;
        $role=$this->home->updateplace($data);
       // print_r($res);
           echo $role;
	}
	public function edit_places()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
					
   $this->load->view('edit-places');
   }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function auto_places()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
				
			
   $this->load->view('auto-places');
   }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function insert_airmanag()
	{
		$data=$_POST;
       //print_r($data);exit;
           //echo $data['value'];exit;
        $role=$this->home->insertairport($data);
       // print_r($res);
           echo $role;
	}
	public function insert_package()
	{
		$data=$_POST;
       //print_r($data);exit;
           //echo $data['value'];exit;
        $role=$this->home->insertpackage($data);
       // print_r($res);
           echo $role;
	}
public function searchs_p()
	{
		
   $this->load->view('spoint');
   
	}
	public function bookingstatus()
	{
		$data=$_POST;
       //print_r($data);exit;
           //echo $data['value'];exit;
        $status=$this->home->status_update($data);
       
           echo $status;
		  
	}
	public function pointdriver()
	{
	if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
				
				
   $this->load->view('admin-point-driver');
   }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function airportdriver()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
				
			
		
   $this->load->view('admin-airport-driver');
   }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function hourlydriver()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
				
			
		
   $this->load->view('admin-hourly-driver');
   }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function outdriver()
	{
		
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
				
			
   $this->load->view('admin-out-driver');
   }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function addpoint()
	{
		
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
				
			
   $this->load->view('admin-add-point');
   }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function admin_book()
	{
		$data=$_POST;
		
       
        $status=$this->home->book_admin($data);
      
           echo $status;
	}
	public function upload1()
	{
		$data=$_POST;
		 $delete=$this->home->insta($data);
	}
	public function addair()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
				
			
		
   $this->load->view('admin-add-air');
   }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	
	
	public function addhourly()
	{
		
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
				
			
   $this->load->view('admin-add-hourly');
   }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	public function addout()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
				
			
		
   $this->load->view('admin-add-out');
   }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	
	public function view_page()
	{
		
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
				
			
   $this->load->view('admin-view-static');
   }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	
	
	
	
	public function view_language()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('view-language');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	
	public function edit_language()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('edit-language');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	
	
	
	public function update_language_set()
	{
		$data=$_POST;
       //print_r($data);exit;
           //echo $data['value'];exit;
        $pt=$this->home->languagesetupdate($data);
       // print_r($res);
           echo $pt;
	}
	
	public function add_language()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		 $this->load->view('add-language');
		 }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	
	public function insert_language()
	{
		$data=$_POST;
    
        $role=$this->home->insertlanguage($data);
 
          echo $role;
	}
	public function upload_blog()
	{
		$data=$_POST;
    
        $role=$this->home->blog_upload($data);
 
          echo $role;
	}
	
	
	public function add_select_language()
	{
		//$data=$_POST;
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		$this->load->view('add-select-language');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
	
	public function insert_addnew_languages()
	{
		$data=$_POST;
   //echo $data['value'];exit;
   $taxi=$this->home->languagesadd($data);
    // print_r($res);
    echo $taxi;
	}
	
	public function languages_delete()
	{
		$data=$_POST;
            
       $user=$this->home->delete_langauge($data);
              
       echo $user;
	}
	public function add_page()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
				
			
		
   $this->load->view('admin-add-static');
   }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
   
	}
	public function add_banner()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
				
			
		
   $this->load->view('admin-add-banner');
   }else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
   
	}
	
	public function set_upload_baner()
	{
		$config['file_name']='banner-inner';
		$config['upload_path'] = 'assets/images/images';
        $config['allowed_types'] = 'png';
	   
		$config['maintain_ratio'] = TRUE;
	   
		$config['overwrite'] = 'TRUE';
		return $config;
	}	
	public function set_upload_car()
	{
		$config['file_name']='car';
		$config['upload_path'] = 'assets/images/images';
        $config['allowed_types'] = 'png';
	   
		$config['maintain_ratio'] = TRUE;
	   
		$config['overwrite'] = 'TRUE';
		return $config;
	}	
	public function banner()
	{
		$data=$_POST;
		
		if(isset($_FILES['blog_content']['name'])){
		
		$config = $this->set_upload_baner();
		$this->load->library('upload');
        $this->upload->initialize($config);
    
        $imgInfo = getimagesize($_FILES["blog_content"]["tmp_name"]);
        $extension = image_type_to_extension($imgInfo[2]);
        if ($extension != '.png' ){
           $this->session->set_flashdata('item', array('message' => 'select only png image types','class' => 'error') );
		
			$d = $this->session->flashdata('item');

			redirect('admin/add_banner');
        }
	
        else if (($imgInfo[0] != 361) && ($imgInfo[1] != 403)){
            $this->session->set_flashdata('item', array('message' => 'select images of 361/403 size(baner1)','class' => 'error') );
		
			$d = $this->session->flashdata('item');

			redirect('admin/add_banner');
        }else{
	        if ( !$this->upload->do_upload('blog_content'))
		    {
			
			   $this->session->set_flashdata('item', array('message' => $this->upload->display_errors('blog_content') ,'class' => 'error') );
			
			   $d = $this->session->flashdata('item');

			   redirect('admin/add_banner');

		    }
		    else{
			   $data2 = array('upload_data' => $this->upload->data('blog_content'));
			
			   echo $data['blog_content']=$config['upload_path']."/banner-inner.png";
			
		    }
        }
}  if(isset($_FILES['baner_car']['name'])){
		$config = $this->set_upload_car();
		
		$this->load->library('upload');
    
        $this->upload->initialize($config);
	    $imgInfo = getimagesize($_FILES["baner_car"]["tmp_name"]);
        $extension = image_type_to_extension($imgInfo[2]);
        if ($extension != '.png' ){
           $this->session->set_flashdata('item', array('message' => 'select only png image types','class' => 'error') );
		
			$d = $this->session->flashdata('item');

			redirect('admin/add_banner');
        }
	
        else if (($imgInfo[0] != 466) && ($imgInfo[1] != 264)){
            $this->session->set_flashdata('item', array('message' => 'select images of 466/264 size(banercar)','class' => 'error') );
		
			$d = $this->session->flashdata('item');

			redirect('admin/add_banner');
        }else{
		if ( !$this->upload->do_upload('baner_car'))
		{
			
			$this->session->set_flashdata('item', array('message' => $this->upload->display_errors('favicon'),'class' => 'error') );
			
			$d = $this->session->flashdata('item');

			redirect('admin/add_banner');
		}
		else{
		    $this->upload->overwrite = true;
			$data1 = array('upload_datas' => $this->upload->data('baner_car'));
            echo $data['baner_car']=$config['upload_path']."/car.png";
	
			}
		}
}
		if(!$this->session->flashdata('item')){
		
		$taxi=$this->home->baners($data);
		}else{
			
			$d=$this->session->flashdata('item');
			redirect('admin/add_banner');
		}
}
   public function add_pages()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
				
			
		
		$this->load->view('add-pages');
		}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
   
	}
	 
	public function insert_page()
	{
		$data=$_POST;
    
        $role=$this->home->page_insert($data);
 
          echo $role;
	}
	public function view_pages()
	{
		$this->load->view('view-pages');
	}
	public function delete_pages()
	{
		$data=$_POST;
             //print_r($data);exit;
              //echo $data['value'];exit;
       $user=$this->home->deletepages($data);
               // print_r($res);
       echo $user;
	}
	public function edit_pages()
	{
		$this->load->view('edit-pages');
	}
	public function update_pages()
	{
		$data=$_POST;
             //print_r($data);exit;
              //echo $data['value'];exit;
       $user=$this->home->pages_updates($data);
               // print_r($res);
       echo $user;
	}
	public function wallet_list()
	{
	
   $this->load->view('wallet_lists');
  
	}public function select_driver()
	{
		$data=$_POST;

$paypal=$this->home->driver_assign_auto($data);

echo $paypal;
	}
	public function callback_list()
	{
	
   $this->load->view('callback_lists');
  
	}
	public function approval_driver()
	{
		$data=$_POST;
             //print_r($data);exit;
              //echo $data['value'];exit;
       $user=$this->home->driver_approvel($data);
               // print_r($res);
       echo $user;
	}
	public function callback_delete()
	{
		$data=$_POST;
             //print_r($data);exit;
              //echo $data['value'];exit;
       $user=$this->home->delete_callback($data);
               // print_r($res);
       echo $user;
	}public function rating()
	{
		$data=$_POST;
		 $user=$this->home->rate_driver($data);
		 if($user==true){
			 $this->load->view('rating');
		 }
		
	}


        /* Language change code for mobile apps Edited <<*/

public function languageChageForDriverApp(){
	if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
 	 $permission = $this->permission();
  if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		//$this->load->helper('language_helper');
		$this->db->select('language_name');
		$query = $this->db->get('app_languages');
		$allLanguages = $query->result_array();

		if(isset($allLanguages[0]['language_name'])){
			  $currentlanguage=$allLanguages[0]['language_name'];
		}

		$viewData['allLanguages']=$allLanguages;
		//$viewData['languageMeta']=$languageMeta;

  	$this->load->view('view-appLanguage',$viewData);
  }else{
 	 redirect('admin/not_admin');
  }
  }else{
 		redirect('admin/index');
 			}
}

	public function showStoredLanguage(){
		$request = $this->input->post();
		$currentlanguage= $request['fetchLanguage'];

		$app= $request['app'];
		if($app=='user'){
				$table='user_app_language';
		}else{
				$table='app_languages';
		}

		$this->db->select('language_meta');
		$this->db->where('language_name', $currentlanguage);
		$query = $this->db->get($table);
		$languageMeta = $query->row();
		$languageMeta=json_decode($languageMeta->language_meta, true);
		//var_dump($languageMeta);
		print json_encode($languageMeta);
	}

	public function saveNewLanguage()
	{
		$request = $this->input->post();
		$newLanguage= $request['newLanguage'];
		// $this->load->helper('language_helper');
		// $getArray=getLanguageForDriverApp();
		// $getArray=json_encode($getArray);
		$app= $request['app'];
		if($app=='user'){
				$table='user_app_language';
		}else{
				$table='app_languages';
		}

		$this->db->select("count(*) as count");
		$this->db->where("language_name",$newLanguage);
		$this->db->from($table);
		$count = $this->db->get()->row();
		if($count->count > 0) {
			$this->db->where("language_name",language_name);
			$result = $this->db->update('language_name', $newLanguage);
		}else {
			$ins = array(
										'language_name' => $newLanguage,
										'language_meta' => '',
										'status'  => '0'
									);
		 $result=$this->db->insert($table, $ins);
		}
		if($result){
			echo 1;
		}else{
			echo 0;
		}
	}

public function saveDriverApplang()
{
 ob_start();
		$request = $this->input->post();

		$hidden_lang=$request['hidden_lang'];
		$languageMeta=json_encode($request);



	 $data = array( 'language_meta' => $languageMeta);
	 $this->db->where('language_name', $hidden_lang);
	 $result=$this->db->update('app_languages', $data);
	 redirect(base_url().'admin/languageChageForDriverApp');

}

public function deleteAppLanguage(){
	$request = $this->input->post();
	$id=$request['id'];
	$this->db->where('id', $id);
	$del=$this->db->delete('app_languages');
	if($del){
		echo 1;
	}else {
		echo 0;
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////

public function languageChageForUserApp(){
	if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
	 $permission = $this->permission();
	if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
		//$this->load->helper('language_helper');
		$this->db->select('language_name');
		$query = $this->db->get('user_app_language');
		$allLanguages = $query->result_array();

		if(isset($allLanguages[0]['language_name'])){
				$currentlanguage=$allLanguages[0]['language_name'];
		}

		$viewData['allLanguages']=$allLanguages;
		//$viewData['languageMeta']=$languageMeta;

		$this->load->view('view-userAppLanguage',$viewData);
	}else{
	 redirect('admin/not_admin');
	}
	}else{
		redirect('admin/index');
	}
}

public function saveUserApplang()
{
 ob_start();
		$request = $this->input->post();

		$hidden_lang=$request['hidden_lang'];
		$languageMeta=json_encode($request);
	 $data = array( 'language_meta' => $languageMeta);
	 $this->db->where('language_name', $hidden_lang);
	 $result=$this->db->update('user_app_language', $data);
	 redirect(base_url().'admin/languageChageForUserApp');

}

public function deleteUserAppLanguage(){
	$request = $this->input->post();
	$id=$request['id'];
	$this->db->where('id', $id);
	$del=$this->db->delete('user_app_language');
	if($del){
		echo 1;
	}else {
		echo 0;
	}
}

public function setAppDefaultLanguage(){
	$request = $this->input->post();
	$language=$request['language'];
	$app=$request['app'];
	if($app=='user'){
			$table='user_app_language';
	}else{
			$table='app_languages';
	}

	$data = array( 'status' => '0');
	$this->db->where('status', '1');
	$result=$this->db->update($table, $data);

	if($result){
		$data = array( 'status' => '1');
		$this->db->where('language_name', $language);
		$setLanguage=$this->db->update($table, $data);
	}
	if($setLanguage)	{	echo 1;	}else{	echo 0;	}


}

/* Language change code for mobile apps Edited >>*/

public function view_cartype()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
	
		$template['page'] = "admin-cars";
		$template['page_title'] = "View car category";
		$template['data'] = "View car category";
		if(!empty(($_POST))) {
		if(isset($_POST)) {
			$data = $_POST;
			$this->home->insert_car($data);
			$this->session->set_flashdata('message',array('message' => 'car type added successfully ','class' => 'success'));
			redirect(base_URL().'Welcome/view_practice');
		}
	}
	
	
		$template['law'] =$this->home->get_car();
		$this->load->view('template', $template);
}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	}
public function edit_cardetails()
	{
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
			
		 $template['page'] = 'admin-edit-cars';
		      $template['page_title'] = 'Edit car type';
		$id = $this->uri->segment(3); 
		      $template['data'] = $this->home->get_single_car($id);
		if(!empty($template['data'])) 
		 {
 		   if($_POST)
		    {
			  $data = $_POST;
			 
		
			  $result = $this->home->edit_cartype($data, $id);
			  $this->session->set_flashdata('message',array('message' => 'Edit Car Type Updated successfully','class' => 'success'));
			  redirect(base_url().'admin/cartype');		 
		      }
			  
		
           }
            else
		        {			 
	  $this->session->set_flashdata('message', array('message' => "You don't have permission to access.",'class' => 'danger'));	
       redirect(base_url().'admin/view_cartype');	
	            }	
	 $this->load->view('template',$template); 		 
			
			}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
	 }
	public function delete_cardetails()
		{
			if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
		if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
			 $id = $this->uri->segment(3); 
              
			
			  
		      $result = $this->home->car_delete($id);	
			 
			  if($result=="success")
			  {
				  $this->session->set_flashdata('message', array('message' => 'Deleted Successfully','class' => 'success'));
				  redirect(base_url().'admin/view_cartype');	
			  }
			 else
		      {	 		 
			  $this->session->set_flashdata('message', array('message' => "You don't have permission to access.",'class' => 'danger'));		
              redirect(base_url().'admin/view_cartype');			  
	          }
			//if($this->session->userdata('super_admin') == 1){
			}else{
			redirect('admin/not_admin');
		}
		}else{
	     redirect('admin/index');
         }
			
			
		}

/* NAJEELA- CAR PAGE
########################################################
--------------------------------------------------------*/
    public function car(){
		
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
			if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
				
			    $this->load->view('add_car',array('error'=>''));
			}else{
				redirect('admin/not_admin');
			}
		}else{
	        redirect('admin/index');
        }
	}

/* Add CAR
########################################################
--------------------------------------------------------*/	
	public function add_car() {
		
		
		if($_POST){
			 
			$data=$this->input->post();
		    if(isset($_FILES['car_image'])) {  
			    $config = $this->set_car_upload_options();
			    $path = $_FILES['car_image']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $new_name = time().".".$ext;
                $config['file_name'] = $new_name;
                $this->upload->initialize($config);

				if(!$this->upload->do_upload('car_image')) {
					unset($data['car_image']);
					$this->session->set_flashdata('item',array('message' => 'Please upload only gif, png,jpg images','class' => 'danger'));
					$d = $this->session->flashdata('item');
					 redirect(base_url().'admin/car');	
				}else {
					$upload_data = $this->upload->data();
					$data['car_image'] = base_url().$config['upload_path']."/".$upload_data['file_name'];
				}
			}
			
			
			$result =$this->home->add_car($data);
			if($result==="exist"){
 
			 $this->session->set_flashdata('item', array('message' => 'Car Type Already Exist','class' => 'error') ); 
			 $d =$d= $this->session->flashdata('item');	  
			 	  redirect(base_url().'admin/car');	
			}else {
		 $this->session->set_flashdata('item', array('message' => 'Added Successfully','class' => 'success') );
		
			$d = $this->session->flashdata('item');
	
			}
		redirect(base_url().'admin/view_car');	
		}
		   
	}

//upload an image options
	private function set_car_upload_options() {   
	    
	    $config = array();
	    $config['upload_path'] = 'assets/upload/car';
	    $config['allowed_types'] = 'gif|jpg|png|jpeg';
	    $config['max_size']      = '';
	    $config['overwrite']     = FALSE;
	  
	    return $config;
	}

/* VIEW CAR DETAILS
########################################################
--------------------------------------------------------*/	
    public function view_car(){

		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission = $this->permission();
			if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
			    $template['car_details']=$this->home->getAllCarDetails();
			    $this->load->view('view_car',$template);
			}else{
				redirect('admin/not_admin');
			}
		}else{
	        redirect('admin/index');
        }
	}

/* CAR EDIT VIEW 
########################################################
--------------------------------------------------------*/	
    public function edit_car(){
		
		if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
			$permission=$this->permission();
			
			if(($this->session->userdata('role-admin') == 'admin') || ($permission == "access")) {
			    
			    $id = $this->uri->segment(3);
			    $template['edit_car_details'] = $this->home->getEditCarDetails($id);
			    $this->load->view('car_edit',$template);
			}else{
				redirect('admin/not_admin');
			}
		}else{
	     redirect('admin/index');
        }
	}		

/* EDIT CAR DETAILS
########################################################
--------------------------------------------------------*/	
	public function edit_car_details() {
		

		if($_POST){
			 $data['id'] = $_POST['id'];
			 $data['car_type'] = $_POST['car_type'];


		     if(isset($_FILES['car_image'])) {  
			    $config = $this->set_car_upload_options();
			    $path = $_FILES['car_image']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $new_name = time().".".$ext;
                $config['file_name'] = $new_name;
                $this->upload->initialize($config);
                //image edit 
 				$upload_data = $this->upload->data();
 $data['car_image'] = base_url().$config['upload_path']."/".$upload_data['file_name'];
 if (!$this->upload->do_upload('car_image')){
 	$this->session->set_flashdata('message', array('message' => "Display Picture : ".$this->upload->display_errors(), 'title' => 'Error !', 'class' => 'danger'));
 	$result =$this->home->update_car_details11($data);
 }
 else
				{
					$upload_data = $this->upload->data();
					$data['car_image'] = base_url().$config['upload_path']."/".$upload_data['file_name'];
					$result =$this->home->update_car_details($data);
				}
 

				// if(!$this->upload->do_upload('car_image')) {
				// 	// unset($data['car_image']);
				// 	$this->session->set_flashdata('item',array('message' => 'Please upload only gif, png,jpg images','class' => 'danger'));
				// 	$d = $this->session->flashdata('item');

				// 	 redirect(base_url().'admin/car');	
				// }else {
				// 	$upload_data = $this->upload->data();
				// 	$data['car_image'] = base_url().$config['upload_path']."/".$upload_data['file_name'];
				// }


			}
			
			
			// $result =$this->home->update_car_details($data);
			if($result) {
			   
				$this->session->set_flashdata('message',array('message' => 'Updated Successfully','class' => 'success'));
			}else {
				
				$this->session->set_flashdata('message', array('message' => 'Error Occured','class' => 'danger'));  
			}
		redirect(base_url().'admin/view_car');	
		}
		   
	}


/* DELETE CAR
########################################################
--------------------------------------------------------*/	
	public function car_delete(){
		
		$data=$_POST;
        $res=$this->home->deletecar($data);
        echo $res;
	}

/* CALCULATE POINT TO POINT DISTANCE
########################################################
--------------------------------------------------------*/
    public function getDistance(){

        $data = $_POST;
        $pick_lat = $data['pickup_lat'];
        $pick_lng = $data['pickup_lng'];
        $drop_lat = $data['drop_lat'];
        $drop_lng = $data['drop_lng'];

    	$jsonResults = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$pick_lat,$pick_lng&destinations=$drop_lat,$drop_lng&key=AIzaSyCHc-JbPT5Fn-dGubkSs31cHjpxAc04JOA");
        $json_decode = json_decode($jsonResults);
		$distance = ceil(($json_decode->rows[0]->elements[0]->distance->value)/1000);
		$duration = round(($json_decode->rows[0]->elements[0]->duration->value)/60);
		$results['distance'] = $distance;

		echo $distance;
    }

/* CALCULATE TOTAL AMOUNT and FETCH ASSIGNED DRIVER
########################################################
--------------------------------------------------------*/
    public function calcTotalAmount(){
		
		$data=$_POST;
		$value = array();
        $res=$this->home->calcTotalAmount($data);
        $value['driver']=$this->home->getAssignedDriver($data);
        $total_km = $data['total_km'];
        $initial_km = $res->intialkm;
        $standard_rate = $res->standardrate;
        $initial_rate = $res->intailrate;
        if($total_km > $initial_km){
	        $first_eqn = ($total_km - $initial_km) * $standard_rate;
	        $value['amount'] = $first_eqn + $initial_rate;
        }else{
        	$value['amount'] = $standard_rate;
        }
        print json_encode($value);
	}

/* GET AIRPORT VALUES
########################################################
--------------------------------------------------------*/
    public function getAirportValues(){
		
		$data=$_POST;
        $res=$this->home->getAirportValues($data);
        $value = array('lat' => $res->lat,'lon' => $res->lon );
        print json_encode($value) ;
	}

/* CALCULATE AIRPORT DISTANCE
########################################################
--------------------------------------------------------*/
    public function getAirportDistance(){

        $data = $_POST;
        
	    $drop_lat = $data['drop_lat'];
	    $drop_lng = $data['drop_lng'];
        $pick_lat = $data['arport_lat'];
        $pick_lng = $data['arport_lng'];

    	$jsonResults = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$pick_lat,$pick_lng&destinations=$drop_lat,$drop_lng&key=AIzaSyCHc-JbPT5Fn-dGubkSs31cHjpxAc04JOA");
        $json_decode = json_decode($jsonResults);
		$distance = ceil(($json_decode->rows[0]->elements[0]->distance->value)/1000);
		$duration = round(($json_decode->rows[0]->elements[0]->duration->value)/60);
		
		echo $distance;
    }

/* ADD PACKAGE
########################################################
--------------------------------------------------------*/  
    public function add_round_package(){
		
		$this->load->view('add_package');
	} 

/* ADD ROUND TRIP PACKAGE
########################################################
--------------------------------------------------------*/ 
	public function round_package_add(){

	    $data=$_POST;
	    $res = $this->home->roundPackageAdd($data);
        if($res) {
			   
			$this->session->set_flashdata('message',array('message' => 'Added Successfully','class' => 'success'));
		}else {
				
			$this->session->set_flashdata('message', array('message' => 'Error Occured','class' => 'danger'));  
		}
		redirect(base_url().'admin/view_round_package');
	}  	


/* VIEW ROUND - TRIP PACKAGE
########################################################
--------------------------------------------------------*/  
    public function view_round_package(){
		
		$template['package'] = $this->home->getRoundPackage();
		$this->load->view('view_round_package',$template);
	} 

/* EDIT VIEW ROUND - TRIP PACKAGE
########################################################
--------------------------------------------------------*/  
    public function edit_view_round_car(){
		
		$id = $this->uri->segment(3);
		$template['edit_package'] = $this->home->edit_view_round_car($id);
		$this->load->view('edit_view_round_package',$template);
	}

/* EDIT ROUND - TRIP PACKAGE
########################################################
--------------------------------------------------------*/  
	public function round_package_edit(){
      
        $data=$_POST;
        $id = $this->uri->segment(3);
	    $res = $this->home->round_package_edit($data,$id);
        if($res) {
			   
			$this->session->set_flashdata('message',array('message' => 'Updated Successfully','class' => 'success'));
		}else {
				
			$this->session->set_flashdata('message', array('message' => 'Error Occured','class' => 'danger'));  
		}
		redirect(base_url().'admin/view_round_package');
	} 

/* DELETE ROUND TRIP PACKAGE
########################################################
--------------------------------------------------------*/	
	public function round_package_delete(){
		
		$data=$_POST;
        $res=$this->home->round_package_delete($data);
        echo $res;
	}

/* ADD OUTSTATION PACKAGE
########################################################
--------------------------------------------------------*/	
	public function outstation_add_package(){
		
		$data = $_POST;
        $res = $this->home->outstation_add_package($data);
        if($res=="success") {
			   
			$this->session->set_flashdata('message',array('message' => 'Updated Successfully','class' => 'success'));
		}else {
				
			$this->session->set_flashdata('message', array('message' => 'Already Exist The Car or Package ','class' => 'danger'));  
		}
		redirect(base_url().'admin/taxi_details_outstation');

	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>
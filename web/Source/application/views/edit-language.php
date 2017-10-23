<!DOCTYPE html>
<html>
  <?php
	 include"includes/admin_header.php";
	 ?>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Left side column. contains the logo and sidebar -->
     <?php
	 include"includes/admin_sidebar.php";
	 ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
                        
               <h1 class="edit_promo">
                  Edit Language Details
               </h1>
                        
                      
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">language</a></li>
            <li class="active">Edit</li>
          </ol>
        </section>

        <!-- Main content -->
 <div class="">
			   <div class="">
                <div class="col-lg-6">
           <div class="box box-primary edit_promoform1">
				 
                <div class="box-header with-border">
                  <h3 class="box-title"></h3>
				   <div class="edituser" tabindex='1'></div>
                </div><!-- /.box-header -->
                <!-- form start -->
				  <?php
								 $id = $_GET['idp'];
						  
		 $query = $this->db->query("SELECT * FROM  language_set WHERE  id ='$id'");
		 $row = $query->row('language_set');
		 $textFile = $row->languages;
         $extension = ".php";     
  
		 include 'includes/'.$textFile.$extension;
								?>
               <form role="form"  method="post" id="taxi_reg">
				
                  <div class="box-body">
				             <div class="form-group">
                                           <label>Language Name</label>
                                           <input class="form-control regcom sample" placeholder="Language Name" readonly value="<?php echo $languages; ?>" name="languages"  type="text">
                                        </div>
				                        <div class="form-group">
                                           <label>About Us</label>
                                           <input class="form-control regcom" placeholder="About Us" name="lang_about_us" value="<?php echo $lang_about_us; ?>" type="text">
                                        </div>
										<div class="form-group">
                                           <label>Callback</label>
                                           <input class="form-control regcom" placeholder="Callback" name="lang_callback" value="<?php echo $lang_callback; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Fare Chart</label>
                                           <input class="form-control regcom" placeholder="Fare Chart" name="lang_fare_chart" value="<?php echo $lang_fare_chart; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                           <label>Contact</label>
                                           <input class="form-control regcom" placeholder="Contact" name="lang_contact" value="<?php echo $lang_contact; ?>" type="text"  >
                                        </div>
                                         
										<div class="form-group">
                                           <label>Login/Signup</label>
                                           <input class="form-control regcom" placeholder="Login/Signup" name="lang_login_signp" value="<?php echo $lang_login_signp; ?>" type="text" >
                                        </div>
										
										<div class="form-group">
                                           <label>Logout</label>
                                           <input class="form-control regcom" placeholder="Logout" name="lang_logout" value="<?php echo $lang_logout; ?>" type="text"  >
                                        </div>
										<div class="form-group">
                                            <label>Point to Point</label>
                                           <input class="form-control regcom" placeholder="Point to Point" name="lang_ptp" value="<?php echo $lang_ptp; ?>" type="text" >
                                        </div>
										
										 <div class="form-group">
                                           <label>Airport Transfer</label>
                                           <input class="form-control regcom" placeholder="Airport Transfer" name="lang_airport" value="<?php echo $lang_airport; ?>" type="text" >
                                        </div>
										
									    <div class="form-group">
                                           <label>Hourly Rental</label>
                                           <input class="form-control regcom" placeholder="Hourly Rental" name="lang_hourly" value="<?php echo $lang_hourly; ?>" type="text"  >
                                        </div>
										
										<div class="form-group">
                                           <label>Outstation</label>
                                           <input class="form-control regcom" placeholder="Outstation" name="lang_outstation" value="<?php echo $lang_outstation; ?>"type="text"  >
                                        </div>
										
								
										
										<div class="form-group">
                                           <label>Location</label>
                                           <input class="form-control regcom" placeholder="Location" name="lang_location" value="<?php echo $lang_location; ?>" type="text"  >
                                        </div>
										<div class="form-group">
                                           <label>Select Taxi</label>
                                           <input class="form-control regcom" placeholder="Select Taxi" name="lang_selectaxi" value="<?php echo $lang_selectaxi; ?>" type="text"  >
                                        </div>
										
										<div class="form-group">
                                           <label>Confirm</label>
                                           <input class="form-control regcom" placeholder="Confirm" name="lang_confirm" value="<?php echo $lang_confirm; ?>" type="text"  >
                                        </div>
										
									    <div class="form-group">
                                           <label>Pickup Area</label>
                                           <input class="form-control regcom" placeholder="Pickup Area" name="lang_pickup_area" value="<?php echo $lang_pickup_area; ?>" type="text" >
                                        </div>
										
										<div class="form-group">
                                           <label>Pickup Date</label>
                                           <input class="form-control regcom" placeholder="Pickup Date" name="lang_pickup_date" value="<?php echo $lang_pickup_date; ?>" type="text"  >
                                        </div>
										
								
                                        <div class="form-group">
                                           <label>Drop Area</label>
                                           <input class="form-control regcom" placeholder="Drop Area " name="lang_drop_area" value="<?php echo $lang_drop_area; ?>" type="text">
                                        </div>
										  <div class="form-group">
                                            <label>Pickup Time</label>
                                           <input class="form-control regcom" placeholder="Pickup Time" name="lang_pickup_time" value="<?php echo $lang_pickup_time; ?>" type="text">
                                        </div>
										<div class="form-group">
                                           <label>Find My Taxi</label>
                                           <input class="form-control regcom" placeholder="Find My Taxi" name="lang_find_taxi" value="<?php echo $lang_find_taxi; ?>" type="text" >
                                        </div>
                                        <div class="form-group">
                                           <label>Select Car</label>
                                           <input class="form-control regcom" placeholder="Select Car" name="lang_select_car" value="<?php echo $lang_select_car; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                           <label>Fare</label>
                                           <input class="form-control regcom" placeholder="Fare" name="lang_fare" value="<?php echo $lang_fare; ?>" type="text"  >
                                        </div>	



                     
						

                                        <div class="form-group">
                                           <label>Distance</label>
                                           <input class="form-control regcom" placeholder="Distance" name="lang_distance" value="<?php echo $lang_distance; ?>" type="text" >
                                        </div>
									    <div class="form-group">
                                           <label>Area</label>
                                           <input class="form-control regcom" placeholder="Area" name="lang_area" value="<?php echo $lang_area; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                           <label>Pickup Address</label>
                                           <input class="form-control regcom" placeholder="Pickup Address" name="lang_pickup_address" value="<?php echo $lang_pickup_address; ?>" type="text"  >
                                        </div>
                                        <div class="form-group">
                                           <label>Enter Promo Code(Optional)</label>
                                           <input class="form-control regcom" placeholder="Enter Promo Code(Optional)" name="lang_enter_promo" value="<?php echo $lang_enter_promo; ?>" type="text"  >
                                        </div>
										<div class="form-group">
                                           <label>Apply</label>
                                           <input class="form-control regcom" placeholder="Apply" name="lang_apply" value="<?php echo $lang_apply; ?>" type="text"  >
                                        </div>	

										<div class="form-group">
                                           <label>Code</label>
                                           <input class="form-control regcom" placeholder="Code" name="lang_code" value="<?php echo $lang_code; ?>" type="text" >
                                        </div>
				                        <div class="form-group">
                                           <label>Landmark</label>
                                           <input class="form-control regcom" placeholder="Landmark" name="lang_landmark" value="<?php echo $lang_landmark; ?>" type="text" >
                                        </div>
										  <div class="form-group">
                                            <label>Booking</label>
                                           <input class="form-control regcom" placeholder="Booking" name="lang_booking" value="<?php echo $lang_booking; ?>"type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Save This Address</label>
                                           <input class="form-control regcom" placeholder="Save This Address" name="lang_save_address" value="<?php echo $lang_save_address; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Going to Airport</label>
                                           <input class="form-control regcom" placeholder="Going to Airport" name="lang_going_airport" value="<?php echo $lang_going_airport; ?>" type="text" >
                                        </div>

										
										<div class="form-group">
                                            <label>Coming from Airport</label>
                                           <input class="form-control regcom" placeholder="Coming from Airport" name="lang_coming_airport" value="<?php echo $lang_coming_airport; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Package</label>
                                           <input class="form-control regcom" placeholder="Package" name="lang_package" value="<?php echo $lang_package; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Departure Date</label>
                                           <input class="form-control regcom" placeholder="Departure Date" name="lang_departure_date" value="<?php echo $lang_departure_date; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Return Date</label>
                                           <input class="form-control regcom" placeholder="Return Date" name="lang_return_date" value="<?php echo $lang_return_date; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Total</label>
                                           <input class="form-control regcom" placeholder="Total" name="lang_total" value="<?php echo $lang_total; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Personal Details</label>
                                           <input class="form-control regcom" placeholder="Personal Details" name="lang_personal_details" value="<?php echo $lang_personal_details; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Change Password</label>
                                           <input class="form-control regcom" placeholder="Change Password" name="lang_change_psw" value="<?php echo $lang_change_psw; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>UserName</label>
                                           <input class="form-control regcom" placeholder="UserName" name="lang_username" value="<?php echo $lang_username; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Email</label>
                                           <input class="form-control regcom" placeholder="Email" name="lang_email" value="<?php echo $lang_email; ?>" type="text" >
                                        </div> <div class="form-group">
                                            <label>Phone</label>
                                           <input class="form-control regcom" placeholder="Phone" name="lang_phone" value="<?php echo $lang_phone; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Gender</label>
                                           <input class="form-control regcom" placeholder="Gender" name="lang_gender" value="<?php echo $lang_gender; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Wallet Balance</label>
                                           <input class="form-control regcom" placeholder="Wallet Balance" name="lang_wallet_bal" value="<?php echo $lang_wallet_bal; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Male</label>
                                           <input class="form-control regcom" placeholder="Male" name="lang_male" value="<?php echo $lang_male; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Female</label>
                                           <input class="form-control regcom" placeholder="Female" name="lang_female" value="<?php echo $lang_female; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Cancel</label>
                                           <input class="form-control regcom" placeholder="Cancel" name="lang_cancel" value="<?php echo $lang_cancel; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Save</label>
                                           <input class="form-control regcom" placeholder="Save" name="lang_save" value="<?php echo $lang_save; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>BOOKING DETAILS</label>
                                           <input class="form-control regcom" placeholder="BOOKING DETAILS" name="lang_booking_dtls" value="<?php echo $lang_booking_dtls; ?>" type="text" >
                                        </div> <div class="form-group">
                                            <label>Past</label>
                                           <input class="form-control regcom" placeholder="Past" name="lang_past" value="<?php echo $lang_past; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Active</label>
                                           <input class="form-control regcom" placeholder="Active" name="lang_active" value="<?php echo $lang_active; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Current Password</label>
                                           <input class="form-control regcom" placeholder="Current Password" name="lang_current_psw" value="<?php echo $lang_current_psw; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>New Password</label>
                                           <input class="form-control regcom" placeholder="New Password" name="lang_psw" value="<?php echo $lang_psw; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Confirm Password</label>
                                           <input class="form-control regcom" placeholder="Confirm Password" name="lang_confirm_psw" value="<?php echo $lang_confirm_psw; ?>" type="text" >
                                        </div> <div class="form-group">
                                            <label>Personal Details</label>
                                           <input class="form-control regcom" placeholder="Select Taxi" name="lang_personal_details" value="<?php echo $lang_personal_details; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Reset</label>
                                           <input class="form-control regcom" placeholder="Reset" name="lang_reset" value="<?php echo $lang_reset; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Contact Us</label>
                                           <input class="form-control regcom" placeholder="Contact Us" name="lang_contact" value="<?php echo $lang_contact; ?>" type="text" >
                                        </div> <div class="form-group">
                                            <label>Name</label>
                                           <input class="form-control regcom" placeholder="Name" name="lang_name" value="<?php echo $lang_name; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Suggestion/Feedback</label>
                                           <input class="form-control regcom" placeholder="Suggestion/Feedback" name="lang_suggestion" value="<?php echo $lang_suggestion; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Show Address</label>
                                           <input class="form-control regcom" placeholder="Show Address" name="lang_show_address" value="<?php echo $lang_show_address; ?>" type="text" >
                                        </div> <div class="form-group">
                                            <label>Hide Address</label>
                                           <input class="form-control regcom" placeholder="Hide Address" name="lang_hide_address" value="<?php echo $lang_hide_address; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Send</label>
                                           <input class="form-control regcom" placeholder="Send" name="lang_send" value="<?php echo $lang_send; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Error in Updation</label>
                                           <input class="form-control regcom" placeholder="Error in Updation" name="lang_error_updatn" value="<?php echo $lang_error_updatn; ?>"  type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Successfully Updated</label>
                                           <input class="form-control regcom" placeholder="Successfully Updated" name="lang_success_updated"   
                                           value="<?php echo $lang_success_updated; ?>" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Night</label>
                                           <input class="form-control regcom" placeholder="Night" name="lang_night"  value="<?php echo $lang_night;?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Day</label>
                                           <input class="form-control regcom" placeholder="Day" name="lang_day"   value="<?php echo $lang_day; ?>
                                           " type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Mail has been send successfully</label>
                                           <input class="form-control regcom" placeholder="Mail has been send successfully" name="lang_mail_send"   value="<?php echo $lang_mail_send; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Error in submission</label>
                                           <input class="form-control regcom" placeholder="Error in submission"  name="lang_error_submission"   value="<?php echo $lang_error_submission; ?>" type="text" >
                                        </div>
											<div class="form-group">
                                            <label>or</label>
                                           <input class="form-control regcom" placeholder="or" name="lang_or"  value="<?php echo $lang_or?>"  type="text" >
                                        </div>
										<div class="form-group">
                                            <label>contact us by sending us mail on</label>
                                           <input class="form-control regcom" placeholder="contact us by sending us mail on" name="lang_contact_mail"   value="<?php echo $lang_contact_mail; ?>" type="text" >
                                        </div>
											<div class="form-group">
                                            <label>eg</label>
                                           <input class="form-control regcom" placeholder="eg" name="lang_eg"  value="<?php echo $lang_eg; ?>"  type="text" >
                                        </div>
										<div class="form-group">
                                            <label>By Hand</label>
                                           <input class="form-control regcom" placeholder="By Hand" name="lang_by_hand"  value="<?php echo $lang_by_hand; ?>"  type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Paypal</label>
                                           <input class="form-control regcom" placeholder="Paypal" name="lang_paypal"  value="<?php echo $lang_paypal; ?>"  type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Month / Year</label>
                                           <input class="form-control regcom" placeholder="Month / Year" name="lang_month_year"  value="<?php echo $lang_month_year; ?>"  type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Book Now</label>
                                           <input class="form-control regcom" placeholder="Book Now" name="lang_book_now"    value="<?php echo $lang_book_now; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Starting</label>
                                           <input class="form-control regcom" placeholder="Starting" name="lang_starting" value="<?php echo $lang_starting; ?>" type="text"  >
                                        </div>
											<div class="form-group">
                                            <label>Home Content1</label>
                                           <input class="form-control regcom" value="<?php echo $lang_home_content1; ?>" placeholder="Home Content1" name="lang_home_content1"  type="text"  >
                                        </div>
										<div class="form-group">
                                            <label>Home Content2</label>
                                  <input class="form-control regcom" placeholder="Home Content2" value="<?php echo $lang_home_content2; ?>" name="lang_home_content2"  type="text"  >
                                        </div>
										 <div class="form-group">
                                            <label>About Header1</label>
                                     <input class="form-control regcom" placeholder="About Header1" value="<?php echo $lang_about_header1; ?>" name="lang_about_header1"  type="text"  >
                                        </div>
										<div class="form-group">
                                            <label>About Header2</label>
                                     <input class="form-control regcom" placeholder="About Header2" value="<?php echo $lang_about_header2; ?>" name="lang_about_header2"  type="text"  >
                                        </div>
										<div class="form-group">
                                            <label>Contact Address</label>
                                     <input class="form-control regcom" placeholder="Contact Address" value="<?php echo $lang_contact_address; ?>" name="lang_contact_address"  type="text"  >
                                        </div>
                                         <div class="form-group">
                                       
                                        <input type="button" class="btn btn-primary" value="Save Details"  name="Save" id="useredit">
                                        
                                      
                                        <input  name="id"   value="<?php echo $row->id; ?>" type="hidden">
                                       </div>    
                                      
							
				</div> 









				
				  
	            </div>
		     </div><!-- /.box -->
			 
           </div>
		   
		   
		   
		   
			 <div class="col-lg-6">
			   <div class="box box-primary edit_promoform">
				 
                <div class="box-header with-border">
                   <h3 class="box-title"></h3>
                      </div><!-- /.box-header -->
                <!-- form start -->
				
                
				
                <div class="box-body">
				  
					                   
										 
										
                                        <div class="form-group">
                                            <label>Car</label>
                                           <input class="form-control regcom" placeholder="Car" name="lang_car" value="<?php echo $lang_car; ?>" type="text">
                                        </div>
										 <div class="form-group">
                                            <label>To Airport</label>
                                           <input class="form-control regcom" placeholder="To Airport" name="lang_to_airport" value="<?php echo $lang_to_airport; ?>" type="text"  >
                                        </div>

                                         <div class="form-group">
                                            <label>From Airport</label>
                                           <input class="form-control regcom" placeholder="From Airport" name="lang_from_airport" value="<?php echo $lang_from_airport; ?>" type="text">
                                        </div>
										 <div class="form-group">
                                            <label>Login</label>
                                           <input class="form-control regcom" placeholder="Login" name="lang_login" value="<?php echo $lang_login; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>User</label>
                                           <input class="form-control regcom" placeholder="User" name="lang_user" value="<?php echo $lang_user; ?>" type="text"  >
                                        </div>
                                        <div class="form-group">
                                            <label>Driver</label>
                                           <input class="form-control regcom" placeholder="Driver" name="lang_driver" value="<?php echo $lang_driver; ?>" type="text"  >
                                        </div>
										 <div class="form-group">
                                            <label>Password</label>
                                           <input class="form-control regcom" placeholder="Password" name="lang_password" value="<?php echo $lang_password; ?>" type="text" >
                                        </div>
									
										<div class="form-group">
                                            <label>Show</label>
                                           <input class="form-control regcom" placeholder="Show" name="lang_show" value="<?php echo $lang_show; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>New to Call My Cab</label>
                                           <input class="form-control regcom" placeholder="New to Call My Cab" name="lang_new_callmycab" value="<?php echo $lang_new_callmycab; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Signup Now</label>
                                           <input class="form-control regcom" placeholder="Signup Now" name="lang_signup_now" value="<?php echo $lang_signup_now; ?>" type="text"  >
                                        </div>
                                        <div class="form-group">
                                            <label>I Agree to the Terms and Conditions</label>
                                           <input class="form-control regcom" placeholder="I Agree to the Terms and Conditions" name="lang_agree_terms" value="<?php echo $lang_agree_terms; ?>" type="text"  >
                                        </div>
										 <div class="form-group">
                                            <label>Signup</label>
                                           <input class="form-control regcom" placeholder="Signup" name="lang_signup" value="<?php echo $lang_signup; ?>" type="text"  >
                                        </div>
										
										
										
										<div class="form-group">
                                            <label>Our cities</label>
                                           <input class="form-control regcom" placeholder="Our cities" name="lang_our_cities" value="<?php echo $lang_our_cities; ?>" type="text" >
                                        </div>
										
										 <div class="form-group">
                                            <label>Social</label>
                                           <input class="form-control regcom" placeholder="Social" name="lang_social" value="<?php echo $lang_social; ?>" type="text"  >
                                        </div>
                                        <div class="form-group">
                                            <label>Bangalore</label>
                                           <input class="form-control regcom" placeholder="PROFILE" name="lang_bangalore" value="<?php echo $lang_bangalore; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Chennai</label>
                                           <input class="form-control regcom" placeholder="Personal Details" name="lang_chennai" value="<?php echo $lang_chennai; ?>" type="text"  >
                                        </div>
										
										
										<div class="form-group">
                                            <label>Delhi</label>
                                           <input class="form-control regcom" placeholder="Basic Information" name="lang_delhi" value="<?php echo $lang_delhi; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>Hyderabad</label>
                                           <input class="form-control regcom" placeholder="Gender" name="lang_hyderabad" value="<?php echo $lang_hyderabad; ?>" type="text" >
                                        </div>
										 <div class="form-group">
                                            <label>footer content1</label>
                                           <input class="form-control regcom" placeholder="footer content1" name="footer_content1" value="<?php echo $footer_content1; ?>" type="text"  >
                                        </div>
                                        <div class="form-group">
                                            <label>footer content2</label>
                                           <input class="form-control regcom" placeholder="footer content2" name="footer_content2" value="<?php echo $footer_content2; ?>" type="text"  >
                                        </div>
										 <div class="form-group">
                                            <label>footer content3</label>
                                           <input class="form-control regcom" placeholder="footer content3" name="footer_content3" value="<?php echo $footer_content3; ?>" type="text" >
                                        </div>
										
				                
										<div class="form-group">
                                            <label>footer content4</label>
                                           <input class="form-control regcom" placeholder="footer content4" name="footer_content4" value="<?php echo $footer_content4; ?>"type="text" >
                                        </div>
										<div class="form-group">
                                            <label>footer content5</label>
                                           <input class="form-control regcom" placeholder="footer content5" name="footer_content5" value="<?php echo $footer_content5; ?>" type="text" >
                                        </div>
			                           <div class="form-group">
                                            <label>footer content6</label>
                                           <input class="form-control regcom" placeholder="footer content6" name="footer_content6" value="<?php echo $footer_content6; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>footer content7</label>
                                           <input class="form-control regcom" placeholder="footer content7" name="footer_content7" value="<?php echo $footer_content7; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>footer content8</label>
                                           <input class="form-control regcom" placeholder="footer content8" name="footer_content8" value="<?php echo $footer_content8; ?>" type="text" >
                                        </div>
										
										<div class="form-group">
                                            <label>Home</label>
                                           <input class="form-control regcom" placeholder="Home" name="lang_home" value="<?php echo $lang_home; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Blog</label>
                                           <input class="form-control regcom" placeholder="Blog" name="lang_blog" value="<?php echo $lang_blog; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Press</label>
                                           <input class="form-control regcom" placeholder="Press" name="lang_press" value="<?php echo $lang_press; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Careers</label>
                                           <input class="form-control regcom" placeholder="Careers" name="lang_careers"  value="<?php echo $lang_careers; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Our Partners</label>
                                           <input class="form-control regcom" placeholder="Our Partners" name="lang_partners" value="<?php echo $lang_partners; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Sitemap Fares</label>
                                           <input class="form-control regcom" placeholder="Sitemap Fares" name="lang_sitemap_fares" value="<?php echo $lang_sitemap_fares; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Callmycab Pvt. Ltd Privacy Policy Terms of Service</label>
                                           <input class="form-control regcom" placeholder="Callmycab Pvt. Ltd Privacy Policy Terms of Service" name="lang_callmycab_pvtltd" value="<?php echo $lang_callmycab_pvtltd; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Are you Serious</label>
                                           <input class="form-control regcom" placeholder="Are you Serious" name="lang_are_serious" value="<?php echo $lang_are_serious; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>A TAXI for just</label>
                                           <input class="form-control regcom" placeholder="A TAXI for just" name="lang_taxi_just" value="<?php echo $lang_taxi_just; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Who we are</label>
                                           <input class="form-control regcom" placeholder="Who we are" name="lang_who_we_are" value="<?php echo $lang_who_we_are; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Want to know more</label>
                                           <input class="form-control regcom" placeholder="Want to know more" name="lang_want_know_more" value="<?php echo $lang_want_know_more; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>QUALITY</label>
                                           <input class="form-control regcom" placeholder="QUALITY" name="lang_quality" value="<?php echo $lang_quality; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>QUALITY content1</label>
                                           <input class="form-control regcom" placeholder="QUALITY content1" name="lang_quality_content1" value="<?php echo $lang_quality_content1; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>QUALITY content2</label>
                                           <input class="form-control regcom" placeholder="QUALITY content2" name="lang_quality_content2" value="<?php echo $lang_quality_content2; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>QUALITY content3</label>
                                           <input class="form-control regcom" placeholder="QUALITY content3" name="lang_quality_content3" value="<?php echo $lang_quality_content3; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>RELIABILITY</label>
                                           <input class="form-control regcom" placeholder="RELIABILITY" name="lang_reliability" value="<?php echo $lang_reliability; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>reliability content1</label>
                                           <input class="form-control regcom" placeholder="reliability content1" name="lang_reliability_content1" value="<?php echo $lang_reliability_content1; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>reliability content2</label>
                                           <input class="form-control regcom" placeholder="reliability content2" name="lang_reliability_content2" value="<?php echo $lang_reliability_content2; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>reliability content3</label>
                                           <input class="form-control regcom" placeholder="reliability content3" name="lang_reliability_content3" value="<?php echo $lang_reliability_content3; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>YOUR RIDE JUST MADE MORE COMFORTABLE</label>
                                           <input class="form-control regcom" placeholder="YOUR RIDE JUST MADE MORE COMFORTABLE" name="lang_ride_comfortable" value="<?php echo $lang_ride_comfortable; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Introducing Cashless Ride</label>
                                           <input class="form-control regcom" placeholder="Introducing Cashless Ride" name="lang_cashless_ride" value="<?php echo $lang_cashless_ride; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Refil Your Wallet</label>
                                           <input class="form-control regcom" placeholder="Refil Your Wallet" name="lang_refill_wallet" value="<?php echo $lang_refill_wallet; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Get Call My Cab on your mobile</label>
                                           <input class="form-control regcom" placeholder="Get Call My Cab on your mobile" name="lang_get_mobile" value="<?php echo $lang_get_mobile; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Send me the link</label>
                                           <input class="form-control regcom" placeholder="Send me the link" name="lang_send_link" value="<?php echo $lang_send_link; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Call us 24 hours available</label>
                                           <input class="form-control regcom" placeholder="Call us 24 hours available" name="lang_available_24" value="<?php echo $lang_available_24; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Call us 24 contents</label>
											<textarea class="form-control" name="lang_callus_24_content" placeholder="Call us 24 contents" value="<?php echo $lang_callus_24_content; ?>"><?php echo $lang_callus_24_content; ?></textarea>
                                            
                                        </div>
											<div class="form-group">
                                            <label>It's New and It's Everywhere</label>
                                           <input class="form-control regcom" placeholder="It's New and It's Everywhere" name="lang_new_everywhere" value="<?php echo $lang_new_everywhere; ?>" type="text" >
                                        </div>
											<div class="form-group">
                                            <label>Car Type</label>
											<textarea class="form-control"   placeholder="Car Type" name="lang_car_type" value="<?php echo $lang_car_type; ?>" ><?php echo $lang_car_type; ?></textarea>
                                            
                                        </div>
											<div class="form-group">
                                            <label>Preffered Location</label>
                                           <input class="form-control regcom" placeholder="Preffered Location" name="lang_preffered_loc" value="<?php echo $lang_preffered_loc; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Preferred Time</label>
                                           <input class="form-control regcom" placeholder="Preferred Time" name="lang_preffered_time" value="<?php echo $lang_preffered_time; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Enter Phone Number</label>
                                           <input class="form-control regcom" placeholder="Enter Phone Number" name="lang_enter_ph" value="<?php echo $lang_enter_ph; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Submit</label>
                                           <input class="form-control regcom" placeholder="Submit" name="lang_submit" value="<?php echo $lang_submit; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Status</label>
                                           <input class="form-control regcom" placeholder="Status" name="lang_status"  value="<?php echo $lang_status; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Total Fare</label>
                                           <input class="form-control regcom" placeholder="Total Fare" name="lang_total_fare"  value="<?php echo $lang_total_fare; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Booking ID</label>
                                           <input class="form-control regcom" placeholder="Booking ID" name="lang_booking_id"  value="<?php echo $lang_booking_id; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>From</label>
                                           <input class="form-control regcom" placeholder="From" name="lang_from" value="<?php echo $lang_from; ?>"  type="text" >
                                        </div>
										<div class="form-group">
                                            <label>To</label>
                                           <input class="form-control regcom" placeholder="To" name="lang_to" value="<?php echo $lang_to; ?>"  type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Password Successfully Changed</label>
                                           <input class="form-control regcom" placeholder="Password Successfully Changed" name="lang_psw_success"  value="<?php echo $lang_psw_success; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Confirm password not matching new password</label>
                                           <input class="form-control regcom" placeholder="Confirm password not matching new password" name="lang_cpsw_not_match" value="<?php echo $lang_cpsw_not_match; ?>"  type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Incorrect Current Password</label>
                                           <input class="form-control regcom" placeholder="Incorrect Current Password" name="lang_incorrect_psw"  value="<?php echo $lang_incorrect_psw; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Error in submisssion</label>
                                           <input class="form-control regcom" placeholder="Error in submisssion" name="lang_error_submission" value="<?php echo $lang_error_submission; ?>"  type="text" >
                                        </div>
										 
										 <div class="form-group">
                                            <label>PAYMENT</label>
                                           <input class="form-control regcom" placeholder="PAYMENT" name="lang_payment"   value="<?php echo $lang_payment; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Wallet</label>
                                           <input class="form-control regcom" placeholder="Wallet" name="lang_wallet"  value="<?php echo $lang_wallet; ?>"  type="text" >
                                        </div>
											<div class="form-group">
                                            <label>Amount</label>
                                           <input class="form-control regcom" placeholder="Amount" name="lang_amount"  value="<?php echo $lang_amount; ?>"  type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Credit Card</label>
                                           <input class="form-control regcom" placeholder="Credit Card" name="lang_credit_card"   value="<?php echo $lang_credit_card; ?>" type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Card Number</label>
                                           <input class="form-control regcom" placeholder="Card Number" name="lang_card_number"  value="<?php echo $lang_card_number; ?>"  type="text" >
                                        </div>
										<div class="form-group">
                                            <label>Expiration Date</label>
                                           <input class="form-control regcom" placeholder="Expiration Date" name="lang_expiration_date"  value="<?php echo $lang_expiration_date; ?>"  type="text" >
                                        </div>
											<div class="form-group">
                                            <label>The last 3 digits displayes on the back of your card</label>
                                           <input class="form-control regcom" placeholder="The last 3 digits displayes on the back of your card" name="lang_last_digits"  value="<?php echo $lang_last_digits; ?>"  type="text" >
                                        </div>
										 
											 <div class="form-group">
                                            <label>About Content</label>
									 <textarea class="form-control regcom" placeholder="About Content" name="lang_about_content"><?php echo $lang_about_content; ?></textarea>
                                        </div>
										 
                                        
										<div class="form-group">
                                            <label>About Footer1</label>
                                     <input class="form-control regcom" value="<?php echo $lang_about_footer1; ?>" placeholder="About Footer1" name="lang_about_footer1"  type="text"  >
                                        </div>
										<div class="form-group">
                                            <label>About Footer2</label>
                                    <input class="form-control regcom" value="<?php echo $lang_about_footer2; ?>" placeholder="About Footer2" name="lang_about_footer2"  type="text"  >
                                        </div>
										<div class="form-group">
                                            <label>About Footer3</label>
                                    <input class="form-control regcom" value="<?php echo $lang_about_footer3; ?>" placeholder="About Footer3" name="lang_about_footer3"  type="text"  >
                                        </div>
									
										</form> 
	      </div>
	  </div>
	  
	  
	  
	  
	   </div>
				  
	</div>			   
			
      </div><!-- /.content-wrapper -->
     <?php
	 include"includes/admin-footer.php";
	 ?>

      <!-- Control Sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
   <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url();?>assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url();?>assets/adminlte/bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url();?>assets/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
	
	 
    <script src="<?php echo base_url();?>assets/adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url();?>assets/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url();?>assets/adminlte/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url();?>assets/adminlte/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url();?>assets/adminlte/dist/js/demo.js"></script>
	
	 <script src="<?php echo base_url();?>assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>
     <script src="<?php echo base_url();?>assets/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- page script -->
	  <script src="<?php echo base_url();?>assets/adminlte/dist/js/sb-admin-2.js"></script>
    <!-- page script -->
   <script src="<?php echo base_url();?>assets/adminlte/plugins/select2/select2.full.min.js"></script>
   
   
   
     
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" />
        <script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
    
  
    
       <script type="text/javascript">
$(document).ready(function(){
$(".sample").on("keydown", function (e) {
        return e.which !== 32;
	    });  
	
        $('.sample').keyup(function()
	     {
			var yourInput = $(this).val();
			re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
			var isSplChar = re.test(yourInput);
			if(isSplChar)
			{
				var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
				$(this).val(no_spl_char);
			}
		});	
					   
$('.regcom').on('change', function (){
var a = $(this).val();
if(a != '') {
$(this).removeClass('error-admin');

} else {
$(this).addClass('error-admin');
return false;
}
 });						   
						   
						   
 $("#useredit").click(function(e){

  var isValid = true;
        $('input[type="text"]').each(function() {
            if ($.trim($(this).val()) == '') {
                isValid = false;
                $(this).css({
                    "border": "1px solid red",
                    
                });
				$(this).focus();
				return false;
            }
            else {
                $(this).css({
                    "border": "",
                    "background": ""
                });
            }
        });
		 if (isValid == false) {
            e.preventDefault();
		 }
        else {
            
	          var value =$("#taxi_reg").serialize() ;

$.ajax({
url:'<?php echo base_url();?>admin/insert_language',
method:'post',
data:value,
success:function(res){
$(".edituser").show();
console.log(res);
if(res==0){
	 $(".edituser").focus();
	$(".edituser").html('<p class="error">Error</p>');
	setTimeout(function(){$(".edituser").hide(); }, 3000);
	
}else if(res==2){
	
	$(".edituser").focus();
	$(".edituser").html('<p class="error">Language Exists</p>');
	setTimeout(function(){$(".edituser").hide(); }, 3000);
}
else{
$(".edituser").focus();
$(".edituser").html('<p class="success">Add Language Saved Successfully</p>');
setTimeout(function(){$(".edituser").hide(); }, 1500);
$('#taxi_reg')[0].reset();
}
}
}); 
		}
	            
                                       
 
});
});

</script>

  </body>
</html>

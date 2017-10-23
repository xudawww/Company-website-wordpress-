<?php
$user_data = is_logged();
$get_settings=getsettingsdetails();
 $get_lang=getLanguageForsite();
  include $get_lang;
 echo "jhuhjk";
?>
<script type="text/javascript">
    var base_url ='<?php echo base_url(); ?>';
</script>

 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC9JX3BZZfx2S6GQieC_PqjuJdUbZ7_wyM&libraries=places"
        async defer></script>
		
		
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $get_settings->title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/fav.jpg" type="image/jpg" sizes="16x16">
    <link href="https://fonts.googleapis.com/css?family=Lato:300i,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/css/hover-min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/css/responsive.css">
	    <link rel="icon" href="<?php echo base_url();?><?php echo $get_settings->favicon; ?>">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-timepicker.css"/>

 <link rel="stylesheet" href="<?php echo base_url();?>assets/css/parsley/parsley.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/css/sweetalert.css">
</head>
<body >

<nav class="navbar navbar-default nav-main">
    <div class="container">
		<div class="loader" >
                <img src="<?php echo base_url();?>assets/img/loader.gif" width="120" height="120" />
				</div>
        <div class="row">
            <div class="col-lg-3">
                <div class="logo">
                    <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?><?php echo $get_settings->logo; ?>" class="img-responsive col-lg-9 col-xs-6 col-sm-3" alt=""/></a>
                </div>

            </div>
            <div class="col-lg-9">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav nav-head nav-call" id="logged_ul">
                        <li class="active"><a href="<?php echo base_url();?>callmycab/about"><span><img src="<?php echo base_url();?>assets/img/home/m-1.png"/> </span><br><?php echo $lang_about_us; ?></a></li>
                        <li><a href="#" data-toggle="modal" data-target="#myModalcall"><span><img src="<?php echo base_url();?>assets/img/home/m-2.png"/> </span><br><?php echo $lang_callback; ?></a></li>
                        <li><a href="#" data-toggle="modal" data-target="#myModalf"><span><img src="<?php echo base_url();?>assets/img/home/m-3.png"/> </span><br><?php echo $lang_fare_chart; ?> </a></li>
                        <li><a href="<?php echo base_url();?>callmycab/contact_us"><span><img src="<?php echo base_url();?>assets/img/home/m-4.png"/> </span><br><?php echo $lang_contact; ?> </a></li>
						<?php if(!$user_data){?>
						 <li id="notLogged"><a href="#" id="log_sect" class="login_now"><span><img src="<?php echo base_url();?>assets/img/home/m-5.png"/> </span><br><?php echo $lang_login_signp; ?> </a></li>
                       	<?php }else{?>
						  <li id="logged" class="active check_test"><a href="<?php echo base_url();?>callmycab/account"><span><img src="<?php echo base_url();?>assets/img/home/m-1.png"/> </span><br><?php echo $user_data->username; ?></a></li>
					      <li><a href="<?php echo base_url();?>callmycab/logout"  ><span><img src="<?php echo base_url();?>assets/img/home/m-5.png"/> </span><br><?php echo $lang_logout; ?> </a></li>
						  <?php }?>
                    </ul>
                </div>
            </div>
        </div>


    </div>
</nav>



<div class="container">
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class="modal-content call-back-model-content">
                        <div class="modal-header">
                            <div class="cl-mdl"   class="close" data-dismiss="modal" /> </div>
                            <h4 class="modal-title call-bck-title">OTP Verification</h4>
                        </div>
                        <div class="modal-body">
                            <form name="otp_verification" id="otp_verification" data-parsley-validate="">
                                <div class="form-group">
                                    <input type="text" class="form-control forn-mdl-callback"  name="otp" placeholder="Enter verification code">
                                </div>

                                <div class="form-group">
                                    <button type="button" id="verify_otp" class="btn btn-default btn-snd-callback"><?php echo $lang_submit; ?></button>
                                </div>
								<div id="error_msgs"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>

        </div>
    </div>

</div>



<div class="container">
    <div class="modal fade" id="myModalcall" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class="modal-content call-back-model-content">
                        <div class="modal-header">
                            <img class="cl-mdl" src="<?php echo base_url();?>assets/img/callback/1.png" class="close" data-dismiss="modal" /> </button>
                            <h4 class="modal-title call-bck-title"><?php echo $lang_callback; ?></h4>
                        </div>
                        <div class="modal-body">
                            <form name="callback_form" id="callback_form" data-parsley-validate="">
                                <div class="form-group">
                                    <input type="text" class="form-control forn-mdl-callback"  name="callbck" placeholder="<?php echo $lang_enter_ph; ?>" required data-parsley-minlength="10" data-parsley-maxlength="11" data-parsley-trigger="keyup" data-parsley-type="digits" >
                                </div>
 <div class="test11"></div>
                                <div class="form-group">
                                    <button type="button" id="callback_button" class="btn btn-default btn-snd-callback"><?php echo $lang_submit; ?></button>
                                </div>
								<div id="error_msgs"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>

        </div>
    </div>

</div>

<div class="container">
    <div class="modal fade" id="myModalf" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
                    <div class="modal-content call-back-model-content">
                        <div class="modal-header">
                            <img class="cl-mdl" src="<?php echo base_url();?>assets/img/callback/1.png" class="close" data-dismiss="modal" /> </button>
             <div class="row">
                 <div class="col-lg-4 col-xs-12">
                     <form>
                         <div class="form-group">
                             <div class="row">
                                 <div class="col-lg-2">
                                     <img src="<?php echo base_url();?>assets/img/farechart/1.png" class="far-srch"/>
                                 </div>
                                 <div class="col-lg-10">
                                     <input type="text" class="form-control forn-mdl-callback" id="search_amount" placeholder="<?php echo $lang_starting; ?>">
                                 </div>
                             </div>


                         </div>

                     </form>
                 </div>
                 <div class="col-lg-8 ">
                   <div class="row">
                       <div class="col-lg-6 add-highlight" id="day_main">
                           <div class="row">
                               <div class="col-lg-2">
                              <img src="<?php echo base_url();?>assets/img/farechart/2.png" class="mn-time" />
                               </div>
                               <div class="col-lg-8">
                               <h6 class="mn-time-text" style="cursor:pointer;" id="day_click">6:00 AM-10:00 PM</h6>
                               </div>
                               <input type="hidden" id="time_type" name="time_type" value="day">
                           </div>
                       </div>
                       <div class="col-lg-6" id="night_main">
                           <div class="row">
                               <div class="col-lg-2">
                                   <img src="<?php echo base_url();?>assets/img/farechart/3.png" class="mn-time moon_time" />
                               </div>
                               <div class="col-lg-8">
                                   <h6 class="mn-time-text" style="cursor:pointer;" id="night_click">10:00 PM-6:00 AM</h6>
                               </div>
                           </div>
                       </div>
                   </div>
                 </div>
             </div>
                        </div>
                        <div class="modal-body">
                            <div class="tab-home">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <ul class="nav nav-tabs nav-fare-chart">
                                            <li class="active">
                                                <a data-toggle="tab" href="#home">
                                                    <h4><img src="<?php echo base_url();?>assets/img/farechart/4.png"/></h4>
                                                    <h5> <?php echo $lang_ptp; ?></h5>
                                                </a>
                                            </li>
                                            <li><a data-toggle="tab" href="#menu1">
                                                    <h4><img src="<?php echo base_url();?>assets/img/farechart/5.png"/></h4>
                                                    <h5 class="artprt"> <?php echo $lang_airport; ?></h5>
                                                </a>
                                            </li>
                                            <li><a data-toggle="tab" href="#menu2">
                                                    <h4><img src="<?php echo base_url();?>assets/img/farechart/6.png"/></h4>
                                                    <h5>  <?php echo $lang_hourly; ?></h5>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle="tab" href="#menu3">
                                                    <h4><img src="<?php echo base_url();?>assets/img/farechart/7.png"/></h4>
                                                    <h5> <?php echo $lang_outstation; ?></h5>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row tab-cbt">
                                    <div class="tab-content">
                                        <div id="home" class="tab-pane fade in active">
                                           <div class="row">
                                            <div class="col-lg-12">
                                            <div class="col-lg-1"></div>
                                                <div class="col-lg-10">
                                            <div class="row">
                                                <div class="col-lg-6 cr-lg-6 col-xs-6">
                                                   <div class="cr-fare">
                                                       <h4> <?php echo $lang_car; ?></h4>
                                                   </div>
                                                </div>
                                                <div class="col-lg-6 cr1-lg-6 col-xs-6">
                                                    <div class="cr-fare">
                                                        <h4> <?php echo $lang_fare; ?></h4>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mn-rev-scroll" id="point_cab">
                                                 
                                                   
                                            </div>
                                                   


                                                </div>
                                                <div class="col-lg-1"></div>
                                            </div>
                                           </div>
                                        </div>
                                        <div id="menu1" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="col-lg-1"></div>
                                                    <div class="col-lg-10">
                                                        <div class="row">
                                                            <div class="col-lg-4 cr-lg-4 col-xs-4">
                                                                <div class="cr-fare">
                                                                    <h4> <?php echo $lang_car; ?></h4>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 cr1-lg-4 col-xs-4">
                                                                <div class="cr-fare">
                                                                    <h4> <?php echo $lang_to_airport; ?></h4>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 cr2-lg-4 col-xs-4">
                                                                <div class="cr-fare">
                                                                    <h4> <?php echo $lang_from_airport; ?></h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                <div class="mn-rev-scroll" id="airport_cab">
                                                 
                                               
                                                </div>
                                                        
                                                        
                                                    </div>
                                                    <div class="col-lg-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="menu2" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="col-lg-1"></div>
                                                    <div class="col-lg-10">
                                                        <div class="row">
                                                            <div class="col-lg-6 cr-lg-6 col-xs-6">
                                                                <div class="cr-fare">
                                                                    <h4> <?php echo $lang_car; ?></h4>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 cr1-lg-6 col-xs-6">
                                                                <div class="cr-fare">
                                                                    <h4> <?php echo $lang_fare; ?></h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                            <div class="mn-rev-scroll" id="hourly_cab">
                                                 
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                </div>
                                                    </div>
                                                    <div class="col-lg-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="menu3" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="col-lg-1"></div>
                                                    <div class="col-lg-10">
                                                        <div class="row">
                                                            <div class="col-lg-6 cr-lg-6 col-xs-6">
                                                                <div class="cr-fare">
                                                                    <h4> <?php echo $lang_car; ?></h4>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 cr1-lg-6 col-xs-6">
                                                                <div class="cr-fare">
                                                                    <h4><?php echo $lang_fare; ?></h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <div class="mn-rev-scroll" id="station_cab">
                                                 
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                </div>
                                                    </div>
                                                    <div class="col-lg-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

        </div>
    </div>

</div>

<div class="container cont-login-up">
    <div class="modal fade" id="myModallogin" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class="modal-content call-back-model-content">
                        <div class="modal-header modal-header-1">
                            <img class="cl-mdl" src="<?php echo base_url();?>assets/img/callback/1.png" class="close" data-dismiss="modal" /> </button>
                            <h4 class="modal-title call-bck-title"> <?php echo $lang_login; ?></h4>
                        </div>
                        <div class="modal-body">
                           <form class="cd-form" id="log_sign" name="login" data-parsley-validate="">
                                <div class="form-group ">
                                    <label class="radio-inline rad-user"><input type="radio" checked id="user4" value="user" name="user" data-required="true"> <?php echo $lang_user; ?></label>
                                    <label class="radio-inline rad-user"><input type="radio" id="driver4"  value="driver" name="user"> <?php echo $lang_driver; ?></label>
                                </div>
                                  <div class="row">
                                      <div class="form-group col-lg-9">
                                          <input type="text" class="form-control forn-mdl-callback" id="signin-email" name="username" placeholder="<?php echo $lang_username; ?>" required="">
                                      </div>
                                  </div>


                                <div class="row">
                                    <div class="form-group col-lg-9">
                                        <input type="password" class="form-control forn-mdl-callback" id="signin-password"  name="password" placeholder="<?php echo $lang_password; ?>" required="">

                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label class="checkbox-inline sh-pass"  class="hide-password" ><input type="checkbox" id="log_show" name="log_show" value=""><?php echo $lang_show; ?></label>
                                    </div>
                                </div>
								
							<!--	<p class="fieldset">
						<input type="checkbox" id="remember-me" name="rememberme">
						<label class="checkbox-inline" for="remember-me">Remember me</label>
						</p> -->
           <div id="success_msg" ></div>
		   <div id="error_msg" ></div>

                                <div class="form-group">
									 <button type="button" class="btn btn-default btn-snd-callback signup_logg" value="Login" > <?php echo $lang_login; ?></button>
                                </div>
                                <div class="sign-req">
                                 <h4><?php echo $lang_new_callmycab; ?>?<span><a href="javascript:void(0)" class="signup_now" id="signup_modal" > <?php echo $lang_signup_now; ?></a></span></h4>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>

        </div>
    </div>

</div>


<div class="container">
    <div class="modal fade" id="myModalsignup" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class="modal-content call-back-model-content">
                        <div class="modal-header modal-header-1">
                            <img class="cl-mdl" src="<?php echo base_url();?>assets/img/callback/1.png" class="close" data-dismiss="modal" /> </button>
                            <h4 class="modal-title call-bck-title"><?php echo $lang_signup; ?></h4>
                        </div>
                        <div class="modal-body">
                           <form class="cd-form"  id="user_reg"  name="user_reg" data-parsley-validate="">
                                <div class="form-group ">
                                    <label class="radio-inline rad-user"><input type="radio" checked value="user" name="type" required=""><?php echo $lang_user; ?></label>
                                    <label class="radio-inline rad-user"><input type="radio" value="driver" name="type"  required=""><?php echo $lang_driver; ?></label>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-9">
                                        <input type="text" class="form-control forn-mdl-callback"  id="signup-username" name="username" placeholder="<?php echo $lang_username; ?>"  required="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-9">
                                        <input type="text" class="form-control forn-mdl-callback" id="signup-mobile" name="mobile"minlength="10" 	
data-parsley-minlength="10"data-parsley-trigger="keyup" data-parsley-type="digits" placeholder="<?php echo $lang_phone; ?>"  required="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-9">
                                        <input type="email" class="form-control forn-mdl-callback" id="signup-email" name="email" placeholder="<?php echo $lang_email; ?>"  required="">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group col-lg-9">
                                        <input type="password" class="form-control forn-mdl-callback"  id="signup-password" name="password"   placeholder="<?php echo $lang_password; ?>"  required="">

                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label class="checkbox-inline sh-pass"><input type="checkbox" id="sign_show" name="sign_show" value=""><?php echo $lang_show; ?></label>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="checkbox-inline sh-pass-1"><input type="checkbox" value="" id="accept-terms" required=""> <?php echo $lang_agree_terms; ?></label>
                                    </div>
                                </div>


								<div class="test12"></div>
                                <div class="form-group">
                                    <button type="button" id="userreg" class="btn btn-default btn-snd-callback"><?php echo $lang_signup_now; ?></button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>

        </div>
    </div>

</div>
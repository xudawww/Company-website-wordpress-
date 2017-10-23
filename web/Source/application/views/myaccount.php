<?php
$user_data = is_logged();
 include getLanguageForsite(); 
?>
 

<div class="container-fluid">
    <div class="container">
        <div class="row">
  <div class="col-lg-4" style="padding: 0;">
   <div class="main-login">
       <div class="main-first">
           <div class="row">
               <div class="col-lg-4 col-md-2 col-xs-4">
                   <img src="<?php echo base_url();?>assets/img/login/1.png"/>
               </div>
               <div class="col-lg-8">
                   <div class="main-log-inner">
                       <h4><?php echo $user_data->username; ?></h4>
                       <h5><?php echo $lang_personal_details; ?></h5>
                     <h6 class="c-pass"><?php echo $lang_change_psw; ?><span><img src="<?php echo base_url();?>assets/img/login/2.png"/> </span></h6>
                   </div>
               </div>
           </div>

       </div>
       <div class="m-s-1">
           <div class="main-second">
      <form name="account_dtls" id="account_dtls" data-parsley-validate="" >
               <div class="form-group">
                   <label for="exampleInputPassword1"><?php echo $lang_username; ?></label>
                   <input type="text" class="form-control" name="username"   readonly value="<?php echo $details->user_name; ?>" placeholder="<?php echo $lang_username; ?>UserName">
               </div>
               <div class="form-group">
                   <label for="exampleInputPassword1"><?php echo $lang_email; ?></label>
                   <input type="email" class="form-control" name="email" readonly value="<?php echo $details->email; ?>" placeholder="<?php echo $lang_email; ?>Email">
               </div>
               <div class="form-group">
                   <label for="exampleInputPassword1"><?php echo $lang_phone; ?></label>
                   <input type="text" class="form-control" name="mobile" readonly value="<?php echo $details->phone; ?>" placeholder="<?php echo $lang_phone; ?>Phone">
               </div>
               <div class="form-group gender">
                   <label for="exampleInputPassword1"><?php echo $lang_gender; ?></label>
				 
                   <label class="radio-inline"><input type="radio"  value="male"  name="gender" <?php if($details->gender=='male') {echo "checked";} ?> name="optradio"><?php echo $lang_male; ?></label>
                   <label class="radio-inline"><input type="radio" value="female"  required name="gender" <?php if($details->gender=='female') {echo "checked";} ?> name="optradio"><?php echo $lang_female; ?></label>
                   <div class="clearfix"></div>
				   <?php 
				  $type= $this->session->userdata('type');
				  if($type=='user'){ ?>
                   <h5><?php echo $lang_wallet_bal; ?><span><?php echo get_wallet($details->user_name); ?><!-- $ <?php if($details->wallet_amount!=0){echo $details->wallet_amount;}else{echo "0";} ?> --></span></h5>
                  <?php } ?> 
				</div>
				  <?php 
				  
				  if($type=='driver'){ ?>
                   <div class="form-group">
                       <label for="exampleInputPassword1"><?php echo $lang_car_type; ?></label>
                      <select class="form-control" name="car_type"> 
					  
					
					  <?php foreach($cartypess as $cartyp){ ?>
				<option value="<?php echo $cartyp['car_type']; ?>"   <?php if($selected_cartype->car_type==$cartyp['car_type']) echo 'selected'; ?>> <?php echo $cartyp['car_type']; ?></option>
					  <?php } ?> 
				</select>
				</div>
                   <div class="form-group">
                       <label for="exampleInputPassword1"><?php echo $lang_preffered_loc; ?> </label>
                       <input type="text" class="form-control" name="preffered_location"  value="<?php if(isset($selected_cartype->preffered_location)){if($selected_cartype->preffered_location!="") echo $selected_cartype->preffered_location; } ?>" id="driver_loc" onClick="initialize(this.id)">
					      <input type='hidden' value='in' id='countryin'>
						     <input type='hidden' name="lat" id="driver_lat">
							    <input type='hidden' name="lng" id="driver_lng">
                   </div>
				    <div class="form-group">
                       <label for="exampleInputPassword1"><?php echo $lang_preffered_time; ?></label>
                      <select class="form-control" name="timetype"> 
					  
						   
				<option value="day" <?php if($selected_cartype->timetype=="day") echo 'selected'; ?>><?php echo $lang_day; ?> </option>
  <option value="night" <?php if($selected_cartype->timetype=="night") echo 'selected'; ?>><?php echo $lang_night; ?></option>
  <!-- <option value="both" <?php if($selected_cartype->timetype=="both") echo 'selected'; ?>>Both</option> --></select>
                   </div>
				  <?php } ?>
                   <div class="form-group">
                       <button type="button" name="save_info" id="save_details" class="btn btn-default btn-save"><?php echo $lang_save; ?></button>
                       <a href="" class="cancel"><?php echo $lang_cancel; ?></a>
                   </div>

           </form>
		   <div id="success_div" ><?php echo $lang_success_updated; ?></div>
		   <div id="error_div" ><?php echo $lang_error_updatn; ?></div>
           </div>
       </div>
       <div class="m-s-2">
           <div class="main-second">
               <form name="change_psw_acc" id="change_psw_acc" data-parsley-validate="">
                   <div class="form-group">
                       <input  class="form-control"  name="old_pass" id="old_pass"    type="password" required  placeholder="<?php echo $lang_current_psw; ?>">
                   </div>
                   <div class="form-group">
                       <input name="passwords" id="passwords" class="form-control" type="password" required data-parsley-mincheck="6" placeholder="<?php echo $lang_psw; ?>">
                   </div>
                   <div class="form-group">
                       <input name="cpassword" id="cpassword" class="form-control"   type="password" data-parsley-mincheck="6" required  data-parsley-equalto="#passwords" placeholder="<?php echo $lang_confirm_psw; ?>">
                   </div>

<div id="success_psw"><?php echo $lang_psw_success; ?></div>
<div id="confirm_psw"><?php echo $lang_cpsw_not_match; ?></div>
<div id="current_psw"><?php echo $lang_incorrect_psw; ?></div>
<div id="error_psw"><?php echo $lang_error_submission; ?></div>
                   <div class="form-group">
				      <button type="button" id="save_chng_psw" name="save_chng_psw" class="btn btn-default btn-save" ><?php echo $lang_save; ?></button>
                    
					    <button type="button"   class="btn btn-default btn-save hide-main-second" ><?php echo $lang_reset; ?></button>
                   </div>

               </form>
           </div>
       </div>


   </div>
  </div>
            <div class="col-lg-8 bac-gh-8">
                <div class="tab-login">
                    <div class="tab-lg-sub">
                        <h4><?php echo $lang_booking_dtls; ?></h4>
                        <div class="row">
                            <div class="col-lg-8">
                                <ul class="nav nav-tabs nav-lgn chk">
                                    <li class="active" id="active1">
                                        <a data-toggle="tab" href="#homelg">
                                            <h5><?php echo $lang_active; ?> </h5>
                                        </a>
                                    </li>
                                    <li id="past1"><a data-toggle="tab" href="#menulg">
                                            <h5><?php echo $lang_past; ?></h5>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <div class="sort-by">
                                   <h5><input id="datepicker_sort" type="hidden"> <span> </span></h5>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-content mn-ht-content">
                    <div id="homelg" class="tab-pane fade in active append_content_active">
					<?php foreach($active_tab as $activetab){ ?>
						<div class="tab-login-first">
                            <h5><?php echo $lang_from; ?><span><?php echo $activetab->pickup_area; ?></span></h5>
                            <h5><?php echo $lang_to; ?><span><?php echo $activetab->drop_area; ?></span></h5>
                            <div class="date-tf">
                                <h6> <?php echo date("D, j M", strtotime($activetab->pickup_date)); ?><span><?php echo $activetab->pickup_time; ?></span></h6>
                            </div>
                            <div class="date-tf">
                                <h6><?php echo $lang_booking_id; ?>: <span><?php echo $activetab->uneaque_id; ?></span></h6>
                            </div>
                            <div class="date-tf">
                                <h6><?php echo $lang_car_type; ?>: <span><?php echo $activetab->taxi_type; ?></span></h6>
                            </div>
                            <div class="date-tf">
                                <h6><?php echo $lang_total_fare; ?>:<span><?php echo $activetab->amount; ?></span> </h6>
                            </div>
                            <div class="clearfix"></div>
                            <h6 class="stat"><?php echo $lang_status; ?>:<span><?php echo$activetab->status; ?></span></h6>
                        </div>
					<?php } ?>
                        
                    </div>

                    <div id="menulg" class="tab-pane fade in append_content_past">
					<?php foreach($book_tab as $booktab){ ?>
                        <div class="tab-login-first">
                            <h5><?php echo $lang_from; ?><span><?php echo $booktab->pickup_area; ?></span></h5>
                            <h5><?php echo $lang_to; ?><span><?php echo $booktab->drop_area; ?></span></h5>
                            <div class="date-tf">
                                <h6> <?php echo date("D, j M", strtotime($booktab->pickup_date)); ?> <span><?php echo $booktab->pickup_time; ?></span></h6>
                            </div>
                            <div class="date-tf">
                                <h6><?php echo $lang_booking_id; ?>: <span><?php echo $booktab->uneaque_id; ?></span></h6>
                            </div>
                            <div class="date-tf">
                                <h6><?php echo $lang_car_type; ?>: <span><?php echo $booktab->taxi_type; ?></span></h6>
                            </div>
                            <div class="date-tf">
                                <h6><?php echo $lang_total_fare; ?>:<span><?php echo $booktab->amount; ?></span> </h6>
                            </div>
                            <div class="clearfix"></div>
                            <h6 class="stat"><?php echo $lang_status; ?>:<span><?php echo $booktab->status; ?></span></h6>
                        </div>
                        	<?php } ?>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

 
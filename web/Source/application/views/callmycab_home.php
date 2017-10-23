<!--banner-->
<?php include getLanguageForsite(); 
$get_settings=getsettingsdetails();

?>
<div class="container-fluid">
    <div class="banner-home">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-4">
                        <div class="serious-section animated fadeIn">
                            <div class="srs-main">
                                <img src="<?php echo base_url();?>assets/img/home/3.png" class="img-responsive" />
                                <div class="serious-text">
                                    <h3><?php echo $lang_are_serious; ?>?</h3>
                                    <h4><?php echo $lang_taxi_just; ?><br>
                                        <span>499?</span></h4>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="who-main">
                            <h4><?php echo $lang_who_we_are; ?> </h4>
                            <p><?php echo $lang_home_content1; ?></p>
                            <h5><a href=""><?php echo $lang_want_know_more; ?><span><img src="<?php echo base_url();?>assets/img/home/1.jpg"/></span></a></h5>
                            <h6><img src="<?php echo base_url();?>assets/img/home/1.png" />
                                <img src="<?php echo base_url();?>assets/img/home/2.png"/></h6>
                        </div>
                    </div>
                </div>

            </div>
            <div class="img-car animated fadeInRight">
                <img src="<?php echo base_url();?>assets/img/home/car.png" alt="" class="img-responsive"/>
            </div>
            <div class="img-map-marker animated zoomIn">
                <img src="<?php echo base_url();?>assets/img/home/map.png" alt="" class="img-responsive"/>
            </div>

        </div>

    </div>
</div>
<!--banner-->
<div class="container">
    <div class="second-home-section">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-6 col-md-6 sec-1">
                    <img src="<?php echo base_url();?>assets/img/home/sec-1.png" alt="" class="img-responsive hvr-grow"/>
                    <div class="clearfix"></div>
                    <h3><?php echo $lang_quality; ?></h3>
                    <p>    <?php echo $lang_quality_content1; ?> 
                       <?php echo $lang_quality_content2; ?> 
                        <?php echo $lang_quality_content3; ?></p>
                </div>
                <div class="col-lg-6 col-md-6 sec-2">
                    <img src="<?php echo base_url();?>assets/img/home/sec-2.png" alt="" class="img-responsive hvr-grow"/>
                    <h3><?php echo $lang_reliability; ?>  </h3>
                    <p>   <?php echo $lang_reliability_content1; ?> 
                        <?php echo $lang_reliability_content2; ?> 
                        <?php echo $lang_reliability_content3; ?> </p>
                </div>
            </div>
        </div>
        <div class="row rw-pad">
            <!--<div class="col-lg-offset-2"></div>-->
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="chaseless">
                            <img src="<?php echo base_url();?>assets/img/home/sec-3.png" class="img-responsive hvr-grow" />
                            <div class="chaseless-text">
                                <h4><?php echo $lang_ride_comfortable; ?></h4>
                                <h5><?php echo $lang_cashless_ride; ?>!</h5>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-4">
                        <div class="refil">
                   <a href="" data-toggle="modal" data-target="#myModalwallet"><?php echo $lang_refill_wallet; ?></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="call-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-5"></div>
                <div class="col-lg-6 call-right">
                    <img src="<?php echo base_url();?>assets/img/home/t-1.png" class="img-t hvr-grow" />
                    <h3><?php echo $lang_available_24; ?></h3>
                    <h2>800 666 7777</h2>
                    <p><?php echo $lang_callus_24_content; ?>.</p>

                </div>
            </div>


        </div>

    </div>

</div>

<div class="container-fluid">
    <div class="last-scn-home">
        <div class="container">
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-5 ">
                    <div class="hand-section">
                        <h3><?php echo $lang_new_everywhere; ?>!</h3>
                        <p><?php echo $lang_home_content2; ?></p>
                        <img src="<?php echo base_url();?>assets/img/home/p-1.png"/>
                        <h4><?php echo $lang_get_mobile; ?>.</h4>
                        <form>
                            <div class="form-group col-lg-6" style="padding: 0;">
                                <input type="text" class="form-control" id="phone">
                                <button type="submit" class="btn btn-default but-sub"><?php echo $lang_send_link; ?></button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="img-last-home">
                        <img src="<?php echo base_url();?>assets/img/home/hand.png" class="img-responsive hand-img hvr-grow"  alt=""/>
                    </div>

                </div>
            </div>


        </div>
    </div>

</div>


<div class="book-scn-tab">
    <div class="book-now-option">
        <h3> <img src="<?php echo base_url();?>assets/img/home/pop.png" /></h3>
        <div class="vector-part">
            <div class="sym-up">

            </div>
            <h3><?php echo $lang_book_now; ?></h3>
        </div>
    </div>
    <div class="container-fluid bot-tab">
        <div class="container">
            <div class="bk-option-down">
                <h3> <img src="<?php echo base_url();?>assets/img/home/pop.png" /></h3>
                <div class="vector-part">
                    <div class="sym-up-1">

                    </div>
                    <h3><?php echo $lang_book_now; ?></h3>
                </div>
            </div>
            <div class="tab-home">
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <ul class="nav nav-tabs nav-tab-find nav-mn-fnd">
                            <li class="active">
                                <a data-toggle="tab" href="#point">
                                    <h4><img src="<?php echo base_url();?>assets/img/home/bk-1.png"/></h4>
                                    <h5><?php echo $lang_ptp; ?></h5>
                                </a>
                            </li>
                            <li><a data-toggle="tab" href="#airport">
                                    <h4><img src="<?php echo base_url();?>assets/img/home/bk-2.png"/></h4>
                                    <h5><?php echo $lang_airport; ?></h5>
                                </a>
                            </li>
                            <li><a data-toggle="tab" href="#hourly">
                                    <h4><img src="<?php echo base_url();?>assets/img/home/bk-3.png"/></h4>
                                    <h5><?php echo $lang_hourly; ?></h5>
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#outstation">
                                    <h4><img src="<?php echo base_url();?>assets/img/home/bk-4.png"/></h4>
                                    <h5><?php echo $lang_outstation; ?></h5>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-2"></div>
                </div>

                <div class="tab-content">
                    <div id="point" class="tab-pane fade in active">
                        <div class="tab-main">
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <div class="br-tab"></div>
                                    <ul class="nav nav-tabs nav-tab-find nav-inner-find ">
                                        <li id="first" class="active "><a data-toggle="" href="#homes">
                                                <h4><img src="<?php echo base_url();?>assets/img/home/loc.png"/></h4>
                                                <h6><?php echo $lang_location; ?></h6>
                                            </a></li>
                                        <li id="second"  ><a data-toggle="" href="#menus1">
                                                <h4><img src="<?php echo base_url();?>assets/img/home/selcar.png"/></h4>
                                                <h6><?php echo $lang_selectaxi; ?></h6>
                                            </a>
                                        </li>
                                        <li id="third"  ><a data-toggle="" href="#menus2">
                                                <h4><img src="<?php echo base_url();?>assets/img/home/confirm.png"/></h4>
                                                <h6><?php echo $lang_confirm; ?> </h6>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                                <div class="col-lg-3"></div>
                            </div>
							 <form name="myForm" id="myForm">
                            <div class="tab-content">
							
                                <div id="homes" class="tab-pane fade in active">
                                    <div class="row">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6">
                                            <div class="form-mn">
                                                 <input type='hidden' value='<?php echo $get_settings->country; ?>' id='countryin'>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_pickup_area; ?></label>
                                                                <input type="text" class="form-control first pickup_areas"   name="pickup_area" placeholder="Street, Town" id="autocomplete" autocomplete="on" onClick="initialize(this.id);">
                                                            </div>
                                                        </div>
							<input type='hidden' name="driver_lat" id="driver_lat">
						    <input type='hidden' name="driver_lng" id="driver_lng">
							 <input type='hidden' name="drop_lat" id="drop_lat">
						    <input type='hidden' name="drop_lng" id="drop_lng">
							 <input type='hidden' value="Point to Point Transfer" name="purpose" id="purpose">
							 
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_pickup_date; ?> </label>
                                                                <input type="text" class="form-control first"  autocomplete="off" name="pickup_date" id="datepicker1" placeholder="Date">
                                                            </div>
                                                        </div>

                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_drop_area; ?></label>
                                                                <input type="text" class="form-control first drop_areas" name="drop_area" placeholder="Destination" id="autocomp" autocomplete="on" onClick="initializes(this.id);">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_pickup_time; ?></label>
                                                                <input type="text" class="form-control first basicExample" name="pickup_time" id="pickup_time" placeholder="Time">
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-4">

                                                            <div class="form-group">
                                                                <button type="button" data-validate="first" class="btn btn-default btn-continue point_to_point" ><?php echo $lang_find_taxi; ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                            </div>

                                        </div>
                                        <div class="col-lg-3"></div>
                                    </div>
                                </div>
                               
                                   <div id="menus1" class="tab-pane fade">
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-6">
                                                <div class="form-mn">
                                                    <form>
                                                    <div class="row">

                                                        <div class="col-lg-11">
                                                            <div class="select-car">
                                                                <h5><?php echo $lang_select_car; ?><span class="fr-sp"><?php echo $lang_fare; ?></span><span class="fr-sp" id="dist"></span></h5>
                                                                <div class="sl-car append_val">
                                                                </div>
																</div>

                                                        </div>

                                                        <div class="col-lg-1">

                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-default btn-continue fare-cont point_to_point" data-validate="second"><?php echo $lang_find_taxi; ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                </div>

                                            </div>
                                            <div class="col-lg-3"></div>
                                        </div>
                                    </div>
                                <div id="menus2" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-8">
                                            <div class="form-mn">
                                                
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_area; ?> </label>
                                                                <input type="text" class="form-control" name="area"  placeholder="Street, Town">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_pickup_address; ?> </label>
                                                                <textarea class="form-control third" id="pickup_address_point" name="pickup_address"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1"><?php echo $lang_enter_promo; ?></label>
                                                                    <div class="row">
                                                                        <div class="col-lg-8">
                                                                            <input type="text" class="form-control" placeholder="Code" name="point_promo" id="point_promo">
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <a href="javascript:void(0)" class="app-new" id="point_promo_check"><?php echo $lang_apply; ?></a>
                                                                        </div>
                                                                        <input type="hidden" id="promo_status_point" name="promo_status_point">
                                                                        
                                                                    </div><br/><div id="promo_status_point_message"></div>
                                                                    <div class="checkbox">
                                                                        <label><input type="checkbox" id="save_address"><?php echo $lang_save_address; ?></label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_landmark; ?></label>
                                                                <input type="text" class="form-control" name="landmark" placeholder="Landmark">
                                                            </div>
                                                        </div>
 


                                                        <div class="col-lg-4">

                                                            <div class="form-group">
                                                                <button type="button" data-validate="third" class="btn btn-default btn-continue point_to_point"><?php echo $lang_booking; ?> </button>
																<!-- <a href="" data-toggle="modal" id="findmytaxi_signin" data-target="#myModalsignup" style="display:none;">.</a> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                              
                                            </div>

                                        </div>
                                        <div class="col-lg-2"></div>
                                    </div>
                                </div>
							
                            </div>
							</form>
							
						<!-- form end-->
							
							
							
							
							
							
                        </div>
                    </div>

                
                        <div id="airport" class="tab-pane fade">
                            <div class="tab-main">
                            <form name="airport_form" id="airport_form">                            
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                        <div class="br-tab"></div>
                                        <ul class="nav nav-tabs nav-tab-find nav-inner-find setup-panels">
                                            <li class="active" id="air_location"><a data-toggle="" href="#homess">
                                                    <h4><img src="<?php echo base_url();?>assets/img/home/loc.png"/></h4>
                                                    <h6><?php echo $lang_location; ?> </h6>
                                                </a></li>
                                            <li id="air_car"><a data-toggle="" href="#menuss1">
                                                    <h4><img src="<?php echo base_url();?>assets/img/home/selcar.png"/></h4>
                                                    <h6><?php echo $lang_selectaxi; ?></h6>
                                                </a>
                                            </li id="air_confirm">
                                            <li><a data-toggle="" href="#menuss2">
                                                    <h4><img src="<?php echo base_url();?>assets/img/home/confirm.png"/></h4>
                                                    <h6><?php echo $lang_confirm; ?></h6>
                                                </a>
                                            </li>
                                        </ul>

                                    </div>
                                    <div class="col-lg-3"></div>
                                </div>
                                <div class="tab-content">
                                    <div id="homess" class="tab-pane fade in active">
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-mn">
                                                    <!-- <form> -->
                                                        <div class="row">
                                                            <div class="col-lg-2"></div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group pad-rad">
                                                                    <div class="radio">
                                                                        <label class="lab-rad"><input type="radio" name="air_trans" value="going" class="air_loc"><?php echo $lang_going_airport; ?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 pad-rad-1">
                                                                <div class="form-group">
                                                                    <div class="radio">
                                                                        <label class="lab-rad"><input type="radio" name="air_trans" value="coming" class="air_loc"><?php echo $lang_coming_airport; ?> </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2"></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4"></div>
                                                            <div class="col-lg-4">
<div class="form-group">                                                            
<select class="form-control air_loc" id="airport_field">
<option value="" selected="selected">Airport</option>
<?php foreach ($air_result as $rs) { ?>
<option value="<?php echo $rs->code; ?>"><?php echo $rs->name; ?></option>
                                           <?php } ?>
                                            
                                            
                                        </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4"></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1" id="airport_label"><?php echo $lang_pickup_area; ?> </label>
                                                                    <input type="text" class="form-control air_loc" id="autocomplete_pick" placeholder="Street, Town" onclick="initialize(this.id)">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1"><?php echo $lang_pickup_date; ?></label>
                                                                    <input type="text" class="form-control date-home-1 air_loc" id="datepicker2" placeholder="Date" name="air_pickup_date">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1"><?php echo $lang_pickup_time; ?></label>
                                                                    <input type="text" class="form-control basicExample air_loc" id="air_pickup_time" placeholder="Time" name="air_pickup_time">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <button type="button" class="btn btn-default btn-continue airport_transfer" data-validate="air_loc"><?php echo $lang_find_taxi; ?></button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <!-- </form> -->
                                                </div>

                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>

                                    </div>
                                    <div id="menuss1" class="tab-pane fade">
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-6">
                                                <div class="form-mn">
                                                    <!-- <form> -->
                                                    <div class="row">

                                                        <div class="col-lg-11">
                                                            <div class="select-car">
                                                                <h5><?php echo $lang_select_car; ?><span class="fr-sp"><?php echo $lang_fare; ?></span><span class="fr-sp" id="air_dist"></span></h5>
                                                                <div class="sl-car">
                                                                    <!-- <div class="form-group">
                                                                        <div class="radio">
                                                                            <label><input type="radio" name="optradio"><span><img src="<?php echo base_url(); ?>assets/img/home/car-vector.png"/></span><span>Sedan</span><span class="pr-car-nw">Rs:80</span><span class="fre-det-mn">Fare Details</span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="radio">
                                                                            <label><input type="radio" name="optradio"><span><img src="<?php echo base_url(); ?>assets/img/home/car-vector.png"/></span><span>SUV’s</span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="radio">
                                                                            <label><input type="radio" name="optradio"><span><img src="<?php echo base_url(); ?>assets/img/home/car-vector.png"/></span><span>Van</span></label>
                                                                        </div>
                                                                    </div> -->

                                                                </div>


                                                            </div>

                                                        </div>

                                                        <div class="col-lg-1">

                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-default btn-continue fare-cont airport_car" data-validate="air_car"><?php echo $lang_find_taxi; ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!-- </form> -->
                                                </div>

                                            </div>
                                            <div class="col-lg-3"></div>
                                        </div>
                                    </div>
                                    <div id="menuss2" class="tab-pane fade">
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-mn">
                                                    <!-- <form> -->
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1"><?php echo $lang_area; ?></label>
                                                                    <input type="text" class="form-control" id="air_area" name="air_area" placeholder="Street, Town">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1"><?php echo $lang_pickup_address; ?></label>
                                                                    <textarea class="form-control" name="air_address" id="air_address"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1"><?php echo $lang_enter_promo; ?></label>
                                                                    <div class="row">
                                                                        <div class="col-lg-8">
                                                                            <input type="text" class="form-control" placeholder="Code" name="air_promo" id="air_promo">
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <a href="javascript:void(0)" class="app-new" id="air_promo_check"><?php echo $lang_apply; ?> </a>
                                                                        </div>
                                                                        <input type="hidden" id="air_promo_status" name="air_promo_status">
                                                                    </div><br/>
                                                                    <div id="air_promo_status_message"></div>
                                                                    <div class="checkbox">
                                                                        <label><input type="checkbox" id="save_address"><?php echo $lang_save_address; ?> </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1"><?php echo $lang_landmark; ?></label>
                                                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Landmark" id="air_land" name="air_land">
                                                                </div>
                                                            </div>

                                                            <!-- <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1">Pickup Time</label>
                                                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Time">
                                                                </div>
                                                            </div> -->


                                                            <div class="col-lg-4">

                                                                <div class="form-group">
                                                                    <button type="button" class="btn btn-default btn-continue air_confirm" id="formDataa"><?php echo $lang_booking; ?></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <!-- </form> -->
                                                </div>

                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        



                    <div id="hourly" class="tab-pane fade">
                        <div class="tab-main">
						<form name="hourlyform" id="hourlyform">
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <div class="br-tab"></div>
                                    <ul class="nav nav-tabs nav-tab-find nav-inner-find ">
                                        <li class="active"><a data-toggle="" href="#homesss">
                                                <h4><img src="<?php echo base_url();?>assets/img/home/loc.png"/></h4>
                                                <h6><?php echo $lang_location; ?></h6>
                                            </a></li>
                                        <li><a data-toggle="" href="#menusss1">
                                                <h4><img src="<?php echo base_url();?>assets/img/home/selcar.png"/></h4>
                                                <h6><?php echo $lang_selectaxi; ?></h6>
                                            </a>
                                        </li>
                                        <li><a data-toggle="" href="#menusss2">
                                                <h4><img src="<?php echo base_url();?>assets/img/home/confirm.png"/></h4>
                                                <h6><?php echo $lang_confirm; ?></h6>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                                <div class="col-lg-3"></div>
                            </div>
                            <div class="tab-content">
                                <div id="homesss" class="tab-pane fade in active">
                                    <div class="row">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6">
                                            <div class="form-mn">
                                                
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_package; ?></label>
															
                                                                <select class="form-control opt-3" id="hour_package" name="hour_package">
																	<?php foreach($package_name as $package){ ?>
                                                                    <option value=" <?php echo $package['id']; ?>"> <?php echo $package['package']; ?></option>
																	<?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_pickup_date; ?></label>
                                                                <input type="text" class="form-control firsts"  name="hour_pickup_date" id="datepicker3" placeholder="Date">
                                                            </div>
                                                        </div>

                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_pickup_area; ?></label>
                                                                <input type="text" class="form-control firsts" onClick="initialize_hour(this.id);" id="pickup_hourly" name="hour_pickup_area" placeholder="Street, Town">
                                                            </div>
                                                        </div>
<input type='hidden' name="driver_lat_hour" id="driver_lat_hour">
						    <input type='hidden' name="driver_lng_hour" id="driver_lng_hour">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_pickup_time; ?></label>
                                                                <input type="text" class="form-control firsts basicExample"  id="pickup_time_hour" name="hour_pickup_time" placeholder="Time">
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-4">

                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-default btn-continue hourly" data-validate="firsts"><?php echo $lang_find_taxi; ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                        <div class="col-lg-3"></div>
                                    </div>
                                </div>
                                <div id="menusss1" class="tab-pane fade">
                                  <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-6">
                                                <div class="form-mn">
                                                    
                                                    <div class="row">

                                                        <div class="col-lg-11">
                                                            <div class="select-car">
                                                                <h5><?php echo $lang_select_car; ?><span class="fr-sp"><?php echo $lang_fare; ?></span> </h5>
                                                                <div class="sl-car append_val_hour">
                                                                  </div>
															</div>

                                                        </div>

                                                        <div class="col-lg-1">

                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-default btn-continue fare-cont hourly" data-validate="seconds"><?php echo $lang_find_taxi; ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                               
                                                </div>

                                            </div>
                                            <div class="col-lg-3"></div>
                                        </div>
                                </div>
                                <div id="menusss2" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-8">
                                            <div class="form-mn">
                                               
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_area; ?></label>
                                                                <input type="text" class="form-control" name="hour_area" id="exampleInputPassword1" placeholder="Street, Town">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_pickup_address; ?></label>
                                                                <textarea class="form-control thirds" id="pickup_address_hour" name="hour_pickup_address"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1"><?php echo $lang_enter_promo; ?></label>
                                                                    <div class="row">
                                                                        <div class="col-lg-8">
                                                                            <input type="text" class="form-control" placeholder="Code" name="hour_promo" id="hour_promo">
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <a href="javascript:void(0)" class="app-new" id="hour_promo_check"><?php echo $lang_apply; ?></a>
                                                                        </div>
                                                                        <input type="hidden" id="promo_status_hour" name="promo_status_hour">
                                                                        
                                                                    </div><br/><div id="promo_status_hour_message"></div>
                                                                    <div class="checkbox">
                                                                        <label><input type="checkbox" id="save_address"><?php echo $lang_save_address; ?></label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_landmark; ?></label>
                                                                <input type="text" class="form-control  " name="hour_landmark"  placeholder="Landmark">
                                                            </div>
                                                        </div>
 


                                                        <div class="col-lg-4">

                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-default btn-continue hourly" data-validate="thirds"><?php echo $lang_find_taxi; ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                        <div class="col-lg-2"></div>
                                    </div>
                                </div>
                            </div>
							</form>
                        </div>
                    </div>
                    <div id="outstation" class="tab-pane fade">
                        <div class="tab-main">
						<form name="out_statation" id="out_statation" method="post">
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <div class="br-tab"></div>
                                    <ul class="nav nav-tabs nav-tab-find nav-inner-find ">
                                        <li class="active" id="out_location"><a data-toggle="" href="#homessss">
                                                <h4><img src="<?php echo base_url();?>assets/img/home/loc.png"/></h4>
                                                <h6><?php echo $lang_location; ?></h6>
                                            </a></li>
                                        <li id="out_car"><a data-toggle="" href="#menussss1">
                                                <h4><img src="<?php echo base_url();?>assets/img/home/selcar.png"/></h4>
                                                <h6><?php echo $lang_selectaxi; ?></h6>
                                            </a>
                                        </li>
                                        <li id="out_confirm"><a data-toggle="" href="#menussss2">
                                                <h4><img src="<?php echo base_url();?>assets/img/home/confirm.png"/></h4>
                                                <h6><?php echo $lang_confirm; ?></h6>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                                <div class="col-lg-3"></div>
                            </div>
                            <div class="tab-content">
                                <div id="homessss" class="tab-pane fade in active">
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-8">
                                            <div class="form-mn setup-content" id="step-1" >
                                                
                                                    <!-- <div class="row">
                                                        <div class="col-lg-2"></div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group pad-rad">
                                                                <div class="radio">
                                                                    <label class="lab-rad"><input type="radio" name="optradio">One way Trip</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 pad-rad-1">
                                                            <div class="form-group">
                                                                <div class="radio">
                                                                    <label class="lab-rad"><input type="radio" name="optradio">Round Trip</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2"></div>
                                                    </div> -->
                                                    <div class="row">
                                                            <div class="col-lg-4"></div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">                                                            
                                                                    <select class="form-control out_loc" id="outstation_field" name="outstation_field">
                                                                        <option value="" selected="selected">Package</option>
                                                                        <?php foreach ($out_result as $rs) { ?>
                                                                            <option value="<?php echo $rs->id; ?>"><?php echo $rs->package; ?></option>
                                                                       <?php } ?>
                                                                        
                                                                        
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4"></div>
                                                        </div>

                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_pickup_area; ?> </label>
                                                                <select class="form-control out_loc" name="out_drop_area" id="out_drop_area">
                                                                    <option value="" selected="selected"> Select Pick Area</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_departure_date; ?></label>
                                                                <input type="text" class="form-control out_loc" id="datepicker_dep" name="datepicker_dep" placeholder="Date">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_return_date; ?></label>
                                                                <input type="text" class="form-control out_loc" id="datepicker_ret" name="datepicker_ret" placeholder="Date">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-default btn-continue" id="out_loc" data-validate="out_loc"><?php echo $lang_find_taxi; ?></button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                
                                            </div>

                                        </div>
                                        <div class="col-lg-2"></div>
                                    </div>

                                </div>
                                <div id="menussss1" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6">
                                            <div class="form-mn setup-content" id="step-2">
                                                
                                                    <div class="row">
                                                        <div class="col-lg-11">
                                                            <div class="select-car">
                                                                <h5><?php echo $lang_select_car; ?><span class="fr-sp"><?php echo $lang_fare; ?> </span><span class="fr-sp" id="out_dist"></span></h5>
                                                                <div class="sl-car" id="out_car_list">
                                                                    <!-- <div class="form-group">
                                                                        <div class="radio">
                                                                            <label><input type="radio" name="optradio"><span><img src="<?php echo base_url();?>assets/img//home/car-vector.png"/></span><span>Sedan</span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="radio">
                                                                            <label><input type="radio" name="optradio"><span><img src="<?php echo base_url();?>assets/img//home/car-vector-1.png"/></span><span>SUV’s</span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="radio">
                                                                            <label><input type="radio" name="optradio"><span><img src="<?php echo base_url();?>assets/img//home/car-vector-2.png"/></span><span>Van</span></label>
                                                                        </div>
                                                                    </div> -->

                                                                </div>


                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-lg-1">

                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-default btn-continue fare-cont outstation_car"><?php echo $lang_find_taxi; ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                            </div>

                                        </div>
                                        <div class="col-lg-3"></div>
                                    </div>
                                </div>
                                <div id="menussss2" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-8">
                                            <div class="form-mn setup-content" id="step-3">
                                              
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_area; ?></label>
                                                                <input type="text" class="form-control" id="out_area" name="out_area" placeholder="Street, Town">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_pickup_address; ?></label>
                                                                <textarea class="form-control" id="out_address" name="out_address"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1"><?php echo $lang_enter_promo; ?></label>
                                                                    <div class="row">
                                                                        <div class="col-lg-8">
                                                                            <input type="text" class="form-control" placeholder="Code" name="out_promo" id="out_promo">
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <a href="javascript:void(0)" class="app-new" id="out_promo_check"><?php echo $lang_apply; ?></a>
                                                                        </div>
                                                                        <input type="hidden" id="out_promo_status" name="out_promo_status">
                                                                        
                                                                    </div><br/><div id="out_promo_status_message"></div>
                                                                    <div class="checkbox">
                                                                        <label><input type="checkbox" id="save_address"><?php echo $lang_save_address; ?></label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_landmark; ?></label>
                                                                <input type="text" class="form-control" id="out_land" name="out_land" placeholder="Landmark">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"><?php echo $lang_pickup_time; ?></label>
                                                                <input type="text" class="form-control basicExample" id="out_pickup" name="out_pickup" placeholder="Time">
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-4">

                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-default btn-continue out_confirm"><?php echo $lang_booking; ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                               
                                            </div>

                                        </div>
                                        <div class="col-lg-2"></div>
                                    </div>
                                </div>
                            </div>
							</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
 


 <div class="container">
    <div class="modal fade" id="myModalwallet" role="dialog">
        <div class="modal-dialog">

            <div class="row">

                <div class="col-lg-12">
                    <div class="modal-content call-back-model-content">
                        <div class="modal-header">
                            <img class="cl-mdl" src="<?php echo base_url('assets/img/callback/1.png'); ?>" class="close" data-dismiss="modal" /> </button>
                            <h4 class="modal-title call-bck-title call-wdl"><span class="wallet-img-mdl"><img src="<?php echo base_url('assets/img/payment/wallet.png'); ?>"/></span>Wallet</h4>
                            <h3 class="call-wdl-1"><!-- Balance<span><i class="fa fa-inr"></i> </span> --></h3>
                        </div>
                        <div class="modal-body">
                               <form name="wallet_get_form" id="wallet_get_form" data-parsley-validate="">
                                <div class="form-group">
                                    <input type="text" class="form-control form-mdl-wallet-amt_one" id="wallet_amount" name="wallet_amount"   placeholder="Enter Amount to be Added in Wallet" required data-parsley-minlength="1" data-parsley-maxlength="5" data-parsley-trigger="keyup" data-parsley-type="digits">
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h6 class="need-log">You need toLoginto check your paytm wallet transactions
                                                associated with your account!</h6>
                                        </div>
                                        <div class="co9l-lg-4">
                                            <button type="button" class="btn btn-default btn-add-money" id="add_money">Add Money </button>
                                        </div>
                                    </div>

                                </div>
                             </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<?php 
 $s =$this->session->userdata('uneaqueid');
 $details=$this->session->userdata('last_booking_details');
$_POST=json_decode($details,true);
 $purpose = $_POST['purpose'];
 $id= $this->session->userdata('bookid');
 $query = $this->db->query(" SELECT * FROM `settings` order by id DESC ");
$row = $query->row('settings');
$str = $row->currency;

$s1 = explode(',',$str);
$km = $row->measurements;
if($purpose == 'Point to Point Transfer'){
$car= $_POST['taxi_type'];
$date = $_POST['pickup_date'];
$time = $_POST['pickup_time'];
$landmark = $_POST['landmark'];
$pickadd = $_POST['pickup_address'];

?>
<div aria-labelledby="point-tab" id="point" class="bookcon in fade active" role="tabpanel">

                            <div class="search-form">
                            <div class="row">
                         
                           
                              
                            	<div class="">
                                <div class="confirmed">
	                    <div style="" class="confirmedhead">
                        <div class="col-sm-7">
	                        <div class="chalf">
	                            <h3><img src="<?php echo base_url();?>assets/images/green-tick.png"/>&nbsp;&nbsp;<strong>Booking in Progress</strong></h3>
                                        <div class="ccid"><!--p class="parabooking">We'll notify you, As soon as we find a cab.</p-->
                                        <h5>Your BOOKING ID is </h5>
                                         <h4><?php echo $s;?></h4>
                                       
                                        <!--a class="modify-booking" href="<?php echo base_url();?>callmycab/edit_booking?id=<?php echo $id;?>">(Modify booking)</a-->
                                        </div>

	                        </div>
                        </div>
                        
                        <div class="col-sm-5">
	                        <div class="chalf2">
                                <div class="cid"><a href="#"><img alt="Track your Booking on your Mobile" src="<?php echo base_url();?>assets/images/booking-process.jpg"></a></div>

	                        </div>
                        </div>
                        
                        
	                    </div>
                        
                        
                        
                        <div class="confirmedcontain">
                          <div class="col-sm-6">
	                        <div class="half-down1">
	                            <div class="subhalf">
	                                <div class="halftitle">Taxi </div>
	                                <div class="halfdetail"> : <?php echo ucfirst($car);?></div>
	                            </div>
	                            <div class="subhalf">
	                                <div class="halftitle">DATE &amp; TIME</div>
	                                <div class="halfdetail"> : <?php echo date('D, d M',strtotime($date));?>,  <?php echo $time;?></div>
	                            </div>
                                <?php
								$query = $this->db->query("SELECT * FROM  cabdetails WHERE 	cartype ='$car' AND transfertype ='$purpose'");
		$row = $query->row('cabdetails');
								?>
	                            <div class="subhalf">
	                                <div class="halftitle">FIRST <?php echo $row->intialkm; ?> <?php echo $km;?></div>
	                                <div class="halfdetail">: <?php echo $s1[1] ;?> <?php echo $row->intailrate; ?>.0 </div>
	                            </div>
                                

                                
	                            <div class="subhalf">
	                                <div class="halftitle">AFTER FIRST <?php echo $row->intialkm; ?> <?php echo $km;?></div>
	                                <div class="halfdetail">: <?php echo $s1[1] ;?> <?php echo $row->standardrate; ?>.0/<?php echo $km;?></div>
	                            </div>
                                
                                <div class="subhalf">
	                                <p class="lastpara">* Final fare payable will include Service Tax.</p>
	                            </div>
	                        </div>
                          </div>
                          
                          <div class="col-sm-6">
	                        <div class="half-down2">
	                            <div class="subhalf">
	                                <div class="halftitle">PICKUP ADDRESS</div>
	                                <div class="halfdetail">
	                                : <?php echo ucfirst($pickadd); ?>
	                                </div>
	                            </div>
	                            <!--div class="subhalf">
	                                <div class="halftitle">DROP ADDRESS:</div>
	                                <div class="halfdetail">
	                                International Container Terminal Road,Eloor
	                                </div>
	                            </div-->
	                            
		                            <div class="subhalf">
		                                <div class="halftitle">LANDMARK</div>
		                                <div class="halfdetail"> : <?php echo ucfirst($landmark); ?></div>
		                            </div>
		                        
	                        </div>
                          </div>
                          
                          
	                    </div>
	                </div>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                </div>                           
                            </div>                          
                            </div>
                           </div>
    <?php
}else if($purpose == 'Airport Transfer'){
$car= $_POST['taxi_type'];
$date = $_POST['pickup_date'];
$time = $_POST['pickup_time'];	
$area = $_POST['area'];	
$flight = $_POST['flight_number'];	
	?>
	<div aria-labelledby="point-tab" id="point" class="bookcon in fade active" role="tabpanel">

                            <div class="search-form">
                            <div class="row">
                         
                                    	
                                  
                              
                            	<div class="">
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                	<div class="confirmed">
	                    <div style="" class="confirmedhead">
                        <div class="col-sm-7">
	                        <div class="chalf">
	                            <h3><img src="<?php echo base_url();?>assets/images/green-tick.png"/>&nbsp;&nbsp;<strong>Booking in Progress</strong></h3>
                                        <div class="ccid"><!--p class="parabooking">We'll notify you, As soon as we find a cab.</p-->
                                        <h5>Your BOOKING ID is </h5>
                                         <h4><?php echo $s;?></h4>
                                        <!--a class="modify-booking" href="<?php echo base_url();?>callmycab/edit_booking?id=<?php echo $id;?>">(Modify booking)</a-->
                                        </div>

	                        </div>
                        </div>
                        
                        <div class="col-sm-5">
	                        <div class="chalf2">
                                <div class="cid"><a href="#"><img alt="Track your Booking on your Mobile" src="<?php echo base_url();?>assets/images/booking-process.jpg"></a></div>

	                        </div>
                        </div>
                        
                        
	                    </div>
                        
                        
                        
                        <div class="confirmedcontain">
                          <div class="col-sm-6">
	                        <div class="half-down1">
	                            <div class="subhalf">
	                                <div class="halftitle">Taxi </div>
	                                <div class="halfdetail"> : <?php echo ucfirst($car);?></div>
	                            </div>
	                            <div class="subhalf">
	                                <div class="halftitle">DATE &amp; TIME</div>
	                                <div class="halfdetail">: <?php echo date('D, d M',strtotime($date));?>,  <?php echo $time;?></div>
	                            </div>
                                <?php
								$query = $this->db->query("SELECT * FROM  cabdetails WHERE 	cartype ='$car' AND transfertype ='$purpose'");
		$row = $query->row('cabdetails');
		  if($_POST['transfer']=='going'){
								?>
                              
                                <h6>Going To Airport</h6>
	                            <div class="subhalf">
	                                <div class="halftitle">FIRST <?php echo $row->intialkm; ?> <?php echo $km;?></div>
	                                <div class="halfdetail"> :<?php echo $s1[1] ;?> <?php echo $row->intailrate; ?>.0 </div>
	                            </div>
                                 <div class="subhalf">
	                                <div class="halftitle">AFTER FIRST <?php echo $row->intialkm; ?> <?php echo $km;?></div>
	                                <div class="halfdetail"> :<?php echo $s1[1] ;?> <?php echo $row->standardrate; ?>.0/<?php echo $km;?></div>
	                            </div>
                                <?php
								}else{
								?>
                                 <h6>Coming from Airport</h6>
                                    <div class="subhalf">
	                                <div class="halftitle">FIRST <?php echo $row->fromintialkm; ?> <?php echo $km;?></div>
	                                <div class="halfdetail"> : <?php echo $s1[1] ;?> <?php echo $row->fromintailrate; ?>.0 </div>
	                            </div>
                                
	                            <div class="subhalf">
	                                <div class="halftitle">AFTER FIRST <?php echo $row->fromintialkm; ?> <?php echo $km;?> </div>
	                                <div class="halfdetail"> : <?php echo $s1[1] ;?> <?php echo $row->fromstandardrate; ?>.0/<?php echo $km;?></div>
	                            </div>
                                <?php
								}
								?>
                                
                                <div class="subhalf">
	                                <p class="lastpara">* Final fare payable will include Service Tax.</p>
	                            </div>
	                        </div>
                          </div>
                          
                          <div class="col-sm-6">
	                        <div class="half-down2">
	                            <div class="subhalf">
	                                <div class="halftitle">AREA</div>
	                                <div class="halfdetail">
	                                : <?php echo ucfirst($area); ?>
	                                </div>
	                            </div>
	                            <div class="subhalf">
	                                <div class="halftitle">FLIGHT NO</div>
	                                <div class="halfdetail">
	                              : <?php echo $flight; ?>
	                                </div>
	                            </div>
	                            
		                            <!--div class="subhalf">
		                                <div class="halftitle">LANDMARK:</div>
		                                <div class="halfdetail">ll</div>
		                            </div-->
		                        
	                        </div>
                          </div>
                          
                          
	                    </div>
	                </div>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                </div>                           
                            </div>                          
                            </div>
                           </div>
<?php
}
else if($purpose == 'Hourly Rental'){
$car= $_POST['taxi_type'];
$date = $_POST['pickup_date'];
$time = $_POST['pickup_time'];	
$landmark = $_POST['landmark'];
$pickadd = $_POST['pickup_address'];
$package = $_POST['package'];
?>
<div aria-labelledby="point-tab" id="point" class="bookcon in fade active" role="tabpanel">

                            <div class="search-form">
                            <div class="row">
                         
                                    	
                                  
                              
                            	<div class="">
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                	<div class="confirmed">
	                    <div style="" class="confirmedhead">
                        <div class="col-sm-7">
	                        <div class="chalf">
	                            <h3><img src="<?php echo base_url();?>assets/images/green-tick.png"/>&nbsp;&nbsp;<strong>Booking in Progress</strong></h3>
                                        <div class="ccid"><!--p class="parabooking">We'll notify you, As soon as we find a cab.</p-->
                                        <h5>Your BOOKING ID is </h5>
                                         <h4><?php echo $s;?></h4>
                                      <!--a class="modify-booking" href="<?php echo base_url();?>callmycab/edit_booking?id=<?php echo $id;?>">(Modify booking)</a-->
                                        </div>

	                        </div>
                        </div>
                        
                        <div class="col-sm-5">
	                        <div class="chalf2">
                                <div class="cid"><a href="#"><img alt="Track your Booking on your Mobile" src="<?php echo base_url();?>assets/images/booking-process.jpg"></a></div>

	                        </div>
                        </div>
                        
                        
	                    </div>
                        
                        
                        
                        <div class="confirmedcontain">
                          <div class="col-sm-6">
	                        <div class="half-down1">
	                            <div class="subhalf">
	                                <div class="halftitle">Taxi </div>
	                                <div class="halfdetail"> : <?php echo ucfirst($car);?></div>
	                            </div>
	                            <div class="subhalf">
	                                <div class="halftitle">DATE &amp; TIME</div>
	                                <div class="halfdetail"> : <?php echo date('D, d M',strtotime($date));?>,  <?php echo $time;?></div>
	                            </div>
                                <?php
								$query = $this->db->query("SELECT * FROM  cabdetails WHERE 	cartype ='$car' AND transfertype ='$purpose' AND package ='$package'");
		$row = $query->row('cabdetails');
								?>
	                            <div class="subhalf">
	                                <div class="halftitle">Rate for <?php echo $row->package; ?></div>
	                                <div class="halfdetail"> : <?php echo $s1[1] ;?> <?php echo $row->standardrate; ?>.0 </div>
	                            </div>
                                

                                
	                            
                                
                                <div class="subhalf">
	                                <p class="lastpara">* Final fare payable will include Service Tax.</p>
	                            </div>
	                        </div>
                          </div>
                          
                          <div class="col-sm-6">
	                        <div class="half-down2">
	                            <div class="subhalf">
	                                <div class="halftitle">PICKUP ADDRESS</div>
	                                <div class="halfdetail">
	                                : <?php echo ucfirst($pickadd); ?>
	                                </div>
	                            </div>
	                            <!--div class="subhalf">
	                                <div class="halftitle">DROP ADDRESS:</div>
	                                <div class="halfdetail">
	                                International Container Terminal Road,Eloor
	                                </div-->
	                            </div>
	                            
		                            <div class="subhalf">
		                                <div class="halftitle">LANDMARK</div>
		                                <div class="halfdetail"> : <?php echo ucfirst($landmark); ?></div>
		                            </div>
		                        
	                        </div>
                          </div>
                          
                          
	                    </div>
	                </div>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                </div>                           
                            </div>                          
                            </div>
                           </div>
                           
<?php
}else {
$car= $_POST['taxi_type'];
$date = $_POST['pickup_date'];
$time = $_POST['pickup_time'];
$transfer1 = $_POST['transfer'];
$landmark = $_POST['landmark'];
$pickadd = $_POST['pickup_address'];
?>
<div aria-labelledby="point-tab" id="point" class="bookcon in fade active" role="tabpanel">

                            <div class="search-form">
                            <div class="row">
                         
                                    	
                                  
                              
                            	<div class="">
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                	<div class="confirmed">
	                    <div style="" class="confirmedhead">
                        <div class="col-sm-7">
	                        <div class="chalf">
	                            <h3><img src="<?php echo base_url();?>assets/images/green-tick.png"/>&nbsp;&nbsp;<strong>Booking in Progress</strong></h3>
                                        <div class="ccid"><!--p class="parabooking">We'll notify you, As soon as we find a cab.</p-->
                                        <h5>Your BOOKING ID is </h5>
                                         <h4><?php echo $s;?></h4>
                                         <!--a class="modify-booking" href="<?php echo base_url();?>callmycab/edit_booking?id=<?php echo $id;?>">(Modify booking)</a-->
                                        </div>

	                        </div>
                        </div>
                        
                        <div class="col-sm-5">
	                        <div class="chalf2">
                                <div class="cid"><a href="#"><img alt="Track your Booking on your Mobile" src="<?php echo base_url();?>assets/images/booking-process.jpg"></a></div>

	                        </div>
                        </div>
                        
                        
	                    </div>
                        
                        
                        
                        <div class="confirmedcontain">
                          <div class="col-sm-6">
	                        <div class="half-down1">
	                            <div class="subhalf">
	                                <div class="halftitle">Taxi </div>
	                                <div class="halfdetail">: <?php echo ucfirst($car);?></div>
	                            </div>
	                            <div class="subhalf">
	                                <div class="halftitle">DATE &amp; TIME</div>
	                                <div class="halfdetail">: <?php echo date('D, d M',strtotime($date));?>,  <?php echo $time;?></div>
	                            </div>
                                <?php
								$query = $this->db->query("SELECT * FROM  cabdetails WHERE 	cartype ='$car' AND transfertype ='$purpose'");
		$row = $query->row('cabdetails');
		                    if($transfer1=='oneway'){
								?>
								
	                            <div class="subhalf">
	                                <div class="halftitle">ONEWAY TRIP</div>
	                                <div class="halfdetail">:<?php echo $s1[1] ;?> <?php echo $row->standardrate; ?>.0 </div>
	                            </div>
                                
                             <?php
							}else{
							?>
                                
	                            <div class="subhalf">
	                                <div class="halftitle">ROUND TRIP</div>
	                                <div class="halfdetail">: <?php echo $s1[1] ;?> <?php echo $row->fromstandardrate; ?>.0</div>
	                            </div>
                                <?php
							}
							?>
                                <div class="subhalf">
	                                <p class="lastpara">* Final fare payable will include Service Tax.</p>
	                            </div>
	                        </div>
                          </div>
                          
                          <div class="col-sm-6">
	                        <div class="half-down2">
	                            <div class="subhalf">
	                                <div class="halftitle">PICKUP ADDRESS</div>
	                                <div class="halfdetail">
	                                : <?php echo ucfirst($pickadd); ?>
	                                </div>
	                            </div>
	                            <!--div class="subhalf">
	                                <div class="halftitle">DROP ADDRESS:</div>
	                                <div class="halfdetail">
	                                International Container Terminal Road,Eloor
	                                </div>
	                            </div-->
	                            
		                            <div class="subhalf">
		                                <div class="halftitle">LANDMARK</div>
		                                <div class="halfdetail"> : <?php echo ucfirst($landmark); ?></div>
		                            </div>
		                        
	                        </div>
                          </div>
                          
                          
	                    </div>
	                </div>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                </div>                           
                            </div>                          
                            </div>
                           </div>
<?php
}
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>           

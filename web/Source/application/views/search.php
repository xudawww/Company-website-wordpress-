  <div class="booking_area">
  <?php
					
					 if(!$results) {
		echo "<div><p style='font-family:sans-serif;font-size:15px;margin-top:12px;text-align:center;'>You don't have any bookings with us. Do you want to book a taxi?</p><div style='text-align:center;'>"; ?>
		<a class='btn-now' href='<?php echo base_url();?>'>Book Now</a></div></div>
		<?php
	}else{
					 foreach($results as $row1) {
					?>
                    	<div class="bkng_darea">
                        <div class="bkng_darea_hd">
                        <div class="row">
                            <div class="col-md-7"> <div class=" bkng_rtfrm"> <?php if($row1->pickup_area){ echo $row1->pickup_area; }else{ echo $row1->pickup_address;}?> </div> <?php echo $row1->drop_area ;?> </div>     
                            <?php if($row1->status=='Booking'){?>
                            <div class="col-md-5">
                            
                            <div class="bkng_hd_icon"> <a href="#"> <img src="<?php echo base_url();?>assets/images/track.png" alt="">  Track </a> </div>
                            <div class="bkng_hd_icon"> <a href="<?php if($row1->status=='Booking'){?><?php echo base_url();?>callmycab/edit_booking?id=<?php echo $row1->id; }?>"><img src="<?php echo base_url();?>assets/images/edit.png" alt=""> Edit </a> </div>
                            <div class="bkng_hd_icon"> <a href="javascript:void(0);" class="cancel"  title="<?php echo $row1->id;?>" ><img src="<?php echo base_url();?>assets/images/cancel.png" alt=""> Cancel </a> </div>
                            </div>
                            <?php }
					
							?>
                            </div>
                            </div>
                            
                            <div class="row">
                            
                            <div class="bkng_darea_listmain">
                            <div class="col-md-2"> <div class="bkng_darea_list"><?php $date = $row1->pickup_date;
							echo date('D, d M',strtotime($date));?><br>

							<?php echo $row1->pickup_time;?> </div> </div>
                            <div class="col-md-3"> <div class="bkng_darea_list"> <?php echo $row1->uneaque_id;?> <p> BOOKING ID </p></div> </div>
                            <div class="col-md-3"> <div class="bkng_darea_list"> <?php echo $row1->taxi_type;?> <p> Car Type </p> </div> </div>
                            <div class="col-md-2">  <div class="bkng_darea_list">&#8377; <?php echo $row1->amount;?> <p> Total Fare </p> </div> </div>
                            <div class="col-md-2"> <div class="bkng_darea_list bkng_bdrnone"> <?php echo $row1->status;?>. </div> </div>
                        </div>
                        </div>
                        </div>
                    <!-- End Box 1 -->
                    <?php
					 }
	}
					 ?>


<nav>
  
  <?php echo $this->pagination->create_links(); ?>
</nav>




 
</div>

<div class="booking_area">
<!-- Box 1 -->
                    <?php
					 if($this->session->userdata('username')){
		$username=$this->session->userdata('username');
		}else{
			$username= $this->input->cookie('username', false);
		}
					$status= $_POST['status'];
					$num_rec_per_page=4;
					if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
					$start_from = ($page-1) * $num_rec_per_page; 
					 $query1 = $this->db->query("SELECT * FROM  bookingdetails WHERE username='$username' AND status='$status' LIMIT $start_from, $num_rec_per_page");
					 foreach($query1->result_array('bookingdetails') as $row1){
					?>
                    	<div class="bkng_darea">
                        <div class="bkng_darea_hd">
                        <div class="row">
                            <div class="col-md-7"> <div class=" bkng_rtfrm"> <?php if($row1['pickup_area']){ echo $row1['pickup_area']; }else{ echo $row1['pickup_address'];}?> </div> <?php echo $row1['drop_area'] ;?> </div>     
                            <?php if($row1['status']=='Booking'){?>
                            <div class="col-md-5">
                            
                            <div class="bkng_hd_icon"> <a href="#"> <img src="<?php echo base_url();?>assets/images/track.png" alt="">  Track </a> </div>
                            <div class="bkng_hd_icon"> <a href="<?php if($row1['status']=='Booking'){?><?php echo base_url();?>index.php/callmycab/edit_booking?id=<?php echo $row1['id']; }?>"><img src="<?php echo base_url();?>assets/images/edit.png" alt=""> Edit </a> </div>
                            <div class="bkng_hd_icon"> <a href="#" class="cancel"  title="<?php echo $row1['id'];?>" ><img src="<?php echo base_url();?>assets/images/cancel.png" alt=""> Cancel </a> </div>
                            </div>
                            <?php }
							?>
                            </div>
                            </div>
                            
                            <div class="row">
                            
                            <div class="bkng_darea_listmain">
                            <div class="col-md-2"> <div class="bkng_darea_list"><?php $date = $row1['pickup_date'];
							echo date('D, d M',strtotime($date));?><br>

							<?php echo $row1['pickup_time'];?> </div> </div>
                            <div class="col-md-3"> <div class="bkng_darea_list"> <?php echo $row1['uneaque_id'];?> <p> BOOKING ID </p></div> </div>
                            <div class="col-md-3"> <div class="bkng_darea_list"> <?php echo $row1['taxi_type'];?> <p> Car Type </p> </div> </div>
                            <div class="col-md-2">  <div class="bkng_darea_list">&#8377; <?php echo $row1['amount'];?> <p> Total Fare </p> </div> </div>
                            <div class="col-md-2"> <div class="bkng_darea_list bkng_bdrnone"> <?php echo $row1['status'];?>. </div> </div>
                        </div>
                        </div>
                        </div>
                    <!-- End Box 1 -->
                    <?php
					 }
					 ?>


 <?php
    $this->db->where('status', $status);
	$this->db->where('username', $username);
	$query3 = $query = $this->db->get("bookingdetails");
	$total_records = $query3->num_rows;
	$total_pages = ceil($total_records / $num_rec_per_page); 
	?>
                    <nav>
  <ul class="pagination">
    <li>
      <a href="<?php echo base_url();?>callmycab/account?page=1" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
  <?php  for ($i=1; $i<=$total_pages; $i++) { ?>
    <li><a href="<?php echo base_url();?>callmycab/account?page=<?php echo $i;?>"><?php echo $i;?></a></li>
  <?php
  }
  ?>
    <li>
      <a href="<?php echo base_url();?>callmycab/account?page=<?php echo $total_pages ; ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>


           
        
     </div>   
                 
<?php
if($_POST['page'])
{
$page = $_POST['page'];
$cur_page = $page;
$page -= 1;
 $per_page = 4;
$previous_btn = true;
$next_btn = true;
$first_btn = true;
$last_btn = true;
$start = $page * $per_page;
 $status =$_POST['status'];
 $item =$_POST['item'];

$query = $this->db->query(" SELECT * FROM `settings` order by id DESC ");
		$row = $query->row('settings');
		
										$str = $row->currency;
										$s = explode(',',$str);
										
if($_POST['date'] != 0){
	$date= $_POST['date'];
 $this->db->where('pickup_date', $date);
}

	  if($username = $this->session->userdata('username')){
        $username = $this->session->userdata('username');
        }else{
        $username = $this->input->cookie('username', false);
        }
 
  
	$this->db->where_in('item_status', array('Completed',''));  
  
$names = array($status, $item);
$this->db->where('username', $username);
$this->db->where_in('status', $names);
$this->db->order_by('id', 'desc'); 
$this->db->limit($per_page,$start);
$query_pag_data = $this->db->get("bookingdetails");



$msg = "";
if($query_pag_data->num_rows()>0){
foreach ($query_pag_data->result() as $row) {
?>
    <div class="bkng_darea data">
                        <div class="bkng_darea_hd">
                        <div class="row">
                            <div class="col-md-7"> <div class=" bkng_rtfrm"> <?php if($row->pickup_area){ echo $row->pickup_area; }else{ echo $row->pickup_address;}?> </div> <?php echo $row->drop_area ;?> </div>     
                            <?php  if($row->item_status==''&& $row->status=='Booking' ){?>
                            <div class="col-md-5">
                            
                            <div class="bkng_hd_icon"> <a href="#"> <img src="<?php echo base_url();?>assets/images/track.png" alt="">  Track </a> </div>
                            <!--div class="bkng_hd_icon"> <a href="<?php echo base_url();?>callmycab/edit_booking?id=<?php echo $row->id; ?>"><img src="<?php echo base_url();?>assets/images/edit.png" alt=""> Edit </a> </div-->
                            <div class="bkng_hd_icon"> <a href="#" class="cancel"  title="<?php echo $row->id;?>" ><img src="<?php echo base_url();?>assets/images/cancel.png" alt=""> Cancel </a> </div>
                            </div>
                            <?php }
							?>
                            </div>
                            </div>
                            
                            <div class="row">
                            
                            <div class="bkng_darea_listmain">
                            <div class="col-md-2"> <div class="bkng_darea_list"><?php $date = $row->pickup_date;
							echo date('D, d M',strtotime($date));?><br>

							<?php echo $row->pickup_time;?> </div> </div>
                            <div class="col-md-3"> <div class="bkng_darea_list"> <?php echo $row->uneaque_id;?> <p> BOOKING ID </p></div> </div>
                            <div class="col-md-3"> <div class="bkng_darea_list"> <?php echo $row->taxi_type;?> <p> Car Type </p> </div> </div>
                            <div class="col-md-2">  <div class="bkng_darea_list"><?php echo $s[1];?> <?php echo $row->amount;?> <p> Total Fare </p> </div> </div>
                            <div class="col-md-2"> <div class="bkng_darea_list bkng_bdrnone"> <?php echo $row->status;?>. </div> </div>
                        </div>
                        </div>
                        </div>                        <?php
}



/* --------------------------------------------- */
 if($username = $this->session->userdata('username')){
        $username = $this->session->userdata('username');
        }else{
        $username = $this->input->cookie('username', false);
        }
		$names = array($status, $item);
 $this->db->where('username', $username);
if($_POST['date']!= 0){
 $this->db->where('pickup_date', $date);
}

$this->db->where_in('item_status', array('Completed',''));  
  
 $this->db->where_in('status', $names);
 
$result_pag_num = $this->db->get("bookingdetails");

$count = $result_pag_num->num_rows();
$no_of_paginations = ceil($count / $per_page);

/* ---------------Calculating the starting and endign values for the loop----------------------------------- */
if ($cur_page >= 7) {
    $start_loop = $cur_page - 3;
    if ($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    } else {
        $end_loop = $no_of_paginations;
    }
} else {
    $start_loop = 1;
    if ($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}
/* ----------------------------------------------------------------------------------------------------------- */
$msg .= "<div class='pagination1'><ul>";

// FOR ENABLING THE FIRST BUTTON
if ($first_btn && $cur_page > 1) {
    $msg .= "<li p='1' class='active'>First</li>";
} else if ($first_btn) {
    $msg .= "<li p='1' class='inactive'>First</li>";
}

// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
    $msg .= "<li p='$pre' class='active'>Previous</li>";
} else if ($previous_btn) {
    $msg .= "<li class='inactive'>Previous</li>";
}
for ($i = $start_loop; $i <= $end_loop; $i++) {

    if ($cur_page == $i)
        $msg .= "<li p='$i' style='color:#fff;background-color:#006699;' class='active'>{$i}</li>";
    else
        $msg .= "<li p='$i' class='active'>{$i}</li>";
}

// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;
    $msg .= "<li p='$nex' class='active'>Next</li>";
} else if ($next_btn) {
    $msg .= "<li class='inactive'>Next</li>";
}

// TO ENABLE THE END BUTTON
if ($last_btn && $cur_page < $no_of_paginations) {
    $msg .= "<li p='$no_of_paginations' class='active'>Last</li>";
} else if ($last_btn) {
    $msg .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
}
$goto = "<input type='text' class='goto' size='1' style='margin-top:-1px;margin-left:60px;'/><input type='button' id='go_btn' class='go_button' value='Go'/>";
$total_string = "<span class='total' a='$no_of_paginations'>Page <b>" . $cur_page . "</b> of <b>$no_of_paginations</b></span>";
$msg = $msg . "</ul>" . $goto . $total_string . "</div>";  // Content for pagination
echo $msg;
}else{
	echo "<div><p style='font-family:sans-serif;font-size:15px;margin-top:12px;text-align:center;'>You don't have any bookings with us. Do you want to book a taxi?</p><div style='text-align:center;'>"; ?>
		<a class='btn-now' href='<?php echo base_url();?>'>Book Now</a></div></div>
		<?php
}
}

?>
<script type="text/javascript">
  
 
$(document).ready(function(){ 

$('.cancel').click(function(){	
							
	var r = confirm("Are you sure want to cancel the booking ");
	if (r == true) {
	var th=$(this);			
	var id = $(this).attr('title');
	var status = "Cancelled";
	
$.ajax({
url:'<?php echo base_url();?>callmycab/cancel',
type:'post',
data:{'id':id,'status':status},
success:function(cancel){
console.log(cancel);
if(cancel==0){
	
	
alert("err");

}
else{
th.hide();
	location.reload();
}
}
});  								
	}
						   
});						   
						   
	});	
</script>	
						   
		
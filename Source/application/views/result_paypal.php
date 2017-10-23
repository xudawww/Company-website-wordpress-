

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <?php
	   $query = $this->db->query(" SELECT * FROM `settings` order by id DESC ");
		$row = $query->row('settings');
		$str = $row->currency;
		 $assigned=$row->mechanic_assigned;
										$s = explode(',',$str);
	  ?>
      <title><?php echo $row->title; ?></title>
       <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
      <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
       <link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet">
      <!-- Bootstrap core CSS -->
      <link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet">
      <link href='<?php echo base_url();?>assets/css?family=Open+Sans' rel='stylesheet' type='text/css'>
      <!-- Custom styles for this template -->
      <link href="<?php echo base_url();?>assets/css/jumbotron.css" rel="stylesheet">
      <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
      <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
         <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script> <!-- Gem jQuery -->
      <!-- Load jQuery UI Main JS  -->
    
      <script src="<?php echo base_url();?>assets/js/ie-emulation-modes-warning.js"></script>
      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      
      <![endif]-->
      
      <link rel="shortcut icon" type="image/icon" href="<?php echo base_url();?><?php echo $row->favicon; ?>"/>
      
      
    <!-- Login -->
    <link href='<?php echo base_url();?>assets/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'> 
 	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/login/style.css"> <!-- Gem style -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/sidebar/component.css"> <!-- Gem style -->
	<script src="<?php echo base_url();?>assets/js/login/modernizr.js"></script> <!-- Modernizr -->
    <script src="<?php echo base_url();?>assets/js/login/main.js"></script> <!-- Gem jQuery -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> 
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

    <!--datepicker-->
    <!-- Load jQuery from Google's CDN -->
    <!-- Load jQuery UI CSS  -->
    
     
      
      

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    
    
    
      
   <!--google map-->
            <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
         

        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
       

         
      
      
      
   </head>
   <body onLoad="initialize()" class="bnr-404"> 
   <!-- Side Bar -->
              <?php
			 if($row->sidebar=='Vertical'){
			 include"includes/callmycab_sidebar.php"; }
			 ?>
              <!-- End Side Bar  -->
     <div class="jumbotron <?php if($row->sidebar=='Vertical'){ echo "verticalcal";}?>">
        
         <div class="bnr-404">
       
     <?php
	 if($row->sidebar=='Horizontal'){
			 include "includes/callmycab_horizontal.php"; 
			 }
	  include "includes/farechart.php";
	 include "includes/callmycab_header.php";
	 ?>
      <!-- Main jumbotron for a primary marketing message or call to action -->
    
            <div class="container">
            <div class="secssion1">
               <div class="row">
                  <div class="col-md-12">
                   <?php



				   //print_r($_POST);
 $km = $row->measurements;
 if(isset($_POST['txn_id'])){
 $item_transaction = $_POST['txn_id'];
 $status = $_POST['payment_status'];
 $item_no = $_POST['item_number'];
  $amount = $_POST['payment_gross'];
 $query = $this->db->query("SELECT * FROM  bookingdetails  WHERE    uneaque_id ='$item_no' ");
        $row = $query->row('bookingdetails');
		$purpose =$row->purpose;
		$taxitype=$row->taxi_type; 
		$timetype=$row->timetype; 
	if($purpose == 'Point to Point Transfer'){

?>   
                     <div class="return_outer">
                       
                    
					  
					  
					  
                          <div class="return_outer_hd">
                          
                              <div class="col-md-8"> 
                              <h1> Payment Successful </h1>
                              <p> Your Booking ID is <br>
                              <span class="returnid"> <?php echo $item_transaction;?> </span>
							 
                              </p>
                              </div>
                              <div class="col-md-4"> <div class="return_outer_app"></div> </div>
                          
                          </div>
                      
                      
                      <?php
					  $date = $row->pickup_date; 
                      $time = $row->pickup_time; 
					  ?>
                      
                      
                      
                           <div class="return_outer_clm2">
                           		<div class="col-md-6">
                                <div class="rtun_clm2_lft">
                                <ul>
                                <li> <div class="rtun_clm2_lftrw1"> Taxi	</div>	<div class="rtun_clm2_lftrw2"> :<?php echo ucfirst($row->taxi_type); ?>  </div></li>
								
								<li> <div class="rtun_clm2_lftrw1"> Date & Time 	</div>	<div class="rtun_clm2_lftrw2"> : <?php echo date('D, d M',strtotime($date));?>,  <?php echo $time;?> </div></li>
                           <li> <div class="rtun_clm2_lftrw1"> Amount	</div>	<div class="rtun_clm2_lftrw2"> : $.<?php echo $amount; ?>  </div></li>
								<li> <div class="rtun_clm2_lftrw1"> Total <?php echo $km;?>	</div>	<div class="rtun_clm2_lftrw2"> : <?php echo $row->km; ?>  </div></li>
                                
						   <?php
						   $query1 = $this->db->query("SELECT * FROM  cabdetails WHERE     cartype ='$taxitype' AND transfertype ='$purpose' AND timetype='$timetype'");
        $row1 = $query1->row('cabdetails');
?>						   
								
								
								<li> <div class="rtun_clm2_lftrw1"> First <?php echo $row1->intialkm; ?> <?php echo $km;?> 	</div>	<div class="rtun_clm2_lftrw2"> : <?php echo $s[1] ;?>.  <?php echo $row1->intailrate; ?>.0 </div></li>
                                <li> <div class="rtun_clm2_lftrw1"> After First <?php echo $row1->intialkm; ?> <?php echo $km;?> 	</div>	<div class="rtun_clm2_lftrw2"> : <?php echo $s[1] ;?>.<?php echo $row1->standardrate; ?>.0/<?php echo $km;?> </div></li>
                                </ul>
                                </div>
                                </div>
                                
                                <div class="col-md-6">
                                
                             
                                <div class="rtun_clm2_rht">
                                <ul>
                                <li> <div class="rtun_clm2_lftpickup"> PICKUP ADDRESS	</div>	<div class="rtun_clm2_lftland"> : <?php echo ucfirst($row->pickup_address); ?> </div></li>
                                <li> <div class="rtun_clm2_lftpickup"> LANDMARK 	</div>	<div class="rtun_clm2_lftland"> :  <?php echo ucfirst($row->landmark); ?> </div></li>
                              
                                </ul>
                                </div>
                                </div>
                           </div>
					  
					  
					  
                      		<div class="rturn_otr_tax"> *Final fare payable will include service tax </div>
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
                       <div>
                      </div>
                      </div>
					  
					  
					  
					  
					  
					  
					  <?php
	}else if($purpose == 'Airport Transfer'){
		?>
		
		
		
		
		
		 <div class="return_outer">
                       
                    
					  
					  
					  
                          <div class="return_outer_hd">
                          
                              <div class="col-md-8"> 
                              <h1> Payment Successful </h1>
                              <p> Your Booking ID is <br>
                              <span class="returnid"> <?php echo $item_transaction;?> </span>
                              </p>
                              </div>
                              <div class="col-md-4"> <div class="return_outer_app"></div> </div>
                          
                          </div>
                      
                      
                      <?php
					  $date = $row->pickup_date; 
                      $time = $row->pickup_time; 
					  ?>
                      
                      
                      
                           <div class="return_outer_clm2">
                           		<div class="col-md-6">
                                <div class="rtun_clm2_lft">
                                <ul>
                                <li> <div class="rtun_clm2_lftrw1"> Taxi	</div>	<div class="rtun_clm2_lftrw2"> :<?php echo ucfirst($row->taxi_type); ?>  </div></li>
								
								<li> <div class="rtun_clm2_lftrw1"> Date & Time 	</div>	<div class="rtun_clm2_lftrw2"> : <?php echo date('D, d M',strtotime($date));?>,  <?php echo $time;?> </div></li>
                           <li> <div class="rtun_clm2_lftrw1"> Amount	</div>	<div class="rtun_clm2_lftrw2"> :$.<?php echo $amount; ?>  </div></li>
								<li> <div class="rtun_clm2_lftrw1"> Total <?php echo $km;?>	</div>	<div class="rtun_clm2_lftrw2"> : <?php echo $row->km; ?>  </div></li>
                                
						   <?php
						   $query1 = $this->db->query("SELECT * FROM  cabdetails WHERE     cartype ='$taxitype' AND transfertype ='$purpose' AND timetype='$timetype'");
        $row1 = $query1->row('cabdetails');
		
		if($row->transfer=='going'){
?>						   
								
								
								<li> <div class="rtun_clm2_lftrw1"> First <?php echo $row1->intialkm; ?> <?php echo $km;?>	</div>	<div class="rtun_clm2_lftrw2"> : <?php echo $s[1] ;?>.  <?php echo $row1->intailrate; ?>.0 </div></li>
                                <li> <div class="rtun_clm2_lftrw1"> After First <?php echo $row1->intialkm; ?> <?php echo $km;?>	</div>	<div class="rtun_clm2_lftrw2"> : <?php echo $s[1] ;?>.<?php echo $row1->standardrate; ?>.0/<?php echo $km;?> </div></li>
	<?php	}else{
	?>
	<li> <div class="rtun_clm2_lftrw1"> First <?php echo $row1->fromintialkm; ?> <?php echo $km;?>	</div>	<div class="rtun_clm2_lftrw2"> : <?php echo $s[1] ;?>.  <?php echo $row1->fromintailrate; ?>.0 </div></li>
                                <li> <div class="rtun_clm2_lftrw1"> After First <?php echo $row1->fromintialkm; ?> <?php echo $km;?>	</div>	<div class="rtun_clm2_lftrw2"> : <?php echo $s[1] ;?>.<?php echo $row1->fromstandardrate; ?>.0/<?php echo $km;?> </div></li>
	
	<?php
	}
	?>
                                </ul>
                                </div>
                                </div>
                                
                                <div class="col-md-6">
                                
                             
                                <div class="rtun_clm2_rht">
                                <ul>
                                <li> <div class="rtun_clm2_lftpickup"> PICKUP ADDRESS	</div>	<div class="rtun_clm2_lftland"> : <?php echo ucfirst($row->pickup_address); ?> </div></li>
                                <li> <div class="rtun_clm2_lftpickup"> FLIGHT NO	</div>	<div class="rtun_clm2_lftland"> :  <?php echo $row->flight_number; ?> </div></li>
                              
                                </ul>
                                </div>
                                </div>
                           </div>
					  
					  
					  
                      		<div class="rturn_otr_tax"> *Final fare payable will include service tax </div>
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
                       <div>
                      </div>
                      </div>
					  
					  
					  
		
		
		
		
		
		
		
		
		
		<?php
	}else if($purpose == 'Hourly Rental'){
	?>
					  
					  
					  
					 
		 <div class="return_outer">
                       
                    
					  
					  
					  
                          <div class="return_outer_hd">
                          
                              <div class="col-md-8"> 
                              <h1> Payment Successful </h1>
                              <p> Your Booking ID is <br>
                              <span class="returnid"> <?php echo $item_transaction;?> </span>
                              </p>
                              </div>
                              <div class="col-md-4"> <div class="return_outer_app"></div> </div>
                          
                          </div>
                      
                      
                      <?php
					  $date = $row->pickup_date; 
                      $time = $row->pickup_time; 
					  ?>
                      
                      
                      
                           <div class="return_outer_clm2">
                           		<div class="col-md-6">
                                <div class="rtun_clm2_lft">
                                <ul>
                                <li> <div class="rtun_clm2_lftrw1"> Taxi	</div>	<div class="rtun_clm2_lftrw2"> :<?php echo ucfirst($row->taxi_type); ?>  </div></li>
								
								<li> <div class="rtun_clm2_lftrw1"> Date & Time 	</div>	<div class="rtun_clm2_lftrw2"> : <?php echo date('D, d M',strtotime($date));?>,  <?php echo $time;?> </div></li>
                           <li> <div class="rtun_clm2_lftrw1"> Amount	</div>	<div class="rtun_clm2_lftrw2"> : $.<?php echo $amount; ?>  </div></li>
								<li> <div class="rtun_clm2_lftrw1"> Package	</div>	<div class="rtun_clm2_lftrw2"> : <?php echo $row->package; ?>  </div></li>
                                
						  
                                </ul>
                                </div>
                                </div>
                                
                                <div class="col-md-6">
                                
                             
                                <div class="rtun_clm2_rht">
                                <ul>
                                <li> <div class="rtun_clm2_lftpickup"> PICKUP ADDRESS	</div>	<div class="rtun_clm2_lftland"> : <?php echo ucfirst($row->pickup_address); ?> </div></li>
                                <li> <div class="rtun_clm2_lftpickup"> LANDMARK	</div>	<div class="rtun_clm2_lftland"> :  <?php echo ucfirst($row->landmark); ?> </div></li>
                              
                                </ul>
                                </div>
                                </div>
                           </div>
					  
					  
					  
                      		<div class="rturn_otr_tax"> *Final fare payable will include service tax </div>
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
                       <div>
                      </div>
                      </div>
					   
					  
					  
					  
					  
	<?php
	}else {
?>	

<div class="return_outer">
                       
                    
					  
					  
					  
                          <div class="return_outer_hd">
                          
                              <div class="col-md-8"> 
                              <h1> Payment Successful </h1>
                              <p> Your Booking ID is <br>
                              <span class="returnid"> <?php echo $item_transaction;?> </span>
                              </p>
                              </div>
                              <div class="col-md-4"> <div class="return_outer_app"></div> </div>
                          
                          </div>
                      
                      
                      <?php
					  $date = $row->pickup_date; 
                      $time = $row->pickup_time; 
					  ?>
                      
                      
                      
                           <div class="return_outer_clm2">
                           		<div class="col-md-6">
                                <div class="rtun_clm2_lft">
                                <ul>
                                <li> <div class="rtun_clm2_lftrw1"> Taxi	</div>	<div class="rtun_clm2_lftrw2"> :<?php echo ucfirst($row->taxi_type); ?>  </div></li>
								
								<li> <div class="rtun_clm2_lftrw1"> Date & Time 	</div>	<div class="rtun_clm2_lftrw2"> : <?php echo date('D, d M',strtotime($date));?>,  <?php echo $time;?> </div></li>
                           <li> <div class="rtun_clm2_lftrw1"> Amount	</div>	<div class="rtun_clm2_lftrw2"> : $.<?php echo $amount; ?>  </div></li>
								
                                
						   <?php
						   $query1 = $this->db->query("SELECT * FROM  cabdetails WHERE     cartype ='$taxitype' AND transfertype ='$purpose' AND timetype='$timetype'");
        $row1 = $query1->row('cabdetails');
		
if($row->transfer=='oneway'){
?>						   
								
								
								<li> <div class="rtun_clm2_lftrw1"> ONEWAY TRIP	</div>	<div class="rtun_clm2_lftrw2"> : <?php echo $s[1] ;?>.  <?php echo $row1->standardrate; ?>.0 </div></li>
                                
	<?php	}else{
	?>
	
                                <li> <div class="rtun_clm2_lftrw1"> ROUND TRIP	</div>	<div class="rtun_clm2_lftrw2"> : <?php echo $s[1] ;?>.<?php echo $row1->fromstandardrate; ?>.0 </div></li>
	
	<?php
	}
	?>
                                </ul>
                                </div>
                                </div>
                                
                                <div class="col-md-6">
                                
                             
                                <div class="rtun_clm2_rht">
                                <ul>
                                <li> <div class="rtun_clm2_lftpickup"> PICKUP ADDRESS	</div>	<div class="rtun_clm2_lftland"> : <?php echo ucfirst($row->pickup_address); ?> </div></li>
                                <li> <div class="rtun_clm2_lftpickup"> LANDMARK	</div>	<div class="rtun_clm2_lftland"> :  <?php echo ucfirst($row->landmark); ?> </div></li>
                              
                                </ul>
                                </div>
                                </div>
                           </div>
					  
					  
					  
                      		<div class="rturn_otr_tax"> *Final fare payable will include service tax </div>
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
                       <div>
                      </div>
                      </div>
					   


					  
	<?php
	}
 }
?>	
					  
                  </div>
                
                  
                 
                  
               </div>
            </div>
         </div>
      </div>
      </div>
      <!-- column1-->
      
      <!--/column1-->
      <!-- column2-->
      
    
<form method='post' style='display:none;'>
<input type="hidden" id='item_no' value='<?php echo $item_no;?>'>
<input type="hidden" id='item_transaction' value='<?php echo $item_transaction;?>'>
<input type="hidden" id='item_status' value='<?php echo $status;?>'>
<input type="hidden" id='item_amount' value='<?php echo $amount;?>'>
<input type='button' value="submit" id="paypal">
</form>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>           
<script>
$(document).ready(function() {

	
	var a = $('#item_transaction').val();
	var b = $('#item_status').val();
	var c = $('#item_no').val();
	
	
	
	$.ajax({
url:'<?php echo base_url();?>callmycab/addpaypal',
type:'post',
data:{'a':a,'b':b,'c':c},
success:function(book){
console.log(book);
if(book==1){
	 select_driver();
//alert('Payment Successful');
//$('.resultid').html('Payment Successful');
}else {
//alert('Payment Error');
//$('.resultid').html('Payment Error');
}

}
});
});	
function select_driver(){
	var driver_on ="<?php echo $assigned;  ?>";
	if(driver_on =='on'){
		
	var c = $('#item_no').val();
	$.ajax({
url:'<?php echo base_url();?>admin/select_driver',
type:'post',
data:{'c':c},
success:function(book){
console.log(book);
if(book==1){
//alert('Payment Successful');
//$('.resultid').html('Payment Successful');
}else {
//alert('Payment Error');
//$('.resultid').html('Payment Error');
}

}
});
	}
}
	


</script>



      
      
      
      
      
      
      
      
      
      
      
     
      
      
      <!--/column1-->
      <!-- /container -->
      <!-- Bootstrap core JavaScript
         ================================================== -->
         <!--timepicker-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-timepicker.css"/>
<!-- Load jQuery JS -->
<script src="<?php echo base_url();?>assets/js/jquery-timepicker.js"></script>
<!-- Load jQuery UI Main JS -->
<script src="<?php echo base_url();?>assets/js/jquery-timepicker-min.js"></script>
<!--end timepicker-->

      <!-- Placed at the end of the document so the pages load faster -->
      <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <script src="<?php echo base_url();?>assets/js/ie10-viewport-bug-workaround.js"></script>
      
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" />
        <script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
        
        
        
        
        
        
  
        
     
   </body>
</html>


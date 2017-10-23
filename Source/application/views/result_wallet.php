

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


?>   
                     <div class="return_outer">
                       
                    
					  
					  
					  
                          <div class="return_outer_hd">
                          
                              <div class="col-md-8"> 
                              <h1> Your wallet has added $<?php echo $amount;?> in your  wallet</h1>
                              <p> Your Booking ID is <br>
                              <span class="returnid"> <?php echo $item_transaction;?> </span>
							 
                              </p>
                              </div>
                              
                          
                          </div>
                      
                      
                    
					  
					  
                      		<div class="rturn_otr_tax"> *Final fare payable will include service tax </div>
					  
					  
					  
					  
					  
					  
 <?php
 }
?> 
					  
					  
					  
                       <div>
                      </div>
                      </div>
					  
					  
					  
					  
			
					  
                  </div>
                
                  
                 
                  
               </div>
            </div>
         </div>
      </div>
      </div>
      <!-- column1-->
      
      <!--/column1-->
      <!-- column2-->
      
    
<form method='post' style='display:none;' id="transaction">
<input type="hidden"  id='item_no' value='<?php echo $item_no;?>'>
<input type="hidden" name ="item_no" id='item_transaction' value='<?php echo $item_transaction;?>'>
<input type="hidden" name="status" id='item_status' value='<?php echo $status;?>'>
<input type="hidden" name="amount" id='item_amount' value='<?php echo $amount;?>'>
<input type="hidden" name="username"  value='<?php echo $this->session->userdata('username');?>'>
<input type='button' value="submit" id="paypal">
</form>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>           
<script>
$(document).ready(function() {

	var form =$('#transaction').serializeArray();
	
	
	
	
	$.ajax({
url:'<?php echo base_url();?>wallet/add_amount_wallet',
type:'post',
data:form,
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

        
        
        
        
        
        
  
        
     
   </body>
</html>


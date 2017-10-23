

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
      
      <link rel="shortcut icon" type="image/icon" href="<?php echo base_url();?>assets/images/favicon.ico"/>
      
      
    <!-- Login -->
    <link href='<?php echo base_url();?>assets/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'> 
 	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/login/style.css"> <!-- Gem style -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/sidebar/component.css"> <!-- Gem style -->
	<script src="<?php echo base_url();?>assets/js/login/modernizr.js"></script> <!-- Modernizr -->
    <script src="<?php echo base_url();?>assets/js/login/main.js"></script> <!-- Gem jQuery -->
    
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
			 include "includes/callmycab_sidebar.php"; }
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
                   
                     <div class="return_outer">
                       
                    
					  
					  
					  
                          <div class="return_outer_hdcncl">
                          
                              <div class="col-md-8"> 
                              <h1> Payment Failed </h1>
                              
							 
                            
                              </div>
                              <div class="col-md-4"> <div class="return_outer_app"></div> </div>
                          
                          </div>
                      
                     
					  
					  
                       <div>
                      </div>
                      </div>
					  
					  
					  
					  
					  
				
                  
               </div>
            </div>
         </div>
      </div>
      </div>
   

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>           

         <!--timepicker-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-timepicker.css"/>
<!-- Load jQuery JS -->
<script src="<?php echo base_url();?>assets/js/jquery-timepicker.js"></script>
<!-- Load jQuery UI Main JS -->
<script src="<?php echo base_url();?>assets/js/jquery-timepicker-min.js"></script>
<!--end timepicker-->
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?php echo base_url();?>assets/js/ie10-viewport-bug-workaround.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" />
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>

<script>
$(document).ready(function() {

	
	var item_status = "<?php echo $_GET['id']; ?>";
	
	
	
	$.ajax({
url:'<?php echo base_url();?>callmycab/update_itemstatus',
type:'post',
data:{'item_status':item_status},
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
	
	
	
	
});	

</script>

</body>
</html>


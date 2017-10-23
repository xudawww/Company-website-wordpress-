

<!DOCTYPE html>
<html >
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
		$mesr = $row->measurements;
										$str = $row->currency;
										$s = explode(',',$str);
										$paypal = $row->paypal_option;
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
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/parsley/parsley.css"> <!-- Gem style -->
	<script src="<?php echo base_url();?>assets/js/login/modernizr.js"></script> <!-- Modernizr -->
    <script src="<?php echo base_url();?>assets/js/login/main.js"></script>
      
      
   </head>
   <body class="about-us1">
   <?php
			 if($row->sidebar=='Vertical'){
			}
			 ?>
     <div class="jumbotron about-sw ">
      
     
         <div class="bnr">
           <?php
		    include "includes/farechart.php";
	 include "includes/callmycab_header.php";
	 if($row->sidebar=='Horizontal'){
			 }
	 
	 ?>
     
            <!--/.navbar-collapse -->
         </div>
      </nav>
      <!-- Main jumbotron for a primary marketing message or call to action -->
    
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
 <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?php echo base_url();?>assets/js/ie10-viewport-bug-workaround.js"></script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" />
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
            <div class="container">
            <div class="secssion1">

               
                <!-- My Account -->
               
               
               <div class="col-md-12">
               		<div class="row">
               		<div class="myaccount about">
                    
                    
                    </div>
                    
                    
                    <!--about us-->
                    
                    
                    <div class="aboutus">
                      <div class="img-abt">
                        <div class="col-lg-4">
                        	<div class="bg-about">
                            	<h3 class="head-abt">Feedback</h3>
                            </div>
                        </div>
                       </div>
					   
 <div class="loader"></div>
                       
                       <div class="para-abt">
					   <div class="result"></div>
					  <p class="para-content"><?php 
echo "Thank you for your feedback!";
?></p>
                       		
                       </div>
                                                                  
                    </div>
                    
                    
                    <!--/about us-->
                    
                    
                    </div>
               </div>
                    
                    
                    </div>
                    </div>
               </div>
               <!--/My Account--> 
               
               
                 
                  
               </div>
            </div>
         </div>
 
      <!-- column1-->
      <!--/column1-->
      
      
      <!-- column2-->

    
     <script src="<?php echo base_url();?>assets/js/parsley.min.js"></script> 
      
      
  <script type="text/javascript">
  
 
$(document).ready(function(){ 
$(".loader").hide();

 $("#button").on('click',function(){
   if ($('#myForm').parsley().validate() ) {
	   $(".loader").show();
	   var form =$('#myForm').serializeArray();
	   $.ajax({
			type:'post',
            url:'<?php echo base_url();?>callmycab/contact_us_details',
            dataType: 'json',
            data:form,
			
            success:function(res){
				$(".loader").hide();
            var s = res.message;
			
			
           if(res.status=='failed'){
	            var appndData = "<span class='error1 '>"+ s +"</span>";
	            $('.result').html(appndData);
            }else{
	           $('.result').html("<span class='success1 '>"+ s +"</span>");
			   
            }


        }
		 });
	
   }
});
				 });
			
	
			
			</script>
    
    
      
      <!--/column1-->
      <!-- /container -->
      <!-- Bootstrap core JavaScript
   
      
      
   </body>
</html>

<?php

if($username = $this->session->userdata('username') || $this->input->cookie('username', false)){
	
 $id = $_GET['id'];
 
	
?>


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
		$mesr = $row->measurements;
										$str = $row->currency;
										$s = explode(',',$str);
	  ?>
      <title><?php echo $row->title; ?></title>
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
    
    
    <!--datepicker-->
    <!-- Load jQuery from Google's CDN -->
    <!-- Load jQuery UI CSS  -->
    
    
    
    
    
      
     <!--google map-->
            <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
         

         <script src="http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false" ></script>
         
       
       <?php
	   if($row->places =='google'){
		   ?>
        <script type="text/javascript">
		function initialize(id) {
//alert(id);
var cntry = document.getElementById('countryin').value;
 
var options = {
types: ['(cities)'],
  componentRestrictions: {country: cntry}
 };

 var input = document.getElementById(id);
 var autocomplete = new google.maps.places.Autocomplete(input, options);
  //var autocomplete1 = new google.maps.places.Autocomplete(input, options);
  
}
   google.maps.event.addDomListener(window, 'load', initialize);
            
			
			
			
	
	
			
			
			
			
			
        </script>
<?php
	   }else{
	   ?>
          <script type="text/javascript">
                $(document).ready(function(){
                    $(".auto-place").autocomplete({
						
						
                        source:'<?php echo base_url();?>admin/auto_places',
                        minLength:1
                    });
					 
					
					
                });
        </script>
      <?php
	   }
	   ?>
    <script>
	  jQuery(document).ready(function(){
	  var analatic= jQuery('#analatic_code').val();
	  
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');


ga('create', analatic, 'auto');
ga('send', 'pageview');
});
</script>

        
      
      
   </head>
   <body onLoad="initialize()">
  <?php
			 if($row->sidebar=='Vertical'){
			 include "includes/callmycab_sidebar.php"; }
			 ?>
     <div class="jumbotron <?php if($row->sidebar=='Vertical'){ echo "verticalcal";}?>">
          
    <div class="bnr">
     <?php
	 if($row->sidebar=='Horizontal'){
			 include "includes/callmycab_horizontal.php"; }
	 include "includes/farechart.php";
	 include"includes/myaccount_header.php";
	 $textFile= $row->languages;
     $extension = ".php";
     $filename='includes/'.$textFile.$extension;
 
     if (file_exists($filename)) {
     include 'includes/'.$textFile.$extension;
     }else{
     include 'includes/en_lang.php'; 
     }
	 ?>
            <!--/.navbar-collapse -->
         
      </nav>
      <!-- Main jumbotron for a primary marketing message or call to action -->
    
            <div class="container">
            <div class="secssion1">
               <div class="row">
                  <div class="col-md-7">
				  <input type="hidden" id="tab-id" value="1">
				  <input type='hidden' value='<?php echo $row->measurements;?>' id='distance_unit'>
                  
				 <input type='hidden' value='<?php echo $row->analatic_code;?>' id='analatic_code'>
                  
				   <input type='hidden' value='<?php echo $row->country;?>' id='countryin'>
              
                     <?php
						
						  if($this->session->userdata('username')){
		$username=$this->session->userdata('username');
		}else{
			$username= $this->input->cookie('username', false);
		}
		 $query = $this->db->query("SELECT * FROM  bookingdetails WHERE username='$username' AND id ='$id'");
		 $row = $query->row('bookingdetails');
						 ?>
               <input type='hidden' value='' id='distance_place'>
				   <input type='hidden' value='' id='day_night'>          
                  
                     <div data-example-id="togglable-tabs" role="tabpanel" class="bs-example bs-example-tabs">
                        <ul role="tablist" class="nav nav-tabs" id="myTab">
                           <li class="<?php if($row->purpose=='Point to Point Transfer'){echo "active";}?>" role="presentation"><a aria-expanded="true" aria-controls="point" data-toggle="<?php if($row->purpose=='Point to Point Transfer'){echo "tab";}?>" role="tab" id="point-tab" href="#<?php if($row->purpose=='Point to Point Transfer'){echo "point";}?>"><img src="<?php echo base_url();?>assets/images/tab1.png"/>&nbsp;&nbsp;<?php echo $point_topoint; ?></a></li>
                           <li role="presentation" class="<?php if($row->purpose=='Airport Transfer'){echo "active";}?>"><a aria-controls="airport" data-toggle="<?php if($row->purpose=='Airport Transfer'){echo "tab";}?>" id="airport-tab" role="tab" href="#<?php if($row->purpose=='Airport Transfer'){echo "airport";}?>" aria-expanded="false"><img src="<?php echo base_url();?>assets/images/tab2.png"/>&nbsp;&nbsp;<?php echo $airport_transfer; ?></a></li>
                           <li role="presentation" class="<?php if($row->purpose=='Hourly Rental'){echo "active";}?>"><a aria-controls="hourly" data-toggle="<?php if($row->purpose=='Hourly Rental'){echo "tab";}?>" id="hourly-tab" role="tab" href="#<?php if($row->purpose=='Hourly Rental'){echo "hourly";}?>" aria-expanded="false"><img src="<?php echo base_url();?>assets/images/tab3.png"/>&nbsp;&nbsp;<?php echo $hourly_rental; ?></a></li>
                           <li role="presentation" class="<?php if($row->purpose=='Outstation Transfer'){echo "active";}?>"><a aria-controls="outstation" data-toggle="<?php if($row->purpose=='Outstation Transfer'){echo "tab";}?>" id="outstation-tab" role="tab" href="#<?php if($row->purpose=='Outstation Transfer'){echo "outstation";}?>" aria-expanded="false"><img src="<?php echo base_url();?>assets/images/tab4.png"/>&nbsp;&nbsp;<?php echo $out_station; ?></a></li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                        
                         <div class="conrep"></div>
                        <?php 
						if($row->purpose=='Point to Point Transfer'){
						?>
                        
                           <div aria-labelledby="point-tab" id="point" class="hidecon tab-pane in fade <?php if($row->purpose=='Point to Point Transfer'){echo "active";}?>" role="tabpanel">
                            <div class="search-form" id="test1">
                            <div class="row">
                         
                         
                      
                         
                         
                                    	<div class="arrow-toptab">
                                    	<ul class="arrow-toptablist">
                                        		<li class="inactivearrow-toptablist2 finished ps1"><?php echo $locations; ?></li>
                                               <li class="inactivearrow-toptablist2 ps2 point-tab1"><?php echo $select_taxi; ?></li>
                                               <li class="inactivearrow-toptablist2 ps3"><?php echo $confirm_booking; ?></li>
                                        </ul>
                                        
                                    </div>
                                  
                              
                            	<div class="col-sm-6 pstep1">
                                
                                	
                                
                                	<p class="para-head"><?php echo $pickup_area; ?></p>
                                	<input type="text" class="field1 common2 samples" name="email1" placeholder="Starting" id="autocomplete" autocomplete="on" onClick="initialize(this.id);" value="<?php echo $row->pickup_area; ?>">
                                    
                                    <p class="para-head"><?php echo $pickup_date; ?></p>
                                	<input type="text" class="field2 pickdate datepicker common2" name="email1" placeholder="" id="datepickerp" value="<?php echo $row->pickup_date; ?>">
                                </div>                           
                            	<div class="col-sm-6 pstep1">
                                	<p class="para-head"><?php echo $drop_area; ?></p>
                                	<input type="text" class="field3 common2 samples" name="email1" placeholder="Destination" id="autocomp" autocomplete="on" onClick="initialize(this.id);" value="<?php echo $row->drop_area; ?>">
                                    
                                    <p class="para-head"><?php echo $pickup_time; ?></p>
                                	<div class="time_div"><input type="text" class="field4 basicExample times common2" name="email1" placeholder="" id="pickuptime" value="<?php echo $row->pickup_time; ?>"></div><br>
                                    <input type="button" value="Find my Taxi" class="findtaxibtn sel_taxi movestep2">
                                    
                                </div>  
                              
                                
                                
                                
                                <div class="col-lg-12 pstep2">
                              		
                                    
                                    
                                    <div class="carprice">
                                    
                                    	<ul class="taxiinfohead">
                                        	<li><?php echo $select_car; ?></li>
                                            <li>&nbsp;</li>
                                            <li>&nbsp;</li>
                                            <li><?php echo $Fares; ?></li>
                                        </ul>
                                        
                                        <div class="table-bgwhite">
                                        
                                        
                                        
                                        
                                       
                                        <?php
										
											 $query1 = $this->db->query("SELECT * FROM  cabdetails WHERE transfertype='Point to Point Transfer' and timetype='day' ");
											  if($query1->num_rows >0){
											  foreach($query1->result_array('cabdetails') as $row1){
											?>
                                             <hr class="horrizontalline">
                                        <ul class="taxiinfo2 <?php echo $row1['timetype'];?>">
                                        	<li><input type="radio" name="taxi_type" class="fareselect pradio" value="<?php echo $row1['cartype'];?>" <?php if( $row->taxi_type == $row1['cartype'] ) { echo "checked";} ?>></li>
                                            <li><img src="<?php if( $row1['cartype']=='Sedan'){?><?php echo base_url();?>assets/images/car3.png<?php }else if($row1['cartype']=='Hatchback'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Tata Indica AC'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Nano'){?><?php echo base_url();?>assets/images/nano.png<?php }else if($row1['cartype']=='SUV'){?><?php echo base_url();?>assets/images/car4.png<?php }else{?><?php echo base_url();?>assets/images/car4.png<?php }?>"/></li>
                                            <li class="cartype2"><p class="taxiname"><?php echo $row1['cartype'];?></p> <p class="taxicondi">4  Seater AC</p></li>
                                            <li class="paddingzero">
                                            		<p class="taxiname"> <?php echo $s[1] ;?> <?php echo $row1['intailrate'];?>.00 for the first <?php echo $row1['intialkm'];?>.00 <?php echo $mesr;?> </p>
                									<p class="taxicondi">(  <?php echo $s[1] ;?>  <?php echo $row1['standardrate'];?>.00 / <?php echo $mesr;?>)</p>
                                            </li>
                                        </ul>
                                        
                                        <?php
											  }
											  }else{
												 ?>
												 <div class="notavai day"><?php echo $cab_not_available; ?></div>
												<?php
											 }
											 
											  ?>
											  <?php
										
											 $query1 = $this->db->query("SELECT * FROM  cabdetails WHERE transfertype='Point to Point Transfer' and timetype='night' ");
											  if($query1->num_rows >0){
											  foreach($query1->result_array('cabdetails') as $row1){
											?>
                                             <hr class="horrizontalline">
                                        <ul class="taxiinfo2 <?php echo $row1['timetype'];?>">
                                        	<li><input type="radio" name="taxi_type" class="fareselect pradio" value="<?php echo $row1['cartype'];?>" <?php if( $row->taxi_type == $row1['cartype'] ) { echo "checked";} ?>></li>
                                            <li><img src="<?php if( $row1['cartype']=='Sedan'){?><?php echo base_url();?>assets/images/car3.png<?php }else if($row1['cartype']=='Hatchback'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Tata Indica AC'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Nano'){?><?php echo base_url();?>assets/images/nano.png<?php }else if($row1['cartype']=='SUV'){?><?php echo base_url();?>assets/images/car4.png<?php }else{?><?php echo base_url();?>assets/images/car4.png<?php }?>"/></li>
                                            <li class="cartype2"><p class="taxiname"><?php echo $row1['cartype'];?></p> <p class="taxicondi">4  Seater AC</p></li>
                                            <li class="paddingzero">
                                            		<p class="taxiname"> <?php echo $s[1] ;?> <?php echo $row1['intailrate'];?>.00 for the first <?php echo $row1['intialkm'];?>.00 <?php echo $mesr;?> </p>
                									<p class="taxicondi">(  <?php echo $s[1] ;?>  <?php echo $row1['standardrate'];?>.00 / <?php echo $mesr;?>)</p>
                                            </li>
                                        </ul>
                                        
                                        <?php
											  }
											  }else{
												 ?>
												 <div class="notavai night"><?php echo $cab_not_available; ?></div>
												<?php
											 }
											 
											  ?>
                                         <!--hr class="horrizontalline">
                                        <ul class="taxiinfo1">
                                        	<li><input type="radio" class="fareselect" value="Tata Indica AC" <?php if( $row->taxi_type =="Tata Indica AC" ) { echo "checked";} ?>></li>
                                            <li><img src="<?php echo base_url();?>assets/images/cab-image.png"/></li>
                                            <li class="middileone"><p class="taxiname">Tata Indica AC</p> <p class="taxicondi">4  Seater AC</p></li>
                                            <li class="paddingzero">
               										<p class="taxiname">₹ 49.00 for the first 4.0 km </p>
                									<p class="taxicondi">( ₹ 14.00 / km )</p>
                    								
                							</li>
                                        </ul>
                                       
                                        <ul class="taxiinfo2">
                                        	<li><input type="radio" class="fareselect" value="Hyundai Accent" <?php if( $row->taxi_type =="Hyundai Accent" ) { echo "checked";} ?>></li>
                                            <li><img src="<?php echo base_url();?>assets/images/cab-image.png"/></li>
                                            <li class="middileone"><p class="taxiname">Tata Indica AC</p> <p class="taxicondi">4  Seater AC</p></li>
                                            <li class="paddingzero">
                                            		<p class="taxiname">₹ 49.00 for the first 4.0 km </p>
                									<p class="taxicondi">( ₹ 14.00 / km )</p>
                                            </li>
                                        </ul-->
                                        
                                        
                                    </div>
                                    
                                    
										<input type="button" class="findtaxibtn movestep3" value="Find my Taxi">
									</div>
                                    
                                    
                                    
                              
                              </div>
                              
                                <div class="backclrwhite pstep3">
                              
                            	<div class="col-sm-6">
                                
                                	
                                
                                	<p class="para-head"><?php echo $area; ?></p>
                                	<input type="text"  name="email1" class="field6" id="area" value="<?php echo $row->area; ?>">
                                    
                                    <p class="para-head"><?php echo $landmarks; ?></p>
                                	<input type="text"  name="email1" class="field6" id="landmark" value="<?php echo $row->landmark; ?>">
                                    
                                    
                                    <p class="para-head"><?php echo $pickups_addr; ?></p>
                                	<textarea cols="90" rows="2" class="formtext11 common2" id="pickupadd"><?php echo $row->pickup_address; ?></textarea>
                                    
                                </div>                           
                            	<div class="col-sm-6">
                                	<div class="margindeclare"><input type="checkbox" class="fareselect" id="check"> &nbsp;<label class="checkboxlabel"><?php echo $save_address; ?></label></div>
                                    
                                    <p class="para-head"><?php echo $promocodes; ?></p>
                                     <input type="hidden" id="hiddentext-point" name="hidetext"  value="<?php echo $row->promo_code; ?>">  
                                	<input type="text" value="<?php echo $row->promo_code; ?>"  name="promocode" class="field7 common2 point-promo" id="promocode1"><input type="button" class="applybtn" value="APPLY" id="promocode-point">
                                     <?php  if($username = $this->session->userdata('username')){
		$value = $this->session->userdata('username');
		}else{
		$value= $this->input->cookie('username', false);
		}
						if(!empty($value)){
							?>
                             <p class="ppromo-err"></p>
                             <?php
						}else{
							?>
                                    <p class="errortext"><?php echo $pls_login_registers; ?></p>
                                    <?php
						}
						?>
                                    <br>
                                    
                                    <input type="button" class="findtaxibtn2" value="Save Changes" id="pointconfirm"><div class="result"></div>
                                    </div>
                                </div>
                              
                              
                              </div>                          
                            </div>
                           </div>
                            
            
            <?php
						}else if($row->purpose=='Airport Transfer'){
						?>
          
          
          
                          <div role="tabpanel" class="hidecon tab-pane <?php if($row->purpose=='Airport Transfer'){echo "active";}?>" id="airport" aria-labelledby="airport-tab">
                              
                            
                              
                              
                              <div class="search-form">
                                             <div class="row">
                         
                                    	<div class="arrow-toptab">
                                    	<ul class="arrow-toptablist">
                                        		<a href="#"><li class="inactivearrow-toptablist2 finished as1"><?php echo $locations; ?></li></a>
                                                <a href="#"><li class="inactivearrow-toptablist2 as2 air-tab"><?php echo $select_taxi; ?></li></a>
                                                <a href="#"><li class="inactivearrow-toptablist2 as3"><?php echo $confirm_booking; ?></li></a>
                                        </ul>
                                        
                                    </div>
                                     <div class="astep1">
                                
                                
                                
                                
                                
                                <div class="tabs">
    <ul class="tab-links">
        <li class="active going_air"><a href="#tab1" title="going"><?php echo $going_airport; ?></a></li>
        <li><a class ="coming_air"href="#tab2" title="coming"><?php echo $Coming_from_Airports; ?></a></li>
        
    </ul>
    							<div class="dropdownairport"> 
                                <?php
								if($row->purpose=='going'){
								?>   
                                	  <select class="airportdropdown air-man" >
                                     <?php
								 $query1 = $this->db->query("SELECT * FROM airport_details ");
								  foreach($query1->result_array('airport_details') as $row1){
								?>
                                          <option value="<?php echo $row1['name'];?>" <?php if($row1['name'] == $row->pickup_area) echo 'selected'; ?>><?php echo $row1['name'];?></option> </select>
                                          
                                          <?php
								  }
								}else{
									
									?>
								  <select class="airportdropdown air-man" >
                                     <?php
								 $query1 = $this->db->query("SELECT * FROM airport_details ");
								  foreach($query1->result_array('airport_details') as $row1){
								?>
                                          <option value="<?php echo $row1['name'];?>" <?php if($row1['name'] == $row->drop_area) echo 'selected'; ?>><?php echo $row1['name'];?></option>
                                          
                                          <?php
								  }
								}
								?>
									 </select> 
                                     <input type="hidden" value="<?php echo $row->transfer; ?>" id="airporttab">
                                 </div>
                                 <br>
 
    <div class="tab-content1">
        <div id="tab1" class="tab active">
            						
                                  
                                <div class="col-sm-4">
                                	<p class="para-head"><?php echo $pickup_date; ?></p>
                                	<input type="text" class="field2 common2" name="pickdate" value="<?php echo $row->pickup_date; ?>" id="pickdate1">
                                </div>
                                   
                                <div class="col-sm-4"> 
                                    <p class="para-head"><?php echo $pickup_time; ?></p>
                                	
                                    <div class="time_div2"><input type="text" value="<?php echo $row->pickup_time; ?>" name="picktime" class="field4 common2" id ="timep"></div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <p class="para-head"><?php echo $pickup_area; ?></p>
                                	<input type="text" class="field3 common2 samples" id="autocomplete1"  value="<?php echo $row->pickup_area; ?>" autocomplete="on" onClick="initialize(this.id);">
                                </div>
                                
                                <input type="button" value="Find my Taxi" class="findtaxibtn amovestep2">
                                
        </div>
 
        <div id="tab2" class="tab">
            						
                                <div class="col-sm-4">
                                	<p class="para-head"><?php echo $pickup_date; ?></p>
                                	<input type="text" class="field2 common2" name="pickdate"  id="pickdate3" value="<?php echo $row->pickup_date; ?>" >
                                </div>
                                
                                <div class="col-sm-4">                                    
                                    <p class="para-head"><?php echo $pickup_time; ?></p>
                                 <div class="time_div5"><input type="text"  name="picktime" class="field4 common2" id="timep1" value="<?php echo $row->pickup_time; ?>"></div>
                                </div>
                                
                                <div class="col-sm-4">                                    
                                    <p class="para-head"><?php echo $drop_area; ?></p>
                                	<input type="text" class="field3 common2 samples" name="droparea" value="<?php echo $row->drop_area; ?>" id="autocomp6" autocomplete="on" onClick="initialize(this.id);">
                                </div>
                                    
                                    <input type="button" value="Find my Taxi" class="findtaxibtn amovestep2">
        </div>
 
        
    </div>
</div>
                               
                                    
                                </div>      
                              
                                                   
                            	  
                                  <div class="col-lg-12 astep2">
                              		
                                    
                                    
                                    <div class="carprice">
                                    
                                    	<ul class="taxiinfohead">
                                        	<li><?php echo $select_car; ?></li>
                                            <li>&nbsp;</li>
                                           
                                            
                                            <li><?php echo $Fares; ?></li>
                                        </ul>
                                        
                                        <div class="table-bgwhite">
                                        
                                         <?php
										 
											 $query1 = $this->db->query("SELECT * FROM  cabdetails WHERE transfertype='Airport Transfer' and timetype='day'");
											   if($query1->num_rows >0){
											  foreach($query1->result_array('cabdetails') as $row1){
											?>
                                         <hr class="horrizontalline">
                                        <ul class="taxiinfo1 <?php echo $row1['timetype'];?>">
                                        
                                        	<li><input type="radio" class="fareselect aradio" value="<?php echo $row1['cartype'];?>" name="taxi_type" <?php if( $row->taxi_type == $row1['cartype'] ) { echo "checked";} ?>></li>
                                            <li><img src="<?php if( $row1['cartype']=='Sedan'){?><?php echo base_url();?>assets/images/car3.png<?php }else if($row1['cartype']=='Hatchback'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Tata Indica AC'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Nano'){?><?php echo base_url();?>assets/images/nano.png<?php }else if($row1['cartype']=='SUV'){?><?php echo base_url();?>assets/images/car4.png<?php }else{?><?php echo base_url();?>assets/images/car4.png<?php }?>"></li>
                                            <li class="middileone"><p class="taxiname"><?php echo $row1['cartype'];?></p> <p class="taxicondi">4  Seater AC</p></li>
                                            <li class="paddingzero going">
               										<p class="taxiname"><?php echo $s[1] ;?> <?php echo $row1['intailrate'];?> for the first <?php echo $row1['intialkm'];?>.0 <?php echo $mesr;?> </p>
                									<p class="taxicondi">( <?php echo $s[1] ;?> <?php echo $row1['standardrate'];?>.00 / <?php echo $mesr;?>)</p>
                    								
                							</li>
                                            <li class="paddingzero going1">
               										<p class="taxiname"><?php echo $s[1] ;?> <?php echo $row1['fromintailrate'];?> for the first <?php echo $row1['fromintialkm'];?>.0 <?php echo $mesr;?> </p>
                									<p class="taxicondi">( <?php echo $s[1] ;?> <?php echo $row1['fromstandardrate'];?>.00 / <?php echo $mesr;?> )</p>
                    								
                							</li>
                                        </ul>
                                        <?php
											  }
											   }else{
												 ?>
												 <div class="notavai day"><?php echo $cab_not_available; ?></div>
												<?php
											 }
											 
											  ?>
                                         <?php
										 
											 $query1 = $this->db->query("SELECT * FROM  cabdetails WHERE transfertype='Airport Transfer' and timetype='night'");
											   if($query1->num_rows >0){
											  foreach($query1->result_array('cabdetails') as $row1){
											?>
                                         <hr class="horrizontalline">
                                        <ul class="taxiinfo1 <?php echo $row1['timetype'];?>">
                                        
                                        	<li><input type="radio" class="fareselect aradio" value="<?php echo $row1['cartype'];?>" name="taxi_type" <?php if( $row->taxi_type == $row1['cartype'] ) { echo "checked";} ?>></li>
                                            <li><img src="<?php if( $row1['cartype']=='Sedan'){?><?php echo base_url();?>assets/images/car3.png<?php }else if($row1['cartype']=='Hatchback'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Tata Indica AC'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Nano'){?><?php echo base_url();?>assets/images/nano.png<?php }else if($row1['cartype']=='SUV'){?><?php echo base_url();?>assets/images/car4.png<?php }else{?><?php echo base_url();?>assets/images/car4.png<?php }?>"></li>
                                            <li class="middileone"><p class="taxiname"><?php echo $row1['cartype'];?></p> <p class="taxicondi">4  Seater AC</p></li>
                                            <li class="paddingzero going">
               										<p class="taxiname"><?php echo $s[1] ;?> <?php echo $row1['intailrate'];?> for the first <?php echo $row1['intialkm'];?>.0 <?php echo $mesr;?> </p>
                									<p class="taxicondi">( <?php echo $s[1] ;?> <?php echo $row1['standardrate'];?>.00 / <?php echo $mesr;?> )</p>
                    								
                							</li>
                                            <li class="paddingzero going1">
               										<p class="taxiname"><?php echo $s[1] ;?> <?php echo $row1['fromintailrate'];?> for the first <?php echo $row1['fromintialkm'];?>.0 <?php echo $mesr;?> </p>
                									<p class="taxicondi">( <?php echo $s[1] ;?> <?php echo $row1['fromstandardrate'];?>.00 / <?php echo $mesr;?> )</p>
                    								
                							</li>
                                        </ul>
                                        <?php
											  }
											   }else{
												 ?>
												 <div class="notavai night"><?php echo $cab_not_available; ?></div>
												<?php
											 }
											 
											  ?>
                                       
                                        
                                        
                                    </div>
                                    
                                    
										<input type="button" value="Find my Taxi" class="findtaxibtn amovestep3">
									</div>
                                    
                                    
                                    
                              
                              </div>
                              
                            	                           
                                  <div class="col-sm-6 astep3">
                                
                                	
                                
                                	<p class="para-head"><?php echo $area; ?></p>
                                	<input type="text" placeholder="Ashok Nagar, MG Road" name="email1" class="field6" value="<?php echo $row->area; ?>" id="area1">
                                    
                                    <p class="para-head"><?php echo $flight_number; ?></p>
                                	<input type="text" placeholder="" name="email1" class="field6 common2" value="<?php echo $row->	flight_number; ?>" id="flight">
                                    <p class="para-head"><?php echo $pickups_addr; ?> </p>
                                	<textarea class="formtext11 common2" rows="2" cols="90" id="aaddress"><?php echo $row->	pickup_address; ?></textarea>
                                    
                                </div>                           
                            	<div class="col-sm-6 astep3">
                                	<div class="margindeclare"><input type="checkbox" class="fareselect" id="check2"> &nbsp;<label class="checkboxlabel"></label></div>
                                    
                                    <p class="para-head"><?php echo $promocodes; ?></p>
                                     <input type="hidden" id="hiddentext-air" name="hidetext"  value="<?php echo $row->promo_code; ?>">  
                                	<input type="text" placeholder="" name="promocode" class="field7 common" id="promocode2" value="<?php echo $row->promo_code; ?>"><input type="button" class="applybtn" value="APPLY" id="promocode-air">
                                   
                                     <?php  if($username = $this->session->userdata('username')){
		$value = $this->session->userdata('username');
		}else{
		$value= $this->input->cookie('username', false);
		}
						if(!empty($value)){
							?>
                             <p class="apromo-err"></p>
                             <?php
						}else{
							?>
                                    <p class="errortext"><?php echo $pls_login_registers; ?></p>
                                    <?php
						}
						?>
                                    <br>
                                    
                                    <input type="button" class="findtaxibtn2" value="Save Changes" id="airportconfirm">
                                    </div>
                                </div>  
                              </div>                          
                            </div>
                            <?php }
							else if($row->purpose=='Hourly Rental'){
							?>
                              
                             <div aria-labelledby="hourly-tab" id="hourly" class="hidecon tab-pane <?php if($row->purpose=='Hourly Rental'){echo "active";}?>" role="tabpanel">
                              
                              
                              
                              <div class="search-form">
                            <div class="row">
                         
                                    	<div class="arrow-toptab">
                                    	<ul class="arrow-toptablist">
                                        		<a href="#"><li class="inactivearrow-toptablist2 finished hs1"><?php echo $locations; ?></li></a>
                                                <a href="#"><li class="inactivearrow-toptablist2 hs2 hourly-tab"><?php echo $select_taxi; ?></li></a>
                                                <a href="#"><li class="inactivearrow-toptablist2 hs3"><?php echo $confirm_booking; ?></li></a>
                                        </ul>
                                        
                                    </div>
                                  
                              
                            	<div class="col-sm-6 hstep1">
                                
                                	
                                	<p class="para-head"><?php echo $Packages; ?></p>
                                	<select class="dropdown-field1" id="package">
                                     <?php
										   	$query2 = $this->db->query("SELECT DISTINCT`package` FROM package_details");
                                                    foreach($query2->result_array('package_details') as $row1){
										   ?>
                                              <option value="<?php echo $row1['package'];?>" <?php if($row->package == $row1['package']) echo 'selected'; ?>><?php echo $row1['package'];?></option>
                                             
                                             <?php
													}?>
                                                
                                                 </select>
                                
                                	<p class="para-head"><?php echo $pickup_area; ?></p>
                                	<input type="text" class="field1 common2 samples" name="pickup_area"  value="<?php echo $row->pickup_area; ?>" id="autocomplete2" autocomplete="on" onClick="initialize(this.id);">
                                    
                                   
                                </div>                           
                            	<div class="col-sm-6 hstep1">
                                	 <p class="para-head"> <?php echo $pickup_date; ?></p>
                                	<input type="text" class="field2 common2" name="pickup_date" value="<?php echo $row->pickup_date; ?>" id="dateh">
                                    
                                    <p class="para-head"><?php echo $pickup_time; ?> </p>
                                	<div class="time_div1"><input type="text" class="field4 common2" name="pickup_time"  value="<?php echo $row->pickup_time; ?>" id="timeh"></div><br>
                                    <input type="button" value="Find my Taxi" class="findtaxibtn hmovestep2">
                                    
                                </div>  
                           
                                        
                             
                              
                              <div class="col-lg-12 hstep2">
                              		
                                    
                                    
                                    <div class="carprice">
                                    
                                    	<ul class="taxiinfohead">
                                        	<li><?php echo $select_car; ?></li>
                                            <li>&nbsp;</li>
                                            <li>&nbsp;</li>
                                            <li><?php echo $Fares; ?></li>
                                        </ul>
                                        
                                        <div class="table-bgwhite">
                                        
                                        
                                        <?php
											 $query1 = $this->db->query("SELECT * FROM  cabdetails WHERE transfertype='Hourly Rental' and timetype='day'");
											  if($query1->num_rows >0){
											  foreach($query1->result_array('cabdetails') as $row1){
											?>
                                             <hr class="horrizontalline">
                                        <ul class="taxiinfo1 <?php echo $row1['timetype'];?>">
                                        	<li><input type="radio" class="fareselect hradio" value="<?php echo $row1['cartype'];?>" name="taxi_type"  <?php if( $row->taxi_type ==$row1['cartype'] ) { echo "checked";} ?>></li>
                                            <li><img src="<?php if( $row1['cartype']=='Sedan'){?><?php echo base_url();?>assets/images/car3.png<?php }else if($row1['cartype']=='Hatchback'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Tata Indica AC'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Nano'){?><?php echo base_url();?>assets/images/nano.png<?php }else if($row1['cartype']=='SUV'){?><?php echo base_url();?>assets/images/car4.png<?php }else{?><?php echo base_url();?>assets/images/car4.png<?php }?>"/></li>
                                            <li class="cartype2"><p class="taxiname"><?php echo $row1['cartype'];?></p> <p class="taxicondi">4  Seater AC</p></li>
                                            <li class="middileone4">
               										<p class="taxiname"> <?php echo $s[1] ;?> <?php echo $row1['standardrate'];?>.00</p>
                									<p class="taxicondi">( <?php echo $s[1] ;?> <?php echo $row1['extrakm'];?>.00 for extra <?php echo $mesr;?> <br>  <?php echo $s[1] ;?> <?php echo $row1['extrahour'];?>.00 for extra hour )</p>
                    								
                							</li>
                                        </ul>
                                        <?php
											  }
											  }else{
												 ?>
												 <div class="notavai day"><?php echo $cab_not_available; ?></div>
												<?php
											 }
											 
											  ?>
                                        
                                        
                                        <?php
											 $query1 = $this->db->query("SELECT * FROM  cabdetails WHERE transfertype='Hourly Rental' and timetype='night'");
											  if($query1->num_rows >0){
											  foreach($query1->result_array('cabdetails') as $row1){
											?>
                                             <hr class="horrizontalline">
                                        <ul class="taxiinfo1 <?php echo $row1['timetype'];?>">
                                        	<li><input type="radio" class="fareselect hradio" value="<?php echo $row1['cartype'];?>" name="taxi_type"  <?php if( $row->taxi_type ==$row1['cartype'] ) { echo "checked";} ?>></li>
                                            <li><img src="<?php if( $row1['cartype']=='Sedan'){?><?php echo base_url();?>assets/images/car3.png<?php }else if($row1['cartype']=='Hatchback'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Tata Indica AC'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Nano'){?><?php echo base_url();?>assets/images/nano.png<?php }else if($row1['cartype']=='SUV'){?><?php echo base_url();?>assets/images/car4.png<?php }else{?><?php echo base_url();?>assets/images/car4.png<?php }?>"/></li>
                                            <li class="cartype2"><p class="taxiname"><?php echo $row1['cartype'];?></p> <p class="taxicondi">4  Seater AC</p></li>
                                            <li class="middileone4">
               										<p class="taxiname"> <?php echo $s[1] ;?> <?php echo $row1['standardrate'];?>.00</p>
                									<p class="taxicondi">( <?php echo $s[1] ;?> <?php echo $row1['extrakm'];?>.00 for extra <?php echo $mesr;?> <br>  <?php echo $s[1] ;?> <?php echo $row1['extrahour'];?>.00 for extra hour )</p>
                    								
                							</li>
                                        </ul>
                                        <?php
											  }
											  }else{
												 ?>
												 <div class="notavai night"><?php echo $cab_not_available; ?></div>
												<?php
											 }
											 
											  ?>
                                        
                                      
                                        
                                    </div>
                                    
                                    
										<input type="button" class="findtaxibtn hmovestep3" value="Find my Taxi">
									</div>
                                    
                                    
                                    
                              
                              </div>
                              
                            	                           
                           
                                  
                               <div class="backclrwhite hstep3">
                              
                            	<div class="col-sm-6">
                                
                                	
                                
                                	<p class="para-head"><?php echo $area; ?></p>
                                	<input type="text" class="field6" name="area"  value="<?php echo $row->area; ?>" id="areah">
                                    
                                    <p class="para-head"><?php echo $landmarks; ?></p>
                                	<input type="text" class="field6" name="landmark" value="<?php echo $row->landmark; ?>" id="landmarkh">
                                    
                                    
                                    <p class="para-head"> <?php echo $pickups_addr; ?></p>
                                	<textarea class="formtext11 common2" rows="2" cols="90" id="pickaddh"><?php echo $row->pickup_address; ?></textarea>
                                    
                                </div>                           
                            	<div class="col-sm-6">
                                	<div class="margindeclare"><input type="checkbox" class="fareselect" id="check1"> &nbsp;<label class="checkboxlabel"><?php echo $save_address; ?></label></div>
                                    
                                    <p class="para-head"><?php echo $promocodes; ?></p>
                                    <input type="hidden" id="hiddentext-hourly" name="hidetext"  value="<?php echo $row->promo_code; ?>"> 
                                	<input type="text" class="field7 common2" name="promocode"  id="promocode3"  value="<?php echo $row->promo_code; ?>" ><input type="button" value="APPLY" class="applybtn" id="promocode-hourly">
                                       <?php  if($username = $this->session->userdata('username')){
		$value = $this->session->userdata('username');
		}else{
		$value= $this->input->cookie('username', false);
		}
						if(!empty($value)){
							?>
                             <p class="hpromo-err"></p>
                             <?php
						}else{
							?>
                                    <p class="errortext"><?php echo $pls_login_registers; ?></p>
                                    <?php
						}
						?>
                                    <br>
                                    
                                    <input type="button" value="Save Changes" class="findtaxibtn2" id="hourlyrental">
                                    </div>
                                </div>  
                              </div>                          
                            </div>
                              
                              
                              <!--confirm booking Hourly Rentalends strats-->
                              
                              
                              
                              
                           </div>
                           
                           <?php
							}else{
							?>
                           
                           <div aria-labelledby="outstation-tab" id="outstation" class="hidecon tab-pane  <?php if($row->purpose=='Outstation Transfer'){echo "active";}?>" role="tabpanel">
                             
                             
                             
                             
                             <div class="search-form">
                            <div class="row">
                         
                                    	<div class="arrow-toptab">
                                    	<ul class="arrow-toptablist">
                                        		<a href="#"><li class="inactivearrow-toptablist2 finished os1"><?php echo $locations; ?></li></a>
                                                <a href="#"><li class="inactivearrow-toptablist2 os2 out-tab"><?php echo $select_taxi; ?> </li></a>
                                                <a href="#"><li class="inactivearrow-toptablist2 os3"><?php echo $confirm_booking; ?></li></a>
                                        </ul>
                                        
                                    </div>
                                  <div class="tabs ostep1">
                               
                                <ul class="tab-links">
                                        <li class="active out_oneway"><a href="#tab1" title="oneway"><?php echo $oneway_trip; ?></a></li>
                                        <li><a class="out_round" href="#tab2" title="round"><?php echo $roundtrips; ?></a></li>
                                                      
                                 </ul>	
                               <input type="hidden" value="<?php echo $row->transfer; ?>" id="outtab">
    
                                 <br>
    
    
    <div class="tab-content1">
    
        <div id="tab1" class="tab active">
                              
                            	<div class="col-sm-6">                              	                                	
                                
                                	<p class="para-head"><?php echo $to; ?></p>
                                	<input type="text" class="field3 common2 samples" name="drop_area" placeholder="Starting" id="autocomplete3" autocomplete="on" onClick="initialize(this.id);" value="<?php echo $row->drop_area; ?>">
                                 </div>
                                 
                                 <div class="col-sm-6">
                                    <p class="para-head"><?php echo $departure_date; ?></p>
                                	<input type="text" class="field4 common2" name="pickup_date" placeholder="" id="dtimeo"  value="<?php echo $row->pickup_date; ?>">
                                    </div>   
                                    <input type="button" value="Find my Taxi" class="findtaxibtn omovestep2">
                                    
                                
                                </div>
                                       
                                       <div id="tab2" class="tab">                 
                            	<div class="col-sm-4">
                                	                                
                                	<p class="para-head"><?php echo $to; ?></p>
                                	<input type="text" class="field3 common2 samples" name="drop_area"   id="autocomp2" autocomplete="on" onClick="initialize(this.id);" value="<?php echo $row->drop_area; ?>">
                                 </div>
                                 
                                 <div class="col-sm-4">
                                    <p class="para-head"><?php echo $departure_date; ?></p>
                                	<input type="text" class="field2 common2" name="pickup_date"  id="depdate" value="<?php echo $row->pickup_date; ?>" >
                                 </div>
                                 
                                 <div class="col-sm-4"> 
                                    <p class="para-head"><?php echo $return_date; ?> </p>
                                	<input type="text" class="field2 common2" name="return_date" id="returndate" value="<?php echo $row->return_date; ?>">
                                  </div> 
                                    <input type="button" value="Find my Taxi" class="findtaxibtn omovestep2">
                                    
                                    
                                </div>
                                </div>
                                </div>
                              
                            	   
                                
                                                        
                            	  
                            
                              
                              
                              <div class="col-lg-12 ostep2">
                              		
                                    
                                    
                                    <div class="carprice">
                                    
                                   
                                    	<ul class="taxiinfohead">
                                        	<li><?php echo $select_car; ?> </li>
                                            <li>&nbsp;</li>
                                            <li>&nbsp;</li>
                                            <li><?php echo $Fares; ?></li>
                                        </ul>
                                        
                                        <div class="table-bgwhite">
                                        
                                        
                                         
                                    <?php
											 $query1 = $this->db->query("SELECT * FROM  cabdetails WHERE transfertype='Outstation Transfer' and timetype='day'");
											   if($query1->num_rows >0){
											  foreach($query1->result_array('cabdetails') as $row1){
											?>
                                         <hr class="horrizontalline">
                                        <ul class="taxiinfo1 <?php echo $row1['timetype'];?>">
                                        	<li><input type="radio" class="fareselect oradio" name="taxi_type" value="<?php echo $row1['cartype'];?>"  <?php if( $row->taxi_type ==$row1['cartype'] ) { echo "checked";} ?>></li>
                                            <li><img src="<?php if( $row1['cartype']=='Sedan'){?><?php echo base_url();?>assets/images/car3.png<?php }else if($row1['cartype']=='Hatchback'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Tata Indica AC'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Nano'){?><?php echo base_url();?>assets/images/nano.png<?php }else if($row1['cartype']=='SUV'){?><?php echo base_url();?>assets/images/car4.png<?php }else{?><?php echo base_url();?>assets/images/car4.png<?php }?>"/></li>
                                            <li class="middileone3"><p class="taxiname"><?php echo $row1['cartype'];?></p> <p class="taxicondi">4  Seater AC</p></li>                                        
                                            <li class="paddingzero oneway">
               										<p class="taxiname"><?php echo $s[1] ;?> <?php echo $row1['standardrate'];?>.00</p>
                                                   
                									<p class="taxicondi"><a class="faredetais" href="#"><?php echo $fare_detail; ?></a></p>
                    								
                							</li>
                                           
                                            <li class="paddingzero round">
               										
                                                    <p class="taxiname"> <?php echo $s[1] ;?> <?php echo $row1['fromstandardrate'];?>.00</p>
                									<p class="taxicondi"><a class="faredetais" href="#"><?php echo $fare_detail; ?></a></p>
                    								
                							</li>
                                           
                                        </ul>
                                       <?php
											  }
											   }else{
												 ?>
												 <div class="notavai day"><?php echo $cab_not_available; ?></div>
												<?php
											 }
											 
											  ?>
                                      <?php
											 $query1 = $this->db->query("SELECT * FROM  cabdetails WHERE transfertype='Outstation Transfer' and timetype='night'");
											   if($query1->num_rows >0){
											  foreach($query1->result_array('cabdetails') as $row1){
											?>
                                         <hr class="horrizontalline">
                                        <ul class="taxiinfo1 <?php echo $row1['timetype'];?>">
                                        	<li><input type="radio" class="fareselect oradio" name="taxi_type" value="<?php echo $row1['cartype'];?>"  <?php if( $row->taxi_type ==$row1['cartype'] ) { echo "checked";} ?>></li>
                                            <li><img src="<?php if( $row1['cartype']=='Sedan'){?><?php echo base_url();?>assets/images/car3.png<?php }else if($row1['cartype']=='Hatchback'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Tata Indica AC'){?><?php echo base_url();?>assets/images/cab-image.png<?php }else if($row1['cartype']=='Nano'){?><?php echo base_url();?>assets/images/nano.png<?php }else if($row1['cartype']=='SUV'){?><?php echo base_url();?>assets/images/car4.png<?php }else{?><?php echo base_url();?>assets/images/car4.png<?php }?>"/></li>
                                            <li class="middileone3"><p class="taxiname"><?php echo $row1['cartype'];?></p> <p class="taxicondi">4  Seater AC</p></li>                                        
                                            <li class="paddingzero oneway">
               										<p class="taxiname"><?php echo $s[1] ;?> <?php echo $row1['standardrate'];?>.00</p>
                                                   
                									<p class="taxicondi"><a class="faredetais" href="#"><?php echo $fare_detail; ?></a></p>
                    								
                							</li>
                                           
                                            <li class="paddingzero round">
               										
                                                    <p class="taxiname"> <?php echo $s[1] ;?> <?php echo $row1['fromstandardrate'];?>.00</p>
                									<p class="taxicondi"><a class="faredetais" href="#"><?php echo $fare_detail; ?></a></p>
                    								
                							</li>
                                           
                                        </ul>
                                       <?php
											  }
											   }else{
												 ?>
												 <div class="notavai night"><?php echo $cab_not_available; ?></div>
												<?php
											 }
											 
											  ?>
                                       
                                        
                                    </div>
                                    
                                    
										<input type="button" class="findtaxibtn omovestep3" value="Find my Taxi">
									</div>
                                    
                                    
                                    
                              
                              </div>
                              
                            	                           
                            	  
                                  
                                  
                               <div class="backclrwhite ostep3">
                              
                            	<div class="col-sm-6">
                                
                                	
                                
                                	<p class="para-head"><?php echo $area; ?></p>
                                	<input type="text" class="field6" name="email1" placeholder="Ashok Nagar, MG Road" value="<?php echo $row->area; ?>"  id="oarea">
                                    
                                    <p class="para-head"><?php echo $landmarks; ?></p>
                                	<input type="text" class="field6" name="email1" placeholder="" value="<?php echo $row->landmark; ?>"  id="landmarko">
                                    
                                    
                                    <p class="para-head"><?php echo $pickups_addr; ?></p>
                                	<textarea class="formtext11 common2" rows="2" cols="90" id="oaddress"><?php echo $row->pickup_address; ?></textarea>
                                    
                                    <p class="para-head"><?php echo $pickup_time; ?></p>
                                	<input type="text" class="field2" name="email1" placeholder="" value="<?php echo $row->	pickup_time; ?>" id="otime">
                                    
                                </div>                           
                            	<div class="col-sm-6">
                                	<div class="margindeclare"><input type="checkbox" class="fareselect" id="check3"> &nbsp;<label class="checkboxlabel"><?php echo $save_address; ?></label></div>
                                    
                                    <p class="para-head"><?php echo $promocodes; ?></p>
                                    	<input type="hidden" id="hiddentext-out" name="hidetext" value="<?php echo $row->promo_code; ?>">  
                                	<input type="text" class="field7"name="promocode" placeholder=""><input type="button" value="APPLY" class="applybtn" id="promocode-out">
                                     <?php  if($username = $this->session->userdata('username')){
		$value = $this->session->userdata('username');
		}else{
		$value= $this->input->cookie('username', false);
		}
						if(!empty($value)){
							?>
                             <p class="opromo-err"></p>
                             <?php
						}else{
							?>
                                    <p class="errortext"><?php echo $pls_login_registers; ?></p>
                                    <?php
						}
						?>
                                    <br>
                                    
                                    <input type="button" value="Save Changes" class="findtaxibtn2" id="outstationconfirm">
                                    </div>
                                </div>  
                              </div>                          
                            </div>
                             
                             <!--  confirm booking Outstation ends-->
                             
                             
                             
                             
                             
                            
                             
                             
                             
                             
                           </div>
                           <?php
							}
							?>
                           
                        </div>
                     </div>
                  </div>
                  <div class="col-md-5">
                  
                   <div class="car-middle"></div>
                  	<div class="right-image">
                    	<img src="<?php echo base_url();?>assets/images/banner-inner.png"/>
                    </div>                  
                  </div>
                  
                 
                  
               </div>
            </div>
         </div>
      </div>
	  
      </div>
      
     <?php
	 include "includes/callmycab_footer.php";
	 ?>
      
      
      
      
      
    
      
      
      
      
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
<script type="text/javascript">
$(document).ready(function () {
        $( ".datepicker" ).datepicker({
		    minDate: 0//this option for allowing user to select from year range
		});
	    $(".datepicker").change(function(){
		    var date = $(this).val();
			$.ajax({
			   url:'<?php echo base_url();?>callmycab/timepicker',
			   data:{'date' : date},
			   type:'post',
			   success:function(result){
				 
					$(".time_div").html(result);
				}	
		   });
		});
		$( "#dateh" ).datepicker({
		    minDate: 0//this option for allowing user to select from year range
		});
        $("#dateh").change(function(){
			var date = $(this).val();
			$.ajax({
			   url:'<?php echo base_url();?>callmycab/timepicker1',
			   data:{'date' : date},
			   type:'post',
			   success:function(result){
				 
					$(".time_div1").html(result);
				}	
			});
		}); 
	    $( "#pickdate1" ).datepicker({
		    minDate: 0//this option for allowing user to select from year range
		});
		$("#pickdate1").change(function(){
			var date = $(this).val();
			$.ajax({
			   url:'<?php echo base_url();?>callmycab/timepicker2',
			   data:{'date' : date},
			   type:'post',
			   success:function(result){
				  $(".time_div2").html(result);
				}	
			});
		}); 
		$( "#pickdate2" ).datepicker({
		    minDate: 0//this option for allowing user to select from year range
		});
        $("#pickdate2").change(function(){
		    var date = $(this).val();
			$.ajax({
			   url:'<?php echo base_url();?>callmycab/timepicker3',
			   data:{'date' : date},
			   type:'post',
			   success:function(result){
				 
					$(".time_div3").html(result);
				}	
		    });
		}); 
		///outstation
		$( "#depdate" ).datepicker({
		    minDate: 0//this option for allowing user to select from year range
		});
		$( "#dtimeo" ).datepicker({
		    minDate: 0//this option for allowing user to select from year range
		});
        $( "#returndate" ).datepicker({
		    minDate: 0//this option for allowing user to select from year range
		});
        $('#otime').timepicker();
    });
</script>
<script type="text/javascript">
function Converttimeformat(time) 
    {
		var hrs = Number(time.match(/^(\d+)/)[1]);
		var mnts = Number(time.match(/:(\d+)/)[1]);
		var format = time.substr(time.length - 2);;
		if (format == "pm" && hrs < 12) hrs = hrs + 12;
		if (format == "am" && hrs == 12) hrs = hrs - 12;
		var hours = hrs.toString();
		var minutes = mnts.toString();
		if (hrs < 10) hours = "0" + hours;
		if (mnts < 10) minutes = "0" + minutes;		
		return hours;
	}
	function initMap(origin, destination) {
	  var bounds = new google.maps.LatLngBounds;
	  var s = document.getElementById('distance_unit').value;
		  if(s =='mi'){
	  if(origin && destination) {
	  
	  var service = new google.maps.DistanceMatrixService;
	    service.getDistanceMatrix({
		origins: [origin],
		destinations: [destination],
		travelMode: google.maps.TravelMode.DRIVING,
		
		unitSystem:google.maps.UnitSystem.IMPERIAL,
		
		avoidHighways: false,
		avoidTolls: false
	  }, function(response, status) {
		if (status !== google.maps.DistanceMatrixStatus.OK) {
		  console.log('Error was: ' + status);
		} else {
		  var originList = response.originAddresses;
		  var destinationList = response.destinationAddresses;

		  for (var i = 0; i < originList.length; i++) {
			var results = response.rows[i].elements;
			for (var j = 0; j < results.length; j++) {
				  var inpu = results[j].distance.text;
				document.getElementById('distance_place').value=inpu; 

				 
			}
		  }
		}
	  });
    }
	}else{
		if(origin && destination) {
	  
	  
	  
	  var service = new google.maps.DistanceMatrixService;
	  service.getDistanceMatrix({
		origins: [origin],
		destinations: [destination],
		travelMode: google.maps.TravelMode.DRIVING,
		
		unitSystem:google.maps.UnitSystem.METRIC,
		
		avoidHighways: false,
		avoidTolls: false
	  }, function(response, status) {
		if (status !== google.maps.DistanceMatrixStatus.OK) {
		  console.log('Error was: ' + status);
		} else {
		  var originList = response.originAddresses;
		  var destinationList = response.destinationAddresses;

		  for (var i = 0; i < originList.length; i++) {
			var results = response.rows[i].elements;
			for (var j = 0; j < results.length; j++) {
				  var inpu = results[j].distance.text;
				document.getElementById('distance_place').value=inpu; 

				 
			}
		  }
		}
	  });
      }
	}
  
  
  
  
}
$(document).ready(function(){
	    $(".samples").on("keydown", function (e) {
        return e.which !== 32;
	    }); 
		$('.samples').keyup(function()
	     {
			var yourInput = $(this).val();
			re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
			var isSplChar = re.test(yourInput);
			if(isSplChar)
			{
				var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
				$(this).val(no_spl_char);
			}
		});	
		
	    $('.movestep2').click(function(){
			parea = $('#autocomplete' ).val();
			darea = $('#autocomp' ).val();
			pdate = $('#datepickerp' ).val();
			ptime = $('.times' ).val();
			origin = parea;
            destination = darea;
 
            var km1 = initMap(origin,destination);
			var validTime = $('.times' ).val().match(/^([012]?\d):([0-6]?\d)\s*(a|p)m$/i);
			error = false;
			if(!parea){
			  $('#autocomplete').addClass('required');
			  $("#autocomplete").focus();
			   error = true;
		    } if(!darea){
			  
			  $('#autocomp').addClass('required');
			  $("#autocomp").focus();
			   error = true;
		    } if(!pdate){
			   $('#datepickerp').addClass('required');
			   $("#datepickerp").focus();
				error = true;
		    } if(!validTime){
			   $('.times').addClass('required');
			   $(".times").focus();
				error = true;
		    } if(parea && darea){
				  if(parea == darea){
					  confirm("Please check your pickup/drop area.");
						error = true;
						$("#autocomplete").focus();
				  } 
				}
			if( error == false){ 
		
		  
			  jQuery('.pstep2').show();
			  jQuery('.pstep1').hide();
			 
			  jQuery('.ps2').addClass('currentstep'); 
			  
			  
			  jQuery('#tab-id').val('2');
			  var bootime= Converttimeformat(ptime);
			  if( bootime >24 || bootime<6){ 
			 
				   jQuery('.pointnight').show();
				   jQuery('.pointday').hide();
				   jQuery('#day_night').val('night');
			    }else {
					jQuery('#day_night').val('day');  
					jQuery('.pointday').show(); 
					jQuery('.pointnight').hide(); 
			    }
		    }
		});
		$('.ps1').click(function(){
		  jQuery('.pstep1').show(); 
		  jQuery('.pstep2').hide(); 
		  jQuery('.pstep3').hide();
		  jQuery('.ps2').removeClass('finished'); 
		  jQuery('.ps2').removeClass('currentstep'); 
		  jQuery('.ps2').removeClass('point-tab1');																	                                                                        jQuery('.ps3').removeClass('currentstep');
	    });
		$('.point-tab1').click(function(){
		  var id =	jQuery('#tab-id').val();
		  if(id ==3){
			  jQuery('#tab-id').val('2');
			   jQuery('.pstep2').show();
			   jQuery('.pstep3').hide();  
			   jQuery('.pstep1').hide(); 
			  jQuery('.ps3').removeClass('currentstep'); 
		    }
		});						
		$('.movestep3').click(function(){
		   
			var radioValue =$("input[type='radio'].pradio:checked").val();
		 
		   if (!radioValue) { 
              alert("Please select any cab");										 
            }else{
			  jQuery('.pstep3').show();
			  jQuery('.pstep2').hide(); 
			  jQuery('#tab-id').val('3');
			  jQuery('.ps2').addClass('finished'); 
			  jQuery('.ps3').addClass('currentstep'); 
            }
		});
	    $('.common2').on('change', function (){
		   var a = $(this).val();
		   if(a != '') {
			   $(this).removeClass('required');
		   } else {
				$(this).addClass('required');
		   }
	    });  
		$('.amovestep2').click(function(){
		  var gpdate = $('#pickdate1' ).val();
		  gptime = $('#timep' ).val().match(/^([012]?\d):([0-6]?\d)\s*(a|p)m$/i);
		  pickuparea =$('#autocomplete1').val()
		  cdate = $('#pickdate3' ).val();
		  cptime = $('#timep1' ).val().match(/^([012]?\d):([0-6]?\d)\s*(a|p)m$/i);
		  cpickuparea =$('#autocomp6').val()
		  error = false;
		  trans = $('#airporttab').val()
		
		  if(trans == 'going'){
			   var pickup_area =$("#autocomplete1").val() ;
			   var drop_area =$(".air-man").val() ;		  
				origin = pickup_area;
                destination = drop_area;
 
              var km1 = initMap(origin,destination);	   
				if(!gpdate){
				  $('#pickdate1').addClass('required');
				  $("#pickdate1").focus();
				   error = true;
			    }if(!gptime){
				  
				  $('#timep').addClass('required');
				  $("#timep").focus();
				  error = true;
				} if(!pickuparea){
				   $('#autocomplete1').addClass('required');
				   $("#autocomplete1").focus();
					error = true;
		        } 
			}else{
			    var drop_area =$("#autocomp6").val();
                var pickup_area =$(".air-man").val() ;
				origin = pickup_area;
                destination = drop_area;
				var km1 = initMap(origin,destination);	   	  
				if(!cdate){
				  $('#timep1').addClass('required');
				  $("#timep1").focus();
				   error = true;
				}if(!cptime){
				  
				  $('#timep1').addClass('required');
				  $("#timep1").focus();
				  error = true;
				} if(!cpickuparea){
				   $('#autocomp6').addClass('required');
				   $("#autocomp6").focus();
					error = true;
			    }
			}
			if( error == false){ 
			    if(trans == 'going'){
				  jQuery('.astep2').show();
				  jQuery('.astep1').hide();
				  jQuery('.as2').addClass('currentstep');
				  jQuery('.going1').hide();
				  dd = $('#timep' ).val();
				  var bootime= Converttimeformat(dd);
					if( bootime >24 || bootime<6){ 
						jQuery('#day_night').val('night');
						jQuery('.night').show();
						jQuery('.day').hide();
					}else {
					    jQuery('#day_night').val('day');  
						jQuery('.day').show(); 
						jQuery('.night').hide(); 
					}

			    }else{
				  jQuery('.astep2').show();
				  jQuery('.astep1').hide();
				  jQuery('.as2').addClass('currentstep');
				  jQuery('.going').hide();
				  dd1=$('#timep1' ).val();
				  var bootime= Converttimeformat(dd1);
					if( bootime >24 || bootime<6){ 
					    jQuery('#day_night').val('night');
					    jQuery('.night').show();
					    jQuery('.day').hide();
					}else {
						jQuery('#day_night').val('day');  
					    jQuery('.day').show(); 
					    jQuery('.night').hide(); 
					}
			    }
				jQuery('#tab-id').val('2');
			}
		});
	    $('.as1').click(function(){
		   jQuery('.astep1').show(); 
		   jQuery('.astep3').hide(); 
		   jQuery('.astep2').hide(); 
		   jQuery('.as2').removeClass('finished');
		   jQuery('.as2').removeClass('currentstep'); 
		   jQuery('.as3').removeClass('currentstep'); 
		   jQuery('#tab-id').val('1');
		});
		$('.air-tab').click(function(){
		    var id =	jQuery('#tab-id').val();
			
		   if(id ==3){
		 	   jQuery('.astep2').show(); 	 
			   jQuery('#tab-id').val('2');
			   jQuery('.astep3').hide(); 
			   jQuery('.astep1').hide(); 
			   jQuery('.as2').removeClass('finished');
			   jQuery('.as3').removeClass('currentstep'); 
            }
		});
		$('.amovestep3').click(function(){
		   var radioValue =$("input[type='radio'].aradio:checked").val();
			if (!radioValue) { 
             alert("Please select any cab");										 
            }else{
			  jQuery('.astep3').show();
			  jQuery('.astep2').hide();
			  jQuery('#tab-id').val('3');
			  jQuery('.as2').addClass('finished'); 
			  jQuery('.as3').addClass('currentstep');
            }																	  
		});
		$('.hmovestep2').click(function(){
		  var package = $('#package' ).val();
		  pdate = $('#dateh' ).val();
		  paarea = $('#autocomplete2' ).val();
		  ptime = $('#timeh' ).val().match(/^([012]?\d):([0-6]?\d)\s*(a|p)m$/i);
		  ptime2 = $('#timeh' ).val();
		  error = false;
			
		  if(!package){
			   $('#package').addClass('required');
			   $("#package").focus();
				error = true;
		    } if(!pdate){
			   $('#dateh').addClass('required');
			   $("#dateh").focus();
				error = true;
		    }if(!paarea){
			   $('#autocomplete2').addClass('required');
			   $("#autocomplete2").focus();
				error = true;
		    }if(!ptime){
			   $('#timeh').addClass('required');
			   $("#timeh").focus();
				error = true;
		    }if( error == false){ 
			  jQuery('.hstep2').show();
			  jQuery('.hstep1').hide(); 
			  $(".taxiinfo1").hide();
			  jQuery('.hs2').addClass('currentstep'); 
			   jQuery('#tab-id').val('2');
				var bootime= Converttimeformat(ptime2);
				if( bootime >24 || bootime<6){ 
				    $(".night:contains("+package+")").css("display", "block");
					
				    jQuery('#day_night').val('night');
				    
				}else {
				    $(".day:contains("+package+")").css("display", "block");
					
				    jQuery('#day_night').val('day'); 
				}
		    }
	    });
		$('.hs1').click(function(){
		  jQuery('.hstep1').show(); 
		  jQuery('.hstep2').hide(); 
		  jQuery('.hstep3').hide();
		  jQuery('.hs2').removeClass('finished'); 
		  jQuery('.hs2').removeClass('currentstep'); 
		  jQuery('.hs3').removeClass('currentstep');
		   jQuery('#tab-id').val('1');
		});
	    $('.hmovestep3').click(function(){
		    var radioValue =$("input[type='radio'].hradio:checked").val();
			if (!radioValue) { 
              alert("Please select any cab");										 
            }else{
			  jQuery('.hstep3').show();
			  jQuery('.hstep2').hide(); 
			  jQuery('.bookcon').hide();
			  jQuery('.hs2').addClass('finished'); 
			  jQuery('.hs3').addClass('currentstep'); 
			  jQuery('#tab-id').val('3');
            }
	    });
		$('.hourly-tab').click(function(){
			var id =	jQuery('#tab-id').val();
			if(id ==3){
			   jQuery('.hstep3').hide(); 
			   jQuery('.hstep2').show(); 
			   jQuery('.hs2').removeClass('finished');
			   jQuery('.hs3').removeClass('currentstep'); 
			}
		});
		$('.omovestep2').click(function(){
		   
		   var	drop_area = $("#autocomplete3").val();
			pickup_date = $("#dtimeo").val();
			drop_area1 = $("#autocomp2").val();
			pickup_date1 = $("#depdate").val() ;	
			return_date =$("#returndate").val() ;
			error = false;
			out = $('#outtab').val()
            if(out == 'oneway'){
			  if(!drop_area){
				  $('#autocomplete3').addClass('required');
				  $("#autocomplete3").focus();
				  error = true;
			    }  if(!pickup_date){
				  
				  $('#dtimeo').addClass('required');
				  $("#dtimeo").focus();
				   error = true;
			    } 
			}else{      
					if(!drop_area1){
					  $('#autocomp2').addClass('required');
					  $("#autocomp2").focus();
					  error = true;
				    } 
				    if(!pickup_date1){
					  
					  $('#depdate').addClass('required');
					  $("#depdate").focus();
					   error = true;
				   } 
				   if(!return_date){
					   $('#returndate').addClass('required');
					   $("#returndate").focus();
						error = true;
					  
				    }
				}
			    if( error == false){ 
				   
				   
				  if(out == 'oneway'){  
				   
					   
					  jQuery('.ostep2').show();
					  jQuery('.ostep1').hide(); 
					  jQuery('.os2').addClass('currentstep'); 
					  jQuery('.round').hide(); 
				    }else{
					  jQuery('.ostep2').show();
					  jQuery('.ostep1').hide(); 
					  
					  jQuery('.os2').addClass('currentstep'); 
					  jQuery('.oneway').hide(); 
				    }
				 jQuery('#tab-id').val('2');
		        }
			});
		$('.os1').click(function(){
		  jQuery('.ostep1').show(); 
		  jQuery('.ostep2').hide(); 
		  jQuery('.ostep3').hide();
		  jQuery('.os2').removeClass('finished'); 
		  jQuery('.os2').removeClass('currentstep'); 
		  jQuery('.os3').removeClass('currentstep');
		  jQuery('#tab-id').val('1');
		});
		$('.omovestep3').click(function(){
			
			var radioValue =$("input[type='radio'].oradio:checked").val();
		 
		   if (!radioValue) { 
			   alert("Please select any cab");										 
			}else{
			  jQuery('.ostep3').show();
			  jQuery('.ostep2').hide(); 
			  jQuery('.os3').addClass('currentstep');
			  jQuery('.os2').addClass('finished');
			  jQuery('#tab-id').val('3'); 
			}
		});
		$('.out-tab').click(function(){
		  var id =	jQuery('#tab-id').val();
		   if(id ==3){
			   jQuery('.ostep3').hide(); 
			   jQuery('.ostep2').show(); 
			   jQuery('.os2').removeClass('finished');
			  jQuery('.os3').removeClass('currentstep'); 
			}
		});
		
		$('#promocode-point').click(function(){
           var code = $('#promocode1').val();
          if(!code){
	         $('#promocode1').addClass('required');
	         $('#promocode1').focus();
			 return false;
            }
            else{
	
				$.ajax({
					url:'<?php echo base_url();?>callmycab/promo',
					type:'post',
					data:{'promocode':code},
					success:function(book){
						console.log(book);
						if(book==0){
							$(".ppromo-err").html('<p style="font-size: 11px;color:#ff1f1f">Invalid Promocode</p>');
							$('#promocode1').addClass('required');
						}
						else{
							$(".ppromo-err").html('<p style="font-size: 11px;color:green">Promocode Accepted</p>');
							$('#hiddentext-point').val(code);
						}
					}
				});
			}
		});
 
	    $('#pointconfirm').click(function(){
           $('.loader').show();		
           var paddress = $('#pickupadd' ).val();
           if(!paddress){
               $('#pickupadd').addClass('required');
               $("#pickupadd").focus(); 
			   return false;
			}else{							  
			  if ($('#check').is(':checked')){
  	              var pickupadd = $("#pickupadd").val();
		
					$.ajax({
						url:'<?php echo base_url();?>callmycab/address',
						type:'post',
						data:{'pickupadd':pickupadd},
						success:function(book){
							console.log(book);
							if(book==1){
							//alert('s');
							}else {
							//alert('f');
							}

						}
					});
	            }
            }
            var pickup_area =$("#autocomplete").val() ;
			var pickup_date =$(".pickdate").val() ;
			var drop_area =$("#autocomp").val() ;
			var pickup_time =$("#pickuptime").val() ;
			var area =$("#area").val() ;
			var landmark =$("#landmark").val() ;
			var pickup_address =$("#pickupadd").val() ;
			var id = <?php echo $id; ?>;
			var taxi_type =$("input[type='radio'].pradio:checked").val();
			var purpose ="Point to Point Transfer";
			var promo_code = $("#hiddentext-point").val() ;
			var km=$('#distance_place').val();
			var timetype = $('#day_night').val();
			$.ajax({
				url:'<?php echo base_url();?>callmycab/update_booking',
				type:'post',
				data:{'timetype':timetype,'km':km,'pickup_area':pickup_area,'pickup_date':pickup_date,'drop_area':drop_area,'pickup_time':pickup_time,'area':area,'landmark':landmark,'pickup_address':pickup_address,'id':id,'taxi_type':taxi_type,'purpose':purpose,'promo_code':promo_code},
				success:function(book1){
					console.log(book1);
					if(book1==0){
					   alert('fail to Update');
					}
					else{
						$('.conrep').html(book1);
						$('.hidecon').hide();

					}
				}
			});  
       });  
	   $('#promocode-air').click(function(){
           var code = $('#promocode2').val();
			if(!code){
				$('#promocode2').addClass('required');
				$('#promocode2').focus();
			}
			else{
				
				$.ajax({
					url:'<?php echo base_url();?>callmycab/promo',
					type:'post',
					data:{'promocode':code},
					success:function(book){
						console.log(book);
						if(book==0){
							$(".apromo-err").html('<p style="font-size: 11px;color:#ff1f1f">Invalid Promocode</p>');
							$('#promocode2').addClass('required');

						}
						else{
							$(".apromo-err").html('<p style="font-size: 11px;color:green">Promocode Accepted</p>');
							
							$('#hiddentext-air').val(code);
						}
					}
				});
			}
        });

	

        $('#airportconfirm').click(function(){	
            $('.loader').show();
            var add = $("#aaddress").val();
			if(!add){ 
			  $('#aaddress').addClass('required');	  
			  $(this).focus();
				
			}

            else{
	
		        if ($('#check2').is(':checked')){
  	
		           var pickupadd = $("#aaddress").val();
		
					$.ajax({
						url:'<?php echo base_url();?>callmycab/address',
						type:'post',
						data:{'pickupadd':pickupadd},
						success:function(book){
							console.log(book);
							if(book==1){
							//alert('s');
							}else {
							//alert('f');
						 	}

						}
					});
			    }
            }
            var trans = $('#airporttab').val()
            if(trans == 'going'){
				var pickup_date =$("#pickdate1").val() ;	
				var pickup_time =$("#timep").val() ;	
				var pickup_area =$("#autocomplete1").val() ;
				var drop_area =$(".air-man").val() ;
			}else{
				var pickup_date =$("#pickdate3").val() ;
				var pickup_time =$("#timep1").val() ;
				var drop_area =$("#autocomp6").val();
				var pickup_area =$(".air-man").val() ;
			}

			var area =$("#area1").val() ;
			var flight_number =$("#flight").val() ;
			var taxi_type =$("input[type='radio'].aradio:checked").val();
			var transfer = $("#airporttab").val() ;
			var id = <?php echo $id; ?>;
			var promo_code = $("#hiddentext-air").val() ;
			var pickup_address = $("#aaddress").val();

			var purpose ="Airport Transfer";
			var km=$('#distance_place').val();
			var timetype = $('#day_night').val();
			$.ajax({
				url:'<?php echo base_url();?>callmycab/update_booking',
				type:'post',
				data:{'timetype':timetype,'km':km,'pickup_area':pickup_area,'pickup_date':pickup_date,'drop_area':drop_area,'pickup_time':pickup_time,'area':area,'flight_number':flight_number,'taxi_type':taxi_type,'transfer':transfer,'id':id,'purpose':purpose,'pickup_address':pickup_address,'promo_code':promo_code},

				success:function(book1){
					console.log(book1);
					if(book1==0){
					   alert('fail to Update');
					}
					else{

					    $('.conrep').html(book1);
						$('.hidecon').hide();
					}
				}
			});  
        });
											 
	 
		$('#promocode-hourly').click(function(){
			var code = $('#promocode3').val();
			if(!code){
				$('#promocode3').addClass('required');
				$('#promocode3').focus();
			}
			else{
				
				$.ajax({
					url:'<?php echo base_url();?>callmycab/promo',
					type:'post',
					data:{'promocode':code},
					success:function(book){
						console.log(book);
						if(book==0){
							$(".hpromo-err").html('<p style="font-size: 11px;color:#ff1f1f">Invalid Promocode</p>');
							$('#promocode3').addClass('required');

						}
						else{
							$(".hpromo-err").html('<p style="font-size: 11px;color:green">Promocode Accepted</p>');
							$('#hiddentext-hourly').val(code);
						}
					}
				});
			}
        });



        $('#hourlyrental').click(function(){
            $('.loader').show();	
			var add = $("#pickaddh").val();
			if(!add){  
			    $('#pickaddh').addClass('required');	  
			    $(this).focus();
				
			}else{	
				if ($('#check1').is(':checked')){
				
					var pickupadd = $("#pickaddh").val();
					
					$.ajax({
						url:'<?php echo base_url();?>callmycab/address',
						type:'post',
						data:{'pickupadd':pickupadd},
						success:function(book){
							console.log(book);
							if(book==1){
							//alert('s');
							}else {
							//alert('f');
							}

						}
					});
				}
							  
            }

			var package =$("#package").val();
			var pickup_area =$("#autocomplete2").val() ;
			var pickup_date =$("#dateh").val() ;
			var pickup_time =$("#timeh").val() ;
			var area =$("#areah").val() ;
			var landmark =$("#landmarkh").val() ;
			var pickup_address =$("#pickaddh").val();
			var id = <?php echo $id; ?>;
			var taxi_type =$("input[type='radio'].hradio:checked").val();
			var purpose ="Hourly Rental";
			var promo_code = $("#hiddentext-hourly").val() ;
			var timetype = $('#day_night').val();
			$.ajax({
				url:'<?php echo base_url();?>callmycab/update_booking',
				type:'post',
				data:{'timetype':timetype,'package':package,'pickup_area':pickup_area,'pickup_date':pickup_date,'pickup_time':pickup_time,'area':area,'landmark':landmark,'pickup_address':pickup_address,'id':id,'taxi_type':taxi_type,'purpose':purpose,'promo_code':promo_code},

				success:function(book1){
					console.log(book1);
					if(book1==0){
					    alert('fail to Update');
					}
					else{
					    $('.conrep').html(book1);
						$('.hidecon').hide();
					}
				}
			});  
        });




		$('#promocode-out').click(function(){
			var code = $('#promocode4').val();
			if(!code){
				$('#promocode4').addClass('required');
				$('#promocode4').focus();
			}
			else{
				
				$.ajax({
					url:'<?php echo base_url();?>callmycab/promo',
					type:'post',
					data:{'promocode':code},
					success:function(book){
						console.log(book);
						if(book==0){
						$(".opromo-err").html('<p style="font-size: 11px;color:#ff1f1f">Invalid Promocode</p>');
						$('#promocode4').addClass('required');

						}
						else{
							$(".opromo-err").html('<p style="font-size: 11px;color:green">Promocode Accepted</p>');
							$('#hiddentext-out').val(code);
						}
					}
				});
			}
        });
	    $('.loader').hide();										 
        $('#outstationconfirm').click(function(){
            $('.loader').show();										   
            var pickup_address =$("#oaddress").val();
			
            if(!pickup_address){
				$('#oaddress').addClass('required');
				$("#oaddress").focus();
				return false;
			}else{
				
				
				
				if ($('#check3').is(':checked')){
				
					var pickupadd = $("#oaddress").val();
					
					$.ajax({
						url:'<?php echo base_url();?>callmycab/address',
						type:'post',
						data:{'pickupadd':pickupadd},
						success:function(book){
							console.log(book);
							if(book==1){
							//alert('s');
							}else {
							//alert('f');
							}

						}
					});
	            }

            }

            var otime =$("#otime").val();
			if(!otime){
				$('#otime').addClass('required');
				$("#otime").focus();
				return false;
			}
			var out = $('#outtab').val()
			if(out == 'oneway'){
				var	drop_area = $("#autocomplete3").val();
				var pickup_date = $("#dtimeo").val() ;
			}else{
				var	drop_area = $("#autocomp2").val();
				var pickup_date = $("#depdate").val() ;	
				var return_date =$("#returndate").val() ;
			}


			var area =$("#oarea").val() ;
			var landmark =$("#landmarko").val() ;
			var pickup_address =$("#oaddress").val();
			var pickup_time =$("#otime").val() ;
			var taxi_type =$("input[type='radio'].oradio:checked").val();
			var transfer = $("#outtab").val() ;
			var id = <?php echo $id; ?>;
			var purpose ="Outstation Transfer";
			var promo_code = $("#hiddentext-out").val();
			var timetype = $('#day_night').val();

			$.ajax({
				url:'<?php echo base_url();?>callmycab/update_booking',
				type:'post',
				data
				:{'timetype':timetype,'pickup_date':pickup_date,'drop_area':drop_area,'return_date':return_date,'area':area,'landmark':landmark,'pickup_address':pickup_address,'pickup_time':pickup_time,'taxi_type':taxi_type,'id':id,'transfer':transfer,'purpose':purpose,'promo_code':promo_code},
				success:function(book1){
					console.log(book1);
					if(book1==0){
					  alert('fail to Update');
					}
					else{

					    $('.conrep').html(book1);
						$('.hidecon').hide();
					}
				}
			});  
        });			



       jQuery('.tabs .tab-links a').on('click', function(e)  {
			var currentAttrValue = jQuery(this).attr('href');
			var title = jQuery(this).attr('title');
			$('#airporttab').val(title);
            $('#outtab').val(title);
			
            jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
            jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
            
        });
	
	  <?php
	  if($row->transfer=='round')
	   {
		?>
	  $(".out_round").trigger('click');
	  <?php
	    }
	   if($row->transfer=='coming')
	   {	
	   ?>
	  $(".coming_air").trigger('click');
	   <?php
	  }
	   ?>
   });
	
</script>
<div class="loader"></div>
   </body>
   
</html>
<?php

 }else{
        redirect('/', 'refresh');
    }

?>


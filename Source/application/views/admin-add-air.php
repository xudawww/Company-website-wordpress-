<!DOCTYPE html>
<html>
  <?php
	 include"includes/admin_header.php";
	 ?>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Left side column. contains the logo and sidebar -->
     <?php
	 include"includes/admin_sidebar.php";
	 ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1 class="add_promocode">
         Add Airport Transfer
          </h1>
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">ABD</a></li>
            <li class="active">Airport Transfer</li>
          </ol>
        </section>
		   <?php
	   $query = $this->db->query(" SELECT * FROM `settings` order by id DESC ");
		$row = $query->row('settings');
	   if($row->places =='google'){	
	  ?>
	<script src="http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false" ></script>
         
       
		  
		   
        <script type="text/javascript">
		

/******* get google places ********/		
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

 /******* get lat and longitude ********/

    google.maps.event.addListener(autocomplete, 'place_changed', function () {
			 
        var placeA = autocomplete.getPlace();
        var latLong = autocomplete.getPlace().geometry.location;
        var js=JSON.stringify(latLong);
		var par=JSON.parse(js);
		if(id=="autocomplete"){				  
		   document.getElementById('pickup_lat').value=par.lat;
		   document.getElementById('pickup_lng').value=par.lng;
		   getAirportDistance();
		}else if(id=="autocomp"){

           document.getElementById('drop_lat').value=par.lat;
		   document.getElementById('drop_lng').value=par.lng;
		    getAirportDistance();
		}else{

		}				 
	});

  
}
 //  google.maps.event.addDomListener(window, 'load', initialize);

/*****GET DISTANCE BASED ON LAT AND LONG*****/ 
    function getAirportDistance(){
       
       var type = $('transfer').val();
       if(type == "going"){
	    	
	    	var drop_lat = document.getElementById('pickup_lat').value;    	
			var drop_lng = document.getElementById('pickup_lng').value;
		}else{

			var drop_lat = document.getElementById('drop_lat').value;
			var drop_lng = document.getElementById('drop_lng').value;
		}	
	        
			var arport_lat = document.getElementById('arport_lat').value;
			var arport_lng = document.getElementById('arport_lng').value;

		if(drop_lat!='' && drop_lng!='' && arport_lat!='' && arport_lng!=''){
			//alert(pickup_lat+pickup_lng+drop_lat+drop_lng);
			$.ajax({
				url:'<?php echo base_url();?>admin/getAirportDistance',
				method:'post',
				data:{drop_lat:drop_lat,drop_lng:drop_lng,arport_lat:arport_lat,arport_lng:arport_lng},
				success:function(res){
				    console.log(res);
				    $('#dist').val(res +'Km');
				}
		    });
		}

    }
            

        </script>
		
	<?php
	   }else{
	   ?>  <script type="text/javascript">
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
  <input type='hidden' value='<?php echo $row->country;?>' id='countryin'>
	
        <!-- Main content -->
 <div class="">
			   <div class="">
                <div class="col-lg-6">
           <div class="box box-primary edit_promoform1">
				 
                <div class="box-header with-border">
                  <h3 class="box-title"></h3>
				   <div class="adminuser1" tabindex='1'></div>
                </div><!-- /.box-header -->
                <!-- form start -->
				
              <form role="form"  method="post" id="user_reg">
				
                  <div class="box-body">
				  <div class="form-group">
                                            <label>User</label>
                                           <select id="signup-username" class="form-control regcom select2"  style="width: 100%;" name="username">
						                    <option value='0'>Select user</option>
											<?php
											$query1 = $this->db->query("SELECT * FROM  userdetails");
							             foreach($query1->result_array('userdetails') as $row1){
												?><option value="<?php  echo $row1['username'];?>" ><?php  echo $row1['username']; ?></option>
												<?php
											 }
											 ?>
											</select>
											</div>
				  
						
											<div class="form-group">
                                            <label>Type</label>
                                            <select  class="form-control regcom select2"  style="width: 100%;" name='transfer' id='transfer'>
						                    <option value='going'>Going to airport</option> 
											<option value='coming'>Coming from airport</option> </select>
											</div>
                                       
									   <div class="form-group">
                                            <label>Airport</label>
                                            <select  class="form-control regcom select2"  style="width: 100%;" name='transfer1' id="transfer1">
						                     <?php
								//$query1 = $this->db->query("SELECT * FROM airport_details ");
								$query1 = $this->db->query("SELECT * FROM airport_list ");
								 //$query1 = $this->db->query("SELECT `airport_details`.*, `airport_list`.`id`, `airport_list`.`coun_id`, `airport_list`.`lat`,`airport_list`.`lon` FROM (`airport_list`) LEFT JOIN `airport_details` ON `airport_details`.`id` = `airport_list`.`coun_id` ");
								  foreach($query1->result_array('airport_list') as $row1){
								  	//var_dump($row1);
								?>
                                          <option value="<?php echo $row1['name'];?>"><?php echo $row1['name'];?></option>
                                          
                                          <?php
								  }
								  ?></select>
											</div>
                                        
									    <input type="hidden" id="arport_lat" > 
                                        <input type="hidden" id="arport_lng">
                                        <div class="form-group" id='drop'>
                                            <label>Pickup area</label>
                                           <input class="form-control regcom sample" placeholder="Starting" name='pickup_area'id="autocomplete" autocomplete="on" onClick="initialize(this.id);">
                                        </div>
                                        <input type="hidden" id="pickup_lat"> 
                                        <input type="hidden" id="pickup_lng">

                                         <div class="form-group" id='pick'>
                                            <label>Drop Area</label>
                                           <input class="form-control regcom sample" placeholder="Destination" name='drop_area' id="autocomp" autocomplete="on" onClick="initialize(this.id);">
                                        </div>

                                        <input type="hidden" id="drop_lat"> 
                                        <input type="hidden" id="drop_lng"> 
                                        
                                          <div class="form-group" id='pick'>
                                            <label>Distance</label>
                                           <input class="form-control regcom sample" placeholder="Distance" name='distance' id="dist" >
                                        </div>
										
					<div class="form-group">
                    <label>Pickup Date</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right regcom date" id="datepickerp" readonly name='pickup_date'>
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
                                        
                                        
										
					<div class="bootstrap-timepicker">
                    <div class="form-group">
                      <label>Pickup Time</label>
                      <div class="input-group">
					  <div class="time_div">
                        <input type="text" class="form-control timepicker regcom times" placeholder="Pickup Time" name="pickup_time">
						</div>
                        <div class="input-group-addon">
                          <i class="fa fa-clock-o"></i>
                        </div>
                      </div><!-- /.input group -->
                    </div><!-- /.form group -->
                  </div>
										
										
										 <div class="form-group">
                                       
                                        <input type="button" class="btn btn-primary" value="Submit"  name="Save" id="useradd">
                                        <button type="reset" class="btn btn-primary">Reset </button>
                                        </div>
				  
				</div>  
				  
	</div>
				 
                
              </div><!-- /.box -->
			  
			  
			  
			  
			  <div class="col-lg-6">
			             <div class="box box-primary edit_promoform">
				 
                <div class="box-header with-border">
                  <h3 class="box-title"></h3>
                </div><!-- /.box-header -->
                <!-- form start -->

				
                  <div class="box-body">
				  
					                   <div class="form-group ">
										  
												   
                                            <label>Select Car</label>
											<select id="car" class="form-control select2"  style="width: 100%;"  name="taxi_type">
						                    <option value='0'>Select Car</option>
											<?php
											$query1 = $this->db->query("SELECT * FROM  cabdetails WHERE transfertype='Point to Point Transfer'");
							             foreach($query1->result_array('cabdetails') as $row1){
												?><option value="<?php  echo $row1['cartype'];?>" ><?php  echo $row1['cartype']; ?></option>
												<?php
											 }
											 ?>
											</select>
                                        </div>

                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input class="form-control regcom sample" placeholder="Amount" name="amount" id="amnt">
                                        </div>
										 
                                        <div class="form-group">
                                            <label>Area</label>
                                            <input class="form-control regcom sample" placeholder="Area" name="area" id="area1">
                                        </div>
										  <div class="form-group">
                                            <label>Flight Number</label>
                                            <input class="form-control regcom sample" placeholder="Landmark" name="flight_number" id="flight_number">
                                        </div>
										<div class="form-group">
                                            <label>Pickup Address</label>
                                            <input class="form-control regcom sample" placeholder="Address" name="pickup_address" id="pickupadd">
                                        </div>
										<div class="form-group">
                                            <label>Assigned For</label>
                                            <select id="assigned" class="form-control regcom select2"  style="width: 100%;" name="assigned_for" id='aaddress'>
						                    <option value='0'>Select Driver</option>
                                            </select>
                                        </div>
					
				</div>  
				  </form>
	          </div>
			  </div>
			  
                </div>
				</div>
				  
				   
			
      </div><!-- /.content-wrapper -->
     <?php
	 include"includes/admin-footer.php";
	 ?>

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
   <script src="<?php echo base_url();?>assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url();?>assets/adminlte/bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
   
    
    <script src="<?php echo base_url();?>assets/adminlte/dist/js/demo.js"></script>
	<script src="<?php echo base_url();?>assets/adminlte/dist/js/app.js"></script>
	
	 <script src="<?php echo base_url();?>assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>
     <script src="<?php echo base_url();?>assets/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- page script -->
   
	  <script src="<?php echo base_url();?>assets/adminlte/dist/js/sb-admin-2.js"></script>
     <!-- page script -->
  
	 
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" />
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript">

$('#car').on('change', function (){
	var car_type = $('#car').val();
	var total_km = $('#dist').val();
	$.ajax({
			url:'<?php echo base_url();?>admin/calcTotalAmount',
			data:{'car_type' : car_type,'total_km':total_km},
			type:'post',
			success:function(result){
				
				var res = jQuery.parseJSON(result);
				$('#amnt').val(res.amount);
				$.each(res.driver,function(i,value){
					
					var test = $('<option value="'+value['id']+'">'+value['name']+'</option>').appendTo('#assigned')
				})
			}	
	});
			
});
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
$(document).ready(function () {
		$(".sample").on("keydown", function (e) {
        return e.which !== 32;
	    });  
	
        $('.sample').keyup(function()
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
	 $( "#datepickerp" ).attr("placeholder", "mm-dd-yyyy").datepicker({
		    minDate: 0//this option for allowing user to select from year range
	   });
	   $("#datepickerp").change(function(){
		 	var date = $(this).val();
			$.ajax({
			url:'<?php echo base_url();?>callmycab/timepickera',
			data:{'date' : date},
			type:'post',
			success:function(result){ 
			$(".time_div").html(result);
			}	
			});
	   });
    
       var a = $('#transfer').val();
	    $("#trans").val(a);
	    if(a =='going') {
	    $("#drop").show();
	    $("#pick").hide();
	    } else {
	    $("#pick").show();
	    $("#drop").hide();
	    }
        $('#transfer').on('change', function (){
	    var a = $(this).val();
	    $("#trans").val(a);
	    if(a =='going') {
	    $("#drop").show();
	    $("#pick").hide();
	    } else {
	    $("#pick").show();
	    $("#drop").hide();
	    }
       });	
	    
 
        $('.regcom').on('change', function (){
	     var a = $(this).val();
	     if(a != '') {
	       $(this).removeClass('error-admin');
	      } else {
	      $(this).addClass('error-admin');
	      }
       });
 
 
	
        $("#useradd").click(function(){
			
         var username = $('#signup-username').val();
	      parea = $('#transfer1' ).val();
          darea = $('#autocomp' ).val();
          pdate = $('#datepickerp' ).val();
	      ptime = $('.times' ).val().match(/^([012]?\d):([0-6]?\d)\s*(a|p)m$/i);
	      paddress = $('#pickupadd' ).val();
		  car = $('#car').val();
	        driver = $('#assigned').val();
       if(!username){
	
	     $( "#signup-username" ).addClass('error-admin');
	     $("#signup-username").focus();
		 return false;
        }
		if(username=="0" ){

				alert("Please Select user");
				 return false;
			}
        if(!parea){
	    
	      $('#transfer1' ).addClass('error-admin');
	      $('#transfer1' ).focus();
		  return false;
        } 
		
		
        if(!pdate){
	   
	      $( "#datepickerp" ).addClass('error-admin');
	      $("#datepickerp").focus();
		  return false;
        }
        if(!ptime){
	   
	       $( ".times" ).addClass('error-admin');
	       $(".times").focus();
		   return false;
        }
         if(car=="0" ){

				alert("Please Select car");
				 return false;
			}
        if(!paddress){
            $('#pickupadd').addClass('error-admin');
            $("#pickupadd").focus(); 
            return false;
        }if(driver=="0" ){

				alert("Please Select driver");
				 return false;
			}
 
 
 	    var trans = $('#transfer').val();
		
        if(trans == 'going'){

         var pickup_time =$(".times").val() ;	
         var pickup_area =$("#autocomplete").val() ;
         var drop_area =$("#transfer1").val() ;
        }else{

         var pickup_time =$(".times").val() ;
         var drop_area =$("#autocomp").val();
         var pickup_area =$("#transfer1").val() ;
        }
         var username = $('#signup-username').val();
         var pickup_date =$("#datepickerp").val() ;
         var purpose ="Airport Transfer";
         var taxi_type =$("#taxi_type").val() ;
         var area =$("#area1").val() ;
         var flight_number =$("#flight_number").val() ;
         var pickup_address = $("#pickupadd").val();
         var amount = $('#amnt').val();
         var distance = $('#dist').val();
         $.ajax({
          url:'<?php echo base_url();?>admin/admin_book',
         method:'post',
          data:{'amount':amount,'distance':distance,'username':username,'taxi_type':taxi_type,'purpose':purpose,'pickup_area':pickup_area,'pickup_date':pickup_date,'drop_area':drop_area,'pickup_time':pickup_time,'area':area,'flight_number':flight_number,'taxi_type':taxi_type,'pickup_address':pickup_address},
          success:function(res){
	      $(".adminuser1").show();
          console.log(res);
          if(res==1){
			   $(".adminuser1").focus();
		       $(".adminuser1").html('<p class="error">Error!!!</p>');
	           setTimeout(function(){$(".adminuser1").hide(); }, 3000);
            }
			else{

				
				
				
				 $(".adminuser1").focus();
				$(".adminuser1").html('<p class="success">Update Successfully...</p>');
				setTimeout(function(){$(".adminuser1").hide(); }, 1500);
				$('#user_reg')[0].reset();
			}
        }
           });
        });
   });


$('#transfer1').on('change', function (){
	var airport_place = $('#transfer1').val();
	
	$.ajax({
			url:'<?php echo base_url();?>admin/getAirportValues',
			data:{'airport_place' : airport_place},
			type:'post',
			success:function(result){
				var res=jQuery.parseJSON(result);
				$('#arport_lat').val(res.lat);
				$('#arport_lng').val(res.lon);
				//alert(a.lat);
			}	
	});
			
});

</script>
  </body>
</html>

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
         Add Hourly Rental
          </h1>
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">ABD</a></li>
            <li class="active">Hourly Rental</li>
          </ol>
        </section>
		  <?php

	   $query = $this->db->query(" SELECT * FROM `settings` order by id DESC ");
	   $row = $query->row('settings');
	   if($row->places =='google'){	
	  ?>
	    
<script src="http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false" ></script>
<script type="text/javascript">
		
function initialize(id) {
		var cntry = document.getElementById('countryin').value;
	 
		var options = {
		types: ['(cities)'],
		  componentRestrictions: {country: cntry}
		};

		var input = document.getElementById(id);
		var autocomplete = new google.maps.places.Autocomplete(input, options);
	   
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
  <input type='hidden' value='<?php echo $row->country;?>' id='countryin'>
	   
	   
	   

        <!-- Main content -->
 <div class="">
			   <div class="">
                <div class="col-lg-6">
           <div class="box box-primary edit_promoform1">
				 
                <div class="box-header with-border">
                  <h3 class="box-title"></h3>
				   <div class="adminuser1"></div>
                </div><!-- /.box-header -->
                <!-- form start -->
				
             <form role="form"  method="post" id="user_reg">
				
                  <div class="box-body">
				  <div class="form-group">
				  
				  
				  <!-----------raj mid oct112016------------------------->
				    <input type="hidden" value="Hourly Rental" name='purpose'>
				  
				  <!---------------------------------->
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
                                            <label>Pickup area</label>
                                           <input class="form-control regcom sample"placeholder="Starting" name='pickup_area'id="autocomplete" autocomplete="on" onClick="initialize(this.id);">
                                        </div>
                                         <div class="form-group">
                                            <label>Package</label>
                                            <select class="form-control regcom select2"  style="width: 100%;" id="package" name='package'>
                                            <?php
                                            $query11 = $this->db->query("SELECT distinct(package) FROM package_details");
                                            foreach($query11->result_array('packagedetails') as $row11){
                                            ?>
                                            
											
                                             <option value="<?php  echo $row11['package'];?>" ><?php  echo $row11['package']; ?></option>
                                             <?php
                                         }
                                             ?>
											<!-- <option value='4hrs 40Kms'>4hrs 40Kms</option>
											 <option value='8hrs 80Kms'>8hrs 80Kms</option> -->
											</select>
                                          </div>
										  
										   <div class="form-group">
                    <label>Pickup Date</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right regcom" id="datepickerp" readonly name='pickup_date'>
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
											<select id="car" class="form-control select2"  style="width: 100%;" name="taxi_type">
						                    <option value='0'>Select car</option>
											<?php
											$query1 = $this->db->query("SELECT * FROM cabdetails LEFT JOIN car_categories ON cabdetails.cartype=car_categories.car_type WHERE transfertype='Hourly Rental' group by cabdetails.cartype");
							             foreach($query1->result_array('cabdetails') as $row1){
												?><option value="<?php  echo $row1['cartype'];?>" ><?php  echo $row1['cartype']; ?></option>
												<?php
											 }
											 ?>
											</select>
                                        </div>
                                        <div class="form-group">
                                            <label>Area</label>
                                            <input class="form-control regcom sample" placeholder="Area" name="area" id="area">
                                        </div>
										  <div class="form-group">
                                            <label>Landmark</label>
                                            <input class="form-control regcom sample" placeholder="Landmark" name="landmark" id="landmark">
                                        </div>
										<div class="form-group">
                                            <label>Pickup Address</label>
                                            <input class="form-control regcom sample" placeholder="Address" name="pickup_address" id="pickupadd">
                                        </div>
										<div class="form-group">
                                            <label>Assigned For</label>
                                            <select id="assigned" class="form-control select2"  style="width: 100%;" name="assigned_for">
						                    <option value='0'>Select Driver</option>
                                            <?php
											$query1 = $this->db->query("SELECT driver_details.* FROM driver_details where NOT EXISTS(select * from bookingdetails where driver_details.id=bookingdetails.assigned_for and bookingdetails.status='Processing') ");
											 foreach($query1->result_array('driver_details') as $row1){
												?><option value="<?php  echo $row1['id'];?>"><?php  echo $row1['name']; ?></option>
												<?php
											 }
											
											?>
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
    <!-- jQuery 2.1.4 -->
   <script src="<?php echo base_url();?>assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url();?>assets/adminlte/bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url();?>assets/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
	
	 
    <script src="<?php echo base_url();?>assets/adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url();?>assets/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url();?>assets/adminlte/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url();?>assets/adminlte/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url();?>assets/adminlte/dist/js/demo.js"></script>
	
	 <script src="<?php echo base_url();?>assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>
     <script src="<?php echo base_url();?>assets/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- page script -->
   
	  <script src="<?php echo base_url();?>assets/adminlte/dist/js/sb-admin-2.js"></script>
	
	
    <!-- page script -->
   <script src="<?php echo base_url();?>assets/adminlte/plugins/select2/select2.full.min.js"></script>
      
     <!-- page script -->
     <script>
        $(function () {
          $("#example1").DataTable();
          $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
          });
            $(".select2").select2();
        });
     </script>
	
		
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" />
        <script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
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
			   
				minDate: 0
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
			parea = $('#autocomplete' ).val();
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
	    
	         $('#autocomplete' ).addClass('error-admin');
	         $('#autocomplete' ).focus();
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
            }
			if(driver=="0" ){

				alert("Please Select driver");
				 return false;
			}
        //var value =$("#user_reg").serialize() ;
		var pickup_area =$("#autocomplete").val() ;
			var package =$("#package").val() ;
			var username = $('#signup-username').val();
         var pickup_date =$("#datepickerp").val() ;
         var purpose ="Hourly Rental";
         var taxi_type =$("#car").val() ;
         var area =$("#area").val() ;
         var landmark =$("#landmark").val() ;
         var pickup_address = $("#pickupadd").val();
		 var assigned_for = $("#assigned").val();
           var pickup_time =$(".times").val() ;

		$.ajax({
			url:'<?php echo base_url();?>admin/admin_book',
			method:'post',
			 data:{'username':username,'taxi_type':taxi_type,'purpose':purpose,'assigned_for':assigned_for,'pickup_area':pickup_area,'pickup_date':pickup_date,'package':package,'pickup_time':pickup_time,'area':area,'landmark':landmark,'taxi_type':taxi_type,'pickup_address':pickup_address},
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





</script>
  </body>
</html>

<!DOCTYPE html>
<html>
  <?php
	 include "includes/admin_header.php";
	 ?>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Left side column. contains the logo and sidebar -->
     <?php
	 include "includes/admin_sidebar.php";
	 ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1 class="add_promocode">
           Edit Taxi Details
          </h1>
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">TD</a></li>
            <li class="active">Edit</li>
          </ol>
        </section>

        <!-- Main content -->
 <div class="">
			   <div class="">
                <div class="col-lg-6">
           <div class="box box-primary edit_promoform1">
				 
                <div class="box-header with-border">
                  <h3 class="box-title"></h3>
				   <div class="taxi"></div>
                </div><!-- /.box-header -->
                <!-- form start -->
				   <?php
								$id = $_GET['idtaxi'];
						  
		// $query = $this->db->query("SELECT * FROM  cabdetails WHERE  id ='$id'");
                $query = $this->db->query("SELECT `round`.*, `round`.`package` as package_name, `cabdetails`.`id` as cab_id,`cabdetails`.`timetype`,`cabdetails`.`transfertype`,`cabdetails`.`package`, `cabdetails`.`cartype`, `cabdetails`.`standardrate` FROM (`cabdetails`) LEFT JOIN `round_trip_package` as round ON `round`.`id` = `cabdetails`.`package` WHERE `cabdetails`.`transfertype` = 'Outstation Transfer' AND `cabdetails`.`id` = '$id' ORDER BY `cabdetails`.`id`");
		            $row = $query->row('cabdetails');
								?>
                   <form role="form"  method="post" id="taxi_reg">
				
                  <div class="box-body">
				  
                                 <div class="form-group">
                                            <label>Taxi</label>
                                            <select class="form-control regcom  select2"  style="width: 100%;" id="cartype" name="cartype">
                                              
												 <?php
										   	$query2 = $this->db->query("SELECT DISTINCT`car_type` FROM car_categories");
                                                    foreach($query2->result_array('car_categories') as $row1){
										   ?>
                                              <option value="<?php echo $row1['car_type'];?>" <?php if($row->cartype == $row1['car_type']) echo 'selected'; ?> ><?php echo $row1['car_type'];?></option>
                                             
                                             <?php
													}?>
                                            </select>
                                        </div>
                                         
                                         
                                          <input   value="<?php echo $row->timetype; ?>" type="hidden" id="timetype" name="timetype">
                                       
                                        <div class="form-group">
                                            <label> Package11</label>

                                            <input class="form-control"  readonly placeholder="Package" name="standardrate"  id="standardrate" value="<?php echo $row->package_name; ?>">
                                            <input  id="id" value="<?php echo $row->cab_id; ?>" type="hidden" name="id">
                                           
                                        </div>
                                         <div class="form-group">
                                            <label>Rate</label>
                                            <input class="form-control regcom" placeholder="Rate" name="standardrate"  id="fromstandardrate"value="<?php echo $row->standardrate; ?>">
                                           <input  id="transfertype" name="transfertype" type="hidden" value="<?php echo $row->transfertype; ?>">
                                        </div>
                                        
                                        
                                      <div class="form-group">
                                       
                                        <input type="button" class="btn btn-primary" value="Save Details"  name="Save" id="taxiadd">
                                       
                                        </div>
				</div>  
				  </form>
	            </div>
		     </div><!-- /.box -->
			 
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
$(document).ready(function(){
	$(".regcom").on("keydown", function (e) {
        return e.which !== 32;
	    });  
	
	 $('.regcom').keyup(function()
	     {
			var yourInput = $(this).val();
			re = /[`~!@#%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
			var isSplChar = re.test(yourInput);
			if(isSplChar)
			{
				var no_spl_char = yourInput.replace(/[`~!@#%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
				$(this).val(no_spl_char);
			}
		});	
	 	   
	$('#intialkm2').on('change', function (){
																		   var a = $(this).val();
																		   $('.intrate').html('Intial '  +  a +' Km Rate');
																		   
																			  
																	  });	
	$('.regcom').on('change', function (){
																		   var a = $(this).val();
																		   if(a != '') {
																			   $(this).removeClass('error-admin');
																		   } else {
																			    $(this).addClass('error-admin');
																		   }
																			  
																	  });		

 $('#standardrate').bind('keypress', function(e) { 
return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
  });
	$('#fromstandardrate').bind('keypress', function(e) { 
return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
  });
	
	
	
$("#taxiadd").click(function(){
						
 var  standardrate=  $('#standardrate').val();
	  fromstandardrate=  $('#fromstandardrate').val();
    // only validate going forward. If current group is invalid, do not go further
    // .parsley().validate() returns validation result AND show errors
	
	
	
     if(!standardrate){
	   
	   $( "#standardrate" ).addClass('error-admin');
	    $("#standardrate").focus();
		return false;
   }
    if(!fromstandardrate){
	   
	   $( "#fromstandardrate" ).addClass('error-admin');
	    $("#fromstandardrate").focus();
		return false;
   }
 
 
 
 
 
 
 var value =$("#taxi_reg").serialize() ;

$.ajax({
url:'<?php echo base_url();?>admin/update_taxi',
type:'post',
data:value,
success:function(res){
	$(".taxi").show();
console.log(res);
if(res==1){
		$(".taxi").html('<p class="success">Update Successfully</p>');
	setTimeout(function(){$(".taxi").hide(); }, 1500);
	//window.location.href="<?php echo base_url();?>index.php/admin/pointview";
}else if(res==2){
$(".taxi").html('<p class="error">Car Type Exists</p>');
setTimeout(function(){$(".taxi").hide(); }, 1500);
}
else{

	
	
	
	
$(".taxi").html('<p class="error">Errorr </p>');
setTimeout(function(){$(".taxi").hide(); }, 1500);
}
}
});
});
});

</script>

  </body>
</html>

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
           Edit Airport Transfer
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
                </div>
                       
                       
						
						<!-- /.box-header -->
                <!-- form start -->
				  <?php
				  $query1 = $this->db->query(" SELECT * FROM `settings` order by id DESC ");
		$row11 = $query1->row('settings');
		$mesr = $row11->measurements;
								$id = $_GET['idtaxi'];
						  
		 $query = $this->db->query("SELECT * FROM  cabdetails WHERE  id ='$id'");
		 $row = $query->row('cabdetails');
								?>
              <form role="form"  method="post" id="taxi_reg">
                  <div class="box-body">
				  
                                        <div class="form-group">
                                            <label>Car Type</label>
                                             <select class="form-control  select2"  style="width: 100%;" id="cartype" name="cartype">
                                              
												 
												 <?php
										   	$query2 = $this->db->query("SELECT DISTINCT`car_type` FROM car_categories");
                                                    foreach($query2->result_array('car_categories') as $row1){
										   ?>
                                              <option value="<?php echo $row1['car_type'];?>" <?php if($row->cartype == $row1['car_type']) echo 'selected'; ?> ><?php echo $row1['car_type'];?></option>
                                             
                                             <?php
													}?>
                                                 </select>
                                        </div>
										  <div class="form-group">
                                       <h4><u>To Airport Transfer</u></h4>
                                       </div>
									    <div class="form-group">
                                            <label> Intial <?php echo $mesr;?></label>
                                            <input class="form-control regcom"  name="intialkm"  id="intialkm2" value="<?php echo $row->intialkm; ?>">
                                            <input  id="id" name="id" type="hidden" value="<?php echo $row->id; ?>">
                                        </div>
										   <div class="form-group">
                                            <label class="intrate"> Intial <?php echo $mesr;?> Rate</label>
                                            <input class="form-control regcom" value="<?php echo $row->	intailrate; ?>" name="intailrate" id="intailrate">
                                        </div>
										  <div class="form-group">
                                            <label> Standard Rate</label>
                                            <input class="form-control regcom" value="<?php echo $row->standardrate; ?>" name="standardrate"  id="standardrate">
                                           <input  id="transfertype" name="transfertype" type="hidden" value="<?php echo $row->transfertype; ?>">
                                        
                                        </div>
					 <div class="form-group">
                                       
                                        <input type="button" class="btn btn-primary" value="Save Details"  name="Save" id="taxiadd">
                                       
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
				                           <div class="form-group">
                                            <label>Time</label>
                                           <select class="form-control regcom select2"  style="width: 100%;" id="timetype" name="timetype">
                                           
                                               <option value="day" <?php if($row->timetype == 'day') echo 'selected'; ?>>Day(6:00AM-10:00PM)</option>
                                              <option value="night" <?php if($row->timetype == 'night') echo 'selected'; ?>>Night(10:00PM-6:00AM)</option>
                                              
                                                 </select>
                                        </div>
										  <div class="form-group">
                                       <h4><u>From Airport Transfer</u></h4>
                                       </div>
									    <div class="form-group">
                                            <label> Intial <?php echo $mesr;?></label>
                                            <input class="form-control regcom"  value="<?php echo $row->fromintialkm; ?>" name="fromintialkm"  id="fromintialkm2">
                                           
                                        </div>
										 
                                         <div class="form-group">
                                            <label class="intrate2"> Intial <?php echo $mesr;?> Rate</label>
                                            <input class="form-control regcom" value="<?php echo $row->fromintailrate; ?>" name="fromintailrate" id="fromintailrate">
                                        </div>
                                         <div class="form-group">
                                            <label> Standard Rate</label>
                                            <input class="form-control regcom" value="<?php echo $row->fromstandardrate; ?>" name="fromstandardrate"  id="fromstandardrate">
                                           <input  id="transfertype" name="transfertype" type="hidden" value="<?php echo $row->transfertype; ?>">
                                        </div>
					
				              </div>  
				           </form>
	                    </div>
			         </div>
			  
			  
			  
			  
			  
			  
			  
                    <!-- /.panel -->
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
			re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
			var isSplChar = re.test(yourInput);
			if(isSplChar)
			{
				var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
				$(this).val(no_spl_char);
			}
		});	
	 
	$('#intialkm2').on('change', function (){
		var km ="<?php echo $row11->measurements; ?>";
																		   var a = $(this).val();
																		   $('.intrate').html('Intial '  +  a + km + ' Rate');
																		   
																			  
																	  });	
		
	$('#fromintialkm2').on('change', function (){
		var km ="<?php echo $row11->measurements; ?>";
																		   var a = $(this).val();
																		   $('.intrate2').html('Intial '  +  a + km + ' Rate');
																		   
																			  
																	  });	
						   
						   
$('.regcom').on('change', function (){
																		   var a = $(this).val();
																		   if(a != '') {
																			   $(this).removeClass('error-admin');
																		   } else {
																			    $(this).addClass('error-admin');
																		   }
																			  
																	  });						   
	 			   

	 $('#intialkm2').bind('keypress', function(e) { 
return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
  });
	 $('#intailrate').bind('keypress', function(e) { 
return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
  });
	 $('#standardrate').bind('keypress', function(e) { 
return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
  });
	 
	 $('#fromintialkm2').bind('keypress', function(e) { 
return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
  });
	 $('#fromintailrate').bind('keypress', function(e) { 
return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
  });
	 $('#fromstandardrate').bind('keypress', function(e) { 
return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
  });
	 
	
	
$("#taxiadd").click(function(){
 var intialkm2 = $('#intialkm2').val();
      intailrate =  $('#intailrate').val();
	   standardrate=  $('#standardrate').val();
	fintialkm2 = $('#fromintialkm2').val();
      fintailrate =  $('#fromintailrate').val();
	   fstandardrate=  $('#fromstandardrate').val();
	
    // only validate going forward. If current group is invalid, do not go further
    // .parsley().validate() returns validation result AND show errors
	
	
    if(!intialkm2){
	   
	   $( "#intialkm2" ).addClass('error-admin');
	    $("#intialkm2").focus();
		return false;
   }
   
   
   if(!intailrate){
	   
	   $( "#intailrate" ).addClass('error-admin');
	    $("#intailrate").focus();
		return false;
   }
   if(!standardrate){
	   
	   $( "#standardrate" ).addClass('error-admin');
	    $("#standardrate").focus();
		return false;
   }
    if(!fintialkm2){
	   
	   $( "#fromintialkm2" ).addClass('error-admin');
	    $("#fromintialkm2").focus();
		return false;
   }
   
   
   if(!fintailrate){
	   
	   $( "#fromintailrate" ).addClass('error-admin');
	    $("#fromintailrate").focus();
		return false;
   }
   if(!fstandardrate){
	   
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
if(res==0){
		$(".taxi").html('<p class="error">Error</p>');
	setTimeout(function(){$(".taxi").hide(); }, 3000);
}else if(res==2){
$(".taxi").html('<p class="error">Car Type Exists</p>');
setTimeout(function(){$(".taxi").hide(); }, 1500);
}
else{

	
	
	
	
$(".taxi").html('<p class="success">Taxi Details Saved Successfully</p>');
setTimeout(function(){$(".taxi").hide(); }, 1500);
$('#taxi_reg')[0].reset();
}
}
});
});
});





</script>
  </body>
</html>

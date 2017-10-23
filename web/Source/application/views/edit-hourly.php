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
          <h1 class="edit_promo">
          Edit Hourly Rental Transfer11
          </h1>
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">VBD</a></li>
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
				
                </div><!-- /.box-header -->
                <!-- form start -->
				   <?php
								$id = $_GET['id5'];
						  
		 $query = $this->db->query("SELECT * FROM  bookingdetails WHERE  id ='$id'");
		 $row = $query->row('bookingdetails');
								?>
                <form role="form"  method="post" id="hourly_reg">
				
                  <div class="box-body">
				  
                                                                                <div class="form-group">
                                            <label>Package</label>
                                           <input class="form-control regcom" name="package"  value="<?php echo $row->drop_area; ?>" readonly>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label>Pickup Area</label>
                                           <input class="form-control regcom"  name="pickup_area" value="<?php echo $row->pickup_area; ?>" readonly>
                                        </div>
                                        
                             <div class="form-group">
                    <label>Pickup Date</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right regcom datepicker"  name="pickup_date" value="<?php echo $row->pickup_date; ?>" readonly>
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->            
                                         
                                         
                     			
							 <div class="bootstrap-timepicker">
                    <div class="form-group">
                      <label>Pickup Time</label>
                      <div class="input-group">
                        <input type="text" class="form-control timepicker regcom" name="pickup_time"  value="<?php echo $row->pickup_time; ?>" readonly>
                        <div class="input-group-addon">
                          <i class="fa fa-clock-o"></i>
                        </div>
                      </div><!-- /.input group -->
                    </div><!-- /.form group -->
                  </div>

                  
                                        
                                         <div class="form-group">
                                            <label>Car Type </label>
                                            <input class="form-control " name="taxi_type" value="<?php echo $row->taxi_type; ?>" readonly>
                                           
                                        </div>
                                        <div class="form-group">
                                            <label>Area</label>
                                            <input class="form-control " name="area" value="<?php echo $row->area; ?>" readonly>
                                            
                                        </div>
					
				       <div class="form-group">
                                        <input type="button" class="btn btn-primary" value="Save Details"  name="Save" id="hourlyedit">
                                       
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
                                            <label>Landmark</label>
                                            <input class="form-control " name="landmark" value="<?php echo $row->landmark; ?>" readonly>
                                            
                                        </div>
                                         <div class="form-group">
                                            <label>Pickup Address</label>
                                            <input class="form-control" name="pickup_address" value="<?php echo $row->pickup_address; ?>" readonly>
                                            
                                        </div>
                                        
                                         <div class="form-group">
                                            <label>Promo Code</label>
                                            <input class="form-control " name="promo_code" value="<?php echo $row->promo_code; ?>" readonly>
                                            
                                        </div>
                                        
										 <div class="form-group">
                                 <label>Payment Status</label>
                                            <input class="form-control " name="item_status" value="<?php echo $row->item_status; ?>" readonly>
                                           </div>
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input class="form-control"  name="amount" value="<?php echo $row->amount; ?>" id="amount">
                                            <input class="form-control"  name="id" type="hidden" value="<?php echo $row->id; ?>">
											<input class="form-control"  name="status" type="hidden" value="Processing">
											 <input class="form-control"  name="username" type="hidden" value="<?php echo $row->username; ?>">
                                        
                                        </div>
                                         <div class="form-group">
                                            <label>Assigned For</label>
                                            <select id="assigned" class="form-control regcom select2"style="width: 100%;" name="assigned_for">
											<option value='0'>Select Driver</option>
                                            <?php
											if( $row->assigned_for){
												 $ids =$row->assigned_for;
												$querys = $this->db->query("SELECT * from driver_details WHERE id='$ids'");
												 $rowss = $querys->row('driver_details');
												 ?><option value="<?php  echo $rowss->id;?>" <?php if($row->assigned_for == $rowss->id) echo 'selected'; ?>><?php  echo $rowss->name; ?></option>
												
												 <?php
												
											}else{
											$query1 = $this->db->query("SELECT driver_details.* FROM driver_details where NOT EXISTS(select * from bookingdetails where driver_details.id=bookingdetails.assigned_for and bookingdetails.status='Processing') and user_status!='Inactive' and  driver_details.car_type='$row->taxi_type'");
											 foreach($query1->result_array('driver_details') as $row1){
												?><option value="<?php  echo $row1['id'];?>" <?php if($row->assigned_for == $row1['id']) echo 'selected'; ?>><?php  echo $row1['name']; ?></option>
												<?php
											 }
											 }
											?>
                                            </select>
                                        </div>
                                       
										
                                     
				  </form>
	</div>
			  </div>
			  
			  
			  
			  
			  
			  
			  
                    <!-- /.panel -->
                </div>
				</div>
                <!-- /.col-lg-12 -->
            </div>
      </div><!-- /.content-wrapper -->
     <?php
	 include"includes/admin-footer.php";
	 ?>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                    <p>Will be 23 on April 24th</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-user bg-yellow"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                    <p>New phone +1(800)555-1234</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                    <p>nora@example.com</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-file-code-o bg-green"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                    <p>Execution time 5 seconds</p>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Update Resume
                    <span class="label label-success pull-right">95%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Laravel Integration
                    <span class="label label-warning pull-right">50%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Back End Framework
                    <span class="label label-primary pull-right">68%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

          </div><!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Some information about this general settings option
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Allow mail redirect
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Other sets of options are available
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Expose author name in posts
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Allow the user to show his name in blog posts
                </p>
              </div><!-- /.form-group -->

              <h3 class="control-sidebar-heading">Chat Settings</h3>

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Show me as online
                  <input type="checkbox" class="pull-right" checked>
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Turn off notifications
                  <input type="checkbox" class="pull-right">
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Delete chat history
                  <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                </label>
              </div><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
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
 $('#distance').bind('keypress', function(e) { 
return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
  });
	 $('#amount').bind('keypress', function(e) { 
return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
  });			   
						   

$("#hourlyedit").click(function(){
 var assinged =$("#assigned").val() ;
 if(assinged=='0'){
	 alert("Please Select Driver");
	 return false;
	 
 }
 var value =$("#hourly_reg").serialize() ;

$.ajax({
url:'<?php echo base_url();?>admin/update_point',
type:'post',
data:value,
success:function(res){
	$(".editbook").show();
console.log(res);
if(res==1){
		$(".editbook").html('<p class="success">Update Successfully</p>');
	setTimeout(function(){$(".editbook").hide(); }, 1500);
	//window.location.href="<?php echo base_url();?>index.php/admin/pointview";
}
else{
	
$(".editbook").html('<p class="error">Errorr </p>');
setTimeout(function(){$(".editbook").hide(); }, 1500);
}
}
});
});
});
</script>

  </body>
</html>

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
         Add Car
          </h1>
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            
            <li class="active">Add Car</li>
          </ol>
        </section>

        <!-- Main content -->
               <div class="">
			   <div class="">
                <div class="col-lg-12">
           <div class="box box-primary edit_promoform1">
				  <div class="editbook"></div>
                <div class="panel-heading">
                        
   
                        <!-- /.box-header -->
						
               
                        <?php
if(($this->session->flashdata('item'))) {
  $message = $this->session->flashdata('item');
  ?>
<div id="mess" class="<?php echo $message['class'];?>"><?php echo $message['message']; ?></div>
<?php
}else{
}
 
?>                         
		</div>				
	<div class="panel-body">
   <div class="row">
    <form role="form" method="post" action="<?php echo base_url('admin/add_car');?>" class="validate" enctype="multipart/form-data">
      <div class="col-lg-6">
          <div class="form-group">
            <label>Car Type</label>
              <input   name="car_type" type="text" class="form-control " required>
          </div>                                
         <div class="form-group">
            <div class="row">
               <div class="col-lg-12">
                  <div class="col-sm-6">
                     <label>Car Image</label>
                     <input class="regcom"  type="file"  name="car_image" accept="image/*" class="" size="20" required>
                  </div>
                 
               </div>
            </div>
         </div>
         <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Save">
         </div>
      </div>
      </form>
      <div class="col-lg-6">
         
      </div>
      <!-- /.col-lg-6 (nested) -->
      <!-- /.col-lg-6 (nested) -->
   </div>
   <!-- /.row (nested) -->
</div>
</div>
</div>
<!-- /.col-lg-12 -->
</div>
</div><!-- /.content-wrapper -->
</div><!-- ./wrapper -->
	
	
	 <?php
	 include"includes/admin-footer.php";
	 ?>

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
    <script src="<?php echo base_url();?>assets/vplugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url();?>assets/adminlte/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url();?>assets/adminlte/dist/js/demo.js"></script>
    <!-- page script -->
   <script src="<?php echo base_url();?>assets/adminlte/plugins/select2/select2.full.min.js"></script>
    
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

</div>
  </body>
</html>

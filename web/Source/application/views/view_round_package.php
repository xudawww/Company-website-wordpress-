<!DOCTYPE html>
<html>
  <?php
	 include"includes/admin_header.php";
	 ?>
	 <link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/plugins/datatables/dataTables.bootstrap.css">
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
          <h1>
            Package Details
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">UM</a></li>
            <li class="active">View All</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              

              <div class="box">
                <div class="box-header">
                
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
				  
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Package</th>
                        <th>Pick Point</th>
						            <th>Action</th>
                      </tr>
                    </thead>  
      					<?php
                  $i=0;
                  foreach($package as $packg){
                  $i++;  
                ?>
                                    
                    <tr class="odd gradeX" >
                        <td class="center"> <?php echo $i;?></td>
                        <td class="center"> <?php echo $packg->package;?></td>
                        <td class="center"> <?php echo $packg->pick_point;?></td>
                        <td class="center"><a href="<?php echo base_url();?>admin/edit_view_round_car/<?php echo $packg->id;?>">
                          <i class="fa fa-pencil-square-o"></i></a>&nbsp;&nbsp;<a href="#" title="<?php echo $packg->id;?>" class="delete">
                          <i class="fa fa-trash-o "></i></a></td>
                    </tr>
                <?php
  	            }
  							?> 
     	
                   
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
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
    <script>
      $(function () {
        $("#example1").DataTable({
			"ordering": false
			});
        
      });
    </script>
	

   
<script>
$(function () {
	
 $(document).on('click',"#example1 .delete",function(){
							
			var r = confirm("Are you sure want to delete the user details ");
			if (r == true) {
				var th=$(this);			
				var id = $(this).attr('title');
				
				
				$.ajax({
					url:'<?php echo base_url();?>admin/round_package_delete',
					type:'post',
					data:{'id':id},
					success:function(cancel){
					console.log(cancel);
					if(cancel==1){
					th.hide();
					location.reload();
					
					
					
					}
					else{
					alert("err");
					}
					}
				});  								
			}
						   
});				
    });
    </script>

</body>

</html>
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
                  Edit Package
               </h1>
               <ol class="breadcrumb">
                  <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li><a href="#">PM</a></li>
                  <li class="active">Edit New</li>
               </ol>
            </section>
            <!-- Main content -->
            <div class="">
               <div class="">

                    <?php
                  if(($this->session->flashdata('item'))) {
                    $message = $this->session->flashdata('item');
                    ?>
                  <div id="mess" class="<?php echo $message['class'];?>"><?php echo $message['message']; ?></div>
                  <?php
                  }else{
                  }
 
                  ?>                      
                  <div class="col-lg-6">
                     <div class="box box-primary edit_promoform1">
                        <div class="box-header with-border">
                           <h3 class="box-title"></h3>
                           <div class="promo-add"></div>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form"  method="post" action="<?php echo base_url('admin/round_package_edit/'.$edit_package->id);?>">
                           <div class="box-body">
                              <div class="form-group">
                                 <label>Package</label>
                                 <input class="form-control regcom" placeholder="Package" name="package" value="<?php echo $edit_package->package;?>">
                              </div>
                  
                               <div class="form-group">
                                 <label>Pick Point</label>
                                 <input class="form-control regcom" placeholder="Pick Point(Eg:-a2-a2,b1-b2)" name="pick_point" value="<?php echo $edit_package->pick_point;?>">
                              </div>
                              
                              <div class="form-group">
                                 <input type="submit" class="btn btn-primary" value="Save">
                                 
                              </div>
                           </div>
                          </form> 
                     </div>
                  </div>
                  <!-- /.box -->
                 <!--  <div class="col-lg-6">
                  <div class="box box-primary edit_promoform">
                  <div class="box-header with-border">
                  <h3 class="box-title"></h3>
                  </div>
                 
                  </form>
                  </div>
                  </div> -->
                  <!-- /.panel -->
               </div>
            </div>
         </div>
         <!-- /.content-wrapper -->
         <?php
            include"includes/admin-footer.php";
            ?>
      </div>
      <!-- ./wrapper -->
      <!-- jQuery 2.1.4 -->
      <script src="<?php echo base_url();?>assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
      <!-- Bootstrap 3.3.5 -->
      <script src="<?php echo base_url();?>assets/adminlte/bootstrap/js/bootstrap.min.js"></script>
      <!-- DataTables -->
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
      <script src="<?php echo base_url();?>assets/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
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
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.datetimepicker.css"/>
      <script src="<?php echo base_url();?>assets/js/jquery.datetimepicker.js"></script>
      <script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
      <script type="text/javascript">
         $(document).ready(function(){
         $( ".datepicker" ).datetimepicker({ minDate:0});
        
      
         });
         
      </script>
   </body>
</html>
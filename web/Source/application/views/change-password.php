<!DOCTYPE html>
<html>
  <?php
	 include"includes/admin_header.php";
   ?>
<script src="<?php echo base_url();?>assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
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
          Change Password
          </h1>
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">admin</a></li>
            <li class="active">Change Password</li>
          </ol>
        </section>

        <!-- Main content -->
             <div class="">
			   <div class="">
                <div class="col-lg-6">
           <div class="box box-primary edit_promoform1">
				 
                <div class="box-header with-border">
                  <h3 class="box-title"></h3>
				   <div class="promo-add"></div>
                </div><!-- /.box-header -->
                <!-- form start -->
				
                 
				  
				  
				  
				  
				  
				  <form role="form"  method="post" id="pass_reg">
                                        
                                      <div class="box-body">  
                                        <div class="form-group">
                                            <label>Current Password</label>
                                             <input class="form-control regcom paste-copy" name="password" id="password" type="password">
                                        </div>
                                         <div class="form-group">
                                            <label>Change password</label>
                                            <input class="form-control regcom paste-copy"  name="change" id="change" type="password">
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm password</label>
                                            <input class="form-control regcom paste-copy"  name="confirma" id="confirma" type="password">
                                        </div>
                                         
                                        
                                        <button type="reset" class="btn btn-primary">Reset </button>
                                        <input type="button" class="btn btn-primary" value="Submit "  name="Save" id="change-pass">
                                        
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
	
	 <script src="<?php echo base_url();?>assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>
     <script src="<?php echo base_url();?>assets/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- page script -->
	  <script src="<?php echo base_url();?>assets/adminlte/dist/js/sb-admin-2.js"></script>
    <!-- page script -->
   <script src="<?php echo base_url();?>assets/adminlte/plugins/select2/select2.full.min.js"></script>
    <!-- page script -->
   <script type="text/javascript">
$(document).ready(function(){
       $('.paste-copy').bind('cut copy paste', function(event) {
           event.preventDefault();
        });
	
	 $('.regcom').on('change', function (){
		   var a = $(this).val();
		   if(a != '') {
			   $(this).removeClass('error-admin');
		   } else {
				$(this).addClass('error-admin');
		   }
       });
	    $("#change-pass").click(function(){
 
			var password =$("#password").val() ;
			var change =$("#change").val() ;
			var confirma =$("#confirma").val() ;
			if(!password){

				$( "#password" ).addClass('error-admin');
				$("#password").focus();
			    return false;
			}
			if(!change){

				$( "#change" ).addClass('error-admin');
				$("#change").focus();
				return false;
			
			}
			if(!confirma){

				$( "#confirma" ).addClass('error-admin');
				$("#confirma").focus();
				return false;
			}



			$.ajax({
				url:'<?php echo base_url();?>admin/check_password',
				type:'post',
				data:{'password':password,'change':change,'confirma':confirma},
				success:function(password){
					$(".c-pass").show();
					console.log(password);
					if(password == 1){

						$(".c-pass").html('<p class="success">Password change successfully</p>');
						setTimeout(function(){location.reload(); }, 3000);

					}else if(password == 2){
						$(".c-pass").html('<p class="error">Newpassword and confirm password are not correct</p>');
						setTimeout(function(){$(".c-pass").hide(); }, 3000);
					}
					else if(password == 3){
						$(".c-pass").html('<p class="error">Current Password not correct</p>');
						setTimeout(function(){$(".c-pass").hide(); }, 3000);
					}else{
						$(".c-pass").html('<p class="error">Fail to update</p>');
						setTimeout(function(){$(".c-pass").hide(); }, 3000);
					}
				}
			});
		});
   });


</script>

</body>
</html>

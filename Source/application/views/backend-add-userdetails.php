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
	  $query1 = $this->db->query("SELECT * FROM  role where rolename!='admin'");
	 ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1 class="add_promocode">
         Add User Details
          </h1>
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">BU</a></li>
            <li class="active">Add New</li>
          </ol>
		
        </section>
		
	

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
                                            <label>Username</label>
                                           <input class="form-control regcom sample" placeholder="Username" name="username" id="signup-username">
                                        </div>
                                         <div class="form-group">
                                            <label>Password</label>
                                           <input class="form-control regcom" placeholder="Password" name="password" id="signup-password" type="password">
                                        </div>
                                         <div class="form-group">
                                            <label>Role</label>
											  <select class="form-control select2"  style="width: 100%;" name="role" id="signup-role">
													<?php   foreach($query1->result_array('role') as $role_get){ ?>
                                               <option value="<?php echo $role_get['rolename']; ?>" ><?php echo $role_get['rolename']; ?></option>
													<?php } ?>
                                               
                                             </select>
										  
                                        </div>
                                        
                                         <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control regcom" placeholder="E-mail" name="email"  id="signup-email">
                                            
                                        </div>
                                      
							 <div class="form-group">
                    <label>Mobile</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-phone"></i>
                      </div>
                      <input type="text" class="form-control regcom" placeholder="Mobile" name="mobile" id="signup-mobile">
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->			
										
                                       <div class="form-group">
                                       
                                        <input type="button" class="btn btn-primary" value="Submit"  name="Save" id="useradd">
                                        <button type="reset" class="btn btn-primary">Reset </button>
                                        </div>
                                        </div> 
                                  
				</div>   
	</div>
              </div><!-- /.box -->
			  
			  
				  </form>

                </div>
				</div>
				  
			 <?php
	 include"includes/admin-footer.php";
	 ?>	   
			
      </div><!-- /.content-wrapper -->
    

   <!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      
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
      });
    </script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" />
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
	
<link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/css/jquery-ui.css" />
<script src="<?php echo base_url();?>assets/adminlte/js/jquery-ui.js"></script>
    
    
<script type="text/javascript">
$(document).ready(function(){
	    $(".regcom").on("keydown", function (e) {
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
        $('.regcom').on('change', function (){
		   var a = $(this).val();
		   if(a != '') {
			   $(this).removeClass('error-admin');
		   } else {
				$(this).addClass('error-admin');
		   }
			  
	   });						   


	 function ValidateEmail(email) {
			var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
			return expr.test(email);
		};
		$("#signup-username").on("keydown", function (e) {
		return e.which !== 32;
		});
			$("#useradd").click(function(){
			var username = $('#signup-username').val();
			mobile = $('#signup-mobile').val();
			email = $('#signup-email').val();
			password =  $('#signup-password').val();
			var pattern = /^\d{10}$/;


			if(!username){

			  $( "#signup-username" ).addClass('error-admin');
				$("#signup-username").focus();
				return false;
			}
			if(!password){
				
			   $( "#signup-password" ).addClass('error-admin');
				$("#signup-password").focus();
				return false;
			} if(!ValidateEmail(email)){
			   
			   $( "#signup-email" ).addClass('error-admin');
				$("#signup-email").focus();
				return false;
			}


			if(!pattern.test(mobile)){
			   
			   $( "#signup-mobile" ).addClass('error-admin');
				$("#signup-mobile").focus();
				return false;
			}


            var value =$("#user_reg").serialize() ;

			$.ajax({
				url:'<?php echo base_url();?>admin/insert_backend_user',
				method:'post',
				data:value,
				success:function(res){
					$(".adminuser1").show();
					console.log(res);
					if(res==3){
						$(".adminuser1").focus();
						$(".adminuser1").html('<p class="error">User Already Exist!!!</p>');
						setTimeout(function(){$(".adminuser1").hide(); }, 3000);
					}
					if(res==0){
						$(".adminuser1").focus();
						$(".adminuser1").html('<p class="error">Sorry Error Occured!!!</p>');
						setTimeout(function(){$(".adminuser1").hide(); }, 3000);
					} if(res==4){
						$(".adminuser1").focus();
					   $(".adminuser1").html('<p class="error">Email Already Exist!!!</p>');
					   setTimeout(function(){$(".adminuser1").hide(); }, 3000);
					}else{
						$(".adminuser1").focus();

						$(".adminuser1").html('<p class="success">User Registered Successfully</p>');
						setTimeout(function(){$(".adminuser1").hide(); }, 1500);
						$('#user_reg')[0].reset();
						 window.location.href="<?php echo base_url();?>index.php/admin/backened_user";
					}
				}
			});
	   });
   });


</script>


  </body>
</html>

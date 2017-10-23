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
          Edit User Details
		   </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">UM</a></li>
            <li class="active">Edit</li>
          </ol>
        </section>

        <!-- Main content -->
               <div class="">
			   <div class="">
                <div class="col-lg-6">
           <div class="box box-primary edit_promoform1">
				  <div class="panel panel-default">
						
						 <div class="box-header with-border">
                  <h3 class="box-title"></h3>
				    <div class="edituser"></div>
                </div>
                <!-- form start -->
				 <?php
								 $id = $_GET['id2'];
						  
		 $query = $this->db->query("SELECT * FROM  userdetails WHERE  id ='$id'");
		 $row = $query->row('userdetails');
								?>
                <form role="form"  method="post" id="user_reg">
				
                  <div class="box-body">
				  
                    <div class="form-group">
                                            <label>Username</label>
                                           <input class="form-control regcom sample" placeholder="Username" name="username" id="signup-username" readonly value="<?php echo $row->username; ?>" >
                                        </div>
                                         <div class="form-group">
                                            <label>Password</label>
                                           <input class="form-control regcom" placeholder="Password" name="password" id="signup-password" type="password"  value="<?php echo $row->password; ?>" >
                                        </div>
                                        
                                         <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control regcom" placeholder="E-mail" name="email"  readonly id="signup-email" value="<?php echo $row->email; ?>">
                                            
                                        </div>
                                      
										
	              <div class="form-group">
                    <label>Mobile</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-phone"></i>
                      </div>
                      <input type="text" class="form-control regcom sample" placeholder="Mobile" name="mobile" readonly id="signup-mobile" value="<?php echo $row->mobile; ?>">
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
				  
				  
					
				  <div class="form-group">
                      <input type="button" class="btn btn-primary" value="Save Details"  name="Save" id="useredit">
					  <input  name="id"   value="<?php echo $row->id; ?>" type="hidden">
                  </div>
				                         
                                       
                                        
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
				
            
				
                  <div class="box-body admin_edituserdetails">
				  
                  
					
					 <div class="form-group">
                    <label>Date of Birth</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right regcom datepicker"  placeholder="DD/MM/YYYY" name="dob"  id="optionD" value="<?php echo $row->dob; ?>"  name='pickup_date'>
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
					
					
					
					
					 <div class="form-group">
                    <label>Anniversary Date</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right regcom datepicker"  placeholder="DD/MM/YYYY" name="anniversary_date"  id="result" value="<?php echo $row->anniversary_date; ?>">
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
                                        
					
					  <div class="form-group">
                                            <label>Gender</label><br>

                                            <label class="radio-inline">
                                                <input type="radio" name="gender" id="optionsRadiosInline1" value="male"  <?php if($row->gender=='male') {echo "checked";} ?> >Male
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="gender" id="optionsRadiosInline2" value="female"  <?php if($row->gender=='female'){echo "checked";} ?>>Female
                                            </label>
                                            
                                        </div>
					
                  

                  
				  
				</div>  
				  </form>
	</div>
			  </div>
			  
			  
			  
			  
			  
			  
			  
                    <!-- /.panel -->
                </div>
				</div>
                <!-- /.col-lg-12 -->
            </div>
      
     <?php
	 include"includes/admin-footer.php";
	 ?>

   </div><!-- /.content-wrapper -->
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
      });
    </script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" />
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
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
	$('body').keydown(function (e) {
         var key = e.which;
         switch (e.which) {
           case 123:
           alert("Sorry.You can't inspect this.For security reasons");
             e.preventDefault();
            break;
         }
       });
       $('body').mousedown(function(event) {
       switch (event.which) {
       case 3:
       alert("Sorry.You can't inspect this.For security reasons");
       break;
       default:
       }
       });
		$( ".datepicker" ).datepicker({
			
			changeMonth: true,
			changeYear: true,
			yearRange: '1910:2010'
        });			   
 
        $('.regcom').on('change', function (){
		   var a = $(this).val();
		   if(a != '') {
			   $(this).removeClass('error-admin');
		   } else {
				$(this).addClass('error-admin');
		   }
        });						   

			$('#useredit').click(function(){	
              var mobile = $('#signup-mobile').val();
			  var pattern = /^\d{10}$/;
			 if(!pattern.test(mobile)){
				   $("#signup-mobile").addClass('error-admin');
				   $("#signup-mobile").focus();
				   return false;
			   }
 	
			  var value =$("#user_reg").serialize() ;

				$.ajax({
					url:'<?php echo base_url();?>index.php/admin/updateuser',
					type:'post',
					data:value,
					success:function(contact){
						$(".edituser").show();
						console.log(contact);
						/*if(contact==1){
							$(".edituser").html('<p class="success">User details updated successfully</p>');
							setTimeout(function(){$(".adminuser1").hide(); }, 3000);
							window.location.href="<?php echo base_url();?>index.php/admin/userlist";

						}
						else{
							$(".edituser").html('<p class="error">Sorry Error Occured!!!</p>');
							setTimeout(function(){$(".adminuser1").hide(); }, 1500);
						}*/
						
						if(contact==3){
				$(".edituser").html('<p class="error">User Already Exist!!!</p>');
				setTimeout(function(){$(".adminuser1").hide(); }, 3000);
			}
			else if(contact==0){
				$(".edituser").html('<p class="error">Sorry Error Occured!!!</p>');
				setTimeout(function(){$(".adminuser1").hide(); }, 3000);
			}else if(contact==4){
				$(".edituser").html('<p class="error">Email Already Exist!!!</p>');
				setTimeout(function(){$(".adminuser1").hide(); }, 3000);
			}else if(contact==1){

				$(".edituser").html('<p class="success">User details updated successfully</p>');
				setTimeout(function(){$(".adminuser1").hide(); }, 1500);
				$('#user_reg')[0].reset();
				location.reload();
			}
			else{
				$(".edituser").html('<p class="error">Sorry Error Occured!!!</p>');
				setTimeout(function(){$(".adminuser1").hide(); }, 3000);
			}
						
						
					}
				});  
			});  
});


</script>

  </body>
</html>

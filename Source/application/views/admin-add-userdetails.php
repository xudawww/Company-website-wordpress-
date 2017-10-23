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
           Add User Details
          </h1>
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">UM</a></li>
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
				   <div class="adminuser1"></div>
                </div><!-- /.box-header -->
                <!-- form start -->
				
                <form role="form"  method="post" id="user_reg" data-parsley-validate="">
				
                  <div class="box-body">
				  
                    <div class="form-group">
                      <label for="exampleInputEmail1">username</label>
                      <input id="signup-username" name="username"  class="form-control regcom sample" data-parsley-pattern="^[a-zA-Z]+$" data-parsley-minlength="6"  data-parsley-maxlength="15"	 required="" placeholder="Username">
                    </div>
					
					<div class="form-group">
                      <label for="exampleInputEmail1">Password</label>
                      <input type="password" name="password" class="form-control regcom "  data-parsley-minlength="6"  data-parsley-minlength="6"	  data-parsley-maxlength="15"	 required="" id="signup-password" placeholder="Password">
                    </div>
					<div class="form-group">
                      <label for="exampleInputEmail1">Email</label>
                      <input type="email" name="email" class="form-control regcom " id="signup-email" placeholder="Email" required="" >
                    </div>
                   
				 <div class="form-group">
                    <label>Mobile</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-phone"></i>
                      </div>
                      <input type="text" class="form-control regcom sample" placeholder="Mobile" name="mobile" id="signup-mobile" required="">
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->	  
                  
				  <div class="form-group">
                      <input type="button" class="btn btn-primary" value="Submit"  name="Save" id="useradd">  
                      <button type="reset" class="btn btn-primary">Reset</button>					  
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
                    <label>Date of Birth</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right regcom datepicker"  placeholder="DD/MM/YYYY" name="dob"  id="optionD">
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
				  
					                   
                                        
				     
	
					 <div class="form-group">
                    <label>Anniversary Date</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right regcom datepicker"  placeholder="DD/MM/YYYY" name="anniversary_date"  id="result">
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->

				  
										<div class="form-group">
                                            <label>Gender</label><br>

                                            <label class="radio-inline">
                                                <input type="radio" name="gender" id="optionsRadiosInline1" value="male" >Male
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="gender" id="optionsRadiosInline2" value="female">Female
                                            </label>
                                            
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
    <script src="<?php echo base_url();?>assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	 <script src="<?php echo base_url();?>assets/js/parsley.min.js"></script>
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
		$( ".datepicker" ).datepicker({
			
			changeMonth: true,
			changeYear: true,
			yearRange: '1910:2010'

		});			   
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
       						   
	   
		$("#useradd").click(function(){
		
		   if ($('#user_reg').parsley().validate() ) {		
		  var value =$("#user_reg").serialize() ;

		$.ajax({
			url:'<?php echo base_url();?>index.php/admin/insertuser',
			method:'post',
			data:value,
			success:function(res){
				$(".adminuser1").show();
			console.log(res);
			if(res==3){
				$(".adminuser1").html('<p class="error">User Already Exist!!!</p>');
				setTimeout(function(){$(".adminuser1").hide(); }, 3000);
			}
			else if(res==0){
				$(".adminuser1").html('<p class="error">Sorry Error Occured!!!</p>');
				setTimeout(function(){$(".adminuser1").hide(); }, 3000);
			}else if(res==4){
				$(".adminuser1").html('<p class="error">Email Already Exist!!!</p>');
				setTimeout(function(){$(".adminuser1").hide(); }, 3000);
			}else{

				$(".adminuser1").html('<p class="success">User Registered Successfully</p>');
				setTimeout(function(){$(".adminuser1").hide(); }, 1500);
				$('#user_reg')[0].reset();
        window.location.href="<?php echo base_url();?>index.php/admin/userlist";
			}
			}
			});
		   }
		});
		
});


</script>


  </body>
</html>

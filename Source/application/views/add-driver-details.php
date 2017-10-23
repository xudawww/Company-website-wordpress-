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
           Add Driver Details
          </h1>
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="#">DM</a></li>
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
				   <div class="taxi"></div>
                </div><!-- /.box-header -->
                <!-- form start -->
				
                 <form role="form"  method="post" id="taxi_reg">
				
                  <div class="box-body">
				  
                                        <div class="form-group">
                                        <label>Name</label>
                                        <!--  <input  id="name" name="name" type="text" class="form-control"> -->
                                        <input  id="name" name="name" type="text" class="form-control  samples">
                                       
                                        </div>
                                       <div class="form-group">
                                        <label>Username</label>
                                        <input  id="user_name" name="user_name" type="text" class="form-control regcom samples">
                                        </div><div class="form-group">
                                        <label>Password</label>
                                        <input  id="password" name="password" type="password" class="form-control regcom">
                                        </div>
                                         <div class="form-group">
                                            <label>Address</label>
                                          <textarea class="form-control  samples" rows="3" name="address" id="address"></textarea>
                                        </div>
										<div class="form-group">
                                       <label>Phone</label>
                     <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-phone"></i>
                      </div>
                      <input type="text" class="form-control regcom samples"  name="phone"  id="phone" >
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
                                        
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control regcom"  name="email"  id="email">
                                           
                                        </div>
                                       <div class="form-group">
                                       
                                        <input type="button" class="btn btn-primary" value="Save "  name="Save" id="taxiadd">
                                        <button type="reset" class="btn btn-primary">Reset </button>
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
                                            <label class="intrate">License No</label>
                                            <input class="form-control regcom" name="license_no" id="license">
                                        </div>
                                            <div class="form-group ">
										  
												   
                                            <label>Car Type</label>
											<select id="cartype" class="form-control select2"  style="width: 100%;" name="car_type">
						                    <option value='0'>Car Type</option>
											<?php
											$query1 = $this->db->query("SELECT * FROM car_categories");
							             foreach($query1->result_array('cabdetails') as $row1){
												?><option value="<?php  echo $row1['car_type'];?>" ><?php  echo $row1['car_type']; ?></option>
												<?php
											 }
											 ?>
											</select>
                                        </div>
                                         <div class="form-group">
                                            <label>Car No</label>
                                            <input class="form-control regcom"  name="car_no"  id="carno">
                                           
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
	 include "includes/admin-footer.php";
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
    
	 <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" />
        <script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
    
     <script type="text/javascript">
$(document).ready(function(){
$(".regcom").on("keydown", function (e) {
        return e.which !== 32;
	    });  
	
        $('.samples').keyup(function()
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
		 var a = $(this).val();
		 $('.intrate').html('Intial '  +  a +' Km Rate');
		 });						   
						   
						   
$('.regcom').on('change', function (){
   var a = $(this).val();
   if(a != '') {
   $(this).removeClass('error-admin');
  
   } else {
    $(this).addClass('error-admin');
	return false;
	}
	});						   
$("#name").on("keydown", function (e) {
 return e.which !== 32;
	});		   

 $('#phone').bind('keypress', function(e) { 
return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
  });
	 $('#license').bind('keypress', function(e) { 
return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
  });
	
	function ValidateEmail(email) {
       var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
       return expr.test(email);
   };
	
$("#taxiadd").click(function(){
 var name = $('#name').val();
    user = $('#user_name').val();
	password = $('#password').val();
    address =  $('#address').val();
    phone=  $('#phone').val();
	email = $('#email').val();
	license=  $('#license').val();
	cartype=  $('#cartype').val();
	carno=  $('#carno').val();
	var regex = new RegExp("^[a-zA-Z]+$");
	
    
    if(!regex.test(name)){
	  $( "#name" ).addClass('error-admin');
	   $("#name").focus();
		return false;
   }
   
   if(!user){
	 $( "#user_name" ).addClass('error-admin');
	 $("#user_name").focus();
		return false;
   }
   if(!password){
	 $( "#password" ).addClass('error-admin');
	 $("#password").focus();
		return false;
   }
   
   
   if(!address){
	   
	   $("#address").addClass('error-admin');
	    $("#address").focus();
		return false;
   }
   if(!phone){
	   
	   $("#phone").addClass('error-admin');
	    $("#phone").focus();
		return false;
   }
   if(!ValidateEmail(email)){
       
       $( "#email" ).addClass('error-admin');
        $("#email").focus();
        return false;
  }
  
  
 if(!license){
	   
	   $( "#license" ).addClass('error-admin');
	    $("#license").focus();
		return false;
   }
  
 if(!cartype){
	   
	   $( "#cartype" ).addClass('error-admin');
	    $("#cartype").focus();
		return false;
   }
  
 if(!carno){
	   
	   $( "#carno" ).addClass('error-admin');
	    $("#carno").focus();
		return false;
   }
 
 
 var value =$("#taxi_reg").serialize() ;

$.ajax({
url:'<?php echo base_url();?>admin/insert_driver',
type:'post',
data:value,
success:function(res){
$(".taxi").show();
console.log(res);
if(res==0){
$(".taxi").html('<p class="error">Error</p>');
setTimeout(function(){$(".taxi").hide(); }, 3000);
}else if(res==2){
$(".taxi").html('<p class="error">Driver Exists</p>');
setTimeout(function(){$(".taxi").hide(); }, 3000);
}
else if(res==3){
$(".taxi").html('<p class="error">Username Exists</p>');
setTimeout(function(){$(".taxi").hide(); }, 3000);
}
else{

$(".taxi").html('<p class="success">Driver Details Saved Successfully</p>');
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

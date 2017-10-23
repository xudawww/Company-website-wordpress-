<?php
if($this->session->userdata('username-admin') ||   $this->input->cookie('username-admin', false)){
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url();?>assets/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>assets/dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?php echo base_url();?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

   
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php
	 include"uploads/admin_header.php";
	 ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"> Add New Role</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        Add New Role
                        <div class="adminuser1"></div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form"  method="post" id="role_reg">
                                        
                                       
                                        <div class="form-group">
                                            <label>Rolename</label>
                                           <input class="form-control regcom" placeholder="Role" name="rolename" id="signup-username">
                                        </div>
                                         <div class="form-group">
                                        <label>Pages</label>
                                        
                                        </div>
                                        <div class="checkbox">
<label>
<input type="checkbox" value="1" name="page_id[]">
dashboard.php
</label>
</div>
 <div class="checkbox">
<label>
<input type="checkbox" value="2" name="page_id[]">
 add-promocode.php
</label>
</div>
<div class="checkbox">
<label>
<input type="checkbox" value="1,2" name="page_id1">
 All
</label>
</div>
                                     <div class="form-group">
                                       
                                        <input type="button" class="btn btn-primary" value="Add Role"  name="Save" id="useradd">
                                        <button type="reset" class="btn btn-primary">Reset </button>
                                        </div>
                                        
                                        
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                              
                               
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url();?>assets/dist/js/sb-admin-2.js"></script>
    
    
    
    
    
    
    
      <!--/column1-->
      <!-- /datepicker -->
      
    
      
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" />
        <script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
     <script type="text/javascript">
$(document).ready(function(){
					   
$('.regcom').on('change', function (){
var a = $(this).val();
	if(a != '') {
	$(this).removeClass('error-admin');
	 } else {
	$(this).addClass('error-admin');
	}
	});						   
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
 function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
	$("#signup-username").on("keydown", function (e) {
    return e.which !== 32;
	});
$("#useradd").click(function(){
 var username = $('#signup-username').val();
	
   if(!username){
	
	  $( "#signup-username" ).addClass('error-admin');
	  $("#signup-username").focus();
		return false;
   }
 var value =$("#role_reg").serialize() ;

$.ajax({
url:'<?php echo base_url();?>admin/insert_role',
method:'post',
data:value,
success:function(res){
$(".adminuser1").show();
console.log(res);
if(res==2){
   $(".adminuser1").html('<p class="error">Role Already Exist!!!</p>');
   setTimeout(function(){$(".adminuser1").hide(); }, 3000);
}
else if(res==0){
   $(".adminuser1").html('<p class="error">Sorry Error Occured!!!</p>');
   setTimeout(function(){$(".adminuser1").hide(); }, 3000);
}else{
  $(".adminuser1").html('<p class="success">Role Added Successfully</p>');
  setTimeout(function(){$(".adminuser1").hide(); }, 1500);
  $('#user_reg')[0].reset();
}
}
});
});
});
</script>


</body>

</html>
<?php
}
else{
	$this->load->view('admin-login');
}
?>
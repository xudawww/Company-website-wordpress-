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
            Add Airport Details
          </h1>
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">AM</a></li>
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
				   <div class="adminuser"></div>
                </div><!-- /.box-header -->
                <!-- form start -->
				         
                 <form role="form"  method="post" id="user_reg">
                               <div class="box-body">          
                                       
                                        <div class="form-group">
                                            <label>Airport Name</label>
                                           <input class="form-control " placeholder="Airport Name" name="name" id="signup-username">
                                        </div>
                                         
                                       <div class="form-group">
                                       
                                        <input type="button" class="btn btn-primary" value="Submit"  name="Save" id="useradd">
                                        <button type="reset" class="btn btn-primary">Reset </button>
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
      </div>
     

      
   
    </div><!-- ./wrapper -->

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
$('.regcom').on('change', function (){
var a = $(this).val();
if(a != '') {
 $(this).removeClass('error-admin');
} else {
 $(this).addClass('error-admin');
 return false;
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
 
$("#useradd").click(function(){
 var username = $('#signup-username').val();
   if(!username){
	
	  $( "#signup-username" ).addClass('error-admin');
	  $("#signup-username").focus();
		return false;
   }
 
var value =$("#user_reg").serialize() ;

$.ajax({
url:'<?php echo base_url();?>admin/insert_airmanag',
method:'post',
data:value,
success:function(res){
$(".adminuser").show();
console.log(res);
if(res==0){
	$(".adminuser").html('<p class="error">Error</p>');
	setTimeout(function(){$(".adminuser1").hide(); }, 3000);
}else if(res==2){
	$(".adminuser").html('<p class="error">Name Exists</p>');
	setTimeout(function(){$(".adminuser1").hide(); }, 3000);
}
else{
   $(".adminuser").html('<p class="success">Airport Details Saved Successfully</p>');
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

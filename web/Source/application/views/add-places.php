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
           Add Places
          </h1>
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Places</a></li>
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
				   <div class="promo-add"></div>
                </div><!-- /.box-header -->
                <!-- form start -->
				
                 <form role="form"  method="post" id="promocode_reg">
				
                  <div class="box-body">
				             <div class="form-group">
                                            <label>Places</label>
                                           <input class="form-control regcom11" placeholder="Places" name="location" id="places">
                                        </div>
                                         
                                        
                                        
                                          <div class="form-group">
                                       
                                        <input type="button" class="btn btn-primary " value="Submit "  name="Save" id="promoadd">
                                        <button type="reset" class="btn btn-primary">Reset </button>
                                        </div>
                                     
				  
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
		
$("#promoadd").click(function(){
 var promocode = $('#places').val();
if(!promocode){
	
	  $( "#places" ).addClass('error-admin');
	  $("#places").focus();
		return false;
   }
  
var value =$("#promocode_reg").serialize() ;

$.ajax({
url:'<?php echo base_url();?>admin/insert_places',
type:'post',
data:value,
success:function(res){
$(".promo-add").show();
console.log(res);
if(res==1){
	$(".promo-add").html('<p class="success">Places Entered Successfully</p>');
	
	setTimeout(function(){$(".promo-add").hide(); }, 1500);
	$('#promocode_reg')[0].reset();
}else if(res==2){
	$(".promo-add").html('<p class="error">Places Exists </p>');
    setTimeout(function(){$(".promo-add").hide(); }, 1500);}
else{
$(".promo-add").html('<p class="error">Errorr </p>');
setTimeout(function(){$(".promo-add").hide(); }, 1500);
}
}
});
});
});
</script>

</body>
</html>

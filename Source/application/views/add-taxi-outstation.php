<!DOCTYPE html>
<html>
  <?php
	 include "includes/admin_header.php";
	 ?>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Left side column. contains the logo and sidebar -->
     <?php
	 include "includes/admin_sidebar.php";
	 ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1 class="add_promocode">
          Add Taxi Details
          </h1>
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">TD</a></li>
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
			  
                 <form role="form"  method="post" id="taxi-hourly">
				
                  <div class="box-body">
				       
                              
                                         <div class="form-group">
                                            <label>Car Type</label>
                                           <select class="form-control regcom select2"  style="width: 100%;" id="cartype" name="cartype">
                                             <?php
										   	$query2 = $this->db->query("SELECT DISTINCT`car_type` FROM driver_details");
                                                    foreach($query2->result_array('countries') as $row1){
										   ?>
                                              <option value="<?php echo $row1['car_type'];?>"><?php echo $row1['car_type'];?></option>
                                             
                                             <?php
													}?>
                                                 </select>
                                                 
                                        </div>

                                         
                                          <div class="form-group">
                                            <label>Standard Rate ( Oneway Trip )</label>
                                            <input class="form-control regcom" placeholder="145" name="standardrate"  id="standardrate">
                                           <input  id="transfertype" name="transfertype" type="hidden" value="Outstation Transfer">
                                        </div>
                                         <div class="form-group">
                                            <label> Standard Rate ( Round Trip )</label>
                                            <input class="form-control regcom" placeholder="145" name="fromstandardrate"  id="fromstandardrate">
                                           
                                        </div>
                                        
                                      
                                       <div class="form-group">
                                       
                                        <input type="button" class="btn btn-primary" value="Submit "  name="Save" id="taxiadd">
                                        <button type="reset" class="btn btn-primary">Reset </button>
                                        </div>
                                        
                                          
                                                  
                                    
                                       
                                     
                                  
				</div>   
	</div>
              </div><!-- /.box -->
			  
			  
				  </form>

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
            $(".select2").select2();
        });
     </script>
     
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" />
        <script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
    
     <script type="text/javascript">
$(document).ready(function(){
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
	    }
  });						   
$('#standardrate').bind('keypress', function(e) { 
return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
  });
	
$("#taxiadd").click(function(){

 var  standardrate=  $('#standardrate').val();
 if(!standardrate){
	   
	   $( "#standardrate" ).addClass('error-admin');
	   $("#standardrate").focus();
		return false;
   }
 var value =$("#taxi-hourly").serialize() ;

$.ajax({
url:'<?php echo base_url();?>admin/insert_taxi',
type:'post',
data:value,
success:function(res){
$(".taxi").show();
console.log(res);
if(res==0){
	$(".taxi").html('<p class="error">Error</p>');
	setTimeout(function(){$(".taxi").hide(); }, 3000);
}else if(res==2){
	$(".taxi").html('<p class="error">Car Type Exists</p>');
	setTimeout(function(){$(".taxi").hide(); }, 3000);
}
else{
   $(".taxi").html('<p class="success">Taxi Details Saved Successfully</p>');
   setTimeout(function(){$(".taxi").hide(); }, 1500);
   $('#taxi-hourly')[0].reset();
}
}
});
});
});

</script>

</body>
</html>

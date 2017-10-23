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
          Add Promo Code
          </h1>
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">PM</a></li>
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
                                            <label>Promo Code</label>
                                           <input class="form-control regcom" placeholder="Promo Code" name="promocode" id="promocode">
                                         </div>
					<div class="form-group">
                                            <label>Type</label>
                                          <select class="form-control regcom select2"  style="width: 100%;"name="type">
                                               <option value="Fixed">Fixed</option>
                                               <option value="Percentage">Percentage</option>
                                               
                                                  </select>
                                        </div>
										
                    <div class="form-group">
                                            <label>Amount</label>
                                            <input class="form-control regcom" placeholder="Amount" name="amount" id="amount">
                                            
                                        </div>

                               
				
				  <div class="form-group">
                                       
                                        <input type="button" class="btn btn-primary " value="Submit "  name="Save" id="promoadd">
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
                    <label>Start Date</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker regcom" placeholder="DD/MM/YYYY" name="startdate" id="startdate" >
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
					
					
					
					 
					 <div class="form-group">
                    <label>End Date</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker regcom" placeholder="DD/MM/YYYY" name="enddate" id="enddate" >
                    </div><!-- /.input group -->
                  </div>

                             <div class="form-group">
                                            <label>Status</label>
                                          <select class="form-control regcom select2"  style="width: 100%;"name="status">
                                               <option value = "">Select</option>
                                               <option value="1">Active</option>
                                               <option value="0">Inactive</option>
                                               
                                           </select>
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
	 include"includes/admin-footer.php";
	 ?>

    
    </div><!-- ./wrapper -->

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
$('#amount').bind('keypress', function(e) { 
return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
  });	
$("#promoadd").click(function(){
 var promocode = $('#promocode').val();
	amount = $('#amount').val();
	startdate = $('#startdate').val();
    enddate =  $('#enddate').val();
if(!promocode){
	
	  $( "#promocode" ).addClass('error-admin');
	  $("#promocode").focus();
		return false;
   }
   if(!amount){
	
	  $( "#amount" ).addClass('error-admin');
	  $("#amount").focus();
		return false;
   }
   if(!startdate){
	
	  $( "#startdate" ).addClass('error-admin');
	  $("#startdate").focus();
		return false;
   }
   if(!enddate){
	
	  $( "#enddate" ).addClass('error-admin');
	  $("#enddate").focus();
		return false;
   }
 
 var value =$("#promocode_reg").serialize() ;

$.ajax({
url:'<?php echo base_url();?>index.php/admin/insert_promocode',
type:'post',
data:value,
success:function(res){
$(".promo-add").show();
console.log(res);
if(res==1){
	$(".promo-add").html('<p class="success">Promo Code Entered Successfully</p>');
	setTimeout(function(){$(".promo-add").hide(); }, 1500);
	$('#promocode_reg')[0].reset();
	}
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

<!DOCTYPE html>
<html>
  <?php
	 include "includes/admin_header.php";
	 ?>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper ">

      <!-- Left side column. contains the logo and sidebar -->
     <?php
	 include "includes/admin_sidebar.php";
	 ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="min-height: 637px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1 class="add_promocode">
           Edit Promo Code
          </h1>
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">PM</a></li>
            <li class="active">Edit</li>
          </ol>
        </section>

        <!-- Main content -->
 <div class="">
			   <div class="">
                <div class="col-lg-6">
           <div class="box box-primary edit_promoform1">
				 
               <!-- /.box-header -->
                <!-- form start -->
				  <div class="box-header with-border">
                  <h3 class="box-title"></h3>
				  <div class="promo-add"></div>
                </div>
				
				
				 
				 <?php
							  $id = $_GET['idp'];
						  
		 $query = $this->db->query("SELECT * FROM  promocode WHERE  id ='$id'");
		 $row = $query->row(' promocode');
							   ?>
                <form role="form"  method="post" id="promocode_reg">
				
                  <div class="box-body">
				  
                                      <div class="form-group">
                                            <label>Promo Code</label>
                                           <input class="form-control regcom" value="<?php echo $row->promocode; ?>" name="promocode" >
                                        </div>
                                         <div class="form-group">
                                            <label>Type</label>
                                          <select class="form-control select2"  style="width: 100%;" name="type" >
                                               <option value="Fixed" <?php if($row->type == 'Fixed') echo 'selected'; ?>>Fixed</option>
                                               <option value="Percentage" <?php if($row->type == 'Percentage') echo 'selected'; ?>>Percentage</option>
                                               
                                                  </select>
                                        </div>
                                        
                                         <div class="form-group">
                                            <label>Amount</label>
                                            <input class="form-control regcom sample" value="<?php echo $row->amount; ?>" name="amount"  id="amount">
                                            
                                        </div>
                                        <div class="form-group">
                                        <input type="button" class="btn btn-primary" value="Save Details"  name="Save" id="promoedit">
                                       
                                        
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
                      <input type="text" class="form-control pull-right datepicker" id="reservation" value="<?php echo $row->startdate; ?>" name="startdate" >
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
				                        
                                         
                    <label>End Date</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="reservation" value="<?php echo $row->enddate; ?>" name="enddate" >
					  <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
				          
                                        
								  
				</div>  
				  </form>
	</div>
			  </div>
			  
			  
			  
			  
			  
			  
			  
                    <!-- /.panel -->
                </div>
				</div>
				  
				   
			
      
     <?php
	 include"includes/admin-footer.php";
	 ?>
</div><!-- /.content-wrapper -->
    
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
<!-- Load jQuery JS -->
<script src="<?php echo base_url();?>assets/js/jquery.datetimepicker.js"></script>
<!-- Load jQuery UI Main JS -->

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
	 
	$( ".datepicker" ).datetimepicker();
	
	
	 $('#amount').bind('keypress', function(e) { 
return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
  });	
	 
	 
	$("#promoedit").click(function(){
 
 
 var value =$("#promocode_reg").serialize() ;

$.ajax({
url:'<?php echo base_url();?>admin/update_promocode',
type:'post',
data:value,
success:function(res){
	$(".promo-add").show();
console.log(res);
if(res==1){
		$(".promo-add").html('<p class="success">Promo Code Entered Successfully</p>');
	setTimeout(function(){$(".promo-add").hide(); }, 1500);
	//window.location.href="<?php echo base_url();?>index.php/admin/pointview";
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

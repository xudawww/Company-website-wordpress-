<!DOCTYPE html>
<html>
  <?php
	 include"includes/admin_header.php";
	 ?>
<link rel="stylesheet" href="<?php echo base_url();?>adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

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
         Edit Baner
          </h1>
		  
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">EB</a></li>
            <li class="active">Edit</li>
          </ol>
		
        </section>
		<?php
		
		$query = $this->db->query("SELECT * FROM  blogs WHERE  id ='5'");
		 $row = $query->row('blogs');
	?>

        <!-- Main content -->
        <div class="">
			   <div class="">
                <div class="col-lg-12">
           <div class="box box-primary edit_promoform1">
				
                  <div class="box-header with-border">
                  <h3 class="box-title"></h3>
				  <?php
				  if(($this->session->flashdata('item'))) {
  $message = $this->session->flashdata('item');
  ?>
<div id="mess" class="<?php echo $message['class'];?>"><?php echo $message['message']; ?></div>
<?php
}
?>
                </div><!-- /.box-header -->
                <!-- form start -->
				
			  
              <?php echo form_open_multipart('admin/banner');?>
				<div class="box-body">
				<label>Block Name</label>
				<input type="text" name="block_name"  id="name" class="form-control regcom sample" value="<?php echo $row->block_name; ?>">
				<input type="hidden" name="id" id="id" class="form-control regcom" value="<?php echo $row->id; ?>">
				
				</div>
				<div class="box-body">
				<label>Banner Image1</label>
				<input type="file" name="blog_content"  id="blog_content" class="form-control regcom" value="<?php echo $row->blog_content; ?>">
			
				
				</div>
				<div class="box-body">
				<label>Banner Image2(car)</label>
				<input type="file" name="baner_car"  id="baner_car" class="form-control regcom" value="<?php echo $row->baner_car; ?>">
			
				
				</div>
                <!-- /.box --> 
										<div class="box-body">
                                       
                                        <input type="submit" class="btn btn-primary" value="Submit"   id="useradd">
                                        <button type="reset" class="btn btn-primary">Reset </button>
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
   
 <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
    <!-- page script -->
   
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" />
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/css/jquery-ui.css" />
<script src="<?php echo base_url();?>assets/adminlte/js/jquery-ui.js"></script>
<script>
     $(function ($) {
       // Replace the <textarea id="editor1"> with a CKEditor
       // instance, using default configuration.
       CKEDITOR.replace('editor1');
       //bootstrap WYSIHTML5 - text editor
       //$(".textarea").wysihtml5();
     });
   </script>
<script type="text/javascript">
$(document).ready(function(){
$(".sample").on("keydown", function (e) {
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
		  
          
		$("#useradd").click(function(){
		 var name = $('#name').val();
			

		   if(!name){
			
			  $( "#name" ).addClass('error-admin');
				$("#name").focus();
				return false;
		   }
		  
		 
		 
		 
		});
});


</script>


  </body>
</html>

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
         Edit Blocks
          </h1>
		  
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">EB</a></li>
            <li class="active">Edit</li>
          </ol>
		
        </section>
		<?php
		$id = $_GET['idp'];
		$query = $this->db->query("SELECT * FROM  static_pages WHERE  id ='$id'");
		 $row = $query->row('static_pages');
	  ?>

        <!-- Main content -->
        <div class="">
			   <div class="">
                <div class="col-lg-12">
           <div class="box box-primary edit_promoform1">
				
                  <div class="box-header with-border">
                  <h3 class="box-title"></h3>
				  <div class="adminuser1" tabindex='1'></div>
                
                </div><!-- /.box-header -->
                <!-- form start -->
				
			  
                <form role="form"  method="post" id="user_reg">
				<div class="box-body">
				<label>Page Title</label>
				<input type="text" name="block_name"  id="name" class="form-control regcom" value="<?php echo $row->page_title; ?>">
				<input type="hidden" name="id" id="id" class="form-control regcom" value="<?php echo $row->id; ?>">
				
				</div>
				
                 <div class="box box-info">
               <div class="box-header">
                 <h3 class="box-title">Editor </h3>
                 <!-- tools box -->
                 <div class="pull-right box-tools">
                   <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                   <button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                 </div><!-- /. tools -->
               </div><!-- /.box-header -->
               <div class="box-body pad">
                 
                   <textarea id="blog_content" class="textarea" name="blog_content" rows="10" cols="80"><?php echo $row->page_content; ?>
                      </textarea>
                
               </div>
			   <?php
			 if($row->id =="2"){
				 ?>
				<div class="box-body pad">
			 All input feild have requred.Please don't try to remove it once you edit It's a type of validation for manidatory.
			 </div> <?php
			 }
			 ?>
             </div><!-- /.box --> 
			 
			 
										<div class="box-body">
                                       
                                        <input type="button" class="btn btn-primary" value="Submit"  name="Save" id="useradd">
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
   
 
   
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" />
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/css/jquery-ui.css" />
<script src="<?php echo base_url();?>assets/adminlte/js/jquery-ui.js"></script>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>
tinymce.init({
         selector: "textarea",
   
  
  plugins: 'link image code',
  relative_urls: false,
  content_css: [
    
  ]
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
		   }
			  
	   });						   
		  
          
		$("#useradd").click(function(){
			
		   var page_title = $('#name').val();
		   if(!page_title){
			
			    $( "#name" ).addClass('error-admin');
				$("#name").focus();
				return false;
		   }
		  
		  var page_content = tinyMCE.activeEditor.getContent();
          var id="<?php echo $id;?>";
		 
		 

			$.ajax({
				url : '<?php echo base_url();?>admin/update_pages',
				method:'post',
				data:{'page_title':page_title,'page_content':page_content,'id':id},
				success:function(res){
				$(".adminuser1").show();
				console.log(res);
				 if(res==0){
					 $(".adminuser1").focus();
					$(".adminuser1").html('<p class="error">Erorr!!!</p>');
					setTimeout(function(){$(".adminuser1").hide(); }, 3000);
				}else{
	                $(".adminuser1").focus();
					$(".adminuser1").html('<p class="success">Updated Successfully</p>');
					setTimeout(function(){$(".adminuser1").hide(); }, 1500);
					
					
				}
				}
			});
		});
});


</script>


  </body>
</html>

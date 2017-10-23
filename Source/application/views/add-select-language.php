<!DOCTYPE html>
<html>
  <?php
	 include"includes/admin_header.php";
	 ?>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
     https://www.googleapis.com/language/translate/v2/languages
	 https://www.googleapis.com/language/translate/v2
      <!-- Left side column. contains the logo and sidebar -->
     <?php
	 include"includes/admin_sidebar.php";
	 ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1 class="add_promocode">
          Add Hourly Rental
          </h1>
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">TD</a></li>
            <li class="active">Add New</li>
          </ol>
        </section>


<?php
    $apiKey = 'AIzaSyBYvIig873iza-7bMSzRLcEuU-k6xkl3a0';
    $text = 'Hello world!';
    $url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q=' . rawurlencode($text) . '&source=en&target=fr';

    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($handle);
    $responseDecoded = json_decode($response, true);
    $responseCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);      //Here we fetch the HTTP response code
    curl_close($handle);

    if($responseCode != 200) {
		//var_dump($responseCode);
        echo 'Fetching translation failed! Server response code:' . $responseCode . '<br>';
        echo 'Error description: ' . $responseDecoded['error']['errors'][0]['message'];
    }
    else {
        echo 'Source: ' . $text . '<br>';
        echo 'Translation: ' . $responseDecoded['data']['translations'][0]['translatedText'];
    }
?>

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
			   <?php

	 $query = $this->db->query(" SELECT * FROM `settings` order by id DESC ");
		$row = $query->row('settings');
		$measr =$row->measurements;
	 ?>
                 <form role="form"  method="post" id="taxi-hourly">
				
                  <div class="box-body">
				       
                                         <div class="form-group">
                                            <label>Add Language</label>
                                           <select class="form-control regcom select2"  style="width: 100%;" id="cartype" name="cartype">
                                             <?php
										   	$query2 = $this->db->query("SELECT DISTINCT`languages` FROM language_set");
                                                    foreach($query2->result_array('countries') as $row1){
										   ?>
                                              <option value="<?php echo $row1['languages'];?>"><?php echo $row1['languages'];?></option>
                                             
                                             <?php
													}?>
                                                 </select>
                                        </div>
                                        
                                       <div class="form-group">
                                            <label>Point To Point</label>
                                            <input class="form-control regcom" placeholder="Point To Point" name="standardrate" id="extrahour">
                                           
                                        </div>
										
                                       <div class="form-group">
                                       
                                        <input type="button" class="btn btn-primary" value="Submit "  name="Save" id="taxiadd">
                                        <button type="reset" class="btn btn-primary">Reset </button>
                                        </div>
				</div>  
				 
	</div>
				  </form>
                
              </div><!-- /.box -->
			  
			  
			  
			 
			  
			  
			  
			  
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

		
$("#taxiadd").click(function(){
var   extrahour =  $('#extrahour').val();
if(!extrahour){
	   
	   $( "#extrahour" ).addClass('error-admin');
	   $("#extrahour").focus();
		return false;
   }
  
var value =$("#taxi-hourly").serialize() ;

$.ajax({
url:'<?php echo base_url();?>admin/insert_addnew_languages',
type:'post',
data:value,
success:function(res){
$(".taxi").show();
console.log(res);
if(res==0){
	$(".taxi").html('<p class="error">Error</p>');
	setTimeout(function(){$(".taxi").hide(); }, 3000);
}else if(res==2){
	$(".taxi").html('<p class="error">Car Type exists</p>');
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

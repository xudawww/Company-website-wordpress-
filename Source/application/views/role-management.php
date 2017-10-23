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
           Add New Role
          </h1>
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">RM</a></li>
            <li class="active">Add New</li>
          </ol>
        </section>

        <!-- Main content -->
             <div class="">
			   <div class="">
                <div class="col-lg-12">
           <div class="box box-primary edit_promoform1">
				 
                <div class="box-header with-border">
                  <h3 class="box-title"></h3>
				        <div class="result-role"></div>
                        <div class="adminuser1"></div>
                <!-- /.box-header -->
                <!-- form start -->
				
                
				  <form method="post" class="form parsley-form col-sm-12" data-validate="parsley">
<div style="width:100%; float:left; clear:both; margin-bottom:25px">
<div class="pull-left">
<div class="btn-group" style="clear:both">
<input type="hidden" value="<?php if(isset($_GET['role'])){ echo $_GET['role'];} ?>" id="get_role_id"/>
<?php
 $roles =  $this->db->query("SELECT * FROM  role");
 foreach($roles->result_array('role') as $role)
   {
	
  ?> 
     <button class="btn btn-default <?php if(isset($_GET['role'])) { if($_GET['role']== $role['r_id']) { echo "active";}} ?>" type="button" style="text-transform:capitalize" onClick="location.href='<?php echo base_url();?>admin/role_management?role=<?php echo  $role['r_id'];?>'"><?php echo  $role['rolename'];?></button>  
  <?php
   }
?> 

</div>
<div style="margin:16px; margin-bottom:0; clear:both;">
 <!--<a href="#"  data-toggle="modal" data-target="#myModal">Add Role</a>-->
 <input href="#"  data-toggle="modal" data-target="#myModal" type="button" class="btn btn-primary" value="Add Role" id="promoedit">
 <input href="#"  data-toggle="modal" data-target="#myModal1" style="margin-left:6px;" type="button" class="btn btn-primary" value="Delete Role" id="promoedit">
 <!--<a href="#"  data-toggle="modal" data-target="#myModal1" style="margin-left:25px;">Delete Role</a>--> 
</div>
</div>
<?php
// role based displayed
if(!isset($_GET['role']) || ($_GET['role']== "1") ) {
/*if(isset($_GET['role'])) {
	if($_GET['role'] == "1") {*/
		?>
        <div class="col-sm-12">
        <div class="jumbotron admin-page role_style">
        <p> All page are accessible </p>
        </div>
        </div>
        
        <?php
	    } else {
		
		$d = $_GET['role'];
		$check_role = $this->db->query("select * from role where r_id ='$d' ");
		if($check_role->num_rows == 0) {
			$this->load->view('role-management');
		}
		$d = $_GET['role'];
		 
		$role_id= $this->db->query("select * from role_permission where role_id ='$d' ");
		if($role_id->num_rows == 1) {
			foreach($role_id->result_array() as $result){
			
			$str = rtrim($result['page_id'],',');
			$p = explode(',', $str);
			
			?>
			
             <div class="col-sm-12 admin-roleman role_dropbox">
        <!--<label>Default</label>
       -->
        <!--<div class="checkbox"><label><input  class="role_checkbox" type="checkbox" checked disabled value="1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21">Basic User Needs</label></div>-->
		<div class="col-sm-4">
        <label>Booking Details <br>Point to Point Transfer</label>
		
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("15", $p)) { echo "checked";} ?> type="checkbox" value="15">  Assign Driver</label></div>
		<div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("15", $p)) { echo "checked";} ?> type="checkbox" value="57">  Assigned Driver</label></div>
		<label>Airport Transfer</label>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("10", $p)) { echo "checked";} ?> type="checkbox" value="10"> Assign Driver</label></div>
		<div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("10", $p)) { echo "checked";} ?> type="checkbox" value="58"> Assigned Driver</label></div>
		<label>Hourly Rental Transfer</label>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("13", $p)) { echo "checked";} ?> type="checkbox" value="13">Assign Driver </label></div>
		 <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("13", $p)) { echo "checked";} ?> type="checkbox" value="59"> Assigned Driver</label></div>
		 <label>Outstation Transfer </label>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("14", $p)) { echo "checked";} ?> type="checkbox" value="14">Assign Driver </label></div>
		<div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("14", $p)) { echo "checked";} ?> type="checkbox" value="60">Assigned Driver</label></div>
        <label>Promocode Management</label>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("32", $p)) { echo "checked";} ?> type="checkbox" value="32">View Promocode Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("2", $p)) { echo "checked";} ?> type="checkbox" value="2">Add Promocode </label></div>
        
        <label>Taxi Details</label>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("28", $p)) { echo "checked";} ?> type="checkbox" value="28">Point to Point Transfer  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("27", $p)) { echo "checked";} ?> type="checkbox" value="27">Airport Transfer </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("29", $p)) { echo "checked";} ?> type="checkbox" value="29">Hourly Rental Transfer </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("30", $p)) { echo "checked";} ?> type="checkbox" value="30">Outstation Transfer </label></div>
        <label>Front end</label>
		<div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("52", $p)) { echo "checked";} ?> type="checkbox" value="52">View All </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("53", $p)) { echo "checked";} ?> type="checkbox" value="53">Edit Front end </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("54", $p)) { echo "checked";} ?> type="checkbox" value="54">Add Banner Images </label></div>
        <label>Pages</label>
		<div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("55", $p)) { echo "checked";} ?> type="checkbox" value="55">View All </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("56", $p)) { echo "checked";} ?> type="checkbox" value="56">Edit Pages </label></div>
        
		</div>
		
		<div class="col-sm-4">
         <label>Driver Management</label>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("31", $p)) { echo "checked";} ?> type="checkbox" value="31">View Driver Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("3", $p)) { echo "checked";} ?> type="checkbox" value="3">Add Driver Details </label></div>
         <label>Settings</label>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("4", $p)) { echo "checked";} ?> type="checkbox" value="4">Add Settings  </label></div>
        <label>Role Management</label>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("26", $p)) { echo "checked";} ?> type="checkbox" value="26">Add Role Permission  </label></div>
         <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("26", $p)) { echo "checked";} ?> type="checkbox" value="26">Add Role Permission  </label></div>
         <label>Add Booking</label>
		 <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("36", $p)) { echo "checked";} ?> type="checkbox" value="36">Point to Point Transfer  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("37", $p)) { echo "checked";} ?> type="checkbox" value="37">Airport Transfer </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("38", $p)) { echo "checked";} ?> type="checkbox" value="38">Hourly Rental Transfer </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("39", $p)) { echo "checked";} ?> type="checkbox" value="39">Outstation Transfer </label></div>
        <label>Languages</label>
		 <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("49", $p)) { echo "checked";} ?>  type="checkbox" value="49">view Languages Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("50", $p)) { echo "checked";} ?> type="checkbox" value="50">Add Language Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("51", $p)) { echo "checked";} ?>type="checkbox" value="51">Edit Language Details  </label></div>
        <label>Wallet</label>
		<div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("61", $p)) { echo "checked";} ?>  type="checkbox" value="49">Wallet Details  </label></div>
		
		 </div>
		 <div class="col-sm-4">
         <label>Backend User</label>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("33", $p)) { echo "checked";} ?> type="checkbox" value="33">view User Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("34", $p)) { echo "checked";} ?> type="checkbox" value="34">Add User Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("35", $p)) { echo "checked";} ?> type="checkbox" value="35">Edit User Details  </label></div>
		<label>User lists</label>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("9", $p)) { echo "checked";} ?> type="checkbox" value="33">view User Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("1", $p)) { echo "checked";} ?> type="checkbox" value="34">Add User Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("12", $p)) { echo "checked";} ?> type="checkbox" value="35">Edit User Details  </label></div>
         <label>Airport Management</label>
		 <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("40", $p)) { echo "checked";} ?> type="checkbox" value="40">view Airport Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("41", $p)) { echo "checked";} ?> type="checkbox" value="41">Add Airport Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("42", $p)) { echo "checked";} ?> type="checkbox" value="42">Edit Airport Details  </label></div>
         <label>Package Management</label>
		 <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("43", $p)) { echo "checked";} ?>  type="checkbox" value="43">view Package Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("44", $p)) { echo "checked";} ?> type="checkbox" value="44">Add Package Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("45", $p)) { echo "checked";} ?> type="checkbox" value="45">Edit Package Details  </label></div>
         <label>Places</label>
		 <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("46", $p)) { echo "checked";} ?>  type="checkbox" value="46">view Places Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("47", $p)) { echo "checked";} ?> type="checkbox" value="47">Add Places Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("48", $p)) { echo "checked";} ?> type="checkbox" value="48">Edit Places Details  </label></div>
         
		</div>
		
		 <div class="col-sm-12">
        <input type="hidden" name="role_permission" class="role_permission1" id="role_permission" value="<?php echo $result['page_id']; ?>"/>
         <input class="btn btn-primary btn-secondary role-sub role_submit"  type="button" name="role" id="submit" value="Submit"/>
        </div>
		
		</div>
            <?php
			}
		} else {
		?>
        <div class="col-sm-12 role_dropbox">
        <!--<label>Default</label>-->
      <!--  <div class="checkbox"><label><input  class="role_checkbox" type="checkbox" checked disabled value="1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21">Basic User Needs</label></div>-->
	     <div class="col-sm-4">
       <label><h4>Booking Details</h4><br>Point to Point Transfer</label>
	  
        <div class="checkbox"><label><input class="role_checkbox" type="checkbox" value="15">Assign Driver  </label></div>
		 <div class="checkbox"><label><input class="role_checkbox" type="checkbox" value="57">Assigned Driver  </label></div>
		 <label>Airport Transfer</label>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="10">Assign Driver</label></div>
		 <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="58">Assigned Driver </label></div>
		 <label>Hourly Rental Transfer</label>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="13">Assign Driver  </label></div>
		<div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="59">Assign Driver  </label></div>
		<label>Outstation Transfer </label>
        <div class="checkbox"><label><input class="role_checkbox" type="checkbox" value="14">Assign Driver</label></div>
		  <div class="checkbox"><label><input class="role_checkbox" type="checkbox" value="60">Assign Driver</label></div>
        
		
        <label>Promocode Management</label>
        <div class="checkbox"><label><input class="role_checkbox" type="checkbox" value="32">View Promocode Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" type="checkbox" value="2">Add Promocode </label></div>
        
		
        <label>Taxi Details</label>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="28">Point to Point Transfer  </label></div>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="27">Airport Transfer </label></div>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="29">Hourly Rental Transfer </label></div>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="30">Outstation Transfer </label></div>
        <label>Front end</label>
		<div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="52">View All </label></div>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="53">Edit Front end </label></div>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="54">Add Banner Images </label></div>
        
		<label>Pages</label>
		<div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="55">View All </label></div>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="56">Edit Pages </label></div>
        
		</div>  
		

		<div class="col-sm-4">
          <label>Driver Management</label>
        <div class="checkbox"><label><input class="role_checkbox" type="checkbox" value="31">View Driver Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="3">Add Driver Details </label></div>
       
		
         <label>Settings</label>
        <div class="checkbox"><label><input class="role_checkbox" type="checkbox" value="4">Add Settings  </label>
		</div>
		
		
        <label>Role Management</label>
        <div class="checkbox"><label><input class="role_checkbox" type="checkbox" value="26">Add Role Permission  </label></div>
         <label>Places</label>
		 <div class="checkbox"><label><input class="role_checkbox"   type="checkbox" value="46">view Places Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="47">Add Places Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" type="checkbox" value="48">Edit Places Details  </label></div>
         <label>Languages</label>
		 <div class="checkbox"><label><input class="role_checkbox"   type="checkbox" value="49">view Languages Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="50">Add Language Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" type="checkbox" value="51">Edit Language Details  </label></div>
          <label>Wallet</label>
		  <div class="checkbox"><label><input class="role_checkbox" type="checkbox" value="61">Wallet Details  </label></div>
		  
		</div> 
		<div class="col-sm-4">
		 <label>Add Booking</label>
		 <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="36">Point to Point Transfer  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" type="checkbox" value="37">Airport Transfer </label></div>
        <div class="checkbox"><label><input class="role_checkbox" type="checkbox" value="38">Hourly Rental Transfer </label></div>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="39">Outstation Transfer </label></div>
        
		
		
        <label>Backend User</label>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="33">view User Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" type="checkbox" value="34">Add User Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="35">Edit User Details  </label></div>
		<label> User lists</label>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="9">view User Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox" type="checkbox" value="1">Add User Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="12">Edit User Details  </label></div>
         <label>Airport Management</label>
		 <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="40">view Airport Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="41">Add Airport Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="42">Edit Airport Details  </label></div>
         <label>Package Management</label>
		 <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="43">view Package Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="44">Add Package Details  </label></div>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="45">Edit Package Details  </label></div>
        
		</div>
        <div class="col-sm-12">
		
		<div class="col-sm-4">
        <input type="hidden" name="role_permission" class="role_permission1" id="role_permissionc" value="1,2"/>
         <input class="btn  btn-primary  btn-secondary role-sub role_submit"  type="button" name="role" id="submit" value="Submit"/>
        </div>
		
		</div>
		</div>
        <?php }
		?>
        <div class="col-sm-4">
        
        </div>
        <?php
}
?>
                   
				</div>  
			  </form>
	        </div>
				 
                
           </div><!-- /.box -->
          </div>
	    </div>
				  
				   
			
      </div><!-- /.content-wrapper -->
    
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New Role</h4>
      </div>
      <form id="validate-basic" action="#" data-validate="parsley" class="form parsley-form">
      <div class="modal-body">
        
        <div class="form-group">
                  <label for="name">Rolename</label>
                  <input type="text" id="rolename" name="name" class="form-control" data-required="true" >
                  
         </div>
         <div class="alert alert-success" id="rolerply" style="display:none;"></div>
         <div id="emptyerr" class="alert alert-danger" style="display:none">Please enter rolename</div>
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default rload" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addrole">Add Role</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->


 


<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Role</h4>
      </div>
      <form id="validate-basic" action="#" data-validate="parsley" class="form parsley-form">
      <div class="modal-body">
      
        <div class="form-group">  
             <label for="name">Rolename</label>
                  <select data-required="true" class="form-control parsley-validated select2"  style="width: 100%;" name="validateSelect" id="deleterolename">
                    <option value="" selected>Please Select</option>
                    <?php $dr =$this->db->query("select * from role ");
					if($dr->num_rows > 0) {
				foreach($dr->result_array() as $row){
						?>
                        <option value="<?php echo $row['rolename']; ?>"><?php echo $row['rolename']; ?></option>
                        <?php
					}
					}
					?>
                  </select>
         </div>
         <div class="alert alert-success" id="drolerply" style="display:none;"></div>
         <div id="emptyerr1" class="alert alert-danger" style="display:none">Please select rolename</div>
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default rload" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="deleterole">Delete Role</button>
      </div>
      </form>
    </div>
  </div>
</div>



      <!-- Control Sidebar -->
     </div> 
    </div><!-- ./wrapper -->
<?php
	 include"includes/admin-footer.php";
	 ?>
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
  
  $(document).ready(function () {
	    var t='';
	/* Get the checkboxes values based on the class attached to each check box */
	$(".role_checkbox").click(function() {
		$(".role_checkbox:checked").each(function() {
			t+=$(this).val()+',';
			//$('.role_permission').val($(this).val());
		});	
		var input = $('.role_permission1');
		input.val(t);
		//alert(t);
		t='';
	});

	$('#addrole').click(function(){
		if ($('#rolename').val().length == 0){
			$('#emptyerr').slideToggle(500);
			$('#emptyerr').fadeOut(5000);
		} else {
			var rolename = $('#rolename').val();
			$.ajax({
				type: "POST",
			    url:'<?php echo base_url();?>admin/add_role',
				data:{'rolename':rolename},
                success:function(result){
					
                        console.log(result);
						
                     $("#rolerply").html(result);
					$('#rolerply').slideToggle(500);
					$('#rolerply').fadeOut(5000);
					
					setTimeout(function(){$('#myModal').modal('hide'); }, 3000);
                    }
						
				
				
			});
		}
	});
	
	
	$('#deleterole').click(function(){
		if ($('#deleterolename').val().length == 0){
			$('#emptyerr1').slideToggle(500);
			$('#emptyerr1').fadeOut(5000);
		} else {
			var rolename = $('#deleterolename').val();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>admin/role_delete",
				data: {'rolename':rolename},
				cache: false,
				success: function(result)
				{
					  console.log(result);
					$("#drolerply").html(result);
					$('#drolerply').slideToggle(500);
					$('#drolerply').fadeOut(5000);
					setTimeout(function(){$('#myModal').modal('hide'); }, 3000);
                    //location.reload();
				}
			});
		}
	});
	$('.rload').click(function(){
		window.location.href = "role_management";
	});
	
	
	$('.role-sub').click(function(){
		  var role_id = $('#get_role_id').val();
		     page_id = $('.role_permission1').val();
			 
		  $.ajax({
url:'<?php echo base_url();?>admin/update_role',
type:'post',
data:{'role_id':role_id,'page_id':page_id},
success:function(book){
	$(".result-role").show();
console.log(book);
if(book==2 || book ==4){
$(".result-role").html('<p class="error">Error</p>');
	//setTimeout(function(){$(".result-role").hide(); }, 3000);
}else if(book == 1){
	$(".result-role").html('<p class="success">Role Permission Added successfully</p>');
//setTimeout(function(){$(".result-role").hide(); }, 1500);

}else{
	$(".result-role").html('<p class="success">Role Permission Changes successfully</p>');
//setTimeout(function(){$(".result-role").hide(); }, 1500);

}

	}
		});  
		 }); 
});
</script>

  </body>
</html>

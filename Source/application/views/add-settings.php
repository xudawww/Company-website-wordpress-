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
         Settings
          </h1>
		  
		 
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            
            <li class="active">Settings</li>
          </ol>
        </section>

        <!-- Main content -->
               <div class="">
			   <div class="">
                <div class="col-lg-12">
           <div class="box box-primary edit_promoform1">
				  <div class="editbook"></div>
                <div class="panel-heading">
                        
   
                        <!-- /.box-header -->
						
               
                        <?php
if(($this->session->flashdata('item'))) {
  $message = $this->session->flashdata('item');
  ?>
<div id="mess" class="<?php echo $message['class'];?>"><?php echo $message['message']; ?></div>
<?php
}else{
}

  $query = $this->db->query(" SELECT * FROM `settings` order by id DESC ");
   $row = $query->row('settings');
?>                         
		</div>				
						 <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                              
                                   <?php echo form_open_multipart('admin/upload');?>
                                   
                                         <div class="form-group">
                                            <label>Site Title</label>
                                        <input  id="title" name="title" type="text" class="form-control " value="<?php echo $row->title; ?>">
                                        </div>
                                       
                                         <div class="form-group">
                                          <div class="row">
                                           <div class="col-lg-12">
                                          <div class="col-sm-6">
                                            <label>Logo</label>
                                           <input class="regcom"  name="logo"  id="logo" type="file" value="<?php echo $row->logo; ?>">
                                          
										   </div>
                                          <div class="col-sm-6 text-right">
                                           <?php
										   $logo =$row->logo;
										   if($logo){
											   ?>
                                               <img src="<?php echo base_url();?><?php echo $row->logo; ?>">
											   <?php
										   }
										   ?>
                                           </div>
                                        </div>
                                        </div>
                                        </div>
										 
                                         <div class="form-group">
                                            <label>Fav Icon </label>
                                           <input   name="favicon"  id="favicon" type="file" value="<?php echo $row->favicon; ?>">
										   Please select an image 15px/15px
                                          
                                           
                                        </div>
                                         
                                         <div class="form-group">
                                            <label>Places </label>
                                               <select class="form-control select2"  style="width: 100%;" name="places" id="places">
                                               <option value="google"<?php if($row->places == 'google') echo 'selected'; ?> >Google Map</option>
                                               <!-- <option value="default" <?php if($row->places == 'default') echo 'selected'; ?>>Default</option>-->
                                               
                                                  </select>
                                           
                                        </div>
										<?php
										 $query11 = $this->db->query("SELECT * FROM  language_set  ");
						
						?>
										<div class="form-group">
                                            <label>Language </label>
                                          <select class="form-control select2"  style="width: 100%;" name="languages" id="languages">
                                                <?php
										   	
                                                    foreach($query11->result_array('language_set') as $row11){
                                                            ?>
										  
                                               <option value="<?php echo $row11['languages'];?>"<?php if($row->languages == $row11['languages']) echo 'selected'; ?> ><?php echo $row11['languages'];?></option>
                                              <?php
													}?>
                                                  </select>
                                    
                                        </div>
										<?php
										 $query1 = $this->db->query("SELECT * FROM  countries  ");
						
						?>
                                          <div class="form-group Country">
                                            <label>Country</label>
                                           <select class="form-control regcom select2"  style="width: 100%;" name="country"  id="country">
										   <?php
										   	
                                                    foreach($query1->result_array('countries') as $row1){
                                                            ?>
										  
                                               <option value="<?php echo $row1['iso_alpha2'];?>"<?php if($row->country == $row1['iso_alpha2']) echo 'selected'; ?> ><?php echo $row1['name'];?></option>
                                              <?php
													}?>
                                                  </select>
                                        </div>
										<div class="form-group ">
                                            <label>Currency</label>
                                           <select class="form-control regcom select2"  style="width: 100%;" name="currency"  id="currency">
										   <?php
										   	$query2 = $this->db->query("SELECT DISTINCT`currrency_symbol`,`currency_name`,currency_code FROM `countries` where `currrency_symbol` IS NOT NULL  ");
                                                    foreach($query2->result_array('countries') as $row1){
														
														$array["a"] = $row1['currency_code'];
                                                        $array["b"] = $row1['currrency_symbol'];
														 $str = implode(',',$array);
                                                          // $s = explode(',',$str);
														//  echo$s[1]; 
														
                                                            ?>
										  
                                               <option value="<?php echo $str;?>"<?php if($row->currency == $str) echo 'selected'; ?> ><?php echo $row1['currency_code'];?>(<?php echo $row1['currrency_symbol'];?>)</option>
                                              <?php
													}?>
                                                  </select>
                                        </div>
										 <div class="form-group">
										
                                            <label>Measurements </label>
                                          <select class="form-control select2"  style="width: 100%;" name="measurements" id="measurements">
                                               <option value="km"<?php if($row->measurements == 'km') echo 'selected'; ?> >Kilometer</option>
                                               <option value="mi" <?php if($row->measurements == 'mi') echo 'selected'; ?>>Miles</option>
                                               
                                                  </select>
                                           
                                        </div>
										<div class="form-group">
										
                                            
                      <label>Payment option</label><br>
                    
                       <?php $paypal_option = explode(",", $row->paypal_option); ?>
 
                        <input type="checkbox" name="paypal_option[]" value="PayPal"  <?php if(in_array("PayPal", $paypal_option)) echo 'checked'; ?>> PayPal<br>
                        <input type="checkbox" name="paypal_option[]" value="Cash" <?php if(in_array("Cash", $paypal_option)) echo 'checked'; ?>> Cash<br>
                        <input type="checkbox" name="paypal_option[]" value="Credit_Card" <?php if(in_array("Credit_Card", $paypal_option)) echo 'checked'; ?>> Credit Card<br>
                        
                       
                                  
                    </div>

                      <div class="form-group">
                    
                                            
                      <label>Card option</label><br>
                    
                       <input type="radio" name="card_option" value="Authorize" <?php if($row->card_option=='Authorize') echo 'checked'; ?>>  Authorize<br>
                        <input type="radio" name="card_option" value="BrainTree" <?php if($row->card_option=='BrainTree') echo 'checked'; ?>> Brain Tree<br>
                        
                        
                    </div>
                                         <div class="form-group" id='paypal1'>
										
                                        <label>Paypal </label>
                                          <select class="form-control select2"  style="width: 100%;" name="paypal" id="paypal">
                                            <option value="https://www.paypal.com/cgi-bin/webscr"<?php if($row->paypal == 'https://www.paypal.com/cgi-bin/webscr') echo 'selected'; ?> >Live</option>
                                            <option value="https://www.sandbox.paypal.com/cgi-bin/webscr" <?php if($row->paypal == 'https://www.sandbox.paypal.com/cgi-bin/webscr') echo 'selected'; ?>>Sandbox</option>

                                          </select>
                                           
                                        </div>
										
										
										<div class="form-group " id='pay-id'>
                                            <label>Paypal ID</label>
                                          <input class="form-control regcom"  name="paypalid"  id="paypalid"  value="<?php echo $row->paypalid; ?>" >
                                           
                                        </div>
										
                                         <div class="form-group">
                                            <label>Admin :-email</label>
                                            <input class="form-control regcom"  name="email"  id="email"  value="<?php echo $row->email; ?>">
                                           
                                        </div>
                                        <div class="form-group ">
                                          <label>Verification </label>
                                          <select class="form-control select2"  style="width: 100%;" name="verification" id="Verification">
                                               <option value="on"<?php if($row->verification  == 'on') echo 'selected'; ?> >On</option>
                                               <option value="off" <?php if($row->verification  == 'off') echo 'selected'; ?>>Off</option>
                                               
                                          </select>
                                        </div>
                                       <div class="form-group">
                                       
                                        <input type="submit" class="btn btn-primary" value="Save" id="taxiadd">
                                        <button type="reset" class="btn btn-primary">Reset </button>
                                        </div>
                                        
                                        </div> <div class="col-lg-6">
                                       
                                         
                                         
                                        
										 <div class="form-group Communication">
                                            <label>Communication</label>
                                          <select class="form-control select2"  style="width: 100%;" name="communication" id="communication">
                                               <option value="sms"<?php if($row->communication == 'sms') echo 'selected'; ?> >Sms</option>
                                               <option value="email" <?php if($row->communication == 'email') echo 'selected'; ?>>Email</option>
                                               
                                                  </select>
                                        </div>
										<div id='comu-sms'>
                                         <div class="form-group">
                                            <label>Sender ID(sms)</label>
                                            <input class="form-control regcom"  name="sender_id"  id="sender-id"  value="<?php echo $row->sender_id; ?>">
                                           
                                        </div>
                                        <div class="form-group">
                                            <label class="intrate">Sms Username</label>
                                            <input class="form-control regcom" name="sms_username" id="sms_username" value="<?php echo $row->sms_username; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="intrate">Sms Password</label>
                                            <input class="form-control regcom" name="sms_password" id="sms_password" value="<?php echo $row->sms_password; ?>" type="password">
                                        </div>
										</div>
										
										<div id='comu-email'>
										<div class="form-group">
                                            <label class="intrate">Smtp Username</label>
                                            <input class="form-control regcom" name="smtp_username" id="smtp_username" value="<?php echo $row->smtp_username; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="intrate">Smtp Host</label>
                                            <input class="form-control regcom" name="smtp_host" id="smtp_host" value="<?php echo $row->smtp_host; ?>" >
                                        </div>
										<div class="form-group">
                                            <label class="intrate">Smtp Password</label>
                                            <input class="form-control regcom" name="smtp_password" id="smtp_password" value="<?php echo $row->smtp_password; ?>" type="password">
                                        </div>
										</div>
									<!--	 <div class="form-group">
                                            <label>Sidebar</label>
                                          <select class="form-control select2"  style="width: 100%;" name="sidebar" id="sidebar">
                                               <option value="Vertical"<?php if($row->sidebar == 'Vertical') echo 'selected'; ?> >Vertical</option>
                                               <option value="Horizontal" <?php if($row->sidebar == 'Horizontal') echo 'selected'; ?>>Horizontal</option>
                                               
                                                  </select>
                                        </div> -->
						
										<div class="form-group">
                                            <label >App Secret Key</label>
                                            <input class="form-control regcom" name="serv_secret_key" id="serv_secret_key" value="<?php echo $row->serv_secret_key;?>" type="text">
                                        </div>				
										
                                         <div class="form-group">
                                            <label>Google Analytic code</label>
                                            <input class="form-control regcom"  name="analatic_code"  id="analatic_code"  value="<?php echo $row->analatic_code; ?>">
                                           
                                        </div>
										 	 <div class="form-group ">
                                            <label>Automatically  Assigning Driver </label>
                                          <select class="form-control select2"  style="width: 100%;" name="mechanic_assigned" id="Verification">
                                               <option value="on"<?php if($row->mechanic_assigned  == 'on') echo 'selected'; ?> >On</option>
                                               <option value="off" <?php if($row->mechanic_assigned  == 'off') echo 'selected'; ?>>Off</option>
                                               
                                                  </select>
                                        </div>  
										 <div class="form-group" id='Authorize.Net'>
										
                                            <label>Authorize.Net </label>
                                          <select class="form-control select2"  style="width: 100%;" name="authorize_net_url" id="Authorize.Net">
                                               <option value="https://secure.authorize.net/gateway/transact.dll"<?php if($row->authorize_net_url == 'https://secure.authorize.net/gateway/transact.dll') echo 'selected'; ?> >Live</option>
                                               <option value="https://test.authorize.net/gateway/transact.dll" <?php if($row->authorize_net_url == 'https://test.authorize.net/gateway/transact.dll') echo 'selected'; ?>>Sandbox</option>
                                               
                                                  </select>
                                           
                                        </div>
										<div id="Authorize-lid">
										<div class="form-group " id=''>
                                            <label>Authorize.Net Login ID</label>
                                          <input class="form-control regcom"  name="authorize_id"  id="Authorizeid"  value="<?php echo $row->authorize_id; ?>" >
                                           
                                        </div>
										<div class="form-group " >
                                            <label>Authorize.Net Transaction key</label>
                                          <input class="form-control regcom"  name="authorize_key"  id="Authorizekey"  value="<?php echo $row->authorize_key; ?>" >
                                           
                                        </div>
										<div class="form-group " >
                                            <label>Braintree merchant id</label>
                                          <input class="form-control regcom"  name="braintree_merchant_id"  id="braintree_merchant_id"  value="<?php echo $row->braintree_merchant_id; ?>" >
                                           
                                        </div><div class="form-group " >
                                            <label>Braintree Public key</label>
                                          <input class="form-control regcom"  name="braintree_public_key"  id="braintree_public_key"  value="<?php echo $row->braintree_public_key; ?>" >
                                           
                                        </div><div class="form-group " >
                                            <label>Braintree Private key</label>
                                          <input class="form-control regcom"  name="braintree_private_key"  id="braintree_private_key"  value="<?php echo $row->braintree_private_key; ?>" >
                                           
                                        </div>
										 </div>
										
										
										
                                         <input class="form-control regcom"  name="id"  id='id'  value="<?php echo $row->id; ?>" type="hidden">
                                        
                                          
                                        
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                              
                               
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
          
                </div>
				</div>
                <!-- /.col-lg-12 -->
            </div>
      </div><!-- /.content-wrapper -->
    

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
    <script src="<?php echo base_url();?>assets/vplugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url();?>assets/adminlte/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url();?>assets/adminlte/dist/js/demo.js"></script>
    <!-- page script -->
   <script src="<?php echo base_url();?>assets/adminlte/plugins/select2/select2.full.min.js"></script>
    
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
	
var values="<?php echo $row->paypal_option;?>";
$.each(values.split(","), function(i,e){
    $("#payment_op option[value='" + e + "']").prop("selected", true);
	
	
});
	
	$('#payment_op').on('change', function (){
    var a = $(this).val();
	$("#option-pay").val(a);
	
	
});
setTimeout(function(){$("#mess").hide(); }, 3000);
var a = $('#Verification').val();
if(a == 'on') {
	$('.Communication').show();
	$('#comu-email').hide();
	} else{
	$('.Communication').hide();
	$('#comu-email').hide();
  }
  $(".regcom").on("keydown", function (e) {
        return e.which !== 32;
	    });  
	
        
$('#Verification').on('change', function (){
    var a = $(this).val();
	
	if(a == 'on') {
	$('.Communication').show();
	$('#comu-email').hide();
	} else{
	$('.Communication').hide();
	$('#comu-email').hide();
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
$('#places').on('change', function (){
var a = $(this).val();
																		   if(a == 'google') {
																			   $('.Country').show();
																		   } else {
																			    $('.Country').hide();
																		   }
																			  
			
			});
			var a = $('#communication').val();	
			if(a == 'sms') {
																			   $('#comu-sms').show();
																			   $('#comu-email').hide();
																		   } else if(a == 'email'){
																			    $('#comu-email').show();
																				 $('#comu-sms').hide();
																		   }else{
																			   $('#comu-sms').hide();
																			   $('#comu-email').hide();
																		   }														  
			  
	$('#communication').on('change', function (){
																		   var a = $(this).val();
																		   if(a == 'sms') {
																			   $('#comu-sms').show();
																			   $('#comu-email').hide();
																		   } else if(a == 'email'){
																			    $('#comu-email').show();
																				 $('#comu-sms').hide();
																		   }else{
																			   $('#comu-sms').hide();
																			   $('#comu-email').hide();
																		   }
																			  
																	  });																  
	function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
	
	
$("#taxiadd").click(function(){
	
 var title = $('#title').val();
      logo = $('#logo').val();
	  favicon = $('#favicon').val();
	   user = $('#smtp_username').val();
	   pass = $('#smtp_password').val();
	   host = $('#smtp_host').val();
	  paypal =$('#paypalid').val();
	   email =   $('#email').val();
	  var pattern = /^\d{10}$/;
	  senderid= $('#sender-id').val();
	  smspass = $('#sms_password').val();
	  smsuser = $('#sms_username').val();
	  country = $('#country').val().length;
	  var regex = new RegExp("^[a-zA-Z]+$");
    // only validate going forward. If current group is invalid, do not go further
    // .parsley().validate() returns validation result AND show errors
	
	
    if(!title){
	   
	   $( "#title" ).addClass('error-admin');
	    $("#title").focus();
		return false;
   }
   
  
   
   
   
   
 if(!user){
	   
	   $( "#smtp_username" ).addClass('error-admin');
	    $("#smtp_username").focus();
		return false;
   }
    if(!host){
	   
	   $( "#smtp_host" ).addClass('error-admin');
	    $("#smtp_host").focus();
		return false;
   }
    if(!pass){
	   
	   $( "#smtp_password" ).addClass('error-admin');
	    $("#smtp_password").focus();
		return false;
   }
   
  if(!paypal){
	   
	   $( "#paypalid" ).addClass('error-admin');
	    $("#paypalid").focus();
		return false;
   }
   
 
  
 if(!ValidateEmail(email)){
	   
	   $( "#email" ).addClass('error-admin');
	    $("#email").focus();
		return false;
   }
   if(!senderid){
	   
	   $( "#sender-id" ).addClass('error-admin');
	    $("#sender-id").focus();
		return false;
   }

if(!smsuser){
	   
	   $( "#sms_username" ).addClass('error-admin');
	    $("#sms_username").focus();
		return false;
   }
  if(!smspass){
	   
	   $( "#sms_password" ).addClass('error-admin');
	    $("#sms_password").focus();
		return false;
   }
 
 if(country!='2' && !regex.test(country)){
	   
	   $( "#country" ).addClass('error-admin');
	    $("#country").focus();
		return false;
   }
  
 

});
});





</script>	
</div>
  </body>
</html>

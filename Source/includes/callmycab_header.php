 <?php
 
  $textFile= $row->languages;
     $extension = ".php";
    $filename=$textFile.$extension;
 
     if (file_exists($filename)) {
     include $textFile.$extension;
     }else{
    include 'en_lang.php'; 
     }
  ?>
 <nav class="navbar navbar-inverse ">
         <div class="container">
            <div class="navbar-header">
               <div class="row">
                  <div class="col-md-3">
                    
                  </div>
                  <div class="col-md-9">
                     <ul class="header-list">
                        
                      
                                  
                        
                        
                       
                      
					
                       
                       
                    
                      
                         
                       
                       
                       
                       
                 
                                
                            
                                          
                       
                       
                       
                       
                       
                      
                       
                       
                       
                       
                       
                       
                       <input type='hidden' value='<?php echo $row->verification;?>' id='verify'>
                       
                       
                       <div class="cd-user-modal"> 
                       <div id="code-login1"  class="modal fade over" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> <!-- sign up form -->
                       <div class="cd-user-modal-container1">
                             
           <p class="cd-switcher stylep" >
				<a href="#0"><?php echo $verification_code; ?></a></p>
                      
				<form class="cd-form" method="post" id="otp_reg1">
           
               <?php
			   $query = $this->db->query(" SELECT * FROM `settings` order by id DESC ");
		$rowcom = $query->row('settings');
		$communication1 = $rowcom->communication;
		if($communication1=='sms'){
		?>
				
			
                
					<p class="fieldset">
						<!--<p>Please enter the OTP you received on your registered mobile number. </p>-->
                        
						<input class="full-width has-padding has-border regcom" id="active_id" name="active_id" type="text" placeholder="Enter OTP">
						<span class="cd-error-message"><?php echo $error_message; ?></span>
					</p>
                   
					
                    <p class="resend-otp"><?php echo $OTP; ?><a href="#0" id="Otp-Resend"><?php echo $resends; ?></a></p>
					
					<?php
		}else{
			?>
			
			<p class="fieldset">
						<!--<p>Please enter the OTP you received on your registered mobile number. </p>-->
                        
						<input class="full-width has-padding has-border regcom " id="active_email" name="active_email" type="text" placeholder="Enter Code">
						<span class="cd-error-message"><?php echo $error_message; ?></span>
					</p>
			<p class="fieldset">
			<input type="hidden" name="username" id="otp-user"/>
                    <p class="resend-otp"><?php echo $re_code; ?></a></p>
						
                       
					</p>
			<?php
			
		}?>
					
					
					
					<p class="fieldset">
						<input class="full-width has-padding test " type="button" value="Verify" id="Save-code">
                       
					</p>
					
                      <p class="fieldset">
                    <div class="sms-code"></div>
                    </p>
                  
				</form>
                </div>
                     
				<a href="#0" class="cd-close-form"><?php echo $close; ?></a>
                
			</div><!-- this is the entire modal form, including the background -->
		<div class="cd-user-modal-container"> <!-- this is the container wrapper -->
			<ul class="cd-switcher register-index">
				<li><a href="#0" class="conlog"><?php echo $sign_in; ?></a></li>
				<li><a href="#0"><?php echo $new_accounts; ?></a></li>
			</ul>

			<div id="cd-login"> <!-- log in form -->
				<form class="cd-form" method="post" id="log" data-parsley-validate="">
				<p class="fieldset">
				<div class="user-wrap">
				<div class="choose">
					<div class="choose-radio">
						<input type="radio" class="regular-radio" id="user4" value="user" name="user" required="">
						<label for="user4"></label>
					</div>
					<div class="users">
						User
					</div>
				</div>
				<div class="choose">
					<div class="choose-radio">
						<input type="radio" id="driver4" class="regular-radio" value="driver" name="user"><label for="driver4"></label>
					</div>
					<div class="users">
						Driver
					</div>
				</div>
				</div>
				  
				</p>
					<p class="fieldset">
						<label class="image-replace cd-username " for="signin-email"><?php echo $username; ?></label>
						<input class="full-width has-padding has-border" id="signin-email" type="text" name="username" placeholder="Username" required="">
						<span class="cd-error-message"><?php echo $error_message; ?></span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signin-password"><?php echo $passwords; ?></label>
						<input class="full-width has-padding has-border password" id="signin-password" type="password" name="password"  placeholder="Password" required="">
						<a href="#0" class="hide-password"><?php echo $hide; ?></a>
						<span class="cd-error-message"><?php echo $error_message; ?></span>
					</p>

					<p class="fieldset">
						<input type="checkbox" id="remember-me" name="rememberme">
						<label for="remember-me"><?php echo $remember_me; ?></label>
					</p>

					<p class="fieldset">
						<input class="full-width signup" type="submit" value="Login">
					</p>
                    <p class="fieldset"> <div class="test2"></div></p>
                    
				</form>
				
				<p class="cd-form-bottom-message"><a href="0#"><?php echo $forgot_pswd; ?></a></p>
               
			
            	<a href="#0" class="cd-close-form"><?php echo $close; ?></a> 
                
			</div> <!-- cd-login -->
            
           <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
            <script src="<?php echo base_url();?>assets/js/parsley.min.js"></script>
            
            <script type="text/javascript">
$(document).ready(function(){
$(".signup").click(function(){
	if ($('#log').parsley().validate() ) {	
var value =$("#log").serialize() ;


$.ajax({
url:'<?php echo base_url();?>callmycab/userlogin',
type:'post',
data:value,
success:function(result){
	$(".test2").show();
console.log(result);

if(result==1){
$(".test2").html('<p class="error">Please enter a correct username and password</p>');
setTimeout(function(){$(".test2").hide(); }, 3000);

}
else{
	//$('.logout2').html(logout);
	if(result=="driver"){
	window.location = "<?php echo base_url();?>callmycab/account";
	}else{
		$(".sess-login1").text(result);
$(".sess-login11").attr("href", "<?php echo base_url();?>callmycab/account");
//$('.sess-login').html(result);
$(".promo-text").text("");
$(".test2").html('<p class="success">Login successfully</p>');
setTimeout(function(){$(".cd-user-modal").animate({
            left: '250px',
            opacity: '0',
            height: '150px',
            width: '150px'
        }); }, 1500);
		$('body').css("overflow-Y","scroll");
		
	}
	

}
}
});
}
});

});
</script>
            

			<div id="cd-signup"> <!-- sign up form -->
				<form class="cd-form" method="post" id="user_reg"  data-parsley-validate="">
                <p class="fieldset">
				<div class="user-wrap">
				<div class="choose">
					<div class="choose-radio">
						<input type="radio" class="regular-radio" id="user24" value="user" name="type" required="">
						<label for="user24"></label>
					</div>
					<div class="users">
						User
					</div>
				</div>
				<div class="choose">
					<div class="choose-radio">
						<input type="radio" id="driver24" class="regular-radio" value="driver" name="type"><label for="driver24"></label>
					</div>
					<div class="users">
						Driver
					</div>
				</div>
				</div>
				  
				</p>
					<p class="fieldset">
						<label class="image-replace cd-username " for="signup-username">Username</label>
						<input class="full-width has-padding has-border regcom"  id="signup-username" name="username" type="text" placeholder="Username"  data-parsley-pattern="^[a-zA-Z]+$" data-parsley-minlength="6"	 required="">
						<span class="cd-error-message">Error message here!</span>
					</p>
                    <p class="fieldset">
						<label class="image-replace cd-phone" for="signup-mobile">Contact number</label>
						<input class="full-width has-padding has-border regcom" id="signup-mobile" name="mobile"minlength="10" 	
data-parsley-minlength="10"data-parsley-trigger="keyup" data-parsley-type="digits" required="" type="text" placeholder="Mobile">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-email" for="signup-email">E-mail</label>
						<input class="full-width has-padding has-border regcom" id="signup-email" name="email" required="" type="text" placeholder="E-mail">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signup-password">Password</label>
						<input class="full-width has-padding has-border password regcom"   id="signup-password" name="password" type="password"  placeholder="Password"  data-parsley-minlength="6"required="" >
                       
						<a href="#0" class="hide-password">Show</a>
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<input type="checkbox" id="accept-terms" required="">
						<label for="accept-terms">I agree to the <a href="#0">Terms</a></label>
					</p>

					<p class="fieldset">
						<input class="full-width has-padding test testr" type="button" value="Create account" id="Save">
                       
					</p>
                  <div class="loader1" style='display:none;'>
                  <img src="<?php echo base_url();?>assets/images/ajax-loader.gif" />
                  </div>
                   <p class="fieldset">
					 <div class="test11" ></div>
					</p>
				</form>
                     
				<a href="#0" class="cd-close-form">Close</a>
                
			</div> 
            
            
            
            
            
        
           
            <script type="text/javascript">
$(document).ready(function(){
$(".hide-password").click(function () {
			if ($(".password").attr("type")=="password") {
				$(".password").attr("type", "text");
				 $(".hide-password").text('Hide');
			}
			else{
				$(".password").attr("type", "password");
				
				  $(".hide-password").text('Show');
			}
	
		});						   
						   
$('.regcom').on('change', function (){
																		   var a = $(this).val();
																		   if(a != '') {
																			   $(this).removeClass('required');
																		   } else {
																			    $(this).addClass('required');
																		   }
																			  
																	  });						   
						   
						   
 function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
	$("#signup-username").on("keydown", function (e) {
    return e.which !== 32;
	});
	
    
$(".testr").click(function(){
	
	if ($('#user_reg').parsley().validate() ) {			  
 var username = $('#signup-username').val();
	  
   $('#otp-user').val(username);
  $('.loader1').show();
var value =$("#user_reg").serialize() ;


$.ajax({
url:'<?php echo base_url();?>callmycab/testajax',
type:'post',
data:value,
success:function(res){
	$('.loader1').hide();
	$(".test11").show();
console.log(res);
var verify ="<?php echo $rowcom->verification;?>";

if(res==3){
		$(".test11").html('<p class="error">User Already Exist!!!</p>');
	
}
else if(res==4){
$(".test11").html('<p class="error">Email Already Exist!!!</p>');
setTimeout(function(){$(".test11").hide(); }, 3000);
}else if(res==5){
$(".test11").html('<p class="error">Mobile Number Already Exist!!!</p>');
setTimeout(function(){$(".test11").hide(); }, 3000);
}else if(res==2){
$(".test11").html('<p class="error">Erorr !!!</p>');
setTimeout(function(){$(".test11").hide(); }, 3000);
}

else{
if(verify=='on'){

$('#code-login1').modal('show');

$('.register-index').hide();
$('#cd-signup').hide();
$(".promo-text").text("");
}else{
if(res=='driver'){
	window.location = "<?php echo base_url();?>callmycab/account";
}else{	
$(".test11").html('<p class="success">User Registered Successfully</p>');
setTimeout(function(){$(".test11").hide(); }, 3000);
setTimeout(function(){$(".cd-user-modal").animate({
            left: '250px',
            opacity: '0',
            height: '150px',
            width: '150px'
        }); }, 1500); 

$(".sess-login1").text(res);
$(".sess-login11").attr("href", "<?php echo base_url();?>callmycab/account");
}
}

}
}
});
	}
});
 $("#Save-code").click(function(){
var username = $('#otp-user').val() ;
 communictn = $('#communictn').val() ;
 if(communictn =='sms'){
  active_id = $('#active_id').val() ;
 }else{
	  active_id = $('#active_email').val() ;
 }
   
$.ajax({
url:'<?php echo base_url();?>callmycab/otp_verify',
type:'post',
data:{'username':username,'active_id':active_id,'communictn':communictn},
success:function(res){
	$(".sms-code").show();
console.log(res);
if(res==1){
		$(".sms-code").html('<p class="error">Invalid Code!!!</p>');
	setTimeout(function(){$(".sms-code").hide(); }, 3000);
}
else if(res==3){
$(".sms-code").html('<p class="error">Error</p>');
setTimeout(function(){$(".sms-code").hide(); }, 3000);
}else{
	if(res=='driver'){
		$(".sms-code").html('<p class="success">Valid Code</p>');
setTimeout(function(){$(".sms-code").hide(); }, 3000);
	window.location = "<?php echo base_url();?>callmycab/account";
}else{
$(".sms-code").html('<p class="success">Valid Code</p>');
setTimeout(function(){$(".sms-code").hide(); }, 3000);
setTimeout(function(){$(".cd-user-modal").animate({
            left: '250px',
            opacity: '0',
            height: '150px',
            width: '150px'
        }); }, 1500);
$('body').css("overflow-Y","scroll");
$(".sess-login1").text(res);
$(".sess-login11").attr("href", "<?php echo base_url();?>callmycab/account");
}


}
}
	});							
						   
});
 
 
  $("#Otp-Resend").click(function(){
var username = $('#otp-user').val() ;
  
$.ajax({
url:'<?php echo base_url();?>callmycab/resend_otp',
type:'post',
data:{'username':username},
success:function(res){
	$(".sms-code").show();
console.log(res);
if(res==3){
		$(".sms-code").html('<p class="error">Error</p>');
	setTimeout(function(){$(".sms-code").hide(); }, 3000);
}
else{
$(".sms-code").html('<p class="success">OTP Resent Succesfully.</p>');
setTimeout(function(){$(".sms-code").hide(); }, 3000);
$('.resend-otp').remove()


}
}
	});							
						   
});
 
 $("#reset-pass").click(function(){
if ($('.fogot_form').parsley().validate() ) {
	 $('.loader1').show();
 var communictn = $('#communictn').val() ;
 if(communictn =='sms'){
  email = $('#reset-mobile').val() ;
 }else{
	  email = $('#reset-email').val() ;
 }
 var type=$('input:radio[name=user_types]:checked').val();
 $.ajax({
url:'<?php echo base_url();?>callmycab/reset_email',
type:'post',
data:{'email':email,'communictn':communictn,'type':type},
success:function(res){
	 $('.loader1').hide();
	$(".reset-pass1").show();
console.log(res);
if(res==2){
		$(".reset-pass1").html('<p class="error">Error</p>');
	setTimeout(function(){$(".reset-pass1").hide(); }, 3000);
}else if(res==0){
	$(".reset-pass1").html('<p class="error"> This email is not associated with any account.</p>');
	setTimeout(function(){$(".reset-pass1").hide(); }, 3000);
}else if(res==1){
	$(".reset-pass1").html('<p class="error"> This mobile is not associated with any account.</p>');
	setTimeout(function(){$(".reset-pass1").hide(); }, 3000);
}
else if(res==4){
$(".reset-pass1").html('<p class="success">Password has been send your mobile.</p>');
setTimeout(function(){$(".reset-pass1").hide(); }, 3000);



}
else{
$(".reset-pass1").html('<p class="success">Password has been send your mail.</p>');
setTimeout(function(){$(".reset-pass1").hide(); }, 3000);



}
}

	});	
      
}	
});       
  $("#amountsss").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
 
});
function myaddwallet(){
	    

		var id = $("#amountsss").val();
		if(!id){
			$( "#amountsss" ).addClass('required');
	        $("#amountsss").focus();
		return false;
		}
       
		
		
		
		$.ajax({
			 url:'<?php echo base_url();?>wallet/set_session',
			type:'post',
           
            
            data:{"id":id},
			
            success:function(res){
				
     if(res==''){
		 $("#iddd").html("Please Login");
	 }else{
		 $("#iddd").html(res)
	 }
			
         

        }
		 });
	
			
	}function myaddcall(){
		if ($('#cal-reg').parsley().validate() ) {
		 var form =$('#cal-reg').serializeArray();
		 
		 $.ajax({
					url:'<?php echo base_url();?>home/call_add',
					type:'post',
					data:form,
					
					success:function(book){
						
						console.log(book);
						
						 var items = JSON.parse(book);
						 var s = items[0].message;
						 
						 $('.results-call').text(s);
						  setTimeout(function(){ $('.results-call').hide(); }, 3000);
						  $('#cal-reg')[0].reset();
						  setTimeout(function(){$('#newModals').modal('hide'); }, 3000);
						  
					}
				});
		}
		
	}
	

</script>

            <!-- cd-signup -->

			<div id="cd-reset-password">
			<?php
			
		$communication = $rowcom->communication;
			?>
<input type='hidden' value='<?php echo $row->communication; ?>' id='communictn'>			<!-- reset password form -->
			  <?php
	   
		if($communication=='email'){
	  ?>
				<p class="cd-form-message">Lost your password? Please enter your email address. You will receive a link to create a new password.</p>

				<form class="cd-form fogot_form" data-parsley-validate="">
				<p class="fieldset">
				<div class="user-wrap">
				<div class="choose">
					<div class="choose-radio">
						<input type="radio" class="regular-radio" id="forgot24" value="user" name="user_types"  data-parsley-trigger="keyup"  required="">
						<label for="forgot24"></label>
					</div>
					<div class="users">
						User
					</div>
				</div>
				<div class="choose">
					<div class="choose-radio">
						<input type="radio" id="forgot2424" class="regular-radio" value="driver" name="user_types"><label for="forgot2424"></label>
					</div>
					<div class="users">
						Driver
					</div>
				</div>
				</div>
				  
				</p>
					<p class="fieldset">
						<label class="image-replace cd-email" for="reset-email">E-mail</label>
						<input class="full-width has-padding has-border" id="reset-email" type="email" placeholder="E-mail" data-parsley-trigger="change"  required="">
						<span class="cd-error-message">Error message here!</span>
					</p>
<?php
		}
		else{?>
		<p class="cd-form-message">Lost your password? Please enter your mobile number.<br>You will receive a new password.</p>

				<form class="cd-form fogot_form" data-parsley-validate="">
				
				<p class="fieldset">
				<div class="user-wrap">
				<div class="choose">
					<div class="choose-radio">
						<input type="radio" class="regular-radio" id="forgot25" value="user" name="user_types"  data-parsley-trigger="keyup"  required="">
						<label for="forgot25"></label>
					</div>
					<div class="users">
						User
					</div>
				</div>
				<div class="choose">
					<div class="choose-radio">
						<input type="radio" id="forgot26" class="regular-radio" value="driver" name="user_types"><label for="forgot26"></label>
					</div>
					<div class="users">
						Driver
					</div>
				</div>
				</div>
				  
				</p>
					<p class="fieldset">
						<label class="image-replace cd-phone" for="reset-mobile">Mobile Number</label>
						<input class="full-width has-padding has-border" id="reset-mobile" type="text" placeholder="Mobile" data-parsley-trigger="change"  required="">
						<span class="cd-error-message">Error message here!</span>
					</p>

		
		<?php
		}
		?>
		<div class='reset-pass1'></div>
					<p class="fieldset">
						<input class="full-width has-padding test" type="button" value="Reset password" id='reset-pass'>
					</p>
					 <div class="loader1" style='display:none;'>
                  <img src="<?php echo base_url();?>assets/images/ajax-loader.gif" />
                  </div>
				</form>

				<p class="cd-form-bottom-message"><a href="#0">Back to log-in</a></p>
			</div> <!-- cd-reset-password -->
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
			<a href="#0" class="cd-close-form">Close</a>
		</div> <!-- cd-user-modal-container -->
	</div>
                       
                       
                       
                       
                     </ul>
                  </div></div>
               </div>
			   
			   <div class="modal fade" id="newModals" role="dialog">
						<div class="modal-dialog" style="top: 140px;">
							<div role="document" class="modal-dialog">
							               
								<div class="modal-content ac-usr-myveh-edt-popup-wrapper">
								
									<div class="modal-header">
										<div class="ac-usr-myveh-edt-popup-header">
											<h1>Call back</h1>
										</div>
									</div>
									<div class="modal-body">
									<form  id="cal-reg" data-parsley-validate="">
										<div class="ac-usr-myveh-edt-popup-content">
											<div class="row">
												
												<input type="text"data-parsley-trigger="keyup" minlength="10" 	
data-parsley-minlength="10" data-parsley-maxlength="15" data-parsley-type="digits"required="" placeholder="Enter Phone Number" id="Call" class="ac-usr-myveh-edt-popup-input" name="phone">
										   <input type="hidden" id="id" name="id" value="68">    
											</div>
											<input type="button" class="reg-form-next"  value="Submit" onclick="myaddcall();">       <div class="results-call"></div>                                             </div>
											</form>
									</div>
								</div>
                                        </div>
							
						</div>
					</div> 
					<?php
$mesr = $rowcom->measurements;
$str = $rowcom->currency;
$s1 = explode(',',$str);
$paypal_url=$rowcom->paypal; 
$paypal_id=$rowcom->paypalid; 
$from =$s1[0];
$to ="USD";
 $uneaque_id = 'CMC'.strtotime(date('m/d/Y H:i:s'));
	$ddd="" ;
	 $id="0";					
					?>
             <div class="modal fade" id="newwallet" role="dialog">
						<div class="modal-dialog" style="top: 140px;">
							<div role="document" class="modal-dialog">
							               
								<div class="modal-content ac-usr-myveh-edt-popup-wrapper">
								
									<div class="modal-header">
										<div class="ac-usr-myveh-edt-popup-header">
											<h1>Refill Your Wallet</h1>
										</div>
									</div>
									
									<div class="modal-body">

										<div class="ac-usr-myveh-edt-popup-content">
											<div class="row">
												
												<input type="text" name="amounts" id="amountsss" class="ac-usr-myveh-edt-popup-input regcom" >
										      
											</div>
											<input type="button" class="reg-form-next"  value="Add Money" onclick="myaddwallet();">      <div id="iddd" style="text-align:center;"></div>                                           </div>
									</div>
									
								</div>
                                        </div>
							
						</div>
					</div> 
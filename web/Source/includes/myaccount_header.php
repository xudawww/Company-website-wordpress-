 
         <div class="container">
            <div class="navbar-header">
               <div class="row">
                  
                  <div class="col-md-9">
                     <ul class="header-list">
                    
                       
                       
                       
                       
                       
                       
                       
                       
            

                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                     
                       
                       <div class="cd-user-modal"> <!-- this is the entire modal form, including the background -->
		<div class="cd-user-modal-container"> <!-- this is the container wrapper -->
			<p class="cd-switcher stylep">
           
				<a href="#0">Change Password</a>
               
				
			</p>

			<!-- cd-login -->
            
           
            
            <script type="text/javascript">
$(document).ready(function($){
						   
						   
						    $('.paste-copy').bind('cut copy paste', function(event) {
        event.preventDefault();
    });
						 $('.regcom').on('change', function (){
																		   var a = $(this).val();
																		   if(a != '') {
																			   $(this).removeClass('required');
																		   } else {
																			    $(this).addClass('required');
																		   }
																			  
																	  });	
$("#change-pass").click(function(){
var current =$("#current").val() ;
var newpass =$("#chan-pass").val() ;
var confirmpass =$("#confirm-pass").val() ;
if(!current){
	$( "#current" ).addClass('required');
    $("#current").focus();
		return false;
}
if(!newpass){
	$( "#chan-pass" ).addClass('required');
    $("#chan-pass").focus();
		return false;
}
if(!confirmpass){
	$( "#confirm-pass" ).addClass('required');
    $("#confirm-pass").focus();
		return false;
}
$.ajax({
url:'<?php echo base_url();?>callmycab/changepassword',
type:'post',
data:{'current':current,'newpass':newpass,'confirmpass':confirmpass},
success:function(password){
		$("#error").show();
console.log(password);
if(password == 2){
	
$("#error").html('<p class="success">Password changed successfully</p>');
setTimeout(function(){location.reload(); }, 3000);

}else if(password == 0){
	$("#error").html('<p class="error">Password missmatch</p>');
	setTimeout(function(){$("#error").hide(); }, 3000);
}
else if(password == 3){
$("#error").html('<p class="error">Invalid current password</p>');
setTimeout(function(){$("#error").hide(); }, 3000);
}else{
	$("#error").html('<p class="error">Sorry error occured</p>');
	setTimeout(function(){$("#error").hide(); }, 3000);
}
}
});
});

});
</script>
            

			           
         
            <!-- cd-signup -->

			<div id="cd-reset-password"> <!-- reset password form -->
				

				<form class="cd-form" id="c-password">
               
					<p class="fieldset">
						<label class="image-replace cd-password " for="reset-email">Current Password</label>
						<input class="full-width has-padding has-border regcom paste-copy" id="current" type="password" placeholder="Current Password">
						<span class="cd-error-message">Error message here!</span>
					</p>
                    <p class="fieldset">
						<label class="image-replace cd-password " for="reset-email">Change Password</label>
						<input class="full-width has-padding has-border regcom paste-copy" id="chan-pass" type="password" placeholder="New Password">
						<span class="cd-error-message">Error message here!</span>
					</p>
                    <p class="fieldset">
						<label class="image-replace cd-password " for="reset-email">Confirm Password</label>
						<input class="full-width has-padding has-border regcom paste-copy" id="confirm-pass" type="password" placeholder="Confirm Password">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<input class="full-width signup has-padding test" type="button" value="Reset password" id="change-pass">
					</p>
                     <p class="fieldset">
                      <div id="error">
</div>
                   </p>
				</form>
               
          
           
				
			</div> <!-- cd-reset-password -->
			<a href="#0" class="cd-close-form">Close</a>
            
		</div> <!-- cd-user-modal-container -->
	</div>
                       
                       
                       
                       
                     </ul>
                  </div></div>
               </div>
            
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <title>Installer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/installer.css">
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    </head>
    
    
    <body>

<div class="container">
	<div class="bms-wizard-wrapper">
		
			<div class="bms-logo">
							<img src="img/logo.png">
						</div>
      <div class="stepwizard">
    <div class="stepwizard-row setup-panel">
          <div class="stepwizard-step">
        <a href="#step-1" type="button" class="btn btn-primary btn-circle ">MYSQL DETAILS</a>
       
      </div>
          <div class="stepwizard-step">
        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">SMTP DETAILS</a>
       
      </div>
       <div class="stepwizard-step">
        <a href="#step-4" type="button" class="btn btn-default btn-circle " disabled="disabled">SETTINGS</a>
      
      </div>
          <div class="stepwizard-step">
        <a href="#step-3" type="button" class="btn btn-default btn-circle " disabled="disabled">DONE</a>
     
      </div>
        </div>
  </div>
      <form role="form"  id='Values' action="" method="post">
    <div class="row setup-content" id="step-1">
          
        <div class="col-md-12">
              
          <div class="form-group">
            <label class="control-label whtclr">Database Host</label>
            <input  maxlength="100" type="text" required="required" id="db_host" name="db_host" class="form-control chclr" placeholder="Database Host"  />
          </div>
          <div class="form-group">
            <label class="control-label whtclr">Database Name</label>
            <input maxlength="100" type="text" required="required" id="db_name" name="db_name" class="form-control chclr" placeholder="Database Name" />
          </div>
          <div class="form-group">
            <label class="control-label whtclr">Database Username</label>
             <input maxlength="100" type="text" required="required" id="db_username" name="db_username" class="form-control chclr" placeholder="Database Username" />
          </div>
          <div class="form-group">
            <label class="control-label whtclr">Database Password</label>
             <input maxlength="100" type="password"  name="db_password" id="db_password" class="form-control chclr" placeholder="Database Password" />
          </div>
              <button class="btn btn-primary nextBtn btn-lg pull-right next" id="sqlDetails" type="button" >Next</button>
           <div class="loader" >
                <img src="img/loader.gif" width="120" height="120" />
             </div>
        </div>
           <div class="message"></div>
     
        </div>
    <div class="row setup-content" id="step-2">

        <div class="col-md-12">
              
              <div class="form-group">
            <label class="control-label whtclr">SMTP Host</label>
            <input maxlength="200" type="text" required="required" id="smtp_host" name="smtp_host" class="form-control chclr" placeholder="SMTP Host" />
          </div>
              <div class="form-group">
            <label class="control-label whtclr">SMTP Username</label>
            <input maxlength="200" type="text" required="required" id="smtp_username" name="smtp_username" class="form-control chclr" placeholder="SMTP Username"  />
          </div>
          <div class="form-group">
            <label class="control-label whtclr">SMTP Password</label>
            <input maxlength="200" type="password" required="required" id="smtp_password" name="smtp_password" class="form-control chclr" placeholder="SMTP Password"  />
          </div>
              <button class="btn btn-primary nextBtn btn-lg pull-right next"  type="button" >Next</button>
              <div class="loader" >
                <img src="img/loader.gif" />
             </div>
            </div>
     
        </div>
        <div class="row setup-content" id="step-4">
        
        <div class="col-md-12">
             

              <div class="form-group">
            <label class="control-label whtclr">Admin Email</label>
            <input maxlength="200" type="email" required="required" id="admin_email" name="email" class="form-control chclr" placeholder="Admin Email" />
          </div>
              <div class="form-group">
            <label class="control-label whtclr">SMS Gateway Username</label>
            <input maxlength="200" type="text"  required="required" id="sms_username" name="sms_username" class="form-control chclr" placeholder="SMS Gateway Username"  />
          </div>
           <div class="form-group">
            <label class="control-label whtclr">SMS Gateway Password</label>
            <input maxlength="200" type="password"  required="required" id="sms_password" name="sms_password" class="form-control chclr" placeholder="SMS Gateway Password"  />
          </div>
          <!--  <div class="form-group">
            <label class="control-label whtclr">Security Key</label>
            <input maxlength="200" type="password" required="required" id="security_key" name="security_key" class="form-control chclr" placeholder="Security key"  />
          </div> -->
              <button class="btn btn-primary nextBtn btn-lg pull-right next" type="button" >Next</button>
             <div class="loader" >
                <img src="img/loader.gif" />
             </div>
            </div>
   
        </div>
    <div class="row setup-content" id="step-3">
        
        <div class="col-md-12">
			 <h3 class="dtlall"> All Details</h3>
			<div class="out_bs allData">
			<!-- appending data -->
			</div>
			
			
			
              <button class="btn btn-success btn-lg pull-right next" id="formData" type="button">Submit</button>
             <div class="message"></div>
             <div class="loader" >
                <img src="img/loader.gif" />
             </div>
            </div>
      
        </div>
  </form>
    </div>
		</div>

<script type="text/javascript">
  $(document).ready(function () {

  var navListItems = $('div.setup-panel div a'),
      allWells = $('.setup-content'),
      allNextBtn = $('.nextBtn');

  allWells.hide();

  navListItems.click(function (e) {
    e.preventDefault();
    var $target = $($(this).attr('href')),
        $item = $(this);

    if (!$item.hasClass('disabled')) {
      navListItems.removeClass('btn-primary').addClass('btn-default');
      $item.addClass('btn-primary');
      allWells.hide();
      $target.show();
      $target.find('input:eq(0)').focus();
    }
  });

  allNextBtn.click(function(){
    var curStep = $(this).closest(".setup-content"),
      curStepBtn = curStep.attr("id"),
      nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
      curInputs = curStep.find("input[type='text'],input[type='url'],input[type='password'],input[type='email'],textarea[textarea]"),
      isValid = true;

    $(".form-group").removeClass("has-error");
    for(var i=0; i<curInputs.length; i++){
      if (!curInputs[i].validity.valid){
        isValid = false;
        $(curInputs[i]).closest(".form-group").addClass("has-error");
      }
    }
//alert(isValid);
/*mycode*/
    if(curStepBtn=="step-1" && isValid==true){
      var mysqlDetails=$('#Values').serialize();
        $('.loader').show();
          $.ajax({
            url:'dbconnect.php',
            type:'post',
            data:mysqlDetails,
            success:function(result){
              $('.loader').hide();
              if(result=="Success"){
                isValid = true;
                if(isValid)
                  nextStepWizard.removeAttr('disabled').trigger('click');
              }else{
                isValid = false;
                $('.message').html('<br><div class="label label-danger">Could not connect to MYSQL!</div>');
				setTimeout(function(){$(".message").hide();}, 3000);
              } 

            }
          });
    }else{
      if (isValid)
        nextStepWizard.removeAttr('disabled').trigger('click');
    }

    if(curStepBtn=="step-4" && isValid==true){
      var db_host=$('#db_host').val();
      var db_name=$('#db_name').val();
      var db_username=$('#db_username').val();
      var db_password=$('#db_password').val();

      var smtp_host=$('#smtp_host').val();
      var smtp_username=$('#smtp_username').val();
      var smtp_password=$('#smtp_password').val();
      
      var admin_email=$('#admin_email').val();
      var sms_username=$('#sms_username').val();
      var sms_password=$('#sms_password').val();
     // var security_key=$('#security_key').val();

      var allVal='<div class="col-md-6 " style="padding:0px;"> <div class="all_dtl"><div class="all_dtl1">Database Host</div><div class="all_dtl2">:</div><div class="all_dtl3">'+db_host+'</div></div><div class="all_dtl"><div class="all_dtl1">Database Name</div><div class="all_dtl2">:</div><div class="all_dtl3">'+db_name+'</div></div><div class="all_dtl"><div class="all_dtl1">Database Username</div><div class="all_dtl2">:</div><div class="all_dtl3">'+db_username+'</div></div><div class="all_dtl"><div class="all_dtl1">Database Password</div><div class="all_dtl2">:</div><div class="all_dtl3">'+db_password+'</div></div><div class="all_dtl"><div class="all_dtl1">SMTP Host</div><div class="all_dtl2">:</div><div class="all_dtl3">'+smtp_host+'</div></div><div class="all_dtl"><div class="all_dtl1">SMTP USername</div><div class="all_dtl2">:</div><div class="all_dtl3">'+smtp_username+'</div></div></div><div class="col-md-6"><div class="all_dtl"><div class="all_dtl1">SMTP Password</div><div class="all_dtl2">:</div><div class="all_dtl3">'+smtp_password+'</div></div><div class="all_dtl"><div class="all_dtl1">Admin Email</div><div class="all_dtl2">:</div><div class="all_dtl3">'+admin_email+'</div></div><div class="all_dtl"><div class="all_dtl1">SMS Gateway Username</div><div class="all_dtl2">:</div><div class="all_dtl3">'+sms_username+'</div></div><div class="all_dtl"><div class="all_dtl1">SMS Gateway Password</div><div class="all_dtl2">:</div><div class="all_dtl3">'+sms_password+'</div></div></div>';
       $('.allData').html(allVal);

    }
   
/*end mycode*/
  });

  $('div.setup-panel div a.btn-primary').trigger('click');

    $('#formData').click(function(){
      var allDetails=$('#Values').serialize();
         $('.loader').show();
          $.ajax({
            url:'allDetails.php',
            type:'post',
            data:allDetails,
            success:function(result){
              $('.loader').hide();
              if(result=="Success"){
                window.location.href ='../index.php';
              }else{
                
                $('.message').html('<br><div class="label label-danger">Error Occured</div>');
				setTimeout(function(){$(".message").hide();}, 3000);
              } 

            }
          });
    });

});
  </script>
</body>
</html>

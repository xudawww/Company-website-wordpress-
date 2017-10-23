<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CMC| Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/plugins/iCheck/square/blue.css">

    
  </head>
  <style>
 .login_page .alert {margin-top: 10px!important;text-align: center!important;padding: 5px!important;}

  </style>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
	  <img class="circle" src="<?php echo base_url();?>upload/logo.png">
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <!--<form action="../../index2.html" method="post">-->	
		<form role="form" id="adminlog">
          <div class="form-group has-feedback">
                                 <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="email" type="text" autofocus>
                                 </div>
                                 <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
                                 <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                 </div>
                                 <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                                     <label>
                                        <input  type="checkbox" value="Remember Me" name="rememberme">Remember Me
                                     </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-12">
             
			  <input type="button" class="btn btn-primary btn-block btn-flat" value="Sign In" id="sublog">
			  <div class="atest2 login_page"></div>
            </div><!-- /.col -->
          </div>
        </form>

		

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url();?>assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url();?>assets/adminlte/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url();?>assets/adminlte/plugins/iCheck/icheck.min.js"></script>
    <script type="text/javascript">
    $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
    });
    

$(document).ready(function () {
		$('#adminlog input').keypress(function(e) {
			if (e.keyCode == 13) {
				$('#sublog').click();
				//alert("dfdf");
			}
		});
		$("#sublog").click(function(){
			var value =$("#adminlog").serialize() ;
			$.ajax({
				url:'<?php echo base_url();?>admin/adminlogin',
				type:'post',
				data:value,
				success:function(result){
					$(".atest2").show();
					console.log(result);
					if(result==1){
						$(".atest2").html('<div class="alert alert-danger">Login Failed</div>');
						setTimeout(function(){$(".atest2").hide(); }, 3000);

					}
					else{	
						window.location.href="<?php echo base_url();?>admin/dashboard";

					}
				}
			});

		});

});
</script>
	
  </body>
</html>

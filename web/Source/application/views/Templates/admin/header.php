<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- META SECTION -->
        <title><?php echo $page_title; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
		<?php 
$settings_get=getsettingsdetails();
print_r(getLanguageForsite());
?>
        <link rel="icon" href="<?php echo $settings_get->fav_icon; ?>" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>assets/css/theme-default.css"/>
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>assets/css/parsley.css"/>
        <!-- EOF CSS INCLUDE -->

        <!-- START PLUGINS -->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/bootstrap/bootstrap.min.js"></script>
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->
        <script type='text/javascript' src='<?php echo base_url(); ?>assets/js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/scrolltotop/scrolltopcontrol.js"></script>

        <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/morris/raphael-min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/morris/morris.min.js"></script> -->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/rickshaw/d3.v3.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/rickshaw/rickshaw.min.js"></script>
        <script type='text/javascript' src='<?php echo base_url(); ?>assets/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'></script>
        <script type='text/javascript' src='<?php echo base_url(); ?>assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'></script>
        <script type='text/javascript' src='<?php echo base_url(); ?>assets/js/plugins/bootstrap/bootstrap-datepicker.js'></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/bootstrap/bootstrap-timepicker.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/owl/owl.carousel.min.js"></script>


        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
        <!-- END THIS PAGE PLUGINS-->

        <!-- START TEMPLATE -->


        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/actions.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/parsley.js"></script>
        <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/demo_dashboard.js"></script> -->
        <!-- END TEMPLATE -->

        <!-- <script src="./js/jquery.min.js"></script> -->


    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">

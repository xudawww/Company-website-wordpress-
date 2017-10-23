 <?php include getLanguageForsite();
$get_settings=getsettingsdetails(); ?>
<div class="container-fluid">
    <div class="about-back">
     <div class="container">
         <img src="<?php echo base_url(); ?>assets/img/about/1.png" class="img-responsive img-graph" alt=""/>
         <div class="gr-inner">
             <h3>
                 <img src="<?php echo base_url(); ?>assets/img/about/2.png"/>
                 <img src="<?php echo base_url(); ?>assets/img/about/3.png"/>
             </h3>

         </div>
        <div class="col-lg-12">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <h4> <?php echo $lang_about_header1; ?> </h4>
                <h5>'<?php echo $lang_about_header2; ?>'</h5>
                <p> <?php echo $lang_about_content; ?> </p>
            </div>
            <div class="col-lg-2"></div>
        </div>



     </div>
    </div>
    <div class="col-lg-12 col-rw-grey">
        <div class="col-lg-4 col-md-4">
            <img src="<?php echo base_url(); ?>assets/img/about/5.png" class="grey-tr"/>
        </div>
        <div class="col-lg-8">
            <img src="<?php echo base_url(); ?>assets/img/about/4.png" class="man-pwr img-responsive"/>
            <div class="getting-abt">
                <h3> <?php echo $lang_about_footer1; ?> </h3>
                <h4> <?php echo $lang_about_footer2; ?> </h4>
                <h5> <?php echo $lang_about_footer3; ?> </h5>
            </div>
        </div>

    </div>
<!--    <div class="foot-slant">-->
<!--        <img src="img/about/6.png"/>-->
<!--    </div>-->

</div>
 
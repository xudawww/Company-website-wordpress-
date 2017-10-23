<?php  include getLanguageForsite();  ?> 

<!--contact-->
<div class="container-fluid" style="background: #e8e8e8;">
    <div class="col-lg-12">
        <div class="col-lg-6" style=" padding: 0;">
            <div class="contact-left">
                <img src="<?php echo base_url();?>assets/img/contact/1.jpg" class="img-responsive" alt=""/>
            </div>
        </div>
        <div class="col-lg-4" style="padding: 0;">
            <div class="row">
                <div class="col-lg-12 pad-cl-1" >
                    <div class="row bac-orange">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8 ">
                            <div class="contact-right">
                                <h4><?php echo $lang_contact; ?></h4>
                                <form name="contact_form" id="contact_form" data-parsley-validate="">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="" name="name" placeholder="<?php echo $lang_name; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id=" " name="phone" placeholder="<?php echo $lang_phone; ?>" data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup" data-parsley-type="digits" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="" name="email" placeholder="<?php echo $lang_email; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <textarea placeholder="<?php echo $lang_suggestion; ?>" name="message" class="form-control text-cnt" required></textarea>
                                    </div>
									<div id="success_contact"><?php echo $lang_mail_send; ?></div>
									<div id="error_psw"><?php echo $lang_error_submission; ?></div>
									
                                    <div class="form-group">
                                        <button type="button" name="contact_form_sub" class="btn btn-default btn-cnt-send contact_form_button"><?php echo $lang_send; ?></button>
                                    </div>
                                </form>

                                <div class="clearfix"></div>

                                <div class="show-div">
                                    <span class="show-add-img"><img src="<?php echo base_url();?>assets/img/contact/2.png"/> </span><h5><?php echo $lang_show_address; ?></h5>
                                </div>
                                <div class="clearfix"></div>

                                <div class="hd-div-1">
                                <span><img src="<?php echo base_url();?>assets/img/contact/3.png"/> </span><h5 class="hide-address"><?php echo $lang_hide_address; ?></h5>
                                 </div>

                                <div class="cnt-hide">
                                  <div class="cnt-add-left">
                                    <img src="<?php echo base_url();?>assets/img/contact/4.png"/>
                                      <h6><?php echo $lang_contact_address; ?></h6>
                                      <h6> <?php echo $lang_or; ?> </h6>
                                      <h6><?php echo $lang_contact_mail; ?> </h6>
                                      <a href=""> mail@techware.in</a>
                                  </div>
                                </div>

                                <div class="clearfix"></div>

                            </div>
                        </div>
                        <div class="col-lg-2"></div>
                    </div>
                </div>

            </div>

             <div class="car-contact animated fadeInRight">
                 <img src="<?php echo base_url();?>assets/img/contact/1.png" class="img-responsive" alt="" />
             </div>
        </div>
    </div>

</div>

<!--contact-->
 
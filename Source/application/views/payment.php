 
<?php
list($currency,$code) = explode(',', $settings->currency);
  include getLanguageForsite(); 
?>
<div class="container-fluid" style="background: #eeeeee;">

<div class="container">

    <div class="col-lg-2"></div>

    <div class="col-lg-8">

   <div class="payment-main">

       <h2><?php echo $lang_payment; ?></h2>

   </div>

        <div class="row pay-wallet">

            <div class="col-lg-6">

              <h3><?php echo $lang_wallet; ?><span><?php echo $code."0.00"; ?> </span></h3>

            </div>

            <div class="col-lg-6">

                <h3 class="fl-rght"><?php echo $lang_amount; ?><span><?php echo $code.$data['amount']; ?> </span></h3>

            </div>

        </div>







            <div class="form-payment-mn">

                <div class="radio-payment">

                    <?php
                        $payment_option = explode(',', $settings->paypal_option);
                        if (in_array("Credit_Card", $payment_option)) { ?>
                            <label class="radio-inline">

                                <input type="radio" name="payment_option" id="credit_card" value="credit_card"><?php echo $lang_credit_card; ?><span><img src="<?php echo base_url();?>assets/img/payment/1.png"/></span>

                            </label>
                        <?php }

                        if (in_array("PayPal", $payment_option)) { ?>
                            <label class="radio-inline">

                                <input type="radio" name="payment_option" id="paypal" value="paypal"><?php echo $lang_paypal; ?><span><img src="<?php echo base_url();?>assets/img/payment/2.png"/></span>

                            </label>
                        <?php } 
                        if (in_array("Cash", $payment_option)) { ?>
                            <label class="radio-inline">

                                <input type="radio" name="payment_option" id="cash" value="cash"><?php echo $lang_by_hand; ?>

                            </label>
                        <?php } ?>

                </div>


                <div id="credit_card_form" style="display:none">
                <div class="form-group col-lg-6 pad-zero">

                    <label for="usr" class="label-paymnt"><?php echo $lang_card_number; ?></label>

                    <input type="text" class="form-control pay-control" id="card_no" name="card_no">

                </div>

                <div class="clearfix"></div>



                <div class="row" >

                    <div class="col-lg-5">

                        <div class="form-group">

                            <label for="usr" class="label-paymnt"><?php echo $lang_expiration_date; ?></label>

                            <input type="text" class="form-control pay-control" placeholder="<?php echo $lang_month_year; ?>" id="exp_date" name="exp_date"> <?php if($settings->card_option=='Authorize') { echo 'eg: 12/28'; } else { echo 'eg: 06/2032'; } ?>

                        </div>

                    </div>

                    <div class="col-lg-2">

                        <div class="form-group">

                            <label for="usr" class="label-paymnt">CVV2/ CVC2</label>

                            <input type="text" class="form-control pay-control" id="card_cvv" name="card_cvv">

                        </div>

                    </div>



                    <div class="col-lg-4">

                        <p class="cvv-p"><?php echo $lang_last_digits; ?></p>

                    </div>

                </div>
                </div>

                <div class="row" id="error_msg_class"></div>


                <input type="hidden" name="amount" id="amount" value="<?php echo $data['amount']; ?>" />
                <input type="hidden" name="booking_id" id="booking_id" value="<?php echo $data['booking_id']; ?>" />
                <input type="hidden" name="credit_option" id="credit_option" value="<?php echo $settings->card_option; ?>" />
                
				 
                <button type="button" class="btn btn-default btn-form btn-pay-sub" id="payment_submit"><?php echo $lang_submit; ?></button>

            </div>





    </div>

    <div class="col-lg-2"></div>

</div>



</div>



<!--payment-->

 
<?php

$query1 = $this->db->query(" SELECT * FROM `settings` WHERE id='1'");
$row = $query1->row('settings');
$mesr = $row->measurements;
$str = $row->currency;
$s1 = explode(',',$str);
$s =$this->session->userdata('uneaqueid');
$id= $this->session->userdata('bookid');
$purpose = $_POST['purpose'];
$car= $_POST['taxi_type'];
$time = $_POST['pickup_time'];
$paypal_url=$row->paypal; 
$paypal_id=$row->paypalid; // sriniv_1293527277_biz@inbox.com
$username = $this->session->userdata('username');

$from =$s1[0];
$to ="USD";

$txt='';
 $amount1=$this->session->userdata('amount');
	

 $ddd=number_format($amount1);
		
		
		if(isset($amount1)){
		/*$amount = urlencode($amount1);
$from_Currency = urlencode($from);
$to_Currency = urlencode($to);
$get = $this->curl->simple_get("https://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency");
$get = explode("<span class=bld>",$get);
$get = explode("</span>",$get[1]);  
$converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);
$ddd = number_format($camount);
echo $ddd;
exit();
ini_set('default_socket_timeout', 900); 
$ctx = stream_context_create(array('http'=>
    array(
        'timeout' => 1200,  //1200 Seconds is 20 Minutes
    )
));
$details = json_decode(file_get_contents("http://rate-exchange.herokuapp.com/fetchRate?from=$from_Currency&to=$to_Currency", false, $ctx));


$camount =$details->Rate*$amount1;*/
//echo $amount1;
		 $ddd = $amount1;
		
		}

   
 
		
		
		
	$queryu = $this->db->query(" SELECT * FROM `userdetails` WHERE username='$username' ");
$rowu = $queryu->row('userdetails');

if($rowu->wallet_amount!='' || $rowu->wallet_amount!='0'){
	$wallet =$rowu->wallet_amount;
	$w = $rowu->wallet_amount;
	$a = $ddd;
	if($w > $a ){
		 $amount2 =($w - $a)*1 ;
		$hides ="hides";
		$amount="0";
		//echo "positive walet";
	}else{
		$amount = ($a - $w)*1;
		$hides ="";
		$amount2="0";
		//echo "positive amount";
	}
	
}else{
$amount2="0";
$hides ="";
 $amount = $ddd;
//echo " amount";
}

$this->session->set_userdata('wallet-balance',$amount2);	
?>

<div class="payment">
		<div class="payment-wrapper">
			<div class="payment-outter">
				<div class="payment-inner">
				
					<div class="row">
					<div class="col-md-12">
					
						<div class="paycard">
						<ul class="pay1">
						<li><div class="x1">Wallet:$<?php echo $amount2;?></div></li>
						<li><div class="x1">Amount:$<?php echo  $amount;?></div></li>
						</ul>
						
						<ul class="pay1 <?php echo $hides;?>" >
						
						<?php
						
						$pay =array($row->paypal_option);
						$str = explode(',',$row->paypal_option);
						
if (in_array("Authorize.Net", $str) && $hides!='hides')	{					
						?>
						<li><input type="radio" id="radio-1-4" value="Credit" name="types" class="regular-radio"  requred=""/><label for="radio-1-4"></label><div class="x1">Credit Card<img src="<?php echo base_url();?>assets/images/visacard.png"></div></li>
<?php
}if(in_array("PayPal", $str) && $hides!='hides' )	{
?>
						<li><input type="radio" id="radio-1-5" name="types" class="regular-radio" value="Paypal" requred=""/><label for="radio-1-5"></label><div class="x1">Paypal<img src="<?php echo base_url();?>assets/images/paypal.png"></div></li>
						<?php
}							

if(in_array("Braintree", $str) && $hides!='hides' )	{
?>
<li><input type="radio" id="radio-1-6" name="types" class="regular-radio" value="Braintree" requred=""/><label for="radio-1-6"></label><div class="x1">Braintree<img src="<?php echo base_url();?>assets/images/paypal.png"></div></li>
			<?php
}
?>

						</ul>
						<ul class="pay1">
						<?php
						if (in_array("By hand", $str) && $hides!='hides')	{
							?>
						<li><input type="radio" id="radio-1-1" name="types" value="wallet" class="regular-radio" requred="" /><label for="radio-1-1"></label><div class="x1">By Hand</div></li>
						<?php
						}if( $hides=='hides' )	{
						?>
						<li><input type="radio" id="wallet456" name="types" value="byhand " class="regular-radio" requred="" /><label for="wallet456"></label><div class="x1">Use Wallet</div></li>
						<?php
						}
						?>
						
						</ul>
						</div>
						</div>
					</div><br>
					<form id="Credit-card"  data-parsley-validate="">
					<div class="paycard-details">
							Card Number<br><br>
							<input class="card-input" type="text" name="x_card_num"  requred="" data-parsley-type="digits">
					</div><br>
					<div class="paycard-details">
							
							<div class="col-md-6 padding0">
								Expiration Date<br>
								<div class="card-data" style="padding-left: 0px;">
								<input type="text" class="card-input1" placeholder="Month/Year" name="x_exp_date" requred="">
							</div>
							</div>
							<div class="col-md-1">
							</div>
							<div class="col-md-3 padding0">
								CVV2/CVC2
								<div class="card-data" style="padding-left:0px;">

								<input type="text"  class="card-input1" name="x_card_code" minlength="3" 	
data-parsley-minlength="3"  data-parsley-type="digits" requred="">
								<input type="hidden"  class="card-input1" name="x_amount" value="<?php echo $amount;?>">
								<input type="hidden"  class="card-input1" name="x_country" value="<?php echo"US";?>">
							</div>
							</div>
							<div class="col-md-2 padding0">
								<div class="card-data font10">
									<p>The last 3 digits displayed<br>
									onthe back of your card</p>
								</div>
							</div>
											<div class="brain">
							Name on Card
							<input class="card-input" type="text" name="x_card_name"  requred="" data-parsley-type="alphanum">
</div>
					</div>
					
					
                    <input class="paybtn btn-continue" value="Submit"type="button" id ="authorized">
                    
					</form>	
					<div class="results"></div>
				</div>
			</div>
		</div>
	</div>
        <div class="product">            
            
            <div class="btn">
			
			
			
			
                <form action='<?php echo $paypal_url; ?>' method='post' name='frmPayPal1' class="paypals" style="display:none">
                    <input type='hidden' name='business' value='<?php echo $paypal_id;?>'>
                    <input type='hidden' name='cmd' value='_xclick'>

                    <input type='hidden' name='item_name' value='<?php echo $s;?>'>
                    <input type='hidden' name='item_number' value='<?php echo $s;?>'>
                       
 <input type='hidden' name='amount' value='<?php   echo $amount;?>'>
                    <input type='hidden' name='no_shipping' value='1'>
                    <input type='hidden' name='currency_code' value='USD'>
                    <input type='hidden' name='handling' value='0'>
                    <input type='hidden' name='cancel_return' value='<?php echo base_url();?>callmycab/cancel_paypal?id=<?php echo $id;?>'>
                    <input type='hidden' name='return' value='<?php echo base_url();?>callmycab/result_paypal'>

    <input type="hidden" name="notify_url" value="<?php echo base_url();?>callmycab/result_paypal">
<input type='hidden' name='rm' value='2'>
                    <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form> 
            </div>
        </div>
	
<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/parsley.min.js"></script>
<script>
$(document).ready(function () {
		 $(".brain").hide();
	$('input[type=radio][name=types]').change(function() {
        if (this.value == 'Braintree') {
			$(".brain").show();
           
			
        }
        else  {
            $(".brain").hide();
        }
    });
$("#point").hide()
 jQuery('#authorized   ').on('click', function(e)  {
	 if ( ! $("input[name=types]").is(':checked') ){
		 alert("Please Select a Payment Type");
		 return false;
		 
	 }else{
	 var type= $('input[name=types]:checked').val();
	 if(type =='Credit'){
		 if ($('#Credit-card').parsley().validate() ) {
			 $(".loader").show();
		 var form =$('#Credit-card').serializeArray();
			
			$.ajax({
					url:'<?php echo base_url();?>home/index',
					type:'post',
					data:form,
					
					success:function(book){
						
						console.log(book);
						$(".loader").hide();
						 var items = JSON.parse(book);
						 var s = items[0].message;
						 
						 $('.results').text(s);
					}
				});
		 }
	 }else if(type =='Paypal'){
			

	
 var id = "<?php echo $this->session->userdata('bookid'); ?>";

	var amount1 = "<?php  if($this->session->userdata('amount')){echo $amount1=$this->session->userdata('amount');}else{echo "0";} ?>";


if( !amount1 || amount1=="0"){
window.location.replace("<?php echo base_url();?>callmycab/cancel_paypal?id="+id);

}else{
	
$('.paypals').submit();
}
		 
	 }else if(type =='Braintree'){
		
	    if ($('#Credit-card').parsley().validate() ) {
			 $(".loader").show();
		 var form =$('#Credit-card').serializeArray();
			
			$.ajax({
					url:'<?php echo base_url();?>home/braintree',
					type:'post',
					data:form,
					
					success:function(book){
						
						console.log(book);
						$(".loader").hide();
						 var items = JSON.parse(book);
						 var s = items[0].message;
						 
						 $('.results').text(s);
					}
				});
		 }
	 }
	 else {
		$(".loader").show();
		 
		 $.ajax({
					url:'<?php echo base_url();?>home/confirm_booking',
					type:'post',
					
					
					success:function(book){
						
						console.log(book);
						$(".loader").hide();
						addpaypal();
						$("#hide_payment").hide();
						$(".payment").html(book);
					}
				});
	 }
	 }
	 
			
			});
			
			
			
		function confirms(){
				
				$.ajax({
					url:'<?php echo base_url();?>home/confirm_booking',
					type:'post',
					
					
					success:function(book){
						
						console.log(book);
						select_driver();
						$("#hide_payment").hide();
						$(".payment").html(book);
						
					}
				});
			}
			
			function addpaypal(){
		
	
	var a = "";
	var b = "";
	var c =  '<?php echo $s;?>';
	
	
	
	$.ajax({
url:'<?php echo base_url();?>callmycab/addpaypal',
type:'post',
data:{'a':a,'b':b,'c':c},
success:function(book){
console.log(book);
if(book==1){
	select_driver();
//alert('Payment Successful');
//$('.resultid').html('Payment Successful');
}else {
//alert('Payment Error');
//$('.resultid').html('Payment Error');
}

}
});
	}
		function select_driver(){	
			
			var driver_on ="<?php echo $row->mechanic_assigned; ?>";
	if(driver_on =='on'){
		var c = "<?php echo $s;?>";
	
	$.ajax({
url:'<?php echo base_url();?>admin/select_driver',
type:'post',
data:{'c':c},
success:function(book){
console.log(book);
if(book==1){
//alert('Payment Successful');
//$('.resultid').html('Payment Successful');
}else {
//alert('Payment Error');
//$('.resultid').html('Payment Error');
}

}
});
	}
		}		
			
			
			
			
			
			
			
			

});

</script>




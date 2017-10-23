<?php

$query1 = $this->db->query(" SELECT * FROM `settings` order by id DESC ");
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
	


		
		
		if(isset($amount1)){
		$amount = urlencode($amount1);
$from_Currency = urlencode($from);
$to_Currency = urlencode($to);
$get = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency");
$get = explode("<span class=bld>",$get);
$get = explode("</span>",$get[1]);  
$converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);
		 $ddd = number_format($converted_amount);
		}
?>

<div class="payment">
		<div class="payment-wrapper">
			<div class="payment-outter">
				<div class="payment-inner">
					<div class="row">
						<div class="paycard">
							<div class="col-md-6"><input type="radio" name="types" value="Credit"><label>Authorize.Net<img src="<?php echo base_url();?>assets/images/visacard.png"></label></div>
							<div class="col-md-6"><input type="radio" name="types" value="Paypal" ><label>Paypal<img src="<?php echo base_url();?>assets/images/paypal.png"></label></div>
							</div>
							<div class="paycard">
							<div class="col-md-6"><input type="radio" name="types" value="By Hand " ><label>By hand</label></div>
							<div class="col-md-6"><input type="radio" name="types" value="PayUMoney" ><label>PayUMoney</label></div>
						</div>
					</div><br>
					
					<form id="Credit-card">
					<div class="paycard-details">
							Card Number<br><br>
							<input class="card-input" type="text" name="x_card_num">
					</div><br>
					<div class="paycard-details">
							
							<div class="col-md-3 padding0">
								Expiration Date<br>
								<div class="card-data" style="padding-left: 0px;padding-right:0px;">
								<input type="text" class="card-input1" placeholder="Month/Year" name="x_exp_date">
							</div>
							</div>
							
							<div class="col-md-3 padding0">
								CVV2/CVC2
								<div class="card-data">

								<input type="text"  class="card-input1" name="x_card_code">
								<input type="hidden"  class="card-input1" name="x_amount" value="<?php echo $this->session->userdata('amount');?>">
								<input type="hidden"  class="card-input1" name="x_country" value="<?php echo $from;?>">
							</div>
							</div>
							<div class="col-md-3 padding0">
								<div class="card-data font10">
									<p>The last 3 digits displayed<br>
									onthe back of your card</p>
								</div>
							</div>
					</div>
					</form>
					<br>
					<div class="paycard-details">
						<input class="paybtn" value="Submit"type="button" id ="authorized">
					</div>
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
                       
 <input type='hidden' name='amount' value='<?php   echo $ddd;?>'>
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
<script>
$(document).ready(function () {
	
$("#point").hide()
 jQuery('#authorized   ').on('click', function(e)  {
	 var type= $('input[name=types]:checked').val();
	 if(type =='Credit'){
		 
		 var form =$('#Credit-card').serializeArray();
			
			$.ajax({
					url:'<?php echo base_url();?>home/index',
					type:'post',
					data:form,
					
					success:function(book){
						
						console.log(book);
						 var s = book.message;
						 $('.results').text(s);
					}
				});
	 }else if(type =='Paypal'){
			
alert('paypal');
	
 var id = "<?php echo $this->session->userdata('bookid'); ?>";

	var amount1 = "<?php  if($this->session->userdata('amount')){echo $amount1=$this->session->userdata('amount');}else{echo "0";} ?>";


if( !amount1 || amount1=="0"){
window.location.replace("<?php echo base_url();?>callmycab/cancel_paypal?id="+id);

}else{
	
$('.paypals').submit();
}
		 
	 }else if(type =='PayUMoney'){
		 alert('PayUMoney');
	 $('.payuForm').submit();
	 }
	 else{
		 alert("dfdf");
	 }
	 
			
			});
});

</script>
<?php
// Merchant key here as provided by Payu
$MERCHANT_KEY = "ggprvR";

// Merchant Salt as provided by Payu
$SALT = "TzW5Rh6k";

// End point - change to https://secure.payu.in for LIVE mode
$PAYU_BASE_URL = " https://secure.payu.in";

$action = '';

$posted = array();
if(!empty($_POST)) {
    //print_r($_POST);
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value; 
	
  }
}

$formError = 0;

if(empty($s)) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $s;
}
$hash = "sha512, shibilabs23@gmail|7559848609|http://www.testdomain.com/testcallback|INR|SHA256|5196060|ggprvR|TzW5Rh6k|CREDIT|100|SALE|REDIRECT|asdflkafuq347riuvgyrgfbwqbvq";
// Hash Sequence
$action = $PAYU_BASE_URL . '/_payment';
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
		  || empty($posted['service_provider'])
  ) {
    $formError = 1;
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
	$hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';	
	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;


    $hash = "'sha512', 'shibilabs23@gmail','7559848609','http://www.testdomain.com/testcallback'INR','SHA256','5196060','ggprvR','TzW5Rh6k','CREDIT','100','SALE','REDIRECT','asdflkafuq347riuvgyrgfbwqbvq'";
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}

    $hashs = "'sha512', 'shibilabs23@gmail','7559848609','http://www.testdomain.com/testcallback'INR','SHA256','5196060','ggprvR','TzW5Rh6k','CREDIT','100','SALE','REDIRECT','asdflkafuq347riuvgyrgfbwqbvq'";
?>

  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
  
    <?php if($formError) { ?>
	
     
    <?php } ?>
   <form action="<?php echo $action; ?>" method="post" name="payuForm" class="payuForm">
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden"id="hash" name="hash" value="<?php echo  $hashs; ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <table>
        <tr>
          <td><b>Mandatory Parameters</b></td>
        </tr>
        <tr>
          <td>Amount: </td>
          <td><input name="amount"  value="<?php echo "85";?>"  /></td>
          <td>First Name: </td>
          <td><input name="firstname" id="firstname" value="<?php echo "fg"; ?>" /></td>
        </tr>
        <tr>
          <td>Email: </td>
          <td><input name="email" id="email" value="<?php echo "shibilabs23@gmail.com"; ?>" /></td>
          <td>Phone: </td>
          <td><input name="phone" value="<?php echo "7559848609"; ?>" /></td>
        </tr>
        <tr>
          <td>Product Info: </td>
          <td colspan="3"><textarea name="productinfo"><?php echo "sds";?></textarea></td>
        </tr>
        <tr>
          <td>Success URI: </td>
          <td colspan="3"><input name="surl" value="<?php echo base_url();?>callmycab/result_paypal" size="64" /></td>
        </tr>
        <tr>
          <td>Failure URI: </td>
          <td colspan="3"><input name="furl" value="<?php echo base_url();?>callmycab/cancel_paypal?id=<?php echo $id;?>" size="64" /></td>
        </tr>

        <tr>
          <td colspan="3"><input type="hidden" name="service_provider" value="payu_paisa" size="64" /></td>
        </tr>

        <tr>
          <td><b>Optional Parameters</b></td>
        </tr>
        <tr>
          <td>Last Name: </td>
          <td><input name="lastname" id="lastname" value="<?php echo "dfdf"; ?>" /></td>
          <td>Cancel URI: </td>
          <td><input name="curl" value="<?php echo base_url();?>callmycab/cancel_paypal?id=<?php echo $id;?>" /></td>
        </tr>
        <tr>
          <td>Address1: </td>
          <td><input name="address1" value="<?php echo "sss"; ?>" /></td>
          <td>Address2: </td>
          <td><input name="address2" value="<?php echo "dd"; ?>" /></td>
        </tr>
        <tr>
          <td>City: </td>
          <td><input name="city" value="<?php echo "sdsd"; ?>" /></td>
          <td>State: </td>
          <td><input name="state" value="<?php echo "Kerala"; ?>" /></td>
        </tr>
        <tr>
          <td>Country: </td>
          <td><input name="country" value="<?php echo $s1[0];?>" /></td>
          <td>Zipcode: </td>
          <td><input name="zipcode" value="<?php echo"695606"; ?>" /></td>
        </tr>
        <tr>
          <td>UDF1: </td>
          <td><input name="udf1" value="<?php echo "cc"; ?>" /></td>
          <td>UDF2: </td>
          <td><input name="udf2" value="<?php echo "cc"; ?>" /></td>
        </tr>
        <tr>
          <td>UDF3: </td>
          <td><input name="udf3" value="<?php echo "dcx"; ?>" /></td>
          <td>UDF4: </td>
          <td><input name="udf4" value="<?php echo "xcxc"; ?>" /></td>
        </tr>
        <tr>
          <td>UDF5: </td>
          <td><input name="udf5" value="<?php echo "xcxc"; ?>" /></td>
          <td>PG: </td>
          <td><input name="pg" value="<?php echo "xcxc"; ?>" /></td>
        </tr>
        <tr>
          <?php if(!$hash) { ?>
            <td colspan="4"><input type="submit" value="Submit" id="max-value" /></td>
          <?php } ?>
        </tr>
      </table>
    </form>


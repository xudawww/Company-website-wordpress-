<?php
$query1 = $this->db->query(" SELECT * FROM `settings` order by id DESC ");
$row = $query1->row('settings');
$mesr = $row->measurements;
$str = $row->currency;
$s1 = explode(',',$str);
$paypal_url=$row->paypal; 
$paypal_id=$row->paypalid; 
$from =$s1[0];
$to ="USD";
 $uneaque_id = 'CMC'.strtotime(date('m/d/Y H:i:s'));
	$ddd="" ;
	 $id="0";
	 if($this->session->userdata('walletamounts')){
		
		$amount = urlencode($this->session->userdata('walletamounts'));
/*$from_Currency = urlencode($from);
$to_Currency = urlencode($to);
$get = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency");
$get = explode("<span class=bld>",$get);
$get = explode("</span>",$get[1]);  
$converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);*/
		 $ddd = number_format($amount);
		
		
}
?>           









<div class="loader"></div>
<form action='<?php echo $paypal_url; ?>' method='post' name='frmPayPal1' class="paypals" style="display:none">
                    <input type='hidden' name='business' value='<?php echo $paypal_id;?>'>
                    <input type='hidden' name='cmd' value='_xclick'>

                    <input type='hidden' name='item_name' value='<?php echo $uneaque_id;?>'>
                    <input type='hidden' name='item_number' value='<?php echo $uneaque_id;?>'>
                       
 <input type='hidden' name='amount' id="amount_dd" value='<?php   echo $ddd;?>'>
                    <input type='hidden' name='no_shipping' value='1'>
                    <input type='hidden' name='currency_code' value='USD'>
                    <input type='hidden' name='handling' value='0'>
                    <input type='hidden' name='cancel_return' value='<?php echo base_url();?>wallet/cancel_wallet?id=<?php echo $id;?>'>
                    <input type='hidden' name='return' value='<?php echo base_url();?>wallet/result_wallet'>

    <input type="hidden" name="notify_url" value="<?php echo base_url();?>wallet/result_wallet">
<input type='hidden' name='rm' value='2'>
                    <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form> 
				<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
				<script>
$(document).ready(function(){
	var s =$("#amount_dd").val();
	
	if(s!=0){
		
		 $('.paypals').submit();
	}else{
		alert("failed");
	}
	
 });
</script>				
		
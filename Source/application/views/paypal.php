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

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Products | Store</title>
        <style type="text/css">
            body{
                width: 900px;
                margin: 0 auto;
                margin-top: 50px;
                font:bold 14px arial;
            }
            .product{
                float: left;
                margin-right: 10px;
                border: 1px solid #cecece;
                padding: 10px;
                margin-right: 20px;
            }
            .price{
                text-align: right;
            }
            .btn{
                text-align: center;
}








        </style>
    </head>
    <body >
       
		
		
		
		
		
		
		<div class="loader"></div>
		
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
	
          
    </body>
</html>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>           
<script>


$(document).ready(function() {
 $(".loader").show();	

var id = "<?php echo $this->session->userdata('bookid'); ?>";

	var amount1 = "<?php  if($this->session->userdata('amount')){echo $amount1=$this->session->userdata('amount');}else{echo "0";} ?>";


if( !amount1 || amount1=="0"){
window.location.replace("<?php echo base_url();?>callmycab/cancel_paypal?id="+id);

}else{
	
$('.paypals').submit();
}
});
</script>
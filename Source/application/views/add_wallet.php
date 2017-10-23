<html>
    <head>
	  <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
       <link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script><?php
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
	 
?>           
<script>
$(document).ready(function(){
	 $(".loader").hide();
 });


function myaddwallet(){
	alert("fg");
		var id = $("#amountsss").val();
       $(".loader").show();	
		
		
		
		$.ajax({
			 url:'<?php echo base_url();?>wallet/set_session',
			type:'post',
           
            
            data:{"id":id},
			
            success:function(res){
				
       
			$("#iddd").html(res)
         

        }
		 });
	
			
 
	}



</script>
	</head>
    <body >
       
<input type="text" name="amounts" id="amountsss">
<input type="button"  value="Add Money"  onclick="myaddwallet();">


			
<div id="iddd"></div>

				</body>
				</html>
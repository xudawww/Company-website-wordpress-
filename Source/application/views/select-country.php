<form method='post' id='taxi_reg1' style="display:block;">
    	<table class="dup-step1-inputs">
					
    	    <tr><td>Site Title</td><td><input type="text" name="title" id="title" class="regcom"  placeholder="Site Title" /></td></tr>
			<tr><td>Country</td><td><select  name="country"  id="country">
										   <?php
										   
										 $query1 = $this->db->query("SELECT * FROM  countries  ");
						
						
                                                    foreach($query1->result_array('countries') as $row1){
                                                            ?>
										  
                                               <option value="<?php echo $row1['iso_alpha2'];?>" ><?php echo $row1['name'];?></option>
                                              <?php
													}?>
                                                  </select></td></tr>
			<tr><td>Currency</td><td><select   name="currency"  id="currency">
										   <?php
										   	$query2 = $this->db->query("SELECT DISTINCT`currrency_symbol`,`currency_name`,currency_code FROM `countries` where `currrency_symbol` IS NOT NULL  ");
                                                    foreach($query2->result_array('countries') as $row1){
														
														$array["a"] = $row1['currency_code'];
                                                        $array["b"] = $row1['currrency_symbol'];
														 $str = implode(',',$array);
                                                          // $s = explode(',',$str);
														//  echo$s[1]; 
														
                                                            ?>
										  
                                               <option value="<?php echo $str;?>" ><?php echo $row1['currency_code'];?>(<?php echo $row1['currrency_symbol'];?>)</option>
                                              <?php
													}?>
                                                  </select></td></tr>
    	   <tr><td>Smtp Username</td><td><input type="text" name="smtp_username" id="smtp_username"  class="regcom" placeholder="Smtp Username" /></td></tr>
			<tr><td>Smtp Host</td><td><input type="text" name="smtp_host" id="smtp_host" class="regcom"  placeholder="Smtp Host" /></td></tr>
			<tr><td>Smtp Password</td><td><input type="password" name="smtp_password" id="smtp_password" class="regcom"  placeholder="Smtp Password" /></td></tr>
			
		   </table>
		<div id="dup-step1-dbconn">
		<?php
		$query = $this->db->query(" SELECT * FROM `settings` order by id DESC ");
		$row = $query->row('settings');
		
		?>
		
		<input type='hidden' name='id' value="<?php echo $row->id; ?>">
		<input type="button" name="add_floor1" id='selectadd'  value="Save Changes "  class="button button-primary"/>
</div>
		</form>
		<script type="text/javascript">
$(document).ready(function(){
	 $('.regcom').on('change', function (){
		   var a = $(this).val();
		   if(a != '') {
			   $(this).removeClass('error-admin');
		   } else {
				$(this).addClass('error-admin');
		   }
			  
	   });	

 
	
		$("#selectadd").click(function(){
	
            var stitle = $('#title').val();	
     suser = $('#smtp_username').val();
     shost = $('#smtp_host').val();
     spass = $('#smtp_password').val();	
     	 if(!stitle){
			
			    $( "#title" ).addClass('error-admin');
				$("#title").focus();
				return false;
		   } 
		   if(!suser){
			
			    $( "#smtp_username" ).addClass('error-admin');
				$("#smtp_username").focus();
				return false;
		   } 
		   if(!shost){
			
			    $( "#smtp_host" ).addClass('error-admin');
				$("#smtp_host").focus();
				return false;
		   } 
		   if(!spass){
			
			    $( "#smtp_password" ).addClass('error-admin');
				$("#smtp_password").focus();
				return false;
		   } 
	 var value =$("#taxi_reg1").serialize() ;

$.ajax({
url:'<?php echo base_url();?>installer/upload1',
type:'post',
data:value,
success:function(res){
	if(res=='0'){
		//$(".test2").html('<p class="success">site url: <a href="<?php echo base_url();?>" target="_blank"><?php echo base_url();?></a><br><br>admin url : <a href="<?php echo base_url();?>/admin" target="_blank"><?php echo base_url();?>/admin</a><br><br>Username: admin,Password:admin</p>');
		 window.location.href ='callmycab/first_show';
	}else{
		$(".test2").html('<p class="success">Error</p>');
	}
}
});
	
	});
});
		</script>
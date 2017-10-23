<input type="text" class="field4 basicExample times common" id="pickuptime " name="pickuptime " placeholder="">
<?php  $date= $_POST['date'];
 date_default_timezone_set("Asia/Kolkata"); 
 $current_date = date('h:ia',strtotime('30 minute'));
 $current_time = strtotime($current_date);
 
 $frac = 900;
 $r = $current_time % $frac;
 
 $new_time = $current_time + ($frac-$r);
 $mintime = date('h:ia', $new_time);
 
 ?>

 
 
<?php if($date==date('m/d/Y')){ //$mintime= date('h:ia');?>

<script>
 $('.basicExample').timepicker({
							   'minTime': '<?php echo $mintime;?>',
							   'forceRoundTime': true,
    'maxTime': '00:00am'
							   });
</script>
<?php }else { ?>
	<script>
 $('.basicExample').timepicker();
</script>
<?php } ?>
<input type="text" class="field4 basicExample comman2" id="time2" name="email1" placeholder="">
<?php  $date= $_POST['date'];
 date_default_timezone_set("Asia/Kolkata"); 
 $current_date = date('h:ia',strtotime('30 minute'));
 $current_time = strtotime($current_date);
 
 $frac = 900;
 $r = $current_time % $frac;
 
 $new_time = $current_time + ($frac-$r);
 $mintime = date('h:ia', $new_time);
 
 ?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-timepicker.css"/>
<!-- Load jQuery JS -->
<script src="<?php echo base_url();?>assets/js/jquery-timepicker.js"></script>
<!-- Load jQuery UI Main JS -->
<script src="<?php echo base_url();?>assets/js/jquery-timepicker-min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
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
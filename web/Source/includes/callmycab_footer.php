  <?php
 $query1 = $this->db->query("SELECT * FROM  blogs WHERE id!='5' ORDER BY id ASC");
 foreach($query1->result_array('blogs') as $row1){
	
	$s = $row1['blog_content'];
		$ss =base_url();
		$searches = array('#s#');
        $replacements = array($ss);
		$e =str_replace($searches, $replacements, $s);
		
		echo $e;
 }
 ?>
  <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
            <script src="<?php echo base_url();?>assets/js/parsley.min.js"></script>
 
 
 
 
 
  
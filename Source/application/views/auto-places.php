  <?php
								$term=$_GET["term"];
						  
		 $query = $this->db->query("SELECT * FROM places WHERE  location like '$term%' order by location ");
		 foreach($query->result_array() as $row){
			   $json[]=array(
                    'value'=> $row["location"],
                    'label'=>$row["location"]
                        );
		 }
		 echo json_encode($json);
	?>
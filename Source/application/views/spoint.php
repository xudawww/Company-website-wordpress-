<table id="dataTables-example" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="dataTables-example_info">
                                <?php
								
								
								$status=$_POST['a'];
                                 $purpose=	$_POST['b'];							
								if($status=='Processing'){
								 $query1 = $this->db->query("SELECT * FROM  bookingdetails WHERE purpose='$purpose'  and (status='Processing' or status='Complete') ORDER BY id DESC");
								}else{
									 $query1 = $this->db->query("SELECT * FROM  bookingdetails WHERE purpose='$purpose'  and status='$status' ORDER BY id DESC");
								
								}
								?>
                                
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>From</th>
                                            <th>To</th>
                                             <th>Date</th>
                                             <th>Status</th>
                                            <th>Action</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php
		
       foreach($query1->result_array('userdetails') as $row1){
        ?>
                                    
                                        <tr class="odd gradeX" >
                                            <td class="center"> <?php echo $row1['uneaque_id'];?></td>
                                            <td class="center"> <?php echo $row1['pickup_area'];?></td>
                                            <td class="center"> <?php echo $row1['drop_area'];?></td>
                                            <td class="center"> <?php echo $row1['pickup_date'];?></td>
                                            <td class="center"> <?php echo $row1['status'];?></td>
                                            <td class="center"><a href="<?php echo base_url();?>admin/edit_point?id3=<?php echo $row1['id'];?>"><?php if(!empty($row1['assigned_for'])) {echo "Assigned";} else{echo " Not Assigned";}?> </a>&nbsp;&nbsp;<a href="#" title="<?php echo $row1['id'];?>" class="delete">Delete</a>
											<?php
											if($status=='Processing'){
												?>
												<a href="#" class='status2'title="<?php echo $row1['id'];?>">click</a>
												<?php
								 }
											?></td>
                                        </tr>
                                       <?php
	   }
									?> 
                                    </tbody>
                                   
                                </table>
								
								
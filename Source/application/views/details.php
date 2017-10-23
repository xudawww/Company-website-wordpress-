<div class="details-area">
      <table>
		<thead>
        <?php
		 $id = $_POST['detailsid'];
		   $username = $this->session->userdata('username');
		    $query1 = $this->db->query("SELECT * FROM  bookingdetails WHERE username='$username' AND id ='$id'");
		 $row1 = $query1->row('bookingdetails');
		 
		?>
		<tr>
			<td> Booking ID:</td><td><?php echo $row1->uneaque_id;?></td>
         </tr>
         <tr>   
			<td> From :</td><td><?php echo $row1->pickup_area ;?></td>
          </tr>
          <tr>
			<td> To :</td><td><?php echo $row1->drop_area ;?></td>
           </tr>
           <tr>
           
			<td> Date: </td><td> <?php echo $row1->pickup_date;?></td>
            </tr>
            <tr>
            <td> Distance: </td><td></td>
            </tr>
            <tr>
            <td>Price:</td><td></td>
            </tr>
            <tr>
			<td> Satus :</td><td><?php echo $row1->status; ?></td>
		  </tr>
         
         
          		</thead>
		<tbody>
        </tbody>
	</table>
    
                    
     </div>               
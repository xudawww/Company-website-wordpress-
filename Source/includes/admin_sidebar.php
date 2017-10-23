      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo base_url();?>assets/adminlte/dist/img/default-160x160.gif" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>Admin</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
         <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>-->

          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->



          <ul class="sidebar-menu">
          <?php

           $user2 = $this->session->userdata('permission');


		   $id = $user2;

		   $page_name = array();


		   $rows = $this->db->query(" SELECT * FROM `role_permission` WHERE page_id='$id' ")->row();

			$page_name = explode(',', $user2);




		    if( in_array('9',$page_name) || in_array('1',$page_name))
            {
              ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>User Management </span><i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			  <?php
            if((in_array('9',$page_name)) )
            {?>
                <li><a href="<?php echo base_url();?>admin/userlist"><i class="fa fa-circle-o"></i>View All</a></li>
				<?php
			}if((in_array('1',$page_name)) ){
			?>
                <li><a href="<?php echo base_url();?>admin/adduser"><i class="fa fa-circle-o"></i>Add New</a></li>
				<?php
			}?>
              </ul>
            </li>
<?php
}

if( in_array('15',$page_name) || in_array('57',$page_name)|| in_array('10',$page_name) || in_array('58',$page_name) || in_array('13',$page_name) || in_array('59',$page_name)|| in_array('14',$page_name)|| in_array('60',$page_name))
            {
              ?>



			   <!--<li class="treeview active">
                          <a href="#">
                      <ul class="treeview-menu menu-open" style="">-->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>View Booking Details</span>


                <span class="label label-primary pull-right"></span>
              </a>
			  <?php
			  if( in_array('15',$page_name) || in_array('57',$page_name)){
				  ?>
              <ul class="treeview-menu">
                <li class="treeview"><a href="#"><i class="fa fa-circle-o"></i>Point To Point Transfer</a>
					<ul class="treeview-menu">
					<?php
					if( in_array('15',$page_name)){

					?>
						<li><a href="<?php echo base_url();?>admin/pointview"><i class="fa fa-circle-o"></i>Assign Driver</a></li>
					<?php
					}if( in_array('57',$page_name)){
					?>
					   <li><a  href="<?php echo base_url();?>admin/pointdriver"><i class="fa fa-circle-o"></i> Assigned Driver</a></li>
					   <?php
					}
					?>
				    </ul>

				</li>
			  </ul>
				<?php
			  }
			  if( in_array('10',$page_name) || in_array('58',$page_name)){
				  ?>
			  <ul class="treeview-menu">
			    <li class="treeview"><a href="#"><i class="fa fa-circle-o"></i>Airport Transfer</a>
				   <ul class="treeview-menu">
				   <?php
					if( in_array('10',$page_name)){

					?>
						<li><a href="<?php echo base_url();?>admin/airportview"><i class="fa fa-circle-o"></i>Assign Driver</a></li>
					<?php
					}
					if( in_array('58',$page_name)){

					?>
					   <li><a  href="<?php echo base_url();?>admin/airportdriver"><i class="fa fa-circle-o"></i>Assigned Driver</a></li>
					   <?php
					}
					?>
				    </ul>
				</li>
			  </ul>
			  <?php
			  }if( in_array('13',$page_name) || in_array('59',$page_name)){
			  ?>
			  <ul class="treeview-menu">
                <li class="treeview"><a href="#"><i class="fa fa-circle-o"></i>Hourly Transfer</a>
				    <ul class="treeview-menu">

					<?php
					if( in_array('13',$page_name)){

					?>
						<li><a href="<?php echo base_url();?>admin/hourlyview"><i class="fa fa-circle-o"></i>Assign Driver</a></li>
					<?php
					}
					if( in_array('59',$page_name)){

					?>
					   <li><a  href="<?php echo base_url();?>admin/hourlydriver"><i class="fa fa-circle-o"></i> Assigned Driver</a></li>
					   <?php
					}
					?>
				    </ul>
				</li>
			 </ul>
				<?php
			  }if( in_array('14',$page_name) || in_array('60',$page_name)){
			  ?>
			  <ul class="treeview-menu">
                <li class="treeview"><a href="#"><i class="fa fa-circle-o"></i>Outstation Transfer</a>
				   <ul class="treeview-menu">
	                   <?php
					if( in_array('14',$page_name)){

					?>
						<li><a href="<?php echo base_url();?>admin/outstationview"><i class="fa fa-circle-o"></i>Assign Driver</a></li>
					<?php
					}
					if( in_array('60',$page_name)){

					?>
					   <li><a  href="<?php echo base_url();?>admin/outdriver"><i class="fa fa-circle-o"></i> Assigned Driver</a></li>
					   <?php
					}
					?>
				    </ul>
				</li>
              </ul>
			  <?php
			  }
			  ?>

            </li>
<?php
			}
			 if( in_array('36',$page_name) || in_array('37',$page_name)|| in_array('38',$page_name) || in_array('39',$page_name))
            {
              ?>


			 <li class="treeview">
              <a href="#">
                <i class="fa fa-tty"></i>
<span>Add Booking Details</span>
                <span class="label label-primary pull-right"></span>
              </a>
			  <ul class="treeview-menu">
			  <?php
					if( in_array('36',$page_name)){

					?>
                <li><a href="<?php echo base_url();?>admin/addpoint"><i class="fa fa-circle-o"></i>Point To Point Transfer</a></li>
					<?php
					}
					if( in_array('37',$page_name)){

					?>
			    <li><a href="<?php echo base_url();?>admin/addair"><i class="fa fa-circle-o"></i>Airport Transfer</a></li>
				<?php
					}
					if( in_array('38',$page_name)){

					?>
                <li><a href="<?php echo base_url();?>admin/addhourly"><i class="fa fa-circle-o"></i>Hourly Transfer</a></li>
				<?php
					}
					if( in_array('39',$page_name)){

					?>
                <li><a href="<?php echo base_url();?>admin/addout"><i class="fa fa-circle-o"></i>Outstation Transfer</a>
				</li>
				<?php
					}
					?>
             </ul>

            </li>

			<?php
			}

			if( in_array('32',$page_name) || in_array('2',$page_name))
            {
              ?>


			 <li class="treeview">
              <a href="#">
                <i class="fa fa-th"></i> <span>Promocode Management</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			  <?php

					if( in_array('32',$page_name)){

					?>
                <li><a href="<?php echo base_url();?>admin/view_promocode"><i class="fa fa-circle-o"></i>View All</a></li>
				<?php
					}
					if( in_array('2',$page_name)){

					?>
                <li><a href="<?php echo base_url();?>admin/promocode"><i class="fa fa-circle-o"></i>Add New</a></li>
				<?php
					}
					?>
              </ul>
            </li>
			<?php
			} 
			?>
            <!--  my code -->
	       <li class="treeview">
              <a href="#">
                <i class="fa fa-car"></i> <span>Car</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			 
                <li><a href="<?php echo base_url();?>admin/car"><i class="fa fa-circle-o"></i>Add Car</a></li>
				 <li><a href="<?php echo base_url();?>admin/view_car"><i class="fa fa-circle-o"></i>View All</a></li>
              </ul>
            </li>
  
             <li class="treeview">
              <a href="#">
                <i class="fa fa-suitcase"></i> <span>Outstation Package</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url();?>admin/add_round_package"><i class="fa fa-circle-o"></i>Add Package</a></li>
				<li><a href="<?php echo base_url();?>admin/view_round_package"><i class="fa fa-circle-o"></i>View All</a></li>
              </ul>
            </li>
         
			<?php
			if( in_array('28',$page_name) || in_array('27',$page_name)|| in_array('29',$page_name) || in_array('30',$page_name))
            {
              ?>

			 <li class="treeview">
              <a href="#">
                <i class="fa fa-taxi"></i> <span>Taxi Details</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			  <?php

					if( in_array('28',$page_name)){

					?>
                <li><a href="<?php echo base_url();?>admin/taxi_view"><i class="fa fa-circle-o"></i>Point To Point Transfer</a></li>
				<?php
					}
					if( in_array('27',$page_name)){

					?>
                <li><a href="<?php echo base_url();?>admin/taxi_airport"><i class="fa fa-circle-o"></i>Airport Transfer</a></li>
				<?php
					}
					if( in_array('29',$page_name)){

					?>
				<li><a href="<?php echo base_url();?>admin/taxi_hourly"><i class="fa fa-circle-o"></i>Hourly Transfer</a></li>
				<?php
					}
					if( in_array('30',$page_name)){

					?>
                <li><a href="<?php echo base_url();?>admin/taxi_outstation"><i class="fa fa-circle-o"></i>Outstation Transfer</a></li>
				<?php
					}
					?>
              </ul>
            </li>
			<?php
			}if( in_array('31',$page_name) || in_array('3',$page_name))
            {
              ?>


			 <li class="treeview">
              <a href="#">
                <i class="fa fa-empire"></i> <span>Driver Management</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			  <?php

					if( in_array('30',$page_name)){

					?>
                <li><a href="<?php echo base_url();?>admin/view_driver"><i class="fa fa-circle-o"></i>View All</a></li>
				<?php
					}
					if( in_array('30',$page_name)){

					?>
                <li><a href="<?php echo base_url();?>admin/add_driver"><i class="fa fa-circle-o"></i>Add New</a></li>
				<?php
					}
					?>
              </ul>
            </li>
			<?php
			}

					if( in_array('40',$page_name)){

					?>
			<li>
              <a href="<?php echo base_url();?>admin/view_airmanage">
                <i class="fa fa-plane"></i> <span>Airport Management</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
			</li>
			<?php
					}if( in_array('43',$page_name)){
					?>
			<li>
              <a href="<?php echo base_url();?>admin/view_package">
               <i class="fa fa-road"></i>
      <span>Package Management</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
			</li>
<?php
					}
if( in_array('4',$page_name)){
					?>
             <li>
             <a href="<?php echo base_url();?>admin/add_settings"><i class="fa fa-wrench"></i>&nbsp;&nbsp;Settings <span class="fa arrow"></span></a></li>
              <li>
			  <?php
}
if( in_array('26',$page_name)){
					?>
			<li>
			  <a href="<?php echo base_url();?>admin/role_management"><i class="fa fa-user"></i>&nbsp;&nbsp;Role Management <span class="fa fa-angle-left pull-right"></span></a></li>
              </a>
			</li>
			<?php
}if( in_array('33',$page_name)){
					?>

		     <li>
			   <a href="<?php echo base_url();?>admin/backened_user">
                <i class="fa fa-toggle-on	"></i> <span>Backend User</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
			</li>
			<?php
}if( in_array('46',$page_name) ||in_array('47',$page_name)){
?>
			<li class="treeview">
			   <a href="<?php echo base_url();?>admin/view_places">
                <i class="fa fa-map-marker"></i> <span>Places</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
			  <ul class="treeview-menu">
			  <?php
if( in_array('46',$page_name)){
					?>
			    <li><a href="<?php echo base_url();?>admin/view_places"><i class="fa fa-circle-o"></i>View All</a></li>
				<?php
}
if( in_array('47',$page_name)){
					?>
                <li><a href="<?php echo base_url();?>admin/places_add"><i class="fa fa-circle-o"></i>Add New</a></li>
<?php
}
?>
			  </ul>

			</li>
			<?php
}
if( in_array('49',$page_name)){
					?>



			 <!-- <li>
			 <a href="<?php //echo base_url();?>admin/view_language"><i class="fa fa-language"></i>
&nbsp;&nbsp;Language <span class="fa fa-angle-left pull-right"></span></a></li> -->

     <li class="treeview">
        <a href="#">
          <i class="fa fa-language"></i> <span>Language Translation</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo base_url();?>admin/view_language"><i class="fa fa-circle-o"></i> Language For Web</a></li>
          <li><a href="<?php echo base_url();?>admin/languageChageForUserApp"><i class="fa fa-circle-o"></i>Language For User App</a></li>
          <li><a href="<?php echo base_url();?>admin/languageChageForDriverApp"><i class="fa fa-circle-o"></i>Language For Driver App</a></li>
        </ul>
      </li>
	  <?php
 
}
//if( in_array('52',$page_name)){
?>
	 		<!--   <li>
			 <a href="<?php echo base_url();?>admin/view_page"><i class="fa fa-wrench"></i>


&nbsp;&nbsp;Front end<span class="fa fa-angle-left pull-right"></span></a></li>


         <li class="treeview">
			   <a href="<?php echo base_url();?>admin/view_pages">
                <i class="fa fa-adjust"></i>
 <span>Pages</span> <i class="fa fa-angle-left pull-right"></i>
              </a>


			</li>-->
	        <?php
//}
if( in_array('61',$page_name)){
?>

 <li>
			  <a href="<?php echo base_url();?>admin/wallet_list"><i class="fa fa-money"></i>


&nbsp;&nbsp;Wallet<span class="fa fa-angle-left pull-right"></span></a></li>
              </a>
			</li>
<?php
}

if( in_array('62',$page_name)){
?>

 <li>
			  <a href="<?php echo base_url();?>admin/callback_list"><i class="fa fa-google-wallet"></i>

&nbsp;&nbsp;Callback<span class="fa fa-angle-left pull-right"></span></a></li>
              </a>
			</li>
<?php
}
?> 
  </ul>

        </section>
        <!-- /.sidebar -->
      </aside>

<?php
/*
}

if( in_array('52',$page_name)){
?>
	 		   <li>
			 <a href="<?php echo base_url();?>admin/view_page"><i class="fa fa-wrench"></i>


&nbsp;&nbsp;Front end<span class="fa fa-angle-left pull-right"></span></a></li>
			 <?php
}
if( in_array('55',$page_name)){
?>

         <li class="treeview">
			   <a href="<?php echo base_url();?>admin/view_pages">
                <i class="fa fa-adjust"></i>
 <span>Pages</span> <i class="fa fa-angle-left pull-right"></i>
              </a>


			</li>
	        <?php
}if( in_array('61',$page_name)){
?>

 <li>
			  <a href="<?php echo base_url();?>admin/wallet_list"><i class="fa fa-money"></i>


&nbsp;&nbsp;Wallet<span class="fa fa-angle-left pull-right"></span></a></li>
              </a>
			</li>
<?php
}

if( in_array('62',$page_name)){
?>

 <li>
			  <a href="<?php echo base_url();?>admin/callback_list"><i class="fa fa-google-wallet"></i>

&nbsp;&nbsp;Callback<span class="fa fa-angle-left pull-right"></span></a></li>
              </a>
			</li>
<?php
}
?> 
 */
        

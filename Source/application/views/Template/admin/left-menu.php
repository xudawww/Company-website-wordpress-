<!-- START PAGE SIDEBAR -->
<div class="page-sidebar">
    <!-- START X-NAVIGATION -->
    <ul class="x-navigation">
        <li class="xn-logo">
		<?php 
$settings_get=getsettingsdetails();
?>
            <a href="<?php echo base_url().'admin/'; ?>"><?php echo $settings_get->title; ?></a>
            <a href="#" class="x-navigation-control"></a>
        </li>
        <li class="xn-profile">
            <a href="#" class="profile-mini">
                <img src="assets/images/users/avatar.jpg" alt="Admin"/>
            </a>
            <div class="profile">
                <div class="profile-image">
                    <img src="<?php echo base_url(); ?>assets/assets/images/users/user6.jpg" alt="Admin"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">Admin</div>
                 </div>
                 
            </div>
        </li>
        <li class="xn-title">Navigation</li>
        <li>
            <a href="<?php echo base_url().'admin/'; ?>"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>
        </li>

        <li class="xn-openable">
            <a href="#"><span class="fa fa-file-text-o"></span> <span class="xn-text">Places Management</span></a>
            <ul>
                <li><a href="<?php echo base_url(); ?>admin/places">Add Places</a></li>
                <li><a href="<?php echo base_url(); ?>admin/manage-places">Manage Places</a></li>
            </ul>
        </li>

        <li class="xn-openable">
            <a href="#"><span class="fa fa-sitemap"></span> <span class="xn-text">Homestay Management</span></a>
            <ul>

                <li><a href="<?php echo base_url(); ?>admin/assign-property">Property types</a></li>

                <li><a href="<?php echo base_url(); ?>admin/assign-amenities">Amenities</a></li>

                <li><a href="<?php echo base_url(); ?>admin/assign-spaces">What spaces can guests use</a></li>
				
				<li><a href="<?php echo base_url(); ?>admin/manage-listings">Manage Listings</a></li>


                <!--                <li class="xn-openable">
                                    <a href="#">Gallery Management</a>
                                    <ul>
                                        <li><a href="<?php echo base_url(); ?>driverManagement">Add Driver</a></li>
                                        <li><a href="<?php echo base_url(); ?>driverManagement/manageDriver">Manage Driver</a></li>
                                        <li><a href="#">Manage Availability Driver</a></li>
                                    </ul>
                                </li>-->
            </ul>
        </li>

        <li class="xn-openable">
            <a href="#"><span class="fa fa-pencil"></span> <span class="xn-text">User Management </span></a>
            <ul>
                <li><a href="<?php echo base_url(); ?>admin/users">List Users</a></li>
            </ul>
        </li>
		
		<li class="xn-openable">
            <a href="#"><span class="fa fa-envelope"></span> <span class="xn-text">Booking Management </span></a>
            <ul>
                <li><a href="<?php echo base_url(); ?>admin/booking">List Bookings</a></li>
            </ul>
        </li>

        <li class="xn-openable">
           <a href="#"><span class="fa fa-cogs"></span> <span class="xn-text">Settings</span></a>
               <ul>
                 <li><a href="<?php echo base_url(); ?>admin/settings"><span class="fa fa-pencil-square-o"></span>Website Settings</a></li>
               </ul>
                 </li>     
        </ul>
    <!-- END X-NAVIGATION -->
</div>
<!-- END PAGE SIDEBAR -->

<script type="text/javascript">
var currentUrl = window.location.href;
$('.x-navigation').each(function () {
  var li = $(this).find('li');
  $(li.get()).each(function () {
    var allLinks = $(this).find('a').attr("href");
    if(currentUrl==allLinks){
      addActiveclass(this);
      return;
    }
  });
  function addActiveclass(obj)
  {
    $(obj).addClass('active');
    $( obj ).parentsUntil().addClass('active');
    $( obj ).parents().addClass('active');
  }

})
</script>

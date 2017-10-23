 <?php
	$query = $this->db->query(" SELECT * FROM `settings` order by id DESC ");
        $row = $query->row('settings');
		
    $textFile= $row->languages;
    $extension = ".php";
    $filename='includes/'.$textFile.$extension;
   
 
     if (file_exists($filename)) {
     include $textFile.$extension;
     }else{
    include 'en_lang.php'; 
     }
	 $query1 = $this->db->query("SELECT * FROM  static_pages ");
		$data = $query->row('static_pages');
 ?>
		<div class="headermenus">
	<nav class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
         <a href="<?php if($type = $this->session->userdata('type')=="user"){ echo base_url();}?>" class="navbar-brand"><img class='circle'src="<?php echo base_url();?>upload/logo.png"></a>
         </div>
        <div class="collapse navbar-collapse" id="navbar">
          <ul class="nav navbar-nav">
		  <?php  if($username = $this->session->userdata('username')){
		$value = $this->session->userdata('username');
		}else{
		$value= $this->input->cookie('username', false);
		}
		if(!empty($value)){
		?>
		
            
			<li><a href="<?php echo base_url();?>callmycab/account" >
				<span class="menu-image1"><img src="<?php echo base_url();?>assets/images/menu-icon1.png"></span>
				<span class="sess-login"><?php echo $value; ?> </span>
			</a></li>
			<?php
		}else{
			?>
			<li><a href="javascript:void(0);" class='sess-login11'><nav class="main-nav">
				<span class="menu-image1"><img src="<?php echo base_url();?>assets/images/menu-icon1.png"></span>
				<span class='sess-login1'><?php echo $login_Register; ?></span>
			</nav></a></li>
			<?php
		}
		?>
            <li><a href="#" data-toggle="modal" data-target="#newModals">
				<span class="menu-image2"><img src="<?php echo base_url();?>assets/images/menu-icon2.png"></span>
				<span><?php echo $callbacks; ?></span>
			</a></li>
			
            <li><a href="javascript:void(0);" class=' parafair' data-toggle="modal" data-target="#myModal">
				<span class="menu-image3"><img src="<?php echo base_url();?>assets/images/menu-icon5.png"></span>
				<span><?php echo $fare_charts; ?></span>
			</a></li>
			<li><a href="<?php echo base_url();?>callmycab/page_index/about_us">
				<span class="menu-image3"><img src="<?php echo base_url();?>assets/images/menu-icon3.png"></span>
				<span><?php echo $abouts; ?></span>
			</a></li>
            <li><a class="bordernone" href="<?php echo base_url();?>callmycab/page_index/contact_us">
				<span class="menu-image5"><img src="<?php echo base_url();?>assets/images/menu-icon4.png"></span>
				<span><?php echo $contacts; ?></span>
			</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
</div>	
	
	
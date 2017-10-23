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
 ?> 
              <ul class="cbp-vimenu" >
              <li><a href="<?php if($type = $this->session->userdata('type')=="user"){ echo base_url();} ?>" class="icon-logo">Logo</a></li>
                                        
              <?php  if($username = $this->session->userdata('username')){
		$value = $this->session->userdata('username');
		}else{
		$value= $this->input->cookie('username', false);
		}
						if(!empty($value)){
						?>
                              <li ><a href="<?php echo base_url();?>callmycab/account" class="icon-login sess-login"><?php echo $value; ?> </a></li>
                        <?php
						}else{?>
              <nav class="main-nav">
              <li  ><a href="javascript:void(0);" class="icon-login sess-login1 sess-login11"><?php echo $login_Register; ?></a></li>
              </nav>                                                                         
             <?php
						}
						?>
              <li><a href="#" class="icon-callback" data-toggle="modal" data-target="#newModals"><?php echo $callbacks; ?></a></li>
              <li><a href="javascript:void(0);" class="icon-freechart parafair" data-toggle="modal" data-target="#myModal"><?php echo $fare_charts; ?></a></li>
              <li><a href="<?php echo base_url();?>callmycab/page_index/about_us" class="icon-about"><?php echo $abouts; ?></a></li>
              <li><a href="<?php echo base_url();?>callmycab/page_index/contact_us" class="icon-contact"><?php echo $contacts; ?></a></li>
              </ul>
			  
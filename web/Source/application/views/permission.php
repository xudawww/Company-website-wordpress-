
<?php
/* page permission */
    if(!empty($this->session->userdata('permission'))) {
   
	 $pm = $this->db->query("SELECT * FROM  pages WHERE pages='".basename($_SERVER['HTTP_REFERER'])."'");
	 foreach($pm->result_array() as $upm){
    if($pm->num_rows == 1) {
      
        if(in_array($upm['p_id'], $this->session->userdata('permission'))) {
            $permission = "access";
        } else {
            $permission = "failed";
            $this->load->view('admin-login');
        }
    } else {
        $permission = "failed";
    }
	 }
    }
    /* page permission */
?>
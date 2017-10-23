<?php
class Home_model extends CI_Model{
function __construct() {
parent::__construct();
}
function update_status_authorize_net($result){
	
	$uneaque_id = $this->session->userdata('uneaqueid');
	$bookid = $this->session->userdata('bookid');
	$table="bookingdetails";
	$update_data = array(
			'status'     => 'Booking',
			'item_status'=>'Completed',
			'transaction'=>$result
		);
		$where_data = array('uneaque_id'     => $uneaque_id,
		'id'=>$bookid
		);
	$results = $this->update_table_where($update_data, $where_data, $table );
	return true;
	
}function update_status_authorize_net_cancel(){
	
	$uneaque_id = $this->session->userdata('uneaqueid');
	$bookid = $this->session->userdata('bookid');
	$table="bookingdetails";
	$update_data = array(
			'status'     => 'Cancelled',
			'item_status'=>'Cancelled'
			
		);
		$where_data = array('uneaque_id'     => $uneaque_id,
		'id'=>$bookid
		);
	$results = $this->update_table_where($update_data, $where_data, $table );
	
	$s =$this->add_wallet_balance();
	return true;
	
}
function add_wallet_balance(){	
    $table="userdetails";
	$wallet=$this->session->userdata('wallet-balance');
	$username= $this->session->userdata('username');
	$update_data = array(
			'wallet_amount'     => $wallet
		);
		
		$where_data = array(
			'username'     => $username,
		);

		$results = $this->update_table_where($update_data, $where_data, $table );
	return true;
	
    }
function add_call($id){
	$select_data = "*"; 
			
			$where_data = array(	// ----------------Array for check data exist ot not
				'phone'     => $id['phone']
			);
			
			$table="callback";  //------------ Select table
			$result = $this->get_table_where( $select_data, $where_data, $table );
			if( count($result) == 0 ){ 
			
	      $request = array(	// ----------------Array for check data exist ot not
			'phone'     => $id['phone']
		 );
		
	$this->db->insert($table,  $request);
		
		return true;
			}
	
	
}
function get_table_where( $select_data, $where_data, $table){
        
		$this->db->select($select_data);
		$this->db->where($where_data);
		$query  = $this->db->get($table);  //--- Table name = User
		$result = $query->result_array(); 
		return $result;	
   }
function update_table_where( $update_data, $where_data, $table){	
		$this->db->where($where_data);
		$this->db->update($table, $update_data);
	
	
    }
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('paypal_lib');
		$this->load->library('Authorize_net');
		$this->load->library('Braintree_lib');
	}
	
	public function index($id=null){
		if($this->session->userdata('username'))
	 {
		$settings = getsettingsdetails(); 
		list($currency,$code) = explode(',', $settings->currency);
		$book = $this->db->where('id',$id)->get('bookingdetails')->row();
		$user = $this->db->where('username',$book->username)->get('userdetails')->row();
		$total = $book->amount;

		if($book->promo_code!=''){
			$promo = $this->db->where('promocode',$book->promo_code)->get('promocode')->row();
			
			if($promo->type=='Fixed'){
				$promo_amount = $promo->amount;
			} else {
				$promo_amount = (($book->amount*$promo->amount)/100);
			}
			$this->db->where('promocode',$book->promo_code)->update('promocode',array('status'=>0));
		} else {
			$promo_amount = 0;
		}

		

		if($promo_amount>0){
			if($promo_amount>$book->amount){
				$total = 0;
				$promo_balance = $promo_amount - $book->amount;
				$data['promo_message'] = "Promo Code Used amount of ".$code.$book->amount." Balance amount ".$code.$promo_balance." credited to Wallet";
				
				$this->db->set('wallet_amount', 'wallet_amount+ '.(int)$data['amount'], FALSE);
				$this->db->where('username', $book->username);
				$this->db->update('userdetails');
			} else {
				$total = $book->amount - $promo_amount;
				$data['promo_message'] = "Promo Code Used amount of ".$code.$promo_amount;
			}
			
		} else {
			$data['promo_message'] = '';
		}

		

		if($total>0){

			if($user->wallet_amount>0){

				if($user->wallet_amount>$book->amount){
					$wallet_balance = $user->wallet_amount - $total;
					$total = 0;
					$this->db->set('wallet_amount',$wallet_balance , FALSE);
					$this->db->where('username', $book->username);
					$this->db->update('userdetails');
				} else {
					$wallet_balance = 0;
					$this->db->set('wallet_amount',$wallet_balance , FALSE);
					$this->db->where('username', $book->username);
					$this->db->update('userdetails');
					$total = $total - $user->wallet_amount;
				}
			}



			if($total>0){
				$data['amount'] = $total;
				$data['booking_id'] = $id;
				$template['settings'] = $settings;
				$template['page_title'] = "Payment";
				$template['page_name'] = "payment"; 
				$template['data'] = $data;
        		$this->load->view('template', $template);
			} else {
				$this->db->where('id',$id)->update('bookingdetails',array('item_status'=>'Completed','payment_media'=>'Wallet'));
				$template['book_info'] = $this->db->where('id',$id)->get('bookingdetails')->row();
				$template['page_title'] = "Payment Success";
				$template['page_name'] = "success"; 
        		$this->load->view('template', $template);
			}

		} else {
			$this->db->where('id',$id)->update('bookingdetails',array('item_status'=>'Completed','payment_media'=>'Promo Code'));
			$template['book_info'] = $this->db->where('id',$id)->get('bookingdetails')->row();
			$template['page_title'] = "Payment Success";
			$template['page_name'] = "success"; 
        	$this->load->view('template', $template);

		}




		
	}else{
		  redirect('/', 'refresh');
	 }
	}
	public function autherize_payment(){
			if($this->session->userdata('username'))
	 {
		$info = (object)$_POST;


		

		

		$settings = getsettingsdetails();
		list($from_Currency,$code) = explode(',', $settings->currency);
		$book = $this->db->where('id',$info->booking_id)->get('bookingdetails')->row();
		$user = $this->db->where('username',$book->username)->get('userdetails')->row();


		
		$amount = $info->amount;
		$amount = ceil(convert_to_usd($amount,$from_Currency));

		

		$desc = 'Payment of call My Cab Unique ID:'.$book->uneaque_id;

		$auth_net = array(
			'x_card_num'			=> $info->card_no, //'4111111111111111', // Visa
			'x_exp_date'			=> $info->exp_date,
			'x_card_code'			=> $info->card_cvv,
			'x_description'			=> $desc,
			'x_amount'				=> $amount,
			'x_first_name'			=> $user->username,
			'x_last_name'			=> 'Call My Cab',
			'x_address'				=> '',
			'x_city'				=> '',
			'x_state'				=> 'location',
			'x_zip'					=> '',
			'x_country'				=> $settings->country,
			'x_phone'				=> $user->mobile,
			'x_email'				=> $user->email,
			'x_customer_ip'			=> $this->input->ip_address(),
			);
		$this->authorize_net->setData($auth_net);

		// Try to AUTH_CAPTURE
		if( $this->authorize_net->authorizeAndCapture() )
		{
			/*echo '<h2>Success!</h2>';
			echo '<p>Transaction ID: ' . $this->authorize_net->getTransactionId() . '</p>';
			echo '<p>Approval Code: ' . $this->authorize_net->getApprovalCode() . '</p>';*/
			$txn_id = $this->authorize_net->getTransactionId();
			$this->db->where('id',$info->booking_id)->update('bookingdetails',array('item_status'=>'Completed','transaction'=>$txn_id,'payment_media'=>'Authorize.Net'));
			$rs = array('status'=>'success','message'=>'Transaction Successfully','booking_id'=>$info->booking_id);
			print json_encode($rs);
		}
		else
		{
			
			$error = $this->authorize_net->getError();
			$this->db->where('id',$info->booking_id)->update('bookingdetails',array('item_status'=>'Cancelled','payment_media'=>'Authorize.Net'));
			$result = array('status'=>'error','message'=>$error,'booking_id'=>$info->booking_id);	
			print json_encode($result);		
		}
	}
else{
		  redirect('/', 'refresh');
	 }
	}
	public function paypal_payment($amount=null,$booking_id=null){	
		if($this->session->userdata('username'))
	 {

        $settings = getsettingsdetails();
		list($from_Currency,$code) = explode(',', $settings->currency);
		$book = $this->db->where('id',$booking_id)->get('bookingdetails')->row();
		$user = $this->db->where('username',$book->username)->get('userdetails')->row();


		
		$amount = $amount;
		$returnURL = base_url().'Payment/success';
        $cancelURL = base_url().'Payment/cancel';
        $notifyURL = base_url().'Payment/success';
        $paypalID = $this->config->item('business');
        $unique = uniqid();

        $amount = ceil(convert_to_usd($amount,$from_Currency));
 		

        $this->paypal_lib->add_field('business', $paypalID);
        $this->paypal_lib->add_field('return', $returnURL);
        $this->paypal_lib->add_field('cancel_return', $cancelURL);
        $this->paypal_lib->add_field('notify_url', $notifyURL);
        $this->paypal_lib->add_field('item_name', "Payment of Booking ".$book->uneaque_id);
        $this->paypal_lib->add_field('custom', $booking_id);
        $this->paypal_lib->add_field('item_number',  $book->uneaque_id);
        $this->paypal_lib->add_field('amount',  $amount);
        $this->paypal_lib->paypal_auto_form();
		}else{
		  redirect('/', 'refresh');
	 }
	}

	function success(){
			if($this->session->userdata('username'))
	 {
		$paypalInfo	= $this->input->post();
		$booking_id = $paypalInfo['custom'];
		$txn_id	= $paypalInfo["txn_id"];		
		$paypalURL = $this->paypal_lib->paypal_url;		
		$result	= $this->paypal_lib->curlPost($paypalURL,$paypalInfo);		
		$this->db->where('id',$booking_id)->update('bookingdetails',array('item_status'=>'Completed','transaction'=>$txn_id,'payment_media'=>'Paypal'));
		//$rs = array('status'=>'success','message'=>'Transaction Successfully','booking_id'=>$info->booking_id);
		//print json_encode($rs);	
		$template['book_info'] = $this->db->where('id',$booking_id)->get('bookingdetails')->row();
			$template['page_title'] = "Payment Success";
			$template['page_name'] = "success"; 
        	$this->load->view('template', $template);
		}else{
		  redirect('/', 'refresh');
	 }	
    }

    function cancel(){
    	$this->db->where('id',$info->booking_id)->update('bookingdetails',array('item_status'=>'Cancelled','payment_media'=>'Paypal'));
    	$template['page_title'] = "Payment failure";
			$template['page_name'] = "error"; 
        	$this->load->view('template', $template);
			
    }

    public function braintree_payment(){
			if($this->session->userdata('username'))
	 {
    	$info = (object)$_POST;
    	$book = $this->db->where('id',$info->booking_id)->get('bookingdetails')->row();
		$user = $this->db->where('username',$book->username)->get('userdetails')->row();


		$settings = getsettingsdetails();
		list($from_Currency,$code) = explode(',', $settings->currency);
		$amount = $info->amount;
		$amount = ceil(convert_to_usd($amount,$from_Currency));



		


		$result = Braintree_Transaction::sale(array(
			'amount' => $amount,
			'creditCard' => array(
			'number' => $info->card_no,
			'cardholderName' =>  $user->username,
			'expirationDate' => $info->exp_date,
			'cvv' => $info->card_cvv
			)
		));

		if ($result->success) {
			$txn_id = $result->transaction->id;
			$this->db->where('id',$info->booking_id)->update('bookingdetails',array('item_status'=>'Completed','transaction'=>$txn_id,'payment_media'=>'BrainTree'));
			$rs = array('status'=>'success','message'=>'Transaction Successfully','booking_id'=>$info->booking_id);
			print json_encode($rs);
		} else {
			$error = $result->_attributes['message'];
			$this->db->where('id',$info->booking_id)->update('bookingdetails',array('item_status'=>'Cancelled','payment_media'=>'BrainTree'));
			$result = array('status'=>'error','message'=>$error,'booking_id'=>$info->booking_id);	
			print json_encode($result);
		}
}else{
		  redirect('/', 'refresh');
	 }
    }

    public function cash_payment(){
			if($this->session->userdata('username'))
	 {
    	$info = (object)$_POST;
    	$this->db->where('id',$info->booking_id)->update('bookingdetails',array('item_status'=>'Completed','payment_media'=>'Cash'));
		$rs = array('status'=>'success','message'=>'Transaction Successfully','booking_id'=>$info->booking_id);
		print json_encode($rs);
		}else{
		  redirect('/', 'refresh');
	 }
    }

    public function payment_check($id=null){
			if($this->session->userdata('username'))
	 {
    	
    	$settings = getsettingsdetails(); 
		list($currency,$code) = explode(',', $settings->currency);
		$book = $this->db->where('id',$id)->get('bookingdetails')->row();
		$user = $this->db->where('username',$book->username)->get('userdetails')->row();
		$total = $book->amount;
		$data['amount'] = $total;
		$data['booking_id'] = $id;
		$template['settings'] = $settings;
		$template['data'] = $data;
    	$template['page_title'] = "Payment Success";
		$template['page_name'] = "payment"; 
        $this->load->view('template', $template);
		}else{
		  redirect('/', 'refresh');
	 }
    }

    public function payment_success($id=null){
		
			if($this->session->userdata('username'))
	 { 	$uname=$this->session->userdata('username');
    	$template['page_title'] = "Payment Success";
		$template['page_name'] = "success";
		$template['book_info'] = $this->db->where('id',$id)->get('bookingdetails')->row();
		$query1 = $this->db->query("select * from userdetails where username ='$uname'");
		if ($query1->num_rows() =='1'){
		$row3 = $query1->row('userdetails');
		$name=$row3->username;
		$from=$row3->username;
		$email=$row3->email;
		$sub='Booking Confirmation';
		$sms='<div style="width:660px; height:400px; margin:0 auto; background:#F7941E; padding:20px 20px 20px 20px; font-family: Century Gothic,Verdana,Geneva,sans-serif; border:solid #de851b 1px;">
	
    <div style="width:100%; float:left; padding:0 0 10px 0;">
    <div style="width:138px; height:50px; float:left; margin:0 0 0 20px;"> <img src="'.base_url().'assets/img/home/logo.png" alt="" /></div>
    <div style="width:350px; float:left; padding:25px 0 0 0; text-align:center; font-size:18px; ">Booking Confirmation</div>
     </div>
     <div style="background:#fff;  float:left; width:96.3%;   border-top-right-radius: 8px; border-top-left-radius: 8px; padding:15px 12px 0 12px;  ">
    		<div style="width:100%; padding:10px 0 10px 0; float:left; color:#666261; font-size:14px; text-align:center;">Thank you for choosing our service. We are happy to serve you!!!</div>
                 <div style="width:100%; float:left; padding:15px 0 15px 0; border-bottom:solid #cdcdcd 1px; border-top:solid #cdcdcd 1px;"> 
                 <div style="width:100%; float:left; font-size:14px; text-align:center;">Booking has been successful</div>
            </div>
        </div></div>
        <div style="background:#fff;  float:left; width:96.3%;    border-bottom-right-radius: 8px; border-bottom-left-radius: 8px; padding:20px 12px 20px 12px;  "></div>
          </div>';
		 
		 $this->send_mail($from,$name,$email,$sub,$sms);
		}
        $this->load->view('template', $template);
		}else{
		  redirect('/', 'refresh');
	 }
    }

function send_mail($from,$name,$mail,$sub, $msg)
{
 $this->db->order_by("id","desc");
 $query2 = $this->db->get('settings');
 foreach ($query2->result() as $row)
 {
 $host= $row->smtp_host;
 $pass= $row->smtp_password;
 $username = $row->smtp_username;
  $from = $row->smtp_username;
	}
$config['protocol'] = 'smtp';
$config['smtp_host'] = $host;
$config['smtp_user'] = $username;
$config['smtp_pass'] = $pass;
$config['smtp_port'] = 25;
$config['mailtype'] = 'html';

$this->email->initialize($config);
$this->email->from($from, $name);
$this->email->to($mail);
$this->email->subject($sub);
$this->email->message($msg);
$this->email->send();
//echo	 $this->email->print_debugger();
 }

    
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Wallet extends CI_Controller {



	public function __construct() {

		parent::__construct();

		$this->load->library('paypal_lib');

	}



	public function add_to_wallet($amount=null){



		$settings = $this->db->get('settings')->row();



		list($currency_code,$code) = explode(',', $settings->currency);

		$username = $this->session->userdata('username');

		//$amount = $this->input->get('amount');

		

		$returnURL = base_url().'Wallet/success';

        $cancelURL = base_url().'Wallet/cancel';

        $notifyURL = base_url().'Wallet/success';

        $paypalID = $this->config->item('business');

        $unique = uniqid();

        $amount_org = $amount;



        $amount = ceil($this->convert_to_usd($amount,$currency_code));

 		



        $this->paypal_lib->add_field('business', $paypalID);

        $this->paypal_lib->add_field('return', $returnURL);

        $this->paypal_lib->add_field('cancel_return', $cancelURL);

        $this->paypal_lib->add_field('notify_url', $notifyURL);

        $this->paypal_lib->add_field('item_name', "Call My Cab Wallet");

        $this->paypal_lib->add_field('custom', $amount_org);

        $this->paypal_lib->add_field('item_number',  $unique);

        $this->paypal_lib->add_field('amount',  $amount);

        $this->paypal_lib->paypal_auto_form();

	}



	function convert_to_usd($amount,$from_Currency){

		

		$to_Currency = 'USD';

		$amount = urlencode($amount);

		$from_Currency = urlencode($from_Currency);

		$to_Currency = urlencode($to_Currency);

		$get = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency");

		$get = explode("<span class=bld>",$get);

		$get = explode("</span>",$get[1]);

		return $converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);

	}



	function success(){

		$paypalInfo	= $this->input->post();

		$uneaque_id	= $paypalInfo["txn_id"];

		$data['amount'] = $paypalInfo['custom'];

		$data["username"] = $this->session->userdata('username');

		$data['item_no'] =  $paypalInfo["txn_id"];

		$data['status'] = 'Completed';

		$paypalURL = $this->paypal_lib->paypal_url;		

		$result	= $this->paypal_lib->curlPost($paypalURL,$paypalInfo);

		

		$this->db->insert('wallet',$data);

		

		$this->db->set('wallet_amount', 'wallet_amount+ '.(int)$data['amount'], FALSE);

		$this->db->where('username', $this->session->userdata('username'));

		$this->db->update('userdetails');	

		$data['uneaque_id'] = $uneaque_id;	 

		$template['book_info'] = (object)$data;

		$template['page_title'] = "Wallet Success";
		$template['page_name'] = "wallet_success"; 
        $this->load->view('template', $template);	

			

    }



    function cancel(){

    	redirect(base_url());

    }



}
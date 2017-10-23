<?php
	global $WPVR_SERVER;
	
	global $wpvr_default_options , $wpvr_default_tokens , $wpvr_activation_default;
	global $CLI_SERVER , $wpvr_is_cli , $wpvr_vs_ids , $default_notice;
	global $wpvr_empty_activation , $wpvr_remote_ip;

	/* DEfault Tokens */
	$wpvr_default_tokens = array();
	$wpvr_default_tokens = apply_filters( 'wpvr_extend_default_tokens' , $wpvr_default_tokens );


	if( $wpvr_is_cli === TRUE ) $WPVR_SERVER = $CLI_SERVER;
	else $WPVR_SERVER = $_SERVER;
	
	if( isset( $WPVR_SERVER[ 'SERVER_ADDR' ] ) ) $act_ip = $WPVR_SERVER[ 'SERVER_ADDR' ];
	elseif( isset( $WPVR_SERVER[ 'REMOTE_ADDR' ] ) ) $act_ip = $WPVR_SERVER[ 'REMOTE_ADDR' ];
	else $act_ip = '';

	$wpvr_remote_ip = $act_ip;
	
	if( !isset($WPVR_SERVER['HTTP_HOST']) ){
		$WPVR_SERVER['HTTP_HOST']  = 'unkown.domain';
	}
	
	$wpvr_empty_activation = array(
		'act_status'  => 0 ,
		'act_product' => '' ,
		'act_id'      => '' ,
		'act_email'   => '' ,
		'act_code'    => '' ,
		'act_date'    => '' ,
		'buy_date'    => '' ,
		'buy_user'    => '' ,
		'buy_licence' => '' ,
		'act_addons'  => array() ,
		'act_url'     => WPVR_SITE_URL ,
		'act_domain'  => $WPVR_SERVER[ 'HTTP_HOST' ] ,
		'act_version' => WPVR_VERSION ,
		'act_cinfos'  => '' ,
		'act_ip'      => $act_ip ,
	);


	/* Default activation array */
	$wpvr_activation_default = array(
		'act_status'  => 0 ,
		'act_product' => '' ,
		'act_id'      => '' ,
		'act_email'   => '' ,
		'act_code'    => '' ,
		'act_date'    => '' ,
		'buy_date'    => '' ,
		'buy_user'    => '' ,
		'buy_licence' => '' ,
		'act_addons'  => array() ,
		'act_url'     => WPVR_SITE_URL ,
		'act_domain'  => $WPVR_SERVER[ 'HTTP_HOST' ] ,
		'act_version' => WPVR_VERSION ,
		'act_cinfos'  => '' ,
		'act_ip'      => $act_ip ,
	);

	$default_notice = array(
		'slug'               => 'wpvr_notice_' . rand( 100 , 999999 ) ,
		'title'              => '' ,
		'class'              => 'updated' , //updated or warning or error
		'content'            => '' ,
		'hidable'            => TRUE ,
		'is_dialog'          => FALSE ,
		'dialog_modal'       => FALSE ,
		'dialog_delay'       => 1000 ,
		//'dialog_ok_button' => '',
		'dialog_ok_button'   => ' <i class="fa fa-check"></i> OK' ,
		'dialog_hide_button' => '<i class="fa fa-close"></i> DISMISS ' ,
		'dialog_class'       => '' ,
		'dialog_ok_url'      => FALSE ,
		'show_once'          => FALSE ,
		'single_line'        => FALSE ,
		'is_manual'          => FALSE ,
		'icon'               => 'fa-rocket' ,
		'color'              => '#27A1CA' ,
		'date'               => '' ,
	);

	if( !isset( $wpvr_options['unwanted'] ) )   $wpvr_options['unwanted'] = array();
	foreach( (array) $wpvr_vs as $vs ){
		if( !isset( $wpvr_options['unwanted'][ $vs['id'] ] ) )   {
			$wpvr_options['unwanted'][ $vs['id'] ] = array();
		}
	}

	//d( $wpvr_options );
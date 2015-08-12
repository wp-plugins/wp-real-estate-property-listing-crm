<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * create user function
 * - create user
 * @param	$data	array()		possible items:
 * 								this is for create user
 * 									email: the main base of the account
 * 									username: the login username, the default is the email
 * 									password: it not set will generate password, if set then user has preference password
 * 									first_name: the first name of the current user
 * 									last_name: the last name of the current user
 * 									nickname: if not set, first_name will be used
 * */
function md_create_user($data = array()){
	//check user must not logged in
	$return_msg 	= '';
	$return_status 	= false;

	$email = '';
	if( isset($data['email']) ){
		$email = $data['email'];
	}
	$username = '';
	if( isset($data['username']) ){
		$username = $data['username'];
	}
	$password = wp_generate_password(12, false);
	if( isset($data['password']) ){
		$password = $data['password'];
	}
	$first_name = '';
	if( isset($data['first_name']) ){
		$first_name = $data['first_name'];
	}
	$last_name = '';
	if( isset($data['last_name']) ){
		$last_name = $data['last_name'];
	}
	$nickname = $first_name;
	if( isset($data['nickname']) ){
		$nickname = $data['nickname'];
	}
	//continue
	//check email and username must not exists
	if( !email_exists($email) && !username_exists($username) ){
		//create user here
		$create_user_array = array(
			'email' 		=> $email,
			'username' 		=> $username,
			'password' 		=> $password,
			'first_name' 	=> $first_name,
			'last_name' 	=> $last_name,
			'nickname' 		=> $nickname
		);
		$user = \MD_User::get_instance()->create($create_user_array);
	}

	if( $user ){
		return $user;
	}else{
		return false;
	}
}
/* *
 * login user
 * @param $credentials		array()			for login user data:
 * 											user_login: username
 * 											user_password: password
 * 											remember: default is true
 * */
function md_login_user($credentials = array(), $direct = false){
	return \MD_User::get_instance()->login($credentials, $direct);
}
/**
 * register user function
 * - create user
 * - auto login
 * - send user credentials
 * - push to crm
 * @param	$data	array()		possible items:
 * 								this is for create user
 * 									email: the main base of the account
 * 									username: the login username, the default is the email
 * 									password: it not set will generate password, if set then user has preference password
 * 									first_name: the first name of the current user
 * 									last_name: the last name of the current user
 * 									nickname: if not set, first_name will be used
 * 								for login user
 * 									user_login: username will be use instead
 * 									user_password: password will be use instead
 * 									remember: default is true
 * */
function md_register_user($data = array()){
	if( !is_user_logged_in() ){
		return md_create_user($data);
	}else{
		//login
	}
}
/**
 * un-subscribe user in property alert
 * */
function md_unsubscribe_palert($email){

}

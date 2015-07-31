<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class MD_User{

	protected static $instance = null;

	public function __construct(){}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function is_logged_in(){
		return is_user_logged_in();
	}

	public function wp_get_current_user(){
		return wp_get_current_user();
	}

	public function is_user_exists($email){
		return username_exists($email);
	}

	public function is_email_exists($email){
		return email_exists($email);
	}

	public function check_subscribe_user_exists($email){
		if( $this->is_user_exists($email) || $this->is_user_exists($email) ){
			return true;
		}
		return false;
	}

	/**
	 * Sign-in user
	 * @param	 $credentials 		array() 	array items should be:
	 * 											user_login : the actual username
	 * 											user_password : the actual password
	 * 											remember default to true
	 * */
	public function user_signon($credentials = array()){
		if( !isset($credentials['remember']) ){
			$credentials['remember'] = true;
		}
		$login = wp_signon( $credentials, false );
		if ( is_wp_error($login) ) {
			return $login->get_error_message();
		}else{
			return $login;
		}
	}

	/**
	 * Sign-in user without password
	 * @param	 $credentials 		array() 	array items should be:
	 * 											user_id : the id of the user in the wp_user table
	 * 											remember default to true
	 * */
	public function user_signon_cookie($credentials = array(), $remember = true){
		if( isset($credentials['user_id']) ){
			wp_set_auth_cookie($credentials['user_id'],$remember);
		}
		return false;
	}

	/**
	 * create user
	 * @param	$post_data		array()		the default elements are:
	 * 										username: the login username
	 * 										password: the login password, if not set then will auto generate
	 * 										nickname: this could be any name
	 * 										first_name: the first name of the current user
	 * 										last_name: the last name of the current user
	 * */
	public function create($post_data){
		$user_id	= 0;

		if( !isset($post_data['password']) ){
			$password 	= wp_generate_password(12, false);
		}else{
			$password = $post_data['password'];
		}

		$user_id = wp_create_user($post_data['username'], $password, $post_data['email']);

		$first_name = '';
		if( isset($post_data['first_name']) ){
			$first_name = $post_data['first_name'];
		}

		$last_name = '';
		if( isset($post_data['last_name']) ){
			$last_name = $post_data['last_name'];
		}

		$nickname = $first_name;
		if( isset($post_data['nickname']) ){
			$nickname = $post_data['nickname'];
		}

		// Set the name
		wp_update_user(
			array(
				'ID'          =>    $user_id,
				'nickname'    =>    $nickname,
				'first_name'  =>    $first_name,
				'last_name'   =>    $last_name,
			)
		);

		return array(
			'user_id'	=>	$user_id,
			'password'	=>	$password,
		);
	}

	public function login($credentials = array(), $direct = false){
		if( $direct ){
			return $this->user_signon_cookie($credentials);
		}else{
			return $this->user_signon($credentials);
		}
	}

	public function save_lead_to_crm($data = array()){

	}

}

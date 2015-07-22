<?php
namespace helpers;

class Cookies {

	protected static $instance = null;

	protected $expire_time;

	public function __construct(){
		//set default values
		$this->setExpireTime(time() + 7200);
	}

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

	public function setExpireTime($time){
		$this->expire_time = $time;
	}

	public function getExpireTime(){
		return $this->expire_time;
	}

	public function set($cookie_name, $cookie_value, $expire = null){
		if( is_null($expire) ){
			$expire = time() + 3600;
		}
		setcookie( $cookie_name, $cookie_value, $expire, COOKIEPATH, COOKIE_DOMAIN );
	}

	public function get($cookie_name){
		if( isset( $_COOKIE[$cookie_name] ) ){
			return $_COOKIE[$cookie_name];
		}else{
			return false;
		}
	}

	public function delete($cookie_name){
		if( $this->get($cookie_name ) ){
			setcookie( $cookie_name, '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN );
			unset( $_COOKIE[$cookie_name] );
			return true;
		}else{
			return false;
		}
	}

	public function wp_cookie_is_user_logged(){
		$logged_in = false;
		if (count($_COOKIE)) {
			foreach ($_COOKIE as $key => $val) {
				if (preg_match("/wordpress_logged_in/i", $key)) {
					$logged_in = true;
				}
			}
		} else {
			$logged_in = false;
		}
		return $logged_in;
	}

}

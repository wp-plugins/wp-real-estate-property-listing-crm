<?php
//remove
class Account_Shortcode{
	protected static $instance = null;

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

	public function __construct(){
		//add_action('admin_footer', array($this, 'md_get_shortcodes'));
		add_shortcode('md_account_dashboard',array($this,'init_shortcode'));
	}

	private function get_default_template($template = null){
		return \Account_Registered::get_instance()->get_default_template($template);
	}

	private function get_signup_template(){
		return \Signup_Form::get_instance()->get_template_form();
	}

	private function get_account_profile(){
		return \Account_Profile::get_instance()->get_default_template();
	}

	public function init_shortcode($atts){
		global $current_user;
		get_currentuserinfo();

		$template = $this->get_default_template();

		if( !is_user_logged_in() ){
			$template_signup = $this->get_signup_template();
		}
		$user_account 		= \Account_Profile::get_instance()->get_current_user();
		$user_meta 			= get_user_meta($user_account->ID);
		$template_profile 	= $this->get_account_profile();
		$template_password 	= \Account_Profile::get_instance()->get_password_form();

		$num_favorites 			= 0;
		$favorites 				= \Save_Property::get_instance()->get_db_favorites();
		$num_favorites 			= count($favorites);
		$template_favorites 	= \Save_Property::get_instance()->template_favorites();
		$get_favorites_property = \Save_Property::get_instance()->get_favorites_property();

		$num_xout = 0;
		$xout = \Save_Property::get_instance()->get_db_xout();
		$num_xout = count($xout);
		$template_xout 	= \Save_Property::get_instance()->template_xout();
		$get_xout_property = \Save_Property::get_instance()->get_xout_property();

		$col = MD_DEFAULT_GRID_COL;
		$show_sort = false;
		ob_start();
		require $template;
		$output = ob_get_clean();
		return $output;
	}

	public function md_get_shortcodes(){

	}

}

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Next_Prev{
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

	public function display(){
		$template 		= \MD_Template::get_instance()->load_template('next_prev.php');
		$next_prev_data = array();

		if( DEFAULT_FEED == 'crm' ){
			$next_prev_data = \crm\Layout_Property::get_instance()->next_prev();
		}

		if( $template && $next_prev_data ){
			if( has_filter('next_prev_template') ){
				$template = apply_filters('next_prev_template',$path);
			}
			require $template;
		}
		return false;
	}

}

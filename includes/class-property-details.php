<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Load Property Details template
 * */
class MD_Property_Details{
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

	// we will get the default
	public function get_carousel_template($atts){
		$photos 			= get_single_property_photos();
		$template_carousel 	= \MD_Template::get_instance()->load_template($atts['template_carousel']);

		if( $template_carousel ){
			if( has_filter('global_template_carousel') ){
				$template_carousel = apply_filters('global_template_carousel',$atts);
			}
			require_once $template_carousel;
		}
	}

	public function single_map($atts){
		require GLOBAL_TEMPLATE . 'single/partials/map/map.php';
	}

	public function single_walkscore($atts){
		require GLOBAL_TEMPLATE . 'single/partials/walkscore/walkscore.php';
	}

	public function single_photos($atts){
		require GLOBAL_TEMPLATE . 'single/partials/photos/photos.php';
	}

	public function display_agent_box($property_data, $atts = array()){
		$template 	= GLOBAL_TEMPLATE . 'agent/html-agent.php';
		$agent 		= new MD_Agent;
		$agent->set_agent_data($property_data);
		require $template;
	}

	public function display_property_details_left_content($atts, $additional_atts = array()){
		require GLOBAL_TEMPLATE . 'single/partials/property-details/left-content.php';
	}

	public function display_property_details_right_content($atts, $additional_atts = array()){
		require GLOBAL_TEMPLATE . 'single/partials/property-details/right-content.php';
	}
}



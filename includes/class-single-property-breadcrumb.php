<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Plugin Name.
 * Class to set Property Breadcrumb and its associate page
 *
 * @package   MD_Single_Property
 * @author    Masterdigm <email@example.com>
 * @license   GPL-2.0+
 * @link      http://masterdigm.com
 * @copyright 2014 Masterdigm
 */

/**
 * This is use to update public design changes
 *
 *
 *
 * @package MD_Single_Property
 * @author  masterdigm / Allan
 */
class MD_Single_Property_Breadcrumb {
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	public function __construct(){
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function masterdigm_breadcrumb_trail($property_data, $args = null){
		$trail = $this->createPageForBreadcrumbTrail($property_data, $args['show_location']);
		return $trail;
	}

	public function createPageForBreadcrumbTrail($property_data, $show_location = null){
		$breadcrumb = array();
		if( isset($property_data['source']) ){
			$breadcrumb = apply_filters('breadcrumb_' . $property_data['source'], $property_data, $show_location);
		}
		return $breadcrumb;
	}

	public function setSessionBreadCrumb($source, $breadcrumb){
		if( session_id() && isset($source) ) {
			if( !isset($_SESSION[$source . 'breadcrumb']) ) {
				$_SESSION[$source . 'breadcrumb'] = $breadcrumb;
			}
		}
	}

	public function getSessionBreadCrumb($source){
		if( session_id() && isset($source) ) {
			if( isset($_SESSION[$source . 'breadcrumb']) ) {
				return $_SESSION[$source . 'breadcrumb'];
			}
		}
	}

	public function deleteSessionBreadCrumb($source = ''){
		if( session_id() && isset($source) ) {
			if( isset($_SESSION[$source . 'breadcrumb']) ) {
				unset($_SESSION[$source . 'breadcrumb']);
			}
		}
	}

}


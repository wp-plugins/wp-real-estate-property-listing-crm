<?php
namespace mls;
/**
 * Use as to handle templating for various views on each template
 * */
class Layout_Property{
	protected static $instance = null;

	public function __construct(){
		add_action('hook_favorites_property_mls',array($this,'saved_properties'),10,1);
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

	public function saved_properties($data_properties){
		$properties = \mls\Properties::get_instance()->get_property_by_id($data_properties['id']);
		return $properties;
	}

}

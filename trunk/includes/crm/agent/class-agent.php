<?php
namespace crm;
/**
 * Handle logic for fetching agent details
 * */
class Agent{

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

	public function displayAgentHTML(){
		$property = \MD_Single_Property::get_instance()->getPropertyData();
		if( $property['agent'] ){
			$agent = $property['agent'];
			include( PLUGIN_PUBLIC_VIEW . 'share/agent.php');
		}else{
			return false;
		}
	}

}

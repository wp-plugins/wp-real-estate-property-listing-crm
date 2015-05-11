<?php
class CRM_Hook{
	protected static $instance = null;

	public $crm;

	public function __construct(){
		$this->crm = new Masterdigm_CRM;
		add_action('before_get_properties_crm',array($this,'track_search'),10,1);
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

	public function track_search($search_data){

	}

}

<?php
class Favorites_Xout_Property extends Account_Dashboard{
	protected static $instance = null;
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

	public function __construct(){
		add_filter( 'dashboard_content_favorites', array($this,'controller'),10, 1 );
	}

	public function get_dashboard_page(){
		return parent::get_instance()->get_dashboard_page();
	}

	public function url(){
		return get_permalink($this->get_dashboard_page()->ID).'favorites';
	}

	public function controller(){
		global $wp_query;
		$arr_action = parent::get_instance()->md_get_query_vars();

		$action_args = $arr_action;

		$action = '';
		if( isset($arr_action->action) ){
			$action = $arr_action->action;
		}
		$task = '';
		if( isset($arr_action->task) ){
			$task = $arr_action->task;
		}

		switch($task){
			default:
				$this->display();
			break;
		}
	}

	public function display(){
		$args = array();
		require_once GLOBAL_TEMPLATE . 'account/partials/favorite-xout-list.php';
	}
}

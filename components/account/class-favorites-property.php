<?php
class Favorites_Property extends Account_Dashboard{
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
		//add_filter( 'content_favorite', array($this,'controller'),10, 1 );
		add_filter( 'dashboard_content_favorites', array($this,'controller'),10, 1 );
	}

	public function get_dashboard_page(){
		if( parent::get_instance()->get_dashboard_page() ){
			return parent::get_instance()->get_dashboard_page();
		}
	}

	public function url(){
		if( $this->get_dashboard_page() ){
			return get_permalink($this->get_dashboard_page()->ID).'favorites';
		}
	}

	public function controller($args){
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
				$this->get_favorites_property();
			break;
		}
	}

	public function get_favorites_property(){
		$fav = $this->get_db_favorites();

		if( count($fav) > 0 && $fav ){

			$data 				= array();
			$property			= array();
			$data_properties	= array();
			$res				= array();

			foreach($fav as $key_db => $val_db){
				$data_property 	= unserialize($val_db->meta_value);
				$source 		= $data_property['feed'];
				$properties 	= apply_filters('hook_favorites_property_' . $source, $data_property);

				if(
					isset($properties)
				){
					$res = array_merge( (array)$properties, array( 'source' => $source ) );
				}else{
					$res = array( 'result' => 'fail' );
				}

				if( isset($res) ){
					$property[] = $res;
					\MD\Property::get_instance()->set_properties($property,'crm');
				}else{
					$property[] = (object)array(
						'property-id' => $val_db->meta_value,
						'message'=> ' Property Id # '.$val_db->meta_value
					);
				}
			}
			$col = 4;
			require_once GLOBAL_TEMPLATE . 'account/partials/favorite-list.php';
		}else{
			return false;
		}
	}

	public function get_db_favorites(){
		global $wpdb;
		$user_account = wp_get_current_user();
		$query = "SELECT * FROM $wpdb->usermeta	WHERE user_id = {$user_account->ID} AND meta_key LIKE '%save-property%'";
		return $wpdb->get_results( $query, OBJECT );
	}
}

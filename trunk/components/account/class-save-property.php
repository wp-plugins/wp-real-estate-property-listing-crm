<?php
//remove
class Save_Property{
	protected static $instance = null;
	public $plugin_name;
	public $version;
	public $user_current_id;
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
		$this->user_current_id = get_current_user_id();
	}

	public function get_db_favorites(){
		global $wpdb;

		$query = "SELECT * FROM $wpdb->usermeta
					WHERE user_id = $this->user_current_id
						AND meta_key LIKE '%save-property%'";
		return $wpdb->get_results( $query, OBJECT );
	}

	public function get_db_xout(){
		global $wpdb;

		$query = "SELECT * FROM $wpdb->usermeta
					WHERE user_id = $this->user_current_id
						AND meta_key LIKE '%xout-property%'";
		return $wpdb->get_results( $query, OBJECT );
	}

	public function template_favorites(){
		$template = GLOBAL_TEMPLATE . 'account/partials/favorites.php';

		// hook filter, incase we want to just use hook
		if( has_filter('shortcode_account_favorites') ){
			$template = apply_filters('shortcode_account_favorites', $path);
		}
		return $template;
	}

	public function get_favorites_property(){
		return $this->get_db_saved_properties('favorites');
	}

	public function template_xout(){
		$template = GLOBAL_TEMPLATE . 'account/partials/xout.php';

		// hook filter, incase we want to just use hook
		if( has_filter('shortcode_account_xout') ){
			$template = apply_filters('shortcode_account_xout', $path);
		}
		return $template;
	}

	public function get_xout_property(){
		return $this->get_db_saved_properties('xout');
	}

	public function get_db_saved_properties($saved = null){
		switch($saved){
			case 'favorites':
				$db = $this->get_db_favorites();
			break;
			case 'xout':
				$db = $this->get_db_xout();
			break;
		}
		if( count($db) > 0 && $db ){

			$data 				= array();
			$property			= array();
			$data_properties	= array();
			$res				= array();

			foreach($db as $key_db => $val_db){
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
				}else{
					$property[] = (object)array(
						'property-id' => $val_db->meta_value,
						'message'=> ' Property Id # '.$val_db->meta_value
					);
				}
			}

			return $property;
		}else{
			return false;
		}
	}
}

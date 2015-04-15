<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * A Class to store data from the api
 * Uses wordpress option table
 * wrapper for options
 * @see http://codex.wordpress.org/Option_Reference
 * */
class DB_Store{
	protected static $instance = null;

	protected $option_prefix 			= 'db_store_';
	protected $option_properties_prefix = 'db_store_property';

	public function __construct(){
		/*add_action('init', array($this,'add_reset_cache_rewrite_rule'));
		add_filter('query_vars',array($this,'add_reset_cache_url'));
		add_action('parse_request',array($this,'parse_request_reset_cache'));*/
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

	public function get_option_prefix(){
		return $this->option_prefix;
	}

	public function get_option_properties_prefix(){
		return $this->option_properties_prefix;
	}

	public function get_option_prefix_like(){
		global $wpdb;
		$sql = "SELECT * FROM $wpdb->options WHERE option_name like '%".$this->get_option_prefix()."%'";
		return $wpdb->get_results($sql);
	}

	public function get_option_prefix_properties(){
		global $wpdb;
		$sql = "SELECT * FROM $wpdb->options WHERE option_name like '%".$this->get_option_properties_prefix()."%'";
		return $wpdb->get_results($sql);
	}

	public function reset_db_store(){
		global $wpdb;

		$get_data = $this->get_option_prefix_like();
		if( count($get_data) > 0 ){
			foreach($get_data as $key => $val){
				update_option($val->option_name,null);
			}
		}
	}

	public function reset_db_store_properties(){
		global $wpdb;

		$get_data = $this->get_option_prefix_properties();
		if( count($get_data) > 0 ){
			foreach($get_data as $key => $val){
				update_option($val->option_name,null);
			}
		}
	}

	public function get($name){
		$option_name = $this->get_option_prefix() . $name;
		return get_option($option_name);
	}

	public function put($name, $value){
		$option_name = $this->get_option_prefix() . $name;
		return update_option($option_name, $value);
	}

	public function del($name){
		$option_name = $this->get_option_prefix() . $name;
		return delete_option($option_name);
	}

	public function add_reset_cache_url($query_vars){
		/*$query_vars[] = 'masterdigm-reset-cache';
		return $query_vars;*/
	}

	public function add_reset_cache_rewrite_rule(){
		//add_rewrite_rule('masterdigm-reset-cache.php$', 'index.php?masterdigm-reset-cache=1', 'top');
	}

	public function parse_request_reset_cache($query){
		/*if ( array_search( 'masterdigm-reset-cache', $query->query_vars ) ) {
			\DB_Store::get_instance()->reset_db_store_properties();
			update_option('log_crm_'.date('m.d.y.g.i.a'),array($_SERVER,$_REQUEST));
			header('Content-Type: application/json');
			$data = array('response'=>'OK','return'=>true);
			echo json_encode($data);
		}
		return;*/
	}
}

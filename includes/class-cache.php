<?php
/**
 * Cache
 *
 * This will use to cache data from api.
 * - it cache the method get_properties, actually its the search data we cache
 * so the next time a user search for the same property, we will just serve the api result
 * - the location or the marketing coverage of the client will be cache, these are the autocomplete
 * type in the search location.
 *
 * @since 1.0.0
 * @package    Masterdigm_API
 * */
class Masterdigm_Cache {
	protected static $instance = null;
	public $obj_phpfastcache;
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

	public function __construct(){

	}

	public function md_wp_parse_query(){
		add_action('init', array($this,'add_reset_cache_rewrite_rule'));
		add_filter('query_vars',array($this,'add_reset_cache_url'));
		add_action('pre_get_posts',array($this,'parse_request_reset_cache'));
	}

	public function cache_folder(){
		$path = wp_upload_dir();
		$cache_path = $path['basedir'] . '/cache';
		return $cache_path;
	}

	public function init(){
		$cache_path = $this->cache_folder();

		if ( !file_exists( $cache_path ) ) {
			mkdir( $cache_path, 0777 );
		}

		phpFastCache::setup("storage","files");
		phpFastCache::setup("path", $cache_path);

		$this->obj_phpfastcache = phpFastCache();
	}

	public function stats(){
		return $this->obj_phpfastcache->stats();
	}

	public function set($name, $value, $time = 604800){
		$this->obj_phpfastcache->set($name, $value, $time);
	}

	public function get($name){
		return $this->obj_phpfastcache->get($name);
	}

	public function del($name){
		return $this->obj_phpfastcache->delete($name);
	}

	public function clean(){
		return $this->obj_phpfastcache->clean();
	}

	public function add_reset_cache_url($query_vars){
		$query_vars[] = 'masterdigm-reset-cache';
		return $query_vars;
	}

	public function add_reset_cache_rewrite_rule(){
		add_rewrite_rule( 'masterdigm-reset-cache/(.*)/?', 'index.php?masterdigm-reset-cache=$matches[1]', 'top' );
	}

	public function parse_request_reset_cache($query){
		global $wp;
        if (isset($wp->request) && $wp->request == 'masterdigm-reset-cache'){
			$this->clean();
			update_option('log_crm_'.date('m.d.y.g.i.a'),array($_SERVER,$_REQUEST));
			header('Content-Type: application/json');
			$data = array('response'=>'OK','return'=>true);
			die( json_encode($data) );
		}
	}
}

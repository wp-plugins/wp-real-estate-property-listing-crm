<?php
class Social_API {

	protected static $instance = null;

	public $prefix;

	public $slug;
	public $array_error = array();
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
		$this->prefix = 'social-api';
		$this->slug = 'admin.php?page=md-api-social-api';
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {
		$plugin_name = \Masterdigm_API::get_instance()->get_plugin_name();

		add_submenu_page(
			$plugin_name,
			'Social API',
			'Social API',
			'manage_options',
			'md-api-social-api',
			array( $this, 'controller' )
		);
	}

	public function setError($array_error){
		$this->array_error = $array_error;
	}

	public function getError(){
		return $this->array_error;
	}

	public function controller(){
		$request = '';
		if( isset($_REQUEST['action']) ){
			$request = sanitize_text_field($_REQUEST['action']);
		}
		$obj_admin_util = new Masterdigm_Admin_Util;
		switch($request){
			case 'update_api':
				$error 		= array();
				$has_error 	= false;
				$post 		= $_POST;
				$prefix = $this->prefix;
				update_option($prefix,$post['socialapi']);
				\Masterdigm_Admin_Util::get_instance()->redirect_to($this->slug);
			break;
			default:
				$this->displayIndex();
			break;
		}
	}

	/**
	 * list the data
	 * */
	public function displayIndex(){
		$obj = $this->get_instance();
		require_once( plugin_dir_path( __FILE__ ) . 'view/add.php' );
	}

	public function getSocialApi(){
		$prefix 	= $this->prefix;
		if( isset($_POST['socialapi']) ){
			$social_api = get_option($prefix,$_POST['socialapi']);
			return $social_api;
		}
	}

	public function getSocialApiByKey($api,$key){
		$prefix 	= $this->prefix;
		if( isset($_POST['socialapi']) ){
			$social_api = get_option($prefix,$_POST['socialapi']);
			return trim($social_api[$api][$key] != '') ? $social_api[$api][$key]:'';
		}
	}
}

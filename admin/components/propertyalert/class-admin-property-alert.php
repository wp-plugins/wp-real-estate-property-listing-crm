<?php
class Property_Alert_Admin {

	protected static $instance = null;
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
		$this->prefix = 'propertyalert-admin';
		$this->slug = 'admin.php?page=md-api-property-alert';
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
			'Property Alert API',
			'Property Alert API',
			'manage_options',
			'md-api-property-alert',
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
		$request 	= '';
		$prefix 	= $this->prefix;
		$post 		= $_POST;
		if( isset($_REQUEST['action']) ){
			$request = sanitize_text_field($_REQUEST['action']);
		}
		$obj_admin_util = new Masterdigm_Admin_Util;
		switch($request){
			case 'update':
				$error 		= array();
				$has_error 	= false;
				update_option('success-unsubscribe',$post['success-unsubscribe']);
				update_option('fail-unsubscribe',$post['fail-unsubscribe']);
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
		$obj 				= $this->get_instance();
		$editor_settings 	= array(
			'teeny'			=>	true,
			'textarea_rows' => 	5,
			'media_buttons' => 	false
		);
		$success_editor		= $this->_success_content($editor_settings);
		$fail_editor		= $this->_fail_content($editor_settings);
		require_once( plugin_dir_path( __FILE__ ) . 'view/index_page.php' );
	}

	private function _success_content($settings = array()){
		$content = $this->display_success();
		return array(
			'content' 	=> $content,
			'editor_id' => 'success-unsubscribe',
			'settings' 	=> $settings,
		);
	}

	private function _fail_content($settings = array()){
		$content = $this->display_fail();
		return array(
			'content' 	=> $content,
			'editor_id' => 'fail-unsubscribe',
			'settings' 	=> $settings,
		);
	}

	public function display_success(){
		return get_option('success-unsubscribe');
	}

	public function display_fail(){
		return get_option('fail-unsubscribe');
	}
}

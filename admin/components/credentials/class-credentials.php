<?php
class API_Credentials{
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
		$this->slug = 'admin.php?page='.\Masterdigm_API::get_instance()->get_plugin_name();
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
	}

	public function setError($array_error){
		$this->array_error = $array_error;
	}

	public function getError(){
		return $this->array_error;
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {
		$plugin_name = \Masterdigm_API::get_instance()->get_plugin_name();
		add_menu_page(
			'Masterdigm',
			'Masterdigm',
			'manage_options',
			$plugin_name,
			array( $this, 'controller' ),
			'',
			21
		);
		add_submenu_page(
			$plugin_name,
			'Settings',
			'Settings',
			'manage_options',
			'md-api-plugin-settings',
			array( $this, 'settings_controller' )
		);
	}

	public function settings_controller(){
		\Settings_API::get_instance()->controller();
	}

	public function controller($request = null){
		$request = '';
		if( isset($_REQUEST['action']) ){
			$request = sanitize_text_field($_REQUEST['action']);
		}
		switch($request){
			case 'update_api':
				$error 		= array();
				$has_error 	= false;
				$post 		= $_REQUEST;

				if(
					$post['property_data_feed'] == 'crm'
					&& ( $post['api_key'] == '' || $post['api_token'] == '')
				){
					$has_error = true;
					$error[] = 'Please provide property CRM api token / key';
				}

				if(
					$post['property_data_feed'] == 'mls'
					&& ( $post['mls_api_key'] == '' || $post['mls_api_token'] == '')
				){
					$has_error = true;
					$error[] = 'Please provide property MLS api token / key';
				}

				if(
					$post['property_data_feed'] == '0'
					&& ( $post['mls_api_key'] == '' || $post['mls_api_token'] == '')
				){
					$has_error = true;
					$error[] = 'You have provided MLS api and token key, but you need to choose data feed dropdown to MLS';
				}

				if(
					$post['property_data_feed'] == '0'
					&& ( $post['api_key'] == '' || $post['api_token'] == '')
				){
					$has_error = true;
					$error[] = 'You have provided CRM api and token key, but you need to choose data feed dropdown to CRM';
				}

				if(
					$post['property_data_feed'] == '0' &&
					$post['api_key'] == '' &&
					$post['api_token'] == '' &&
					$post['mls_api_key'] == '' &&
					$post['mls_api_token'] == ''
				){
					$has_error = true;
					$error[] = 'Please provide API credentials';
				}

				if(
					$post['property_data_feed'] == '0' &&
					($post['api_key'] != '' ||
					$post['api_token'] != '' ||
					$post['mls_api_key'] != '' ||
					$post['mls_api_token'] != '')
				){
					$has_error = true;
					$error[] = 'Please choose data to feed';
				}

				if( $has_error ){
					$this->setError($error);
					$this->display_index();
				}else{
					$this->post_update_api($post);
					// reset cache
					\DB_Store::get_instance()->reset_db_store();
					\Masterdigm_Admin_Util::get_instance()->redirect_to($this->slug);
				}
			break;
			default:
				$this->display_index();
			break;
		}
	}

	/**
	 * display the main index view
	 * */
	public function display_index() {
		require_once( plugin_dir_path( __FILE__ ) . 'view/index.php' );
	}

	public function post_update_api($post){
		update_option( 'mls_api_key', $post['mls_api_key'] );
		update_option( 'mls_api_token', $post['mls_api_token'] );
		update_option( 'api_key', $post['api_key'] );
		update_option( 'api_token', $post['api_token'] );
		update_option( 'broker_id', $post['broker_id'] );
		update_option( 'user_id', $post['user_id'] );
		update_option( 'property_data_feed', $post['property_data_feed'] );
	}
}

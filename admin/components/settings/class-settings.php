<?php
class Settings_API {

	protected static $instance = null;

	public $prefix;

	public $slug;

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

	public function get_slug(){
		return 'admin.php?page=md-api-plugin-settings';
	}

	public function get_option_prefix(){
		return 'plugin-settings';
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
			'Settings',
			'Settings',
			'manage_options',
			'md-api-plugin-settings',
			array( $this, 'controller' )
		);
	}

	public function controller(){
		$request = '';
		if( isset($_REQUEST['action']) ){
			$request = sanitize_text_field($_REQUEST['action']);
		}

		$obj_admin_util = new Masterdigm_Admin_Util;
		$obj = $this->get_instance();
		switch($request){
			case 'update_api':
				$post = $_POST;
				$this->post_update_api($this->get_option_prefix(), $post);
				\Masterdigm_Admin_Util::get_instance()->redirect_to($this->get_slug());
			break;
			case 'delete_all_cache':
				\DB_Store::get_instance()->reset_db_store();
				\Masterdigm_Admin_Util::get_instance()->redirect_to(admin_url());
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
		$obj_admin_util 			= new Masterdigm_Admin_Util;
		$show_popup_choose 			= $this->_show_popup_choose();
		$show_popup_close_button 	= $this->_show_popup_close_button();
		$show_popup_after 			= $this->_show_popup_after();
		$search_status 				= $this->_show_fields_status();

		$show_default_property_name	= $this->_show_default_property_name();
		if( $this->showpopup_settings('clicks') ){
			$default_click 	= $this->showpopup_settings('clicks');
		}else{
			$default_click 	= SHOW_POPUP;
		}

		$obj = new Settings_API;

		require_once( plugin_dir_path( __FILE__ ) . 'view/index.php' );

	}

	public function post_update_api($prefix, $post){
		update_option($prefix,$post['setting']);
	}

	public function _show_fields_status(){
		$status = array();
		$fields = \CRM_Account::get_instance()->get_fields();

		if( $fields->fields->status ){
			foreach($fields->fields->status as $key=>$val){
				$status[$key] = $val;
			}
		}
		return $status;
	}

	private function _show_popup_choose(){
		return array(
			'1' => 'Turn on, show popup after certain clicks?',
			'0' => 'Turn off, do not show popup after certain clicks?',
		);
	}

	private function _show_popup_close_button(){
		return array(
			'1' => 'No',
			'0' => 'Yes',
		);
	}

	private function _show_popup_after(){
		return array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
		);
	}

	private function _show_default_property_name(){
		return array(
			'address' => 'Address',
			'tagline' => 'Tag Line',
		);
	}

	public function showpopup_settings($key){
		return $this->getSettingsGeneralByKey('showpopup',$key);
	}

	public function show_click(){
		return $this->getSettingsGeneralByKey('showpopup','clicks');
	}

	public function getSettingsGeneralByKey($setting_key, $key){
		$prefix 	= $this->get_option_prefix();
		$settings 	= get_option($prefix);
		if(
			$settings &&
			isset($settings[$setting_key]) &&
			isset($settings[$setting_key][$key]) &&
			trim(isset($settings[$setting_key][$key]) != '')
		){
			return $settings[$setting_key][$key];
		}
		return false;
	}
}

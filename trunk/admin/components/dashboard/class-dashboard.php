<?php
/**
 * Plugin class.
 * Class for admin dashboard
 * @see http://codex.wordpress.org/Post_Types
 *
 *
 *
 * @package MD_CPT
 * @author  Masterdigm / Allan
 */
class Admin_Dashboard {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
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
		if( current_user_can('activate_plugins') ){
			add_action('wp_dashboard_setup', array( $this, 'add_dashboard_widget' ), 1000 );
		}
		//add_action('admin_footer', array($this,'footer_modal'), 100 );
	}

	public function settings_controller(){
		\Settings_API::get_instance()->controller();
	}

	public function controller(){
		$request = sanitize_text_field($_REQUEST['action']);
		switch($request){
			case 'delete_all_cache':
				\Property_Cache::get_instance()->deleteCacheDB($_REQUEST['option_key']);
				\Masterdigm_Admin_Util::get_instance()->redirect_to('admin.php?page=md-api-plugin-settings');
			break;
			default:
				$this->display_index();
			break;
		}
	}

	public function display_index($post, $callback_args){
		$data['current_site_id'] = get_current_blog_id();
		$data['cache_keywords']  = \Property_Cache::get_instance()->getDefinedKeyword();
		$data['get_cache']  	 = \Property_Cache::get_instance()->getLikeCacheOptionKey('');
		extract( $data );
		require_once( plugin_dir_path( __FILE__ ) . 'view/cache-property.php' );
	}

	public function add_dashboard_widget(){
		wp_add_dashboard_widget(
			'dashboard_cache_property_widget',
			'Reset Cache',
			array($this,'display_index')
		);
	}

	public function footer_modal(){
		include_once( PLUGIN_ADMIN_VIEW . 'modal.php');
		$favorite = \Subscriber_Properties::get_instance()->get_db_favorites();
		$xout = \Subscriber_Properties::get_instance()->get_db_xout();

		echo '<div class="galleria"></div>';
	}
}

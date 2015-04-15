<?php
class Account_Registered{
	protected static $instance = null;
	public $plugin_name;
	public $version;
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

	}

	public function get_default_template($template = null){
		if( is_null($template) ){
			$template = GLOBAL_TEMPLATE . 'account/main.php';
		}
		// hook filter, incase we want to just use hook
		if( has_filter('shortcode_account_page') ){
			$template = apply_filters('shortcode_account_page', $path);
		}
		return $template;
	}

}

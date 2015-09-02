<?php
/**
 * List search result
 * */
class Search_Result_List{
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	public function __construct(){
		add_filter("view_display_content_list", array($this,'init'), 10, 1);
	}

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

	public function load_template(){
		$template_part = \MD_Template::get_instance()->load_template('searchresult/threeviews/map/fullscreen_modal.php');
		if( $template_part ){
			require $template_part;
		}
		exit();
	}

	public function init($atts = array()){
		add_action( 'template_redirect', array($this,'load_template'));
	}

}

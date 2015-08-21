<?php
/**
 * Photo search result
 * */
class Search_Result_Photo{
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	public function __construct(){
		add_filter("view_display_content_photo", array($this,'init'), 10, 1);
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

	public function init($atts = array()){
		$template_part = \MD_Template::get_instance()->load_template('list/default/list-default.php');
		if( $template_part ){
			extract($atts);
			require $template_part;
		}
	}

}

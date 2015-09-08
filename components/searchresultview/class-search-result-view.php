<?php
class Search_Result_View{
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	public function __construct(){

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

	public function view(){
		$current_view = '';

		//over-ride current default route / view
		if( has_filter('view_search_result') ){
			$current_view = apply_filters('view_search_result', $view);
		}

		if( isset($_REQUEST['view']) ){
			$current_view = sanitize_text_field($_REQUEST['view']);
		}elseif( isset($_GET['view']) ){
			$current_view = sanitize_text_field($_GET['view']);
		}elseif( isset($_POST['view']) ){
			$current_view = sanitize_text_field($_POST['view']);
		}

		if( $current_view == '' ){
			return false;
		}else{
			return $current_view;
		}
	}

	/**
	 * controller
	 * */
	public function init($atts){
		$view = $this->view();
		if( has_filter("view_display_content_{$view}") ){
			apply_filters("view_display_content_{$view}", $atts);
		}
	}
}

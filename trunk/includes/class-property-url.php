<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * rewrite property url
 * */
class Property_URL{

	protected $page_property_title = 'Property';

	protected static $instance = null;

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
		add_action( 'init', array( $this, 'load_rewrite_property' ) );
	}

	/**
	 * rewrite the property page to add query string such as address
	 * */
	public function load_rewrite_property(){
		add_rewrite_rule(
			'^property/([^/]*)/?',
			'index.php?pagename='.$this->page_property_title.'&url=$matches[1]',
			'top'
		);
		add_rewrite_tag('%url%', '([^&]+)');
	}

	/**
	 * @TODO: this should be in the settings,
	 * to choose which default page to display as search result from search form
	 * */
	public function get_search_page_default(){
		return $this->get_permalink_property('Search Properties');
	}

	/**
	 * setup the property url for single
	 * two options one is pretty link and one is ugly link
	 * @since    1.0.0
	 *
	 * @param    int    $matrix_id    matrix id of the property.
	 * @param    string | alpha numeric    $address    address of the property.
	 *
	 * @return url
	 * */
	public function get_property_url($url){
		if( get_option('permalink_structure') ){
			// pretty url
			// permalink structure custom
			return $this->get_permalink_property( $this->page_property_title ) ."$url";
		}else{
			// ugly
			// uses query var
			return $this->get_permalink_property( $this->page_property_title ) . "&url=$url";
		}
	}

	/**
	 * get the permalink structure of the current post by title
	 * @since	1.0.0
	 *
	 * @param	string	@page_title the title of the post that is type page
	 * 								currently this is use in function get_property_url
	 * 								the sole purpose is to setup the url of the single page
	 * 								mostly this is use in the search page property
	 * @return get_permalink | string
	 * */
	public function get_permalink_property($page_title){
		$page = get_page_by_title($page_title);
		if( $page ){
			return get_permalink($page->ID);
		}
	}

}

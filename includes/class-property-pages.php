<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * create property related page content
 * */
class Property_Page{

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

	public function __construct(){}

	/**
	 * Create Search Properties page
	 * in this plugin we are going to create two page
	 * 1) Search Properties - hold the list of all properties
	 * 2) Property - hold the single page for property
	 *
	 * @since 1.0.0
	 *
	 * @return object | resource
	 * */
	public function create_property_page(){
		$current_user 	= wp_get_current_user();
		$get_user_id 	= $current_user->ID;
		if( !get_page_by_title('Property') ){
			$shortcode = '[md_sc_search_property_form template="searchform/search-form-minimal.php"]';
			$shortcode .= '<p></p>';
			$shortcode .= '[md_single_properties template="single/single-property-page.php" template_carousel="carousel/html-galleria.php" show_nearby_prop="true" nearby_prop_col="4" ]';
			$post = array(
			  'post_title'    => 'Property',
			  'post_content'  => $shortcode,
			  'post_status'   => 'publish',
			  'post_author'   => $get_user_id,
			  'post_type'	  => 'page',
			);
			wp_insert_post( $post );
		}
		if( !get_page_by_title('State') ){
			$shortcode = '[md_list_properties_by_breadcrumb col="4" show_child="true" infinite="true" ]';
			$post = array(
			  'post_title'    => 'State',
			  'post_content'  => $shortcode,
			  'post_status'   => 'publish',
			  'post_author'   => $get_user_id,
			  'post_type'	  => 'page',
			);
			wp_insert_post( $post );
		}
		if( !get_page_by_title('County') ){
			$shortcode = '[md_list_properties_by_breadcrumb col="4" show_child="true" infinite="true" ]';
			$post = array(
			  'post_title'    => 'County',
			  'post_content'  => $shortcode,
			  'post_status'   => 'publish',
			  'post_author'   => $get_user_id,
			  'post_type'	  => 'page',
			);
			wp_insert_post( $post );
		}
		if( !get_page_by_title('City') ){
			$shortcode = '[md_list_properties_by_breadcrumb col="4" show_child="true" infinite="true" ]';
			$post = array(
			  'post_title'    => 'City',
			  'post_content'  => $shortcode,
			  'post_status'   => 'publish',
			  'post_author'   => $get_user_id,
			  'post_type'	  => 'page',
			);
			wp_insert_post( $post );
		}
		if( !get_page_by_title('Community') ){
			$shortcode = '[md_list_properties_by_breadcrumb col="4" show_child="true" infinite="true" ]';
			$post = array(
			  'post_title'    => 'community',
			  'post_content'  => $shortcode,
			  'post_status'   => 'publish',
			  'post_author'   => $get_user_id,
			  'post_type'	  => 'page',
			);
			wp_insert_post( $post );
		}

		if( !get_page_by_title('Search Properties') ){
			$shortcode = '[md_sc_search_property_form template="searchform/search-form-minimal.php"]';
			$shortcode .= '<p></p>';
			$shortcode .= '[md_search_property_result template="searchresult/search-result.php" col="'.MD_DEFAULT_GRID_COL.'" infinite="true" ]';
			$post = array(
			  'post_title'    => 'Search Properties',
			  'post_content'  => $shortcode,
			  'post_status'   => 'publish',
			  'post_author'   => $get_user_id,
			  'post_type'	  => 'page',
			);
			wp_insert_post( $post );
		}

		if( !get_page_by_title('Un Subscribe') ){
			$shortcode = '[md_sc_unsubscribe_api]';
			$post = array(
			  'post_title'    => 'Un Subscribe',
			  'post_name'     => 'unsubscribe',
			  'post_content'  => $shortcode,
			  'post_status'   => 'publish',
			  'post_author'   => $get_user_id,
			  'post_type'	  => 'page',
			);
			wp_insert_post( $post );
		}

		\Account_Dashboard::get_instance()->create_my_account_page();
	}


}

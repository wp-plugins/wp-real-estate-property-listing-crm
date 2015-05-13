<?php
namespace mls;
/**
 * Use as to handle templating for various views on each template
 * */
class Template_Property{
	protected static $instance = null;

	public function __construct(){
		add_action('template_more_details_mls',array($this,'more_details'),10,1);
		add_action('template_carousel_mls',array($this,'display_carousel'),10,1);
		add_action('template_photos_mls',array($this,'photo_tab'),10,1);
		add_action('hook_favorites_property_mls',array($this,'saved_properties'),10,1);
	}

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

	public function saved_properties($data_properties){
		$properties = \mls\Properties::get_instance()->get_property_by_id($data_properties['id']);
		return $properties;
	}

	public function display_carousel($atts){
		$template =  MLS_VIEW . 'single/partials/carousel/html-galleria.php';

		if( file_exists($template) ){
			require_once $template;
		}
	}

	public function more_details($atts){
		global $have_properties;

		if(have_properties()){
			$template =  MLS_VIEW . 'single/single-property-more-details.php';
			if( file_exists($template) ){
				if( has_filter('mls_more_details_single') ){
					$template = apply_filters('mls_more_details_single',$path, $atts);
				}
				require_once $template;
			}
		}
	}

	public function photo_tab($atts){
		global $have_properties;

		if(have_properties()){
			$template =  MLS_VIEW . 'single/partials/photos/photos.php';
			if( file_exists($template) ){
				if( has_filter('mls_photo_tab_single') ){
					$template = apply_filters('mls_photo_tab_single',$path, $atts);
				}
				require_once $template;
			}
		}
	}
}

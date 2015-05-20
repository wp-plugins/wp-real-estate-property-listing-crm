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
		add_action('next_prev_mls',array($this,'next_prev_mls'),10,1);
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

	public function next_prev_mls(){
		$next_prev_array = array();
		if( have_properties() ){

			$property = get_single_data();

			$search_data	= array();
			$communityid 	= '';
			$location 		= '';
			if( $property['community'] && isset($property['community']->community_id) ){
				$communityid = $property['community']->community_id;
			}else{
				$location = $property['property']->PostalCode;
			}

			$search_data['countyid'] 		= '';
			$search_data['stateid'] 		= '';
			$search_data['countyid'] 		= '';
			$search_data['countryid'] 		= '';
			$search_data['communityid'] 	= $communityid;
			$search_data['cityid'] 			= '';
			$search_data['location'] 		= $location;
			$search_data['bathrooms'] 		= '';
			$search_data['bedrooms'] 		= '';
			$search_data['transaction'] 	= '';
			$search_data['property_type'] 	= '';
			$search_data['property_status'] = '';
			$search_data['min_listprice'] 	= '';
			$search_data['max_listprice'] 	= '';

			$properties = \MLS_Property::get_instance()->get_properties($search_data);

			$total_properties = $properties->total;
			if( $total_properties >= 10 ){
				//make the limit 10;
				$search_data['limit'] = $total_properties;
			}

			$next_prev = \MLS_Property::get_instance()->get_properties($search_data);

			if( isset($next_prev->data) ){
				foreach($next_prev->data as $key => $val){
					$next_prev_array[$val->id] = $val->displayUrl();
				}
			}

			$current_property 	= get_single_data();
			$current_id			= $current_property['property']->ListingId;
			$get_current_key	= array_search($current_id,array_keys($next_prev_array));
			$next_url = '#';
			$prev_url = '#';

			$next_prev_keys = array_keys($next_prev_array);
			$get_next_key = 0;
			if( $next_prev_keys > $total_properties ){
				$get_next_key	= ($get_current_key + 1);
			}

			if( isset($next_prev_keys[$get_next_key]) ){
				$next_key = $next_prev_keys[$get_next_key];
				if( isset($next_key) ){
					$next_url = $next_prev_array[$next_key];
				}
			}else{
				$next_key = $next_prev_keys[0];
				if( isset($next_key) ){
					$next_url = $next_prev_array[$next_key];
				}
			}

			$next_prev_keys = array_keys($next_prev_array);
			$get_prev_key = 0;
			if( $get_current_key > 0 ){
				$get_prev_key = ($get_current_key - 1);
			}
			$prev_key = $next_prev_keys[$get_prev_key];
			if( isset($prev_key) && $get_current_key > 0 ){
				$prev_url = $next_prev_array[$prev_key];
			}else{
				$total_properties -= 1;
				if(isset($next_prev_keys[$total_properties])){
					$prev_key = $next_prev_keys[$total_properties];
					$prev_url = $next_prev_array[$prev_key];
				}
			}


			$show_next_prev_array = array();
			if( $total_properties == 0 && $get_current_key == 0 ){
				$show_next_prev_array = array(
					'next_url' => $next_url,
					'show_next_url' => false,
					'prev_url' => '#',
					'show_prev_url' => false
				);
			}else{
				$show_next_prev_array = array(
					'next_url' => $next_url,
					'show_next_url' => true,
					'prev_url' => $prev_url,
					'show_prev_url' => true
				);
			}
			return $show_next_prev_array;
		}
		return false;
	}
}

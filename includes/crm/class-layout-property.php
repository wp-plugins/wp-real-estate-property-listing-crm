<?php
namespace crm;
/**
 * Use as to handle templating for various views on each template
 * */
class Layout_Property{
	protected static $instance = null;

	public function __construct(){
		add_action('template_more_details_crm',array($this,'more_details'),10,1);
		add_action('hook_favorites_property_crm',array($this,'saved_properties'),10,1);
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

	public function get_carousel_template_crm($atts){
		$photos = get_single_property_photos($atts);
		$template_carousel = \MD_Template::get_instance()->load_template($atts['template_carousel']);
		if( $template_carousel ){
			if( has_filter('crm_template_carousel') ){
				$template_carousel = apply_filters('crm_template_carousel',$atts);
			}
			require_once $template_carousel;
		}
	}

	public function get_template_more_details_crm($atts){
		$template =  CRM_VIEW . 'single/single-property-more-details.php';
		if( file_exists($template) ){
			if( has_filter('crm_more_details_single') ){
				$template = apply_filters('crm_more_details_single',$path, $atts);
			}
			require_once $template;
		}
	}

	public function next_prev(){
		$next_prev_array = array();
		if( have_properties() ){

			$property = have_properties();

			$search_data['countyid'] 		= 0;
			$search_data['stateid'] 		= 0;
			$search_data['countryid'] 		= 0;
			$search_data['cityid'] 			= 0;
			$search_data['zip'] 			= '';
			$search_data['communityid'] 	= $property->communityid;
			$search_data['bathrooms'] 		= '';
			$search_data['bedrooms'] 		= '';
			$search_data['transaction'] 	= $property->transaction_type;
			$search_data['property_type'] 	= $property->property_type;
			$search_data['property_status'] = $property->property_status;
			$search_data['min_listprice'] 	= 0;
			$search_data['max_listprice'] 	= 0;
			$search_data['orderby'] 		= '';
			$search_data['order_direction']	= '';

			$properties = \crm\Properties::get_instance()->get_properties($search_data);

			$total_properties = $properties->total;
			if( $total_properties >= 10 ){
				//make the limit 10;
				$search_data['limit'] = $total_properties;
			}

			$next_prev = \crm\Properties::get_instance()->get_properties($search_data);

			if( isset($next_prev->data) ){
				foreach($next_prev->data as $key => $val){
					$next_prev_array[$val->id] = $val->displayUrl();
				}
			}

			$current_property 	= get_single_data();
			$current_id			= $current_property['property']->id;
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

	public function list_properties(){
	}

	public function single_property(){

	}

	public function nearby_properties(){
	}

	public function saved_properties($data_properties){
		$properties =  \crm\Properties::get_instance()->get_property($data_properties['id'],'');
		return $properties;
	}

	public function more_details($atts){
		global $have_properties;

		if(have_properties()){
			$template =  CRM_VIEW . 'single/single-property-more-details.php';
			if( file_exists($template) ){
				if( has_filter('crm_more_details_single') ){
					$template = apply_filters('crm_more_details_single',$path, $atts);
				}
				require_once $template;
			}
		}
	}

}

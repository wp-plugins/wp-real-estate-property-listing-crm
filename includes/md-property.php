<?php
/**
 * Masterdigm Property Functions
 *
 * @author 		Allan / Masterdigm
 * @category 	Core
 * @package 	Masterdigm Property/Functions
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function md_display_nearby_property($atts){
	if( have_properties() ){
		$property = have_properties();
		\helpers\Text::print_r_array($property);
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
		$search_data['limit']			= 11;

		if( has_filter('nearby_search_data') ){
			$search_data = apply_filters('nearby_search_data',$search_data);
		}

		//$properties = apply_filters('property_nearby_property_' . md_get_source(), $properties);

		$properties = \CRM_Property::get_instance()->get_properties($search_data);
		$total_properties = $properties->total;

		$atts['infinite'] = false;
		if( $total_properties >= 10  ){
			$atts['infinite'] = true;
		}

		\MD\Property::get_instance()->set_properties($properties,'crm');
		$template = GLOBAL_TEMPLATE . 'list/default/list-default.php';

		// hook filter, incase we want to just use hook
		if( has_filter('shortcode_list_property_crm') ){
			$template = apply_filters('shortcode_list_property_crm', $path);
		}

		$atts['col'] 	= $atts['short_code_nearby_col'];
		$col 			= $atts['nearby_prop_col'];

		if( isset($atts['show_nearby_prop']) && $atts['show_nearby_prop'] == true ){
			$show_sort = false;
			require_once $template;
		}
	}
}

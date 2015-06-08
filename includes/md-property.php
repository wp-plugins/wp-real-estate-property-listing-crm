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

		if( has_filter('nearby_search_data') ){
			$search_data = apply_filters('nearby_search_data',$search_data);
		}

		$properties = apply_filters('property_nearby_property_' . get_single_property_source(), get_single_data(), array('limit'=>6));
		$properties->search_keyword['limit'] = 11;
		$more_similar_homes_link = \Property_URL::get_instance()->get_search_page_default() .'?' . http_build_query($properties->search_keyword) . "\n";
		$total_properties = $properties->total;

		$atts['infinite'] = false;
		/*if( $total_properties >= 10  ){
			$atts['infinite'] = true;
		}*/

		\MD\Property::get_instance()->set_properties($properties, get_single_property_source());

		$template = GLOBAL_TEMPLATE . 'list/default/list-similar-homes.php';
		// hook filter, incase we want to just use hook
		if( has_filter('shortcode_list_property_'.get_single_property_source()) ){
			$template = apply_filters('shortcode_list_property_' . get_single_property_source(), $path);
		}

		$atts['col'] 	= $atts['short_code_nearby_col'];
		$col 			= 12;

		if( isset($atts['show_nearby_prop']) && $atts['show_nearby_prop'] == true ){
			$show_sort = false;
			require $template;
		}
	}
}

function dump($string, $exit = false){
	return \helpers\Text::print_r_array($string, $exit);
}

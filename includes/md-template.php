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

function md_global_carousel_template($atts){
	\MD_Property_Details::get_instance()->get_carousel_template($atts);
}
function next_prev(){
	\Next_Prev::get_instance()->display();
}
function md_pagination($pages, $range, $max_num_pages = null, $url = array()){
	\Pagination::get_instance()->md_pagination($pages, $range, $max_num_pages, $url);
}
function display_map_single($atts){
	\MD_Property_Details::get_instance()->single_map($atts);
}
function display_walkscore_single($atts){
	\MD_Property_Details::get_instance()->single_walkscore($atts);
}
function display_photos_single($atts){
	\MD_Property_Details::get_instance()->single_photos($atts);
}
function display_agent_details($property_data, $atts = array()){
	\MD_Property_Details::get_instance()->display_agent_box($property_data, $atts);
}
function display_property_details_left_content($atts, $additional_atts = array()){
	\MD_Property_Details::get_instance()->display_property_details_left_content($atts, $additional_atts);
}
function display_property_details_right_content($atts, $additional_atts = array()){
	\MD_Property_Details::get_instance()->display_property_details_right_content($atts, $additional_atts);
}
/**
 * redirect template to full screen
 * */
function map_fullscreen()
{
	if( \Search_Result_View::get_instance()->view() == 'map' ){
		$map_view = true;

		if( is_fullscreen() == 'y' ){
			$template_part = \MD_Template::get_instance()->load_template('searchresult/threeviews/map/fullscreen_map.php');
			if( $template_part ){
				$plugin_name 	= \Masterdigm_API::get_instance()->get_plugin_name();
				$version 	 	= \Masterdigm_API::get_instance()->get_version();
				$atts 					= array();
				$properties 			= apply_filters('search_property_result_' . DEFAULT_FEED, array());
				$source 				= DEFAULT_FEED;
				$atts['search_keyword']	= $properties->search_keyword;
				$atts['source']			= $source;
				\MD\Property::get_instance()->set_properties($properties, $source);
				$map_content = \MD_Template::get_instance()->load_template('searchresult/threeviews/map/map_index.php');
				require $template_part;
			}
			exit();
		}
	}
}

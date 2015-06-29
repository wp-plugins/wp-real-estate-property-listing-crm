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
function display_property_alert_button(){
}

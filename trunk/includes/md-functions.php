<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function isMLS(){
	return ( DEFAULT_FEED ==  'mls' ) ? true:false;
}

function isCRM(){
	return ( DEFAULT_FEED ==  'crm' ) ? true:false;
}
function remove_nonaplha($string){
	return \helpers\Text::remove_non_alphanumeric($string);
}
function _label($str_label){
	$arr_label = \MD_Template::get_instance()->label();
	if( has_filter('change_key_label') ){
		$arr_label = apply_filters('change_key_label', $arr_label);
	}
	return $arr_label[$str_label];
}
function get_search_form_price_range(){
	$arr_price_range = \MD_Search_Utility::get_instance()->get_price_range();
	// incase we want to just totally change the whole array
	if( has_filter('filter_arr_price_range') ){
		$arr_price_range = apply_filters('filter_arr_price_range', $arr_price_range);
	}
	return $arr_price_range;
}
function get_account_details(){
	return \crm\AccountEntity::get_instance()->get_account_details();
}
function get_account_fields(){
	return \crm\AccountEntity::get_instance()->get_fields();
}
function get_account_currency(){
	return \crm\AccountEntity::get_instance()->get_account_data('currency');
}
function get_account_data($data_name){
	return \crm\AccountEntity::get_instance()->get_account_data($data_name);
}
// plugin settings
function option_plugin_settings($settings = null){
	$plugin_settings = get_option('plugin-settings');
	if( $plugin_settings ){
		if( is_null($settings) ){
			return $plugin_settings;
		}else{
			return $plugin_settings[$settings];
		}
	}
	return 0;
}
function default_search_status(){
	return option_plugin_settings('search_criteria')['status'] ? option_plugin_settings('search_criteria')['status']:0;
}
function get_states_by_country(){
	return \crm\AccountEntity::get_instance()->getStatesByCountryId();
}
function get_coverage_area(){
	return \crm\AccountEntity::get_instance()->getCoverageArea();
}
function bootstrap_grid_col($col = null){
	if( !is_null($col) ){
		$col = ceil(12 / $col );
	}else{
		$col = MD_DEFAULT_GRID_COL;
	}
	return $col;
}
if( \Settings_API::get_instance()->showpopup_settings('show') == 1 ){
	function clear_cookie() {
		\Show_Popup::get_instance()->deleteShowPopup();
		session_destroy();
	}
	add_action('wp_logout', 'clear_cookie');
	function show_popup() {
		$popup_show = \Settings_API::get_instance()->showpopup_settings('clicks');
		$cookie_name = 'guest_page_view';
		$cookie = new \helpers\Cookies;
		if(
			!is_user_logged_in() &&
			is_page('property')
		){
			$get_cookie = $cookie->get($cookie_name);
			if( $get_cookie ){
				if( $get_cookie != $popup_show ){
					$cookie->set($cookie_name,($get_cookie + 1));
				}
			}else{
				$cookie->set($cookie_name,1);
			}
		}
	}
	add_action( 'wp', 'show_popup');
}
function get_default_property_name(){
	$name = \Settings_API::get_instance()->getSettingsGeneralByKey('property','name');
	if( !$name && $name == '' ){
		$name = 'address';
	}
	return $name;
}
function validateDate($date){
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') == $date;
}
function md_page_title($title, $id = null){
	global $wp_query, $get_single_property_source;
	if(
		!is_admin()
	){
		if(
			in_the_loop() &&
			is_page('country') ||
			is_page('county') ||
			is_page('state') ||
			is_page('city') ||
			is_page('community') ||
			is_page('zip')
		){
			if( DEFAULT_FEED == 'mls' || get_single_property_source() == 'mls' ){
				$location = str_replace('-',' ',get_query_var('url'));
				$location = ucwords($location);
			}elseif( DEFAULT_FEED == 'crm' || get_single_property_source() == 'crm' ){
				$location 		= '';
				$query_var   	= get_query_var('url');
				$parse_property = explode( '-', $query_var);

				unset($parse_property[0]);
				foreach($parse_property as $val){
					$location .= $val.' ';
				}
				$location = ucwords($location);
			}
			if( isset($location) && trim($location) != '' ){
				$title	= 'Homes for Sale And Rent in '.$location;
			}
		}
	}
	return $title;
}
add_action( 'loop_start',
	function(){
		add_filter( 'the_title', 'md_page_title', 10, 2 );
	}
);
add_filter( 'wp_title', 'md_page_title', 10, 2 );
/*add_action('wp_headers','reset_cache_func',10,1);
function reset_cache_func($url){
	echo get_query_var('reset-cache');
}*/

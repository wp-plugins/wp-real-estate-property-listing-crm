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
function remove_whitespace($string){
	return preg_replace('/\s+/', '', $string);
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
	return \CRM_Account::get_instance()->get_account_details();
}
function get_account_fields(){
	return \CRM_Account::get_instance()->get_fields();
}
function get_account_currency(){
	return \CRM_Account::get_instance()->get_account_data('currency');
}
function get_account_data($data_name){
	return \CRM_Account::get_instance()->get_account_data($data_name);
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
	$option_plugin_settings = option_plugin_settings('search_criteria');
	return $option_plugin_settings['status'] ? $option_plugin_settings['status']:0;
}
function get_states_by_country(){
	return \CRM_Account::get_instance()->getStatesByCountryId();
}
function get_coverage_area(){
	return \CRM_Account::get_instance()->getCoverageArea();
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
	$label = 'Homes for Sale And Rent in ';
	$label = apply_filters('home_for_sale_rent_hook', $label);
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
			$location 		= '';
			$query_var   	= get_query_var('url');
			$parse_property = explode( '-', $query_var);

			if( $parse_property[0] == 'mls' ){
				$prefix = '';

				if( count($parse_property) == 2 ){
					$prefix = 'Postal ';
					unset($parse_property[0]);
				}elseif( count($parse_property) >= 3 ){
					unset($parse_property[0]);
					unset($parse_property[1]);
				}

				foreach($parse_property as $val){
					$location .= $val.' ';
				}
				$location = $prefix . ucwords($location);
			}elseif( $parse_property[0] == 'crm' ){
				unset($parse_property[0]);
				unset($parse_property[1]);
				foreach($parse_property as $val){
					$location .= $val.' ';
				}
				$location = ucwords($location);
			}

			if( isset($location) && trim($location) != '' ){
				$title	= $label . $location;
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

function md_redirect_property_url(){
	global $wp_query, $post;
	$idx = '';
	if( isset($_SERVER['REQUEST_URI']) ){
		$request_uri = $_SERVER['REQUEST_URI'];
		$explode = explode('/',$request_uri);
		if( in_array('pview',$explode) ){
			$pview = array_search('pview',$explode);
			$idx = $explode[$pview+1];
			$property = \CRM_Property::get_instance()->get_property($idx);
			if( $property ){
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: ".$property->properties->displayURL());
				exit();
			}
		}
	}
}
add_action('wp','is_404_function');
function is_404_function(){
	if ( is_404() ) {
		md_redirect_property_url();
	}
}
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
function array_to_js_obj($array, $depth=0, $script="", $siblings = null){
	$relIdx = 0;
	foreach($array as $optionObjName => $val){
		if(is_array($val)){
			$arraysOnLevel[$optionObjName] = $val;
		}else{
			$script .= $optionObjName.": ";
			if(!is_numeric($val) && $val!='true' && $val!='false')
				$script .= "'".$val."'";
			else
				$script .= $val;
			if(++$relIdx<count($array))
				$script .=",";
		}
	}
	if(isset($arraysOnLevel)){
		$array = reset($arraysOnLevel);
		$optionObjName = key($arraysOnLevel);

		if(count($arraysOnLevel>1))
			$siblings[$depth] = array_slice($arraysOnLevel, 1);

		$script .= $optionObjName.": {";
		return array_to_js_obj($array, ++$depth, $script, $siblings);
	}else{
		while(--$depth >=0){
			$script.="}";
			if(is_array($siblings[$depth])&& $siblings[$depth]!=null){
				$script .= ",";
				return array_to_js_obj($siblings[$depth], $depth, $script, $siblings);
			}
		}
	}
	return $script;
}
function md_trim_tolower($str){
	return strtolower(remove_whitespace(remove_nonaplha($str)));
}
function md_limit_text($str, $limit = 10){
	return \helpers\Text::limit_words($str, $limit);
}

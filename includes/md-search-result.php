<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function get_query_view_uri(){
	$query_string = '';
	if( isset($_SERVER['QUERY_STRING']) ){
		$r = parse_url($_SERVER['QUERY_STRING']);
		parse_str($r['path'],$get_arr);
		unset($get_arr['view']);
		if( count($get_arr) > 1 && isset($get_arr['location']) ){
			$query = '?' . http_build_query($get_arr) . '&';
		}else{
			$query = '?';
		}
	}
	return $query;
}
function md_search_uri_query($view_query_string){
	$query 	= get_query_view_uri();
	$uri 	= \Property_URL::get_instance()->get_search_page_default() . $query . $view_query_string;
	return $uri;
}
function get_current_view_query(){
	return \Search_Result_View::get_instance()->view();
}
function is_fullscreen(){
	$fullscreen = 'n';
	if( isset($_GET['fullscreen']) ){
		$fullscreen = sanitize_text_field($_GET['fullscreen']);
	}
	return $fullscreen;
}

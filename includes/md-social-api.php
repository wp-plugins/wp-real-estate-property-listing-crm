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
function get_all_social_api(){
	$prefix = \Social_API::get_instance()->get_option_prefix();
	return get_option($prefix);
}
function get_social_api_by_key($api, $key){
	return \Social_API::get_instance()->getSocialApiByKey($api, $key);
}
function get_facebook_api(){
	return get_social_api_by_key('facebook','id');
}
function get_facebook_version(){
	return get_social_api_by_key('facebook','version');
}
function has_facebook_api(){
	if( get_facebook_api() && get_facebook_version() ){
		return true;
	}
	return false;
}

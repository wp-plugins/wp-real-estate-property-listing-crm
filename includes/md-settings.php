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
function get_all_settings(){
	$prefix = \Settings_API::get_instance()->get_option_prefix();
	return get_option($prefix);
}
function get_settings_by_key($setting_key, $key){
	return \Settings_API::get_instance()->getSettingsGeneralByKey($setting_key, $key);
}

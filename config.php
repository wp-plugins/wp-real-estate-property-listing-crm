<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$settings 			= get_option('plugin-settings');
$plugin_foldername 	= explode('/',plugin_basename( __FILE__ ));
$social_api 		= get_option('social-api');
define('DO_NOT_CACHE',false);
define('DEFAULT_FEED',get_option( 'property_data_feed' ));
define('SEARCH_RESULT_FEED',get_option( 'property_data_feed' ));
// move to setting UI
if( isset($settings['mail']['server']) ){
	define('MD_SYSTEM_MAIL',$settings['mail']['server']);
}else{
	define('MD_SYSTEM_MAIL',get_option('admin_email'));
}
// move to setting UI
if(isset($settings['template']['colgrid'])){
	define('MD_DEFAULT_GRID_COL',$settings['template']['colgrid']);
}else{
	define('MD_DEFAULT_GRID_COL',4);
}
/*********/
define('PLUGIN_DIR_PATH',plugin_dir_path( __FILE__ ));
define('PLUGIN_VIEW', PLUGIN_DIR_PATH . 'public/templates/');
define('THEME_VIEW', get_stylesheet_directory());
/*********/
define('MD_PLUGIN_PAGE','http://www.masterdigm.com/realestatewordpressplugin');
define('MD_SHOW_PROPERTY_IMG',1);
define('PLUGIN_FOLDER_NAME',$plugin_foldername[0]);
define('PLUGIN_PUBLIC_DIR', WP_PLUGIN_DIR .'/'. PLUGIN_FOLDER_NAME . '/public/');
define('COMPONENT_DIR', WP_PLUGIN_DIR .'/'. PLUGIN_FOLDER_NAME . '/components/');
define('PLUGIN_PUBLIC', WP_PLUGIN_DIR .'/'. PLUGIN_FOLDER_NAME . '/public/plugin/');
define('PLUGIN_ADMIN_VIEW', WP_PLUGIN_DIR .'/'. PLUGIN_FOLDER_NAME . '/admin/views/');
define('PLUGIN_ASSET', WP_PLUGIN_DIR .'/'. PLUGIN_FOLDER_NAME . '/assets/');
define('PLUGIN_ASSET_URL', WP_PLUGIN_URL .'/'. PLUGIN_FOLDER_NAME . '/assets/');
define('PLUGIN_PUBLIC_URL', WP_PLUGIN_URL .'/'. PLUGIN_FOLDER_NAME . '/public/plugin/');
define('SWITCH_DATA_FEED', false);
define('MLS_VIEW', PLUGIN_VIEW . 'mls/template/');
define('CRM_VIEW', PLUGIN_VIEW . 'crm/template/');
define('LAYOUT',WP_PLUGIN_DIR .'/'. PLUGIN_FOLDER_NAME . '/public/partials/');
define('GLOBAL_TEMPLATE',WP_PLUGIN_DIR .'/'. PLUGIN_FOLDER_NAME . '/public/globals/');
// choose which data to render
define('MD_DATA_FEED', get_option( 'property_data_feed' ));
define('CRM_SEARCH_LOOKUP_STATE',6);
// for mls data feed
define('MLS_API_KEY', '');
define('MLS_API_TOKEN', '');
define('MLS_API_ENDPOINT','http://www.masterdigmserver1.com/api/');
define('MLS_API_VERSION','v2');
// crm data feed
define('MD_API_KEY', get_option( 'api_key' ));
define('MD_API_TOKEN', get_option( 'api_token' ));
define('MD_BROKER_ID', get_option( 'broker_id' ));
define('MD_USER_ID', get_option( 'user_id' ));
define('MD_API_ENDPOINT','http://masterdigm.com/api2/');
define('MD_API_VERSION','v2');
//template
define('LIST_BOX_STYLE', PLUGIN_VIEW . 'list/default/list-default.php');
define('CAROUSEL_DEFAULT_SINGLE', PLUGIN_VIEW . 'carousel/single-property-galleria.php');
//CRM
define('CRM_DEFAULT_LIST', CRM_VIEW . 'list/default/list-default.php');
define('CRM_DEFAULT_RELATED', CRM_VIEW . 'list/default/list-related-property.php');
define('CRM_DEFAULT_SINGLE', CRM_VIEW . 'single/single-property-page.php');
define('CRM_DEFAULT_SEARCH_FORM', CRM_VIEW . 'searchform/search-form.php');
define('CRM_DEFAULT_SEARCH_RESULT', PLUGIN_VIEW . 'searchresult/search-result.php');
define('CRM_DEFAULT_SEARCH_RESULT_SCROLL', PLUGIN_VIEW . 'searchresult/scroll-search-result.php');
//MLS
define('MLS_DEFAULT_SINGLE', MLS_VIEW . 'single/single-property-page.php');
// masterdigmsites
define('MD_FACEBOOK_APP_ID',$social_api['facebook']['id']);
define('MD_FACEBOOK_APP_SECRET',$social_api['facebook']['secret']);
// FB APP
// education.com
define('EDUCATION_API','a31664cdc439e290b1c5ce905e75c692');
// walkscore
define('WALKSCORE_API','20237ca07492bb7c6a97bdc2677a1540');
// google api
define('GOOGLE_PUBLIC_KEY','AIzaSyBy6vTWwrkvvUBVaIYfXtOIQ4LjEg2HDPA');
//cookie
//show pop-up in x
define('SHOW_POPUP',3);
// phpfastcache
$array_label = array(
	'property-details' 			=> 'Property Details',
	'map-and-directions' 		=> 'Map and Directions',
	'school-and-information' 	=> 'School and Information',
	'walk-score' 				=> 'Walk Score',
	'single-photos' 			=> 'Photos',
	'video' 					=> 'Video',
	'price' 					=> 'Price',
	'baths' 					=> 'Baths',
	'beds' 						=> 'Beds',
	'year-built' 				=> 'Year Built',
	'mls' 						=> 'MLS# ',
	'search-title'				=> 'Find your Home',
	'garage'					=> 'Garage',
	'next'						=> 'Next',
	'prev'						=> 'Previous',
	'property-code'				=> 'Property Code',
);

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
require_once plugin_dir_path( __FILE__ ) . 'admin/components/credentials/init.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/components/settings/init.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/components/subscribeapi/init.php';
if( \Masterdigm_API::get_instance()->has_crm_api_key() ){
	require_once plugin_dir_path( __FILE__ ) . 'admin/components/breadcrumburl/init.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/components/tagcontent/init.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/components/socialapi/init.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/components/shortcodes/init.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/components/dashboard/init.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/components/createlocationpage/init.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/components/propertyalert/init.php';
}

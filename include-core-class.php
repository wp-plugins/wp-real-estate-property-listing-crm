<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
//pdf lib
require_once(plugin_dir_path( __FILE__ ) . 'includes/tcpdf/config/tcpdf_config.php');
// Include the main TCPDF library (search the library on the following directories).
$tcpdf_include_dirs = array(
	realpath('../tcpdf.php'),
	plugin_dir_path( __FILE__ ) . 'includes/tcpdf/tcpdf.php',
	'/usr/share/php/tcpdf/tcpdf.php',
	'/usr/share/tcpdf/tcpdf.php',
	'/usr/share/php-tcpdf/tcpdf.php',
	'/var/www/tcpdf/tcpdf.php',
	'/var/www/html/tcpdf/tcpdf.php',
	'/usr/local/apache2/htdocs/tcpdf/tcpdf.php'
);
foreach ($tcpdf_include_dirs as $tcpdf_include_path) {
	if (@file_exists($tcpdf_include_path)) {
		require_once($tcpdf_include_path);
		break;
	}
}
//interface
require_once( plugin_dir_path( __FILE__ ) . 'includes/interface-masterdigm-api.php' );
//cache
require_once( plugin_dir_path( __FILE__ ) . 'includes/cache/class-property-cache.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-db-store.php' );
add_action( 'plugins_loaded', array( 'DB_Store', 'get_instance' ) );
// helpers
require plugin_dir_path( __FILE__ ) . 'helpers/inc.php';
// search
require plugin_dir_path( __FILE__ ) . 'includes/class-search-utility.php';
add_action( 'plugins_loaded', array( 'MD_Search_Utility', 'get_instance' ) );
// property pages
require plugin_dir_path( __FILE__ ) . 'includes/class-property-pages.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-property-url.php';
add_action( 'plugins_loaded', array( 'Property_URL', 'get_instance' ) );
require plugin_dir_path( __FILE__ ) . 'admin/class-masterdigm-admin-util.php';
//masterdigm api class
//require masterdigm api class for CRM
require_once( plugin_dir_path( __FILE__ ) . 'includes/api/masterdigm/crm/class-crm-client.php' );
//require masterdigm api class for MLS
//require_once( plugin_dir_path( __FILE__ ) . 'includes/api/masterdigm/mls/class-mls-client.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/api/masterdigm/mls/MlsConnector.php' );
//require masterdigm api wrapper
// crm
require_once( plugin_dir_path( __FILE__ ) . 'includes/crm/init.php' );
// mls
require_once( plugin_dir_path( __FILE__ ) . 'includes/mls/init.php' );
// single property
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-property-single.php' );
add_action( 'plugins_loaded', array( 'MD_Single_Property', 'get_instance' ) );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-searchby-property.php' );
add_action( 'plugins_loaded', array( 'MD_Searchby_Property', 'get_instance' ) );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-single-property-breadcrumb.php' );
// MD\Property
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-md-property.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-template.php' );
//next prev
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-next-prev.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-agent.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-property-details.php' );

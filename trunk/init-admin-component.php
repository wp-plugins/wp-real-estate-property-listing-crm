<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
// api credentials component
require_once plugin_dir_path( __FILE__ ) . 'admin/components/credentials/init.php';
// breadcrumb url component
require_once plugin_dir_path( __FILE__ ) . 'admin/components/breadcrumburl/init.php';
// tag content component
require_once plugin_dir_path( __FILE__ ) . 'admin/components/tagcontent/init.php';
// social api
require_once plugin_dir_path( __FILE__ ) . 'admin/components/socialapi/init.php';
// short code
require_once plugin_dir_path( __FILE__ ) . 'admin/components/shortcodes/init.php';
// setting component
require_once plugin_dir_path( __FILE__ ) . 'admin/components/settings/init.php';
// dashboard component
require_once plugin_dir_path( __FILE__ ) . 'admin/components/dashboard/init.php';

<?php
require_once(plugin_dir_path( __FILE__ ) . 'class-masterdigm-api-crm.php');
require_once(plugin_dir_path( __FILE__ ) . 'class-crm-account.php');
require_once(plugin_dir_path( __FILE__ ) . 'class-crm-locations.php');
require_once(plugin_dir_path( __FILE__ ) . 'class-crm-property.php');
require_once(plugin_dir_path( __FILE__ ) . 'class-hook.php');
add_action( 'plugins_loaded', array( '\CRM_Hook', 'get_instance' ) );
require_once( plugin_dir_path( __FILE__ ) . 'properties/class-property-entity.php' );
// agent
require_once( plugin_dir_path( __FILE__ ) . 'agent/class-agent-entity.php' );
// view
require_once( plugin_dir_path( __FILE__ ) . 'class-layout-property.php' );
add_action( 'plugins_loaded', array( '\crm\Layout_Property', 'get_instance' ) );
// search by
require_once( plugin_dir_path( __FILE__ ) . 'class-searchby-properties.php' );
add_action( 'plugins_loaded', array( '\crm\MD_Searchby_Property', 'get_instance' ) );
// breadcrumb
require_once( plugin_dir_path( __FILE__ ) . 'class-single-property-breadcrumb.php' );

<?php
//refactored
require_once( plugin_dir_path( __FILE__ ) . 'class-masterdigm-api-crm.php' );
// crm
require_once( plugin_dir_path( __FILE__ ) . 'class-masterdigm-crm.php' );
//account
require_once( plugin_dir_path( __FILE__ ) . 'class-account.php' );
add_action( 'plugins_loaded', array( '\crm\AccountEntity', 'get_instance' ) );
// class for properties
require_once( plugin_dir_path( __FILE__ ) . 'properties/class-properties.php' );
// class for property entity
require_once( plugin_dir_path( __FILE__ ) . 'properties/class-property-entity.php' );
// agent
require_once( plugin_dir_path( __FILE__ ) . 'agent/class-agent.php' );
require_once( plugin_dir_path( __FILE__ ) . 'agent/class-agent-entity.php' );
// view
// remove
require_once( plugin_dir_path( __FILE__ ) . 'class-layout-property.php' );
add_action( 'plugins_loaded', array( '\crm\Layout_Property', 'get_instance' ) );
// search by
require_once( plugin_dir_path( __FILE__ ) . 'class-searchby-properties.php' );
add_action( 'plugins_loaded', array( '\crm\MD_Searchby_Property', 'get_instance' ) );
// breadcrumb
require_once( plugin_dir_path( __FILE__ ) . 'class-single-property-breadcrumb.php' );

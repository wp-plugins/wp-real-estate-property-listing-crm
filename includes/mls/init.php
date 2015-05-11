<?php
// mls
require_once( plugin_dir_path( __FILE__ ) . 'class-mls.php' );
require_once( plugin_dir_path( __FILE__ ) . 'class-property.php' );
//refactor
require_once( plugin_dir_path( __FILE__ ) . 'class-masterdigm-mls.php' );
//account
require_once( plugin_dir_path( __FILE__ ) . 'class-account.php' );
add_action( 'plugins_loaded', array( '\mls\AccountEntity', 'get_instance' ) );
// class for properties
//require_once( plugin_dir_path( __FILE__ ) . 'properties/class-mls-properties.php' );
// class for property entity
require_once( plugin_dir_path( __FILE__ ) . 'properties/class-mls-property-entity.php' );
// view
require_once( plugin_dir_path( __FILE__ ) . 'class-template-property.php' );
add_action( 'plugins_loaded', array( '\mls\Template_Property', 'get_instance' ) );
// search by
require_once( plugin_dir_path( __FILE__ ) . 'class-searchby-properties.php' );
add_action( 'plugins_loaded', array( '\mls\MD_Searchby_Property', 'get_instance' ) );
// breadcrumb
//require_once( plugin_dir_path( __FILE__ ) . 'class-single-property-breadcrumb.php' );

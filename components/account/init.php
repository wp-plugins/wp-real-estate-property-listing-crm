<?php
require_once plugin_dir_path( __FILE__ ) . 'class-dashboard.php';
add_action( 'plugins_loaded', array( 'Account_Dashboard', 'get_instance' ) );
require_once plugin_dir_path( __FILE__ ) . 'class-profile.php';
add_action( 'plugins_loaded', array( 'Account_Profile', 'get_instance' ) );
require_once plugin_dir_path( __FILE__ ) . 'class-favorites-property.php';
add_action( 'plugins_loaded', array( 'Favorites_Property', 'get_instance' ) );
require_once plugin_dir_path( __FILE__ ) . 'class-xout-property.php';
add_action( 'plugins_loaded', array( 'Xout_Property', 'get_instance' ) );
require_once plugin_dir_path( __FILE__ ) . 'class-dashboard-savesearch.php';
add_action( 'plugins_loaded', array( 'Dashboard_Save_Search', 'get_instance' ) );

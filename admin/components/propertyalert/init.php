<?php
/**
 * initialize settings class
 * */
require_once plugin_dir_path( __FILE__ ) . '/class-admin-property-alert.php';
add_action( 'plugins_loaded', array( 'Property_Alert_Admin', 'get_instance' ) );



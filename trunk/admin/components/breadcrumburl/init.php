<?php
/**
 * initialize settings class
 * */
require_once plugin_dir_path( __FILE__ ) . '/class-breadcrumb-url.php';
add_action( 'plugins_loaded', array( 'Breadcrumb_Url', 'get_instance' ) );


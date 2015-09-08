<?php
/**
 * initialize settings class
 * */
require_once plugin_dir_path( __FILE__ ) . '/class-subscribe-api.php';
add_action( 'plugins_loaded', array( 'MD_Subscribe_API', 'get_instance' ) );


<?php
/**
 * initialize settings class
 * */
require_once plugin_dir_path( __FILE__ ) . '/class-social-api.php';
add_action( 'plugins_loaded', array( 'Social_API', 'get_instance' ) );


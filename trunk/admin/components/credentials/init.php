<?php
/**
 * initialize settings class
 * */
require_once plugin_dir_path( __FILE__ ) . '/class-credentials.php';
add_action( 'plugins_loaded', array( 'API_Credentials', 'get_instance' ) );


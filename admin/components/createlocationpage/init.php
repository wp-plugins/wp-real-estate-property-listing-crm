<?php
/**
 * initialize settings class
 * */
require_once plugin_dir_path( __FILE__ ) . 'class-createlocationpage.php';
add_action( 'plugins_loaded', array( 'Create_Location_Page', 'get_instance' ) );


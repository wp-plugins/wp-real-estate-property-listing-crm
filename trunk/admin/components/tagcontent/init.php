<?php
/**
 * initialize settings class
 * */
require_once plugin_dir_path( __FILE__ ) . '/class-tag-content.php';
add_action( 'plugins_loaded', array( 'MD_Property_Content', 'get_instance' ) );


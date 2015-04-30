<?php
require_once plugin_dir_path( __FILE__ ) . 'class-account.php';
require_once plugin_dir_path( __FILE__ ) . 'class-profile.php';
add_action( 'plugins_loaded', array( 'Account_Profile', 'get_instance' ) );
require_once plugin_dir_path( __FILE__ ) . 'class-save-property.php';
add_action( 'plugins_loaded', array( 'Save_Property', 'get_instance' ) );

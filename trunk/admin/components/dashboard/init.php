<?php
require_once plugin_dir_path( __FILE__ ) . 'class-dashboard.php';
add_action( 'plugins_loaded', array( 'Admin_Dashboard', 'get_instance' ) );

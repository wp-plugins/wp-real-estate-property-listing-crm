<?php
require_once plugin_dir_path( __FILE__ ) . 'class-facebook-app.php';
add_action( 'plugins_loaded', array( 'MD_Facebook_App', 'get_instance' ) );

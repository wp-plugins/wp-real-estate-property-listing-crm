<?php
require_once plugin_dir_path( __FILE__ ) . 'class-email-to.php';
add_action( 'plugins_loaded', array( 'Email_To', 'get_instance' ) );

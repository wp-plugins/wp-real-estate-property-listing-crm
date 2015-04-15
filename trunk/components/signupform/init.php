<?php
require_once plugin_dir_path( __FILE__ ) . 'class-signup-sign.php';
add_action( 'plugins_loaded', array( 'Signup_Form', 'get_instance' ) );

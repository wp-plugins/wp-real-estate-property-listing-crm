<?php
require_once plugin_dir_path( __FILE__ ) . 'class-inquire.php';
add_action( 'plugins_loaded', array( 'Inquire', 'get_instance' ) );

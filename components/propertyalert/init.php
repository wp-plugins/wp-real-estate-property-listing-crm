<?php
require_once plugin_dir_path( __FILE__ ) . 'class-property-alert.php';
add_action( 'plugins_loaded', array( 'Property_Alert', 'get_instance' ) );

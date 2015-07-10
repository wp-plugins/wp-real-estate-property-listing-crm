<?php
require_once plugin_dir_path( __FILE__ ) . 'class-save-search.php';
add_action( 'plugins_loaded', array( 'Save_Search', 'get_instance' ) );

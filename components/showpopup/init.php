<?php
require_once plugin_dir_path( __FILE__ ) . 'class-show-popup.php';
add_action( 'plugins_loaded', array( 'Show_Popup', 'get_instance' ) );

<?php
require_once plugin_dir_path( __FILE__ ) . 'class-action-buttons.php';
add_action( 'plugins_loaded', array( 'Action_Buttons', 'get_instance' ) );
require_once plugin_dir_path( __FILE__ ) . 'class-favorite.php';
add_action( 'plugins_loaded', array( 'Favorite_Property', 'get_instance' ) );
require_once plugin_dir_path( __FILE__ ) . 'class-xout.php';
add_action( 'plugins_loaded', array( 'XOut_Property', 'get_instance' ) );

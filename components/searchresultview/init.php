<?php
require_once plugin_dir_path( __FILE__ ) . 'class-search-result-view.php';
add_action( 'plugins_loaded', array( 'Search_Result_View', 'get_instance' ) );
require_once plugin_dir_path( __FILE__ ) . 'class-search-result-photo.php';
add_action( 'plugins_loaded', array( 'Search_Result_Photo', 'get_instance' ) );
require_once plugin_dir_path( __FILE__ ) . 'class-search-result-map.php';
add_action( 'plugins_loaded', array( 'Search_Result_Map', 'get_instance' ) );
require_once plugin_dir_path( __FILE__ ) . 'class-search-result-list.php';
add_action( 'plugins_loaded', array( 'Search_Result_List', 'get_instance' ) );
//selector should be id
$config = array(
	'selector' => '#map-canvas',
);
\Search_Result_Map::get_instance()->set_js_gmap_config($config);
$option_array = array(
	'zoom'		=>	15,
	'center'	=> array(
		'lat' => get_query_lat(),
		'lng' => get_query_lng()
	)
);
\Search_Result_Map::get_instance()->set_js_gmap_option($option_array);


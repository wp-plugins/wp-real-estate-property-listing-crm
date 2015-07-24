<?php
/**
 * initialize settings class
 * */
require_once plugin_dir_path( __FILE__ ) . '/class-settings.php';
/*add_action( 'admin_menu', 'add_plugin_admin_menu');
function add_plugin_admin_menu(){
	$plugin_name = \Masterdigm_API::get_instance()->get_plugin_name();
	$obj = new Settings_API;
	$callback = $obj->controller();
	add_submenu_page(
		$plugin_name,
		'Settings',
		'Settings',
		'manage_options',
		'md-api-plugin-settings',
		$callback
	);
}*/

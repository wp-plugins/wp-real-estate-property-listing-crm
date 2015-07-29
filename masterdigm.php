<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 *
 * @link              http://masterdigm.com
 * @since             1.0.0
 * @package           Masterdigm_Api
 *
 * @wordpress-plugin
 * Plugin Name:       Masterdigm API
 * Plugin URI:        http://www.masterdigm.com/realestatewordpressplugin
 * Description:       Used by Professional Real Estate companies around the world, Masterdigm Real Estate WP plugin will help you build your real estate website.  To get started: 1) Click the "Activate" link to the left of this description, 2) Sign up for a Masterdigm API Key, 3) Go to your left menu:  Masterdigm >> Masterdigm and add your key, token and ID.  Go to this page to learn exactly how: <a href="http://www.masterdigm.com/realestatewordpressplugin" target="_blank">http://www.masterdigm.com/realestatewordpressplugin</a>
 * Version:           3.27.57
 * Author:            Masterdigm
 * Author URI:        http://masterdigm.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       masterdigm-api
 * Domain Path:       /languages
 * Bitbucket Plugin URI: https://bitbucket.org/allan_paul_casilum/masterdigm
 * Bitbucket Branch:     master
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
define('MASTERDIGM_API',true);
/* Masterdigm */
/**
 * load the config variables
 * */
require_once( plugin_dir_path( __FILE__ ) . 'config.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/phpfastcache/phpfastcache.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-view.php' );
/* Masterdigm */
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-masterdigm-api-activator.php';
	Masterdigm_API_Activator::activate();
	flush_rewrite_rules();
}
function md_admin_notice(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-masterdigm-api-activator.php';
	if( !\Masterdigm_API::get_instance()->has_crm_api_key() ){
		Masterdigm_API_Activator::md_admin_notice();
	}
}
add_action('admin_notices', 'md_admin_notice');
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-masterdigm-api-deactivator.php';
	Masterdigm_API_Deactivator::deactivate();
}
register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );
/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-masterdigm-api.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_masterdigm() {
	$plugin = new Masterdigm_API();
	$plugin->run();
}
run_masterdigm();

function has_mls_key(){
	if( get_option('mls_api_key') && get_option('mls_api_token') ){
		return true;
	}
	return false;
}
function has_crm_key(){
	if( get_option('api_key') && get_option('api_token') ){
		return true;
	}
	return false;
}
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-cache.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/md-cache.php' );
// include core classes
require_once( plugin_dir_path( __FILE__ ) . 'include-core-class.php' );
if( !class_exists('Account_Dashboard') ){
	require_once plugin_dir_path( __FILE__ ) . 'components/account/class-dashboard.php';
}
if( !class_exists('Subscriber_Shortcode') ){
	require_once plugin_dir_path( __FILE__ ) . 'admin/components/shortcodes/class-subscriber-shortcode.php';
}
// Admin / Dashboard
require_once( plugin_dir_path( __FILE__ ) . 'init-admin-component.php' );
if( \Masterdigm_API::get_instance()->has_crm_api_key() ){
	// function for easy access
	require_once( plugin_dir_path( __FILE__ ) . 'inc-functions.php' );
	// components
	require_once( plugin_dir_path( __FILE__ ) . 'init-component.php' );
}

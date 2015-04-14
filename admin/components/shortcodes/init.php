<?php
/**
 * initialize shortcodes class
 * */
if( has_crm_key() == 1){
	require_once plugin_dir_path( __FILE__ ) . '/class-shortcodes.php';
	add_action( 'plugins_loaded', array( 'Shortcode_Tinymce', 'get_instance' ) );
	//crm
	require_once plugin_dir_path( __FILE__ ) . '/class-crm-list-properties.php';
	add_action( 'plugins_loaded', array( 'md_sc_crm_list_properties', 'get_instance' ) );
	require_once plugin_dir_path( __FILE__ ) . '/class-crm-featured-properties.php';
	add_action( 'plugins_loaded', array( 'md_sc_crm_featured_properties', 'get_instance' ) );
	require_once plugin_dir_path( __FILE__ ) . '/class-crm-list-property-by.php';
	require_once plugin_dir_path( __FILE__ ) . '/class-crm-single-property.php';
	add_action( 'plugins_loaded', array( 'md_sc_crm_single_box_properties', 'get_instance' ) );
	//mls
	require_once plugin_dir_path( __FILE__ ) . '/class-mls-list-properties.php';
	add_action( 'plugins_loaded', array( 'md_sc_mls_list_properties', 'get_instance' ) );
	require_once plugin_dir_path( __FILE__ ) . '/class-mls-list-property-by.php';
	add_action( 'plugins_loaded', array( 'md_sc_mls_list_properties_by', 'get_instance' ) );
	require_once plugin_dir_path( __FILE__ ) . '/class-mls-single-property.php';
	add_action( 'plugins_loaded', array( 'md_sc_single_box_properties', 'get_instance' ) );
	//utility
	require_once plugin_dir_path( __FILE__ ) . '/class-md-list-property-by.php';
	add_action( 'plugins_loaded', array( 'md_sc_list_properties_by', 'get_instance' ) );
	require_once plugin_dir_path( __FILE__ ) . '/class-md-search-form.php';
	add_action( 'plugins_loaded', array( 'md_sc_search_form', 'get_instance' ) );
	require_once plugin_dir_path( __FILE__ ) . '/class-md-search-result.php';
	add_action( 'plugins_loaded', array( 'md_sc_search_result_properties', 'get_instance' ) );
	require_once plugin_dir_path( __FILE__ ) . '/class-md-single-property.php';
	add_action( 'plugins_loaded', array( 'md_sc_single_properties', 'get_instance' ) );
	require_once plugin_dir_path( __FILE__ ) . '/class-account-shortcode.php';
	add_action( 'plugins_loaded', array( 'Account_Shortcode', 'get_instance' ) );
}

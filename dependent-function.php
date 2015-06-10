<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
// yoast
if ( defined('WPSEO_VERSION') ) {
function md_canonical($url) {
	if( function_exists('get_single_data') || function_exists('parse_query_callback') ){
		$address = parse_query_callback();
		if( $address ){
			$url = $address['property']->displayUrl();
		}
		return $url;
	}
}
add_filter('wpseo_canonical', 'md_canonical' );
add_action('wpseo_sitemap_index','sitemap_mdproperties');
function sitemap_mdproperties(){
	$datetime = new DateTime();
	$date     = $datetime->format( 'c' );
	$sitemap = '<sitemap>
	<loc>'.wpseo_xml_sitemaps_base_url('properties-sitemap.xml').'</loc>
	<lastmod>'.htmlspecialchars( $date ).'</lastmod>
	</sitemap>';
return $sitemap;
}
add_action('init', 'properties_custom_sitemap');
function properties_custom_sitemap(){
    global $wpseo_sitemaps;
    $wpseo_sitemaps->register_sitemap('properties','property_list','properties');
}
function property_list(){
	global $wpseo_sitemaps;

	$data = array(
		'transaction' => 'all'
	);
	$get_total_properties = \CRM_Property::get_instance()->get_properties($data);
	$xml_db_store_prefix = 'product_sitemap_xml';
	$xml_db_store		 = \DB_Store::get_instance()->get($xml_db_store_prefix);
	if( $xml_db_store ){
		$xml_properties = $xml_db_store;
	}else{
		$data_all = array(
			'limit'		  => $get_total_properties->total,
			'transaction' => 'all'
		);
		$xml_properties 	 = \CRM_Property::get_instance()->get_properties($data_all);

	}

	$sitemap .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" ';
	$sitemap .= 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" ';
	$sitemap .= 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

	if( $xml_properties ){
		foreach( $xml_properties->data as $key => $val ){
			if( validateDate($val->posted_at) ){
				$url = array();
				$url['loc'] = $val->displayUrl();
				$url['pri']	= '1.0';
				$url['chf']	= 'weekly';
				$url['mod'] = $val->posted_at;

				/*$photos = \crm\Properties::get_instance()->get_property_photo($val->id);
				if( $photos->result == 'success' || $photos->success ){
					$url['images'] = count($photos->photos);
				}*/
				$sitemap .= $wpseo_sitemaps->sitemap_url($url);
			}
		}
	}

	$sitemap .='</urlset>' . "\n";
	$wpseo_sitemaps->set_sitemap($sitemap);
}
}//endif yoast


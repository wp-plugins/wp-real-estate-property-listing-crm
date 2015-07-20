<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * get hierarchy location of mls
 * @param	$obj_property_data 		array | mls object entity			pass the mls property entity
 * @param	$get_coverage_lookup	array | data set of getCoverageLookup
 * @param	$gc_array_key			string | key of getCoverageLookup	default is keyword, another is full
 *
 * @return associative array
 * */
function get_mls_hierarchy_location($obj_property_data, $get_coverage_lookup, $gc_array_key = 'keyword'){
	$matches = array();
	$ret = array();
	$search_location = '';
	$community = '';
	$city = '';
	$location = $get_coverage_lookup;

	if( $location->result == 'success' ){
		$array_location = json_decode(json_encode($location->lookups), true);
		if( isset($obj_property_data->Community) && trim($obj_property_data->Community) != '' ){
			$community 	= trim(strtolower($obj_property_data->Community));
			$community  = explode(' ',$community );
			if( count($community ) >= 3 ){
				$community  = strtolower($community[0].' '.$community[1]);
			}elseif( count($community ) >= 2 ){
				$community  = trim(strtolower($community [0]));
			}else{
				$community  = trim(strtolower($community [0]));
			}

		}
		if(isset($obj_property_data->City) && $obj_property_data->City != ''){
			$city = trim(strtolower($obj_property_data->City));
		}
		$matches['country'] = array(
			'keyword' => ''
		);
		if(isset($obj_property_data->State) && $obj_property_data->State != ''){
			$matches['state'] = array(
				'keyword' => $obj_property_data->State
			);
		}else{
			$matches['state'] = array(
				'keyword' => ''
			);
		}
		if(isset($obj_property_data->County) && $obj_property_data->County != ''){
			$matches['county'] = array(
				'keyword' => $obj_property_data->County
			);
		}else{
			$matches['county'] = array(
				'keyword' => ''
			);
		}
		/**
		 * loop through array_location
		 * */
		$city_id = 0;
		$indx_community = 0;
		$matches['city'] = array(
			'id' => 0,
			'city_id' => 0,
			'type' => 'city',
			'full' => '-1',
			'keyword' => '-1',
		);

		foreach($array_location as $key => $val){
			$keyword = strtolower(trim($val[$gc_array_key]));
			$city_id = 0;
			if ($city != '' && strcmp($city, $keyword) == 0) {
				$city_id = $val['id'];
				if( $val['location_type'] == 'city' ){
					$matches['city'] = array(
						'id' => $val['id'],
						'type' => $val['location_type'],
						'full' => $val['full'],
						'keyword' => $val['keyword'],
					);
				}
			}
			//if ( $community != '' && strcmp($community, $keyword) == 0 && $indx_community == 0 ) {
			if ( $community != '' && preg_match("/$community/", $keyword) ) {
				if( $val['location_type'] == 'community' ){
					$matches['community'][] = array(
						'id' 		=> $val['id'],
						'city_id' 	=> $val['city_id'],
						'type' 		=> $val['location_type'],
						'full' 		=> $val['full'],
						'keyword' 	=> $val['keyword'],
					);
				}
			}
		}

		if( isset($matches['community']) && count($matches['community']) >= 1 ){
			foreach($matches['community'] as $key => $val){
				if( $matches['city']['id'] == $val['city_id'] ){
					$matches['community'] = array(
						'id' 		=> $val['id'],
						'city_id' 	=> $val['city_id'],
						'type' 		=> 'community',
						'full' 		=> $val['full'],
						'keyword' 	=> $val['keyword'],
					);
				}
			}
		}else{
			$matches['community'] = array(
				'id' => 0,
				'city_id' => 0,
				'type' => 'community',
				'full' => '-1',
				'keyword' => '-1',
			);
		}

		$matches['zip'] = array(
			'keyword' => ''
		);

		return $matches;
	}
}

function wp_query_page_title($location_name){
	global $wpdb;
	$sql = "SELECT * FROM ".$wpdb->posts." WHERE post_title LIKE  '{$location_name}%' AND post_status =  'publish'";
	$ret = $wpdb->get_results($sql);
	return $ret;
}

function get_mls_breadcrumb($obj_property_data, $get_coverage_lookup){
	$mls_breadcrumb = array();
	$ret 			= get_mls_hierarchy_location($obj_property_data, $get_coverage_lookup);

	if( count($ret) > 0 ){
		if( isset($ret['community']) && count($ret['community']) > 0 ){
			$ret['community']['is_in_breadcrumb_filter'] = 0;
			if(\Breadcrumb_Url::get_instance()->getUrlFilter($ret['community']['full'])){
				$ret['community']['is_in_breadcrumb_filter'] = 1;
				$ret['community']['url'] = \Breadcrumb_Url::get_instance()->getUrlFilter($ret['community']['full']);
			}
			if(\Breadcrumb_Url::get_instance()->getUrlFilter($ret['community']['keyword'])){
				$ret['community']['is_in_breadcrumb_filter'] = 1;
				$ret['community']['url'] = \Breadcrumb_Url::get_instance()->getUrlFilter($ret['community']['keyword']);
			}
			$ret['community']['is_in_wp_page'] = 0;

			$wp_page = wp_query_page_title($ret['community']['full']);
			if($wp_page){
				$ret['community']['is_in_wp_page'] = 1;
				$ret['community']['url'] = esc_url( get_permalink( $wp_page[0]->ID ) );
			}
		}
		if( isset($ret['city']) && count($ret['city']) > 0 ){
			$ret['city']['is_in_breadcrumb_filter'] = 0;
			if(\Breadcrumb_Url::get_instance()->getUrlFilter($ret['city']['full'])){
				$ret['city']['is_in_breadcrumb_filter'] = 1;
				$ret['city']['url'] = \Breadcrumb_Url::get_instance()->getUrlFilter($ret['city']['full']);
			}
			if(\Breadcrumb_Url::get_instance()->getUrlFilter($ret['city']['keyword'])){
				$ret['city']['is_in_breadcrumb_filter'] = 1;
				$ret['city']['url'] = \Breadcrumb_Url::get_instance()->getUrlFilter($ret['city']['keyword']);
			}
			$ret['city']['is_in_wp_page'] = 0;
			$wp_page = wp_query_page_title($ret['city']['full']);
			if($wp_page){
				$ret['city']['is_in_wp_page'] = 1;
				$ret['city']['url'] = esc_url( get_permalink( $wp_page[0]->ID ) );
			}
		}
		if( isset($ret['state']) && count($ret['state']) > 0 ){
			$ret['state']['is_in_breadcrumb_filter'] = 0;
			if(\Breadcrumb_Url::get_instance()->getUrlFilter($ret['state']['keyword'])){
				$ret['state']['is_in_breadcrumb_filter'] = 1;
				$ret['state']['url'] = \Breadcrumb_Url::get_instance()->getUrlFilter($ret['state']['keyword']);
			}
			$ret['state']['is_in_wp_page'] = 0;
			$wp_page = wp_query_page_title($ret['state']['keyword']);
			if($wp_page){
				$ret['state']['is_in_wp_page'] = 1;
				$ret['state']['url'] = esc_url( get_permalink( $wp_page[0]->ID ) );
			}
		}
		if( isset($ret['county']) && count($ret['state']) > 0 ){
			$ret['county']['is_in_breadcrumb_filter'] = 0;
			if(\Breadcrumb_Url::get_instance()->getUrlFilter($ret['county']['keyword'])){
				$ret['county']['is_in_breadcrumb_filter'] = 1;
				$ret['county']['url'] = \Breadcrumb_Url::get_instance()->getUrlFilter($ret['county']['keyword']);
			}
			$ret['county']['is_in_wp_page'] = 0;
			$wp_page = wp_query_page_title($ret['county']['keyword']);
			if($wp_page){
				$ret['county']['is_in_wp_page'] = 1;
				$ret['county']['url'] = esc_url( get_permalink( $wp_page[0]->ID ) );
			}
		}
	}

	return $ret;
}
function get_coverage_lookup(){
	return  \mls\AccountEntity::get_instance()->get_coverage_lookup();
}

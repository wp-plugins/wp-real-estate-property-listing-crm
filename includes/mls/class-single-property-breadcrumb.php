<?php
namespace mls;
/**
 * Plugin Name.
 * Class to set Property Breadcrumb and its associate page
 *
 * @package   MD_Single_Property
 * @author    Masterdigm <email@example.com>
 * @license   GPL-2.0+
 * @link      http://masterdigm.com
 * @copyright 2014 Masterdigm
 */

/**
 * This is use to update public design changes
 *
 *
 *
 * @package MD_Single_Property
 * @author  masterdigm / Allan
 */
class MD_Breadcrumb {
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	public function __construct(){
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function countryDetail($obj_property, $show = true){
		return false;
	}

	public function stateDetail($obj_property, $show = true){
		if( $show ){
			$state = array(
				'id'	=>	0,
				'name'	=>	'',
				'url' 	=>	''
			);

			if( $obj_property->stateid != '' || !is_null($obj_property->stateid) ){
				$url = \Property_URL::get_instance()->get_permalink_property(\MD_Searchby_Property::get_instance()->state_pagename);
				$uri  = str_replace(' ','-',strtolower($obj_property->state));
				$state = array(
					'id'	=>	$obj_property->stateid,
					'name'	=>	$obj_property->state,
					'url'	=> 	$url . $obj_property->stateid . '-' . $uri
				);
			}
			return $state;
		}
		return false;
	}

	public function countyDetail($obj_property, $show = true){
		if( $show ){
			$countyid 	= '';
			$county_name 	= '';
			$uri 		= '';

			if(
				isset($obj_property['is_in_breadcrumb_filter']) &&
				$obj_property['is_in_breadcrumb_filter'] == 0 &&
				$obj_property['is_in_wp_page'] == 0 )
			{
				$url = \Property_URL::get_instance()->get_permalink_property(\MD_Searchby_Property::get_instance()->county_pagename);
				$countyid 		= $obj_property['id'];
				$county_name 	= $obj_property['full'];
				$uri 			= str_replace(' ','-',strtolower($county_name));
				$county_url 	= $url . 'mls-' . $countyid . '-' . $uri;
			}else{
				$countyid 		= $obj_property['id'];
				$county_name 	= $obj_property['full'];
				$county_url 	= $obj_property['url'];
			}

			$county = array(
				'id'	=>	$countyid,
				'name'	=>	$county_name,
				'url'	=>	$county_url
			);

			return $county;
		}
		return false;
	}

	public function cityDetail($obj_property, $show = true){
		if( $show ){
			$cityid 	= '';
			$city_name 	= '';
			$uri 		= '';


			if(
				isset($obj_property['is_in_breadcrumb_filter']) &&
				$obj_property['is_in_breadcrumb_filter'] == 0 &&
				$obj_property['is_in_wp_page'] == 0 )
			{
				$url 		= \Property_URL::get_instance()->get_permalink_property(\MD_Searchby_Property::get_instance()->city_pagename);
				$cityid 	= $obj_property['id'];
				$city_name 	= $obj_property['full'];
				$uri 		= str_replace(' ','-',strtolower($city_name));
				$city_url 	= $url . 'mls-' . $cityid . '-' . $uri;
			}else{
				$cityid 	= $obj_property['id'];
				$city_name 	= $obj_property['full'];
				$city_url 	= $obj_property['url'];
			}

			$city = array(
				'id'	=>	$cityid,
				'name'	=>	$city_name,
				'url'	=>	$city_url
			);

			return $city;
		}

		return false;
	}

	public function zipDetail($obj_property, $show = true){
		if( $show ){
			$postal_code = '';

			$postal_code = $obj_property['property']->PostalCode;

			$zip = array(
				'id'	=>	$postal_code,
				'name'	=>	$postal_code
			);

			return $zip;
		}
		return false;
	}

	public function communityDetail($obj_property, $show = true){
		if( $show ){
			$communityid 		= '';
			$community_name 	= '';
			$uri 				= '';


			if(
				isset($obj_property['is_in_breadcrumb_filter']) &&
				$obj_property['is_in_breadcrumb_filter'] == 0 &&
				$obj_property['is_in_wp_page'] == 0 )
			{
				$url = \Property_URL::get_instance()->get_permalink_property(
					\MD_Searchby_Property::get_instance()->community_pagename
				);
				$communityid 	= $obj_property['id'];
				$community_name = $obj_property['full'];
				$uri 			= str_replace(' ','-',strtolower($community_name));
				$community_url 	= $url . 'mls-' . $communityid . '-' . $uri;
			}else{
				$communityid = $obj_property['id'];
				$community_name = $obj_property['full'];
				$community_url = $obj_property['url'];
			}

			$community = array(
				'id'	=>	$communityid,
				'name'	=>	$community_name,
				'url'	=>	$community_url
			);

			return $community;
		}
		return false;
	}

	public function getBreadCrumb($obj_property, $show_location){
		$breadCrumb = array();
		$breadCrumb = array(
			'country'	=>	$this->countryDetail($obj_property['country'], $show_location['country']),
			'state'		=>	$this->stateDetail($obj_property['state'], $show_location['state']),
			'county'	=>	$this->countyDetail($obj_property['county'], $show_location['county']),
			'city'		=>	$this->cityDetail($obj_property['city'], $show_location['city']),
			'community'	=>	$this->communityDetail($obj_property['community'], $show_location['community']),
			'zip'		=>	$this->zipDetail($obj_property['zip'], $show_location['zip']),
		);

		return json_decode(json_encode($breadCrumb), FALSE);
	}

	public function createPageForBreadcrumbTrail($property_data = null, $show_location = null){
		if( is_null($property_data) ){
			$property_data = \MD_Single_Property::get_instance()->getPropertyData();
		}

		if( is_null($show_location) ){
			$show_location = array(
				'country'	=>	false,
				'state'		=>	false,
				'county'	=>	false,
				'city'		=>	true,
				'community'	=>	true,
				'zip'		=>	false,
			);
		}
		$gcl = \mls\AccountEntity::get_instance()->get_coverage_lookup();
		$mls_bread_crumb 	= get_mls_breadcrumb($property_data['property'], $gcl);

		$bread_crumb 		= $this->getBreadCrumb($mls_bread_crumb, $show_location);

		$build_bread_crumb = array();

		if( count($bread_crumb) > 0 ){
			foreach($bread_crumb as $key=>$val){
				$url = '';
				if( $bread_crumb->$key && $bread_crumb->$key->id != 0 && $bread_crumb->$key->name != '' ){
					if($this->_check_breadcrumb_url($bread_crumb->$key->name, $bread_crumb, $key)){
						$url = $this->_check_breadcrumb_url($bread_crumb->$key->name, $bread_crumb, $key);
					}elseif( $this->_check_wp_page($bread_crumb->$key->name, $bread_crumb, $key) ){
						$url = $this->_check_wp_page($bread_crumb->$key->name, $bread_crumb, $key);
					}else{
						$url = $bread_crumb->$key->url;
					}
					$build_bread_crumb[] = '<a href="'.$url.'">'.$bread_crumb->$key->name.'</a>';
				}
			}
		}

		return $build_bread_crumb;
	}

	private function _check_breadcrumb_url($location_name, $object, $key){
		return \Breadcrumb_Url::get_instance()->getUrlFilter($location_name);
	}

	private function _check_in_location($location_name, $key = 'keyword'){
		return \mls\AccountEntity::get_instance()->get_coverage_lookup_key($location_name, $key = 'keyword');
	}

	private function _check_wp_page($location_name, $object, $key){
		$wp_page = get_page_by_title($location_name);
		if( $wp_page ){
			return esc_url( get_permalink( get_page_by_title( $location_name ) ) );
		}else{
			//check in _check_in_location
			$location = $this->_check_in_location($location_name);
			if( $location && isset($location['full']) ){
				$wp_page = get_page_by_title($location['full']);
				if( $wp_page ){
					return esc_url( get_permalink( get_page_by_title( $location['full'] ) ) );
				}else{
					$query = \MLS_Hook::get_instance()->md_query_page_title($location_name);
					if($query){
						return esc_url( get_permalink( $query[0]->ID ) );
					}
				}
			}
		}
		return false;
	}

}


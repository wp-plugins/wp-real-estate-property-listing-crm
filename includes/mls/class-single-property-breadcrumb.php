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
		if( $show ){
			$country = array(
				'id'	=>	0,
				'name'	=>	'',
				'url'	=>	''
			);

			if( $obj_property->countryid != '' || !is_null($obj_property->country) ){
				$url  = \Property_URL::get_instance()->get_permalink_property(\MD_Searchby_Property::get_instance()->country_pagename);
				$uri  = str_replace(' ','-',strtolower($obj_property->country));
				$country = array(
					'id'	=>	$obj_property->countryid,
					'name'	=>	$obj_property->country,
					'url' 	=> 	$url . $obj_property->countryid . '-' . $uri
				);
			}
			return $country;
		}
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
			$county = array(
				'id'	=>	0,
				'name'	=>	'',
				'url'	=>	''
			);

			if( $obj_property->countyid != '' || !is_null($obj_property->countyid) ){
				$url = \Property_URL::get_instance()->get_permalink_property(\MD_Searchby_Property::get_instance()->county_pagename);
				$uri  = str_replace(' ','-',strtolower($obj_property->county));
				$county = array(
					'id'	=>	$obj_property->countyid,
					'name'	=>	$obj_property->county,
					'url'	=>	$url . $obj_property->countyid . '-' . $uri
				);
			}
			return $county;
		}
		return false;
	}

	public function cityDetail($obj_property, $show = true){
		if( $show ){

			$cityid 	= '';
			$city_name 	= '';
			$uri 		= '';
			$source		= $obj_property['source'];

			$url 		= \Property_URL::get_instance()->get_permalink_property(\MD_Searchby_Property::get_instance()->city_pagename);
			$city_name 	= $obj_property['property']->StreetCity;
			$uri  		= str_replace(' ','-',strtolower($city_name));
			$ret_city 	= \mls\AccountEntity::get_instance()->get_coverage_lookup_key($city_name);
			$cityid 	= $ret_city['id'];

			$city = array(
				'id'	=>	$cityid,
				'name'	=>	$city_name,
				'url'	=>	$url . 'mls-' . $cityid . '-' . $uri
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
			$source				= $obj_property['source'];

			$url = \Property_URL::get_instance()->get_permalink_property(
				\MD_Searchby_Property::get_instance()->community_pagename
			);

			if( isset($obj_property['community']) && count($obj_property['community']) >= 1 ){
				$communityid 	= $obj_property['community']->community_id;
				$community_name = $obj_property['community']->community;
				$uri 			= str_replace(' ','-',strtolower($community_name));
				$community_url 	= $url . $source . '-' . $communityid . '-' . $uri;
			}else{
				$postal_code 	= $this->zipDetail($obj_property);
				$communityid 	= $postal_code['id'];
				$community_name = $communityid;
				$community_url 	= $url . $source . '-' . $communityid;
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
			'country'	=>	$this->countryDetail($obj_property, $show_location['country']),
			'state'		=>	$this->stateDetail($obj_property, $show_location['state']),
			'county'	=>	$this->countyDetail($obj_property, $show_location['county']),
			'city'		=>	$this->cityDetail($obj_property, $show_location['city']),
			'community'	=>	$this->communityDetail($obj_property, $show_location['community']),
			'zip'		=>	$this->zipDetail($obj_property, $show_location['zip']),
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

		$bread_crumb = $this->getBreadCrumb($property_data, $show_location);

		$build_bread_crumb = array();

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

		return $build_bread_crumb;
	}

	private function _check_breadcrumb_url($location_name, $object, $key){
		return \Breadcrumb_Url::get_instance()->getUrlFilter($location_name);
	}

	private function _check_wp_page($location_name, $object, $key){

		if( get_page_by_title($object->$key->name) ){
			return esc_url( get_permalink( get_page_by_title( $object->$key->name ) ) );
		}

		return false;
	}

}


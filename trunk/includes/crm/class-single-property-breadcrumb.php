<?php
namespace crm;
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
			$city = array(
				'id'	=>	0,
				'name'	=>	'',
				'url'	=>	''
			);

			if( $obj_property->cityid != '' || !is_null($obj_property->cityid) ){
				$url = \Property_URL::get_instance()->get_permalink_property(\MD_Searchby_Property::get_instance()->city_pagename);
				$uri  = str_replace(' ','-',strtolower($obj_property->city));
				$city = array(
					'id'	=>	$obj_property->cityid,
					'name'	=>	$obj_property->city,
					'url'	=>	$url . $obj_property->cityid . '-' . $uri
				);
			}
			return $city;
		}
		return false;
	}

	public function zipDetail($obj_property, $show = true){
		if( $show ){
			$zip = array(
				'id'	=>	0,
				'name'	=>	''
			);

			if( $obj_property->zip != '' || !is_null($obj_property->zip) ){
				$url = \Property_URL::get_instance()->get_permalink_property(\MD_Searchby_Property::get_instance()->zip_pagename);
				$uri  = str_replace(' ','-',strtolower($obj_property->zip));
				$zip = array(
					'id'	=>	$obj_property->zip,
					'name'	=>	$obj_property->zip,
					'url'	=>	$url . $obj_property->zip
				);
			}
			return $zip;
		}
		return false;
	}

	public function communityDetail($obj_property, $show = true){
		if( $show ){
			$community = array(
				'id'	=>	0,
				'name'	=>	''
			);

			if( $obj_property->communityid != '' || !is_null($obj_property->community) ){
				$url = \Property_URL::get_instance()->get_permalink_property(\MD_Searchby_Property::get_instance()->community_pagename);
				$uri  = str_replace(' ','-',strtolower($obj_property->community));
				$zip = array(
					'id'	=>	$obj_property->communityid,
					'name'	=>	$obj_property->community,
					'url'	=>	$url . $obj_property->communityid . '-' . $uri
				);
			}
			return $zip;
		}
		return false;
	}

	public function addressDetail($obj_property, $show = true){
		if( $show ){
			$address = array(
				'id'	=>	0,
				'name'	=>	'',
				'url'	=>	''
			);

			if( $obj_property->address != '' || !is_null($obj_property->address) ){
				$url = \Property_URL::get_instance()->get_permalink_property(\MD_Searchby_Property::get_instance()->address_pagename);
				$address = array(
					'id'	=>	0,
					'name'	=>	$obj_property->address,
					'url'	=>	$url . urlencode($obj_property->address)
				);
			}
			return $address;
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
				'country'	=>	true,
				'state'		=>	true,
				'county'	=>	true,
				'city'		=>	true,
				'community'	=>	true,
				'zip'		=>	true,
			);
		}

		$bread_crumb = $this->getBreadCrumb($property_data['property'], $show_location);

		$build_bread_crumb = array();
		foreach($bread_crumb as $key=>$val){
			$url = '';
			if( $bread_crumb->$key && $bread_crumb->$key->id != 0 && $bread_crumb->$key->name != '' ){
				$url_swap = \Breadcrumb_Url::get_instance()->getUrlFilter($bread_crumb->$key->name);
				if( $url_swap ){
					$url = $url_swap;
				}else{
					$url = $bread_crumb->$key->url;
				}
				$build_bread_crumb[] = '<a href="'.$url.'">'.$bread_crumb->$key->name.'</a>';
			}
		}
		return $build_bread_crumb;
	}

}


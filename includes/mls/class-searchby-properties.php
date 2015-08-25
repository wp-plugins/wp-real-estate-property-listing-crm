<?php
namespace mls;
/**
 * Search By
 * Class to search property by filter
 * Also add rewrite rule for pages such as:
 * - Country
 * - State
 * - County
 * - City
 * - Zip
 * - Address
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
class MD_Searchby_Property {
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	public function __construct(){
		add_filter('search_property_result_mls',array($this,'searchPropertyResult'),10,1);
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

	public function displayCountryProperty($display_states = 1){
		$data 					= array();
		$data['country_id']		= get_query_var('countryid');
		$_REQUEST['countryid'] 	= $data['country_id'];
		$data['property_result']= \crm\Properties::get_instance()->get_properties();
		if( $display_states ){
			$child = $this->displayCountryStateChildren($_REQUEST['countryid']);
			$data = array_merge($data,$child);
		}
		return $data;
	}

	public function displayCountryStateChildren($country_id){
		$child = array();
		$child['child_list']		= \crm\Properties::get_instance()->getStatesByCountryId($country_id);
		$child['child_key']			= 'states';
		$child['child_label']		= 'State';
		$child['permalink'] 		= \Property_Url::get_instance()->get_permalink_property(\MD_Searchby_Property::get_instance()->state_pagename);
		if($child['child_list']->result =='success') {
			foreach($child['child_list']->states as $key => $val){
				$url = 	urlencode($val->state);
				$url = str_replace("%0D","",$url);
				$child['child_data'][] = array(
					'url' => $child['permalink'] . $val->id . '/' . $url,
					'name' => $val->state
				);
			}
		}
		return $child;
	}

	public function displayStateProperty($state_id, $display_city = 1){
		$data 					= array();
		$data['stateid']		= $state_id;
		$_REQUEST['stateid'] 	= $data['stateid'];
		$data['property_result']= \crm\Properties::get_instance()->get_properties();
		$data['child_list']		= \crm\Properties::get_instance()->getCitiesByStateid($data['stateid']);
		$data['child_key']		= 'city';
		$data['child_label']	= 'City';
		$data['permalink'] 		= \Property_Url::get_instance()->get_permalink_property(\MD_Searchby_Property::get_instance()->city_pagename);
		if($data['child_list']->result =='success') {
			foreach($data['child_list']->states as $key => $val){
				$url = str_replace( "\r\n", "\n", $val->city );
				$url = str_replace( " ", "-", strtolower($val->city) );

				$url_swap = \Breadcrumb_Url::get_instance()->getUrlFilter($val->city);
				if( $url_swap ){
					$url = $url_swap;
				}else{
					$url = $data['permalink'] . $val->id . '-' . $url;
				}

				$data['child_data'][] = array(
					'url' => $url,
					'name' => $val->city
				);
			}
		}

		return $data;
	}

	public function displayCityProperty($city_id){
		$data 					= array();
		$array_id				= array();
		$array_id['city_id']	= $city_id;
		$_REQUEST['cityid'] 	= $city_id;
		$data['property_result']= \crm\Properties::get_instance()->get_properties();

		$data['child_list']		= \crm\Properties::get_instance()->getCommunitiesByCityId($array_id);
		$data['child_key']		= 'community';
		$data['child_label']	= 'Community';
		$data['permalink'] 		= \Property_Url::get_instance()->get_permalink_property(\MD_Searchby_Property::get_instance()->community_pagename);
		if($data['child_list']->result =='success') {
			foreach($data['child_list']->communities as $key => $val){
				$url = str_replace( "\r\n", "\n", $val->community_name );
				$url = str_replace( " ", "-", strtolower($val->community_name) );

				$url_swap = \Breadcrumb_Url::get_instance()->getUrlFilter($val->community_name);
				if( $url_swap ){
					$url = $url_swap;
				}else{
					$url = $data['permalink'] . $val->community_id . '-' . $url;
				}

				$data['child_data'][] = array(
					'url' => $url,
					'name' => $val->community_name
				);
			}
		}
		return $data;
	}

	public function displayZipcodeProperty($location_id){
		$data 					= array();
		$data['zip']		= $location_id;
		$_REQUEST['zip'] 	= $data['zip'];
		$data['property_result']= \crm\Properties::get_instance()->get_properties();
		$data['child_list']		= array();
		$data['child_key']		= '';
		$data['child_label']	= '';
		$data['permalink'] 		= '';

		return $data;
	}

	public function displayCountyProperty($location_id){
		$data 					= array();
		$data['countyid']		= $location_id;
		$_REQUEST['countyid'] 	= $data['countyid'];
		$data['property_result']= \crm\Properties::get_instance()->get_properties();
		$data['child_list']		= array();
		$data['child_key']		= '';
		$data['child_label']	= '';
		$data['permalink'] 		= '';

		return $data;
	}

	public function displayCommunityProperty($location_id){
		$data 					= array();
		$data['communityid']	= $location_id;
		$_REQUEST['communityid'] 	= $data['communityid'];
		$data['property_result']= \crm\Properties::get_instance()->get_properties();
		$data['child_list']		= array();
		$data['child_key']		= '';
		$data['child_label']	= '';
		$data['permalink'] 		= '';

		return $data;
	}

	public function displayPropertyBy($search_by, $location_id, $display_child = 1){
		if( $search_by ){
			switch($search_by){
				case 'country':
					return $this->displayCountryProperty($location_id,$display_child);
				break;
				case 'state':
					return $this->displayStateProperty($location_id,$display_child);
				break;
				case 'city':
					return $this->displayCityProperty($location_id);
				break;
				case 'zip':
					return $this->displayZipcodeProperty($location_id);
				break;
				case 'county':
					return $this->displayCountyProperty($location_id);
				break;
				case 'community':
					return $this->displayCommunityProperty($location_id);
				break;
			}
		}
		return false;
	}

	public function searchPropertyResult($search_data = null){
		$property_data = array();

		$search_data['listing_office_id']	= isset($_REQUEST['listing_office_id']) ? sanitize_text_field($_REQUEST['listing_office_id']):'';
		$search_data['countyid'] 			= isset($_REQUEST['countyid']) ? sanitize_text_field($_REQUEST['countyid']):'';
		$search_data['stateid'] 			= isset($_REQUEST['stateid']) ? sanitize_text_field($_REQUEST['stateid']):'';
		$search_data['countyid'] 			= isset($_REQUEST['countyid']) ? sanitize_text_field($_REQUEST['countyid']):'';
		$search_data['countryid'] 			= isset($_REQUEST['countryid']) ? sanitize_text_field($_REQUEST['countryid']):'';
		$search_data['communityid'] 		= isset($_REQUEST['communityid']) ? sanitize_text_field($_REQUEST['communityid']):'';
		$search_data['cityid'] 				= isset($_REQUEST['cityid']) ? sanitize_text_field($_REQUEST['cityid']):'';
		$search_data['location'] 			= isset($_REQUEST['location']) ? sanitize_text_field($_REQUEST['location']):'';;
		$search_data['bathrooms'] 			= isset($_REQUEST['bathrooms']) ? sanitize_text_field($_REQUEST['bathrooms']):'';
		$search_data['bedrooms'] 			= isset($_REQUEST['bedrooms']) ? sanitize_text_field($_REQUEST['bedrooms']):'';
		$search_data['transaction'] 		= isset($_REQUEST['transaction']) ? sanitize_text_field($_REQUEST['transaction']):'';
		$search_data['communityid'] 		= isset($_REQUEST['communityid']) ? sanitize_text_field($_REQUEST['communityid']):'';
		$search_data['property_type'] 		= isset($_REQUEST['property_type']) ? sanitize_text_field($_REQUEST['property_type']):'';
		$search_data['property_status'] 	= isset($_REQUEST['property_status']) ? sanitize_text_field($_REQUEST['property_status']):'';
		$search_data['min_listprice'] 		= isset($_REQUEST['min_listprice']) ? sanitize_text_field($_REQUEST['min_listprice']):'';
		$search_data['max_listprice'] 		= isset($_REQUEST['max_listprice']) ? sanitize_text_field($_REQUEST['max_listprice']):'';
		$search_data['orderby'] 			= isset($_REQUEST['orderby']) ? sanitize_text_field($_REQUEST['orderby']):'';
		$search_data['order_direction']		= isset($_REQUEST['order_direction']) ? sanitize_text_field($_REQUEST['order_direction']):'';
		$search_data['limit']				= isset($_REQUEST['limit']) ? sanitize_text_field($_REQUEST['limit']):\MD_Search_Utility::get_instance()->search_limit();
		if( has_filter('before_get_properties_mls') ){
			$search_data = apply_filters('before_get_properties_mls', $search_data);
		}

		if( has_filter('before_get_properties_search_query') ){
			$search_data = apply_filters('before_get_properties_search_query', $search_data);
		}

		$property_data = \MLS_Property::get_instance()->get_properties($search_data);

		if( $property_data->total > 0 ){
			return $property_data;
		}else{
			return false;
		}
	}
}


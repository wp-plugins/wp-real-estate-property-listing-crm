<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Plugin Name.
 * Class to set data for single property pages
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
class MD_Single_Property {
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	protected $current_page;

	protected $property_data;

	protected $default_path;

	protected $data_source;

	public function __construct(){
		$this->setCurrentProperty('property');
		add_action('parse_query', array($this, 'parse_query'));
		add_filter('wp_title', array($this,'chage_wp_title'), 10, 2 );
		add_filter('the_title', array($this,'chage_page_title'),10, 2 );
	}

	public function chage_page_title($title, $id){
		// @TODO there should be settings to choose default page for property container
		if( in_the_loop() && $id == get_the_ID() ){
			$data = \MD_Single_Property::get_instance()->getPropertyData();
			if( $data ){
				$title = $data['property']->displayAddress();
			}
		}
		return $title;
	}

	public function chage_wp_title($title, $sep){
		$data 	= \MD_Single_Property::get_instance()->getPropertyData();
		$add_string = '';
		if( $data && isset($data['property']) ){
			$add_string = apply_filters('wp_title_' . $data['source'], $data);
			$title 	= $data['property']->displayAddress();
		}
		return $title . $add_string;
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

	public function setCurrentProperty($property_url){
		$this->current_page = $property_url;
	}

	public function getCurrentPropertyPage(){
		return $this->current_page;
	}

	/**
	 * set the property_data, to accept the result from addActionParseQuery method
	 * */
	public function setPropertyData($data){
		$this->property_data = $data;
	}

	/**
	 * get the data that is set
	 * @see setPropertyData
	 * */
	public function getPropertyData(){
		return $this->property_data;
	}

	/**
	 * Set where the data is coming from
	 * - we evaluate only two source
	 * 1) CRM
	 * 2) MLS
	 * */
	public function setApiDataSource($data_source){
		$this->data_source = $data_source;
	}

	/**
	 * we get the data source
	 * @return string	either MLS or CRM	@check method setApiDataSource
	 * */
	public function getApiDataSource(){
		return $this->data_source;
	}

	public function getSinglePropertyDataURL($url){
		$data					= array();
		$data_property			= array();
		$data['url'] 			= $url;
		$data['parse_property'] = explode( '-', $data['url']);
		$data['property_id'] 	= $data['parse_property'][0];
		$data_property 			= $this->getSinglePropertyData($data['property_id']);

		if( $data_property ){
			return ($data + $data_property);
		}

	}

	public function getSinglePropertyData($property_id, $broker_id = null){
		$data = array();
		if( is_null($broker_id) ){
			$broker_id	= \CRM_Account::get_instance()->get_broker_id();
		}
		if( isset($property_id) && isset($broker_id) ){
			// check the crm first
			$crm = \CRM_Property::get_instance()->get_property($property_id, $broker_id );

			if( $crm ){
				$data['property'] 	= $crm->properties;
				$data['photos'] 	= $crm->photos;
				$data['agent'] 		= $crm->agent;
				$data['related'] 	= null;
				$data['source']   	= 'crm';
			}else{
				// then its mls
				$mls = \MLS_Property::get_instance()->get_property($property_id);
				if( $mls ){
					$data['property'] 			= $mls['properties'];
					$data['photos']   			= $mls['photos'];
					$data['community']   		= $mls['community'];
					$data['source']   			= 'mls';
					$data['mls_type']   		= $mls['mls_type'];
					$data['last_mls_update']   	= $mls['last_mls_update'];
				}
			}
		}

		return $data;
	}

	/**
	 * Hook filter for WP
	 * - when the page url 'property' is call
	 * - this method is call on top of it, so we can call it the entire page
	 * - treat this as a global
	 * */
	public function parse_query(){
		global $wp_query;

		$property_url 	= $this->getCurrentPropertyPage();
		$data 			= array();
		$property_url 	= strtolower($property_url);
		if( isset($wp_query->queried_object) ){
			if( $wp_query->queried_object->post_name == $property_url && is_page($property_url) ){
				$url 					= get_query_var('url');
				$check_property_by_url 	= $this->getSinglePropertyDataURL($url);
				if( $check_property_by_url['source'] == 'crm' ){
					$this->setApiDataSource('crm');
				}else{
					$this->setApiDataSource('mls');
				}
				// set the data and we grab it later
				$this->setPropertyData($check_property_by_url);
			}
		}
		return false;
	}

}


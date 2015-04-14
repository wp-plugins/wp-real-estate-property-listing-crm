<?php
namespace crm;
/**
 * Handle logic for fetching properties
 * */
class AccountEntity{

	protected static $instance = null;

	private $account_details;

	public function __construct(){
		$this->set_account_details();
		add_filter('location_lookup_crm',array($this,'createCountryLookup'),10,2);
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * this will store account from the database for later use
	 * */
	public function init_account_store_db(){
		$this->set_account_details();
		add_filter('location_lookup_crm',array($this,'get_autocomplete_location'),10,1);
	}


	public function set_account_details(){
		$account_details_keyword 	= \Property_Cache::get_instance()->getCacheAccountDetailsKeyword();
		$cache_keyword 	  			= $account_details_keyword->id;
		//\DB_Store::get_instance()->del($cache_keyword);
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$this->account_details = \DB_Store::get_instance()->get($cache_keyword);
		}else{
			$md_client 				= \Clients\Masterdigm_CRM::instance()->connect();
			$this->account_details 	= $md_client->getAccountDetails();
			\DB_Store::get_instance()->put($cache_keyword, $this->account_details);
		}
	}

	public function get_account_details( $account = null ){
		$account_details = $this->account_details;
		if( $account_details->result == 'success' ){
			if( !is_null($account) ){
				if( $this->account_details->data && isset($this->account_details->data->$account) ){
					return $this->account_details->data->$account;
				}
			}else{
				if( $this->account_details->data ){
					return $this->account_details->data;
				}
			}
		}
		return false;
	}

	public function get_account_data($data_name){
		$this->set_account_details();
		$account_details = $this->get_account_details();
		if($account_details){
			return isset($account_details->$data_name) ? $account_details->$data_name:'';
		}
		return false;
	}

	public function getFeedLocation(){
		if( isMLS() ){
			$location = array('state_id' => CRM_SEARCH_LOOKUP_STATE );
		}
		if( isCRM() ){
			$account = $this->get_account_details();
			if( $account ){
				$location = array('country_id' => $account->country_id );
				return $location;
			}
		}
		return false;
	}

	public function getCountryLookup(){
		$location 	= $this->getFeedLocation();
		return $location;
	}

	public function getCoverageLookup($location = null){
		$coverage_lookup_cache_keyword 	= \Property_Cache::get_instance()->getCacheCoverageLookupKeyword();
		$cache_keyword 	  				= $coverage_lookup_cache_keyword->id;
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$autocomplete_result = \DB_Store::get_instance()->get($cache_keyword);
		}else{
			$location				= $this->getCountryLookup();
			$md_client 				= \Clients\Masterdigm_CRM::instance()->connect();
			$autocomplete_result 	= $md_client->getCoverageLookup($location);
			\DB_Store::get_instance()->put($cache_keyword,$autocomplete_result);
		}

		return $autocomplete_result;
	}

	public function getCountryCoverageLookup(){
		$location = array();
		$location = $this->getCoverageLookup();
		return $location;
	}

	/**
	 * create a country look up
	 * - store it in _options table, if it doesn't exsits
	 * - create a json file
	 * */
	public function createCountryLookup($location = null, $search_type = 'full'){
		$json_location 	= array();
		$location 		= $this->getCountryCoverageLookup();

		if( $location->result == 'success' ){
			//create a json
			foreach($location->lookups as $items){
				if( $search_type == 'full' ){
					$json_location[] = array(
						'keyword'=>preg_replace('/(\s)+/', ' ', $items->full),
						'id'=>$items->id,
						'type'=>$items->location_type,
					);
				}else{
					$json_location[] = array(
						'keyword'=>preg_replace('/(\s)+/', ' ', $items->keyword),
						'id'=>$items->id,
						'type'=>$items->location_type,
					);
				}
			}
		}

		return $json_location;
	}

	public function get_fields($field = null){
		$data 		= array($field);
		$account_fields_keyword = \Property_Cache::get_instance()->getCacheAccountFieldsKeyword();
		$cache_keyword 	  		= $account_fields_keyword->id;
		//\DB_Store::get_instance()->del($cache_keyword);
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$get_fields = \DB_Store::get_instance()->get($cache_keyword);
		}else{
			$md_client 	= \Clients\Masterdigm_CRM::instance()->connect();
			$get_fields = $md_client->getFields($data);
			\DB_Store::get_instance()->put($cache_keyword, $get_fields);
		}
		return $get_fields;
	}

	public function get_market_coverage(){
		$market_coverage = array();
		$cache_keyword = 'market_coverage';
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$market_coverage 	= \DB_Store::get_instance()->get($cache_keyword);
		}else{
			$account_id 		= $this->get_broker_id();
			$gemtkCRM 			= \Clients\Masterdigm_CRM::instance()->connect();
			$market_coverage 	= $gemtkCRM->getAccountCoverage();
			\DB_Store::get_instance()->put($cache_keyword,$market_coverage);
		}
		return $market_coverage;
	}

	public function get_property_photo($propertyID){
		$gemtkCRM = \Clients\Masterdigm_CRM::instance()->connect();
		return $gemtkCRM->getPhotosByPropertyId($propertyID);
	}

	public function get_broker_id(){
		return get_option( 'broker_id' );
	}

	public function get_user_id(){
		$user_id = 0;
		if( get_option( 'user_id' ) ){
			$user_id = get_option( 'user_id' );
		}else{
			$this->set_account_details();
			$account_details = $this->get_account_details();
			$user_id = $account_details->userid;
		}
		return $user_id;
	}

	public function get_logo(){
		$logo = $this->get_account_data('company_logo');
		preg_match("/^.+?\www(.+)$/is" , $logo, $match);
		$url = substr( $logo , 0 ,4 ) == 'http' ? $logo : 'http://www.masterdigm.com'.trim($match[1]);

		return $url;
	}

	/**
	 * @TODO : make the location in the breadcrumb dropdown to get ID
	 * */
	public function build_location_array(){
		$account = \crm\AccountEntity::get_instance()->get_account_details();
	}

	public function optionStateByCountry($action = 'get', $option_value = null){
		switch($action){
			case 'update':
				update_option('states_by_country', $option_value);
			break;
			case 'delete':
				delete_option('states_by_country');
			break;
			default:
			case 'get':
				return get_option('states_by_country');
			break;
		}
	}

	public function getStatesByCountryId($country_id = null){
		$get_option_states_by_country = $this->optionStateByCountry('get');

		if( $get_option_states_by_country ){
			return $get_option_states_by_country;
		}else{
			$country_id = $this->get_account_data('country_id');

			$md_client 	= \Clients\Masterdigm_CRM::instance()->connect();
			$get_states = $md_client->getStatesByCountryId($country_id);
			if( $get_states->result == 'success' ){
				$this->optionStateByCountry('update',$get_states);
			}

			$get_option_states_by_country = $this->optionStateByCountry('get');
		}
		return $get_option_states_by_country;
	}

	public function optionCoverageArea($action = 'get', $option_value = null){
		switch($action){
			case 'update':
				update_option('coverage_area', $option_value);
			break;
			case 'delete':
				delete_option('coverage_area');
			break;
			default:
			case 'get':
				return get_option('coverage_area');
			break;
		}
	}

	public function getCoverageArea(){
		$get 			= $this->optionCoverageArea('get');
		$location 		= array();
		if( $get ){
			return $get;
		}else{
			$coverage =	\crm\Properties::get_instance()->getAccountCoverage();
			$this->optionCoverageArea('update',$coverage);
			$get = $this->optionCoverageArea('get');
		}
		return $get;
	}
}

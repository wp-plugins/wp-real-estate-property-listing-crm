<?php
class CRM_Account{
	protected static $instance = null;

	public $crm;

	public function __construct(){
		$this->crm = new Masterdigm_CRM;
		add_filter('location_lookup_crm',array($this,'create_country_lookup'),10,2);
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
	 * get the account details of the current CRM key
	 * @return array | object | getAccountDetails()
	 * */
	public function get_account_details(){
		$account_details_keyword 	= \Property_Cache::get_instance()->getCacheAccountDetailsKeyword();
		$cache_keyword 	  			= $account_details_keyword->id;
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$account_details = \DB_Store::get_instance()->get($cache_keyword);
		}else{
			$account_details 	= $this->crm->get_account_details();
			\DB_Store::get_instance()->put($cache_keyword, $account_details);
		}
		return $account_details;
	}

	/**
	 * Get all account detail by all data or individually
	 * @param	$key	string		default null, else grab the key result in account_details
	 * @return	array | object
	 * */
	public function get_account_data($key = null){
		$account_details = $this->get_account_details();
		if( $account_details->result == 'success' ){
			if( !is_null($key) ){
				if( $account_details->data && isset($account_details->data->$key) ){
					return $account_details->data->$key;
				}
			}else{
				if( $account_details && isset($account_details->data) ){
					return $account_details->data;
				}
			}
		}
		return false;
	}

	public function get_feed_location(){
		$country_id = $this->get_account_data('country_id');
		if( $country_id && isset($country_id) ){
			$location = array('country_id' => $country_id );
			return $location;
		}
		return false;
	}

	public function get_country_lookup(){
		$location 	= $this->get_feed_location();
		return $location;
	}

	public function get_coverage_lookup($location = null){
		$coverage_lookup_cache_keyword 	= \Property_Cache::get_instance()->getCacheCoverageLookupKeyword();
		$cache_keyword 	  				= $coverage_lookup_cache_keyword->id;
		//\DB_Store::get_instance()->del($cache_keyword);
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$autocomplete_result = \DB_Store::get_instance()->get($cache_keyword);
		}else{
			$location				= $this->get_country_lookup();
			$autocomplete_result 	= $this->crm->get_coverage_lookup($location);
			\DB_Store::get_instance()->put($cache_keyword,$autocomplete_result);
		}

		return $autocomplete_result;
	}

	public function get_country_coverage_lookup(){
		$location = array();
		$location = $this->get_coverage_lookup();
		return $location;
	}

	/**
	 * create a country look up
	 * - store it in _options table, if it doesn't exsits
	 * - create a json file
	 * */
	public function create_country_lookup($location = null, $search_type = 'full'){
		$json_location 	= array();
		$location 		= $this->get_country_coverage_lookup();

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
		$data 					= array($field);
		$account_fields_keyword = \Property_Cache::get_instance()->getCacheAccountFieldsKeyword();
		$cache_keyword 	  		= $account_fields_keyword->id;
		//\DB_Store::get_instance()->del($cache_keyword);
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$get_fields = \DB_Store::get_instance()->get($cache_keyword);
		}else{
			$get_fields = $this->crm->get_fields($data);
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
			$market_coverage 	= $this->crm->get_account_coverage();
			\DB_Store::get_instance()->put($cache_keyword, $market_coverage);
		}
		return $market_coverage;
	}
}

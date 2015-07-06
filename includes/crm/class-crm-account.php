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

	public function get_broker_id(){
		$broker_id = MD_BROKER_ID;
		if( !$broker_id ){
			$broker_id = $this->get_account_data('accountid');
		}
		return $broker_id;
	}

	/**
	 * get the account details of the current CRM key
	 * @return array | object | getAccountDetails()
	 * */
	public function get_account_details(){
		$account_details_keyword 	= \Property_Cache::get_instance()->getCacheAccountDetailsKeyword();
		$cache_keyword 	  			= $account_details_keyword->id;
		//\DB_Store::get_instance()->del($cache_keyword);
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
				}else{
					return false;
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
						'keyword'=>preg_replace('/(\s)+/', ' ', $items->full) . ' [ ' . $items->location_type . ' ]',
						'id'=>$items->id,
						'type'=>$items->location_type,
					);
				}else{
					$json_location[] = array(
						'keyword'=>preg_replace('/(\s)+/', ' ', $items->keyword) . ' [ ' . $items->location_type . ' ]',
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

	public function push_crm_data( $array_data ){
		extract($array_data);

		$userid 	= 0;

		$account_id = $this->get_broker_id();
		$this->crm->set_account_Id( $account_id );

		$get_userid = $this->get_account_data('userid');
		if( $get_userid ){
			$userid = $get_userid;
		}

		$response   = $this->crm->save_lead(
			array(
				'first_name'         => sanitize_text_field(isset($yourname)) ? sanitize_text_field($yourname):'',
				'last_name'          => sanitize_text_field(isset($yourlastname)) ? sanitize_text_field($yourlastname):'',
				'middle_name'        => sanitize_text_field(isset($yourmidname)) ? sanitize_text_field($yourmidname):'',
				'lead_source'        => sanitize_text_field(isset($lead_source)) ? sanitize_text_field($lead_source):'',
				'phone_home'         => sanitize_text_field(isset($phone_home)) ? sanitize_text_field($phone_home):'',
				'phone_mobile'       => sanitize_text_field(isset($phone_mobile)) ? sanitize_text_field($phone_mobile):'',
				'phone_work'         => sanitize_text_field(isset($phone_work)) ? sanitize_text_field($phone_work):'',
				'phone_fax'          => sanitize_text_field(isset($phone_fax)) ? sanitize_text_field($phone_fax):'',
				'email1'             => sanitize_text_field(isset($email1)) ? sanitize_text_field($email1):'',
				'address_street'     => sanitize_text_field(isset($address_street)) ? sanitize_text_field($address_street):'',
				'address_city'       => sanitize_text_field(isset($address_city)) ? sanitize_text_field($address_city):'',
				'address_state'      => sanitize_text_field(isset($address_state)) ? sanitize_text_field($address_state):'',
				'address_postalcode' => sanitize_text_field(isset($address_postalcode)) ? sanitize_text_field($address_postalcode):'',
				'address_country'    => sanitize_text_field(isset($address_country)) ? sanitize_text_field($address_country):'',
				'company'            => sanitize_text_field(isset($company)) ? sanitize_text_field($company):'',
				'assigned_to'		 => sanitize_text_field(isset($userid)) ? sanitize_text_field($userid):'',
				'note'				 => sanitize_text_field(isset($note)) ? sanitize_text_field($note):'',
				'source_url'		 => sanitize_text_field(isset($source_url)) ? sanitize_text_field($source_url):''
			)
		);

		return $response;
	}
}

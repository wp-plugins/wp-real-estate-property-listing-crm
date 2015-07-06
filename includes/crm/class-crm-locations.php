<?php
class CRM_Locations{
	protected static $instance = null;

	public $crm;

	public function __construct(){
		$this->crm = new Masterdigm_CRM;
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

	public function get_cities_by_stateId($state_id){
		$cities = array();
		$cache_keyword = 'property-city-by-state-' . $state_id;
		//\DB_Store::get_instance()->del($cache_keyword);
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$cities = \DB_Store::get_instance()->get($cache_keyword);
		}else{
			$cities	= $this->crm->get_cities_by_stateId($state_id);
			\DB_Store::get_instance()->put($cache_keyword,$cities);
		}

		return	$cities;
	}

	/**
	 * single id or array
	 * */
	public function get_communities_by_cityId($city_id){
		$communities 		= array();
		$data_city_id = $city_id;
		if( is_array($city_id['city_id'])){
			$data_city_id = $city_id['city_id'];
		}
		$keyword_city_id 	= implode('_', $data_city_id);
		$cache_keyword 		= 'property-communities-by-city-' . $keyword_city_id;

		//\DB_Store::get_instance()->del($cache_keyword);
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$communities = \DB_Store::get_instance()->get($cache_keyword);
		}else{
			$communities	= $this->crm->get_communities_by_cityId($city_id);
			\DB_Store::get_instance()->put($cache_keyword, $communities);
		}

		return	$communities;
	}

	public function get_states_by_countryId($country_id){
		$state = array();
		$cache_keyword = 'property-state-by-country-'. $country_id;
		//\DB_Store::get_instance()->del($cache_keyword);
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$state = \DB_Store::get_instance()->get($cache_keyword);
		}else{
			$state	= $this->crm->get_states_by_countryId($country_id);
			\DB_Store::get_instance()->put($cache_keyword,$state);
		}
		return	$state;
	}
}

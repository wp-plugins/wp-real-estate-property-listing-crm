<?php
namespace mls;
/**
 * Handle logic for fetching properties
 * */
class AccountEntity{

	protected static $instance = null;

	private $account_details;

	public $mls;

	public function __construct(){
		$this->mls = new \Masterdigm_MLS;
		$this->set_account_details();
		add_filter('location_lookup_mls',array($this,'createCountryLookup'),10,2);
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

	public function set_account_details(){
		$this->get_coverage_lookup();
	}

	public function get_coverage_lookup(){
		$cache_keyword 	= 'mls_location';
		$location 		= array();
		if( cache_get($cache_keyword) ){
			$location = cache_get($cache_keyword);
		}else{
			$location 	= $this->mls->get_coverage_lookup( null );
			cache_set($cache_keyword, $location);
		}
		return $location;
	}

	/**
	 * create a country look up
	 * - store it in _options table, if it doesn't exsits
	 * - create a json file
	 * */
	public function createCountryLookup($location = null, $search_type = 'full'){
		$json_location 	= array();
		$location 		= $this->get_coverage_lookup();

		if( isset($location->result) && $location->result == 'success' ){
			//create a json
			foreach($location->lookups as $items){
				if( $search_type == 'full' ){
					$json_location[] = array(
						'keyword'		=>	$items->full,
						'locationname'	=>	$items->keyword,
						'id'			=>	$items->id,
						'type'			=>	$items->location_type,
					);
				}else{
					$json_location[] = array(
						'keyword'		=>	$items->keyword,
						'locationname'	=>	$items->keyword,
						'id'			=>	$items->id,
						'type'			=>	$items->location_type,
					);
				}
			}
		}

		return $json_location;
	}

	public function get_coverage_lookup_key($string, $array_key = 'keyword'){
		$result 	= array();
		$string 	= strtolower($string);
		$location 	= $this->get_coverage_lookup();
		$city_id 	= 0;
		$city 		= '';
		if( $location->result == 'success' && isset($location->result) ){
			foreach($location->lookups as $key => $val){
				$find = strtolower($val->$array_key);
				if( $find == $string ){
					$result = array(
						'keyword'	=>	$val->keyword,
						'full'		=>	$val->full,
						'id'		=>	$val->id,
						'type'		=>	$val->location_type,
						'city'		=>	isset($val->city_id) ? $val->city:'',
						'city_id'	=>	isset($val->city_id) ? $val->city_id:0,
					);
				}
			}
		}
		return $result;
	}

	public function get_property_type(){
		$type = array();
		$cache_keyword 	= 'mls_property_type';
		$property_type 	= array();
		//cache_del($cache_keyword);
		if( cache_get($cache_keyword) ){
			$property_type = cache_get($cache_keyword);
		}else{
			$property_type 	= $this->mls->get_property_types();
			if( $property_type && isset($property_type->result) == 'success'){
				foreach($property_type->types as $k => $v){
					$key = md_trim_tolower($v);
					$type[$key] = $v;
				}
			}else{
				return false;
			}
			$property_type = $type;
			cache_set($cache_keyword, $property_type);
		}
		return $property_type;
	}

	public function get_property_type_key($key = ''){
		$types = $this->get_property_type();
		if( $types && isset($types->result) && $types->result == 'success' ){
			$get_key = array_key_exists($key,$types->types);
			if( $get_key ){
				return $types->types[$get_key];
			}
		}else{
			return false;
		}
	}

	public function get_cities_by_mls($mls = array()){
		$cities = array();
		$cache_keyword = 'mls-cities';
		if( cache_get($cache_keyword) ){
			$cities = cache_get($cache_keyword);
		}else{
			$cities	= $this->mls->get_cities_by_mls();
			cache_set($cache_keyword,$cities);
		}
		return	$cities;
	}

	public function get_communities_by_city_id($city_id){
		$communities = array();
		$cache_keyword = 'mls-communities-'.$city_id;
		if( cache_get($cache_keyword) ){
			$communities = cache_get($cache_keyword);
		}else{
			$communities	= $this->mls->get_communities_by_city_id($city_id);
			cache_set( $cache_keyword, $communities );
		}
		return	$communities;
	}
}

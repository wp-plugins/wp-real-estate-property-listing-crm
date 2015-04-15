<?php
namespace mls;
/**
 * Handle logic for fetching properties
 * */
class AccountEntity{

	protected static $instance = null;

	private $account_details;

	public function __construct(){
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
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$location = \DB_Store::get_instance()->get($cache_keyword);
		}else{
			$md_client 	= \Clients\Masterdigm_MLS::instance()->connect();
			$location 	= $md_client->getCoverageLookup( 'crmls' );
			\DB_Store::get_instance()->put($cache_keyword, $location);
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

		if( $location->result == 'success' ){
			//create a json
			foreach($location->lookups as $items){
				if( $search_type == 'full' ){
					$json_location[] = array(
						'keyword'	=>	$items->full,
						'id'		=>	$items->id,
						'type'		=>	$items->location_type,
					);
				}else{
					$json_location[] = array(
						'keyword'	=>	$items->keyword,
						'id'		=>	$items->id,
						'type'		=>	$items->location_type,
					);
				}
			}
		}

		return $json_location;
	}

}

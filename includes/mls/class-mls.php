<?php
class Masterdigm_MLS implements iMasterdigm_API{

	public $client;
	protected $mls_key;
	protected $mls_token;
	protected $mls_endpoint;
	protected $mls_version;
	protected static $instance = null;

	public function __construct(){
		/**
		 * get the api credentials
		 * @see /config.php
		 * */
		$this->mls_key 		= MD_API_KEY;
		$this->mls_token 	= MD_API_TOKEN;
		$this->mls_endpoint = MLS_API_ENDPOINT;
		$this->mls_version  = MLS_API_VERSION;
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
	 * connect to the api
	 * @return	object
	 * */
	public function connect(){
		$this->client = new \MlsConnector\MlsConnector( $this->mls_key, $this->mls_token, $this->mls_endpoint , $this->mls_version );
	}

	/**
	 * get client return
	 * @see connect() method
	 * */
	public function get_client(){
		$this->connect();

		return $this->client;
	}

	public function get_property($property_id, $broker_id = null){
		return $this->get_client()->getPropertyByMatrixID($property_id, $broker_id);
	}

	public function get_properties($search_criteria_data){
		return $this->get_client()->getProperties($search_criteria_data);
	}

	public function add_property_alert($data = array()){
		return $this->get_client()->addPropertyAlert($data);
	}

	public function get_location(){}

	public function get_coverage_lookup($data = null){
		return $this->get_client()->getCoverageLookup($data);
	}

	public function get_cities_by_mls($mls = array()){
		return $this->get_client()->getCitiesByMls($mls);
	}

	public function get_communities_by_city_id($city_id){
		return $this->get_client()->getCommunitiesByCityId($city_id);
	}

	public function get_property_types(){
		return $this->get_client()->getPropertyTypes();
	}
}

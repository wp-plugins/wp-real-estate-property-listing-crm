<?php
/**
 * masterdigm crm api
 * use to connect and use CRM API methods
 * @see /includes/api/masterdigm/crm/class-crm-client.php
 * */
class Masterdigm_CRM implements iMasterdigm_API{
	public $client;
	public $key;
	public $token;
	public $endpoint;
	public $version;
	protected static $instance = null;

	public function __construct(){
		/**
		 * get the api credentials
		 * @see /config.php
		 * */
		$this->key 		= MD_API_KEY;
		$this->token 	= MD_API_TOKEN;
		$this->endpoint = MD_API_ENDPOINT;
		$this->version  = MD_API_VERSION;
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
	 * Setup for new client connection credentials
	 * - needed for such cases that we need not use the default config credential
	 *
	 * @param string $key
	 * @param string $token
	 * @param string $endpoint
	 */
	public function setCredentials( $key , $token , $endpoint = MD_API_ENDPOINT , $version = MD_API_VERSION)
	{
		$this->key 		= $key;
		$this->token 	= $token;
		$this->endpoint = $endpoint;
		$this->version 	= $version;

		return $this;
	}

	/**
	 * connect to the api
	 * @return	object
	 * */
	public function connect(){
		$this->client = new \Masterdigm\MD_Client( $this->key, $this->token, $this->endpoint , $this->version );
	}

	/**
	 * get client return
	 * @see connect() method
	 * */
	public function get_client(){
		$this->connect();

		return $this->client;
	}

	/**
	 * for testing purposes only
	 * */
	public function test_connection(){
		return $this->get_client()->testConnection();
	}

	public function set_account_Id($account_id){
		return $this->get_client()->setAccountId($account_id);
	}

	/**
	 * get single / full details of property, singular
	 * @var		$property_id		int		get the unique ID
	 * @var		$broker_id			int		default is null, if null will grab the broker id via api credentials
	 * @return	array object
	 * */
	public function get_property($property_id, $broker_id = null){
		return $this->get_client()->getPropertyById($property_id, $broker_id);
	}

	/**
	 * get all properties base on search data.
	 * @var		$search_data	array	default is null
	 * @return	array	object
	 * */
	public function get_properties($search_data = null){
		return $this->get_client()->getProperties($search_data);
	}

	public function get_location($location = null){
		return $this->get_client()->getCoverageLookup($location);
	}

	/**
	 * get the current account details of the current CRM key
	 * */
	public function get_account_details(){
		return $this->get_client()->getAccountDetails();
	}

	/**
	 * @param	$user_id	int		get the userid in the get_account_details()
	 * @paran	$array_location		default array, else list of location id
	 * 								acceptable data are:
	 * 								cityid and communityid both are array base
	 * 								example:
	 * 								array(
	 *									'cityid'=>array( 1707 , 1421 ),
	 *									'communityid' => array( 13 )
	 *								)
	 * @return	array object
	 * */
	public function get_featured_properties($user_id = null, $array_location_id = array()){
		return $this->get_client()->getFeaturedProperties($user_id, $array_location_id);
	}

	/**
	 * get the marketing coverage lookup, mostly locations
	 * */
	public function get_coverage_lookup($location = null){
		return $this->get_client()->getCoverageLookup($location);
	}

	public function get_fields($data = array()){
		return $this->get_client()->getFields($data);
	}

	public function get_account_coverage(){
		return $this->get_client()->getAccountCoverage();
	}

	public function get_cities_by_stateId($state_id){
		return $this->get_client()->getCitiesByStateid($state_id);
	}

	public function get_communities_by_cityId($city_id){
		return $this->get_client()->getCommunitiesByCityId($city_id);
	}

	public function get_states_by_countryId($country_id){
		return $this->get_client()->getStatesByCountryId($country_id);
	}

	public function get_photos_by_propertyId($property_id){
		return $this->get_client()->getPhotosByPropertyId($property_id);
	}

	public function save_lead($data){
		return $this->get_client()->saveLead($data);
	}

	public function get_agent_details($data){
		return $this->get_client()->getAgentDetails($data);
	}
}

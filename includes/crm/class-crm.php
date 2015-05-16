<?php
/**
 * @remove this
 * masterdigm crm api
 * use to connect and use CRM API methods
 * @see /includes/api/masterdigm/crm/class-crm-client.php
 * */
class CRM implements iMasterdigm_API{
	public $client;
	public $key;
	public $token;
	public $endpoint;
	public $version;

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

	public function get_location(){
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
		if( is_null($user_id) ){
			$user_id = \Masterdigm_CRM_Account::get_instance()->get_account_data('userid');
		}else{
			$user_id = 0;
		}
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
}

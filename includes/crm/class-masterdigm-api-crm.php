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

	public function __construct(){
		/**
		 * get the api credentials
		 * @see /config.php
		 * */
		$this->key 		= MD_API_KEY;
		$this->token 	= MD_API_TOKEN;
		$this->endpoint = MD_API_ENDPOINT;
		$this->version  = MD_API_VERSION;
		// auto-connect
		$this->connect();
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
}

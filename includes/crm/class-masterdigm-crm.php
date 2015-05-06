<?php
/*
 * Wrapper for the Masterdigm API - CRM
 * @note: will be depreciated
 * @see /includes/crm/class-masterdigm-api-crm.php
 * */
namespace Clients;

class Masterdigm_CRM{

	protected static $instance = array();

	public $client;

	protected $key;
	protected $token;
	protected $endpoint;
	protected $version;

	public function __construct( )
	{
		/** default credentials ******/
		$this->key 		= MD_API_KEY;
		$this->token 	= MD_API_TOKEN;
		$this->endpoint = MD_API_ENDPOINT;
		$this->version  = MD_API_VERSION;
	}

	public static function instance( $instance_name = 'default' )
	{
		if( isset( self::$instance[  $instance_name ] ) ){
			return self::$instance[  $instance_name ];
		}

		return self::$instance[  $instance_name ] = new \Clients\Masterdigm_CRM;
	}

	public function connect(){
		$client = new \Masterdigm\MD_Client( $this->key, $this->token, $this->endpoint , $this->version );
		return $client;
	}

	public function getClient()
	{
		return $this->client;
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
		$this->version = $version;

		return $this;
	}


}

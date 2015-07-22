<?php
/* remove
 * Wrapper for the Masterdigm API - MLS
 *
 * */
namespace Clients;

class Masterdigm_MLS{

	protected static $instance = array();

	public $client;

	protected $mls_key;
	protected $mls_token;
	protected $mls_endpoint;
	protected $mls_version;

	public function __construct( )
	{
		/** default credentials ******/
		$this->mls_key 		= MD_API_KEY;
		$this->mls_token 	= MD_API_TOKEN;
		$this->mls_endpoint = MLS_API_ENDPOINT;
		$this->mls_version  = MLS_API_VERSION;
	}

	public static function instance( $instance_name = 'default' )
	{
		if( isset( self::$instance[  $instance_name ] ) ){
			return self::$instance[  $instance_name ];
		}

		return self::$instance[  $instance_name ] = new \Clients\Masterdigm_MLS;
	}

	public function connect(){
		$client = new \MlsConnector\MlsConnector( $this->mls_key, $this->mls_token, $this->mls_endpoint , $this->mls_version );
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
	public function setCredentials( $key , $token , $endpoint , $version = 'v2')
	{
		$this->key 		= $key;
		$this->token 	= $token;
		$this->endpoint = $endpoint;
		$this->version = $version;

		return $this;
	}


}

<?php
interface iMasterdigm_API{
	public function get_property($property_id, $broker_id = null);
	public function get_properties($search_criteria_data);
	public function get_location();
}
class Masterdigm_CRM implements iMasterdigm_API{
	public $client;
	public $key;
	public $token;
	public $endpoint;
	public $version;

	public function __construct(){
		$this->key 		= MD_API_KEY;
		$this->token 	= MD_API_TOKEN;
		$this->endpoint = MD_API_ENDPOINT;
		$this->version  = MD_API_VERSION;
		$this->connect();
	}

	public function connect(){
		$this->client = new \Masterdigm\MD_Client( $this->key, $this->token, $this->endpoint , $this->version );
	}

	public function get_client(){
		return $this->client;
	}

	public function test_connection(){
		return $this->get_client()->testConnection();
	}

	public function get_property($property_id, $broker_id = null){
	}

	public function get_properties($search_criteria_data){
		return $this->get_client()->getProperties($search_criteria_data);
	}
}

class Masterdigm_CRM_Property{
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

	public function test_connect(){
		$this->crm->test_connection();
	}
}
class Masterdigm_CRM_Account{}
class Masterdigm_CRM_Push{}
/**
 * Use any API
 * */
class Masterdigm_Location{
}
/**
 * Use any API
 * */
class Masterdigm_Property {
	public $api;

	public function __construct($source_api){
		$this->api = $source_api;
	}

	public function connect(){
		return $this->api;
	}

	public function test_connection(){
		return $this->connect()->test_connection();
	}

	public function get_properties(){
		return $this->connect()->get_properties('');
	}
}
class WP_Property{
}
$crm_api 		= new Masterdigm_CRM;
$md_property	= new Masterdigm_Property($crm_api);
var_dump($md_property->test_connection());
var_dump($md_property->get_properties());
exit();

<?php
interface Masterdigm_API_DAO{
	public function connect($source);
	public function get_property($property_id, $broker_id);
	public function get_properties($search_criteria_data);
}
class Masterdigm_CRM_DAO{
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
	}

	public function connect(Masterdigm_API_Repository $connect){
		$this->client = new \Masterdigm\MD_Client($this->key, $this->token, $this->endpoint, $this->version );
	}
	public function get_client(){
		return $client;
	}
}
class Masterdigm_CRM_Factory {

}
class Masterdigm_MLS{

}

class Masterdigm_API implements Masterdigm_API_DAO{
	public $client;

	public function __construct(){

	}

	public function connect($source){
		$client = $source;
		return $client;
	}

	public function get_property($property_id, $broker_id){

	}

	public function get_properties(){

	}

	public function get_client(){
		return $this->client;
	}
}

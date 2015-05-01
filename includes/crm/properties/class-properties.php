<?php
namespace crm;
/**
 * Handle logic for fetching properties
 * */
class Properties{

	protected static $instance = null;

	private $account_details;

	public function __construct(){
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

	public function check_status($search_status = 0){
		$status = array();
		$fields = \crm\AccountEntity::get_instance()->get_fields();
		if( $fields->fields->status ){
			foreach($fields->fields->status as $key=>$val){
				$status[$key] = $val;
			}
		}
		if(array_key_exists($search_status, $status)){
			return true;
		}
	}

	/**
	 * get properties
	 *
	 * @return array | object
	 * */
	public function get_properties($search_data = null){

		$communityid = '';
		if( sanitize_text_field(isset($search_data['communityid'])) ){
			$communityid = sanitize_text_field($search_data['communityid']);
		}elseif( sanitize_text_field(isset($_REQUEST['communityid'])) ){
			$communityid = sanitize_text_field($_REQUEST['communityid']);
		}

		$countryid = '';
		if( sanitize_text_field(isset($search_data['countryid'])) ){
			$countryid = sanitize_text_field($search_data['countryid']);
		}elseif( sanitize_text_field(isset($_REQUEST['countryid'])) ){
			$countryid = sanitize_text_field($_REQUEST['countryid']);
		}

		$countyid = '';
		if( sanitize_text_field(isset($search_data['countyid'])) ){
			$countyid = sanitize_text_field($search_data['countyid']);
		}elseif( sanitize_text_field(isset($_REQUEST['countyid'])) ){
			$countyid = sanitize_text_field($_REQUEST['countyid']);
		}

		$stateid = '';
		if( sanitize_text_field(isset($search_data['stateid'])) ){
			$stateid = sanitize_text_field($search_data['stateid']);
		}elseif( sanitize_text_field(isset($_REQUEST['stateid'])) ){
			$stateid = sanitize_text_field($_REQUEST['stateid']);
		}

		$cityid = '';
		if( sanitize_text_field(isset($search_data['cityid'])) ){
			$cityid = sanitize_text_field($search_data['cityid']);
		}elseif( sanitize_text_field(isset($_REQUEST['cityid'])) ){
			$cityid = sanitize_text_field($_REQUEST['cityid']);
		}

		$zip = '';
		if( sanitize_text_field(isset($search_data['zip'])) ){
			$zip = sanitize_text_field($search_data['zip']);
		}elseif( sanitize_text_field(isset($_REQUEST['zip'])) ){
			$zip = sanitize_text_field($_REQUEST['zip']);
		}

		$lat = '0';
		if( sanitize_text_field(isset($search_data['lat'])) ){
			$lat = sanitize_text_field($search_data['lat']);
		}elseif( sanitize_text_field(isset($_REQUEST['lat'])) ){
			$lat = sanitize_text_field($_REQUEST['lat']);
		}

		$lon = '0';
		if( sanitize_text_field(isset($search_data['lon'])) ){
			$lon = sanitize_text_field($search_data['lon']);
		}elseif( sanitize_text_field(isset($_REQUEST['lon'])) ){
			$lon = sanitize_text_field($_REQUEST['lon']);
		}

		$location = '';
		if( sanitize_text_field(isset($search_data['q'])) ){
			$location = sanitize_text_field($search_data['q']);
		}elseif( sanitize_text_field(isset($_REQUEST['q'])) ){
			$location = sanitize_text_field($_REQUEST['q']);
		}

		$bathrooms = '';
		if( sanitize_text_field(isset($search_data['bathrooms'])) ){
			$bathrooms = sanitize_text_field($search_data['bathrooms']);
		}elseif( sanitize_text_field(isset($_REQUEST['bathrooms'])) ){
			$bathrooms = sanitize_text_field($_REQUEST['bathrooms']);
		}

		$bedrooms = '';
		if( sanitize_text_field(isset($search_data['bedrooms'])) ){
			$bedrooms = sanitize_text_field($search_data['bedrooms']);
		}elseif( sanitize_text_field(isset($_REQUEST['bedrooms'])) ){
			$bedrooms = sanitize_text_field($_REQUEST['bedrooms']);
		}

		$min_listprice = '0';
		if( sanitize_text_field(isset($search_data['min_listprice'])) ){
			$min_listprice = sanitize_text_field($search_data['min_listprice']);
		}elseif( sanitize_text_field(isset($_REQUEST['min_listprice'])) ){
			$min_listprice = sanitize_text_field($_REQUEST['min_listprice']);
		}

		$max_listprice = '0';
		if( sanitize_text_field(isset($search_data['max_listprice'])) ){
			$max_listprice = sanitize_text_field($search_data['max_listprice']);
		}elseif( sanitize_text_field(isset($_REQUEST['max_listprice'])) ){
			$max_listprice = sanitize_text_field($_REQUEST['max_listprice']);
		}

		$property_status = default_search_status();
		if( sanitize_text_field(isset($search_data['property_status'])) && sanitize_text_field($search_data['property_status']) != '' ){
			$property_status = sanitize_text_field($search_data['property_status']);
		}elseif( sanitize_text_field(isset($_REQUEST['property_status'])) && sanitize_text_field($_REQUEST['property_status']) != '' ){
			$property_status = sanitize_text_field($_REQUEST['property_status']);
		}

		$property_type = '0';
		if( sanitize_text_field(isset($search_data['property_type'])) ){
			$property_type = sanitize_text_field($search_data['property_type']);
		}elseif( sanitize_text_field(isset($_REQUEST['property_type'])) ){
			$property_type = sanitize_text_field($_REQUEST['property_type']);
		}

		$transaction = '';
		if(sanitize_text_field(isset($search_data['transaction']))){
			$transaction = sanitize_text_field($search_data['transaction']);
		}elseif(sanitize_text_field(isset($_REQUEST['transaction']))){
			$transaction = sanitize_text_field($_REQUEST['transaction']);
		}

		$orderby = '';
		if( sanitize_text_field(isset($search_data['orderby'])) ){
			$orderby = sanitize_text_field($search_data['orderby']);
		}elseif( sanitize_text_field(isset($_REQUEST['orderby'])) ){
			$orderby = sanitize_text_field($_REQUEST['orderby']);
		}

		$order_direction = '';
		if( sanitize_text_field(isset($search_data['order_direction'])) ){
			$order_direction = sanitize_text_field($search_data['order_direction']);
		}elseif( sanitize_text_field(isset($_REQUEST['order_direction'])) ){
			$order_direction = sanitize_text_field($_REQUEST['order_direction']);
		}

		$limit = '11';
		if( sanitize_text_field(isset($search_data['limit'])) ){
			$limit = sanitize_text_field($search_data['limit']);
		}elseif( sanitize_text_field(isset($_REQUEST['limit'])) ){
			$limit = sanitize_text_field($_REQUEST['limit']);
		}

		$paged = 1;
		if( isset($_REQUEST['paged']) ){
			$paged = $_REQUEST['paged'];
		}elseif( get_query_var( 'page' ) ){
			$page = get_query_var( 'page' ) ? absint( get_query_var( 'page' ) ):$paged;
		}

		$search_criteria_data = array(
			'communityid'		=> $communityid,
			'countryid'			=> $countryid,
			'countyid'			=> $countyid,
			'stateid'			=> $stateid,
			'cityid'			=> $cityid,
			'zip'				=> $zip,
			'lat' 				=> $lat,
			'lon' 				=> $lon,
			'q' 				=> $location,
			'bathrooms' 		=> $bathrooms,
			'bedrooms' 			=> $bedrooms,
			'min_listprice' 	=> $min_listprice,
			'max_listprice' 	=> $max_listprice,
			'property_status'	=> $property_status,
			'property_type'		=> $property_type,
			'transaction'		=> $transaction,
			'orderby'			=> $orderby,
			'order_direction'	=> $order_direction,
			'limit'				=> $limit,
			'page'				=> $paged
		);
		$search_md5 	  = md5(json_encode($search_criteria_data));
		//var_dump($search_criteria_data);
		$property_keyword = \Property_Cache::get_instance()->getCacheSearchKeyword();
		$cache_keyword 	  = $property_keyword->id . $search_md5;
		//\DB_Store::get_instance()->del($cache_keyword);
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$get_properties = \DB_Store::get_instance()->get($cache_keyword);
		}else{
			$md_client 	= \Clients\Masterdigm_CRM::instance()->connect();
			$properties = $md_client->getProperties( $search_criteria_data );
			//var_dump($properties);
			$result = false;
			if( isset($properties->total) && count($properties->total) > 0 ){
				$result = true;
			}else{
				$result = true;
			}
			if( $result && (isset($properties->total) && $properties->total > 0) )
			{
				foreach( $properties->properties as $property ){
					$p =	new \crm\Property_Entity;
					$p->bind( $property );

					$data_properties[] = $p;
				}

				$get_properties = (object)array(
					'total'				=>	$properties->total,
					'data'				=>	isset($data_properties) ? $data_properties : array(),
					'search_keyword'	=>	$search_criteria_data,
					'source'			=>	'crm'
				);
				// save to cache, for later use
				\DB_Store::get_instance()->put($cache_keyword, $get_properties);
			}else{
				$get_properties = (object)array(
					'total'				=>	isset($properties->total) ? $properties->total:0,
					'result'			=>	isset($properties->count) ? $properties->count:'',
					'messsage'			=>	isset($properties->messsage) ? $properties->messsage:'',
					'request'			=>	isset($properties->request) ? $properties->request:'',
					'search_keyword'	=>	array(),
					'source'			=>	'crm'
				);
			}
		}
		return $get_properties;
	}

	public function getNextPrevData(){
		return false;
	}

	public function get_property($id, $broker_id){
		$photos 		= array();
		$propertyEntity = array();

		$data = (object)array(
			'id'=>0,
			'brokerid'=>0,
			'photos'=>array(),
			'properties'=>array(),
			'agent'=>array(),
			'source'=>'crm'
		);

		if( $broker_id == '' ){
			$broker_id = $this->get_broker_id();
		}
		$result = false;
		$single_cache_keyword 	= \Property_Cache::get_instance()->getCacheSinglePropertyKeyword();
		$cache_keyword 	  		= $single_cache_keyword->id . $id;
		//\DB_Store::get_instance()->del($cache_keyword);
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$data = \DB_Store::get_instance()->get($cache_keyword);
			return $data;
		}else{
			$MDClient = \Clients\Masterdigm_CRM::instance()->connect();
			$property = $MDClient->getPropertyById( $id, $broker_id );

			if( isset($property) && is_array($property) && $property['result'] == 'fail' ){
				$result = false;
			}elseif( isset($property) && ($property->result == 'success' || $property->count > 0) ){
				$result = true;
			}

			if( $result ){
				$propertyEntity = new \crm\Property_Entity;
				$propertyEntity->bind( $property->property );

				$agentEntity = array();
				if( $property->agent_details ){
					$agentEntity 	= \crm\Agent_Entity::get_instance()->bind( $property->agent_details );
				}

				$photos = $property->photos;

				$data = (object)array(
					'id'			=>	$id,
					'brokerid'		=>	$broker_id,
					'photos'		=>	$photos,
					'properties'	=>	$propertyEntity,
					'agent'			=>	$agentEntity,
					'source'		=>	'crm'
				);

				\DB_Store::get_instance()->put($cache_keyword,$data);
				return $data;
			}else{
				return false;
			}
		}
	}

	public function push_crm_data( $array_data ){
		extract($array_data);
		$userid 	= 0;
		$account_id = $this->get_broker_id();
		$gemtkCRM 	= \Clients\Masterdigm_CRM::instance()->connect();
		$gemtkCRM->setAccountId( $account_id );
		$get_userid = \crm\AccountEntity::get_instance()->get_account_details();
		if( $get_userid && isset($get_userid->userid) ){
			$userid = $get_userid->userid;
		}
		$response   = $gemtkCRM->saveLead(
			array(
				'first_name'         => sanitize_text_field(isset($yourname)) ? sanitize_text_field($yourname):'',
				'last_name'          => sanitize_text_field(isset($yourlastname)) ? sanitize_text_field($yourlastname):'',
				'middle_name'        => sanitize_text_field(isset($yourmidname)) ? sanitize_text_field($yourmidname):'',
				'lead_source'        => sanitize_text_field(isset($lead_source)) ? sanitize_text_field($lead_source):'',
				'phone_home'         => sanitize_text_field(isset($phone_home)) ? sanitize_text_field($phone_home):'',
				'phone_mobile'       => sanitize_text_field(isset($phone_mobile)) ? sanitize_text_field($phone_mobile):'',
				'phone_work'         => sanitize_text_field(isset($phone_work)) ? sanitize_text_field($phone_work):'',
				'phone_fax'          => sanitize_text_field(isset($phone_fax)) ? sanitize_text_field($phone_fax):'',
				'email1'             => sanitize_text_field(isset($email1)) ? sanitize_text_field($email1):'',
				'address_street'     => sanitize_text_field(isset($address_street)) ? sanitize_text_field($address_street):'',
				'address_city'       => sanitize_text_field(isset($address_city)) ? sanitize_text_field($address_city):'',
				'address_state'      => sanitize_text_field(isset($address_state)) ? sanitize_text_field($address_state):'',
				'address_postalcode' => sanitize_text_field(isset($address_postalcode)) ? sanitize_text_field($address_postalcode):'',
				'address_country'    => sanitize_text_field(isset($address_country)) ? sanitize_text_field($address_country):'',
				'company'            => sanitize_text_field(isset($company)) ? sanitize_text_field($company):'',
				'assigned_to'		 => sanitize_text_field(isset($userid)) ? sanitize_text_field($userid):'',
				'note'				 => sanitize_text_field(isset($note)) ? sanitize_text_field($note):''
			)
		);

		return $response;
	}

	public function getAccountCoverage(){
		$account_id = $this->get_broker_id();
		$gemtkCRM 	= \Clients\Masterdigm_CRM::instance()->connect();
		$gemtkCRM->setAccountId($account_id);
		return $gemtkCRM->getAccountCoverage();
	}

	public function get_property_photo($propertyID){
		$cache_keyword 	= 'property-photo-'.$propertyID;
		//\DB_Store::get_instance()->del($cache_keyword);
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$photos = \DB_Store::get_instance()->get($cache_keyword);
		}else{
			$gemtkCRM 	= \Clients\Masterdigm_CRM::instance()->connect();
			$photos 	= $gemtkCRM->getPhotosByPropertyId($propertyID);
			\DB_Store::get_instance()->put($cache_keyword, $photos);
		}
		return $photos;
	}

	public function get_broker_id(){
		return get_option( 'broker_id' );
	}

	public function getFeaturedProperties(){
		\crm\AccountEntity::get_instance()->set_account_details();
		$account_details = \crm\AccountEntity::get_instance()->get_account_details();
		$user_id 		 = \crm\AccountEntity::get_instance()->get_account_data('userid');

		$property_keyword 	= \Property_Cache::get_instance()->getCacheFeaturedKeyword();
		$cache_keyword 		= $property_keyword->id;
		//\DB_Store::get_instance()->del($cache_keyword);
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$get_properties = \DB_Store::get_instance()->get($cache_keyword);
		}else{
			$masterdigm = \Clients\Masterdigm_CRM::instance()->connect();
			$featured 	= $masterdigm->getFeaturedProperties($user_id);

			if( $featured->result == 'success' && $featured->count > 0 )
			{
				foreach( $featured->properties as $property ){

					$p =	new \crm\Property_Entity;
					$p->bind( $property );

					$data_properties[] = $p;
					// grab the first photo of the featured properties, else we end up adding them all
					$photo[$property->id][] = $this->get_property_photo($property->id);
				}
				$get_properties = (object)array(
					'total'=>$featured->count,
					'data'=>$data_properties,
					'photo'=>$photo
				);

				\DB_Store::get_instance()->put($cache_keyword, $get_properties);
			}else{
				$get_properties = (object)array(
					'total'=>0,
					'data'=>array(),
					'photo'=>array()
				);
			}
		}
		return $get_properties;
	}

	public function getComparableProperties($property_id){
		return false;
	}

	public function getStatesByCountryId($country_id){
		$state = array();
		$cache_keyword = 'property-state-by-country-'. $country_id;
		//\DB_Store::get_instance()->del($cache_keyword);
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$state = \DB_Store::get_instance()->get($cache_keyword);
		}else{
			$md 	= \Clients\Masterdigm_CRM::instance()->connect();
			$state	= $md->getStatesByCountryId($country_id);
			\DB_Store::get_instance()->put($cache_keyword,$state);
		}
		return	$state;
	}

	public function getCitiesByStateid($state_id){
		$cities = array();
		$cache_keyword = 'property-city-by-state-' . $state_id;
		//\DB_Store::get_instance()->del($cache_keyword);
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$cities = \DB_Store::get_instance()->get($cache_keyword);
		}else{
			$md 	= \Clients\Masterdigm_CRM::instance()->connect();
			$cities	= $md->getCitiesByStateid($state_id);
			\DB_Store::get_instance()->put($cache_keyword,$cities);
		}

		return	$cities;
	}

	/**
	 * single id or array
	 * */
	public function getCommunitiesByCityId($city_id){
		$communities 		= array();
		$keyword_city_id 	= implode('_', $city_id);
		$cache_keyword 		= 'property-communities-by-city-' . $keyword_city_id;
		//\DB_Store::get_instance()->del($cache_keyword);
		if( \DB_Store::get_instance()->get($cache_keyword) ){
			$communities = \DB_Store::get_instance()->get($cache_keyword);
		}else{
			$md 			= \Clients\Masterdigm_CRM::instance()->connect();
			$communities	= $md->getCommunitiesByCityId($city_id);
			\DB_Store::get_instance()->put($cache_keyword, $communities);
		}

		return	$communities;
	}

}

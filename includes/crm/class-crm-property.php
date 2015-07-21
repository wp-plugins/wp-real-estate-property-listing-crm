<?php
/**
 * Related on properties only for CRM
 * -get single or list of properties
 * -related
 * -next prev
 * */
class CRM_Property{
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

	public function get_default_search_status(){
		global $default_search_status;
		return default_search_status();
	}

	public function get_property_photo($property_id){
		$cache_keyword 	= 'property-photo-'.$property_id;
		//\DB_Store::get_instance()->del($cache_keyword);
		if( cache_get($cache_keyword) ){
			$photos = cache_get($cache_keyword);
		}else{
			$photos 	= $this->crm->get_photos_by_propertyId($property_id);
			cache_set($cache_keyword, $photos);
		}
		return $photos;
	}

	/**
	 * get all properties base on search data.
	 * @var		$search_data	array	default is null
	 * @return	array	object
	 * */
	public function get_properties($search_data = null){

		$communityid = '';
		if( sanitize_text_field(isset($search_data['communityid'])) ){
			$communityid = sanitize_text_field($search_data['communityid']);
		}elseif( sanitize_text_field(isset($_REQUEST['communityid'])) ){
			$communityid = sanitize_text_field($_REQUEST['communityid']);
		}

		$subdivisionid = '';
		if( sanitize_text_field(isset($search_data['subdivisionid'])) ){
			$subdivisionid = sanitize_text_field($search_data['subdivisionid']);
		}elseif( sanitize_text_field(isset($_REQUEST['subdivisionid'])) ){
			$subdivisionid = sanitize_text_field($_REQUEST['subdivisionid']);
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

		$property_status = $this->get_default_search_status();
		if(
			sanitize_text_field(isset($search_data['property_status'])) &&
			sanitize_text_field($search_data['property_status']) != ''
		){
			$property_status = sanitize_text_field($search_data['property_status']);
		}elseif(
			sanitize_text_field(isset($_REQUEST['property_status'])) &&
			sanitize_text_field($_REQUEST['property_status']) != ''
		){
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
			$transaction = sanitize_text_field(urldecode($_REQUEST['transaction']));
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

		$limit = \MD_Search_Utility::get_instance()->search_limit();
		if( sanitize_text_field(isset($search_data['limit'])) ){
			$limit = sanitize_text_field($search_data['limit']);
		}elseif( sanitize_text_field(isset($_REQUEST['limit'])) ){
			$limit = sanitize_text_field($_REQUEST['limit']);
		}

		$paged = 1;
		if( isset($_REQUEST['paged']) ){
			$paged = $_REQUEST['paged'];
		}elseif( get_query_var( 'paged' ) ){
			$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ):$paged;
		}

		$search_criteria_data = array(
			'subdivisionid'		=> $subdivisionid,
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

		$search_criteria_data = apply_filters( 'search_criteria_data', $search_criteria_data );

		$search_md5 	  = md5(json_encode($search_criteria_data));
		$property_keyword = \Property_Cache::get_instance()->getCacheSearchKeyword();
		$cache_keyword 	  = $property_keyword->id . $search_md5;

		$properties_total = 0;
		if( isset($properties->total) ){
			$properties_total = $properties->total;
		}
		$properties_count = '';
		if( isset($properties->count) ){
			$properties_count = $properties->count;
		}
		$properties_messsage = '';
		if( isset($properties->messsage) ){
			$properties_messsage = $properties->messsage;
		}
		$properties_request = '';
		if( isset($properties->request) ){
			$properties_request = $properties->request;
		}
		$get_properties = (object)array(
			'total'				=>	$properties_total,
			'result'			=>	$properties_count,
			'messsage'			=>	$properties_messsage,
			'request'			=>	$properties_request,
			'search_keyword'	=>	array(),
			'source'			=>	'crm'
		);

		//\DB_Store::get_instance()->del($cache_keyword);
		if( cache_get($cache_keyword) ){
			$get_properties = cache_get($cache_keyword);
		}else{
			$properties = $this->crm->get_properties($search_criteria_data);

			$result = false;
			if( isset($properties->total) && count($properties->total) > 0 ){
				$result = true;
			}else{
				$result = true;
			}
			if( $result && (isset($properties->total) && $properties->total > 0) ){
				$data_properties = array();
				foreach( $properties->properties as $property ){
					$p =	new \crm\Property_Entity;
					$p->bind( $property );

					$data_properties[] = $p;
				}
				$get_properties = (object)array(
					'total'				=>	$properties->total,
					'data'				=>	$data_properties,
					'search_keyword'	=>	$search_criteria_data,
					'source'			=>	'crm'
				);
				// save to cache, for later use
				cache_set($cache_keyword, $get_properties);
			}
		}
		return $get_properties;
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
	public function get_featured($user_id = null, $array_location_id = array()){

		if( is_null($user_id) ){
			$user_id = \CRM_Account::get_instance()->get_account_data('userid');
			$user = \CRM_Account::get_instance()->get_account_details();
		}

		$property_keyword 	= \Property_Cache::get_instance()->getCacheFeaturedKeyword();
		$cache_keyword 		= $property_keyword->id;
		//\DB_Store::get_instance()->del($cache_keyword);
		if( cache_get($cache_keyword) ){
			$get_properties = cache_get($cache_keyword);
		}else{
			$properties = $this->crm->get_featured_properties($user_id, $array_location_id);
			if( $properties->result == 'success' && $properties->count > 0 )
			{
				foreach( $properties->properties as $property ){

					$p = new \crm\Property_Entity;
					$p->bind( $property );

					$data_properties[] = $p;
					// grab the first photo of the featured properties, else we end up adding them all
					$photo[$property->id][] = $this->get_property_photo($property->id);
				}
				$get_properties = (object)array(
					'total'	=>	$properties->count,
					'data'	=>	$data_properties,
					'photo'	=>	$photo
				);

				cache_set($cache_keyword, $get_properties);
			}else{
				$get_properties = (object)array(
					'total'	=>	0,
					'data'	=>	array(),
					'photo'	=>	array()
				);
			}
		}
		return $get_properties;
	}

	/**
	 * single or property details
	 * */
	public function get_property($id, $broker_id = null){

		if( is_null($broker_id) ){
			$broker_id = \CRM_Account::get_instance()->get_broker_id();
		}

		$photos 		= array();
		$propertyEntity = array();

		$data = (object)array(
			'id'			=>	0,
			'brokerid'		=>	0,
			'photos'		=>	array(),
			'properties'	=>	array(),
			'agent'			=>	array(),
			'source'		=>	'crm'
		);

		$result 				= false;
		$single_cache_keyword 	= \Property_Cache::get_instance()->getCacheSinglePropertyKeyword();
		$cache_keyword 	  		= $single_cache_keyword->id . $id;
		//\DB_Store::get_instance()->del($cache_keyword);
		if( cache_get($cache_keyword) ){
			$data = cache_get($cache_keyword);
			return $data;
		}else{
			$property = $this->crm->get_property( $id, $broker_id );
			if( isset($property) && is_array($property) && $property['result'] == 'fail' ){
				$result = false;
			}elseif( isset($property) && ($property->result == 'success') ){
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

				cache_set($cache_keyword,$data);
				return $data;
			}else{
				return false;
			}
		}
	}
}

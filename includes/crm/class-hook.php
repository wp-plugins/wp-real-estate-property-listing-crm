<?php
class CRM_Hook{
	protected static $instance = null;

	public $crm;

	public function __construct(){
		$this->crm = new Masterdigm_CRM;
		add_action('before_get_properties_crm',array($this,'track_search'),10,1);
		add_action('breadcrumb_show_locations_crm',array($this,'breadcrumb_show_locations_crm'),10,1);
		add_action('breadcrumb_crm',array($this,'breadcrumb_crm'),10,2);
		add_action('breadcrumb_list_property_crm',array($this,'breadcrumb_list_property_crm'),10,2);
		add_action('md_list_property_by_crm',array($this,'md_list_property_by_crm'),10,3);
		add_action('search_utility_by_crm',array($this,'search_utility_by_crm'),10,1);
		add_action('wp_title_crm',array($this,'wp_title_crm'),10,1);
		add_action('property_nearby_property_crm',array($this,'property_nearby_property_crm'),10,1);
		add_action('next_prev_crm',array($this,'next_prev_crm'),10,1);
		add_filter('is_property_viewable_hook_crm',array($this,'is_property_viewable_hook_crm'),10,1);
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

	public function track_search($search_data){

	}

	public function breadcrumb_show_locations_crm(){
		if( has_filter('breadcrumb_show_locations_crm_hook') ){
			$array_location = apply_filters('breadcrumb_show_locations_crm_hook', $array_location);
		}else{
			$array_location =	array(
				'country'	=>	false,
				'state'		=>	true,
				'county'	=>	true,
				'city'		=>	true,
				'community'	=>	true,
				'zip'		=>	false,
			);
		}
		return $array_location;
	}

	public function breadcrumb_crm($property_data, $show_location){
		return \crm\MD_Breadcrumb::get_instance()->createPageForBreadcrumbTrail($property_data, $show_location);
	}

	public function breadcrumb_list_property_crm($atts){
		return \md_sc_crm_list_properties_by::get_instance()->init_shortcode($atts);
	}

	public function md_list_property_by_crm($data_url_parse, $wp_query, $atts){
		$location_id = '';
		$search_by = '';

		$data_array = array(
			'source' 				=> 'crm',
			'parent_location_id'	=> '',
			'search_by'				=> ''
		);

		if( isset($data_url_parse[1]) ){
			$location_id = $data_url_parse[1];
		}

		if( isset($wp_query->query_vars['pagename']) ){
			$search_by = $wp_query->query_vars['pagename'];
		}
		$data_array = array(
			'source' 				=> 'crm',
			'parent_location_id'	=> $location_id,
			'search_by'				=> $search_by
		);
		// hook filter, incase we want to just use hook
		if( has_filter('hook_md_list_property_by_crm') ){
			$data_array = apply_filters('hook_md_list_property_by_crm', $data_array);
		}

		return $data_array;
	}

	public function search_utility_by_crm($request){

		foreach($request as $key => $val){
			$array_val = explode('=', $val);
			if( $array_val[0] == 'location' ){
				$_REQUEST['location'] = sanitize_text_field($array_val[1]);
			}else{
				if( isset($array_val[1]) ){
					$_REQUEST[$array_val[0]] = sanitize_text_field($array_val[1]);
				}
			}
		}

		$properties = \crm\MD_Searchby_Property::get_instance()->searchPropertyResult();

		return array(
			'search_data' 	=> $request,
			'properties' 	=> $properties,
			'source'		=> 'crm'
		);
	}

	public function wp_title_crm($data){
		return '';
	}

	public function property_nearby_property_crm($array_properties){
		$communityid = '';
		$cityid = '';
		if( $array_properties['property'] && isset($array_properties['property']->communityid) == 0 ){
			$communityid = $array_properties['property']->communityid;
			$city = '';
		}elseif( $array_properties['property'] && isset($array_properties['property']->cityid) ){
			$cityid = $array_properties['property']->cityid;
			$communityid = '';
		}

		$search_data	= array();
		$search_data['countyid'] 		= 0;
		$search_data['stateid'] 		= 0;
		$search_data['countryid'] 		= 0;
		$search_data['cityid'] 			= $cityid;
		$search_data['zip'] 			= '';
		$search_data['communityid'] 	= $communityid;
		$search_data['bathrooms'] 		= '';
		$search_data['bedrooms'] 		= '';
		$search_data['transaction'] 	= $array_properties['property']->transaction_type;
		$search_data['property_type'] 	= $array_properties['property']->property_type;
		$search_data['property_status'] = $array_properties['property']->property_status;
		$search_data['min_listprice'] 	= 0;
		$search_data['max_listprice'] 	= 0;
		$search_data['orderby'] 		= '';
		$search_data['order_direction']	= '';
		$search_data['limit']			= 11;

		$properties = \CRM_Property::get_instance()->get_properties($search_data);
		return $properties;
	}

	public function next_prev_crm(){
		return \crm\Layout_Property::get_instance()->next_prev();
	}

	public function is_property_viewable_hook_crm($status){
		$status = get_account_fields();
		if( $status->result == 'success' && $status->success ){
			if( array_search(md_get_property_status(),(array)$status->fields->status) ){
				return true;
			}
		}
		return false;
	}
}

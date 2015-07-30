<?php
class MLS_Hook{
	protected static $instance = null;

	public $crm;

	public function __construct(){
		add_action('breadcrumb_show_locations_mls',array($this,'breadcrumb_show_locations_mls'),10,1);
		add_action('breadcrumb_mls',array($this,'breadcrumb_mls'),10,2);
		add_action('breadcrumb_list_property_mls',array($this,'breadcrumb_list_property_mls'),10,1);
		add_action('md_list_property_by_mls',array($this,'md_list_property_by_mls'),10,3);
		add_action('search_utility_by_mls',array($this,'search_utility_by_mls'),10,1);
		add_filter('wp_title_mls',array($this,'wp_title_mls'),11,1);
		add_filter('property_nearby_property_mls',array($this,'property_nearby_property_mls'),10,2);
		add_filter('is_property_viewable_hook_mls',array($this,'is_property_viewable_hook_mls'),10,1);
		add_action('wp_ajax_create_location_page_action_mls', array($this,'create_location_page_action_mls_callback') );
		add_action('fields_type_mls', array($this,'fields_type_mls'),10,1 );
		add_action('pdf_photos_mls', array($this,'pdf_photos_mls'),10,1 );
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

	public function breadcrumb_show_locations_mls(){
		if( has_filter('breadcrumb_show_locations_mls_hook') ){
			$array_location = apply_filters('breadcrumb_show_locations_mls_hook', $array_location);
		}else{
			$array_location =	array(
				'country'	=>	false,
				'state'		=>	false,
				'county'	=>	false,
				'city'		=>	true,
				'community'	=>	true,
				'zip'		=>	false,
			);
		}
		return $array_location;
	}

	public function breadcrumb_mls($property_data, $show_location){
		$ret = \mls\MD_Breadcrumb::get_instance()->createPageForBreadcrumbTrail($property_data, $show_location);
		return $ret;
	}

	public function breadcrumb_list_property_mls($atts){

		if( !isset($atts['template_by']) ){
			$template = PLUGIN_VIEW . 'list/default/list-default.php';
		}
		// hook filter, incase we want to just use hook
		if( has_filter('shortcode_list_property_by_mls') ){
			$template = apply_filters('shortcode_list_property_by_mls', $path);
		}

		if( isset($atts['col']) && is_numeric($atts['col']) ){
			$col = ceil(12 / $atts['col'] );
		}else{
			$col = MD_DEFAULT_GRID_COL;
		}

		if( isset($atts['parent_location_id']) ){
			$parent_location_id = $atts['parent_location_id'];
		}

		if( isset($atts['source']) ){
			$source = $atts['source'];
		}

		if( isset($atts['search_by']) ){
			$search_by = $atts['search_by'];
		}

		$atts['infinite'] = true;
		if( $atts['infinite'] == 'true' ){
			$atts['infinite'] = true;
		}elseif($atts['infinite'] == 'false'){
			$atts['infinite'] = false;
		}

		switch($search_by){
			case 'community':
				$search_by = array(
					'communityid' => $parent_location_id,
					'transaction' => 'For Sale'
				);
			break;
			case 'city':
				$search_by = array(
					'cityid' => $atts['parent_location_id'],
					'transaction' => 'For Sale'
				);
			break;
			case 'postal_code':
				$search_by = array(
					'location' => $atts['parent_location_id'],
					'transaction' => 'For Sale'
				);
			break;
		}
		$search_data 		= $search_by;
		$atts['show_child'] = false;
		$show_sort 			= true;
		$properties 		= \MLS_Property::get_instance()->get_properties($search_by);
		\MD\Property::get_instance()->set_properties($properties,'mls');

		require $template;
	}

	public function md_list_property_by_mls($data_url_parse, $wp_query, $atts){
		$location_id = '';
		$search_by = '';

		$data_array = array(
			'source' 				=> 'mls',
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
			'source' 				=> 'mls',
			'parent_location_id'	=> $location_id,
			'search_by'				=> $search_by
		);
		// hook filter, incase we want to just use hook
		if( has_filter('hook_md_list_property_by_mls') ){
			$data_array = apply_filters('hook_md_list_property_by_mls', $data_array);
		}
		return $data_array;
	}

	public function search_utility_by_mls($request){
		$search_data = $request;
		$properties = \mls\MD_Searchby_Property::get_instance()->searchPropertyResult($search_data);

		return array(
			'search_data' 	=> $request,
			'properties' 	=> $properties,
			'source'		=> 'mls'
		);
	}

	public function wp_title_mls($data){
		if( $data ){
			return ' MLS# '.$data['property']->getMLS().' ';
		}else{
			return '';
		}
	}

	public function property_nearby_property_mls($array_properties, $array_option_search){
		$search_data	= array();
		$communityid 	= '';
		$cityid 		= '';
		$location 		= '';

		$loc = get_coverage_lookup();
		$ret = get_mls_hierarchy_location($array_properties['property'], $loc);

		if( $array_properties['community'] && isset($array_properties['community']->community_id) ){
			$communityid = $array_properties['community']->community_id;
		}else{
			if( isset($ret['city']) && isset($ret['city']['id']) ){
				$cityid = $ret['city']['id'];
			}
			if( isset($ret['community']) && isset($ret['community']['id']) ){
				$communityid = $ret['community']['id'];
			}
		}

		$limit = 6;
		if( isset($array_option_search['limit']) ){
			$limit = $array_option_search['limit'];
		}

		$search_data['countyid'] 		= '';
		$search_data['stateid'] 		= '';
		$search_data['countyid'] 		= '';
		$search_data['countryid'] 		= '';
		$search_data['communityid'] 	= $communityid;
		$search_data['cityid'] 			= '';
		$search_data['location'] 		= $location;
		$search_data['bathrooms'] 		= '';
		$search_data['bedrooms'] 		= '';
		$search_data['transaction'] 	= '';
		$search_data['property_type'] 	= '';
		$search_data['property_status'] = '';
		$search_data['min_listprice'] 	= '';
		$search_data['max_listprice'] 	= '';
		$search_data['limit']			= $limit;

		$properties = \MLS_Property::get_instance()->get_properties($search_data);
		return $properties;
	}

	public function is_property_viewable_hook_mls($status){
		return true;
	}

	private function _wp_create_page($array_val, $parent_id = 0, $post_status = 'publish'){
		$current_user = wp_get_current_user();
		$post_id			= 0;
		$content_shortcode 	= '';
		$location 			= '';
		$location 	= $array_val['location_type'].'id';
		$id 		= $array_val['id'];

		$shortcode_tag 		= \md_sc_mls_list_properties::get_instance()->get_shortcode_tag();
		$content_shortcode 	= \md_sc_search_form::get_instance()->shortcode_tag().'<br>';
		$content_shortcode .= '['.$shortcode_tag.' '.$location.'="'.$id.'" limit="10" template="list/default/list-default.php" col="4" infinite="true"]';

		$post_title		= $array_val['full'];
		$post_content	= $content_shortcode;
		$post_parent	= $parent_id;
		$post_arg = array(
		  'post_title'    => $post_title,
		  'post_content'  => $post_content,
		  'post_status'   => $post_status,
		  'post_author'   => $current_user->ID,
		  'post_parent'	  => $post_parent,
		  'post_type'	  => 'page',
		);

		$is_in_post = false;

		if( get_page_by_title($post_title) ){
			$post = get_page_by_title($post_title);
			$post_id = $post->ID;
			$is_in_post = true;
		}elseif( $this->md_query_page_title($post_title) ){
			$post = $this->md_query_page_title($post_title);
			$post_id = $post[0]->ID;
			$is_in_post = true;
		}

		if( $is_in_post && $post_status == 'trash' ){
			$post_id = wp_delete_post($post->ID, true);
		}elseif( $post_status == 'draft' || $post_status == 'publish' ){
			if( $is_in_post ){
				$post_arg['ID'] = $post_id;
				$post_id 		= wp_update_post( $post_arg );
			}else{
				$post_id = wp_insert_post( $post_arg );
			}
		}

		return $post_id;
	}

	public function create_location_page_action_mls_callback(){
		check_ajax_referer( 'md-ajax-request', 'security' );
		$current_user = wp_get_current_user();

		$msg 	= '';
		$status = false;

		$page_location 	= array();
		//hook, get the default
		$account 					= \mls\AccountEntity::get_instance()->get_coverage_lookup();

		if( isset($account->result) == 'success' ){
			$locations 	= $account->lookups;
			$city_array = array();
			if( count($locations) > 0 ){
				foreach($locations as $key=>$val){
					if( $val->location_type == 'city' ){
						$city_array[$val->id] = array(
							'id'=>$val->id,
							'keyword'=>$val->keyword,
							'full'=>$val->full,
							'location_type'=>$val->location_type,
						);
					}
					if( $val->location_type == 'community' ){
						$city_array[$val->city_id]['community'][] = array(
							'id'=>$val->id,
							'keyword'=>$val->keyword,
							'full'=>$val->full,
							'location_type'=>$val->location_type,
						);
					}
				}
			}
			if( count($city_array) > 0 ){

				$post_status = 'publish';
				if( isset($_POST['post_status']) ){
					$post_status = sanitize_text_field($_POST['post_status']);
				}

				$page_location['total']	= count($locations);
				$count = 0;

				wp_defer_term_counting( true );
				wp_defer_comment_counting( true );

				foreach($city_array as $key => $val){
					$page_location['date_added'] 	= date("F j, Y, g:i a");
					$page_location['count']	= $count++;

					$post_id = $this->_wp_create_page($val, 0, $post_status);

					if(
						isset($val['community']) &&
						is_array($val['community']) &&
						count($val['community']) > 0 )
					{
						foreach($val['community'] as $key_community => $val_community){
							if( $this->_wp_create_page($val_community, $post_id, $post_status)){
								$page_location['count']	= $count++;
							}
						}
					}
					sleep(1);
				}

				wp_defer_term_counting( false );
				wp_defer_comment_counting( false );

				$option_name = 'create_page_by_location_'.date("m.d.Y.H.i.s");
				$date 		 = date("F j, Y, g:i a");
				$option_value = array(
					'data'=>$page_location,
					'date'=>$date
				);
				update_option($option_name, $option_value);
				$msg = 'Done, total '.$post_status.' page : '.$option_value['data']['count'];
				$status = true;
			}
		}
		echo json_encode(array('msg'=>$msg,'status'=>$status));
		die();
	}

	private function _wp_update_post_meta($post_id, $key, $value){
		update_post_meta($post_id, $key, $value);
	}

	public function md_query_page_title($string){
		global $wpdb;
		$location_name = str_replace(' ','-',strtolower($string));
		$sql = "SELECT * FROM ".$wpdb->posts." WHERE post_name LIKE  '{$location_name}%' AND post_status =  'publish'";
		$ret = $wpdb->get_results($sql);
		return $ret;
	}

	public function fields_type_mls($property_type){
		$fields =  \mls\AccountEntity::get_instance()->get_property_type();
		$fields_type = array();
		if( isset($fields->result) && $fields->result == 'success' ){
			//$fields_type = $fields->types;
			foreach($fields->types as $key => $val){
				$fields_type[$val] = $val;
			}
		}
		return $fields_type;
	}

	public function pdf_photos_mls($photos){
		$mls_photos = array();
		if( count($photos) > 0 ){
			foreach($photos as $key => $val){
				$mls_photos[] = $val->url;
			}
		}
		return $mls_photos;
	}
}

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
		add_action('property_nearby_property_crm',array($this,'property_nearby_property_crm'),10,2);
		add_action('next_prev_crm',array($this,'next_prev_crm'),10,1);
		add_filter('is_property_viewable_hook_crm',array($this,'is_property_viewable_hook_crm'),10,1);
		add_action('wp_ajax_create_location_page_action_crm', array($this,'create_location_page_action_crm_callback') );
		add_action('fields_type_crm', array($this,'fields_type_crm'),10,1 );
		add_action('pdf_photos_crm', array($this,'pdf_photos_crm'),10,1 );
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

	public function property_nearby_property_crm($array_properties, $array_option_search){
		$communityid = '';
		$cityid = '';

		if( $array_properties['property'] && isset($array_properties['property']->communityid) == 0 ){
			$communityid = $array_properties['property']->communityid;
			$city = '';
		}elseif( $array_properties['property'] && isset($array_properties['property']->cityid) ){
			$cityid = $array_properties['property']->cityid;
			$communityid = '';
		}

		$limit = 5;
		if( isset($array_option_search['limit']) ){
			$limit = $array_option_search['limit'];
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
		$search_data['limit']			= $limit;

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

	private function _wp_update_post_meta($post_id, $key, $value){
		update_post_meta($post_id, $key, $value);
	}

	public function create_location_page_action_crm_callback(){
		check_ajax_referer( 'md-ajax-request', 'security' );
		$current_user = wp_get_current_user();

		$msg 	= '';
		$status = false;

		$page_location 	= array();
		//hook, get the default
		$account 					= \CRM_Account::get_instance()->get_coverage_lookup();
		$shortcode_tag 				= \md_sc_crm_list_properties::get_instance()->get_shortcode_tag();
		$shortcode_list_community 	= \md_sc_crm_get_locations::get_instance()->get_shortcode_tag();

		if( isset($account->result) == 'success' ){
			$locations 	= $account->lookups;
			if( count($locations) > 0 ){

				$post_status = 'publish';
				if( isset($_POST['post_status']) ){
					$post_status = sanitize_text_field($_POST['post_status']);
				}

				$page_location['total']	= count($locations);
				$count = 0;

				wp_defer_term_counting( true );
				wp_defer_comment_counting( true );

				foreach($locations as $key => $val){
					$content_shortcode = '';
					$page_location['date_added'] 	= date("F j, Y, g:i a");
					list($title_location) = explode(',',$val->full);
					$page_location[$val->id]['full'] 			= $title_location;
					$page_location[$val->id]['location_type'] 	= $val->location_type;
					$page_location[$val->id]['id'] 				= $val->id;

					$location = $page_location[$val->id]['location_type'].'id';
					$id = $page_location[$val->id]['id'];

					$content_shortcode 	= \md_sc_search_form::get_instance()->shortcode_tag().'<br>';

					if( $val->location_type == 'city' ){
						$content_shortcode 	.= '['.$shortcode_list_community.' cityid="'.$id.'"]'.'<br>';
					}

					$content_shortcode .= '['.$shortcode_tag.' '.$location.'="'.$id.'" limit="11" template="list/default/list-default.php" col="4" infinite="true"]';

					$page_location[$val->id]['shortcode'] = $content_shortcode;
					$post_title		= $page_location[$val->id]['full'];
					$post_insert_arg = array(
					  'post_title'    => $post_title,
					  'post_content'  => $page_location[$val->id]['shortcode'],
					  'post_status'   => $post_status,
					  'post_author'   => $current_user->ID,
					  'post_type'	  => 'page',
					);

					$post = get_page_by_title($page_location[$val->id]['full']);

					$page_location['count']	= $count++;

					if( $post && $post_status == 'trash' ){
						wp_delete_post($post->ID, true);
					}elseif( $post_status == 'draft' || $post_status == 'publish' ){
						if( $post ){
							$post_id = $post->ID;
							$post_arg = array(
								'ID' => $post_id,
								'post_status' => $post_status
							);
							wp_update_post( $post_arg );
						}else{
							$post_id = wp_insert_post( $post_insert_arg );
						}
					}
					//mark in the post_meta as breadcrumb
					$this->_wp_update_post_meta($post_id, 'page_breadcrumb', 1);
					$this->_wp_update_post_meta($post_id, 'page_title', $post_title);
					$this->_wp_update_post_meta($post_id, 'location_id', $val->id);
					$this->_wp_update_post_meta($post_id, 'location_data', $page_location[$val->id]);
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

	public function md_query_page_title($string){
		global $wpdb;
		$location_name = str_replace(' ','-',strtolower($string));
		$sql = "SELECT * FROM ".$wpdb->posts." WHERE post_name LIKE  '{$location_name}%' AND post_status =  'publish'";
		$ret = $wpdb->get_results($sql);
		return $ret;
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

	public function fields_type_crm($property_type){
		$fields =  \CRM_Account::get_instance()->get_fields();
		$fields_type = array();
		if( is_array($fields) && $fields['result'] == 'fail' ){
			$fields_type = array();
		}else{
			if( $fields->result == 'success' ){
				$fields_type = $fields->fields->types;
			}
		}
		return $fields_type;
	}

	public function pdf_photos_crm($photos){
		$crm_photos = array();
		if( count($photos) > 0 ){
			foreach($photos as $key => $val){
				$crm_photos[] = $val;
			}
		}
		return $crm_photos;
	}
}

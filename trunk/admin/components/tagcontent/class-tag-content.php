<?php
/**
 * Property Content Class
 * this class will display a page or post content in the single property page
 * - create an admin add property id,
 * - tag post or/and category
 * */
class MD_Property_Content{
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	public $array_error = array();

	public function __construct(){
		//$this->prefix = 'social-api';
		$this->slug = 'admin.php?page=md-api-tag-content';
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function setError($array_error){
		$this->array_error = $array_error;
	}

	public function getError(){
		return $this->array_error;
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {
		$plugin_name = \Masterdigm_API::get_instance()->get_plugin_name();
		add_submenu_page(
			$plugin_name,
			'Tag Content',
			'Tag Content',
			'manage_options',
			'md-api-tag-content',
			array( $this, 'controller' )
		);
	}

	/**
	 * controller
	 * */
	public function controller(){
		$request = '';
		if( isset($_REQUEST['action']) ){
			$request = sanitize_text_field($_REQUEST['action']);
		}

		switch($request){
			case 'add':
				$this->displayAddNew();
			break;
			case 'post_add_new':
				$error 		= array();
				$has_error 	= false;
				$post 		= $_POST;

				if( sanitize_text_field($_POST['property_data']) == '' ){
					$has_error = true;
					$error[] = 'Please provide property or location data';
				}

				if( $has_error ){
					$this->setError($error);
					$this->displayAddNew();
				}else{
					$this->postUpdateOption($post);
					\Masterdigm_Admin_Util::get_instance()->redirect_to($this->slug);
				}
			break;
			case 'edit':
				$id	= sanitize_text_field($_REQUEST['id']);
				$this->displayEdit($id);
			break;
			case 'post_update':
				$id	= sanitize_text_field($_REQUEST['id']);
				$post = $_POST;
				$error 		= array();
				$has_error 	= false;

				if( sanitize_text_field($_POST['property_data']) == '' ){
					$has_error = true;
					$error[] = 'Please provide property or location data';
				}

				if( $has_error ){
					$this->setError($error);
					$this->displayEdit($id);
				}else{
					$this->postUpdateOption($post);
					\Masterdigm_Admin_Util::get_instance()->redirect_to($this->slug);
				}
			break;
			case 'delete':
				$nonce = $_REQUEST['_wpnounce'];
				$id = sanitize_text_field($_REQUEST['id']);
				if ( ! wp_verify_nonce( $nonce, $id ) ) {
					// This nonce is not valid.
					die( 'Security check' );
				} else {
					$delete_option_prefix = 'tag-content-' . $id;
					delete_option($delete_option_prefix);
					\Masterdigm_Admin_Util::get_instance()->redirect_to($this->slug);
				}
			break;
			default:
				$this->displayIndex();
			break;
		}
	}

	/**
	 * database get breadcrumb-url
	 * */
	public function getTagContents(){
		global $wpdb;

		$query = "SELECT * FROM $wpdb->options
					WHERE option_name LIKE '%tag-content%'
					ORDER BY option_id DESC";
		return $wpdb->get_results( $query, OBJECT );
	}

	/**
	 * list the data
	 * */
	public function displayIndex(){
		$listTagContent	= array();
		$listTagContent	= $this->getTagContents();
		require_once( plugin_dir_path( __FILE__ ) . 'view/list.php' );
	}

	/**
	 * add new content html layout
	 * */
	public function displayAddNew(){
		$obj = $this->get_instance();
		$property_type = array(
			'property'	=> 'Single property ( provide URL )',
			'state'		=> 'State ( provide ID or state name)',
			'city'		=> 'City ( provide ID or city name)',
			'community'	=> 'Community ( provide ID or community name)',
		);

		// get post, any
		$get_posts_arg = array(
			'post_type' => 'any',
			'posts_per_page' => '-1'
		);
		$content = get_posts( $get_posts_arg );

		// choose how to display content list
		$content_list_display = array(
			'title' => 'Display Title only',
			'title_excerpt' => 'Display Title with Excerpt'
		);

		// get categories
		$cat_args = array(
		  'orderby' => 'name'
		);
		$categories = get_categories( $cat_args );

		// choose how to display category content list
		$cat_content_list_display = array(
			'title' => 'Display Title only',
			'title_excerpt' => 'Display Title with Excerpt'
		);

		require_once( plugin_dir_path( __FILE__ ) . 'view/add.php' );
	}

	/**
	 * edit content html layout
	 * */
	public function displayEdit($property_id){

		$get_option_prefix 	= 'tag-content-' . $property_id;
		$option_content		= get_option($get_option_prefix);

		$arr_property_type = array(
			'property'	=> 'Single property ( provide URL )',
			'state'		=> 'State ( provide ID or state name)',
			'city'		=> 'City ( provide ID or city name)',
			'community'	=> 'Community ( provide ID or community name)',
		);
		// get post, any
		$get_posts_arg = array(
			'post_type' => 'any',
			'posts_per_page' => '-1'
		);
		$content = get_posts( $get_posts_arg );

		// choose how to display content list
		$content_list_display = array(
			'title' => 'Display Title only',
			'title_excerpt' => 'Display Title with Excerpt'
		);

		// get categories
		$cat_args = array(
		  'orderby' => 'name'
		);
		$categories = get_categories( $cat_args );

		// choose how to display category content list
		$cat_content_list_display = array(
			'title' => 'Display Title only',
			'title_excerpt' => 'Display Title with Excerpt'
		);

		extract($option_content);

		require_once( plugin_dir_path( __FILE__ ) . 'view/edit.php' );
	}

	private function _getPropertyByURL($post){
		$url			= $post['property_data'];
		$parse_property = explode( '-', $url);
		$property_id 	= basename($parse_property[0]);
		$data 			= array();
		// check the crm first
		$broker_id	= \crm\Properties::get_instance()->get_broker_id();
		$crm		= \crm\Properties::get_instance()->get_property($property_id, $broker_id );
		if( $crm ){
			$data = array_merge( (array)$crm, array( 'source' => 'crm' ) );
			$properties = $data['properties'];
		}else{
			// then its mls
			$mls = \mls\Properties::get_instance()->get_property_by_id($parse_property[0]);
			$data = array_merge( (array)$mls, array( 'source' => 'mls' ) );
			$properties = $data['properties'];
		}
		$objProperty = new \MD\Property;
		$objProperty->set_properties($data);
		$objProperty->set_loop($properties);

		$post['property_id'] 	= $objProperty->displayUniqueID();
		$post['feed'] 			= $data['source'];
		$post['address'] 		= $objProperty->getAddress();

		return $post;
	}

	private function _strLowerReplace($string, $search = ' ', $replace = ''){
		return str_replace($search, $replace, strtolower($string));
	}

	/**
	 * Process the form in add
	 * */
	public function postUpdateOption($post){
		if( $post['property_type'] == 'property' ){
			$post = $this->_getPropertyByURL($post);
		}else{
			$post['property_id'] 	= $this->_strLowerReplace($post['property_data']);
			$post['feed'] 			= '';
			$post['address'] 		= $post['property_type'];
		}
		$update_option_prefix 		= 'tag-content-' . $post['property_id'];
		update_option($update_option_prefix, $post);
	}

	//http://davidwalsh.name/flatten-nested-arrays-php
	private function array_flatten($array,$return = array()) {
		for($x = 0; $x <= count($array); $x++) {

			if(isset($array[$x]) && is_array($array[$x])) {
				$return = $this->array_flatten($array[$x], $return);
			}
			else {
				if(isset($array[$x])) {
					$return[] = $array[$x];
				}
			}
		}
		return $return;
	}

	public function displayTagContent($objProperty){
		$has_option			= false;
		$get_option			= array();
		$prefix_option		= 'tag-content-';
		$post_content 		= array();
		$post_cat_content 	= array();
		$content			= array();
		$category			= array();

		$display_featured_img 			= false;
		$display_category_featured_img 	= false;

		$display_content_excerpt = false;
		$display_category_excerpt = false;

		$title		  = 'News and Update';
		$feed 		  =	\MD_Single_Property::get_instance()->getApiDataSource();

		if( $feed == 'mls' ){
			$property_id 	= $objProperty->Matrix_Unique_ID;
			$city			=	$this->_strLowerReplace($objProperty->City);
			$state			=	$this->_strLowerReplace($objProperty->State);
			$county			=	'';
			$community		=	'';
			$cityid			=	0;
			$stateid		=	0;
			$communityid	=	0;
			$countyid		=	0;
		}elseif( $feed == 'crm' ){
			$property_id 	= $objProperty->id;
			$city			=	$this->_strLowerReplace($objProperty->city);
			$state			=	$this->_strLowerReplace($objProperty->state);
			$county			=	$this->_strLowerReplace($objProperty->county);
			$community		=	$this->_strLowerReplace($objProperty->community);
			$cityid			=	$objProperty->cityid;
			$stateid		=	$objProperty->stateid;
			$communityid	=	$objProperty->communityid;
			$countyid		=	$objProperty->countyid;
		}

		$possible_id = array(
			'id' => $property_id,
			'city' => $city,
			'state' => $state,
			'county' => $county,
			'community' => $community,
			'cityid' => $cityid,
			'stateid' => $stateid,
			'communityid' => $communityid,
			'countyid' => $countyid
		);

		foreach($possible_id as $key=>$val){
			if( get_option($prefix_option . $val) ){
				$has_option = true;
				$get_option[] = $prefix_option . $val;
			}
		}

		if( $has_option && $get_option  ){
			foreach($get_option as $val) {
				$content[] = get_option($val);
			}
		}

		if( count($content) > 0 ){
			$choose_content 	= array();
			$choose_category 	= array();
			$options_content	= array();
			$options_category	= array();

			foreach($content as $key => $val ){
				if( isset($val['choose_content']) ){
					$choose_content[] = $val['choose_content'];
				}
				if( isset($val['choose_category']) ){
					$choose_category[] = $val['choose_category'];
				}

				if( isset($val['choose_content']) && count($val['choose_content']) > 0 ){
					foreach($val['choose_content'] as $val_choose_content){
						$options_content[$val_choose_content] = array(
							'display_featured_img' => isset($val['display_featured_img']) ? $val['display_featured_img']:0,
							'display_content_list' => isset($val['display_content_list']) ? $val['display_content_list']:0
						);
					}
				}

				if( isset($val['choose_category']) && count($val['choose_category']) > 0 ){
					foreach($val['choose_category'] as $val_choose_category){
						$options_category[$val_choose_category] = array(
							'display_category_featured_img' => $val['display_category_featured_img'],
							'display_category_list' => $val['display_category_list']
						);
					}
				}
			}

			$flat_choose_content = $this->array_flatten($choose_content);
			if( count($flat_choose_content) > 0 ){
				$post_content = get_posts(
					array(
						'include'	=>	$flat_choose_content,
						'post_type'	=>	'any'
					)
				);
				wp_reset_postdata();
			}

			$flat_choose_category = $this->array_flatten($choose_category);
			if( count($flat_choose_category) > 0 ){
				$cat = implode(', ', $flat_choose_category);
				$post_cat_content = get_posts(
					array( 'category'=>$cat )
				);
				wp_reset_postdata();
			}
		}

		require_once( GLOBAL_TEMPLATE . 'list_content.php' );
	}

}

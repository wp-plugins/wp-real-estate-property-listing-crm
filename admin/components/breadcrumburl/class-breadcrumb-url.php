<?php
class Breadcrumb_Url{
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	public $array_error = array();

	public function __construct() {
		$this->prefix = 'plugin-settings';
		$this->slug = 'admin.php?page=md-api-settings-breadcrumb-url';
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
			'Breadcrumb URL',
			'Breadcrumb URL',
			'manage_options',
			'md-api-settings-breadcrumb-url',
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
		$obj_admin_util = new Masterdigm_Admin_Util;
		switch($request){
			case 'add':
				$this->displayAddNew();
			break;
			case 'edit':
				$id = sanitize_text_field($_GET['id']);
				$this->displayEdit($id);
			break;
			case 'post_add_new':
				$error 		= array();
				$has_error 	= false;

				if( sanitize_text_field($_POST['filter_name']) == '' ){
					$has_error = true;
					$error[] = 'Please don\'t leave filter name blank';
				}

				if( isCRM() && sanitize_text_field($_POST['filter_location_id']) == '' ){
					$has_error = true;
					$error[] = 'Please don\'t leave location Id blank';
				}

				if( $has_error ){
					$this->setError($error);
					$this->displayAddNew($error);
				}else{
					$this->addNewFilter($_POST);
					\Masterdigm_Admin_Util::get_instance()->redirect_to($this->slug);
				}
			break;
			case 'post_update':
				$error 		= array();
				$has_error 	= false;

				if( sanitize_text_field($_POST['filter_name']) == '' ){
					$has_error = true;
					$error[] = 'Please don\'t leave filter name blank';
				}

				if( isCRM() && sanitize_text_field($_POST['filter_location_id']) == '' ){
					$has_error = true;
					$error[] = 'Please don\'t leave location Id blank';
				}

				if( $has_error ){
					$this->setError($error);
					$id = sanitize_text_field($_GET['id']);
					$this->displayEdit($id);
				}else{
					$this->updateFilter($_POST);
					\Masterdigm_Admin_Util::get_instance()->redirect_to($this->slug);
				}
			break;
			case 'delete':
				$nonce = $_REQUEST['_wpnounce'];
				if ( ! wp_verify_nonce( $nonce, $_REQUEST['id'] ) ) {
					// This nonce is not valid.
					die( 'Security check' );
				} else {
					$delete_option_prefix = 'breadcrumb-url-' . $_REQUEST['id'];
					delete_option($delete_option_prefix);
					\Masterdigm_Admin_Util::get_instance()->redirect_to($this->slug);
				}
			break;
			default:
				$url = $this->listFilter();
				require_once( plugin_dir_path( __FILE__ ) . 'view/list.php' );
			break;
		}
	}

	/**
	 * experiment, idea is to get the whole coverage
	 * */
	public function getCoverage(){
		$coverage_array = array();
		$coverage 		= \MD_Template_Setting::get_instance()->getCoverageLookUp();
		if( $coverage->result == 'success' ){
			foreach($coverage->lookups as $key=>$val){
				$coverage_array[] = array(
					'location' 	=> $val->keyword,
					'id'		=> $val->id
				);
			}
		}

		return $coverage_array;
	}

	/**
	 * display add form
	 * @return include php
	 * */
	public function displayAddNew(){
		global $wpdb;

		$page_ids 	= $this->getPageIdAssociate();
		$arg = array(
			'post_type'			=>array('post','page'),
			'posts_per_page'	=> '-1',
			'exclude'			=> array_keys($page_ids)
		);
		$posts_array = get_posts($arg);

		$choose_location_to_search = array(
			'country' => 'Country',
			'county' => 'County',
			'state' => 'State',
			'city' => 'City',
			'community' => 'Community',
			'zip' => 'Zip'
		);
		require_once( plugin_dir_path( __FILE__ ) . 'view/add.php' );
	}

	/**
	 * Update the breadcrumb url
	 * @return	wordpress update_option
	 * */
	public function addNewFilter($data){
		$update_option_prefix 		= 'breadcrumb-url-' . $data['select_page'];
		$arr_update_breadcrumb_url 	= array(
			'filter_name'=> $data['filter_name'],
			'page_id'=> $data['select_page'],
			'location_id'=> $data['filter_location_id'] ? $data['filter_location_id']:0,
			'filter_location_search'=> $data['filter_location_search']
		);
		update_option($update_option_prefix,$arr_update_breadcrumb_url);
	}

	/**
	 * Update the breadcrumb url
	 * @return	wordpress update_option
	 * */
	public function updateFilter($data){
		$update_option_prefix 		= 'breadcrumb-url-' . $data['select_page'];
		$arr_update_breadcrumb_url 	= array(
			'filter_name'=> $data['filter_name'],
			'page_id'=> $data['select_page'],
			'location_id'=> $data['filter_location_id'] ? $data['filter_location_id']:0,
			'filter_location_search'=> $data['filter_location_search']
		);
		update_option($update_option_prefix,$arr_update_breadcrumb_url);
	}

	/**
	 * display edit form
	 *
	 * @return include	php
	 * */
	public function displayEdit($id){
		global $wpdb;

		$option_id 	= 'breadcrumb-url-'.$id;

		$get_filter	= get_option($option_id);
		$get_filter	= \helpers\Text::array_to_object($get_filter);

		$page_ids 	= $this->getPageIdAssociate();
		unset($page_ids[$id]);
		$arg = array(
			'post_type'			=>array('post','page'),
			'posts_per_page'	=> '-1',
			'exclude'			=> array_keys($page_ids)
		);

		$posts_array = get_posts($arg);

		$choose_location_to_search = array(
			'country' => 'Country',
			'county' => 'County',
			'state' => 'State',
			'city' => 'City',
			'community' => 'Community',
			'zip' => 'Zip'
		);
		require_once( plugin_dir_path( __FILE__ ) . 'view/edit.php' );
	}

	/**
	 * database get breadcrumb-url
	 * */
	public function getFilters(){
		global $wpdb;

		$query = "SELECT * FROM $wpdb->options
					WHERE option_name LIKE '%breadcrumb-url%'
					ORDER BY option_id DESC";
		return $wpdb->get_results( $query, OBJECT );
	}

	/**
	 * Get all
	 * */
	public function getUrlFilters(){
		$url 		= $this->getFilters();
		$array_url 	= array();
		if( $url ){
			foreach( $url as $key => $val ){
				$unserialize_array = unserialize($val->option_value);
				$key_item = preg_replace('/\s+/', '', $unserialize_array['filter_name']);
				$key_item = strtolower($key_item);
				$array_url[$key_item] = $val->option_value;
			}
		}
		return $array_url;
	}

	/**
	 * Get single
	 * */
	public function getUrlFilter($location_name){
		$location_name 	= preg_replace('/\s+/', '', $location_name);
		$location_name 	= strtolower($location_name);
		$url_filters 	= $this->getUrlFilters();

		if( array_key_exists($location_name,$url_filters) ){
			$unserialize_array = unserialize($url_filters[$location_name]);
			return get_permalink($unserialize_array['page_id']);
		}else{
			return false;
		}
	}

	/**
	 * get page id on the associate breadcrumb url
	 * */
	public function getPageIdAssociate(){
		$page_id 		= $this->getFilters();
		$array_page_id 	= array();
		if( $page_id ){
			foreach( $page_id as $key => $val ){
				$unserialize_array 			= unserialize($val->option_value);
				$key_item 					= $unserialize_array['page_id'];
				$array_page_id[$key_item] 	= $val->option_value;
			}
		}
		return $array_page_id;
	}

	/**
	 * get the page details, of the current page by page id
	 * */
	public function getPageLocationId($page_id){
		$array_page_id 	 = $this->getPageIdAssociate();
		$location_id 	 = null;
		if( array_key_exists($page_id,$array_page_id) ){
			$unserialize_array = unserialize($array_page_id[$page_id]);
			return \helpers\Text::array_to_object($unserialize_array);
		}else{
			return false;
		}
	}

	/**
	 * List of breadcrumb filter
	 * */
	public function listFilter(){
		$url 		= $this->getUrlFilters();
		$array_url 	= array();
		if( count($url) > 0 ){
			foreach($url as $key=>$val){
				$array_url[] = unserialize($val);
			}
		}
		return \helpers\Text::array_to_object($array_url);
	}

}
?>

<?php
class Save_Search{
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	public $print_pdf_property_id;

	public function __construct(){
		$this->plugin_name 	= \Masterdigm_API::get_instance()->get_plugin_name();
		$this->version 	 	= \Masterdigm_API::get_instance()->get_version();
		$this->init_wp_hook();
	}

	public function init_wp_hook(){
		add_action( 'wp_ajax_save_search_action', array($this,'save_search_action_callback') );
		add_action( 'wp_ajax_nopriv_save_search_action',array($this,'save_search_action_nopriv_callback') );
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		/*add_action( 'execute_after_signup',array($this, 'save_search_init'),10, 2 );*/
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

	public function enqueue_scripts(){
		wp_enqueue_script( $this->plugin_name . '-save-search', plugin_dir_url( __FILE__ ) . 'js/save-search-min.js', array( 'jquery' ), $this->version, true );
	}

	private function _get_current_location_name($search_data){
		$location_name 		= '';
		$str_save_location 	= '';

		if( isset($search_data['city']) && $search_data['city'] != '' ){
			$str_save_location = $search_data['city'];
		}
		if( isset($search_data['community']) && $search_data['community'] != '' ){
			$str_save_location = $search_data['community'];
		}
		if( isset($search_data['subdivision']) && $search_data['subdivision'] != '' ){
			$str_save_location = $search_data['subdivision'];
		}
		$location_name = $str_save_location;

		return $location_name;
	}

	private function _get_property_type($search_data){
		$str_property_type = '';
		$property_type_id = 0;
		$property_type_id = $search_data['property_type'];

		$hook_property_type = array();
		$hook_property_type = apply_filters('fields_type_' . DEFAULT_FEED, $hook_property_type);

		if( $hook_property_type ){
			$property_type_name = '';
			foreach($hook_property_type as $key=>$val){
				if( $key == $property_type_id){
					$property_type_name = $val;
				}
			}
			$str_property_type = ', '.$property_type_name;
		}

		return $str_property_type;
	}

	private function _get_transaction_type($search_data){
		$property_type = '';
		if( $search_data['transaction'] != '' && !is_numeric($search_data['transaction']) ){
			$property_type = ', '.$search_data['transaction'];
		}
		return $property_type;
	}

	private function _get_price($search_data){
		$price = '';

		$min_price = 0;
		if( $search_data['min_listprice'] > 0 ){
			$min_price = $search_data['min_listprice'];
		}

		$max_price = 0;
		if( $search_data['max_listprice'] > 0 ){
			$max_price = $search_data['max_listprice'];
		}

		if( $min_price > 0 || $max_price > 0 ){
			$account  = \CRM_Account::get_instance()->get_account_data();
			$get_currency = ($account->currency) ? $account->currency:'$';
			$price = ', Price : ' . $get_currency.number_format($min_price) . ' - ' . $get_currency.number_format($max_price);
		}
		return $price;
	}

	private function _get_bed($search_data){
		$bed = '';

		$min_bed = $search_data['min_beds'];
		if( $search_data['min_beds'] > 0 ){
			$min_bed = $search_data['min_beds'];
		}

		$max_bed = 0;
		if( $search_data['max_beds'] > 0 ){
			$max_bed = $search_data['max_beds'];
		}

		if( $min_bed > 0 || $max_bed > 0 ){
			$bed = ', Bed ' . $min_bed . ' - ' . $max_bed;
		}
		return $bed;
	}

	private function _get_bath($search_data){
		$baths = '';

		$min_baths = $search_data['min_baths'];
		if( $search_data['min_baths'] > 0 ){
			$min_baths = $search_data['min_baths'];
		}

		$max_baths = 0;
		if( $search_data['max_baths'] > 0 ){
			$max_baths = $search_data['max_baths'];
		}

		if( $min_baths > 0 || $max_baths > 0 ){
			$baths = ', Baths ' . $min_baths . ' - ' . $max_baths;
		}
		return $baths;
	}

	public function increment_search_counter($search_keyword){
		$key_prefix = 'save-search-' . $search_keyword;
		$get_curent_option = get_option($key_prefix);
		if( $get_curent_option ){
			if( $get_curent_option >= 1 ){
				update_option($key_prefix,($get_curent_option + 1));
			}
		}else{
			update_option($key_prefix,1);
		}
	}

	public function decrement_search_counter($search_keyword){
		$key_prefix = 'save-search-' . $search_keyword;
		$get_curent_option = get_option($key_prefix);
		if( $get_curent_option ){
			if( $get_curent_option > 1 ){
				update_option($key_prefix,($get_curent_option - 1));
			}else{
				delete_option($key_prefix);
			}
		}
	}

	public function save_search_init($data = array()){
		global $current_user;
		get_currentuserinfo();

		$post_data = array();
		if( isset($_POST['data_post']) ){
			$post_data = $_POST['data_post'];
			if( isset($post_data['post']) ){
				parse_str($post_data['post']['data_post'],$ajax_data_post);
			}else{
				parse_str($post_data,$ajax_data_post);
			}
		}else{
			if( isset($_POST['post_data']) ){
				$post_data = $_POST['post_data'];
				if( isset($post_data['post']) ){
					parse_str($post_data['post']['data_post'],$ajax_data_post);
				}else{
					parse_str($post_data,$ajax_data_post);
				}
			}
		}

		$save_search_name = '';
		$location_name = $this->_get_current_location_name($ajax_data_post);
		$price = $this->_get_price($ajax_data_post);
		$property_type = $this->_get_property_type($ajax_data_post);
		$beds = $this->_get_bed($ajax_data_post);
		$baths = $this->_get_bath($ajax_data_post);

		$save_search_name 						= $location_name .', '. $ajax_data_post['transaction'] . $property_type . $price . $beds . $baths;
		$ajax_data_post['save_search_name'] 	= $save_search_name;
		$ajax_data_post['md5_save_search_name'] = md5($save_search_name);
		$ajax_data_post['user_meta_name'] 		= 'save-search-'.md5($save_search_name);
		$ajax_data_post['http_referrer'] 		= $_SERVER['HTTP_REFERER'];

		$update = update_user_meta( $current_user->ID, $ajax_data_post['user_meta_name'], $ajax_data_post );
		if( trim($ajax_data_post['mls']) != '' && DEFAULT_FEED == 'mls' && $location_name != '' ){
			$property_alert = \Property_Alert::get_instance()->subscribe_property_alert($ajax_data_post);
			$ajax_data_post['subscribed_property_alert'] = 1;
			$ajax_data_post['ret_property_alert'] = $property_alert;
			update_user_meta( $current_user->ID, $ajax_data_post['user_meta_name'], $ajax_data_post );
		}

		if( $update ){
			$this->increment_search_counter($ajax_data_post['md5_save_search_name']);
			return $update;
		}
		return false;
	}

	// for logged in users
	public function save_search_action_callback(){
		$ret = $this->save_search_init();

		$msg 	= 'logged in users';
		$status = true;
		$json_array = array(
			'msg'=>$msg,
			'status'=>$status,
			'is_loggedin'=>1,
			'ret'=>$ret
		);
		echo json_encode($json_array);
		die();
	}

	// for not logged in users
	public function save_search_action_nopriv_callback(){
		$msg = 'not logged in user';
		$status = true;
		echo json_encode(
			array(
				'msg'=>$msg,
				'status'=>$status,
				'is_loggedin'=>0
			)
		);
		die();
	}

	public function get_all_by_userid($user_id){
		global $wpdb;
		$sql = "SELECT * FROM $wpdb->usermeta WHERE meta_key like '%save-search%' and user_id = {$user_id}";
		return $wpdb->get_results($sql);
	}

	public function get_save_search( $umeta_key, $single = false, $umeta_user_id = null ){
		global $current_user;
		get_currentuserinfo();

		$user_id = $current_user->ID;
		if( !is_null($umeta_user_id) ){
			$user_id = $umeta_user_id;
		}

		$meta_prefix = 'save-search-';
		$save_search_meta_key = $meta_prefix . $umeta_key;
		$get_save_search = get_user_meta( $user_id, $save_search_meta_key, $single );

		return $get_save_search;
	}

	public function display_button($atts){
		global $current_user, $user_ID;
		get_currentuserinfo();

		$search_keyword = '';
		$is_logged_in = 0;

		$mls_type = '';
		if( isset($atts['mls_type']) ){
			$mls_type = $atts['mls_type'];
		}

		$location_name = '';
		if( isset($_GET['locationname']) && $_GET['locationname'] != ''){
			$location_name = $_GET['locationname'];
		}elseif(isset($_REQUEST['locationname']) && $_REQUEST['locationname'] != ''){
			$location_name = $_REQUEST['locationname'];
		}

		$property_type = '';
		if( isset($_GET['property_type']) && $_GET['property_type'] != ''){
			$property_type = $_GET['property_type'];
		}elseif(isset($_REQUEST['property_type']) && $_REQUEST['property_type'] != ''){
			$property_type = $_REQUEST['property_type'];
		}
		$communityid 	= 0;
		$is_community 	= false;
		if(
			(isset($_GET['communityid']) && $_GET['communityid'] != '')
			||
			(isset($_REQUEST['communityid']) && $_REQUEST['communityid'] != '')
		)
		{
			$is_community 	= true;
			$communityid 	= $_GET['communityid'];
		}
		$cityid 	= 0;
		$is_city 	= false;
		if(
			(isset($_GET['cityid']) && $_GET['cityid'] != '')
			||
			(isset($_REQUEST['cityid']) && $_REQUEST['cityid'] != '')
		)
		{
			$cityid 	= $_GET['cityid'];
			$is_city 	= true;
		}
		$subdivisionid  = 0;
		$is_subdivision = false;
		if(
			(isset($_GET['subdivisionid']) && $_GET['subdivisionid'] != '')
			||
			(isset($_REQUEST['subdivisionid']) && $_REQUEST['subdivisionid'] != '')
		)
		{
			$subdivisionid  = $_GET['subdivisionid'];
			$is_county = true;
		}
		$countyid  = 0;
		$is_county = false;
		if(
			(isset($_GET['countyid']) && $_GET['countyid'] != '')
			||
			(isset($_REQUEST['countyid']) && $_REQUEST['countyid'] != '')
		)
		{
			$countyid  = $_GET['countyid'];
			$is_county = true;
		}

		$county = '';
		if( $location_name != '' && $is_county ){
			$county = $location_name;
		}elseif(isset($atts['search_keyword']['countyid'])){
			$county = $atts['search_keyword']['countyid'];
		}

		$city = '';
		if( $location_name != '' && $is_city ){
			$city = $location_name;
		}elseif(isset($atts['search_keyword']['cityid'])){
			$city = $atts['search_keyword']['cityid'];
		}

		$community = '';
		if( $location_name != '' && $is_community ){
			$community = $location_name;
		}elseif( isset($atts['search_keyword']['communityid']) ){
			$community = $atts['search_keyword']['communityid'];
		}

		$subdivision = '';
		if( $location_name != '' && $is_subdivision ){
			$subdivision = $location_name;
		}elseif( isset($atts['search_keyword']['subdivisionid']) ){
			$subdivision = $atts['search_keyword']['subdivisionid'];
		}

		$min_listprice = 0;
		if( isset($atts['search_keyword']['min_listprice']) ){
			$min_listprice = $atts['search_keyword']['min_listprice'];
		}else{
			if( isset($_GET['min_listprice']) && $_GET['min_listprice'] != ''){
				$min_listprice = $_GET['min_listprice'];
			}elseif(isset($_REQUEST['min_listprice']) && $_REQUEST['min_listprice'] != ''){
				$min_listprice = $_REQUEST['min_listprice'];
			}
		}
		$max_listprice = 0;
		if( isset($atts['search_keyword']['max_listprice']) ){
			$max_listprice = $atts['search_keyword']['max_listprice'];
		}else{
			if( isset($_GET['max_listprice']) && $_GET['max_listprice'] != ''){
				$max_listprice = $_GET['max_listprice'];
			}elseif(isset($_REQUEST['max_listprice']) && $_REQUEST['max_listprice'] != ''){
				$max_listprice = $_REQUEST['max_listprice'];
			}
		}
		$min_beds = 0;
		if( isset($atts['search_keyword']['min_beds']) ){
			$min_beds = $atts['search_keyword']['min_beds'];
		}
		$max_beds = 0;
		if( isset($atts['search_keyword']['bedrooms']) ){
			$max_beds = $atts['search_keyword']['bedrooms'];
		}else{
			if( isset($_GET['bedrooms']) && $_GET['bedrooms'] != ''){
				$max_beds = $_GET['bedrooms'];
			}elseif(isset($_REQUEST['bedrooms']) && $_REQUEST['bedrooms'] != ''){
				$max_beds = $_REQUEST['bedrooms'];
			}
		}
		$min_baths = 0;
		if( isset($atts['search_keyword']['min_baths']) ){
			$min_baths = $atts['search_keyword']['min_baths'];
		}
		$max_baths = 0;
		if( isset($atts['search_keyword']['bathrooms']) ){
			$max_baths = $atts['search_keyword']['bathrooms'];
		}else{
			if( isset($_GET['bathrooms']) && $_GET['bathrooms'] != ''){
				$max_baths = $_GET['bathrooms'];
			}elseif(isset($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] != ''){
				$max_baths = $_REQUEST['bathrooms'];
			}
		}
		$min_garage = 0;
		if( isset($atts['search_keyword']['min_garage']) ){
			$min_garage = $atts['search_keyword']['min_garage'];
		}
		$transaction = 'for sale';
		if( isset($atts['search_keyword']['transaction']) ){
			$transaction = $atts['search_keyword']['transaction'];
		}else{
			if( isset($_GET['transaction']) && $_GET['transaction'] != ''){
				$transaction = $_GET['transaction'];
			}elseif(isset($_REQUEST['transaction']) && $_REQUEST['transaction'] != ''){
				$transaction = $_REQUEST['transaction'];
			}
		}

		if( DEFAULT_FEED == 'mls' ){
			$transaction = 'sale';
			$ex_string = explode(' ',urldecode($transaction));
			if( count($ex_string) == 2 && isset($ex_string[1]) ){
				$transaction = strtolower($ex_string[1]);
			}else{
				if(
					sanitize_text_field(isset($_REQUEST['transaction'])) &&
					sanitize_text_field($_REQUEST['transaction']) != '' &&
					sanitize_text_field($_REQUEST['transaction']) != 'all'
				){
					$ex_string = explode(' ',$_REQUEST['transaction']);
					if( count($ex_string) == 2 && isset($ex_string[1]) ){
						$transaction = $ex_string[1];
					}else{
						$transaction = sanitize_text_field($_REQUEST['transaction']);
					}
				}else{
					$transaction = 'sale';
				}
			}
		}//DEFAULT_FEED == 'mls'

		$content = 'Need to login or register before saving this search';
		if(is_user_logged_in()) {
			global $current_user;
			get_currentuserinfo();
			$content = '';
		};
		$crm_company 	= \CRM_Account::get_instance()->get_account_data('company');
		$post_data = array(
			'mls'			=>	$mls_type,
			'source'		=>	$crm_company,
			'source_url'	=>	site_url() . '?'. $_SERVER['QUERY_STRING'],
			'source_website'=>	site_url(),
			'city'			=>	$city,
			'community'		=>	$community,
			'subdivision'	=>	$subdivision,
			'min_listprice'	=>	$min_listprice,
			'max_listprice'	=>	$max_listprice,
			'min_beds'		=>	$min_beds,
			'max_beds'		=>	$max_beds,
			'min_baths'		=>	$min_baths,
			'max_baths'		=>	$max_baths,
			'min_garage'	=>	$min_garage,
			'transaction'	=>	$transaction,
			'property_type'	=>	$property_type,
			'subdivisionid'	=>	$subdivisionid,
			'cityid'		=>	$cityid,
			'communityid'	=>	$communityid,
		);
		$save_search_name 	= '';
		$location_name 		= $this->_get_current_location_name($post_data);
		$price 				= $this->_get_price($post_data);
		$property_type 		= $this->_get_property_type($post_data);
		$beds 				= $this->_get_bed($post_data);
		$baths 				= $this->_get_bath($post_data);

		$save_search_name = $location_name .', '. $post_data['transaction'] . $property_type . $price . $beds . $baths;

		$save_search =  $this->get_save_search(md5($save_search_name),true);

		$class = 'register-open';
		if( $user_ID != '' ){
			$class = 'save-search';
			$is_logged_in = 1;
		}

		if( $save_search ){
			$class = 'saved-search disabled';
		}

		$btn_class = 'btn-primary';
		if( $save_search ){
			$btn_class = 'btn-success';
		}

		$btn_name = 'Save This Search';
		if( $save_search ){
			$btn_name = 'Saved Search';
		}

		$btn_icon = 'glyphicon-star-empty';
		if( $save_search ){
			$btn_icon = 'glyphicon-star';
		}

		if( isset($atts['search_keyword']) ){
			$query_data = http_build_query($post_data);
		}

		if( trim($location_name) != '' ){
			require 'view/save-search-button.php';
		}
	}

}

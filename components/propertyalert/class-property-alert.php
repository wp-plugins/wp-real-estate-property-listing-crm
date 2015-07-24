<?php
class Property_Alert{
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
		add_action( 'wp_ajax_property_alert_action', array($this,'property_alert_action_callback') );
		add_action( 'wp_ajax_nopriv_property_alert_action',array($this,'property_alert_action_nopriv_callback') );
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action( 'execute_after_signup',array($this, 'property_alert_init'),10, 2 );
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
		wp_enqueue_script( $this->plugin_name . '-property-alert-actions', plugin_dir_url( __FILE__ ) . 'js/property-alert.js', array( 'jquery' ), $this->version, true );
	}

	public function subscribe_property_alert($post_data = array()){
		global $current_user;
		get_currentuserinfo();

		$user_meta = get_user_meta($current_user->ID);
		if( $user_meta && isset($user_meta['lead-data']) ){
			$crm_company 					= \CRM_Account::get_instance()->get_account_data('company');
			$lead_data 						= unserialize($user_meta['lead-data'][0]);
			$post_data['leadid'] 			= $lead_data->leadid;
			$post_data['lead_name'] 		= $current_user->user_firstname.' '.$current_user->user_lastname;
			$post_data['lead_email'] 		= $current_user->user_email;
			$post_data['source_website']	= $post_data['source_website'];
			$post_data['source_url']		= $post_data['source_url'];
			$post_data['source'] 			= $crm_company;

			strtolower($post_data['transaction']);

			return \Masterdigm_MLS::get_instance()->add_property_alert($post_data);
		}

		return false;
	}

	public function ajax_subscribe_property_alert($data = array()){
		global $current_user;
		get_currentuserinfo();
		$post_data = array();
		if( isset($_POST['post_data']) ){
			$post_data = $_POST['post_data'];
			parse_str($post_data['post']['data_post'],$ajax_data_post);
		}

		return $this->subscribe_property_alert($ajax_data_post);
	}

	// for logged in users
	public function property_alert_action_callback(){
		$ret = $this->ajax_subscribe_property_alert();
		$msg = 'logged in users';
		$status = true;
		echo json_encode(
			array(
				'msg'=>$msg,
				'status'=>$status,
				'is_loggedin'=>1,
				'ret'=>$ret
			)
		);
		die();
	}

	// for not logged in users
	public function property_alert_action_nopriv_callback(){
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

	public function display_button($atts){
		global $current_user, $user_ID;
		get_currentuserinfo();

		$search_keyword = '';
		$is_logged_in = 0;
		$class = 'register-open';
		//$class = 'save-search';
		if( $user_ID != '' ){
			$class = 'save-search';
			$is_logged_in = 1;
		}
		$mls_type = '';
		if( isset($atts['mls_type']) ){
			$mls_type = $atts['mls_type'];
		}
		$city = '';
		if( isset($atts['search_keyword']['cityid']) ){
			$city = $atts['search_keyword']['cityid'];
		}
		$community = '';
		if( isset($atts['search_keyword']['communityid']) ){
			$community = $atts['search_keyword']['communityid'];
		}
		$subdivision = '';
		if( isset($atts['search_keyword']['subdivisionid']) ){
			$subdivision = $atts['search_keyword']['subdivisionid'];
		}
		$min_listprice = 0;
		if( isset($atts['search_keyword']['min_listprice']) ){
			$min_listprice = $atts['search_keyword']['min_listprice'];
		}
		$max_listprice = 0;
		if( isset($atts['search_keyword']['max_listprice']) ){
			$max_listprice = $atts['search_keyword']['max_listprice'];
		}
		$min_beds = 0;
		if( isset($atts['search_keyword']['min_beds']) ){
			$min_beds = $atts['search_keyword']['min_beds'];
		}
		$max_beds = 0;
		if( isset($atts['search_keyword']['bedrooms']) ){
			$max_beds = $atts['search_keyword']['bedrooms'];
		}
		$min_baths = 0;
		if( isset($atts['search_keyword']['min_baths']) ){
			$min_baths = $atts['search_keyword']['min_baths'];
		}
		$max_baths = 0;
		if( isset($atts['search_keyword']['bathrooms']) ){
			$max_baths = $atts['search_keyword']['bathrooms'];
		}
		$min_garage = 0;
		if( isset($atts['search_keyword']['min_garage']) ){
			$min_garage = $atts['search_keyword']['min_garage'];
		}
		$transaction = 'for sale';
		if( isset($atts['search_keyword']['transaction']) ){
			$transaction = $atts['search_keyword']['transaction'];
		}
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
				$transaction = 'For Sale';
			}
		}
		if(is_user_logged_in()) {
			global $current_user;
			get_currentuserinfo();

		};

		$crm_company 	= \CRM_Account::get_instance()->get_account_data('company');
		$post_data = array(
			'mls'			=>	$mls_type,
			'source'		=>	$crm_company,
			'source_website'=>	site_url(),
			'source_url'	=>	site_url(),
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
		);
		if( isset($atts['search_keyword']) ){
			$query_data = http_build_query($post_data);
		}
		if( DEFAULT_FEED == 'mls' ){
			require 'view/save-search-button.php';
		}
	}

}

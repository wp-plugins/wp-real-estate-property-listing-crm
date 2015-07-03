<?php
class XOut_Property{
	protected static $instance = null;

	protected $key_xout_property = 'xout-property-';

	public function __construct(){
		if( is_user_logged_in() ){
			add_action( 'wp_ajax_xoutproperty_action', array($this,'xoutproperty_action_callback') );
			add_action( 'wp_ajax_nopriv_xoutproperty_action',array($this,'xoutproperty_action_nopriv_callback') );

			add_action( 'wp_ajax_remove_xout_property_action', array($this,'remove_xout_property_action_callback') );
			add_action( 'wp_ajax_nopriv_remove_xout_property_action',array($this,'remove_xout_property_action_callback') );
		}
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

	public function xoutproperty_action_callback(){
		global $current_user;
		get_currentuserinfo();

		$current_action = 0;
		$ret_data = array();
		$post = array();
		if( isset($_POST['post_data']) ){
			$post = $_POST['post_data'];
		}

		$post_data = array();
		if( isset($_POST['post_data']) ){
			$post_data = $_POST['post_data'];
			parse_str($post_data['post']['data_post'],$ajax_data_post);
		}

		$post_property_id = 0;
		if( isset($ajax_data_post['property-id']) ){
			$post_property_id = $ajax_data_post['property-id'];
		}

		$post_property_feed = DEFAULT_FEED;
		if( isset($ajax_data_post['property-feed']) ){
			$post_property_feed = $ajax_data_post['property-feed'];
		}

		$msg 	= '';
		$status = false;

		$msg 		 = 'Successfully X-Out Property';
		$status 	 = true;
		$user_id 	 = $current_user->ID;
		$property_id = sanitize_text_field($post_property_id);
		$feed 		 = sanitize_text_field($post_property_feed);
		if( $property_id != 0 ){
			$save_property = array(
				'id' => $property_id,
				'feed' => $feed
			);
			update_user_meta($user_id, 'xout-property-' . $property_id, $save_property);
			delete_user_meta($user_id, 'save-property-' . $property_id);
		}

		echo json_encode(array('msg'=>$msg,'status'=>$status));
		die();
	}

	public function xoutproperty_action_nopriv_callback(){
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

	public function remove_xout_property_action_callback(){
		global $current_user;
		get_currentuserinfo();

		check_ajax_referer( 'md-ajax-request', 'security' );
		$msg 	= '';
		$status = false;

		if(is_user_logged_in()) {
			$msg = 'Successfully Remove X-Out Property';
			$status = true;
			$user_id = $current_user->ID;
			$property_id = sanitize_text_field($_POST['property-id']);
			delete_user_meta($user_id, 'xout-property-' . $property_id);
		}

		echo json_encode(array('msg'=>$msg,'status'=>$status));
		die();
	}

	public function check_property($property_id, $user_id = null){
		global $current_user;
		get_currentuserinfo();

		if( !$user_id ){
			$user_id = $current_user->ID;
		}

		if(is_user_logged_in()) {
			$get = get_user_meta($user_id, $this->key_xout_property . $property_id, true);
			if( $get && count($get) > 0 ){
				return true;
			}
		}
	}

}

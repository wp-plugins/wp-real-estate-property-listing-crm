<?php
class MD_Subscribe_API{
	protected static $instance = null;

	public $slug;
	public $activation_key;
	public $array_error = array();

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

	/**
	 * @param $arg array() possible elements
	 * k = the activation key - required
	 * email = email address - required
	 * company = name of the company
	 * first_name = first name
	 * last_name = last name
	 * */
	public function get_activation_key($arg = array()){
		//http://api.masterdigm.net/fkey?email={email}
		$email = '';
		if( isset($arg['email']) ){
			$email = $arg['email'];
		}

		$url = "http://api.masterdigm.net/fkey?email={$email}";
		$response = wp_remote_get($url);
		$response_code = wp_remote_retrieve_response_code( $response );
		if( $response_code == 200 ){
			$response_body = wp_remote_retrieve_body($response);
			$response_body = json_decode($response_body);
			if(
				$response_body
				&& isset($response_body->result)
				&& $response_body->result == 'success'
			){
				return $response_body->key;
			}
		}
		return false;
	}

	/**
	 * @param $arg array() possible elements
	 * k = the activation key - required
	 * email = email address - required
	 * company = name of the company
	 * first_name = first name
	 * last_name = last name
	 * */
	public function get_activate_url($arg = array()){
		$key = '';
		if( isset($arg['k']) ){
			$key = $arg['k'];
		}
		$email = '';
		if( isset($arg['email']) ){
			$email = $arg['email'];
		}
		$company = '';
		if( isset($arg['company']) ){
			$company = $arg['company'];
		}
		$first_name = '';
		if( isset($arg['first_name']) ){
			$first_name = $arg['first_name'];
		}
		$last_name = '';
		if( isset($arg['last_name']) ){
			$last_name = $arg['last_name'];
		}

		$url = "http://api.masterdigm.net/activate?k={$key}&email={$email}&company={$company}&first_name={$first_name}&last_name={$last_name}";
		return $url;
	}

	public function setError($array_error){
		$this->array_error = $array_error;
	}

	public function getError(){
		return $this->array_error;
	}

	public function controller($request = null){
		$request = '';
		if( isset($_REQUEST['action']) ){
			$request = sanitize_text_field($_REQUEST['action']);
		}
		switch($request){
			case 'subscribe_api_key':
				$error 		= array();
				$has_error 	= false;
				$arg['email'] = '';
				if(
					!isset($_POST['email'])
					|| trim($_POST['email']) == ''
					|| !is_email($_POST['email'])
				){
					$has_error = true;
					$error[] = 'Please provide valid email address';
				}else{
					$arg['email'] = $_POST['email'];
				}
				$arg['company'] = '';
				if( isset($_POST['company']) ){
					$arg['company'] = $_POST['company'];
				}

				$arg['first_name'] = '';
				if( isset($_POST['first_name']) ){
					$arg['first_name'] = $_POST['first_name'];
				}

				$arg['last_name'] = '';
				if( isset($_POST['last_name']) ){
					$arg['last_name'] = $_POST['last_name'];
				}

				if( $has_error ){
					$this->setError($error);
					$this->display_index();
				}else{
					$email = $_POST['email'];
					$activation_key = $this->get_activation_key($arg);
					if( $activation_key ){
						$arg['k'] = $activation_key;
						$redirect_to = $this->get_activate_url($arg);
						\Masterdigm_Admin_Util::get_instance()->redirect_to($redirect_to);
					}else{
						$has_error = true;
						$error[] = 'Error in getting activation key';
						$this->setError($error);
						$this->display_index();
					}
				}
			break;
			default:
				$error 		= array();
				$has_error 	= false;

				if( !current_user_can('administrator') ){
					$has_error = true;
					$error[] = 'Need administrator role to subscribe to api';
				}
				if( $has_error ){
					$this->setError($error);
					$this->display_index();
				}else{
					$this->display_index();
				}
			break;
		}
	}

	public function has_subsribed_api(){
		return get_option('subscribed_api');
	}

	/**
	 * display the main index view
	 * */
	public function display_index() {
		$current_user 	= wp_get_current_user();
		$setting 		= \Settings_API::get_instance()->getSettingsGeneralByKey('search_criteria','status');
		$key 	= get_option('api_key');
		$token 	= get_option('api_token');
		if( get_option('md_not_finish_install') ){
			$property_status = \Settings_API::get_instance()->_show_fields_status();
		}
		$credentials_form = plugin_dir_path( __FILE__ ) . 'view/credentials_form.php';
		require_once( plugin_dir_path( __FILE__ ) . 'view/index.php' );
	}

	public function post_update_api($post){
	}

	public function __construct(){}
}

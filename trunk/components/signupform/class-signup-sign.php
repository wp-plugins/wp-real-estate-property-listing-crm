<?php
class Signup_Form{
	protected static $instance = null;
	private $plugin_name;
	private $version;

	public function __construct(){
		add_action('wp_footer', array($this, 'display'));

		if( !is_user_logged_in() ){
			$this->plugin_name 	= \Masterdigm_API::get_instance()->get_plugin_name();
			$this->version 	 	= \Masterdigm_API::get_instance()->get_version();
			add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		}
		add_action( 'signup_action', array($this,'signup_action_callback') );
		add_action( 'wp_ajax_nopriv_signup_action',array($this,'signup_action_callback') );

		add_action( 'wp_ajax_login_action', array($this,'login_action_callback') );
		add_action( 'wp_ajax_nopriv_login_action',array($this,'login_action_callback') );
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
		wp_enqueue_script( $this->plugin_name . '-signup-actions', plugin_dir_url( __FILE__ ) . 'js/signup-min.js', array( 'jquery' ), $this->version, true );
	}

	public function user_signon($user_login, $password, $remember = true){
		$creds 					= array();
		$creds['user_login'] 	= $user_login;
		$creds['user_password'] = $password;
		$creds['remember'] 		= $remember;
		return wp_signon( $creds, false );
	}

	public function register_user($username, $password, $email, $other_data = array()){
		if( !is_user_logged_in() ){
			//username_exists
			if( !username_exists($username) && !email_exists($email) ){
				// create
				$user_id = wp_create_user($username, $password, $email);
				// Set the nickname
				wp_update_user(
					array(
						'ID'          =>    $user_id,
						'nickname'    =>    $other_data['nickname'],
						'first_name'  =>    $other_data['first_name'],
						'last_name'   =>    $other_data['last_name'],
					)
				);

				return $user_id;
			}//username_exists
		}//is_user_logged_in
		return false;
	}

	public function signup_action_callback(){
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ){
			check_ajax_referer( 'md-ajax-request', 'security' );
		}

		$error 				= '';
		$checkuser 			= '';
		$array_data 		= array();
		$ret_data 			= array();
		$save_lead 			= array();
		$current_action 	= 0;

		if( isset($_POST['current_action']) ){
			$current_action = $_POST['current_action'];
		}

		$user_id 		= false;
		$crm_company 	= \CRM_Account::get_instance()->get_account_data('company');
		$source 		= $crm_company;
		$source_note	= $crm_company . ', Register Form';
		$source_url		= site_url();
		$msg 			= '';
		$status 		= false;
		$propertyid 	= 0;

		$firstname 		= sanitize_text_field(isset($_POST['firstname'])) ? sanitize_text_field($_POST['firstname']):'';
		$lastname 		= sanitize_text_field(isset($_POST['lastname'])) ? sanitize_text_field($_POST['lastname']):'';
		$emailaddress 	= sanitize_text_field(isset($_POST['emailaddress'])) ? sanitize_text_field($_POST['emailaddress']):'';
		$phone 			= sanitize_text_field(isset($_POST['phone'])) ? sanitize_text_field($_POST['phone']):'';
		$propertyid		= sanitize_text_field(isset($_POST['property_id'])) ? sanitize_text_field($_POST['property_id']):'';

		$name = $firstname.' '.$lastname;
		//check user exists
		$check_user = username_exists($emailaddress);

		//check email address if its unique
		$email_exists = email_exists($emailaddress);

		//check if already login
		$is_user_login = is_user_logged_in();

		if( sanitize_text_field( trim($firstname) ) == '' ){
			$msg = "<p class='text-danger'>Please input your name</p>";
		}
		if( sanitize_text_field( trim($lastname) ) == '' ){
			$msg = "<p class='text-danger'>Please input your last name</p>";
		}
		if( sanitize_text_field( trim($emailaddress) ) == '' ){
			$msg = "<p class='text-danger'>Please input your email</p>";
		}
		if( sanitize_text_field( !is_email($emailaddress) ) ){
			$msg .= "<p class='text-danger'>Email Address is invalid</p>";
		}

		if( $msg == '' ){
			$status = true;
			// create user
			if( !$is_user_login ){
				if( !$check_user && !$email_exists){
					// create user
					$password 	= wp_generate_password(12, false);
					/*
					$user_id 	= $this->register_user($emailaddress, $password, $emailaddress, $user_array);*/
					$username = $emailaddress;
					$user_array = array(
						'email'			=>	$emailaddress,
						'username'		=>	$username,
						'password'		=>	$password,
						'nickname'		=>	$firstname,
						'first_name'	=>	$firstname,
						'last_name'		=>	$lastname,
					);
					$user_id = md_create_user($user_array);
					update_user_meta($user_id,'phone_num',$phone);
					wp_new_user_notification($user_id, $password);
					$this->user_signon($emailaddress, $password);
					// create user

					//push to crm
					$array_data['yourname'] 	= $firstname;
					$array_data['yourlastname'] = $lastname;
					$array_data['email1'] 		= $emailaddress;
					$array_data['phone_home'] 	= $phone;
					$array_data['lead_source'] 	= $source;
					$array_data['source_url'] 	= $source_url;

					if( !isset($array_data['note']) ){
						$array_data['note'] = $source_note;
					}

					$save_lead = \CRM_Account::get_instance()->push_crm_data($array_data);
					//push to crm

					update_user_meta($user_id, 'lead-data', $save_lead);
					$msg = "<p class='text-success'>Successfully Registered. Thank You.</p>";
				}else{
					$status = false;
					$error = 'User already exists : wp user id: '.$email_exists.' or '.$checkuser;
					$msg = "<p class='text-danger'>There was an error please contact Masterdigm Support. <a href='mailto:support@masterdigm.com'>support@masterdigm.com</a></p>";
					update_option('error-signup-'.$email_exists, $error);
				}
			}
		}

		$ret_data = array(
			'save_lead' => $save_lead,
			'array_data' => $array_data,
			'post' => $_POST,
		);
		$json_array = array(
			'msg'=>$msg,
			'status'=>$status,
			'ret_data' => $ret_data,
			'callback_action'=>$current_action
		);
		echo json_encode($json_array);
		die();
	}

	public function login_action_callback(){
		check_ajax_referer( 'md-ajax-request', 'security' );
		$ret_data = array();
		$save_lead = array();
		$current_action = 0;
		if( isset($_POST['current_action']) ){
			$current_action = $_POST['current_action'];
		}
		$msg 		= '';
		$status 	= false;
		$propertyid = 0;

		$user_login = sanitize_text_field($_POST['emailaddress']);
		$password 	= sanitize_text_field($_POST['password']);
		$user 		= $this->user_signon($user_login, $password);

		if ( is_wp_error($user) ){
			$msg = $user->get_error_message().' Error in login';
		}else{
			$lead_data = get_user_meta($user->ID,'lead-data',true);
			if( !$lead_data || $lead_data && (!is_numeric($lead_data->leadid)) ){
				//push to crm
				$array_data['email1'] 		= $user->user_email;
				$save_lead = \CRM_Account::get_instance()->push_crm_data($array_data);
				update_user_meta($user->ID, 'lead-data', $save_lead);
				//push to crm
			}
			$msg = "<p class='text-success'>Successfully Loged In. Wait while we redirect you. </p>";
			$status = true;
		}
		$ret_data = array(
			'post' => $_POST,
		);
		echo json_encode(
			array(
				'msg'=>$msg,
				'status'=>$status,
				'ret_data' => $ret_data,
				'callback_action'=>$current_action
			)
		);
		die();
	}

	public function get_template_modal(){
		$template = COMPONENT_DIR . 'signupform/view/signup.php';
		if( has_filter('shortcode_signup_template_modal') ){
			$template = apply_filters('shortcode_signup_template_modal', $path);
		}
		return $template;
	}

	public function get_template_form(){
		$template = COMPONENT_DIR . 'signupform/view/form.php';
		if( has_filter('shortcode_signup_template_form') ){
			$template = apply_filters('shortcode_signup_template_form', $path);
		}
		return $template;
	}

	public function display(){
		if( !is_user_logged_in() ){
			// hook filter, incase we want to just use hook
			require $this->get_template_modal();
		}
	}
}

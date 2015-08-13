<?php
class MD_Facebook_App{
	protected static $instance = null;
	private $plugin_name;
	private $version;

	public function __construct(){
		add_action('fb_login_action', array($this,'fb_login_action_callback') );
		add_action('wp_ajax_nopriv_fb_login_action',array($this,'fb_login_action_callback') );
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
		//wp_enqueue_script( $this->plugin_name . '-facebook-js-sdk', plugin_dir_url( __FILE__ ) . 'js/md-facebook-app-script.js', array( 'jquery' ), $this->version, true );
	}

	private function lead_push_crm($lead_data = array()){
		$crm_company 	= \CRM_Account::get_instance()->get_account_data('company');
		$source 		= $crm_company;
		$source_note	= $crm_company . ', Facebook login';
		$source_url		= site_url();

		//push to crm
		$array_data = array();
		$array_data['yourname'] 	= $lead_data['first_name'];
		$array_data['yourlastname'] = $lead_data['last_name'];
		$array_data['email1'] 		= $lead_data['email'];
		$array_data['phone_home'] 	= $lead_data['phone'];
		$array_data['lead_source'] 	= $source;
		$array_data['source_url'] 	= $source_url;

		if( !isset($lead_data['note']) ){
			$array_data['note'] = $source_note;
		}
		$save_lead = \CRM_Account::get_instance()->push_crm_data($array_data);
		//push to crm
		update_user_meta($lead_data['user_id'], 'lead-data', $save_lead);

		return $save_lead;
	}

	private function fb_auth_user_meta($user_id, $facebook_auth = array()){
		update_user_meta($user_id, 'facebook-auth', $facebook_auth);
	}

	public function fb_login_action_callback(){
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ){
			check_ajax_referer( 'md-ajax-request', 'security' );
		}
		$save_lead 		= array();
		$msg 			= '';
		$status 		= false;
		$ret_data		= '';

		$firstname 			= sanitize_text_field(isset($_POST['fb_first_name'])) ? sanitize_text_field($_POST['fb_first_name']):'';
		$lastname 			= sanitize_text_field(isset($_POST['fb_last_name'])) ? sanitize_text_field($_POST['fb_last_name']):'';
		$emailaddress 		= sanitize_text_field(isset($_POST['fb_email'])) ? sanitize_text_field($_POST['fb_email']):'';
		$fb_uid 			= sanitize_text_field(isset($_POST['fb_uid'])) ? sanitize_text_field($_POST['fb_uid']):'';
		$fb_access_token	= sanitize_text_field(isset($_POST['fb_access_token'])) ? sanitize_text_field($_POST['fb_access_token']):'';
		$current_action 	= sanitize_text_field(isset($_POST['current_action'])) ? sanitize_text_field($_POST['current_action']):'';

		$facebook_auth = array(
			'fb_access_token' 	=> $fb_access_token,
			'fb_uid'			=> $fb_uid,
		);

		//check user exists
		$check_user = username_exists($emailaddress);
		$username	= $emailaddress;
		//check email address if its unique
		$email_exists = email_exists($emailaddress);
		//check if already login
		$is_user_login = is_user_logged_in();
		if( !$is_user_login ){
			if( !$check_user && !$email_exists ){
				$password 	= wp_generate_password(12, false);
				//signup
				$user_array = array(
					'email'			=>	$emailaddress,
					'username'		=>	$username,
					'password'		=>	$password,
					'nickname'		=>	$firstname,
					'first_name'	=>	$firstname,
					'last_name'		=>	$lastname,
				);
				$user_id = md_create_user($user_array);

				wp_new_user_notification($user_id, $password);
				$credentials = array(
					'user_login' 	=> $emailaddress,
					'user_password' => $password,
				);
				md_login_user($credentials);

				//facebook auth
				$this->fb_auth_user_meta($user_id['user_id'],$facebook_auth);
				//facebook auth
				$current_user_id = $user_id['user_id'];
				$msg 		= "<p class='text-success'>Successfully Loged In. Wait while we redirect you. </p>";
				$status 	= true;
				$array_data	= $user_id;
			}else{
				$user 			= get_user_by('email',$emailaddress);
				$credentials 	= array(
					'user_id' => $user->ID
				);
				md_login_user($credentials, true);
				//facebook auth
				$this->fb_auth_user_meta($user->ID,$facebook_auth);
				$current_user_id = $user->ID;
				//facebook auth
				$msg 			= "<p class='text-success'>Successfully Loged In. Wait while we redirect you. </p>";
				$status 		= true;
				$array_data 	= $user;
			}
		}

		$lead_data = get_user_meta($current_user_id,'lead-data',true);
		if( !$lead_data || $lead_data && (!is_numeric($lead_data->leadid)) ){
			//push to crm
			$lead_data = array(
				'email'			=>	$emailaddress,
				'phone'			=>	'',
				'first_name'	=>	$firstname,
				'last_name'		=>	$lastname,
				'user_id'		=>	$current_user_id,
			);
			$save_lead = $this->lead_push_crm($lead_data);
			//push to crm
		}

		$ret_data = array(
			'save_lead' 	=> $save_lead,
			'array_data' 	=> $array_data,
			'post' 			=> $_POST,
		);
		$json_array = array(
			'msg'				=>	$msg,
			'status'			=>	$status,
			'ret_data' 			=> 	$ret_data,
			'callback_action'	=>	$current_action
		);

		echo json_encode($json_array);
		die();
	}

	public function fb_login_action_nopriv_callback(){

	}

	public function js_init(){
		?>
		<script>
			var is_my_account_page = '<?php echo is_page('my-account') ? is_page('my-account'):0; ?>';

			function is_popup_reg_form(){
				if( is_my_account_page == 1 ){
					return true;
				}
				if( typeof popup_reg_form !== 'undefined' && popup_reg_form == 1 ){
					return true;
				}
				return false;
			}

			// This is called with the results from from FB.getLoginStatus().
			function statusChangeCallback(response) {
				// The response object is returned with a status field that lets the
				// app know the current login status of the person.
				// Full docs on the response object can be found in the documentation
				// for FB.getLoginStatus().
				if (response.status === 'connected') {
					// Logged into your app and Facebook.
					//console.log('connected');
					connected_api(response);
				} else if (response.status === 'not_authorized') {
				  // The person is logged into Facebook, but not your app.
				  /*document.getElementById('status').innerHTML = 'Please log ' +
					'into this app.';*/
					//console.log('Please log into this app');
				} else {
				  // The person is not logged into Facebook, so we're not sure if
				  // they are logged into this app or not.
				  /*document.getElementById('status').innerHTML = 'Please log ' +
					'into Facebook.';*/
					//console.log('Please log into Facebook');
				}
			}

			function reload(){
				setTimeout(function(){
					jQuery('.register-modal').modal('hide');
					location.reload(true);
				},1000);
			}

			var ajax_update_user_meta = function(response){
				var ajax_data = [];

				var uid = response.authResponse.userID;
				var accessToken = response.authResponse.accessToken;

				ajax_data.push({name:'fb_uid', value:uid});
				ajax_data.push({name:'fb_accessToken', value:accessToken});

				return ajax_data;
			}

			var ajax_update_user = function(response, fb_auth, current_action){
				var ajax_data = [];
				var current_data_post = jQuery('#registerModal .data_post').val();
				var finish = 0;

				ajax_data.push({name:'data_post', value:current_data_post});
				ajax_data.push({name:'fb_first_name', value:response.first_name});
				ajax_data.push({name:'fb_last_name', value:response.last_name});
				ajax_data.push({name:'fb_name', value:response.name});
				ajax_data.push({name:'fb_email', value:response.email});
				ajax_data.push({name:'fb_uid', value:response.id});
				ajax_data.push({name:'fb_access_token', value:fb_auth[1].value});
				ajax_data.push({name:'current_action', value:current_action});
				ajax_data.push({name:'action', value: 'fb_login_action'});
				ajax_data.push({name:'security', value: MDAjax.security});

				jQuery.ajax({
					type: "POST",
					url: MDAjax.ajaxurl,
					data: ajax_data,
					dataType: "json"
				}).done(function( data ) {
					jQuery('#status').html(data.msg);
					if( data.status ){
						if( data.callback_action != 0 ){
							var data_callback = {
								action: data.callback_action,
								security: MDAjax.security,
								post_data: data.ret_data
							};
							jQuery.post(
								MDAjax.ajaxurl,
								data_callback,
								function(response){
									if( response.status ){
										reload();
									}
								}
							);
						}else{
							finish = 1;
						}
						finish = 1;
					}
					if( finish == 1 ){
						reload();
					}
				});
			}

			// This function is called when someone finishes with the Login
			// Button.  See the onlogin handler attached to it in the sample
			// code below.
			function checkLoginState() {
				FB.getLoginStatus(function(response) {
				  statusChangeCallback(response);
				});
			}
			window.fbAsyncInit = function() {
				FB.init({
					appId      : '<?php echo \Social_API::get_instance()->getSocialApiByKey('facebook','id');?>',
					cookie     : true,  // enable cookies to allow the server to access
										// the session
					xfbml      : true,  // parse social plugins on this page
					version    : '<?php echo \Social_API::get_instance()->getSocialApiByKey('facebook','version');?>'
				});

				// Now that we've initialized the JavaScript SDK, we call
				// FB.getLoginStatus().  This function gets the state of the
				// person visiting this page and can return one of three states to
				// the callback you provide.  They can be:
				//
				// 1. Logged into your app ('connected')
				// 2. Logged into Facebook, but not your app ('not_authorized')
				// 3. Not logged into Facebook and can't tell if they are logged into
				//    your app or not.
				//
				// These three cases are handled in the callback function.

				FB.getLoginStatus(function(response) {
					statusChangeCallback(response);
				});

			};

			// Load the SDK asynchronously
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/en_US/sdk.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));

			// Here we run a very simple test of the Graph API after login is
			// successful.  See statusChangeCallback() for when this call is made.
			function connected_api(response) {
				jQuery('#status').html('');
				var current_action 	= jQuery('#registerModal .current_action').val();
				var fb_auth 		= ajax_update_user_meta(response);
				FB.api('/me', {fields: 'id,name,first_name,last_name,email'}, function(response) {
					if( current_action != '' ){
						jQuery('#status').html('<p>login to facebook, please wait...</p>');
						ajax_update_user(response, fb_auth, current_action);
					}else if( current_action == '' && is_popup_reg_form() ){
						jQuery('#status').html('<p>login to facebook, please wait...</p>');
						ajax_update_user(response, fb_auth, current_action);
					}
				});
			}
		</script>
		<?php
	}

	public function login_button(){
		if( has_facebook_api() ){
			$this->js_init();
			$template = COMPONENT_DIR . 'facebookapp/view/login-button.php';
			require $template;
		}
	}
}

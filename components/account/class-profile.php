<?php
class Account_Profile extends Account_Dashboard{
	protected static $instance = null;

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

	public function __construct(){
		$this->plugin_name 	= \Masterdigm_API::get_instance()->get_plugin_name();
		$this->version 	 	= \Masterdigm_API::get_instance()->get_version();
		add_action('wp_enqueue_scripts', array($this,'enqueue_scripts'));
		add_action('wp_ajax_update_profile', array($this,'update_profile_callback') );
		add_action('wp_ajax_nopriv_update_profile',array($this,'update_profile_nopriv_callback') );
		add_action('wp_ajax_update_password', array($this,'update_password_callback') );
		add_action('wp_ajax_nopriv_update_password',array($this,'update_password_nopriv_callback') );
		add_filter( 'dashboard_content_profile', array($this,'controller'),10, 1 );
	}

	public function get_dashboard_page(){
		if( parent::get_instance()->get_dashboard_page() ){
			return parent::get_instance()->get_dashboard_page();
		}
	}

	public function url(){
		if( $this->get_dashboard_page() ){
			return get_permalink($this->get_dashboard_page()->ID).'profile';
		}
	}

	public function controller(){
		global $wp_query;
		$arr_action = parent::get_instance()->md_get_query_vars();

		$action_args = $arr_action;

		$action = '';
		if( isset($arr_action->action) ){
			$action = $arr_action->action;
		}
		$task = '';
		if( isset($arr_action->task) ){
			$task = $arr_action->task;
		}

		switch($task){
			case 'update_profile':
				$this->update_profile_callback();
				$this->edit();
			break;
			case 'update_password':
				$this->update_password_callback();
				$this->edit();
			break;
			case 'edit':
			default:
				$this->edit();
			break;
		}
	}

	public function edit(){
		$user_account = wp_get_current_user();
		$user_meta 	  = get_user_meta($user_account->ID);
		$url 		  = $this->url();
		$phone_number = '';
		if( isset($user_meta['phone_num'][0]) ){
			$phone_number = $user_meta['phone_num'][0];
		}

		require_once $this->template();
	}

	public function enqueue_scripts(){
		$dashboard_page = \Account_Dashboard::get_instance()->get_dashboard_page();
		if( $dashboard_page && is_page($dashboard_page->ID) ){
			wp_enqueue_script( $this->plugin_name . '-account-actions', plugin_dir_url( __FILE__ ) . 'js/account.js', array( 'jquery' ), $this->version, true );
		}
	}

	public function get_current_user(){
		return wp_get_current_user();
	}

	public function template($template = null){
		if( is_null($template) ){
			$template = PLUGIN_VIEW . 'account/partials/profileform.php';
		}
		// hook filter, incase we want to just use hook
		if( has_filter('shortcode_account_profile') ){
			$template = apply_filters('shortcode_account_profile', $path);
		}
		return $template;
	}

	public function get_password_form($template = null){
		if( is_null($template) ){
			$template = PLUGIN_VIEW . 'account/partials/passwordform.php';
		}
		// hook filter, incase we want to just use hook
		if( has_filter('shortcode_account_password') ){
			$template = apply_filters('shortcode_account_password', $path);
		}
		return $template;
	}

	public function update_profile_callback(){
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		{
			check_ajax_referer( 'md-ajax-request', 'security' );
		}

		global $current_user;
		get_currentuserinfo();

		$msg 	= '';
		$status = false;

		$user_id 		= $current_user->ID;
		$first_name 	= sanitize_text_field($_POST['firstname']);
		$last_name 		= sanitize_text_field($_POST['lastname']);
		$email 			= sanitize_email($_POST['emailaddress']);
		$phone_number 	= sanitize_text_field($_POST['phone']);

		if( !is_email( $email ) ){
			$msg = "<p class='text-danger'>Please put valid Email</p>";
		}

		$wp_user_update = wp_update_user(
			array(
				'ID' 			=> $user_id,
				'first_name' 	=> $first_name,
				'last_name' 	=> $last_name
			)
		);

		if ( is_wp_error( $wp_user_update ) ) {
			// There was an error, probably that user doesn't exist.
			$msg = 'Error';
		} else {
			if( $msg == '' ){
				// Success!
				$msg 	= 'Success';
				$status = true;
				update_user_meta($user_id,'phone_num',$phone_number);
				update_user_meta($user_id,'first_name',$first_name);
				update_user_meta($user_id,'last_name',$last_name);
			}else{
				$status = false;
			}
		}

		$ret = array('msg'=>$msg,'status'=>$status);

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		{
			echo json_encode($ret);
			die();
		}else{
			return $ret;
		}
	}

	public function update_profile_nopriv_callback(){
		check_ajax_referer( 'md-ajax-request', 'security' );
		$msg 	= 'Not logged in user';
		$status = false;
		echo json_encode(array('msg'=>$msg,'status'=>$status));
		die();
	}

	public function update_password_nopriv_callback(){
		check_ajax_referer( 'md-ajax-request', 'security' );
		$msg 	= 'Not logged in user';
		$status = false;
		echo json_encode(array('msg'=>$msg,'status'=>$status));
		die();
	}

	public function update_password_callback(){
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		{
			check_ajax_referer( 'md-ajax-request', 'security' );
		}

		global $current_user;
		get_currentuserinfo();

		$msg 	= '';
		$status = false;

		$user_id 		= $current_user->ID;
		$new_password 	= '';
		if( isset($_POST['password']) ){
			$new_password 	= sanitize_text_field($_POST['password']);
		}
		$confirm_password = '';
		if( isset($_POST['confirm-password']) ){
			$confirm_password 	= sanitize_text_field($_POST['confirm-password']);
		}

		if(
			$new_password != $confirm_password &&
			$new_password != '' &&
			$confirm_password != ''
		){
			$msg 	= 'Please Confirm password';
			$status = false;
		}else{
			wp_set_password( $new_password, $user_id );
			$msg 	= 'Successfully Change Password';
			$status = true;
		}

		$ret = array('msg'=>$msg,'status'=>$status);

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		{
			echo json_encode($ret);
			die();
		}else{
			return $ret;
		}
	}
}

<?php
class Email_To{
	protected static $instance = null;
	private $plugin_name;
	private $version;

	public function __construct(){
		add_action('wp_footer', array($this, 'display'));

		$this->plugin_name 	= \Masterdigm_API::get_instance()->get_plugin_name();
		$this->version 	 	= \Masterdigm_API::get_instance()->get_version();

		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action( 'wp_ajax_sendtofriend_action', array($this,'sendtofriend_action_callback') );
		add_action( 'wp_ajax_nopriv_sendtofriend_action',array($this,'sendtofriend_action_callback') );
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
		wp_enqueue_script( $this->plugin_name . '-emailto-actions', plugin_dir_url( __FILE__ ) . 'js/emailto.js', array( 'jquery' ), $this->version, true );
	}

	public function sendtofriend_action_callback(){
		check_ajax_referer( 'md-ajax-request', 'security' );

		global $current_user;
		get_currentuserinfo();

		$source = get_bloginfo('url').', '. get_bloginfo('name') . ', Send to friend Form';
		$msg 	= '';
		$status = false;
		$yourname = '';
		if( isset($_POST['yourname']) ){
			$yourname = sanitize_text_field($_POST['yourname']);
		}
		$friendsemail = '';
		if( isset($_POST['friendsemail']) ){
			$friendsemail = sanitize_text_field($_POST['friendsemail']);
		}
		$youremail = '';
		if( isset($_POST['youremail']) ){
			$youremail = sanitize_text_field($_POST['youremail']);
		}
		$message = '';
		if( isset($_POST['message']) ){
			$message = sanitize_text_field($_POST['message']);
		}
		$friendsemail 	= $friendsemail;
		$yourname 		= $yourname;
		$youremail 		= $youremail;
		$message 		= $message;

		//check user exists
		$check_user = username_exists($youremail);
		//check email address if its unique
		$email_exists = email_exists($youremail);

		//check if already login
		$is_user_login = is_user_logged_in();
		if( !$is_user_login ){
			if( sanitize_text_field( trim($yourname) ) == ''){
				$msg = "<p class='text-danger'>Please input your name</p>";
			}
		}

		if( sanitize_text_field( trim($friendsemail) ) == '' ){
			$msg .= "<p class='text-danger'>Please input friends email</p>";
		}

		if( !is_email($friendsemail) ){
			$msg .= "<p class='friendsemail text-danger'>Email Address is invalid</p>";
		}
		if( !$is_user_login ){
			if( sanitize_text_field( trim($youremail) ) == '' ){
				$msg = "<p class='text-danger'>Please input your email</p>";
			}
		}

		if( is_user_logged_in() ){
			$yourname  = $current_user->user_firstname.' '.$current_user->user_lastname;
			$youremail = $current_user->user_email;
		}

		if( !is_email($youremail) ){
			$msg .= "<p class='youremail text-danger'>Email Address is invalid</p>";
		}

		//$status
		if( $msg == '' ){
			$status = true;
			if( !$is_user_login ){
				if( !$check_user && !$email_exists){
					// create user
					$password 	= wp_generate_password(12, false);
					$user_id 	= \Signup_Form::get_instance()->register_user($youremail, $password, $youremail, array('nickname'=>$yourname));
					wp_new_user_notification($user_id, $password);
					\Signup_Form::get_instance()->user_signon($youremail, $password);
				}
			}

			$array_data['lead_source'] 	= $source;
			$array_data['email1'] 		= $friendsemail;
			$array_data['note'] 		= $source.' '.$message;
			\crm\Properties::get_instance()->push_crm_data($array_data);

			// send email here
			$msg = "<p class='text-success'>Successfully Send Email to Friend. Thank You.</p>";

			$headers  = 'From: '.$yourname.' <'.MD_SYSTEM_MAIL.'>' . "\r\n";
			$headers  .= 'Cc: '.$yourname.' <'.$youremail.'>' . "\r\n" ;
			$to 	  = $friendsemail;
			$subject  = 'Send to a friend from : '.$yourname;
			$message  = $_POST['message']."r\n".$_POST['url'];
			wp_mail($to, $subject, $message, $headers );
		}
		echo json_encode(array('msg'=>$msg,'status'=>$status));
		die(); // this is required to return a proper result
	}


	public function display(){
		require 'view/emailto.php';
	}
}

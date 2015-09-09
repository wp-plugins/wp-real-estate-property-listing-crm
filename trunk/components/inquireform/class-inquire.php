<?php
/**
 * This is use to update public design changes
 *
 *
 *
 * @package MD_Single_Property
 * @author  masterdigm / Allan
 */
class Inquire {
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	private $plugin_name;
	private $version;

	public function __construct(){
		$this->plugin_name 	= \Masterdigm_API::get_instance()->get_plugin_name();
		$this->version 	 	= \Masterdigm_API::get_instance()->get_version();

		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action('wp_ajax_inquireform_action', array($this,'inquireform_action_callback') );
		add_action('wp_ajax_nopriv_inquireform_action',array($this,'inquireform_action_callback') );
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
		wp_enqueue_script( $this->plugin_name . '-inquire-actions', plugin_dir_url( __FILE__ ) . 'js/inquire-min.js', array( 'jquery' ), $this->version, true );
	}

	/**
	 * @param	array	$att
	 * */
	public function display($att){
		$show = 0;
		$msg = '';

		$yourname 		= '';
		$yourlastname 	= '';
		$email1 		= '';
		$phone_mobile 	= '';

		if( is_user_logged_in() ){
			$current_user = wp_get_current_user();
			$yourname = $current_user->user_firstname;
			$yourlastname = $current_user->user_lastname;
			$email1 = $current_user->user_email;
			$phone_mobile = get_user_meta($current_user->ID,'phone_num',true);
		}

		if( isset($att['show']) && $att['show'] == 1 ){
			$show = 1;
		}

		if( isset($att['msg']) ){
			$msg = $att['msg'];
		}

		if( $show == 1 ){
			require 'view/inquire.php';
		}
	}

	/**
	 * Ajax call back in function ajax_request
	 * */
	public function inquireform_action_callback(){
		check_ajax_referer( 'md-ajax-request', 'security' );

		$source = get_bloginfo('url').', '. get_bloginfo('name') . ', Inquire Form';
		$msg = '';
		$status = false;
		$array_data = array();
		$yourname 		= sanitize_text_field($_POST['yourname']);
		$yourlastname 	= sanitize_text_field($_POST['yourlastname']);
		$email 			= sanitize_text_field($_POST['email1']);
		$phone 			= sanitize_text_field($_POST['phone_mobile']);
		$inquire_msg	= sanitize_text_field($_POST['message']);
		$_POST['note']	= $source.' '.$inquire_msg;
		$fullname = $yourname.' '.$yourlastname;
		$subject  = 'Inquiry from '.$fullname;

		$message		 = "Name : " . $fullname . "\n\n";
		$message		.= "Email # : " . $email . "\n\n";
		$message		.= "Phone # : " . $phone . "\n\n";
		$message		.= sanitize_text_field($_POST['message']);

		if( sanitize_text_field( trim($yourname) ) == '' ){
			$msg = "<p class='text-danger'>Please input your name</p>";
		}

		if( sanitize_text_field( trim($yourlastname) ) == '' ){
			$msg .= "<p class='text-danger'>Please input your  last name</p>";
		}

		if( sanitize_text_field( trim($email) ) == '' ){
			$msg .= "<p class='text-danger'>Please input your Email Address</p>";
		}

		if( sanitize_text_field( !is_email($email) ) ){
			$msg .= "<p class='text-danger'>Email Address is invalid</p>";
		}

		if( $msg == '' ){
			$status = true;
			$msg = "<p class='text-success'>Inquiry successfully sent. Our staff will review it as soon as possible. Thank You.</p>";

			$headers = 'From: '.$fullname.' <'.MD_SYSTEM_MAIL.'>' . "\r\n";
			$to 	 = get_bloginfo('admin_email');
			wp_mail($to, $subject, $message, $headers );

			$_POST['lead_source'] = $source;
			\CRM_Account::get_instance()->push_crm_data($_POST);
		}

		echo json_encode(array('msg'=>$msg,'status'=>$status));
		die(); // this is required to return a proper result
	}

}


<?php
class Show_Popup{
	protected static $instance = null;

	public function __construct(){
		add_action('wp_footer', array($this, 'display'));
		add_action('wp_footer', array($this, 'showPopup'));
		$this->showPopup();
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

	public function display_popup(){
		global $wp_query;
		$cookie = new \helpers\Cookies;
		if(
			$wp_query &&
			!$cookie->wp_cookie_is_user_logged() &&
			$wp_query->post->post_name == 'property'
		){
			if(
				\Settings_API::get_instance()->showpopup_settings('show') == 1 && $cookie->get('guest_page_view') >= \Settings_API::get_instance()->showpopup_settings('clicks')
			){
				return true;
			}
		}
		return false;
	}

	public function display(){
		if( $this->display_popup() ){
			require 'view/signup.php';
		}
	}
	public function deleteShowPopup(){
		$cookie = new \helpers\Cookies;
		$cookie->delete('guest_page_view');
	}

	public function showPopup(){
		if($this->display_popup()){
			?>
			<script>
				jQuery(document).ready(function(){
					jQuery('.register-only-modal').on('shown.bs.modal', function () {
					   jQuery('.modal-backdrop').addClass('blur');
					});
					jQuery('.register-only-modal').modal({
						backdrop: 'static',
						keyboard: false
					});
				});
			</script>
			<?php
		}
	}

}
?>

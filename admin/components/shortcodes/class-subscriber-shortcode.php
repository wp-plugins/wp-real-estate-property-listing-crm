<?php
class Subscriber_Shortcode{
	protected static $instance = null;

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

	public function __construct(){
		add_action('admin_footer', array($this, 'md_get_shortcodes'));
		add_shortcode('md_account',array($this,'init_shortcode'));
	}

	private function dashboard_template($template = null){
		return \Account_Registered::get_instance()->template($template);
	}

	private function signup_template(){
		return \Signup_Form::get_instance()->get_template_form();
	}

	public function init_shortcode($atts){
		$user = wp_get_current_user();
		if( is_user_logged_in() ){
			$content = 'default';
			$action_args = array();
			$action = '';
			if(!get_query_var('action')){
				$action_args = array(
					'action'=>'profile',
					'task'=>'edit',
				);
				$action = 'profile';
				\Account_Dashboard::get_instance()->md_set_query_var($action_args);
			}else{
				$ret = \Account_Dashboard::get_instance()->md_get_query_vars();
				$action = $ret->action;
				$task = $ret->task;
			}
			$template = \Account_Dashboard::get_instance()->content(true);
		}else{
			$template = $this->signup_template();
		}

		ob_start();
		require $template;
		$output = ob_get_clean();
		return $output;
	}

	public function get_shortcode(){
		return '[md_account]';
	}

	public function md_get_shortcodes(){
		?>
			<script type="text/javascript">
				function md_account(editor){
					var submenu_array =
						{
							text:'Subscriber Dashboard',
							onclick: function() {
								editor.insertContent( '<?php echo $this->get_shortcode();?>');
							}
						};
					return submenu_array;
				}
			</script>
		<?php
	}

}

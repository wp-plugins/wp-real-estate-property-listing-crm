<?php
class mls_lastupdate_property {
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
		add_shortcode('mls_lastupdate_property',array($this,'init_shortcode'));
	}

	public function init_shortcode(){
		$last_update = '';
		if( get_single_data() ){
			$get_data = get_single_data();
			if( $get_data && isset($get_data['last_mls_update']) ){
				$new_date = date("F d, Y", strtotime($get_data['last_mls_update']));
				$last_update = $new_date;
			}
		}
		return $last_update;
	}

	/**
	 * Add shortcode JS to the page
	 *
	 * @return HTML
	 */
	public function md_get_shortcodes()
	{
		?>
			<script type="text/javascript">
				function mls_lastupdate_property(editor){
					var submenu_array =
						{
							text:'Last Update Property',
							onclick: function() {
								editor.insertContent( '[mls_lastupdate_property]');
							}
						};
					return submenu_array;
				}
			</script>
		<?php
	}
}


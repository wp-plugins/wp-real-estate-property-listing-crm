<?php
if ( !class_exists( 'md_sc_mls_list_properties_by' ) )
{
	class md_sc_mls_list_properties_by {
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
					function mls_list_properties_by(editor){
						var submenu_array =
						{
							text: 'List Property By', onclick: function() {editor.insertContent('[md_mls_list_properties_by]');}
						};
						return submenu_array;
					}
				</script>
			<?php
		}
	}
}

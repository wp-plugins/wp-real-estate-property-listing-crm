<?php
if ( !class_exists( 'md_sc_single_box_properties' ) )
{
	class md_sc_single_box_properties {
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
					function mls_single_property(editor){
						var submenu_array =
							{
								text:'Display Single Property',
								onclick: function() {
									editor.windowManager.open( {
										width:800,
										height:100,
										title: 'Property id',
										file: ajaxurl + '?action=xmy_plugin_function_callback',
										width: 700,
										height: 600,
										onsubmit: function( e ) {
											editor.insertContent( '[md_single_box_properties property_id="' + e.data.textboxPropertyId + '"]');
										}
									});
								}
							};
						return submenu_array;
					}
				</script>
			<?php
		}
	}
}

<?php
if ( !class_exists( 'md_sc_crm_single_box_properties' ) )
{
	class md_sc_crm_single_box_properties {
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
			add_shortcode('md_crm_single_box_properties',array($this,'init_shortcode'));

		}

		public function get_default_template($template = null){
			if( is_null($template) ){
				$template = GLOBAL_TEMPLATE . 'single/single-box.php';
			}
			// hook filter, incase we want to just use hook
			if( has_filter('shortcode_single_box_property_crm') ){
				$template = apply_filters('shortcode_single_box_property_crm', $path);
			}
			return $template;
		}

		public function init_shortcode($atts){
			$att_property_id 	= array();
			$property_data 		= array();
			$template 			= $this->get_default_template();

			if( isset($atts['template']) ){
				$att_template = $atts['template'];
			}

			$atts = shortcode_atts(
				array(
					'template' 	=> $template,
					'property_id' 	=> $atts['property_id'],
				),
				$atts
			);

			$property_id = explode(',' , $atts['property_id']);
			$broker_id 	 = \CRM_Account::get_instance()->get_broker_id();
			if( count($property_id) > 0 ){
				foreach($property_id as $key=>$val){
					if( trim($val) != '' ){
						$property_data[] = \CRM_Property::get_instance()->get_property($val, $broker_id);
					}
				}
			}

			\MD\Property::get_instance()->set_properties($property_data,'crm');

			$total_properties = count($property_data);
			if( $total_properties > 0 ){
				$col = ceil(12 / $total_properties );
			}else{
				$col = MD_DEFAULT_GRID_COL;
			}
			ob_start();
			require $template;
			$output = ob_get_clean();
			return $output;
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
					function crm_single_property(editor){
						var submenu_array =
							{
								text:'Display Single Property',
								onclick: function() {
									editor.windowManager.open( {
										width:800,
										height:100,
										title: 'Property id',
										body: [
											{
												type: 'textbox',
												name: 'textboxPropertyId',
												label: 'Enter property id, for multiple id seperate it by comma (1,2,3)',
												value: '0'
											},
										],
										onsubmit: function( e ) {
											editor.insertContent( '[md_crm_single_box_properties property_id="' + e.data.textboxPropertyId + '"]');
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

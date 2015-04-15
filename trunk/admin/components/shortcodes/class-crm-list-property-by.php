<?php
if ( !class_exists( 'md_sc_crm_list_properties_by' ) )
{
	class md_sc_crm_list_properties_by {
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
			//add_action('admin_footer', array($this, 'md_get_shortcodes'));
		}

		public function get_list_default_template($atts){
			if( !isset($atts['template_list']) ){
				$template = CRM_DEFAULT_LIST;
			}
			// hook filter, incase we want to just use hook
			if( has_filter('shortcode_list_property_crm') ){
				$template = apply_filters('shortcode_list_property_crm', $path);
			}
			return $template;
		}

		public function get_default_property_by_template($atts){
			if( !isset($atts['template_by']) ){
				$template = GLOBAL_TEMPLATE . 'list/default/list-default-by-property.php';
			}
			// hook filter, incase we want to just use hook
			if( has_filter('shortcode_list_property_by_crm') ){
				$template = apply_filters('shortcode_list_property_by_crm', $path);
			}
			return $template;
		}

		public function init_shortcode($atts){
			$list_template 	= $this->get_list_default_template($atts);
			$template 		= $this->get_default_property_by_template($atts);

			if( isset($atts['col']) && is_numeric($atts['col']) ){
				$col = ceil(12 / $atts['col'] );
			}else{
				$col = MD_DEFAULT_GRID_COL;
			}

			if( isset($atts['parent_location_id']) ){
				$parent_location_id = $atts['parent_location_id'];
			}

			if( isset($atts['source']) ){
				$source = $atts['source'];
			}

			if( isset($atts['search_by']) ){
				$search_by = $atts['search_by'];
			}

			if( $atts['infinite'] == 'true' ){
				$atts['infinite'] = true;
			}elseif($atts['infinite'] == 'false'){
				$atts['infinite'] = false;
			}


			if( $atts['show_child'] == 'true' ){
				$atts['show_child'] = true;
			}else{
				$atts['show_child'] = false;
			}

			$atts = shortcode_atts(	array(
				'col' 					=> $col,
				'template'				=> $template,
				'infinite'				=> $atts['infinite'],
				'parent_location_id' 	=> $parent_location_id,
				'source' 				=> 'crm',
				'show_child' 			=> $atts['show_child'],
				'search_by' 			=> $search_by,
			), $atts, 'crm_list_property_by' );

			$_properties = \crm\MD_Searchby_Property::get_instance()->displayPropertyBy(
				$atts['search_by'],
				$atts['parent_location_id'],
				$atts['show_child']
			);

			$properties 	= $_properties['property_result'];

			\MD\Property::get_instance()->set_properties($properties,'crm');

			$child_location = $_properties['child_list'];
			$child_details	= array(
				'child_label'	=>	$_properties['child_label'],
				'child_key'		=>	$_properties['child_key'],
				'permalink'		=>	$_properties['permalink'],
				'data'			=>	isset($_properties['child_data']) ? $_properties['child_data']:array(),
			);
			$show_sort = true;

			require $template;
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
					function _crm_list_properties_by(editor){
						var submenu_array =
						{
							text: 'List Property By',
							onclick: function() {
								editor.insertContent('[md_crm_list_properties_by]');
							}
						};
						return submenu_array;
					}
				</script>
			<?php
		}
	}
}

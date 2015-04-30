<?php
if ( !class_exists( 'md_sc_list_properties_by' ) )
{
	class md_sc_list_properties_by {
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
			add_shortcode('md_list_properties_by_breadcrumb', array($this,'init_shortcode'));
		}

		public function get_default_template(){
			// show list location base on parent like
			// state, city
		}

		public function init_shortcode($atts){
			//var_dump($atts);
			global $wp_query;

			$source = DEFAULT_FEED;

			if(
				is_page('country') ||
				is_page('county') ||
				is_page('state') ||
				is_page('city') ||
				is_page('community') ||
				is_page('zip')
			){
				$query_var   	= get_query_var('url');
				$parse_property = explode( '-', $query_var);
				if( is_int((int)$parse_property[0]) && (int)$parse_property[0] != 0 ){
					$atts['source'] 			= 'crm';
					$atts['parent_location_id'] = (int)$parse_property[0];
					$atts['search_by'] 			= $wp_query->query_vars['pagename'];
					$source						= $atts['source'];
				}else{
					$atts['source'] = 'mls';
					$source			= $atts['source'];
				}
			}else{
				$location = \Breadcrumb_Url::get_instance()->getPageLocationId( get_the_ID() );
				$atts['parent_location_id'] = $location->location_id;
				$atts['filter_name'] = $location->filter_name;
				$atts['filter_location_search'] = $location->filter_location_search;
				$atts['search_by'] = $location->filter_location_search;
			}

			ob_start();
			if($source == 'crm'){
				\md_sc_crm_list_properties_by::get_instance()->init_shortcode($atts);
			}elseif($source == 'mls'){
			}
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
					function md_list_properties_by(editor){
						var submenu_array =
						{
							text: 'List Property By Breadcrumb',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Display properties base on breadcrumb url landing page or url filter by breadcrumb.',
									width:980,
									height:350,
									body: [
										{
											type: 'textbox',
											name: 'textboxGridCol',
											label: 'Set property per columns ( should be divided by 12 )',
											value:'1'
										},
										{
											type: 'checkbox',
											name: 'checkboxShowChild',
											label: 'Show child location? If the location is state it will show list of city, if its city it will show list of communities',
											checked:false
										},
										{
											type: 'checkbox',
											name: 'checkboxShowInfiniteScroll',
											label: 'Show Infinite Scroll? this will show the scrolling ajax instead of tix "how many display"',
											checked:false
										},
									],
									onsubmit: function( e ) {
										var col_grid 	= ' col="' + e.data.textboxGridCol + '" ';
										var show_child 	= ' show_child="' + e.data.checkboxShowChild + '" ';
										var infinite 	= ' infinite="' + e.data.checkboxShowInfiniteScroll + '" ';
										editor.insertContent(
											'[md_list_properties_by_breadcrumb ' + col_grid + show_child + infinite + ']'
										);
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

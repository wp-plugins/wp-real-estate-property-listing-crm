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
			global $wp_query;

			$accepted_source = array('mls','crm');

			$default_source = DEFAULT_FEED;
			$atts['source'] 			= '';
			$atts['parent_location_id'] = 0;
			$atts['search_by'] 			= '';

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

				//add hook
				if( isset($parse_property[0]) && in_array($parse_property[0],$accepted_source) && count($parse_property) >= 3 ){
					$data_url = apply_filters('md_list_property_by_' . $parse_property[0], $parse_property, $wp_query, $atts);
				}elseif(isset($parse_property[0]) && in_array($parse_property[0],$accepted_source) && count($parse_property) == 2 ){
					$data_url = apply_filters('md_list_property_by_' . $parse_property[0], $parse_property, $wp_query, $atts);
					$data_url = array(
						'source' 				=> $data_url['source'],
						'parent_location_id' 	=> (int)$data_url['parent_location_id'],
						'search_by' 			=> 'postal_code',
					);
				}else{
					$data_url = array(
						'source' => '',
						'parent_location_id' => '',
						'search_by' => '',
					);
					$atts = array(
						'source' => '',
						'parent_location_id' => '',
						'search_by' => '',
					);
				}
				$atts['source'] 			= $data_url['source'];
				$atts['parent_location_id'] = (int)$data_url['parent_location_id'];
				$atts['search_by'] 			= $data_url['search_by'];
				$default_source				= $data_url['source'];
			}else{
				$location 						= \Breadcrumb_Url::get_instance()->getPageLocationId( get_the_ID() );
				$atts['parent_location_id'] 	= $location->location_id;
				$atts['filter_name'] 			= $location->filter_name;
				$atts['filter_location_search'] = $location->filter_location_search;
				$atts['search_by'] 				= $location->filter_location_search;
			}

			$atts['parse_property'] = $parse_property;

			ob_start();
			$output = apply_filters('breadcrumb_list_property_' . $atts['source'], $atts);
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

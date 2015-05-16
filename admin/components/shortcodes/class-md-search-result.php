<?php
if ( !class_exists( 'md_sc_search_result_properties' ) )
{
	class md_sc_search_result_properties {
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
			add_shortcode('md_search_property_result', array($this,'init_shortcode'));
			// property pagination infinite scroll
		}

		public function get_template(){
			return \MD_Template::get_instance()->get_theme_page_template(GLOBAL_TEMPLATE . 'searchresult', GLOBAL_TEMPLATE, 'Search Result');
		}

		public function init_shortcode($atts){
			$template = '';

			$properties = apply_filters('search_property_result_' . DEFAULT_FEED, $atts);
			$source 	= DEFAULT_FEED;

			\MD\Property::get_instance()->set_properties($properties, $source);

			if( isset($atts['col']) && is_numeric($atts['col']) ){
				$col = ceil(12 / $atts['col'] );
			}else{
				$col = MD_DEFAULT_GRID_COL;
			}

			if( isset($atts['template']) ){
				$att_template = $atts['template'];
			}

			if( $atts['infinite'] == 'true' ){
				$atts['infinite'] = true;
				$infinite = true;
			}else{
				$infinite = false;
				$atts['infinite'] = false;
			}

			$atts = shortcode_atts(	array(
				'col' 		=> $col,
				'template'	=> $template,
				'infinite'	=> $infinite
			), $atts, 'search-result' );

			if( trim($atts['template']) != '' ){
				// check if its from template
				$template = \MD_Template::get_instance()->load_template($atts['template']);
				if( !$template ){
					$template = CRM_DEFAULT_LIST;
				}
			}

			// hook filter, incase we want to just use hook
			if( has_filter('shortcode_search_result_'.$source) ){
				$template = apply_filters('shortcode_search_result_'.$source, $path);
			}

			$show_sort = true;
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
					function md_search_result(editor){
						var template = [
							<?php if( count($this->get_template()) > 0 ){ ?>
									<?php foreach($this->get_template() as $key=>$val){ ?>
											{text: '<?php echo $val; ?>',value: '<?php echo $key;?>'},
									<?php } ?>
							<?php } ?>
						];
						var submenu_array =
						{
							text: 'Search Property Result',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Search Property Result',
									width:980,
									height:350,
									body: [
										{
											type: 'listbox',
											name: 'listboxTemplate',
											label: 'Choose Template',
											'values': template
										},
										{
											type: 'textbox',
											name: 'textboxGridCol',
											label: 'Set property per columns ( should be divided by 12 )',
											value:'<?php echo MD_DEFAULT_GRID_COL;?>'
										},
										{
											type: 'checkbox',
											name: 'checkboxShowInfiniteScroll',
											label: 'Show Infinite Scroll? this will show the scrolling ajax instead of tix "how many display"',
											checked:true
										},
									],
									onsubmit: function( e ) {
										var template_path = ' template="' + e.data.listboxTemplate + '" ';
										var col_grid = ' col="' + e.data.textboxGridCol + '" ';
										var infinite = ' infinite="' + e.data.checkboxShowInfiniteScroll + '" ';
										editor.insertContent(
											'[md_search_property_result ' + template_path + col_grid + infinite + ']'
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

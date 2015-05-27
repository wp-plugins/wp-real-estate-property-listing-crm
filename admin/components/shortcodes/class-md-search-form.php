<?php
if ( !class_exists( 'md_sc_search_form' ) )
{
	class md_sc_search_form {
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
			add_shortcode('md_sc_search_property_form',array($this,'init_shortcode'));
		}

		public function get_template(){
			return \MD_Template::get_instance()->get_theme_page_template(GLOBAL_TEMPLATE . 'searchform', GLOBAL_TEMPLATE, 'Search Form');
		}

		private function _get_account_fields(){
			$fields = \CRM_Account::get_instance()->get_fields();
			return $fields;
		}

		public function get_autocomplete_location($output = null){
			//$location_lookup = \crm\AccountEntity::get_instance()->createCountryLookup();
			$location = null;
			$keyword = 'full';
			$location_lookup = apply_filters('location_lookup_' . DEFAULT_FEED, $location, $keyword);

			if( is_null($output) ){
				return $location_lookup;
			}elseif( $output == 'json' ){
				echo json_encode($location_lookup);
			}
		}

		public function shortcode_tag(){
			return '[md_sc_search_property_form template="searchform/search-form-minimal.php"]';
		}

		public function init_shortcode($atts){
			$template = '';
			if( isset($atts['template']) ){
				$att_template = $atts['template'];
				$template = $atts['template'];
			}

			$atts = shortcode_atts(	array(
				'template'	=> $template
			), $atts, 'search_form' );

			$template = CRM_DEFAULT_SEARCH_FORM;

			if( trim($atts['template']) != '' ){
				// check if its from template
				$template = \MD_Template::get_instance()->load_template($atts['template']);
				if( !$template ){
					$template = CRM_DEFAULT_SEARCH_FORM;
				}
			}

			// hook filter, incase we want to just use hook
			if( has_filter('shortcode_search_form_crm') ){
				$template = apply_filters('shortcode_search_form_crm', $path);
			}

			$fields = $this->_get_account_fields();

			$fields_type = array();
			if( $fields->result == 'success' ){
				$fields_type = $fields->fields->types;
			}

			$currency = \CRM_Account::get_instance()->get_account_data('currency');
			$array_search_criteria = array();

			$location = '';
			if( isset($_GET['location']) ){
				$location = sanitize_text_field($_GET['location']);
			}
			$min_listprice = 0;
			if( isset($_GET['min_listprice']) ){
				$min_listprice = sanitize_text_field($_GET['min_listprice']);
			}
			$max_listprice = 0;
			if( isset($_GET['max_listprice']) ){
				$max_listprice = sanitize_text_field($_GET['max_listprice']);
			}
			$property_type = '';
			if( isset($_GET['property_type']) ){
				$property_type = sanitize_text_field($_GET['property_type']);
			}
			$bedrooms = 0;
			if( isset($_GET['bedrooms']) ){
				$bedrooms = sanitize_text_field($_GET['bedrooms']);
			}
			$bathrooms = 0;
			if( isset($_GET['bathrooms']) ){
				$bathrooms	= sanitize_text_field($_GET['bathrooms']);
			}
			$lat = '';
			if( isset($_GET['lat']) ){
				$lat = sanitize_text_field($_GET['lat']);
			}
			$cityid = '';
			if( isset($_GET['cityid']) ){
				$cityid	= sanitize_text_field($_GET['cityid']);
			}
			$communityid = '';
			if( isset($_GET['communityid']) ){
				$communityid	= sanitize_text_field($_GET['communityid']);
			}
			$subdivisionid = '';
			if( isset($_GET['subdivisionid']) ){
				$subdivisionid	= sanitize_text_field($_GET['subdivisionid']);
			}
			$countyid = '';
			if( isset($_GET['countyid']) ){
				$countyid	= sanitize_text_field($_GET['countyid']);
			}
			$lon = '';
			if( isset($_GET['lon']) ){
				$lon = sanitize_text_field($_GET['lon']);
			}

			$button_for_sale = 'For Sale';
			if( has_filter('search_form_button_for_sale') ){
				$button_for_sale = apply_filters('search_form_button_for_sale', $button_for_sale);
			}

			$button_for_rent = 'For Rent';
			if( has_filter('search_form_button_for_rent') ){
				$button_for_rent = apply_filters('search_form_button_for_rent', $button_for_rent);
			}

			$show_button_for_sale = true;
			if( has_filter('show_button_for_sale') ){
				$show_button_for_sale = apply_filters('show_button_for_sale', $show_button_for_sale);
			}

			$show_button_for_rent = true;
			if( has_filter('show_button_for_rent') ){
				$show_button_for_rent = apply_filters('show_button_for_rent', $show_button_for_rent);
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
					function md_search_form(editor){
						var template = [
							<?php if( count($this->get_template()) > 0 ){ ?>
									<?php foreach($this->get_template() as $key=>$val){ ?>
											{text: '<?php echo $val; ?>',value: '<?php echo $key;?>'},
									<?php } ?>
							<?php } ?>
						];
						var submenu_array =
						{
							text: 'Search Property Form',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Search Property Form',
									width:980,
									height:350,
									body: [
										{
											type: 'listbox',
											name: 'listboxTemplate',
											label: 'Choose template UI',
											'values': template
										},
									],
									onsubmit: function( e ) {
										var template_path = ' template="' + e.data.listboxTemplate + '" ';
										editor.insertContent(
											'[md_sc_search_property_form ' + template_path + ']'
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

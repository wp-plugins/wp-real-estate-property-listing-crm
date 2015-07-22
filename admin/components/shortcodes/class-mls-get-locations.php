<?php
if ( !class_exists( 'md_sc_mls_get_locations' ) )
{
	class md_sc_mls_get_locations {
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
			add_action('admin_footer', array($this, 'md_get_locations_shortcodes'));
			add_action('wp_ajax_mls_list_locations_view', array($this,'list_locations_view') );
			add_action('wp_ajax_nopriv_mls_list_locations_view',array($this,'list_locations_view') );
			$shortcode_tag = $this->get_shortcode_tag();
			add_shortcode($shortcode_tag,array($this,'init_shortcode'));
		}

		public function get_shortcode_tag(){
			return 'mls_get_locations';
		}

		public function init_shortcode($atts){
			$data			= array();
			$data_locations = array();
			$locations 		= null;

			$search_by_cityid = '';
			if( isset($atts['cityid']) ){
				$search_by_cityid = $atts['cityid'];
			}

			$atts = shortcode_atts(	array(
				'cityid' => $search_by_cityid,
			), $atts, 'crm_get_locations' );

			$data['city_id'] = $search_by_cityid;
			$locations = \mls\AccountEntity::get_instance()->get_communities_by_city_id($search_by_cityid);

			if( $locations && count($locations) >= 1 ){
				foreach($locations as $key => $val){
					$community_name = str_replace( "\r\n", "\n", $val->community );
					$url = str_replace( "\r\n", "\n", $community_name );
					$url = str_replace( " ", "-", strtolower($community_name) );

					$url_swap = \Breadcrumb_Url::get_instance()->getUrlFilter($community_name);

					if( $url_swap ){
						$url = $url_swap;
					}elseif( \crm\MD_Searchby_Property::get_instance()->url_page($community_name) ){
						$url = \crm\MD_Searchby_Property::get_instance()->url_page($community_name);
					}else{
						$permalink = \Property_URL::get_instance()->get_permalink_property(\MD_Searchby_Property::get_instance()->community_pagename);
						$url = $permalink . 'mls-' . $val->community_id . '-' . $url;
					}

					$data_locations[] = array(
						'id' => $val->city_id,
						'url' => $url,
						'name' => $val->community
					);
				}
			}

			//sort it
			array_multisort($data_locations, SORT_ASC);

			$template = GLOBAL_TEMPLATE . '/list/default/mls-get-locations.php';

			$city_id = 0;
			if( isset($atts['cityid']) ){
				$city_id = $atts['cityid'];
			}
			// hook filter, incase we want to just use hook
			if( has_filter('shortcode_list_location_mls') ){
				$template = apply_filters('shortcode_list_location_mls', $path);
			}

			ob_start();
			require $template;
			$output = ob_get_clean();
			return $output;
		}

		public function get_template(){
			return \MD_Template::get_instance()->get_theme_page_template(GLOBAL_TEMPLATE . 'list', GLOBAL_TEMPLATE, 'List');
		}

		public function get_autocomplete_location(){
			return \md_sc_search_form::get_instance()->get_autocomplete_location();
		}

		public function get_location(){
			$json = array();
			$location = \mls\AccountEntity::get_instance()->get_cities_by_mls();
			if( count($location) > 0 ){
				//create a json
				foreach($location as $items){
					if( trim($items->city) != '' ){
						$json[] = array(
							'label'	=> 	\helpers\Text::remove_non_alphanumeric($items->city),
							'value'	=>	\helpers\Text::remove_non_alphanumeric($items->city),
							'id'	=>	$items->city_id,
							'type'	=>	'city',
						);
					}
				}
			}
			return $json;
		}

		public function list_locations_view(){
			require_once( WP_PLUGIN_DIR .'/'. PLUGIN_FOLDER_NAME.'/admin/components/shortcodes/view/mls-get-locations.php' );
 			wp_die();
 		}

		/**
		 * Add shortcode JS to the page
		 *
		 * @return HTML
		 */
		public function md_get_locations_shortcodes()
		{
			?>
				<script type="text/javascript">
					function mls_get_locations(editor){
						var template = [
							<?php if( count($this->get_template()) > 0 ){ ?>
									<?php foreach($this->get_template() as $key=>$val){ ?>
											{text: '<?php echo $val; ?>',value: '<?php echo $key;?>'},
									<?php } ?>
							<?php } ?>
						];

						var submenu_array =
							{
								text:'List Locations',
								onclick: function() {
									editor.windowManager.open(
										{
											width:1000,
											height:600,
											title: 'Insert locations',
											file: ajaxurl + '?action=mls_list_locations_view',
											inline:1,
										},
										{
											editor:editor,
											jquery:jQuery,
											template:template,
										}
									);
								}
							};
						return submenu_array;
					}
				</script>
			<?php
		}
	}
}

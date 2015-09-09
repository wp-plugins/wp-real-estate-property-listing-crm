<?php
if ( !class_exists( 'md_sc_crm_get_locations' ) )
{
	class md_sc_crm_get_locations {
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
			add_action('wp_ajax_list_locations_view', array($this,'list_locations_view') );
			add_action('wp_ajax_nopriv_list_locations_view',array($this,'list_locations_view') );
			$shortcode_tag = $this->get_shortcode_tag();
			add_shortcode($shortcode_tag,array($this,'init_shortcode'));
		}

		public function get_shortcode_tag(){
			return 'crm_get_locations';
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
			$locations = \CRM_Locations::get_instance()->get_communities_by_cityId($data);

			if( $locations && isset($locations->result) == 'success' ){
				foreach($locations->communities as $key => $val){
					$community_name = str_replace( "\r\n", "\n", $val->community_name );
					$city_name 		= str_replace( "\r\n", "\n", $val->city_name );
					$full_community_name_city = $community_name .' '. $city_name;

					$url = str_replace( "\r\n", "\n", $val->community_name );
					$url = str_replace( " ", "-", strtolower($val->community_name) );

					$url_swap = \Breadcrumb_Url::get_instance()->getUrlFilter($val->community_name);

					if( $url_swap ){
						$url = $url_swap;
					}elseif( \crm\MD_Searchby_Property::get_instance()->url_page($full_community_name_city) ){
						$url = \crm\MD_Searchby_Property::get_instance()->url_page($full_community_name_city);
					}else{
						$permalink = \Property_URL::get_instance()->get_permalink_property(\MD_Searchby_Property::get_instance()->community_pagename);
						$url = $permalink . 'crm-' . $val->community_id . '-' . $url;
					}

					$data_locations[] = array(
						'url' => $url,
						'name' => $val->community_name
					);
				}
			}

			$template = PLUGIN_VIEW . '/list/default/get-locations.php';

			// hook filter, incase we want to just use hook
			if( has_filter('shortcode_list_location_crm') ){
				$template = apply_filters('shortcode_list_location_crm', $path);
			}

			ob_start();
			require $template;
			$output = ob_get_clean();
			return $output;
		}

		public function get_template(){
			return \MD_Template::get_instance()->get_theme_page_template(PLUGIN_VIEW . 'list', PLUGIN_VIEW, 'List');
		}

		public function get_autocomplete_location(){
			return \md_sc_search_form::get_instance()->get_autocomplete_location();
		}

		public function get_location(){
			$json = array();
			$location = \CRM_Account::get_instance()->get_coverage_lookup();

			if( isset($location->result) && $location->result == 'success' ){
				//create a json
				foreach($location->lookups as $items){
					if( $items->location_type == 'city' ){
						$json[] = array(
							'label'	=> 	\helpers\Text::remove_non_alphanumeric($items->full),
							'value'	=>	\helpers\Text::remove_non_alphanumeric($items->full),
							'id'	=>	$items->id,
							'type'	=>	$items->location_type,
						);
					}
				}
				return $json;
			}
			return array();
		}

		public function list_locations_view(){
			require_once( WP_PLUGIN_DIR .'/'. PLUGIN_FOLDER_NAME.'/admin/components/shortcodes/view/get-locations.php' );
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
					function crm_get_locations(editor){

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
											file: ajaxurl + '?action=list_locations_view',
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

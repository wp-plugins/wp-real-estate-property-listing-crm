<?php
if ( !class_exists( 'md_sc_crm_list_properties' ) )
{
	class md_sc_crm_list_properties {
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
			add_action('wp_ajax_list_property_view', array($this,'list_property_view') );
			add_action('wp_ajax_nopriv_list_property_view',array($this,'list_property_view') );
			$shortcode_tag = $this->get_shortcode_tag();
			add_shortcode($shortcode_tag,array($this,'init_shortcode'));
		}

		public function get_shortcode_tag(){
			return 'crm_list_properties';
		}

		public function init_shortcode($atts){
			$search_data = array();
			$template = '';
			if( isset($atts['template']) ){
				$att_template = $atts['template'];
			}
			$search_by_zip = '';
			if( isset($atts['zip']) ){
				$search_by_zip = $atts['zip'];
			}
			$search_by_cityid = '';
			if( isset($atts['cityid']) ){
				$search_by_cityid = $atts['cityid'];
			}
			$search_by_communityid = '';
			if( isset($atts['communityid']) ){
				$search_by_communityid = $atts['communityid'];
			}
			$search_by_subdivisionid = '';
			if( isset($atts['subdivisionid']) ){
				$search_by_subdivisionid = $atts['subdivisionid'];
			}
			$search_by_countryid = '';
			if( isset($atts['countryid']) ){
				$search_by_countryid = $atts['countryid'];
			}
			$search_by_countyid = '';
			if( isset($atts['countyid']) ){
				$search_by_countyid = $atts['countyid'];
			}
			$search_by_stateid = '';
			if( isset($atts['stateid']) ){
				$search_by_stateid = $atts['stateid'];
			}
			$bathrooms = 0;
			if( isset($atts['bathrooms']) ){
				$bathrooms = $atts['bathrooms'];
			}
			$bedrooms = 0;
			if( isset($atts['bedrooms']) ){
				$bedrooms = $atts['bedrooms'];
			}
			$min_listprice = 0;
			if( isset($atts['min_listprice']) ){
				$min_listprice = $atts['min_listprice'];
			}
			$max_listprice = 0;
			if( isset($atts['max_listprice']) ){
				$max_listprice = $atts['max_listprice'];
			}
			$status = '';
			if( isset($atts['property_status']) ){
				$status = $atts['property_status'];
			}
			$property_type = '';
			if( isset($atts['property_type']) ){
				$property_type = $atts['property_type'];
			}
			$transaction = '';
			if( isset($atts['transaction']) ){
				$transaction = $atts['transaction'];
			}
			$limit = '';
			if( isset($atts['limit']) ){
				$limit = $atts['limit'];
			}

			if( $atts['infinite'] == 'true' ){
				$atts['infinite'] = true;
			}elseif( $atts['infinite'] == 'false' ){
				$atts['infinite'] = false;
			}

			if( !isset($atts['pagination']) ){
				$atts['pagination'] = 'false';
			}

			if( isset($atts['col']) && is_numeric($atts['col']) ){
				$col = ceil(12 / $atts['col'] );
			}else{
				$col = MD_DEFAULT_GRID_COL;
			}
			$orderby = '';
			if( isset($atts['orderby']) ){
				$orderby = $atts['orderby'];
			}else{
				if( isset($_REQUEST['orderby']) ){
					$orderby = sanitize_text_field($_REQUEST['orderby']);
				}
			}
			$order_direction = '';
			if( isset($atts['order_direction']) ){
				$order_direction = $atts['order_direction'];
			}else{
				if( isset($_REQUEST['order_direction']) ){
					$order_direction = sanitize_text_field($_REQUEST['order_direction']);
				}
			}

			$atts = shortcode_atts(	array(
				'template' 			=> $att_template,
				'communityid'		=> $search_by_communityid,
				'subdivisionid'		=> $search_by_subdivisionid,
				'countryid'			=> $search_by_countryid,
				'countyid'			=> $search_by_countyid,
				'stateid'			=> $search_by_stateid,
				'cityid'			=> $search_by_cityid,
				'zip'				=> $search_by_zip,
				'bathrooms'			=> $bathrooms,
				'bedrooms'			=> $bedrooms,
				'min_listprice'		=> $min_listprice,
				'max_listprice'		=> $max_listprice,
				'property_status'	=> $status,
				'property_type'		=> $property_type,
				'transaction'		=> $transaction,
				'limit'				=> $limit,
				'orderby'			=> $orderby,
				'order_direction'	=> $order_direction,
				'infinite'			=> $atts['infinite'],
				'pagination'		=> $atts['pagination'],
				'col'				=> $col,
				'template'			=> $template
			), $atts, 'crm_list_property' );

			$search_data['subdivisionid']	= $atts['subdivisionid'];
			$search_data['communityid']		= $atts['communityid'];
			$search_data['countryid']		= $atts['countryid'];
			$search_data['countyid']		= $atts['countyid'];
			$search_data['stateid']			= $atts['stateid'];
			$search_data['cityid']			= $atts['cityid'];
			$search_data['zip'] 			= $atts['zip'];
			$search_data['bathrooms'] 		= $atts['bathrooms'];
			$search_data['bedrooms'] 		= $atts['bedrooms'];
			$search_data['min_listprice'] 	= $atts['min_listprice'];
			$search_data['max_listprice'] 	= $atts['max_listprice'];
			$search_data['property_status']	= $atts['property_status'];
			$search_data['property_type'] 	= $atts['property_type'];
			$search_data['transaction'] 	= $atts['transaction'];
			$search_data['limit'] 			= $atts['limit'];
			$search_data['orderby'] 		= $orderby;
			$search_data['order_direction'] = $order_direction;

			$properties = \CRM_Property::get_instance()->get_properties($search_data);

			\MD\Property::get_instance()->set_properties($properties,'crm');

			if( trim($atts['template']) != '' ){
				// check if its from template
				$template = \MD_Template::get_instance()->load_template($atts['template']);
				if( !$template ){
					$template = CRM_DEFAULT_LIST;
				}
			}

			// hook filter, incase we want to just use hook
			if( has_filter('shortcode_list_property_crm') ){
				$template = apply_filters('shortcode_list_property_crm', $path);
			}

			$show_sort = true;
			$args_button_action = array(
				'show' => 1,
				'favorite'	=> array(
					'show' => 1
				),
				'xout'	=> array(
					'show' => 1
				),
				'print'	=> array(
					'show' => 1,
				),
				'share'	=> array(
					'show' => 1
				),
			);
			$atts['source'] = 'crm';
			$atts['server_query_string'] = $_SERVER['QUERY_STRING'];
			$atts['site_url'] = site_url();
			ob_start();
			require $template;
			$output = ob_get_clean();
			return $output;
		}

		private function get_fields_status(){
			$fields = \CRM_Account::get_instance()->get_fields();
			if( isset($fields->fields->status) ){
				return $fields->fields->status;
			}
			return false;
		}

		private function get_fields_type(){
			$fields = \CRM_Account::get_instance()->get_fields();
			if( isset($fields->fields->types) ){
				return $fields->fields->types;
			}
			return false;
		}

		public function get_template(){
			return \MD_Template::get_instance()->get_theme_page_template(GLOBAL_TEMPLATE . 'list', GLOBAL_TEMPLATE, 'List');
		}

		public function get_autocomplete_location(){
			return \md_sc_search_form::get_instance()->get_autocomplete_location();
		}

		public function get_location(){
			$json = array();
			$location = \CRM_Account::get_instance()->get_country_coverage_lookup();

			if( isset($location->result) && $location->result == 'success' ){
				//create a json
				foreach($location->lookups as $items){
					$json[] = array(
						'label'	=> 	\helpers\Text::remove_non_alphanumeric($items->full),
						'value'	=>	\helpers\Text::remove_non_alphanumeric($items->full),
						'id'	=>	$items->id,
						'type'	=>	$items->location_type,
					);
				}
				return $json;
			}
			return array();
		}

		public function list_property_view(){
			require_once( WP_PLUGIN_DIR .'/'. PLUGIN_FOLDER_NAME.'/admin/components/shortcodes/view/list-properties.php' );
 			wp_die();
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
					function crm_list_properties(editor){

						var search_status = [
							<?php if( $this->get_fields_status() ){ ?>
								<?php foreach($this->get_fields_status() as $key => $val ) { ?>
										{text: '<?php echo $val;?>', value: '<?php echo $key;?>'},
								<?php } ?>
							<?php } ?>
						];

						var search_type = [
							<?php if( $this->get_fields_type() ){ ?>
									  {text: 'All', value: '0'},
								<?php foreach($this->get_fields_type() as $key => $val ) { ?>
										{text: '<?php echo $val;?>', value: '<?php echo $key;?>'},
								<?php } ?>
							<?php } ?>
						];

						var template = [
							<?php if( count($this->get_template()) > 0 ){ ?>
									<?php foreach($this->get_template() as $key=>$val){ ?>
											{text: '<?php echo $val; ?>',value: '<?php echo $key;?>'},
									<?php } ?>
							<?php } ?>
						];

						var submenu_array =
							{
								text:'List Properties',
								onclick: function() {
									editor.windowManager.open(
										{
											width:1000,
											height:600,
											title: 'Insert Property by search criteria API',
											file: ajaxurl + '?action=list_property_view',
											inline:1,
										},
										{
											editor:editor,
											jquery:jQuery,
											template:template,
											search_type:search_type,
											search_status:search_status,
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

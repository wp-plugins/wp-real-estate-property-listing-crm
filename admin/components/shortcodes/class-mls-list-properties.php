<?php
if ( !class_exists( 'md_sc_mls_list_properties' ) )
{
	class md_sc_mls_list_properties {
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
			add_shortcode('mls_list_properties',array($this,'init_shortcode'));
			add_action('wp_ajax_mls_list_property_view', array($this,'mls_list_property_view'));
			add_action('wp_ajax_nopriv_mls_list_property_view',array($this,'mls_list_property_view'));
		}

		public function get_location(){
			$json = array();
			$location = \mls\AccountEntity::get_instance()->get_coverage_lookup();
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
			}
			return $json;
		}

		public function get_template(){
			return \MD_Template::get_instance()->get_theme_page_template(GLOBAL_TEMPLATE . 'list', GLOBAL_TEMPLATE, 'List');
		}

		public function mls_list_property_view(){
			require_once( WP_PLUGIN_DIR .'/'. PLUGIN_FOLDER_NAME.'/admin/components/shortcodes/view/mls-list-properties.php' );
			wp_die();
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

		public function get_autocomplete_location(){
			return \md_sc_search_form::get_instance()->get_autocomplete_location();
		}

		private function _status(){
			return array(
				'Active' => 'Active',
				'Backup Offer' => 'Backup Offer',
				'Pending Sale' => 'Pending Sale',
				'Closed Sale' => 'Closed Sale',
			);
		}

		private function _transaction(){
			return array(
				'Rent' => 'Rent',
				'Sale' => 'Sale',
			);
		}

		public function init_shortcode($atts){
			$search_data = array();
			$template = '';
			if( isset($atts['template']) ){
				$att_template = $atts['template'];
			}
			$location = '';
			if( isset($atts['q']) ){
				$location = $atts['q'];
			}
			$search_by_cityid = '';
			if( isset($atts['cityid']) ){
				$search_by_cityid = $atts['cityid'];
			}
			$search_by_communityid = '';
			if( isset($atts['communityid']) ){
				$search_by_communityid = $atts['communityid'];
			}
			$search_by_countyid = '';
			if( isset($atts['countyid']) ){
				$search_by_countyid = $atts['countyid'];
			}
			$bathrooms = '';
			if( isset($atts['bathrooms']) ){
				$bathrooms = $atts['bathrooms'];
			}
			$bedrooms = '';
			if( isset($atts['bedrooms']) ){
				$bedrooms = $atts['bedrooms'];
			}
			$min_listprice = '';
			if( isset($atts['min_listprice']) ){
				$min_listprice = $atts['min_listprice'];
			}
			$max_listprice = '';
			if( isset($atts['max_listprice']) ){
				$max_listprice = $atts['max_listprice'];
			}
			$status = '';
			if( isset($atts['property_status']) ){
				$status = $atts['property_status'];
			}
			$type = '';
			if( isset($atts['property_type']) ){
				$type = $atts['property_type'];
			}
			$transaction = '';
			if( isset($atts['transaction']) ){
				$transaction = $atts['transaction'];
			}
			$limit = 11;
			if( isset($atts['limit']) ){
				$limit = $atts['limit'];
			}
			$lat = '';
			if( isset($atts['lat']) ){
				$lat = $atts['lat'];
			}
			$lon = '';
			if( isset($atts['lon']) ){
				$lon = $atts['lon'];
			}

			if( $atts['infinite'] == 'true' ){
				$atts['infinite'] = true;
			}elseif( $atts['infinite'] == 'false' ){
				$atts['infinite'] = false;
			}

			if( isset($atts['col']) && is_numeric($atts['col']) ){
				$col = ceil(12 / $atts['col'] );
			}else{
				$col = MD_DEFAULT_GRID_COL;
			}

			$atts = shortcode_atts(	array(
				'template' 		=> $att_template,
				'communityid'	=> $search_by_communityid,
				'countyid'		=> $search_by_countyid,
				'cityid'		=> $search_by_cityid,
				'q' 			=> $location,
				'lat' 			=> $lat,
				'lon' 			=> $lon,
				'bathrooms' 	=> $bathrooms,
				'bedrooms' 		=> $bedrooms,
				'min_listprice' => $min_listprice,
				'max_listprice' => $max_listprice,
				'status'		=> $status,
				'type'			=> $type,
				'transaction'	=> $transaction,
				'limit'			=> $limit,
				'infinite'		=> $atts['infinite'],
				'col'			=> $col,
				'template'		=> $template
			), $atts, 'mls_list_property' );

			$search_data['communityid']		= $atts['communityid'];
			$search_data['countyid']		= $atts['countyid'];
			$search_data['cityid']			= $atts['cityid'];
			$search_data['location']		= $location;
			$search_data['bathrooms'] 		= $bathrooms;
			$search_data['bedrooms'] 		= $bedrooms;
			$search_data['min_listprice'] 	= $min_listprice;
			$search_data['max_listprice'] 	= $max_listprice;
			$search_data['property_status']	= $status;
			$search_data['property_type'] 	= $type;
			$search_data['transaction'] 	= $transaction;
			$search_data['limit'] 			= $limit;

			$properties = \MLS_Property::get_instance()->get_properties($search_data);
			//\helpers\Text::print_r_array($properties);
			\MD\Property::get_instance()->set_properties($properties,'mls');

			if( trim($atts['template']) != '' ){
				// check if its from template
				$template = \MD_Template::get_instance()->load_template($atts['template']);
				if( !$template ){
					$template = LIST_BOX_STYLE;
				}
			}

			// hook filter, incase we want to just use hook
			if( has_filter('shortcode_list_property_mls') ){
				$template = apply_filters('shortcode_list_property_mls', $path);
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
			$atts['source'] = 'mls';
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
					function mls_list_properties(editor){
						var mls_jquery_auto_location = <?php echo json_encode($this->get_location()); ?>;
						var search_status = [
							<?php if( $this->_status() ){ ?>
								<?php foreach($this->_status() as $key => $val ) { ?>
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
											title: 'Insert Propert by search criteria - MLS',
											file: ajaxurl + '?action=mls_list_property_view',
											inline:1,
										},
										{
											editor:editor,
											jquery:jQuery,
											autocomplete_location:mls_jquery_auto_location,
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

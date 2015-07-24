<?php
if ( !class_exists( 'md_sc_single_properties' ) )
{
	class md_sc_single_properties {
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
			add_shortcode('md_single_properties',array($this,'init_shortcode'));
		}

		public function display_inquire_form($att){
			\Inquire::get_instance()->display($att);
		}

		public function init_shortcode($atts){
			$template = false;

			if( isset($atts['template']) ){
				$att_template = $atts['template'];
			}

			if( isset($atts['template_carousel']) ){
				$att_template_carousel = $atts['template_carousel'];
			}

			$atts['show_nearby_prop'] = false;
			$att_show_nearby_prop = false;
			if( isset($atts['show_nearby_prop']) == 'true' ){
				$atts['show_nearby_prop'] = true;
				$att_show_nearby_prop = true;
			}
			$short_code_nearby_col = (int)$atts['nearby_prop_col'];
			if( isset($atts['nearby_prop_col']) && is_numeric($atts['nearby_prop_col']) ){
				$att_nearby_prop_col = ceil(12 / $atts['nearby_prop_col'] );
			}else{
				$att_nearby_prop_col = MD_DEFAULT_GRID_COL;
			}
			$atts['nearby_prop_col'] = $att_nearby_prop_col;

			$atts = shortcode_atts(
				array(
					'template' 				=> $att_template,
					'template_carousel' 	=> $att_template_carousel,
					'show_nearby_prop' 		=> $att_show_nearby_prop,
					'nearby_prop_col' 		=> $att_nearby_prop_col,
					'short_code_nearby_col'	=>$short_code_nearby_col,
				),
				$atts, 'md_singleproperty'
			);

			$data 			= \MD_Single_Property::get_instance()->getPropertyData();

			$have_property 	= false;

			if( DEFAULT_FEED == 'crm' ){
				$template_path 	= CRM_VIEW;
			}else{
				$template_path 	= MLS_VIEW;
			}

			if( $data ){

				\MD\Property::get_instance()->set_properties($data['property'],$data['source']);
				\MD\Property::get_instance()->set_loop($data['property']);
				$have_property = true;

				/*$source = $data['source'];
				$properties = apply_filters('single_property_' . $source, $atts);
				*/

				// @TODO convert this into hook
				if( $data['source'] == 'crm' ){
					$data['related']['total'] = count($data['related']);
					$template 		= CRM_DEFAULT_SINGLE;
					$template_path 	= CRM_VIEW;
					$photo = '';
					$photo_url = $data['property']->getPhotoUrl($data['photos']);
					if( isset($photo_url[0]) ){
						$photo 			= $photo_url[0];
					}
				}elseif( $data['source'] == 'mls' ){
					$template 		= MLS_DEFAULT_SINGLE;
					$template_path 	= MLS_VIEW;
					$photo = $data['property']->PrimaryPhotoUrl;
				}
				// @TODO convert this into hook end

				$att_inquire_msg = array(
					'show' => 1,
					'msg' => "I would like to get more information regarding: mls# " . $data['property']->getMLS() .' '. $data['property']->displayAddress(),
				);

				$args_button_action = array(
					'favorite'	=> array(
						'show' => 1,
						'property_id' => md_property_id(),
						'feed' => md_get_source(),
					),
					'xout'	=> array(
						'show' => 1,
						'property_id' => md_property_id(),
						'feed' => md_get_source(),
					),
					'print'	=> array(
						'show' => 1,
						'url' => get_option('siteurl') . '/printpdf/'.md_property_id(),
					),
					'share'	=> array(
						'show' => 1,
						'property_id' => md_property_id(),
						'feed' => md_get_source(),
						'url' => $data['property']->displayUrl(),
						'address' => $data['property']->displayAddress() ? $data['property']->displayAddress():$data['property']->tag_line,
						'media' => $photo
					),
				);
			}

			if( trim($atts['template']) != '' ){
				// check if its from template
				$template = \MD_Template::get_instance()->load_template($atts['template']);
				if( !$template ){
					$template = CRM_DEFAULT_LIST;
				}
			}

			// hook filter, incase we want to just use hook
			if( has_filter('shortcode_single_property_crm') ){
				$template = apply_filters('shortcode_single_property_crm', $path);
			}

			// hook filter, incase we want to just use hook
			if( has_filter('shortcode_single_property_carousel_crm') ){
				$template_carousel = apply_filters('shortcode_single_property_carousel_crm', $path);
			}

			ob_start();
			require $template;
			$output = ob_get_clean();
			return $output;
		}

		public function get_template_carousel(){
			return \MD_Template::get_instance()->get_theme_page_template(PLUGIN_VIEW . 'carousel', PLUGIN_VIEW,  'Carousel');
		}

		public function get_template(){
			return \MD_Template::get_instance()->get_theme_page_template(PLUGIN_VIEW . 'single', PLUGIN_VIEW, 'Single');
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
					function md_single_property(editor){
						var template = [
							<?php if( count($this->get_template()) > 0 ){ ?>
									<?php foreach($this->get_template() as $key=>$val){ ?>
											{text: '<?php echo $val; ?>',value: '<?php echo $key;?>'},
									<?php } ?>
							<?php } ?>
						];
						var template_carousel = [
							<?php if( count($this->get_template_carousel()) > 0 ){ ?>
									<?php foreach($this->get_template_carousel() as $key=>$val){ ?>
											{text: '<?php echo $val; ?>',value: '<?php echo $key;?>'},
									<?php } ?>
							<?php } ?>
						];
						var submenu_array =
						{
							text: 'Single Property',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Single Property page',
									width:980,
									height:350,
									body: [
										{
											type: 'listbox',
											name: 'listboxTemplateCarousel',
											label: 'Choose carousel gallery',
											'values': template_carousel
										},
										{
											type: 'listbox',
											name: 'listboxTemplate',
											label: 'Choose Template',
											'values': template
										},
										{
											type: 'checkbox',
											name: 'checkboxShowNearbyProperties',
											label: 'Show Nearby properties?',
											checked:true
										},
										{
											type: 'textbox',
											name: 'textboxNearbyPropertyCol',
											label: 'Nearby Property, how many column to display ( should be divided by 12 )',
											value:'1'
										},
									],
									onsubmit: function( e ) {
										var template_carousel = ' template_carousel="' + e.data.listboxTemplateCarousel + '" ';
										var template = ' template="' + e.data.listboxTemplate + '" ';
										var show_nearby_prop = ' show_nearby_prop="' + e.data.checkboxShowNearbyProperties + '" ';
										var nearby_prop_col = ' nearby_prop_col="' + e.data.textboxNearbyPropertyCol + '" ';
										editor.insertContent(
											'[md_single_properties ' + template + template_carousel + show_nearby_prop + nearby_prop_col + ']'
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

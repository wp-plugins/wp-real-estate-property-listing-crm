<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
add_action('wp', 'enfold_config');
function enfold_config(){
	$theme = wp_get_theme();
	if( !is_404() ){
		if(
			($theme->template == 'enfold' || $theme->parent->template == 'enfold') &&
			\Masterdigm_API::get_instance()->has_crm_api_key()
		){
			//add_action('do_not_show_this_breadcrumb','__return_true');
			add_action('parse_query', 'parse_query_callback');
			function parse_query_callback(){
				if( function_exists('get_single_data') ){
					return get_single_data();
				}
				return false;
			}
			add_filter('avia_breadcrumbs_trail', 'single_property_breadcrumb_trail', 10, 2);
			add_filter('avf_title_args', 'enfold_title_property',20, 2 );
			add_filter('avf_title_tag', 'md_wp_title', 20, 2 );
			function enfold_title_property($args, $id){
				global $wp_query, $md_title, $get_single_property_source;

				if( is_page() && $wp_query->post->post_name == 'property' ){
					$property_address = md_title();
					if( $property_address ){
						$args['title'] 		= md_title();
						$args['link'] 		= '';
						$args['heading'] 	= 'h1';
					}
				}

				$label = 'Homes for Sale And Rent in ';
				$label = apply_filters('home_for_sale_rent_hook', $label);

				if( is_page() && $wp_query->post->post_name == 'search-properties' ){

					if( sanitize_text_field(isset($_REQUEST['location'])) ){
						$location = sanitize_text_field($_REQUEST['location']);
						if( isset($location) && trim($location) != '' ){
							$location 			= '<span style="font-style:italic">'.$location.'</span>';
							$args['title'] 		= $label . $location;
							$args['link'] 		= '';
							$args['heading'] 	= 'h1';
						}
					}
				}

				if( is_page() == 'page' &&
					$wp_query->post->post_name == 'country' ||
					$wp_query->post->post_name == 'county' ||
					$wp_query->post->post_name == 'state' ||
					$wp_query->post->post_name == 'city' ||
					$wp_query->post->post_name == 'community' ||
					$wp_query->post->post_name == 'zip'
				){
					if( get_single_property_source() == 'mls' ){
						$location = str_replace('-',' ',get_query_var('url'));
						$location = ucwords($location);
					}elseif( get_single_property_source() == 'crm' ){
						$location 		= '';
						$query_var   	= get_query_var('url');
						$parse_property = explode( '-', $query_var);

						unset($parse_property[0]);
						foreach($parse_property as $val){
							$location .= $val.' ';
						}
						$location = ucwords($location);
					}
					if( isset($location) && trim($location) != '' ){
						$args['location']	= $label . $location;
						$args['title'] 		= $label . ' <span style="font-style:italic">'.$location.'</span>';
						$args['link'] 		= '';
						$args['heading'] 	= 'h1';
					}
				}

				return $args;
			}
			function md_title(){
				$title = '';
				$address = parse_query_callback();
				$add_string = '';
				if( $address ){
					$add_string = apply_filters('wp_title_' . $address['source'], $address);
					$title = $address['property']->displayAddress();
				}
				return $title . $add_string;
			}
			function md_wp_title($title, $sep){
				$address = parse_query_callback();
				$add_string = '';
				if( $address ){
					$add_string = apply_filters('wp_title_' . $address['source'], $address);
					$title = $address['property']->displayAddress();
				}
				return $title . $add_string;
			}
			add_action( 'wp_head', 'my_styles_method',100);
			function my_styles_method(){
				$theme 					= wp_get_theme();
				$name 					= strtolower(str_replace(' ','_',$theme->name));
				$get_avia_options 		= get_option('avia_options_'.$name);
				//var_dump($get_avia_options);exit();
				$main_primary_bg_color 	= $get_avia_options['avia']['colorset-main_color-primary'];
				$main_color_secondary 	= $get_avia_options['avia']['colorset-main_color-secondary'];
				$main_color				= array(
					'main_color-bg' => $get_avia_options['avia']['colorset-main_color-bg'],
					'main_color-bg2' => $get_avia_options['avia']['colorset-main_color-bg2'],
					'main_color-primary' => $get_avia_options['avia']['colorset-main_color-primary'],
					'main_color-color' => $get_avia_options['avia']['colorset-main_color-color'],
					'main_color-border' => $get_avia_options['avia']['colorset-main_color-border'],
				);
				?>
				<style>
					.md_main_color_bg{
						background-color:<?php echo $main_color['main_color-bg'];?>;
					}
					.md_main_color_bg2{
						background-color:<?php echo $main_color['main_color-bg2'];?>;
					}
					.md_main_color_primary{
						background-color:<?php echo $main_color['main_color-primary'];?>;
						color:<?php echo $main_color['main_color-primary'];?>;
					}
					.md_main_color_primary_bg{
						background-color:<?php echo $main_color['main_color-primary'];?>;
					}
					.md_main_color_primary_color{
						color:<?php echo $main_color['main_color-primary'];?>;
					}
					.md_main_color-color{
						color:<?php echo $main_color['main_color-color'];?>;
					}
					.md_main_color-border{
						color:<?php echo $main_color['main_color-border'];?>;
					}
					.nav-tabs > li > a{
							background-color: <?php echo $main_primary_bg_color;?>;
					}
					.nav-tabs > li > a:hover{
							background-color: <?php echo $main_color_secondary;?>;
					}
					.right-sidebar .btn{
						background-color: <?php echo $main_primary_bg_color;?>;
					}
					.right-sidebar .btn:hover{
						background-color: <?php echo $main_color_secondary;?>;
					}
					.property-item .label-property{
						background-color: <?php echo $main_primary_bg_color;?> !important;
					}
					.panel-footer .btn{
						background-color: <?php echo $main_primary_bg_color;?>;
					}
					.panel-footer .btn:hover{
						background-color: <?php echo $main_color_secondary;?>;
					}
					.masterdigm-property-box .caption h3{
						color:<?php echo $main_color['main_color-primary'];?>;
					}
				</style>
				<?php
			}
		}//enfold

	}
}

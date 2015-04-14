<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
add_action('init', 'mdStartSession', 1);
function mdStartSession() {
	if(!session_id()) {
		session_start();
	}
}
function checkUrlSource(){
	$query_var   	= get_query_var('url');
	$parse_property = explode( '-', $query_var);
	if( is_int((int)$parse_property[0]) && (int)$parse_property[0] != 0 ){
		return 'crm';
	}else{
		return 'mls';
	}
}
function get_single_data(){
	return \MD_Single_Property::get_instance()->getPropertyData();
}
function get_single_property_source(){
	return \MD_Single_Property::get_instance()->getApiDataSource();
}
function get_single_property_data(){
	$property = get_single_data();
	if( $property && isset($property['property']) ){
		return $property['property'];
	}
	return false;
}
function get_single_property_photos(){
	$property = get_single_data();

	if( $property && isset($property['photos']) ){
		return $property['photos'];
	}
	return false;
}
function get_single_related_properties(){
	$related = get_single_data();
	return $related['related'];
}

function display_single_related_properties($col_num = null){
	$properties  = get_single_related_properties();

	\MD\Property::get_instance()->set_properties($properties,'crm');

	if( count($properties) > 0 ){
		$related_template = CRM_DEFAULT_RELATED;

		$col = $col_num;

		if( is_null($col_num) ){
			$col = MD_DEFAULT_GRID_COL;
		}

		if( has_filter('template_related_col') ){
			$col = apply_filters('template_related_col', $col_num);
		}

		// hook filter, incase we want to just use hook
		if( has_filter('template_related_properties') ){
			$related_template = apply_filters('template_related_properties', $path);
		}

		require $related_template;
	}
}
function get_single_property_by($by = null){
	$property = get_single_property_data();
	return $property->$by;
}
function get_single_property_id(){
	$source = get_single_property_source();
	if( $source == 'crm' ){
	 return get_single_property_by('id');
	}
}
function crm_masterdigm_breadcrumb(){
	if( !has_filter('do_not_show_this_breadcrumb') ){
		$trail 	= array();
		$args 	= array();
		$trail 	= single_property_breadcrumb_trail($trail, $args);
		if( count($trail) > 0 ){
			echo '<ol class="breadcrumb">';
				foreach($trail as $key => $val){
					echo '<li>';
						echo $val;
					echo '</li>';
				}
			echo '</ol>';
		}
	}
}
function single_property_breadcrumb_trail($trail, $args){
	global $wp_query;

	$home_label 	= 'Homes for Sale';
	$property 		= get_single_data();
	$bread_crumb 	= array();
	$source 		= get_single_property_source();
	$display 		= false;

	if( $wp_query->post->post_name == 'property' && $source == DEFAULT_FEED ){
		$display = true;
	}elseif(
		$wp_query->post->post_name == 'country' ||
		$wp_query->post->post_name == 'county' ||
		$wp_query->post->post_name == 'state' ||
		$wp_query->post->post_name == 'city' ||
		$wp_query->post->post_name == 'community' ||
		$wp_query->post->post_name == 'zip' &&
		get_single_property_source() == DEFAULT_FEED
	){
		$display = true;
	}

	if( $display &&  ($property && isset($property['source'])) ){
		switch($property['source']){
			case 'crm':
				$show_location = array(
					'country'	=>	false,
					'state'		=>	true,
					'county'	=>	true,
					'city'		=>	true,
					'community'	=>	true,
					'zip'		=>	false,
				);
			break;
			case 'mls':
				$show_location = array(
					'country'	=>	false,
					'state'		=>	true,
					'county'	=>	true,
					'city'		=>	true,
					'community'	=>	true,
					'zip'		=>	false,
				);
			break;
		}
		$args['show_location'] 	= $show_location;
		$bread_crumb = \MD_Single_Property_Breadcrumb::get_instance()->masterdigm_breadcrumb_trail($property, $args);

		if( is_page('property') && $property ){
			unset($trail);
			\MD_Single_Property_Breadcrumb::get_instance()->deleteSessionBreadCrumb($source);
			\MD_Single_Property_Breadcrumb::get_instance()->setSessionBreadCrumb($source, $bread_crumb);

			$trail 	 = array();
			$trail[] =	'<a href="'.get_bloginfo('url').'" class="property-bread-crumb trail-begin">'.$home_label.'</a>';

			if( $bread_crumb ){
				foreach($bread_crumb as $val) {
					$trail[] = $val;
				}
			}
		}

		if( is_page('country') ||
			is_page('county') ||
			is_page('state') ||
			is_page('city') ||
			is_page('community') ||
			is_page('zip')
		){
			$breadcrumb = \MD_Single_Property_Breadcrumb::get_instance()->getSessionBreadCrumb(DEFAULT_FEED);
			unset($trail);
			$trail 	 = array();
			$trail[] =	'<a href="'.get_bloginfo('url').'" class="property-bread-crumb trail-begin">'.$home_label.'</a>';
			if( $breadcrumb ){
				foreach($breadcrumb as $val) {
					$trail[] = $val;
				}
			}
		}
	}else{
		$breadcrumb = \MD_Single_Property_Breadcrumb::get_instance()->getSessionBreadCrumb(DEFAULT_FEED);
		unset($trail);
		$trail 	 = array();
		$trail[] =	'<a href="'.get_bloginfo('url').'" class="property-bread-crumb trail-begin">'.$home_label.'</a>';
	}
	return $trail;
}
function meta_tag_og() {
	if( is_page('property') ){
		$property = get_single_property_data();
		if($property){
			$current_site = get_option( 'blogname' );
			$current_site_desc = get_option( 'blogdescription' );
			$photo = get_single_property_photos();

			if( get_single_property_source() == 'crm' ){
				$photo = $property->getPhotoUrl($photo)[0];
			}elseif(get_single_property_source() == 'mls' ){
				$photo = $property->PrimaryPhotoUrl;
			}

			?>
			<meta property="og:image" content="<?php echo $photo ? $photo : PLUGIN_ASSET_URL . 'house.png';?>" />
			<meta property="og:latitude" content="<?php echo $property->latitude;?>" />
			<meta property="og:longitude" content="<?php echo $property->longitude;?>" />
			<meta property="og:site_name" content="<?php echo $current_site;?>" />
			<meta property="og:title" content="<?php echo $property->displayAddress();?> : <?php echo $current_site;?>" />
			<meta property="og:url" content="<?php echo $property->displayUrl();?>" />
			<meta property="og:description" content="<?php echo trim(strip_tags($property->displayDescription()));?>" />
			<?php
		}
	}
}
function md_meta(){
	$meta_desc = '';
	if( is_page('property') ){
		$property = get_single_property_data();
		if($property){
			$meta_desc = $property->displayAddress() . ' is a '.$property->displayPropertyType().' and is currently '.$property->displayPropertyStatus().' Listing. Located in '.$property->city.', has '.$property->baths.' full baths half with '.$property->beds.' bedrooms with with MLS Number: '.$property->mlsid.'';
		}
	}
	echo '<meta name="description" content="'.$meta_desc.'">';
}
add_action('wp_head','meta_tag_og',1,1);
add_action('wp_head','md_meta',2,1);
function wp_md_canonical($url) {
	if( function_exists( 'rel_canonical' ) ){
		if( !has_action('wpseo_canonical') ){
			remove_action( 'wp_head', 'rel_canonical' );
		}
	}
	if( is_page('property' ) ){
		$address = parse_query_callback();
		if( $address ){
			$url = $address['property']->displayUrl();
		}
		echo "<link rel='canonical' href='$url' />";
	}
}
add_action('wp_head', 'wp_md_canonical',3,1);
//activate only for customize purposes on per source
//add_filter('template_carousel_crm',	array('\crm\Layout_Property','get_carousel_template_crm'),10,1);
//add_filter('template_more_details_crm',	array('\crm\Layout_Property','get_template_more_details_crm'),10,1);

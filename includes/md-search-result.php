<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * get default view via settings
 * */
function get_setting_default_view(){
	return get_settings_by_key('view','type');
}
function get_query_view_uri(){
	$query_string = '';
	if( isset($_SERVER['QUERY_STRING']) ){
		$r = parse_url($_SERVER['QUERY_STRING']);
		parse_str($r['path'],$get_arr);
		unset($get_arr['view']);
		unset($get_arr['fullscreen']);
		if( count($get_arr) > 1 && isset($get_arr['location']) ){
			$query = '?' . http_build_query($get_arr) . '&';
		}else{
			$query = '?';
		}
	}
	return $query;
}
function md_search_uri_query($view_query_string){
	$query 	= get_query_view_uri();
	$uri 	= \Property_URL::get_instance()->get_search_page_default() . $query . $view_query_string;
	return $uri;
}
function get_current_view_query(){
	/**
	 * get current view via GET query string
	 * */
	$current_view = \Search_Result_View::get_instance()->view();
	/**
	 * get view in the setting page
	 * */
	$setting_view = get_setting_default_view();
	/**
	 * get current view first
	 * */
	if( $current_view ){
		return $current_view;
	}else{
		/**
		 * then get view via setting
		 * */
		if( $setting_view ){
			return $setting_view;
		}else{
			//view default in config
			return DEFAULT_VIEW_SEARCH_RESULT;
		}
	}
}
function is_fullscreen(){
	$fullscreen = 'n';
	if( isset($_GET['fullscreen']) ){
		$fullscreen = sanitize_text_field($_GET['fullscreen']);
	}
	return $fullscreen;
}

function show_fullscreen_button_map(){
	global $map_fullscreen;
	if(get_current_view_query() == 'map'){
		if( is_fullscreen() == 'n' ){
			?>
			<a href="<?php echo md_search_uri_query('view=map&fullscreen=y');?>" class="btn btn-primary active" data-url="<?php echo md_search_uri_query('view=map&fullscreen=y');?>">
				<span class="glyphicon glyphicon-fullscreen" aria-hidden="true" ></span> Show Map Full Screen
			</a>
			<?php
		}else{
			?>
			<a href="<?php echo md_search_uri_query('view=map&fullscreen=n');?>" class="btn btn-primary active" data-url="<?php echo md_search_uri_query('view=map&fullscreen=y');?>">
				<span class="glyphicon glyphicon-fullscreen" aria-hidden="true" ></span> Show normal map screen
			</a>
			<?php
		}
	}
}
function show_search_result_tools($atts, $show_sort){
	?>
	<div id="button-view" style="margin-bottom:10px;">
		<div class="btn-group" role="group" aria-label="...">
			<?php if( is_page('search-properties') ){ ?>
				<a class="btn btn-default <?php echo (get_current_view_query() == 'map') ? 'active':'';?>" href="<?php echo md_search_uri_query('view=map');?>" role="button"><span class="glyphicon glyphicon-map-marker" aria-hidden="true" ></span> Map View</a>
				<a class="btn btn-default <?php echo (get_current_view_query() == 'photo') ? 'active':'';?>" href="<?php echo md_search_uri_query('view=photo');?>" role="button"><span class="glyphicon glyphicon-th-large" aria-hidden="true" ></span> Photo View</a>
				<?php show_fullscreen_button_map(); ?>
			<?php } ?>
			<?php
				if( !is_front_page() && $show_sort ){
					\Action_Buttons::display_sort_button(array('class'=>'list-default'));
				}
				\Save_Search::get_instance()->display_button($atts);

			?>
		</div>
	</div>
	<?php
}
function get_search_limit(){
	return \MD_Search_Utility::get_instance()->search_limit();
}

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Load template
 * */
class MD_Template{
	protected static $instance = null;
	public $column_grid;

	public function __construct(){}

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

	public function get_list_template_desc($path, $str_replace_path = null){
		$files = \Masterdigm_Template::scandir($path, 'php');

		$header_array = array(
			'Template Name'=>'Template Name'
		);

		$template_file = array();
		if( count($files) > 0 ){
			foreach($files as $file){
				$get_file_data = \Masterdigm_Template::get_file_data($file, $header_array);
				$template_file[str_replace($str_replace_path, '', $file)] = $get_file_data['Template Name'];
			}
		}

		return $template_file;
	}

	/**
	 * @param	$list_only	string
	 * */
	public function get_theme_page_template($path, $str_replace_path, $list_only = null){
		$plugin_template_theme = array();
		if( trim($path) != '' ){
			$plugin_template 		= $this->get_list_template_desc($path, $str_replace_path);
			$plugin_template_theme 	= array();
			if( count($plugin_template) > 0 ){
				foreach($plugin_template as $key => $val ){
					if( !is_null($list_only) ){
						if( stripos($val, $list_only) !== false ){
							$plugin_template_theme[$key] = $val;
						}
					}else{
						$plugin_template_theme[$key] = $val;
					}
				}
			}
		}

		$wp_page_template 	= array();
		$wp_get_page_template 	= wp_get_theme()->get_page_templates();
		if( count($wp_get_page_template) > 0 ){
			foreach($wp_get_page_template as $key => $val){
				if( stripos($val,'Masterdigm') !== false ){
					$wp_page_template[$key] = $val;
				}
			}
		}
		return $plugin_template_theme + $wp_page_template;
	}

	public function load_template($template_file){
		if( file_exists(get_stylesheet_directory() .'/'. $template_file) ){
			$template = get_stylesheet_directory() .'/'. $template_file;
			return $template;
		}elseif( file_exists(GLOBAL_TEMPLATE . $template_file) ){
			//check in plugin
			$template = GLOBAL_TEMPLATE . $template_file;
			return $template;
		}
		return false;
	}

	public function set_col_grid($col = null){
		if( is_null($col) ){
			$this->column_grid = MD_DEFAULT_GRID_COL;
		}elseif( is_numeric($col) ){
			$this->column_grid = ceil(12 / $col );
		}
	}

	public function get_col_grid(){
		return $this->column_grid;
	}

	public function get_featured_img($obj_photos, $property_id){
		if( $obj_photos[$property_id][0]->result == 'success' ){
			if( $obj_photos[$property_id][0]->primary ){
				$img = $obj_photos[$property_id][0]->primary;
			}else{
				$img = current((array)$obj_photos[$property_id][0]->photos);
			}
		}
		return $img;
	}

	// we will get the default
	public function get_carousel_template($atts){
		$photos 			= get_single_property_photos();
		$template_carousel 	= \MD_Template::get_instance()->load_template($atts['template_carousel']);

		if( $template_carousel ){
			if( has_filter('global_template_carousel') ){
				$template_carousel = apply_filters('global_template_carousel',$atts);
			}
			require_once $template_carousel;
		}
	}

	public function label(){
		global $array_label;
		$label = $array_label;
		if( has_filter('append_label_array') ){
			$array_label 	= apply_filters('append_label_array',$array_label);
			$label 			= array_merge($label,$array_label);
		}
		return $label;
	}

	public function single_map($atts){
		require GLOBAL_TEMPLATE . 'single/partials/map/map.php';
	}

	public function single_walkscore($atts){
		require GLOBAL_TEMPLATE . 'single/partials/walkscore/walkscore.php';
	}

	public function single_photos($atts){
		require GLOBAL_TEMPLATE . 'single/partials/photos/photos.php';
	}
}

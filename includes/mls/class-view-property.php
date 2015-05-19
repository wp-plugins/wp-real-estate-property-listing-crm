<?php
namespace mls;
/**
 * @deprecated use Class Layout_Property / class-layout-property.php
 * Use as to handle templating for various views on each template
 * */
class View_Property{
	protected static $instance = null;

	public function __construct(){
	}

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
				$template_file[str_replace($str_replace_path, '', $file)] = \Masterdigm_Template::get_file_data($file, $header_array)['Template Name'];
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

	public function get_featured_img($obj_photos, $property_id){
		$img = PLUGIN_ASSET_URL . 'house.png';
		if( $obj_photos[$property_id][0]->result == 'success' ){
			if( $obj_photos[$property_id][0]->primary ){
				$img = $obj_photos[$property_id][0]->primary;
			}else{
				$img = current((array)$obj_photos[$property_id][0]->photos);
			}
		}
		return $img;
	}

	public function single_property_tab_label(){
		$tab_label = array(
			'property-details' => 'Property Details',
			'map-and-directions' => 'Map and Directions',
			'school-and-information' => 'School and Information',
			'walk-score' => 'Walk Score',
			'single-photos' => 'Photos',
			'video' => 'Video',
		);
		return $tab_label;
	}

}

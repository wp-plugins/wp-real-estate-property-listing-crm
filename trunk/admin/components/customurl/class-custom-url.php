<?php
/**
 * Choose URL for property, for instance:
 * - property/
 * - search-result/
 * - city/
 * - community/
 * - state
 * */
class Custom_URL{
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function get_all_page($exclude = array()){
		$args = array();
		if( is_array($exclude) && count($exclude) > 0 ){
			$args = array(
				'exclude' => $exclude
			);
		}
		return get_pages($args);
	}

	public function get_md_page_url($array_md_page = array()){
		$hook_array_md_page = array();
		$array_md_page = array(
			'property' 	=> array(
				'label' 	=> 'Property',
				'wp_object' => get_page_by_title('property'),
			),
			'search-result' => array(
				'label' 	=> 'Search Result',
				'wp_object' => get_page_by_title('search-result'),
			),
			'md-account' 	=> array(
				'label'		=>'MD Account',
				'wp_object' => get_page_by_title('md-account'),
			),
			'city' 			=> array(
				'label'		=> 'City',
				'wp_object' => get_page_by_title('city'),
			),
			'community' 	=> array(
				'label'		=>'Community',
				'wp_object' => get_page_by_title('community'),
			),
			'state' 		=> array(
				'label'		=>'State',
				'wp_object' => get_page_by_title('state'),
			),
			'county' 		=> array(
				'label'		=>'County',
				'wp_object' => get_page_by_title('county'),
			),
		);
		$hook_array_md_page = apply_filters('hook_array_md_page',$hook_array_md_page);
		$md_page_url_array 	= array_merge($array_md_page, $hook_array_md_page);
		return $md_page_url_array;
	}

	public function choose_url_property($page = null){
		if( is_null($page) ){
			if( get_page_by_title('property') ){
			}
		}
	}

	public function choose_url_search_result($page = null){
	}

	public function choose_url_dashboard($page = null){
	}

	public function choose_url_city($page = null){
	}

	public function choose_url_community($page = null){
	}

	public function choose_url_state($page = null){
	}

}

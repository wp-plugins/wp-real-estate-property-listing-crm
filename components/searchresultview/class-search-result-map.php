<?php
/**
 * Photo search result
 * */
class Search_Result_Map{
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	public $js_gmap_option;
	public $js_gmap_config;
	public $plugin_name;
	public $version;
	public $atts;
	public $property_data;

	public function __construct(){
		add_action('wp_ajax_get_properties_data_action', array($this,'get_properties_data_action_callback') );
		add_action('wp_ajax_nopriv_get_properties_data_action',array($this,'get_properties_data_action_callback') );
		add_action('wp_ajax_properties_data_action', array($this,'properties_data_action_callback') );
		add_action('wp_ajax_nopriv_properties_data_action',array($this,'properties_data_action_callback') );
		add_action('wp_ajax_get_single_property_action', array($this,'get_single_property_action_callback') );
		add_action('wp_ajax_nopriv_get_single_property_action',array($this,'get_single_property_action_callback') );
		$this->plugin_name 	= \Masterdigm_API::get_instance()->get_plugin_name();
		$this->version 	 	= \Masterdigm_API::get_instance()->get_version();
		$this->js_gmap_option	= array();
		$this->js_gmap_config	= array();
		add_filter('view_display_content_map', array($this,'init'), 10, 1);
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_filter('search_property_limit', array($this,'search_limit'), 10, 1);
		add_action('wp_footer', array($this,'js_init_gmap'));
	}

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

	private function _current_view(){
		return \Search_Result_View::get_instance()->view();
	}

	public function enqueue_scripts(){
		$view = $this->_current_view();
		if( is_page('search-properties') && $view == 'map' ){
			wp_enqueue_script( $this->plugin_name . '-map-view', plugin_dir_url( __FILE__ ) . 'js/map-view.js', array( 'jquery' ), $this->version, false );
		}
	}

	/**
	 * initialize the map config
	 * */
	public function js_init_gmap($other = array()){
		if( is_page('search-properties') ){
			?>
				<script>
					var is_search 		= 1;
					var gmap_option 	= {<?php echo array_to_js_obj($this->get_js_gmap_option());?>};
					var gmap_config 	= {<?php echo array_to_js_obj($this->get_js_gmap_config());?>};
				</script>
			<?php
		}
	}

	/**
	 * get google map options
	 * */
	public function get_js_gmap_option(){
		return $this->js_gmap_option;
	}

	/**
	 * set google map options
	 * */
	public function set_js_gmap_option($option_array = array()){
		$this->js_gmap_option = $option_array;
		array_merge($this->js_gmap_option, $option_array);
	}

	/**
	 * set google map config
	 * */
	public function set_js_gmap_config($config_array = array()){
		$this->js_gmap_config = $config_array;
		array_merge($this->js_gmap_config, $config_array);
	}

	/**
	 * get google map config
	 * */
	public function get_js_gmap_config(){
		return $this->js_gmap_config;
	}

	/**
	 * get properties data such as lat and lon
	 * */
	public function properties_data(){
		$data = array();
		if( have_properties() ){
			foreach(have_properties() as $p){
				set_loop($p);
				if(
					(md_get_lat() != 0 && md_get_lon() != 0)
					|| (md_get_lat() != '' && md_get_lon() != '')
				){
					$data[] = array(
						'name' => md_property_title(),
						'url' => md_property_url(),
						'lat' => md_get_lat(),
						'lng' => md_get_lon(),
						'id' => md_property_id(),
					);
				}
			}
		}
		return $data;
	}

	public function mls_search_data($search_data, $arr_search){
		$search_data['map_boundaries'] = $arr_search['map_boundaries'];
		return $search_data;
	}

	public function get_by_boudaries(){
		$boundaries = array(
			'ne_lat' => isset($_POST['ne_lat']) ? $_POST['ne_lat']:0,
			'ne_lng' => isset($_POST['ne_lng']) ? $_POST['ne_lng']:0,
			'sw_lat' => isset($_POST['sw_lat']) ? $_POST['sw_lat']:0,
			'sw_lng' => isset($_POST['sw_lng']) ? $_POST['sw_lng']:0
		);
		$arr =  array(
			'map_boundaries'		=>	$boundaries,
			'use_location_search'	=>	1,
			'return_query' 			=> 	1
		);
		return $arr;
	}

	public function get_properties_data(){
		return $this->property_data;
	}

	public function set_properties_data($property_data){
		$this->property_data = $property_data;
	}

	public function get_properties_data_action_callback(){
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ){
			check_ajax_referer( 'md-ajax-request', 'security' );
		}
		$status 	= true;
		$properties = $this->properties_data();
		$json_array = array(
			'status' 		=> $status,
			'properties' 	=> $this->get_properties_data()
		);
		echo json_encode($json_array);
		wp_die();
	}

	public function properties_data_action_callback(){
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ){
			check_ajax_referer( 'md-ajax-request', 'security' );
		}

		if(!defined('MAP_BOUNDARY')){
			$_REQUEST['limit'] = 1000;
		}

		add_filter('before_get_properties_search_query', array($this, 'get_by_boudaries') );

		$prop = apply_filters('search_property_result_' . DEFAULT_FEED, array());
		\MD\Property::get_instance()->set_properties($prop, DEFAULT_FEED);

		$json_array = array(
			'post' => $_POST,
			'prop' => $prop
		);

		$this->set_properties_data($prop);

		$list_part = \MD_Template::get_instance()->load_template('searchresult/threeviews/map/ajax_properties_html.php');
		require $list_part;
		wp_die();
	}

	public function properties_data_action_nopriv_callback(){
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ){
			check_ajax_referer( 'md-ajax-request', 'security' );
		}

		$json_array = array(
			'post' => 'no priv test'
		);
		echo json_encode($json_array);
	}

	public function search_limit($limit){
		$view = $this->_current_view();
		if( is_page('search-properties') && $view == 'map' ){
			if(!defined('MAP_BOUNDARY')){
				$limit = 1000;
			}else{
				$limit = 100;
			}
		}
		return $limit;
	}

	public function hook_view_before_thumbnail($property_id){
		?>
			<a href="javascript:void(0)" class="btn btn-default trigger" data-property-id="<?php echo $property_id;?>">Show This on Map</a>
		<?php
	}

	public function set_atts($atts = array()){
		$this->atts = $atts;
	}

	public function get_atts(){
		return $this->atts;
	}

	/**
	 * init map display
	 * */
	public function init($atts = array()){
		$this->set_atts($atts);
		//get the template
		$template_part = \MD_Template::get_instance()->load_template('searchresult/threeviews/map/map_index.php');
		if( $template_part ){
			extract($atts);
			require $template_part;
		}
		//create the js variables for gmap
		//$this->js_init_gmap();
	}

	public function get_single_property_click(){
		$property_id = 0;
		if( isset($_POST['marker']) && $_POST['marker'] != 0 ){
			$property_id = $_POST['marker'];
		}
		$clicked_marker = false;
		if( isset($_POST['click_marker']) && $_POST['click_marker'] == true ){
			$clicked_marker = true;
		}
		if(
			$property_id != 0
			&& $clicked_marker
		){
			$preview = get_property_details($property_id);
			\MD_Single_Property::get_instance()->setPropertyData($preview);
			$p = \MD_Single_Property::get_instance()->getPropertyData();
			\MD\Property::get_instance()->set_properties($p['property'],$p['source']);
			\MD\Property::get_instance()->set_loop($p['property']);
			//set_loop($data['property']);
			$list_part = \MD_Template::get_instance()->load_template('searchresult/threeviews/map/ajax_properties_overview.php');
			require $list_part;
		}//if isset post
	}

	public function get_single_property_action_callback(){
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ){
			check_ajax_referer( 'md-ajax-request', 'security' );
		}
		$this->get_single_property_click();
		wp_die();
	}

}

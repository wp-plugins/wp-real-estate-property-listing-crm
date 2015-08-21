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

	public function __construct(){
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
					var property_data 	= <?php echo json_encode($this->properties_data());?>;
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

	public function search_limit($limit){
		$view = $this->_current_view();
		if( is_page('search-properties') && $view == 'map' ){
			$limit = 50;
		}
		return $limit;
	}

	public function hook_view_before_thumbnail($property_id){
		?>
			<a href="javascript:void(0)" class="btn btn-default trigger" data-property-id="<?php echo $property_id;?>">Show This on Map</a>
		<?php
	}

	public function modal_fullscreen(){
		$template_part = \MD_Template::get_instance()->load_template('searchresult/threeviews/map/fullscreen_modal.php');
		if( $template_part ){
			require $template_part;
		}
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

}

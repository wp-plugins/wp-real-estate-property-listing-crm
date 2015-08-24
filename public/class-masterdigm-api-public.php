<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Masterdigm_API
 * @subpackage Masterdigm_API/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 * @author     Your Name <email@example.com>
 */
class Masterdigm_API_Public {

	protected static $instance = null;

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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

	public function get_plugin_name(){
		return $this->plugin_name;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/masterdigm-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-style-css', plugin_dir_url( __FILE__ ) . 'css/masterdigm-style.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-bootstrap-css', plugin_dir_url( __FILE__ ) . 'plugin/bootstrap/css/bootstrap.min.css' );
		wp_enqueue_style( $this->plugin_name . '-fontawesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css' );
		wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, '1.0');
	}

	public function load_async_js(){
		?>
		<script>
		(function(w, d, s) {
		  function go(){
			var js, fjs = d.getElementsByTagName(s)[0], load = function(url, id) {
			  if (d.getElementById(id)) {return;}
			  js = d.createElement(s); js.src = url; js.id = id;
			  fjs.parentNode.insertBefore(js, fjs);
			};
			load('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', 'googlemapjs');
		  }
		  if (w.addEventListener) { w.addEventListener("load", go, false); }
		  else if (w.attachEvent) { w.attachEvent("onload",go); }
		}(window, document, 'script'));
		</script>
		<?php
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'google-map', 'https://maps.googleapis.com/maps/api/js?v=3.20&sensor=false', array(), $this->version, true );
		//wp_enqueue_script( 'google-map', 'https://maps.googleapis.com/maps/api/js?v=3.20&key='.GOOGLE_PUBLIC_KEY.'', array(), $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-gmap-marker-cluster', plugin_dir_url( __FILE__ ) . 'js/markerclusterer.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-plugin-gmap3', plugin_dir_url( __FILE__ ) . 'js/gmap3.min_v6.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-bootstrap-js', plugin_dir_url( __FILE__ ) . 'plugin/bootstrap/js/bootstrap.min.js', array(), '3.0.0', true );
		wp_enqueue_script( $this->plugin_name . '-galleria', plugin_dir_url( __FILE__ ) . 'plugin/galleria/galleria-1.4.2.min.js' , array( 'jquery' ), true );
		wp_enqueue_script('thickbox',null,array('jquery'));
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('jquery-masonry',null,array('jquery'));
		wp_enqueue_script($this->plugin_name . '-localize-script');
		wp_enqueue_script( $this->plugin_name . '-typeahead', plugin_dir_url( __FILE__ ) . 'js/typeahead.bundle.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-localize-script-public', plugin_dir_url( __FILE__ ) . 'js/masterdigm-public-min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-search', plugin_dir_url( __FILE__ ) . 'js/search-public.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-single', plugin_dir_url( __FILE__ ) . 'js/masterdigm-single-property-public-min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-infinite-scroll', plugin_dir_url( __FILE__ ) . 'js/infinite_scroll.js', array( 'jquery' ), $this->version, true );
		// localize
		$settings = get_option('plugin-settings');

		$masonry = 0;
		if( ( isset($settings['js']) && isset($settings['js']['masonry']) ) ){
			$masonry = 1;
		}
		wp_localize_script( $this->plugin_name . '-localize-script-public',
			'MDAjax',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'security' => wp_create_nonce( 'md-ajax-request' ),
				'ajax_indicator' => PLUGIN_ASSET_URL . 'ajax-loader-big-circle.gif',
				'masonry_container' => 'search-result',
				'masonry'	=>	$masonry,
				'fb_key'	=>	\Social_API::get_instance()->getSocialApiByKey('facebook','id'),
			)
		);
	}

}

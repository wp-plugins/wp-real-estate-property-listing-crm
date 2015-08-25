<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * This is use to update public design changes
 *
 *
 *
 * @package MD_Single_Property
 * @author  masterdigm / Allan
 */
class MD_Search_Utility {
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	public function __construct(){
		add_action( 'wp_ajax_pagination_scroll_action', array($this,'pagination_scroll_action_callback') );
		add_action( 'wp_ajax_nopriv_pagination_scroll_action',array($this,'pagination_scroll_action_callback') );
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

	public function pagination_scroll_action_callback(){
		check_ajax_referer( 'md-ajax-request', 'security' );
		//get source via url
		$api_result = array(
			'search_data' 	=> '',
			'properties' 	=> array(),
			'source' 		=> ''
		);
		$source_api = '';
		if( isset($_REQUEST['source']) ){
			$source_api = $_REQUEST['source'];
		}else{
			$source_api = DEFAULT_FEED;
		}
		if( $source_api ){
			$source = sanitize_text_field($source_api);
			$request = $_POST;

			$api_result = apply_filters('search_utility_by_' . $source, $request);

			\MD\Property::get_instance()->set_properties($api_result['properties'], $api_result['source']);

			$att_template = CRM_DEFAULT_SEARCH_RESULT_SCROLL;
			// hook filter, incase we want to just use hook
			if( has_filter('shortcode_search_result_scroll_' . $source) ){
				$att_template = apply_filters('shortcode_search_result_scroll_' . $source, $path);
			}

			// check if its from template
			if( file_exists(get_stylesheet_directory() .'/'. $att_template) ){
				$template = get_stylesheet_directory() .'/'. $att_template;
			}elseif( file_exists($att_template) ){
				//check in plugin
				$template = $att_template;
			}

			if( isset($_POST['col']) && is_numeric($_POST['col']) ){
				$col = $_POST['col'];
			}
			if( isset($_POST['grid_col']) ){
				$col = $_POST['grid_col'];
			}

			$current_paged = ($this->get_paged());
			if( isset($_POST['current_query_url']) ){
				$atts['url'] = array(
					'current_query_url'	=>	$_POST['current_query_url'],
					'current_site_url'	=>	$_POST['current_site_url'],
					'current_page'		=>	$_POST['current_page']
				);
			}
			require $template;
		}
		die();
	}

	public function set_request_property($request = null){
		global $wp_rewrite;
		if( is_null($request) ){
			$request = array();
			$url 	= parse_url($_SERVER['QUERY_STRING']);
			$query 	= explode('&',$url['path']);

			foreach($query as $key => $val){
				$array_val = explode('=', $val);
				if( $array_val[0] == 'location' && isset($array_val[1]) ){
					$request['location'] = $array_val[1];
				}else{
					if( isset($array_val[1]) ){
						$request[$array_val[0]] = $array_val[1];
					}
				}
			}

			return $request;
		}
		$request['paged'] = $this->get_paged();
		return $request;
	}

	public function get_paged(){
		$paged = 1;
		if( isset($_REQUEST['paged']) ){
			$paged = $_REQUEST['paged'];
		}elseif( get_query_var( 'paged' ) ){
			$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ):$paged;
		}
		return $paged;
	}

	public function set_next_page_url(){
		$next_page_url = '';
		$next_page_url =  get_pagenum_link($this->get_paged() + 1);
		return str_replace('#038;','',$next_page_url);
	}

	public function js_var_search_data($arr_properties_data, $att_short_code, $request = null, $other_option = array()){
		global $post;

		if( is_null($request) ){
			$request = $this->set_request_property();
		}

		$next_pagination = $this->set_next_page_url();

		$infinite = 0;
		if( isset($att_short_code['infinite']) && $att_short_code['infinite'] ) {
			$infinite = 1;
		}
		if( isset($att_short_code['source']) && $att_short_code['source'] ) {
			$request['source'] = $att_short_code['source'];
		}
		$selector 			= $other_option['selector'];
		$infinite_result 	= $other_option['ajax_display'];
		dump($request);
		if( count($arr_properties_data) > 0 || $arr_properties_data->total > 0 ){
			?>
				<script>
					var search_property_result 	= <?php echo $arr_properties_data->total ? $arr_properties_data->total:0;?>;
					var infinite_scroll 		= <?php echo $infinite;?>;
					var col 					= <?php echo isset($att_short_code['col']) ? $att_short_code['col']:$other_option['col'];?>;
					var infinite_selector		= '<?php echo $selector;?>';
					var wp_var = [
						{name:'current_query_url', value:'<?php echo isset($att_short_code['server_query_string'])?$att_short_code['server_query_string']:''; ?>'},
						{name:'current_site_url', value:'<?php echo isset($att_short_code['site_url'])?$att_short_code['site_url']:''; ?>'},
						{name:'current_page', value:'<?php echo $post->post_name;?>'},
						{name:'next_url_page', value:'<?php echo $next_pagination;?>'},
						{name:'grid_col', value:'<?php echo isset($att_short_code['col']) ? $att_short_code['col']:$other_option['col'];?>'},
						{name:'infinite_result', value:'<?php echo $infinite_result;?>'},
						<?php if(count($request) > 0 ) { ?>
							<?php foreach($request as $key=>$val) { ?>
									{name:'<?php echo $key;?>', value:'<?php echo $val;?>'},
							<?php } ?>
						<?php } ?>
						<?php if(count($other_option) > 0 ) { ?>
							<?php foreach($other_option as $key=>$val) { ?>
									{name:'<?php echo $key;?>', value:'<?php echo $val;?>'},
							<?php } ?>
						<?php } ?>
					];
				</script>
			<?php
		}
	}

	public function get_price_range(){
		$vlow 		= $this->form_price_range_vlow();
		if( has_filter('filter_price_range_vlow') ){
			$vlow = apply_filters('filter_price_range_vlow', $vlow);
		}
		$low 		= $this->form_price_range_low();
		if( has_filter('filter_price_range_low') ){
			$low = apply_filters('filter_price_range_low', $low);
		}
		$mid 		= $this->form_price_range_mid();
		if( has_filter('filter_price_range_mid') ){
			$mid = apply_filters('filter_price_range_mid', $mid);
		}
		$high 		= $this->form_price_range_high();
		if( has_filter('filter_price_range_high') ){
			$high = apply_filters('filter_price_range_high', $high);
		}
		$extreme 	= $this->form_price_range_extreme();
		if( has_filter('filter_price_range_extreme') ){
			$extreme = apply_filters('filter_price_range_extreme', $extreme);
		}
		$insane 	= $this->form_price_range_insane();
		if( has_filter('filter_price_range_insane') ){
			$insane = apply_filters('filter_price_range_insane', $insane);
		}
		$over 		= $this->form_price_range_over();
		if( has_filter('filter_price_range_over') ){
			$over = apply_filters('filter_price_range_over', $over);
		}

		$custom	= array();
		if( has_filter('filter_price_range_custom') ){
			$custom = apply_filters('filter_price_range_custom', $custom);
		}
		return array_merge($vlow,$low,$mid,$high,$extreme,$insane,$over,$custom);
	}

	/**
	 * price range very low
	 * */
	public function form_price_range_vlow(){
		$from = 100;
		$to	  = 10000;
		$step = 500;
		return \helpers\Text::create_array_range($from, $to, $step);
	}

	/**
	 * price range low
	 * */
	public function form_price_range_low(){
		$from = 10000;
		$to	  = 50000;
		$step = 1000;
		return \helpers\Text::create_array_range($from, $to, $step);
	}

	/**
	 * price range mid
	 * */
	public function form_price_range_mid(){
		$from = 60000;
		$to	  = 100000;
		$step = 10000;
		return \helpers\Text::create_array_range($from, $to, $step);
	}

	/**
	 * price range high
	 * */
	public function form_price_range_high(){
		$from = 150000;
		$to	  = 900000;
		$step = 25000;
		return \helpers\Text::create_array_range($from, $to, $step);
	}

	/**
	 * price range extreme
	 * */
	public function form_price_range_extreme(){
		$from = 1250000;
		$to	  = 5000000;
		$step = 250000;
		return \helpers\Text::create_array_range($from, $to, $step);
	}

	/**
	 * price range insane
	 * */
	public function form_price_range_insane(){
		$from = 5500000;
		$to	  = 10000000;
		$step = 500000;
		return \helpers\Text::create_array_range($from, $to, $step);
	}

	/**
	 * price range over
	 * */
	public function form_price_range_over(){
		$from = 10000000;
		$to	  = 20000000;
		$step = 1000000;
		return \helpers\Text::create_array_range($from, $to, $step);
	}

	public function search_limit($limit = 10){
		$limit = apply_filters('search_property_limit', $limit);
		return $limit;
	}
}


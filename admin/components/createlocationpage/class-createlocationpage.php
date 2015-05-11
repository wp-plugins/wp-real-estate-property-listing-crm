<?php
class Create_Location_Page{
	protected static $instance = null;
	private $plugin_name;
	private $version;
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

	public function __construct(){
		$this->plugin_name 	= \Masterdigm_API::get_instance()->get_plugin_name();
		$this->version 	 	= \Masterdigm_API::get_instance()->get_version();
		$this->prefix 		= 'create-page-location';
		$this->slug 		= 'admin.php?page=md-api-create-page-location';
		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action('admin_menu', array( $this, 'add_plugin_admin_menu' ) );
		add_action('wp_ajax_create_location_page_action', array($this,'create_location_page_action_callback') );
		add_action('wp_ajax_nopriv_create_location_page_action',array($this,'create_location_page_action_callback') );
	}

	public function enqueue_scripts(){
		wp_enqueue_script( $this->plugin_name . '-createlocationpage', plugin_dir_url( __FILE__ ) . 'js/createlocationpage.js', array( 'jquery' ), $this->version, true );
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {
		$plugin_name = \Masterdigm_API::get_instance()->get_plugin_name();
		add_submenu_page(
			$plugin_name,
			'Create page base on location',
			'Create page base on location',
			'manage_options',
			'md-api-create-page-location',
			array( $this, 'controller' )
		);
	}

	public function controller(){
		$request = '';
		if( isset($_REQUEST['action']) ){
			$request = sanitize_text_field($_REQUEST['action']);
		}
		$obj_admin_util = new Masterdigm_Admin_Util;
		switch($request){
			case 'create_page':

			break;
			default:
				$this->displayIndex();
			break;
		}
	}

	/**
	 * list the data
	 * */
	public function displayIndex(){
		$log 	 = $this->parse_option_log();
		$raw_log = $this->get_option_log();

		$notice = 'Create pages base on the market coverage you choose in CRM.<br>';
		$notice .= 'You can set the status of the page default is Publish <br>';
		$button = 'Create Page by Location';
		$status = array(
			'publish' => 'Publish',
			'draft'   => 'Draft',
		);
		$option_name = '';
		if( $log->total > 0 ){
			$last_log = end($raw_log);
			$option_name = $last_log->option_name;

			$notice = 'It seems you have already create pages by location.<br>';
			$notice .= 'you can set status of the pages, If you want to update the pages re-run it and it will auto detect those locations you add in the CRM<br>';
			$notice .= 'You can also set status or delete it ( not the delete is force, it will not mark as trash ) it will remove those last pages you created ( check the date below "last activity" )<br>';
			$button = 'Update Page';
			$status = array(
				'publish' => 'Publish',
				'draft'   => 'Draft',
				'trash'	  => 'Trash'
			);
		}
		require_once( plugin_dir_path( __FILE__ ) . 'view/add.php' );
	}

	public function create_location_page_action_callback(){
		check_ajax_referer( 'md-ajax-request', 'security' );
		$current_user = wp_get_current_user();

		$msg 	= '';
		$status = false;

		$page_location 	= array();
		$account 		= \CRM_Account::get_instance()->get_coverage_lookup();
		$shortcode_tag 	= \md_sc_crm_list_properties::get_instance()->get_shortcode_tag();
		$shortcode_list_community 	= \md_sc_crm_get_locations::get_instance()->get_shortcode_tag();

		if( isset($account->result) == 'success' ){
			$locations 	= $account->lookups;
			if( count($locations) > 0 ){

				$post_status = 'publish';
				if( isset($_POST['post_status']) ){
					$post_status = sanitize_text_field($_POST['post_status']);
				}

				$page_location['total']	= count($locations);
				$count = 0;

				wp_defer_term_counting( true );
				wp_defer_comment_counting( true );

				foreach($locations as $key => $val){
					$content_shortcode = '';
					$page_location['date_added'] 	= date("F j, Y, g:i a");
					list($title_location) = explode(',',$val->full);
					$page_location[$val->id]['full'] 			= $title_location;
					$page_location[$val->id]['location_type'] 	= $val->location_type;
					$page_location[$val->id]['id'] 				= $val->id;

					$location = $page_location[$val->id]['location_type'].'id';
					$id = $page_location[$val->id]['id'];

					if( $val->location_type == 'city' ){
						$content_shortcode 	= '['.$shortcode_list_community.' cityid="'.$id.'"]'.'<br>';
					}
					$content_shortcode .= '['.$shortcode_tag.' '.$location.'="'.$id.'" limit="11" template="list/default/list-default.php" col="4" infinite="true"]';

					$page_location[$val->id]['shortcode'] = $content_shortcode;

					$post_insert_arg = array(
					  'post_title'    => $page_location[$val->id]['full'],
					  'post_content'  => $page_location[$val->id]['shortcode'],
					  'post_status'   => $post_status,
					  'post_author'   => $current_user->ID,
					  'post_type'	  => 'page',
					);
					$post = get_page_by_title($page_location[$val->id]['full']);

					$page_location['count']	= $count++;

					if( $post && $post_status == 'trash' ){
						wp_delete_post($post->ID, true);
					}elseif( $post_status == 'draft' || $post_status == 'publish' ){

						if( $post ){
							$post_arg = array(
								'ID' => $post->ID,
								'post_status' => $post_status
							);
							wp_update_post( $post_arg );
						}else{
							wp_insert_post( $post_insert_arg );
						}
					}

				}

				wp_defer_term_counting( false );
				wp_defer_comment_counting( false );

				$option_name = 'create_page_by_location_'.date("m.d.Y.H.i.s");
				$date 		 = date("F j, Y, g:i a");
				$option_value = array(
					'data'=>$page_location,
					'date'=>$date
				);
				update_option($option_name, $option_value);
				$msg = 'Done, total '.$post_status.' page : '.$option_value['data']['count'];
				$status = true;
			}
		}
		echo json_encode(array('msg'=>$msg,'status'=>$status));
		die();
	}

	public function get_option_log(){
		global $wpdb;
		$sql = "SELECT * FROM $wpdb->options WHERE option_name like '%create_page_by_location_%'";
		return $wpdb->get_results($sql);
	}

	public function parse_option_log(){
		$parse_log = array(
			'total' => 0
		);
		$log = $this->get_option_log();
		foreach($log as $key => $val){
			$parse_log['total'] += 1;
			$date_added = unserialize($val->option_value);
			$parse_log['data'][] = array(
				'total' => $date_added['data']['total'],
				'date' 	=> $date_added['data']['date_added']
			);
		}
		return json_decode(json_encode($parse_log), FALSE);
	}
}

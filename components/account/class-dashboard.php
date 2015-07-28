<?php
/**
 * Plugin class.
 * Class to change subscriber dashboard
 * @see http://codex.wordpress.org/Post_Types
 *
 *
 *
 * @package MD_CPT
 * @author  Masterdigm / Allan
 */
class Account_Dashboard {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	protected $md_query_vars;

	public $option_key = 'md_account_dashboard';

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
		add_action( 'init', array($this,'run') );
		add_action( 'init', array($this,'get_dashboard_page') );
		add_action( 'wp_before_admin_bar_render', array( $this, 'modify_wp_admin_bar' ) );
		if( !current_user_can('activate_plugins') ){
			add_action( 'wp_before_admin_bar_render', array( $this, 'subscriber_modify_wp_admin_bar' ) );
		}elseif(current_user_can('activate_plugins')){
			add_action( 'wp_before_admin_bar_render', array( $this, 'admin_modify_wp_admin_bar' ) );
		}
		add_action( 'admin_init', array($this,'redirect_subscriber') );
		add_action( 'template_redirect', array($this,'md_set_query_var') );
	}


	public function run(){
		$this->create_my_account_page();
		$this->set_url();
	}


	private function set_url(){
		$md_account_url = $this->get_dashboard_page();
		if( $md_account_url ){
			add_rewrite_rule(
				'^'.$md_account_url->post_name.'/([^/]*)/?$',
				'index.php?pagename='.$md_account_url->post_name.'&action=$matches[1]',
				'top'
			);
			add_rewrite_rule(
				'^'.$md_account_url->post_name.'/([^/]*)/([^/]*)/?$',
				'index.php?pagename='.$md_account_url->post_name.'&action=$matches[1]&task=$matches[2]',
				'top'
			);
			add_rewrite_tag('%action%', '([^&]+)');
			add_rewrite_tag('%task%', '([^&]+)');
			if( count($_REQUEST) > 0 ){
				foreach($_REQUEST as $key=>$val){
					add_rewrite_tag('%'.$key.'%', '([^&]+)');
				}
			}
		}
	}

	public function md_set_query_var($query_vars){
		global $wp_query;

		$md_query = array();
		$action = false;
		$task = false;

		if( get_query_var('action') ){
			if( get_query_var('action') ){
				$action = get_query_var('action');
			}
			if( get_query_var('task') ){
				$task = get_query_var('task');
			}
		}else{
			if( isset($query_vars['action']) ){
				$action = $query_vars['action'];
			}
			if( isset($query_vars['task']) ){
				$task = $query_vars['task'];
			}
		}

		$md_query = array(
			'action'=>$action,
			'task'=>$task,
		);

		$this->md_query_vars = \helpers\Text::array_to_object($md_query);
	}

	//move this to a centralize class
	public function md_get_query_vars(){
		return $this->md_query_vars;
	}

	public function get_option_key(){
		return $this->option_key;
	}

	public function set_option_dashboard($value){
		$key = $this->get_option_key();
		update_option($key, $value);
	}

	public function get_option_dashboard(){
		$key = $this->get_option_key();
		return get_option($key);
	}

	public function create_my_account_page(){
		if( !get_page_by_title('My Account') ){
			$shortcode = \Subscriber_Shortcode::get_instance()->get_shortcode();
			$post = array(
			  'post_title'    => 'My Account',
			  'post_content'  => $shortcode,
			  'post_status'   => 'publish',
			  'post_author'   => $get_user_id,
			  'post_type'	  => 'page',
			);
			$wp_insert_post = wp_insert_post( $post );
			$this->set_option_dashboard($wp_insert_post);
		}
	}

	public function get_dashboard_page(){
		if( get_page_by_title('My Account') ){
			$my_account = get_page_by_title('My Account');
			return $my_account;
		}else{
			return false;
		}
	}

	public function get_url(){
		$dashboard = $this->get_dashboard_page();
		return get_permalink($dashboard->ID);
	}

	public function navigation($data = array()){
		extract($data);
		$query = $this->md_get_query_vars();
		$action = $query->action;
		require_once PLUGIN_VIEW . 'account/partials/nav.php';
	}

	public function template(){
		return PLUGIN_VIEW . 'account/main.php';
	}

	public function content($ret = false){
		if( $ret ){
			return $this->template();
		}else{
			include_once $this->template();
		}
	}

	public function route(){
		$route = '';
		if( isset($_REQUEST['route']) ){
			$route = sanitize_text_field($_REQUEST['route']);
		}elseif( isset($_GET['route']) ){
			$route = sanitize_text_field($_GET['route']);
		}elseif( isset($_POST['action']) ){
			$route = sanitize_text_field($_POST['route']);
		}

		if( has_filter("dashboard_content_{$route}") ){
			apply_filters("dashboard_content_{$route}");
		}
	}

	public function redirect_subscriber(){
		if ( ! defined( 'DOING_AJAX' ) ) {
			$current_user   = wp_get_current_user();
			if( isset($current_user->roles[0]) && 'subscriber' === $current_user->roles[0] ){
				$role_name      = $current_user->roles[0];
				wp_redirect( $this->get_url() );
			}// if $role_name
		} // if DOING_AJAX
	}

	private function _remove_links_wp_admin_bar($obj_wp_admin_bar){
		$obj_wp_admin_bar->remove_menu('logout');
		$obj_wp_admin_bar->remove_menu('edit-profile');
		$obj_wp_admin_bar->remove_menu('user-info');
		$obj_wp_admin_bar->remove_menu('wp-logo');
		$obj_wp_admin_bar->remove_menu('my-sites');
		$obj_wp_admin_bar->remove_menu('my-sites-list');
		$obj_wp_admin_bar->remove_menu('site-name');
		$obj_wp_admin_bar->remove_node('my-sites');
		$obj_wp_admin_bar->remove_node('search');
	}

	private function _add_links_wp_admin_bar($obj_wp_admin_bar){
		$this->_add_link_my_property($obj_wp_admin_bar);
	}

	public function subscriber_modify_wp_admin_bar(){
		global $wp_admin_bar;

		$wp_admin_bar->remove_menu('logout');
		$wp_admin_bar->remove_menu('edit-profile');
		$wp_admin_bar->remove_menu('user-info');
		$wp_admin_bar->remove_menu('wp-logo');
		$wp_admin_bar->remove_menu('my-sites');
		$wp_admin_bar->remove_menu('my-sites-list');
		$wp_admin_bar->remove_menu('site-name');
		$wp_admin_bar->remove_node('my-sites');
		$wp_admin_bar->remove_node('search');

		$my_account = $wp_admin_bar->get_node('my-account');

		$wp_admin_bar->add_node( array(
			'id' => 'my-account',
			'href'=>\Account_Profile::get_instance()->url(),
		));
        $wp_admin_bar->add_menu( array(
			'parent' => 'user-actions', // use 'false' for a root menu, or pass the ID of the parent menu
			'id' => 'md_profile', // link ID, defaults to a sanitized title value
			'title' => __('Edit Profile'), // link title
			'href' => \Account_Profile::get_instance()->url(), // name of file
			'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
		));
		$wp_admin_bar->add_menu( array(
            'parent'=> 'user-actions',
            'id'    => 'md_account_logout',
            'title' => __( 'Log Out' ),
            'href'  => wp_logout_url()
        ));
	}

	public function admin_modify_wp_admin_bar(){
		global $wp_admin_bar;
	}

	public function modify_wp_admin_bar(){
		global $wp_admin_bar;

		$my_account = $wp_admin_bar->get_node('my-account');

		$wp_admin_bar->add_node( array(
			'id' => 'my-account',
			'href'=>\Account_Profile::get_instance()->url(),
		));

        $wp_admin_bar->add_menu( array(
			'parent' => 'user-actions', // use 'false' for a root menu, or pass the ID of the parent menu
			'id' => 'favorite', // link ID, defaults to a sanitized title value
			'title' => __('Favorites'), // link title
			'href' => \Favorites_Property::get_instance()->url(), // name of file
			'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
		));

        $wp_admin_bar->add_menu( array(
			'parent' => 'user-actions', // use 'false' for a root menu, or pass the ID of the parent menu
			'id' => 'xout', // link ID, defaults to a sanitized title value
			'title' => __('X-Out'), // link title
			'href' => \Xout_Property::get_instance()->url(), // name of file
			'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
		));

        $wp_admin_bar->add_menu( array(
			'parent' => 'user-actions', // use 'false' for a root menu, or pass the ID of the parent menu
			'id' => 'save_search', // link ID, defaults to a sanitized title value
			'title' => __('Save Search'), // link title
			'href' => \Dashboard_Save_Search::get_instance()->url(), // name of file
			'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
		));

        /*$wp_admin_bar->add_menu( array(
			'parent' => 'user-actions', // use 'false' for a root menu, or pass the ID of the parent menu
			'id' => 'property_alert', // link ID, defaults to a sanitized title value
			'title' => __('Property Alert'), // link title
			'href' => '', // name of file
			'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
		));*/
	}
}

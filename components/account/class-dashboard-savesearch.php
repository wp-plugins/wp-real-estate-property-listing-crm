<?php
class Dashboard_Save_Search extends Account_Dashboard{
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

	public function __construct(){
		add_filter( 'dashboard_content_savesearch', array($this,'controller'),10, 1 );
	}

	public function get_dashboard_page(){
		if( parent::get_instance()->get_dashboard_page() ){
			return parent::get_instance()->get_dashboard_page();
		}
	}

	public function url(){
		if( $this->get_dashboard_page() ){
			return get_permalink($this->get_dashboard_page()->ID).'savesearch';
		}
	}

	public function controller($args){
		global $wp_query;
		$user_account = wp_get_current_user();
		$arr_action = parent::get_instance()->md_get_query_vars();
		$redirect = $this->url();
		$action_args = $arr_action;

		$action = '';
		if( isset($arr_action->action) ){
			$action = $arr_action->action;
		}
		$task = '';
		if( isset($arr_action->task) ){
			$task = $arr_action->task;
		}
		if( isset($_GET['_nonce']) ){
			$nonce 		= sanitize_text_field($_GET['_nonce']);
		}
		switch($task){
			case 'update_save_search':
				if( isset($_POST['save_search_name']) ){
					$post_umeta_key = $_POST['save_search_name'];
					$meta_key 		= 'save-search-';
					foreach($post_umeta_key as $key => $val){
						$get_umeta_key = \Save_Search::get_instance()->get_save_search($key,true);
						$get_umeta_key['save_search_name'] = $val;
						update_user_meta( $user_account->ID, $get_umeta_key['user_meta_name'], $get_umeta_key );
					}
				}
				\Masterdigm_Admin_Util::get_instance()->redirect_to($redirect);
			break;
			case 'subscribe':
				$key = sanitize_text_field($_GET['id']);
				$nonce = sanitize_text_field($_GET['_nonce']);
				$redirect = $this->url();
				if(wp_verify_nonce( $nonce, $task.'-saved-search-'. $key . $user_account->ID ) ){
					$umeta_key = get_user_meta( $user_account->ID, 'save-search-'.$key, 1 );
					if( $umeta_key ){
						$p_alert = \Property_Alert::get_instance()->subscribe_property_alert($umeta_key);
						if($p_alert->result == 'success'){
							if( !isset($umeta_key['subscribed_property_alert']) ){
								$umeta_key['subscribed_property_alert'] = 1;
								$umeta_key['ret_property_alert'] = $p_alert;
								if( update_user_meta( $user_account->ID, $umeta_key['user_meta_name'], $umeta_key ) ){
									\Save_Search::get_instance()->increment_search_counter($umeta_key['md5_save_search_name']);
								}
							}
						}
					}
				}
				\Masterdigm_Admin_Util::get_instance()->redirect_to($redirect);
			break;
			case 'unsubscribe':
				$key 		= sanitize_text_field($_GET['id']);
				$nonce 		= sanitize_text_field($_GET['_nonce']);
				if(wp_verify_nonce($nonce, $task.'-saved-search-'. $key . $user_account->ID) ){
					$umeta_key = get_user_meta($user_account->ID, 'save-search-'.$key, 1);
					if( $umeta_key ){
						$umeta_key['subscribed_property_alert'] = 0;
						update_user_meta( $user_account->ID, $umeta_key['user_meta_name'], $umeta_key );
					}
				}
				\Masterdigm_Admin_Util::get_instance()->redirect_to($redirect);
			break;
			case 'unsubscribe-all':
				if(wp_verify_nonce($nonce, 'un-subscribe-all-' . $user_account->ID) ){
					$unsubscribe = \Property_Alert::get_instance()->crm_unsubscribe($user_account->user_email);
				}
				\Masterdigm_Admin_Util::get_instance()->redirect_to($redirect);
			break;
			case 'trash':
				$key 		= sanitize_text_field($_GET['id']);
				$nonce 		= sanitize_text_field($_GET['_nonce']);
				if(wp_verify_nonce($nonce, 'trash-saved-search-'. $key . $user_account->ID) ){
					$umeta_key = get_user_meta($user_account->ID,'save-search-'.$key);
					if( $umeta_key ){
						if( delete_user_meta($user_account->ID, 'save-search-'.$key) ){
							\Save_Search::get_instance()->decrement_search_counter($key);
							\Masterdigm_Admin_Util::get_instance()->redirect_to($redirect);
						}
					}
				}
				\Masterdigm_Admin_Util::get_instance()->redirect_to($redirect);
			break;
			default:
				$this->display_save_search();
			break;
		}
	}

	public function display_save_search(){
		$db_save_search 	= $this->get_db_save_search();
		$user_account 		= wp_get_current_user();
		$has_saved_search 	= false;
		$search_data		= array();
		$redirect = $this->url();
		if( count($db_save_search) > 0 && $db_save_search ){
			foreach($db_save_search as $key_db => $val_db){
				$search_data[$val_db->umeta_id] 	= unserialize($val_db->meta_value);
			}
			$has_saved_search = true;
		}

		require_once PLUGIN_VIEW . 'account/partials/save-search-list.php';
	}

	public function get_db_save_search(){
		global $wpdb;
		$user_account = wp_get_current_user();
		$query = "SELECT * FROM $wpdb->usermeta	WHERE user_id = {$user_account->ID} AND meta_key LIKE '%save-search-%'";
		return $wpdb->get_results( $query, OBJECT );
	}
}

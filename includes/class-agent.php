<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class MD_Agent{
	protected static $instance = null;

	public $set_agent_data;

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

	public function set_agent_data($data = null){
		$agent 		= array();
		$agent_id 	= 0;
		if( isset($data['agent']) ){
			$agent_info = $data['agent'];
		}else{
			if( !isset($data->agent) && isset($data['property']->assigned_to) ){
				$agent_id = $data['property']->assigned_to;
			}else{
				$agent_info = \CRM_Account::get_instance()->get_account_data();
				$agent_id 	= $agent_info->userid;
			}
			$get_agent_info = \CRM_Account::get_instance()->get_agent_details($agent_id);

			if( $get_agent_info->result == 'success' ){
				$agent_info 	= \crm\Agent_Entity::get_instance()->bind( $get_agent_info->data );
			}
		}

		$this->set_agent_data = $agent_info;
	}

	public function get_data(){
		return $this->set_agent_data;
	}

	public function get_photo(){
		return $this->set_agent_data->get_photo();
	}

	public function get_name(){
		return $this->set_agent_data->get_name();
	}

	public function get_company(){
		return $this->set_agent_data->get_company();
	}

	public function get_phone(){
		return $this->set_agent_data->get_phone();
	}

	public function get_mobile_num(){
		return $this->set_agent_data->get_mobile_num();
	}

	public function get_email(){
		return $this->set_agent_data->get_email();
	}

	public function get_website(){
		return $this->set_agent_data->get_website();
	}

	public function get_facebook(){
		return $this->set_agent_data->get_fb();
	}

	public function get_twitter(){
		return $this->set_agent_data->get_twitter();
	}

	public function get_linkedin(){
		return $this->set_agent_data->get_linkedin();
	}

	public function get_youtube(){
		return $this->set_agent_data->get_youtube();
	}

}

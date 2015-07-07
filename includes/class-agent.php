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
		$agent = array();

		if( !isset($data['property']->assigned_to) ){
			$agent_info = \CRM_Account::get_instance()->get_account_data();
		}elseif( isset($data['property']->assigned_to) ){
			$assign_to = $data['property']->assigned_to;
			$get_agent_info = \CRM_Account::get_instance()->get_agent_details($assign_to);
			if( $get_agent_info->result == 'success' ){
				$agent_info = $get_agent_info->data;
			}
		}

		$agent['img'] = PLUGIN_ASSET_URL . 'agent-blank.jpg';
		if( isset($agent_info->company_logo) && $agent_info->company_logo != '' ){
			$agent['img'] = $agent_info->company_logo;
		}

		$agent['manager_first_name'] = '';
		if( isset($agent_info->manager_first_name) && $agent_info->manager_first_name != '' ){
			$agent['manager_first_name'] = $agent_info->manager_first_name;
		}

		$agent['manager_last_name'] = '';
		if( isset($agent_info->manager_last_name) && $agent_info->manager_last_name != '' ){
			$agent['manager_last_name'] = $agent_info->manager_last_name;
		}

		$agent['full_name'] = $agent['manager_first_name'].' '.$agent['manager_last_name'];

		$agent['company'] = '';
		if( isset($agent_info->company) && $agent_info->company != '' ){
			$agent['company'] = $agent_info->company;
		}

		$agent['work_phone'] = '';
		if( isset($agent_info->work_phone) && $agent_info->work_phone != '' ){
			$agent['work_phone'] = $agent_info->work_phone;
		}

		$agent['manager_email'] = '';
		if( isset($agent_info->manager_email) && $agent_info->manager_email != '' ){
			$agent['manager_email'] = $agent_info->manager_email;
		}

		$agent['website'] = '';
		if( isset($agent_info->website) && $agent_info->website != '' ){
			$agent['website'] = $agent_info->website;
		}

		$agent['facebook'] = '';
		if( isset($agent_info->facebook) && $agent_info->facebook != '' ){
			$agent['facebook'] = $agent_info->facebook;
		}

		$agent['twitter'] = '';
		if( isset($agent_info->twitter) && $agent_info->twitter != '' ){
			$agent['twitter'] = $agent_info->twitter;
		}

		$agent['linkedin'] = '';
		if( isset($agent_info->linkedin) && $agent_info->linkedin != '' ){
			$agent['linkedin'] = $agent_info->linkedin;
		}

		$agent['youtube'] = '';
		if( isset($agent_info->youtube) && $agent_info->youtube != '' ){
			$agent['youtube'] = $agent_info->youtube;
		}

		$agent = \helpers\Text::array_to_object($agent);

		$this->set_agent_data = $agent;
	}

	public function get_data(){
		return $this->set_agent_data;
	}

	public function get_photo(){
		return $this->set_agent_data->img;
	}

	public function get_first_name(){
		return $this->set_agent_data->manager_first_name;
	}

	public function get_last_name(){
		return $this->set_agent_data->manager_last_name;
	}

	public function get_full_name(){
		return $this->set_agent_data->full_name;
	}

	public function get_company(){
		return $this->set_agent_data->company;
	}

	public function get_work_phone(){
		return $this->set_agent_data->work_phone;
	}

	public function get_manager_email(){
		return $this->set_agent_data->manager_email;
	}

	public function get_website(){
		return $this->set_agent_data->website;
	}

	public function get_facebook(){
		return $this->set_agent_data->facebook;
	}

	public function get_twitter(){
		return $this->set_agent_data->twitter;
	}

	public function get_linkedin(){
		return $this->set_agent_data->linkedin;
	}

	public function get_youtube(){
		return $this->set_agent_data->youtube;
	}

}

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
		if( is_null($data) ){
			$account = \CRM_Account::get_instance()->get_account_data();
			$agent = array();

			$agent['img'] = PLUGIN_ASSET_URL . 'agent-blank.jpg';
			if( isset($account->company_logo) && $account->company_logo != '' ){
				$agent['img'] = $account->company_logo;
			}

			$agent['manager_first_name'] = '';
			if( isset($account->manager_first_name) && $account->manager_first_name != '' ){
				$agent['manager_first_name'] = $account->manager_first_name;
			}

			$agent['manager_last_name'] = '';
			if( isset($account->manager_last_name) && $account->manager_last_name != '' ){
				$agent['manager_last_name'] = $account->manager_last_name;
			}

			$agent['full_name'] = $agent['manager_first_name'].' '.$agent['manager_last_name'];

			$agent['company'] = '';
			if( isset($account->company) && $account->company != '' ){
				$agent['company'] = $account->company;
			}

			$agent['work_phone'] = '';
			if( isset($account->work_phone) && $account->work_phone != '' ){
				$agent['work_phone'] = $account->work_phone;
			}

			$agent['manager_email'] = '';
			if( isset($account->manager_email) && $account->manager_email != '' ){
				$agent['manager_email'] = $account->manager_email;
			}

			$agent['website'] = '';
			if( isset($account->website) && $account->website != '' ){
				$agent['website'] = $account->website;
			}

			$agent['facebook'] = '';
			if( isset($account->facebook) && $account->facebook != '' ){
				$agent['facebook'] = $account->facebook;
			}

			$agent['twitter'] = '';
			if( isset($account->twitter) && $account->twitter != '' ){
				$agent['twitter'] = $account->twitter;
			}

			$agent['linkedin'] = '';
			if( isset($account->linkedin) && $account->linkedin != '' ){
				$agent['linkedin'] = $account->linkedin;
			}

			$agent['youtube'] = '';
			if( isset($account->youtube) && $account->youtube != '' ){
				$agent['youtube'] = $account->youtube;
			}

			$agent = \helpers\Text::array_to_object($agent);

			$this->set_agent_data = $agent;
		}else{
			$this->set_agent_data = $data;
		}
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

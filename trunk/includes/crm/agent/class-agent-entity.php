<?php
namespace crm;
/**
 * Handle logic for fetching agent details
 * */
class Agent_Entity{

	protected static $instance = null;

	public function __construct(){

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

	/**
	 * Bind a Property taken from API to this object
	 */
	public function bind( $property )
	{
		foreach( get_object_vars( $property )  as $k => $v ){
			$this->$k = $v;
		}
		return $this;
	}

	public function hasProperty( $name ) {
        return array_key_exists( $name, get_object_vars( $this ) );
    }

	public function displayAgentPhoto( $size = 'small' ){
		return ($size == 'small') ?
					(is_null($this->contact_photo_url)) ? $this->photo_url:$this->contact_photo_url
						: $this->photo_url;
	}

	public function displayAgentName(){
		return $this->contact_firstname .' '.$this->contact_middlename.' '.$this->contact_lastname;
	}

	public function displayAgentCompany(){
		return $this->contact_company;
	}

	public function displayAgentCompanyURL(){
		return $this->contact_website;
	}

	public function displayAgentCompanyLogo(){
		return $this->company_logo;
	}

	public function displayAgentEmail(){
		return $this->contact_email;
	}

	public function displayAgentMobile(){
		return $this->contact_mobile;
	}

	public function displayAgentPhone(){
		return $this->contact_phone;
	}

	public function displayAgentTitle(){
		return $this->contact_title;
	}

}

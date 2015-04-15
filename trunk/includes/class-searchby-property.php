<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Plugin Name.
 * Class to search property by filter
 * Also add rewrite rule for pages such as:
 * - Country
 * - State
 * - County
 * - City
 * - Zip
 * - Address
 *
 * @package   MD_Single_Property
 * @author    Masterdigm <email@example.com>
 * @license   GPL-2.0+
 * @link      http://masterdigm.com
 * @copyright 2014 Masterdigm
 */

/**
 * This is use to update public design changes
 *
 *
 *
 * @package MD_Single_Property
 * @author  masterdigm / Allan
 */
class MD_Searchby_Property {
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	public $address_pagename	= 'Address';
	public $address_slug 		= 'address';

	public $country_pagename 	= 'Country';
	public $country_slug 		= 'country';

	public $state_pagename 	= 'State';
	public $state_slug 		= 'state';

	public $city_pagename 	= 'City';
	public $city_slug 		= 'city';

	public $county_pagename 	= 'County';
	public $county_slug 		= 'county';

	public $zip_pagename 	= 'Zip';
	public $zip_slug 		= 'zip';

	public $community_pagename 	= 'Community';
	public $community_slug 		= 'community';

	public function __construct(){
		add_action( 'init', array( $this, 'load_rewrite_property' ) );
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

	public function load_rewrite_property(){
		$this->_countryRewriteURL();
		$this->_stateRewriteURL();
		$this->_countyRewriteURL();
		$this->_cityRewriteURL();
		$this->_zipRewriteURL();
		$this->_communityRewriteURL();
	}

	private function _countryRewriteURL(){
		add_rewrite_rule(
			'^'.$this->country_slug.'/([^/]*)/?',
			'index.php?pagename='.$this->country_pagename.'&url=$matches[1]',
			'top'
		);
		add_rewrite_tag('%url%', '([^&]+)');
	}

	private function _stateRewriteURL(){
		add_rewrite_rule(
			'^'.$this->state_slug.'/([^/]*)/?',
			'index.php?pagename='.$this->state_pagename.'&url=$matches[1]',
			'top'
		);
		add_rewrite_tag('%url%', '([^&]+)');
	}

	private function _cityRewriteURL(){
		add_rewrite_rule(
			'^'.$this->city_slug.'/([^/]*)/?',
			'index.php?pagename='.$this->city_pagename.'&url=$matches[1]',
			'top'
		);
		add_rewrite_tag('%url%', '([^&]+)');
	}

	private function _countyRewriteURL(){
		add_rewrite_rule(
			'^'.$this->county_slug.'/([^/]*)/?',
			'index.php?pagename='.$this->county_pagename.'&url=$matches[1]',
			'top'
		);
		add_rewrite_tag('%url%', '([^&]+)');
	}

	private function _zipRewriteURL(){
		add_rewrite_rule(
			'^'.$this->zip_slug.'/([^/]*)/?',
			'index.php?pagename='.$this->zip_pagename.'&url=$matches[1]',
			'top'
		);
		add_rewrite_tag('%url%', '([^&]+)');
	}

	private function _communityRewriteURL(){
		add_rewrite_rule(
			'^'.$this->community_slug.'/([^/]*)/?',
			'index.php?pagename='.$this->community_pagename.'&url=$matches[1]',
			'top'
		);
		add_rewrite_tag('%url%', '([^&]+)');
	}
}


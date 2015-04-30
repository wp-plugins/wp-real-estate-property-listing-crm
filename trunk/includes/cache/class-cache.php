<?php
/**
 * Cache
 *
 * This will use to cache data from api.
 * - it cache the method get_properties, actually its the search data we cache
 * so the next time a user search for the same property, we will just serve the api result
 * - the location or the marketing coverage of the client will be cache, these are the autocomplete
 * type in the search location.
 *
 * @since 1.0.0
 * @package    Masterdigm_API
 * */
class Masterdigm_Cache {
	protected static $instance = null;

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

}

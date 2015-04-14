<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Masterdigm API
 * @subpackage Masterdigm_API/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Masterdigm_API
 * @subpackage Masterdigm_API/includes
 * @author     Your Name <email@example.com>
 */
class Masterdigm_API_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		\Property_Page::get_instance()->create_property_page();
	}

}

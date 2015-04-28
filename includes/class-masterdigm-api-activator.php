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
		//\Property_Page::get_instance()->create_property_page();
	}

	public static function md_admin_notice() {
		?>
		<div class="updated notice">
			<p>Thank you for installing Masterdigm API, to use and obtain a KEY, please go to <a href="<?php echo admin_url('admin.php?page=masterdigm-api');?>">Plugin Dashboard page</a></p>
			<p>Or go directly to our <a href="http://www.masterdigm.com/pricing/" target="_blank">Masterdigm Sign-Up Page</a></p>
		</div>
		<?php
	}
}

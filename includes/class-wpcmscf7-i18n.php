<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar -- Can't change End of the line charcter.
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.cmsminds.com
 * @since      1.0.3
 *
 * @package    Wpcmscf7
 * @subpackage Wpcmscf7/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.3
 * @package    Wpcmscf7
 * @subpackage Wpcmscf7/includes
 * @author     CMSMINDS <info@cmsminds.com>
 */
class Wpcmscf7_i18n {
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.3
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wpcmscf7',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
}

<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar -- Can't change End of the line charcter.
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.cmsminds.com
 * @since             1.0.4
 * @package           Wpcmscf7
 *
 * @wordpress-plugin
 * Plugin Name:       Pay with Contact Form 7
 * Description:       This Add-on seamlessly integrates PayPal with Contact Form 7 and List Contact Form 7 dashboard with Payment Details.
 * Version:           1.0.4
 * Author:            cmsMinds
 * Author URI:        www.cmsminds.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpcmscf7
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// global variables.
global $wpdb;
$GLOBALS['plugin_main_file'] = plugin_basename( __FILE__ );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpcmscf7-activator.php
 */
function activate_wpcmscf7() {
	if ( ! is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) && current_user_can( 'activate_plugins' ) ) {
		wp_die( 'Sorry, but this plugin requires the Contact Form 7 Plugin to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>' );
	} else {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpcmscf7-activator.php';
		Wpcmscf7_Activator::activate();
	}
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpcmscf7-deactivator.php
 */
function deactivate_wpcmscf7() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpcmscf7-deactivator.php';
	Wpcmscf7_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpcmscf7' );
register_deactivation_hook( __FILE__, 'deactivate_wpcmscf7' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpcmscf7.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpcmscf7() {

	$plugin = new Wpcmscf7();
	$plugin->run();

}
run_wpcmscf7();


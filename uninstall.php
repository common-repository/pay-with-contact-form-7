<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar -- Can't change End of the line charcter.
/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       www.cmsminds.com
 * @since      1.0.3
 *
 * @package    Wpcmscf7
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/*
 *
 * Drop a custom database table cmscf7_forms, cmscf7_forms_transaction
 */
global $wpdb;

$table_name       = $wpdb->prefix . 'cmscf7_forms';
$table_name_trans = $wpdb->prefix . 'cmscf7_forms_transaction';

$wpdb->prepare( 'DROP TABLE IF EXISTS %s', $table_name );

$wpdb->prepare( 'DROP TABLE IF EXISTS %s', $table_name_trans );

/*
 *
 * Drop a option value and meta value
 */

$wpcms_options = 'wpcms_cf7pp_options';

if ( get_option( $wpcms_options ) ) {
	delete_option( $wpcms_options );
}

/*
 *
 * Drop a Meta Value
 */

$wpcms_post_args = array(
	'post_type'   => 'wpcf7_contact_form',
	'numberposts' => -1,
);
$wpcms_posts     = get_posts( $wpcms_post_args );

foreach ( $wpcms_posts as $wpcms_posts_data ) {
	delete_post_meta( $wpcms_posts_data->ID, 'wpcmscf7_enable' );
	delete_post_meta( $wpcms_posts_data->ID, 'wpcmscf7_name' );
	delete_post_meta( $wpcms_posts_data->ID, 'wpcmscf7_price' );
	delete_post_meta( $wpcms_posts_data->ID, 'wpcmscf7_id' );
	delete_post_meta( $wpcms_posts_data->ID, 'wpcmscf7_email' );
}

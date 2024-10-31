<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar -- Can't change End of the line charcter.
/**
 * Fired during plugin deactivation
 *
 * @link       www.cmsminds.com
 * @since      1.0.3
 *
 * @package    Wpcmscf7
 * @subpackage Wpcmscf7/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.3
 * @package    Wpcmscf7
 * @subpackage Wpcmscf7/includes
 * @author     CMSMINDS <info@cmsminds.com>
 */
class Wpcmscf7_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.3
	 */
	public static function deactivate() {

		function wp_config_delete( $slash = '' ) {
			$config = file_get_contents (ABSPATH . "wp-config.php");
			$config = preg_replace ("/( ?)(define)( ?)(\()( ?)(['\"])WPCF7_LOAD_JS(['\"])( ?)(,)( ?)(0|1|true|false)( ?)(\))( ?);/i", "", $config);
			file_put_contents (ABSPATH . $slash . "wp-config.php", $config);
		}

		if (file_exists (ABSPATH . "wp-config.php") && is_writable (ABSPATH . "wp-config.php")) {
			wp_config_delete();
		}
		else if (file_exists (dirname (ABSPATH) . "/wp-config.php") && is_writable (dirname (ABSPATH) . "/wp-config.php")) {
			wp_config_delete('/');
		}
		else if (file_exists (ABSPATH . "wp-config.php") && !is_writable (ABSPATH . "wp-config.php")) {
			?>
			<div class="error">
				<p><?php _e( 'wp-config.php is not writable, please make wp-config.php writable - set it to 0777 temporarily, then set back to its original setting after this plugin has been deactivated.', 'wpcmscf7' ); ?></p>
			</div>
			<button onclick="goBack()">Go Back and try again</button>
			<script>
			function goBack() {
				window.history.back();
			}
			</script>
			<?php
			exit;
		}
		else if (file_exists (dirname (ABSPATH) . "/wp-config.php") && !is_writable (dirname (ABSPATH) . "/wp-config.php")) {
			?>
			<div class="error">
				<p><?php _e( 'wp-config.php is not writable, please make wp-config.php writable - set it to 0777 temporarily, then set back to its original setting after this plugin has been deactivated.', 'wpcmscf7' ); ?></p>
			</div>
			<button onclick="goBack()">Go Back and try again</button>
			<script>
			function goBack() {
				window.history.back();
			}
			</script>
			<?php
			exit;
		}
		else {
			?>
			<div class="error">
				<p><?php _e( 'wp-config.php is not writable, please make wp-config.php writable - set it to 0777 temporarily, then set back to its original setting after this plugin has been deactivated.', 'wpcmscf7' ); ?></p>
			</div>
			<button onclick="goBack()">Go Back and try again</button>
			<script>
			function goBack() {
				window.history.back();
			}
			</script>
			<?php
			exit;
		}

	}

}

<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar -- Can't change End of the line charcter.
/**
 * Fired during plugin activation
 *
 * @link       www.cmsminds.com
 * @since      1.0.3
 *
 * @package    Wpcmscf7
 * @subpackage Wpcmscf7/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.3
 * @package    Wpcmscf7
 * @subpackage Wpcmscf7/includes
 * @author     CMSMINDS <info@cmsminds.com>
 */
class Wpcmscf7_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.3
	 */
	public static function activate() {
		global $wpdb;
	    $table_name = $wpdb->prefix.'cmscf7_forms';

	    if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {

	        $charset_collate = $wpdb->get_charset_collate();

	        $sql = "CREATE TABLE $table_name (
	            form_id bigint(20) NOT NULL AUTO_INCREMENT,
	            form_post_id bigint(20) NOT NULL,
	            form_transaction_id varchar(100) NOT NULL,
	            form_value longtext NOT NULL,
	            form_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	            PRIMARY KEY  (form_id)
	        ) $charset_collate;";

	        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	        dbDelta( $sql );
	    }

	    $upload_dir    = wp_upload_dir();
	    $wpcmscf7_dirname = $upload_dir['basedir'].'/wpcmscf7_uploads';
	    if ( ! file_exists( $wpcmscf7_dirname ) ) {
	        wp_mkdir_p( $wpcmscf7_dirname );
	    }

	    $table_name_trans = $wpdb->prefix.'cmscf7_forms_transaction';

	    if( $wpdb->get_var("SHOW TABLES LIKE '$table_name_trans'") != $table_name_trans ) {

	        $charset_collate_trans = $wpdb->get_charset_collate();

	        $sql_trans = "CREATE TABLE $table_name_trans (
	            id bigint(20) NOT NULL AUTO_INCREMENT,
	            form_post_id bigint(20) NOT NULL,
	            form_transaction_id varchar(100) NOT NULL,
	            trans_value longtext NOT NULL,
	            trans_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	            PRIMARY KEY  (id)
	        ) $charset_collate_trans;";

	        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	        dbDelta( $sql_trans );
	    }

	    // remove ajax from contact form 7 to allow for php redirects
		function wp_config_put( $slash = '' ) {
			$config = file_get_contents (ABSPATH . "wp-config.php");
			$config = preg_replace ("/^([\r\n\t ]*)(\<\?)(php)?/i", "<?php define('WPCF7_LOAD_JS', false);", $config);
			file_put_contents (ABSPATH . $slash . "wp-config.php", $config);
		}

		if ( file_exists (ABSPATH . "wp-config.php") && is_writable (ABSPATH . "wp-config.php") ){
			wp_config_put();
		}
		else if (file_exists (dirname (ABSPATH) . "/wp-config.php") && is_writable (dirname (ABSPATH) . "/wp-config.php")){
			wp_config_put('/');
		}
		else {
			?>
			<div class="error">
				<p><?php _e( 'wp-config.php is not writable, please make wp-config.php writable - set it to 0777 temporarily, then set back to its original setting after this plugin has been activated.', 'wpcmscf7' ); ?></p>
			</div>
			<?php
			exit;
		}
	}

}

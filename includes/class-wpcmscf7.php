<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar -- Can't change End of the line charcter.
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       www.cmsminds.com
 * @since      1.0.3
 *
 * @package    Wpcmscf7
 * @subpackage Wpcmscf7/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.3
 * @package    Wpcmscf7
 * @subpackage Wpcmscf7/includes
 * @author     CMSMINDS <info@cmsminds.com>
 */
class Wpcmscf7 {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.3
	 * @access   protected
	 * @var      Wpcmscf7_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.3
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.3
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.3
	 */
	public function __construct() {
		$this->plugin_name = 'wpcmscf7';
		$this->version     = '1.0.3';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wpcmscf7_Loader. Orchestrates the hooks of the plugin.
	 * - Wpcmscf7i18n. Defines internationalization functionality.
	 * - Wpcmscf7_Admin. Defines all hooks for the admin area.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.3
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpcmscf7-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpcmscf7-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpcmscf7-admin.php';

		$this->loader = new Wpcmscf7_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wpcmscf7i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.3
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wpcmscf7_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.3
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wpcmscf7_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'wpcmscf7_check_dependancy' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'wpcmscf7_admin_menu', 20 );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'wpcmscf7_admin_list_table_page' );
		$this->loader->add_filter( 'plugin_action_links_' . $GLOBALS['plugin_main_file'], $plugin_admin, 'wpcmscf7_plugin_settings_link' );
		$this->loader->add_filter( 'wpcf7_editor_panels', $plugin_admin, 'wpcmscf7_editor_panels' );
		$this->loader->add_action( 'wpcf7_admin_after_additional_settings', $plugin_admin, 'wpcmscf7_admin_after_additional_settings' );
		$this->loader->add_action( 'wpcf7_save_contact_form', $plugin_admin, 'wpcmscf7_save_contact_form' );
		$this->loader->add_action( 'wpcf7_before_send_mail', $plugin_admin, 'wpcmscf7_before_send_mail' );
		$this->loader->add_action( 'wpcf7_mail_sent', $plugin_admin, 'wpcmscf7_after_send_mail' );
	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.3
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.3
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.3
	 * @return    Wpcmscf7_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.3
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
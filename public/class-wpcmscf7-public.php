<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.cmsminds.com
 * @since      1.0.0
 *
 * @package    Wpcmscf7
 * @subpackage Wpcmscf7/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wpcmscf7
 * @subpackage Wpcmscf7/public
 * @author     CMSMINDS <injfo@cmsminds.com>
 */
class Wpcmscf7_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpcmscf7_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpcmscf7_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpcmscf7-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpcmscf7_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpcmscf7_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'my-plugin-public', plugin_dir_url( __FILE__ ) . 'js/wpcmscf7-public.js', array( 'jquery' ), $this->version, false );
		// wp_localize_script( 'my-plugin-public', 'my_plugin' , array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		// wp_enqueue_script( 'my-plugin-public' );
	}

	
}

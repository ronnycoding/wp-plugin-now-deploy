<?php

/**
 * @link       https://rfreites.now.sh
 * @since      1.0.0
 *
 * @package    Wp_Plugin_Now_Deployment
 * @subpackage Wp_Plugin_Now_Deployment/includes
 */

/**
 * @since      1.0.0
 * @package    Wp_Plugin_Now_Deployment
 * @subpackage Wp_Plugin_Now_Deployment/includes
 * @author     Ronny Freites <ronnyangelo.freites@gmail.com>
 */
class Wp_Plugin_Now_Deployment {

	/**
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wp_Plugin_Now_Deployment_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WP_PLUGIN_NOW_DEPLOYMENT_VERSION' ) ) {
			$this->version = WP_PLUGIN_NOW_DEPLOYMENT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wp-plugin-now-deployment';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-plugin-now-deployment-loader.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-plugin-now-deployment-i18n.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-plugin-now-deployment-admin.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-plugin-now-deployment-public.php';

		$this->loader = new Wp_Plugin_Now_Deployment_Loader();

	}

	/**
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wp_Plugin_Now_Deployment_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wp_Plugin_Now_Deployment_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'set_options');
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_submenu_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'settings_page_init' );
		$this->loader->add_action( 'removable_query_args', $plugin_admin, 'remove_query_args' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'register_auto_deploy' );
	}

	/**
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wp_Plugin_Now_Deployment_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * @since     1.0.0
	 * @return    Wp_Plugin_Now_Deployment_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

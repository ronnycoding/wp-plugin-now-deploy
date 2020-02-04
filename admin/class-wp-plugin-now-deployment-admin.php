<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rfreites.now.sh
 * @since      1.0.0
 *
 * @package    Wp_Plugin_Now_Deployment
 * @subpackage Wp_Plugin_Now_Deployment/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Plugin_Now_Deployment
 * @subpackage Wp_Plugin_Now_Deployment/admin
 * @author     Ronny Freites <ronnyangelo.freites@gmail.com>
 */
class Wp_Plugin_Now_Deployment_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Plugin_Now_Deployment_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Plugin_Now_Deployment_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-plugin-now-deployment-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Plugin_Now_Deployment_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Plugin_Now_Deployment_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-plugin-now-deployment-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the Sub Level Administrative menu option for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function add_submenu_page() {
		add_submenu_page(
			'options-general.php',
			__('WP Plugin Now Deployment', 'wp-plugin-now-deployment'),
			__('WP Plugin Now Deployment', 'wp-plugin-now-deployment'),
			'manage_options',
			'wp-plugin-now-deployment-admin-display',
			array(&$this, 'get_submenu_page_partial')
		);
	}

	public function get_submenu_page_partial() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/wp-plugin-now-deployment-admin-display.php';
	}

	public function settings_page_init() {
		// check if user is allowed access
		if ( ! current_user_can( 'manage_options' ) ) return;
		add_settings_section("wp-plugin-now-deployment-webhook-section", "All Settings", null, "wp-plugin-now-deployment-admin-display");
		add_settings_field("wp_plugin_now_deployment_webhook", "Now Deploy Webhook", array(&$this, "display_now_webhook"), "wp-plugin-now-deployment-admin-display", "wp-plugin-now-deployment-webhook-section");
		register_setting("wp-plugin-now-deployment-webhook-section", "wp_plugin_now_deployment_webhook");
	}

	public function display_now_webhook()
	{
		?>
			<input type="text" name="wp_plugin_now_deployment_webhook" id="wp_plugin_now_deployment_webhook" value="<?php echo get_option('wp_plugin_now_deployment_webhook'); ?>" />
		<?php
	}
}

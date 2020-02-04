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

	const URL_BASE_HOOK = 'https://api.zeit.co/v1/integrations/deploy/';

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
			__('WP Plugin Now Deploy', 'wp-plugin-now-deployment'),
			__('WP Plugin Now Deploy', 'wp-plugin-now-deployment'),
			'manage_options',
			'wp-plugin-now-deployment-admin-display',
			array(&$this, 'get_submenu_page_partial')
		);
	}

	public function get_submenu_page_partial() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/wp-plugin-now-deployment-admin-display.php';
	}

	public function handle_settings() {
		$options = get_option('wp_plugin_now_deployment_options');

		if (!empty($_GET['deploy']) && $_GET['deploy'] === 'yes' && !empty($options['webhook']) && !empty($options['enable_deploy']) && $options['enable_deploy'] === 'on') {
			$response = wp_remote_get( Wp_Plugin_Now_Deployment_Admin::URL_BASE_HOOK . $options['webhook'] );
			try {
				if (!empty($response['response']['code']) && $response['response']['code'] === 201) {
					$options['last_deploy'] = strtotime("now");
					update_option('wp_plugin_now_deployment_options', $options);
					?>
					<div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible"> 
						<p><strong><?php echo __('Deploy Successfully Created!', 'wp-plugin-now-deployment'); ?></strong></p>
						<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
					</div>
					<?php
				} else {
					?>
					<div id="setting-error-settings_updated" class="notice notice-error settings-error is-dismissible"> 
						<p><strong><?php echo __('Your Webhook ID is invalid!', 'wp-plugin-now-deployment'); ?></strong></p>
						<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
					</div>
					<?php
				}
			} catch ( Exception $ex ) {
				?>
				<div id="setting-error-settings_updated" class="notice notice-error settings-error is-dismissible"> 
					<p><strong><?php echo __('Unexpected Error', 'wp-plugin-now-deployment'); ?></strong></p>
					<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
				</div>
				<?php
			}
		}
	}

	public function settings_page_init() {
		// check if user is allowed access
		if ( ! current_user_can( 'manage_options' ) ) return;
		register_setting("wp-plugin-now-deployment-webhook-section", "wp_plugin_now_deployment_options");
		add_settings_section("wp-plugin-now-deployment-webhook-section", null, array(&$this, "handle_settings"), "wp-plugin-now-deployment-admin-display");
		add_settings_field("wp_plugin_now_deployment_webhook", __("Webhook", "wp-plugin-now-deployment"), array(&$this, "display_now_webhook"), "wp-plugin-now-deployment-admin-display", "wp-plugin-now-deployment-webhook-section");
		add_settings_field("wp_plugin_now_deployment_webhook_last_deploy", __("Last deploy", "wp-plugin-now-deployment"), array(&$this, "display_now_webhook_last_deploy"), "wp-plugin-now-deployment-admin-display", "wp-plugin-now-deployment-webhook-section");
		add_settings_field("wp_plugin_now_deployment_webhook_deploy", __("Enable deploy", "wp-plugin-now-deployment"), array(&$this, "display_now_webhook_deploy"), "wp-plugin-now-deployment-admin-display", "wp-plugin-now-deployment-webhook-section");
		add_settings_field("wp_plugin_now_deployment_enable_auto_deploy", __("Auto Deploy", "wp-plugin-now-deployment"), array(&$this, "display_now_auto_deploy"), "wp-plugin-now-deployment-admin-display", "wp-plugin-now-deployment-webhook-section");
	}

	public function display_now_webhook()
	{
		$options = get_option('wp_plugin_now_deployment_options');
		?>
			<input type="text" name="wp_plugin_now_deployment_options[webhook]" id="wp_plugin_now_deployment_webhook" value="<?php echo $options['webhook'] ?: ''; ?>" required/>
		<?php
	}

	public function display_now_webhook_last_deploy()
	{
		$options = get_option('wp_plugin_now_deployment_options');
		?>
			<p id="wp_plugin_now_deployment_webhook"><?php echo date("l jS \of F Y h:i:s A", $options['last_deploy']) ?: __("Make your first deploy!") ?></p>
		<?php
	}

	public function display_now_webhook_deploy() {
		$options = get_option('wp_plugin_now_deployment_options');
		if(isset($options['enable_deploy']) && $options['enable_deploy']) { $checked = ' checked="checked" '; }
		echo "<input ".$checked." id='wp_plugin_now_deployment_webhook_enable_deploy' name='wp_plugin_now_deployment_options[enable_deploy]' type='checkbox' />";
	}

	public function display_now_auto_deploy() {
		$options = get_option('wp_plugin_now_deployment_options');
		if(isset($options['enable_auto_deploy']) && $options['enable_auto_deploy']) { $checked = ' checked="checked" '; }
		echo "<input ".$checked." id='wp_plugin_now_deployment_enable_auto_deploy' name='wp_plugin_now_deployment_options[enable_auto_deploy]' type='checkbox' />";
	}

	public function set_options() {
		$tmp = get_option('wp_plugin_now_deployment_options');
		if(empty($tmp)) {
			$arr = array(
				'enable_deploy' => '',
				'webhook' => '',
				'last_deploy' => '',
				'enable_auto_deploy' => ''
			);
			update_option('wp_plugin_now_deployment_options', $arr);
		}
	}

	public function remove_query_args($removable_url_params) {
		$remove_params = array('deploy');
		return array_merge($remove_params, $removable_url_params);
	}

	public function register_auto_deploy() {
		$options = get_option('wp_plugin_now_deployment_options');
		$url_origin_request = parse_url($_SERVER['REQUEST_URI']);
		if(isset($options['enable_auto_deploy']) && $options['enable_auto_deploy']) {
			$response = wp_remote_get( Wp_Plugin_Now_Deployment_Admin::URL_BASE_HOOK . $options['webhook'] );
			try {
				if (!empty($response['response']['code']) && $response['response']['code'] === 201) {
					$options['last_deploy'] = strtotime("now");
					update_option('wp_plugin_now_deployment_options', $options);
				}
			} catch ( Exception $ex ) {
				echo $ex->getMessage();
			}
		}
	}
}

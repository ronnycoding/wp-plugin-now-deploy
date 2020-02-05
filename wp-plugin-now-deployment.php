<?php

/**
 * @link              https://rfreites.now.sh
 * @since             1.0.0
 * @package           Wp_Plugin_Now_Deployment
 *
 * @wordpress-plugin
 * Plugin Name:       Webhook Zeit Deploy
 * Plugin URI:        https://ronnyfreites.blog
 * Description:       Easily deploy static sites using WordPress and Zeit.
 * Version:           1.0.0
 * Author:            Ronny Freites
 * Author URI:        https://rfreites.now.sh
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-plugin-now-deployment
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_PLUGIN_NOW_DEPLOYMENT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-plugin-now-deployment-activator.php
 */
function activate_wp_plugin_now_deployment() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-plugin-now-deployment-activator.php';
	Wp_Plugin_Now_Deployment_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-plugin-now-deployment-deactivator.php
 */
function deactivate_wp_plugin_now_deployment() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-plugin-now-deployment-deactivator.php';
	Wp_Plugin_Now_Deployment_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_plugin_now_deployment' );
register_deactivation_hook( __FILE__, 'deactivate_wp_plugin_now_deployment' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-plugin-now-deployment.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_plugin_now_deployment() {

	$plugin = new Wp_Plugin_Now_Deployment();
	$plugin->run();

}
run_wp_plugin_now_deployment();

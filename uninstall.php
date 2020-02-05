<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://rfreites.now.sh
 * @since      1.0.0
 *
 * @package    Wp_Plugin_Now_Deployment
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'wp_plugin_now_deployment_options' );
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
class Wp_Plugin_Now_Deployment_Activator {

	/**
	 * @since    1.0.0
	 */
	public static function activate() {
		if ( ! current_user_can( 'activate_plugins' ) ) return;
		add_option( 'wp_plugin_now_deployment_options' );
	}

}

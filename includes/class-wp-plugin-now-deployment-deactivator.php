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
class Wp_Plugin_Now_Deployment_Deactivator {

	/**
	 * @since    1.0.0
	 */
	public static function deactivate() {
		if ( ! current_user_can( 'activate_plugins' ) ) return;
		flush_rewrite_rules();
	}

}

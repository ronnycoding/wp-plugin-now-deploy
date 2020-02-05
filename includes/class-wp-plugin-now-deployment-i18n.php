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
class Wp_Plugin_Now_Deployment_i18n {


	/**
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-plugin-now-deployment',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://rfreites.now.sh
 * @since      1.0.0
 *
 * @package    Wp_Plugin_Now_Deployment
 * @subpackage Wp_Plugin_Now_Deployment/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
  <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
  <form method="post" action="options.php">
    <?php
    // output security fields
    settings_fields( "wp-plugin-now-deployment-webhook-section" );

    // // output setting sections
    do_settings_sections( "wp-plugin-now-deployment-admin-display" );

    // submit button
    submit_button();
    ?>
    <input type="submit" id="submitDeploy" class="button button-primary" value="<?php echo __('Build Site', 'wp-plugin-now-deployment'); ?>">
  </form>
</div>
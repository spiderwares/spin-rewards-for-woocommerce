<?php
/**
 * Settings Tab: Spin Rewards	
 * Loads the Spin Rewards settings section in the plugin settings page.
 * 
 * @package Spin_Rewards_For_WooCommerce
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Retrieve the spin rewards settings fields from the SRWC_Rewards_Fields class.
 * @var array $fields Array of spin rewards settings fields.
 * 
 */
$fields = SRWC_Rewards_Fields::spin_rewards_field();

/**
 * Fetch the saved settings from the WordPress options table.
 * @var array|false $options Retrieved settings or false if not set.
 * 
 */
$options = get_option( 'srwc_settings', true );

/**
 * Load the settings form template for the Spin Rewards settings tab.
 */
wc_get_template(
	'fields/setting-forms.php',
	array(
		'title'   => 'Spin Rewards Fields',     // Section title.
		'metaKey' => 'srwc_settings',   // Option meta key.
		'fields'  => $fields,           // Field definitions.
		'options' => $options,          // Saved option values.
	),
	'spin-rewards-for-woocommerce/fields/',   // Relative template path in the plugin.
	SRWC_TEMPLATE_PATH                  // Absolute path to the template directory.
);
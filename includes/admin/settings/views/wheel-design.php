<?php
/**
 * Settings Tab: Wheel Design
 * Loads the Wheel Design settings section in the plugin settings page.
 * 
 * @package Spin_Rewards_For_WooCommerce
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Retrieve the wheel design settings fields from the SRWC_Rewards_Fields class.
 * @var array $fields Array of wheel design settings fields.
 * 
 */
$fields = SRWC_Rewards_Fields::wheel_design_field();

/**
 * Fetch the saved settings from the WordPress options table.
 * @var array|false $options Retrieved settings or false if not set.
 * 
 */
$options = get_option( 'srwc_settings', true );

/**
 * Load the settings form template for the Wheel Design settings tab.
 */
wc_get_template(
	'fields/setting-forms.php',
	array(
		'title'   => 'Wheel Design',         // Section title.
		'metaKey' => 'srwc_settings',   // Option meta key.
		'fields'  => $fields,           // Field definitions.
		'options' => $options,          // Saved option values.
	),
	'spin-rewards-for-woocommerce/fields/',   // Relative template path in the plugin.
	SRWC_TEMPLATE_PATH                  // Absolute path to the template directory.
);
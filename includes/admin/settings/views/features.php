<?php
/**
 * Settings Tab: Features
 * Loads the Features comparison table in the plugin settings page.
 * 
 * @package Spin_Rewards_For_WooCommerce
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Load the features comparison table template.
 */
wc_get_template(
    'features.php',
    array(),
    'spin-rewards-for-woocommerce/',
    SRWC_TEMPLATE_PATH
);

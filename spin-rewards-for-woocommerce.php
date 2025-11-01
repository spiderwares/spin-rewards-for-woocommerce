<?php
/**
 * Plugin Name:       Spin Rewards for WooCommerce
 * Description:       Boost sales and grow your email list with an interactive spin the wheel game that gives customers instant discount rewards.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Cosmic
 * Author URI:        https://cosmicinfosolutions.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Requires Plugins:  woocommerce
 * Text Domain:       spin-rewards-for-woocommerce
 *
 * @package Spin_Rewards_For_WooCommerce
 */

 if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( 'SRWC_FILE' ) ) :
    define( 'SRWC_FILE', __FILE__ ); // Define the plugin file path.
endif;

if ( ! defined( 'SRWC_BASENAME' ) ) :
    define( 'SRWC_BASENAME', plugin_basename( SRWC_FILE ) ); // Define the plugin basename.
endif;

if ( ! defined( 'SRWC_VERSION' ) ) :
    define( 'SRWC_VERSION', '1.0.0' ); // Define the plugin version.
endif;

if ( ! defined( 'SRWC_PATH' ) ) :
    define( 'SRWC_PATH', plugin_dir_path( __FILE__ ) ); // Define the plugin directory path.
endif;

if ( ! defined( 'SRWC_TEMPLATE_PATH' ) ) :
	define( 'SRWC_TEMPLATE_PATH', SRWC_PATH . '/templates/' ); // Define the plugin directory path.
endif;

if ( ! defined( 'SRWC_URL' ) ) :
    define( 'SRWC_URL', plugin_dir_url( __FILE__ ) ); // Define the plugin directory URL.
endif;

if ( ! defined( 'SRWC_PRO_VERSION_URL' ) ) :
    define( 'SRWC_PRO_VERSION_URL', '#' ); // Pro Version URL
endif;

if ( ! class_exists( 'SRWC', false ) ) :
    include_once SRWC_PATH . 'includes/class-srwc.php';
    include_once SRWC_PATH . 'includes/hpos.php';
endif;

$GLOBALS['SRWC'] = SRWC::instance();

if (class_exists ( 'SRWC' )) :
    register_activation_hook( __FILE__, [ 'SRWC', 'plugin_activate' ] );
endif;

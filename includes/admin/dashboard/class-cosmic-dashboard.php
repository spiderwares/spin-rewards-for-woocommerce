<?php
/**
 * Cosmic Dashboard Class
 *
 * Handles the admin dashboard setup and related functionalities.
 *
 * @package Spin_Rewards_For_WooCommerce
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Cosmic_Dashboard' ) ) {

	/**
	 * Class Cosmic_Dashboard
	 *
	 * Initializes the admin dashboard for Cosmic.
	 */
	class Cosmic_Dashboard {

		/**
		 * Constructor for Cosmic_Dashboard class.
		 * Initializes the event handler.
		 */
		public function __construct() {
			$this->events_handler();
		}

		/**
		 * Initialize hooks for admin functionality.
		 */
		private function events_handler() {
			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		}

		/**
		 * Enqueue admin-specific styles for the dashboard.
		 */
		public function enqueue_scripts() {
			
			// Enqueue the Cosmic dashboard CSS.
			wp_enqueue_style(
				'cosmic-dashboard',
				SRWC_URL . 'includes/admin/dashboard/css/cosmic-dashboard.css',
				[],
				SRWC_VERSION 
			);

		}

	}

	// Instantiate the Cosmic_Dashboard class.
	new Cosmic_Dashboard();
}

<?php
/**
 * SRWC Tab Class
 *
 * Handles the admin tab setup and related functionalities.
 *
 * @package Spin_Rewards_For_WooCommerce
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_Tab' ) ) {

	/**
	 * Class SRWC_Tab
	 *
	 * Initializes the admin tab for SRWC.
	 */
	class SRWC_Tab {

		/**
		 * Constructor for SRWC_Tab class.
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
		 * Enqueue admin-specific styles for the tab.
		 */
		public function enqueue_scripts() {
			
			// Enqueue the SRWC tab CSS.
			wp_enqueue_style(
				'srwc-tab',
				SRWC_URL . 'includes/admin/tab/css/srwc-tab.css',
				[],
				SRWC_VERSION 
			);

		}

	}

	// Instantiate the SRWC_Tab class.
	new SRWC_Tab();
}

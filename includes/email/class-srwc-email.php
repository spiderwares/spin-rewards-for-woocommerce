<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_Email' ) ) :

	/**
	 * Class SRWC_Email
	 * 
	 * Handles the registration of the emails.
	 */
	class SRWC_Email {

		/**
		 * Constructor for the class.
		 * 
		 */
		public function __construct() {
			$this->events_handler();
		}

		/**
         * Initialize hooks and filters.
         */
		public function events_handler(){
			add_filter( 'woocommerce_email_classes', [ $this, 'register_emails' ] );
		}

		public function register_emails( $emails ) {

			$settings = get_option( 'srwc_settings', array() );

			if ( empty( $settings['enable_customer_email'] ) || $settings['enable_customer_email'] !== 'yes' ) :
				return $emails;
            endif;

			require_once SRWC_PATH . 'includes/email/class-srwc-user-win-email.php';
			$emails['SRWC_User_Win_Email'] = new SRWC_User_Win_Email();

			return $emails;
		}
	}

	new SRWC_Email();

endif;



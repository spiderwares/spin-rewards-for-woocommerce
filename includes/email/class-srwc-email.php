<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_Emails' ) ) :

	class SRWC_Emails {

		public function __construct() {
			add_filter( 'woocommerce_email_classes', [ $this, 'register_emails' ] );
		}

		public function register_emails( $emails ) {

			$settings = get_option( 'srwc_settings', array() );

			if ( empty( $settings['enable_email'] ) || $settings['enable_email'] !== 'yes' ) :
				return $emails;
            endif;

			require_once SRWC_PATH . 'includes/email/class-srwc-user-win-email.php';
			$emails['SRWC_User_Win_Email'] = new SRWC_User_Win_Email();

			return $emails;
		}
	}

	new SRWC_Emails();

endif;



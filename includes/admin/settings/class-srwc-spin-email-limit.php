<?php
/**
 * Register Spin Rewards Records CPT for SRWC plugin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'SRWC_Spin_Email_Limit' ) ) :

    class SRWC_Spin_Email_Limit {

        /**
         * Initialize hooks for AJAX endpoints
         */
        public $settings;

        /**
         * Initialize hooks for AJAX endpoints
         */
        public function __construct() {
            $this->settings = get_option( 'srwc_settings', array() );

            add_action( 'wp_ajax_srwc_check_email_limit', [ $this, 'check_email_limit' ] );
            add_action( 'wp_ajax_nopriv_srwc_check_email_limit', [ $this, 'check_email_limit' ] );
        }

        /**
         * AJAX handler to check email spin limit
         */
        public function check_email_limit() {
            
            // Verify nonce for security
            if ( isset( $_GET['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['nonce'] ) ), 'srwc_admin_nonce' ) ) :
                wp_die( esc_html__( 'Security check failed.', 'spin-rewards-for-woocommerce' ) );
            endif;

            if ( ! empty( $_POST['customer_email'] ) ) :
                $customer_email = sanitize_email( wp_unslash( $_POST['customer_email'] ) );
                
                $spin_limit_check = SRWC_Spin_Records::check_email_spin_limit( $customer_email );
                if ( $spin_limit_check !== false ) :
                    $spin_limit     = ! empty( $this->settings['spin_per_email'] ) ? absint( $this->settings['spin_per_email'] ) : 0;
                    $custom_message = ! empty( $this->settings['spin_limit_email_message'] ) ? $this->settings['spin_limit_email_message'] : esc_html__( 'You’ve reached your spin limit.', 'spin-rewards-for-woocommerce' );
                    
                    wp_send_json_error( array( 'message' => $custom_message ) );
                else :
                    wp_send_json_success( array( 'message' => 'Email is valid for spinning' ) );
                endif;
            else :
                wp_send_json_error( array( 'message' => esc_html__( 'Email is required.', 'spin-rewards-for-woocommerce' ) ) );
            endif;
        }

    }

    new SRWC_Spin_Email_Limit();
endif;

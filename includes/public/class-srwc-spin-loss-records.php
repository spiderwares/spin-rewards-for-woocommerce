<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_Spin_Loss_Records' ) ) :

    class SRWC_Spin_Loss_Records {

        /**
		 * Initialize hooks.
		 */
        public function __construct() {
            
            // AJAX handler for recording loss spins
            add_action( 'wp_ajax_srwc_record_loss_spin', array( $this, 'record_loss_spin' ) );
            add_action( 'wp_ajax_nopriv_srwc_record_loss_spin', array( $this, 'record_loss_spin' ) );
        }

        /**
         * Record loss spin (no coupon generated, no email sent)
         */
        public function record_loss_spin() {

            if ( ! isset( $_POST['nonce'] ) || ! 
                wp_verify_nonce( 
                    sanitize_text_field( wp_unslash( $_POST['nonce'] ) ),
                    'srwc_nonce' 
                )
            ) :
                return;
            endif;

            $customer_name = isset( $_POST['customer_name'] ) ? sanitize_text_field( wp_unslash( $_POST['customer_name'] ) ) : '';
            $customer_mobile = isset( $_POST['customer_mobile'] ) ? sanitize_text_field( wp_unslash( $_POST['customer_mobile'] ) ) : '';
        
            if ( ! empty( $_POST['customer_email'] ) ) :
                $customer_email = sanitize_email( wp_unslash( $_POST['customer_email'] ) );
            endif;

            // Create spin record for loss (no coupon, no email)
            if ( class_exists( 'SRWC_Spin_Records' ) ) :
                $record_id = SRWC_Spin_Records::create_spin_record( array(
                    'customer_email' => $customer_email,
                    'customer_name'  => $customer_name,
                    'customer_mobile' => $customer_mobile,
                    'coupon_code'    => '', // No coupon for loss
                    'spin_date'      => current_time( 'mysql' )
                ) );
                
                if ( $record_id ) :
                    wp_send_json_success( array( 'message' => 'Loss spin recorded' ) );
                else :
                    wp_send_json_error( array( 'message' => 'Failed to record loss spin' ) );
                endif;
            else :
                wp_send_json_error( array( 'message' => 'Spin records class not available' ) );
            endif;
        }
        
        
    }

    new SRWC_Spin_Loss_Records();
endif;

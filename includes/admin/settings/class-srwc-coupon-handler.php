<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_Coupon_Handler' ) ) :

    /**
     * Main SRWC_Coupon_Handler Class
     *
     * @class SRWC_Coupon_Handler
     * @version 1.0.0
     */
    class SRWC_Coupon_Handler {

        /**
         * Constructor for the class.
         */
        public function __construct() {
            $this->event_handler();
        }
        
        /**
         * Initialize hooks and filters.
         */
        private function event_handler() {
            add_action( 'wp_ajax_srwc_get_coupons', [ $this, 'get_coupons_ajax' ] );    
            add_action( 'wp_ajax_nopriv_srwc_get_coupons', [ $this, 'get_coupons_ajax' ] );
        }

        /**
         * AJAX handler to get existing coupons
         */
        public function get_coupons_ajax() {
            // Verify nonce
            if ( ! wp_verify_nonce( $_POST['nonce'], 'srwc_admin_nonce' ) ) {
                wp_die( 'Security check failed' );
            }

            $coupons = array();
            
            // Get all published coupons
            $args = array(
                'post_type'      => 'shop_coupon',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC'
            );

            $coupon_posts = get_posts( $args );

            foreach ( $coupon_posts as $coupon_post ) {
                $coupon = new WC_Coupon( $coupon_post->ID );
                
                if ( $coupon->is_valid() ) {
                    $coupons[] = array(
                        'code'        => $coupon->get_code(),
                        'description' => $coupon->get_description() ? $coupon->get_description() : $coupon->get_code(),
                        'amount'      => $coupon->get_amount(),
                        'type'        => $coupon->get_discount_type()
                    );
                }
            }

            wp_send_json_success( $coupons );
        }

    }

    // Initialize the class.
    new SRWC_Coupon_Handler();

endif;

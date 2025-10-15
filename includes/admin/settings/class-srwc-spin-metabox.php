<?php
/**
 * Register Spin Metabox for SRWC plugin
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'SRWC_Spin_Metabox' ) ) :

    /**
     * Class SRWC_Spin_Metabox
     *
     * Handles the registration of the Spin Metabox.
     */
    class SRWC_Spin_Metabox {

        /**
         * Constructor for the SRWC_Spin_Metabox class.
         * Hooks into WordPress to register the spin metabox.
         */
        public function __construct() {
            add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
        }

        /**
         * Add meta boxes for spin metabox
         */
        public function add_meta_boxes() {
            add_meta_box(
                'srwc_spin_record_details',
                esc_html__( 'Spin Wheel Record Details', 'spin-rewards-for-woocommerce' ),
                array( $this, 'render_spin_wheel_metabox' ),
                'srwc_spin_record',
                'normal',
                'high'
            );
        }
        
        /**
         * Enqueue admin styles for meta box
         */
        public function enqueue_admin_styles() {

            wp_enqueue_style( 
                'srwc-metabox', 
                SRWC_URL . 'assets/css/srwc-metabox.css', 
                array(), 
                SRWC_VERSION 
            );
        }

        /**
         * Render the spin metabox
         */
        public function render_spin_wheel_metabox( $post ) {

            $settings       = get_option( 'srwc_settings', array() );
            $customer_name  = get_post_meta( $post->ID, 'srwc_customer_name', true );
            $win_label      = get_post_meta( $post->ID, 'srwc_win_label', true );
            $coupon_code    = get_post_meta( $post->ID, 'srwc_coupon_code', true );

            if ( empty( $customer_name ) ) :
                $customer_name = esc_html__( 'Sir/Ma\'am', 'spin-rewards-for-woocommerce' );
            endif;

            wc_get_template(
                'spin-record.php',
                array( 
                    'customer_name'  => $customer_name,
                    'win_label'      => $win_label,
                    'coupon_code'    => $coupon_code,
                    'settings'       => $settings,
                 ),
                'spin-rewards-for-woocommerce/',
                SRWC_TEMPLATE_PATH
            );
        }

    }

    new SRWC_Spin_Metabox();
endif;

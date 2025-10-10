<?php
/**
 * Register Spin Wheel Records CPT for SRWC plugin
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'SRWC_Spin_Wheel_Metabox' ) ) :

    /**
     * Class SRWC_Spin_Wheel_Metabox
     *
     * Handles the registration of the Spin Wheel Records Custom Post Type.
     */
    class SRWC_Spin_Wheel_Metabox {

        /**
         * Constructor for the SRWC_Spin_Wheel_Metabox class.
         * Hooks into WordPress to register the custom post type and statuses.
         */
        public function __construct() {
            add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
        }

        /**
         * Add meta boxes for spin records
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
         * Render the spin record meta box
         */
        public function render_spin_wheel_metabox( $post ) {
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
                 ),
                'spin-rewards-for-woocommerce/',
                SRWC_TEMPLATE_PATH
            );
        }

    }

    new SRWC_Spin_Wheel_Metabox();
endif;

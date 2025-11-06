<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'SRWC_Spin_Metabox' ) ) :

    /**
     * Class SRWC_Spin_Metabox
     *
     * Handles the registration of the Spin Metabox.
     */
    class SRWC_Spin_Metabox {

         /**
         * Constructor for the class.
         */
        public function __construct() {
            $this->events_handler();
        }

        /**
         * Initialize hooks and filters.
         */
        public function events_handler(){
            add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
            add_action( 'save_post', [ $this, 'save_metabox_data' ] );
            add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_styles' ] );
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

            $settings        = get_option( 'srwc_settings', array() );
            $customer_name   = get_post_meta( $post->ID, 'srwc_customer_name', true );
            $win_label       = get_post_meta( $post->ID, 'srwc_win_label', true );
            $coupon_code     = get_post_meta( $post->ID, 'srwc_coupon_code', true );
            $customer_mobile = get_post_meta( $post->ID, 'srwc_customer_mobile', true );

            if ( empty( $customer_name ) ) :
                $customer_name = esc_html__( 'Sir/Ma\'am', 'spin-rewards-for-woocommerce' );
            endif;

            wc_get_template(
                'spin-record.php',
                array( 
                    'customer_name'   => $customer_name,
                    'customer_mobile' => $customer_mobile,
                    'win_label'       => $win_label,
                    'coupon_code'     => $coupon_code,
                    'settings'        => $settings,
                 ),
                'spin-rewards-for-woocommerce/',
                SRWC_TEMPLATE_PATH
            );
        }

        public function save_metabox_data( $post_id ) {

            // Avoid autosave, ajax, or if user lacks permission
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
            if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) return;
            if ( ! current_user_can( 'edit_post', $post_id ) ) return;

            if ( ! isset( $_POST['spin_rewards_nonce'] ) || ! 
            wp_verify_nonce( 
                sanitize_text_field( wp_unslash( $_POST['spin_rewards_nonce'] ) ), 
                'spin_rewards_save_nonce' 
                ) 
            ) :
                return;
            endif;

            if ( isset( $_POST['srwc_customer_name'] ) ) :
                update_post_meta( $post_id, 'srwc_customer_name', sanitize_text_field( wp_unslash( $_POST['srwc_customer_name'] ) ) );
            endif;

            if ( isset( $_POST['srwc_customer_mobile'] ) ) :
                update_post_meta( $post_id, 'srwc_customer_mobile', sanitize_text_field( wp_unslash( $_POST['srwc_customer_mobile'] ) ) );
            endif;

            if ( isset( $_POST['srwc_win_label'] ) ) :
                update_post_meta( $post_id, 'srwc_win_label', sanitize_text_field( wp_unslash( $_POST['srwc_win_label'] ) ) );
            endif;  
        }

    }

    new SRWC_Spin_Metabox();
endif;

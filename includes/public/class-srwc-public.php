<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_Public' ) ) :

    class SRWC_Public {

        private $settings;

        public function __construct() {
            $this->settings = get_option( 'srwc_settings', array() );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
            add_action( 'wp_footer', array( $this, 'display_wheel' ), 20 );
        }
        
        
        public function enqueue_assets() {
            
             wp_enqueue_style( 
                'frontend-style', 
                SRWC_URL . 'assets/css/frontend-style.css', 
                array(), 
                SRWC_VERSION 
            );

            wp_enqueue_script( 
                'srwc-frontend', 
                SRWC_URL . 'assets/js/srwc-frontend.js', 
                array('jquery'), 
                SRWC_VERSION,
                true
            );

            $slides = array();
            if ( isset( $this->settings['slides'] ) && is_array( $this->settings['slides'] ) ) {
                $slides = $this->settings['slides'];
            }

            wp_localize_script( 'srwc-frontend', 'srwc_frontend', array(
                'ajax_url'  => admin_url( 'admin-ajax.php' ),
                'nonce'     => wp_create_nonce( 'srwc_nonce' ),
                'slides'    => $slides,
                'labels'    => wp_json_encode( $slides ),
                'settings'  => $this->settings,
                'checkout_url' => function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : '/checkout/',
                'messages'  => array(
                    'email_required' => esc_html__( 'Please enter your email.', 'spin-rewards-for-woocommerce' ),
                    'email_invalid'  => esc_html__( 'Please enter a valid email address.', 'spin-rewards-for-woocommerce' ),
                    'name_required'  => esc_html__( 'Please enter your name.', 'spin-rewards-for-woocommerce' ),
                    'failed_generate_coupon' => esc_html__( 'Failed to generate coupon.', 'spin-rewards-for-woocommerce' ),
                ),
            ) );
            
            $dynamic_css = $this->dynamic_css();

            if ( ! empty( $dynamic_css ) ) :
                wp_add_inline_style( 'frontend-style', $dynamic_css );
            endif;
        }

        public function dynamic_css(){
            ob_start();

            wc_get_template(
                'dynamic-style.php', 
                array(
                    'settings'  => $this->settings
                ),
                'spin-rewards-for-woocommerce/',
                SRWC_TEMPLATE_PATH
            );

            return ob_get_clean();
        }

        public function display_wheel() {
            // Check if plugin is enabled
            if ( empty( $this->settings['enable'] ) || $this->settings['enable'] !== 'yes' ) {
                return; 
            }

            wc_get_template(
                'spin-wheel.php',
                array(
                    'settings' => $this->settings,
                ),
                'spin-rewards-for-woocommerce/',
                SRWC_TEMPLATE_PATH
            );
        }
    }

    new SRWC_Public();
endif;

<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_Public' ) ) :

    class SRWC_Public {

        /**
		 * Plugin settings.
		 *
		 * @var array
		 */
        public $settings;

         /**
		 * Initialize hooks.
		 */
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
            if ( isset( $this->settings['slides'] ) && is_array( $this->settings['slides'] ) ) :
                $slides = $this->settings['slides'];
            endif;

            wp_localize_script( 'srwc-frontend', 'srwc_frontend', array(
                'ajax_url'  => admin_url( 'admin-ajax.php' ),
                'nonce'     => wp_create_nonce( 'srwc_nonce' ),
                'slides'    => SRWC_Helpers::srwc_slide_labels( $slides ),
                'labels'    => wp_json_encode( $slides ),
                'settings'  => $this->settings,
                'waitMilliseconds' => SRWC_Helpers::get_wait_milliseconds(),
                'checkout_url' => function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : '/checkout/',
                'currency_symbol' => get_woocommerce_currency_symbol(),
                'messages'  => array(
                    'email_required' => !empty($this->settings['email_required_message']) ? $this->settings['email_required_message'] : esc_html__( 'Please enter your email.', 'spin-rewards-for-woocommerce' ),
                    'email_invalid'  => !empty($this->settings['email_invalid_message']) ? $this->settings['email_invalid_message'] : esc_html__( 'Please enter a valid email address.', 'spin-rewards-for-woocommerce' ),
                    'name_required'  => !empty($this->settings['name_required_message']) ? $this->settings['name_required_message'] : esc_html__( 'Please enter your name.', 'spin-rewards-for-woocommerce' ),
                    'failed_generate_coupon' => esc_html__( 'Failed to generate coupon.', 'spin-rewards-for-woocommerce' ),
                    'wait_spin' =>  esc_html__( 'You must wait %s before spinning again.', 'spin-rewards-for-woocommerce' ),
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
            if ( empty( $this->settings['enable'] ) || $this->settings['enable'] !== 'yes' ) :
                return;
            endif;
        
            $show_on = false;
        
            // Always check pages
            if ( ! empty( $this->settings['shop_page'] ) && $this->settings['shop_page'] === 'yes' && is_shop() ) :
                $show_on = true;
            endif;
        
            if ( ! empty( $this->settings['home_page'] ) && $this->settings['home_page'] === 'yes' && is_front_page() ) :
                $show_on = true;
            endif;
        
            if ( ! empty( $this->settings['blog_page'] ) && $this->settings['blog_page'] === 'yes' && ( is_home() || is_singular('post') ) ) :
                $show_on = true;
            endif;
        
            // Conditional tags run always if set
            if ( ! empty( $this->settings['conditional_tags'] ) ) :
                $conditional = trim( $this->settings['conditional_tags'] );
                $conditional_result = SRWC_Helpers::evaluate_conditionals( $conditional );
                $show_on = $show_on || $conditional_result; 
            endif;
        
            if ( ! $show_on ) :
                return;
            endif;

            wc_get_template(
                'spin-wheel.php',
                array( 'settings' => $this->settings ),
                'spin-rewards-for-woocommerce/',
                SRWC_TEMPLATE_PATH
            );
        }

    }

    new SRWC_Public();
endif;

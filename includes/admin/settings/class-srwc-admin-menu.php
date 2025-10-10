<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_Admin_Menu' ) ) :

    /**
     * Main SRWC_Admin_Menu Class
     *
     * @class SRWC_Admin_Menu
     * @version 1.0.0
     */
    final class SRWC_Admin_Menu {

        /**
         * The single instance of the class.
         *
         * @var SRWC_Admin_Menu
         */
        protected static $instance = null;


        public $settings;
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
            // menu\
            $this->settings = get_option( 'srwc_settings', [] );
            add_action( 'admin_init', [ $this, 'register_settings' ] );
            add_action( 'admin_menu', [ $this, 'admin_menu' ] );
            add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_styles' ], 15 );
            add_action( 'pre_update_option_srwc_settings', [ $this, 'filter_data_before_update' ], 10, 3 );
        }

        /*
        * Main SRWC_Admin_Menu Instance.
        *
        * Ensures only one instance of SRWC_Admin_Menu is loaded or can be loaded.
        *
        * @static
        * @return SRWC_Admin_Menu - Main instance.
        */
        public function register_settings() {
            register_setting(
                'srwc_settings',
                'srwc_settings',[ 'sanitize_callback' => [ $this, 'sanitize_settings' ], ]
            );
        }

        /**
         * Sanitize settings and add success message.
         */
        public function sanitize_settings( $input ) {
            add_settings_error(
                'srwc_settings',
                'srwc_settings_updated',
                esc_html__( 'Settings saved successfully.', 'spin-rewards-for-woocommerce' ),
                'updated'
            );
            return $input;
        }

        /**
         * Admin menu for the plugin.
         */
        public function admin_menu() {
            add_submenu_page( 
                'woocommerce', 
                esc_html__( 'Spin Rewards', 'spin-rewards-for-woocommerce' ), 
                esc_html__( 'Spin Rewards', 'spin-rewards-for-woocommerce' ), 
                'manage_options', 
                'cosmic-srwc', 
                [ $this,'admin_menu_content' ] 
            );

            // Add Spin Records submenu
            add_menu_page(
                esc_html__( 'Spin Records', 'spin-rewards-for-woocommerce' ), // Page title
                esc_html__( 'Spin Records', 'spin-rewards-for-woocommerce' ), // Menu title
                'manage_options',                                             // Capability
                'edit.php?post_type=srwc_spin_record',                        // Menu slug
                '',                                                           // Callback not needed
                'dashicons-awards',                                           // Trophy Icon for Rewards
                30                                                            // Position (optional)
            );

            // Add Reports submenu
            add_submenu_page(
                'edit.php?post_type=srwc_spin_record',                        // Parent slug
                esc_html__( 'Reports', 'spin-rewards-for-woocommerce' ),      // Page title
                esc_html__( 'Reports', 'spin-rewards-for-woocommerce' ),      // Menu title
                'manage_options',                                             // Capability
                'srwc-reports',                                               // Menu slug
                [ $this, 'reports_page_content' ]                             // Callback
            );
        }
        
        /**
         * Enqueue admin styles.
         */
        public function enqueue_admin_styles() {

            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker' );
            
            // Enqueue WordPress media
            wp_enqueue_media();

            wp_enqueue_style( 
                'select2', 
                SRWC_URL . 'assets/lib/select2.min.css', 
                array(), 
                SRWC_VERSION
            );

            wp_enqueue_script( 
                'select2', 
                SRWC_URL . 'assets/lib/select2.min.js', 
                array( 'jquery' ), 
                SRWC_VERSION, 
                true 
            );

            wp_enqueue_style( 
                'srwc-admin-style', 
                SRWC_URL . 'assets/css/admin-style.css', 
                array(), 
                SRWC_VERSION 
            );
            wp_enqueue_style( 'woocommerce_admin_styles' );

            wp_enqueue_script( 
                'srwc-admin', 
                SRWC_URL . 'assets/js/srwc-admin.js', 
                array('jquery', 'wp-color-picker', 'media-upload', 'media-views' ), 
                SRWC_VERSION,
                true
            );

            // Localize script for AJAX
            wp_localize_script( 'srwc-admin', 'srwc_admin', array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'nonce'    => wp_create_nonce( 'srwc_admin_nonce' ),
                'messages' => array(
                    'min_slides' => esc_html__( 'You must have at least 3 slides.', 'spin-rewards-for-woocommerce' ),
                    'max_slides' => esc_html__( 'You can only add up to 6 slides.', 'spin-rewards-for-woocommerce' ),
                ),
            ) );
        }

        /**
         * Content for the admin menu page.
         */
        public function admin_menu_content() {

            $active_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'general';
            require_once SRWC_PATH . 'includes/admin/settings/views/rewards-menu.php';
        }

        public function reports_page_content() {
            require_once SRWC_PATH . 'includes/admin/settings/views/reports.php';
        }

        public function filter_data_before_update( $value, $old_value, $option ) {

            $value     = (array) $value;
            $old_value = (array) $old_value;

            if ( isset( $value['slides'] ) && is_array( $value['slides'] ) ) :
                $slides = $value['slides'];
                $formatted_slides = array();

                if ( isset( $slides['coupon_type'] ) && is_array( $slides['coupon_type'] ) ) :
                    $count = count( $slides['coupon_type'] );

                    for ( $i = 0; $i < $count; $i++ ) :
                        if ( $i == 0 ) continue;

                        $formatted_slides[] = array(
                            'coupon_type' => isset( $slides['coupon_type'][$i] ) ? sanitize_text_field( $slides['coupon_type'][$i] ) : 'none',
                            'label'       => isset( $slides['label'][$i] ) ? sanitize_text_field( $slides['label'][$i] ) : '',
                            'value'       => isset( $slides['value'][$i] ) ? floatval( $slides['value'][$i] ) : 0,
                            'coupon_code' => isset( $slides['coupon_code'][$i] ) ? sanitize_text_field( $slides['coupon_code'][$i] ) : '',
                            'custom_value' => isset( $slides['custom_value'][$i] ) ? sanitize_text_field( $slides['custom_value'][$i] ) : '',
                            'probability' => isset( $slides['probability'][$i] ) ? floatval( $slides['probability'][$i] ) : 0,
                            'color'       => isset( $slides['color'][$i] ) ? sanitize_hex_color( $slides['color'][$i] ) : '#ffe0b2',
                        );
                    endfor;
                endif;

                $value['slides'] = $formatted_slides;
            endif;

            $data = array_merge( $old_value, $value );
            return $data;
        }


    }

    // Initialize the class.
    new SRWC_Admin_Menu();

endif;

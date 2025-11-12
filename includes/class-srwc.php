<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC' ) ) :

    /**
     * Main SRWC Class
     *
     * @class SRWC
     * @version 1.0.0
     */
    final class SRWC {

        /**
         * The single instance of the class.
         *
         * @var SRWC
         */
        protected static $instance = null;

        /**
         * The public class instance.
         *
         * @var SRWC_Public
         */
        public $public = null;

        /**
         * Constructor for the class.
         */
        public function __construct() {
            $this->events_handler();
            $this->includes();
        }

        /**
         * Initialize hooks and filters.
         */
        private function events_handler() {
            // Register plugin activation hook
            register_activation_hook( SRWC_FILE, array( 'SRWC_Install', 'install' ) );

            // Hook to install the plugin after plugins are loaded
            add_action( 'plugins_loaded', array( $this, 'SRWC_Install' ), 11 );
            add_action( 'srwc_init', array( $this, 'includes' ), 11 );
        }

        /**
         * Main SRWC Instance.
         *
         * Ensures only one instance of SRWC is loaded or can be loaded.
         *
         * @static
         * @return SRWC - Main instance.
         */
        public static function instance() {
            if ( is_null( self::$instance ) ) :
                self::$instance = new self();

                /**
                 * Fire a custom action to allow dependencies
                 * after the successful plugin setup
                 */
                do_action( 'srwc_plugin_loaded' );
            endif;
            return self::$instance;
        }

        /**
         * Function to display admin notice if WooCommerce is not active.
         */
        public function woocommerce_admin_notice() {
            ?>
            <div class="error">
                <p><?php esc_html_e( 'Win Wheel for WooCommerce requires WooCommerce to be installed and activated in order to work properly.', 'spin-rewards-for-woocommerce' ); ?></p>
            </div>
            <?php
        }

        /**
         * Function to initialize the plugin after WooCommerce is loaded.
         */
        public function SRWC_Install() {
            if ( ! function_exists( 'WC' ) ) :
                add_action( 'admin_notices', array( $this, 'woocommerce_admin_notice' ) );
            else :
                do_action( 'srwc_init' );
            endif;
        }

        /**
         * Flush rewrite rules on plugin activation.
         */
        public static function plugin_activate() {
            
            // Save default options on first activation
            $default_options = include_once SRWC_PATH . 'includes/static/srwc-default-option.php';
            $existingOption  = get_option( 'srwc_settings' );

            // If the option is not set, update it with the default value
            if ( ! $existingOption ) :
                update_option( 'srwc_settings', $default_options['srwc_settings'] );
            endif;
        }

        /**
         * Include required files.
         */
        public function includes() {
            if ( is_admin() ) :
                $this->includes_admin();
           else :
                $this->includes_public();
            endif;
            
            require_once SRWC_PATH . 'includes/public/class-srwc-mailchimp.php';
            require_once SRWC_PATH . 'includes/admin/settings/class-srwc-options.php';
            require_once SRWC_PATH . 'includes/email/class-srwc-email.php';
            require_once SRWC_PATH . 'includes/public/class-srwc-offer-coupon.php';
            require_once SRWC_PATH . 'includes/public/class-srwc-spin-loss-records.php';
        }
        
        /**
         * Include Admin required files.
         */
        public function includes_admin() {
            require_once SRWC_PATH . 'includes/class-srwc-install.php';
            require_once SRWC_PATH . 'includes/admin/tab/class-srwc-tab.php';
            require_once SRWC_PATH . 'includes/admin/settings/class-srwc-admin-menu.php';
            require_once SRWC_PATH . 'includes/admin/settings/class-srwc-coupon-handler.php';
            require_once SRWC_PATH . 'includes/admin/settings/class-srwc-setting-fields.php';
            require_once SRWC_PATH . 'includes/admin/settings/class-srwc-spin-email-limit.php';
            require_once SRWC_PATH . 'includes/admin/settings/class-srwc-spin-metabox.php';
            require_once SRWC_PATH . 'includes/admin/settings/class-srwc-spin-record-cpt.php';
            require_once SRWC_PATH . 'includes/admin/settings/class-srwc-spin-records.php';
            require_once SRWC_PATH . 'includes/admin/settings/class-srwc-spin-reports.php';
        }
        
        /**
         * Include Public required files.
         */
        public function includes_public() {
            require_once SRWC_PATH . 'includes/public/class-srwc-public.php';
            require_once SRWC_PATH . 'includes/public/class-srwc-helpers.php';
        }
    }

endif;

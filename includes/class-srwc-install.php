<?php

/**
 * Installation related functions and actions.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_Install' ) ) :

    /**
     * SRWC_Install Class
     *
     * Handles installation processes like creating database tables,
     * setting up roles, and creating necessary pages on plugin activation.
     */
    class SRWC_Install {

        /**
         * Hook into WordPress actions and filters.
         */
        public static function init() {
            add_filter( 'plugin_action_links_' . plugin_basename( SRWC_FILE ), array( __CLASS__, 'plugin_action_links' ) );
        }

        /**
         * Install plugin.
         *
         * Creates tables, roles, and necessary pages on plugin activation.
         */
        public static function install() {
            if ( ! is_blog_installed() ) :
                return;
            endif;

            self::create_tables();
        }

        /**
         * Create database tables.
         */
        private static function create_tables() {
            global $wpdb;

            $charset_collate = $wpdb->get_charset_collate();

            // Create spin logs table
            $table_name = $wpdb->prefix . 'srwc_spin_logs';
            
            $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                email varchar(100) NOT NULL,
                name varchar(100) DEFAULT '',
                result text DEFAULT '',
                ip_address varchar(45) DEFAULT '',
                user_agent text DEFAULT '',
                created_at datetime DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id),
                KEY email (email),
                KEY created_at (created_at)
            ) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }

        /**
         * Add plugin action links.
         *
         * @param array $links Array of action links.
         * @return array Modified array of action links.
         */
        public static function plugin_action_links( $links ) {
            $action_links = array(
                'settings' => sprintf(
                    '<a href="%s" aria-label="%s">%s</a>',
                    admin_url( 'admin.php?page=cosmic-srwc' ),
                    esc_attr__( 'Settings', 'spin-rewards-for-woocommerce' ),
                    esc_html__( 'Settings', 'spin-rewards-for-woocommerce' )
                ),
            );
            return array_merge( $action_links, $links );
        }

    }

    // Initialize the installation process
    SRWC_Install::init();

endif;

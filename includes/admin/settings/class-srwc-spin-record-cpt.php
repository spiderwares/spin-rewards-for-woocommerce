<?php
/**
 * Register Spin Rewards Records CPT for SRWC plugin
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Prevent direct access to this file.
 * This file is part of the Spin Rewards for WooCommerce plugin.
 * It handles the registration of the Spin Rewards Records Custom Post Type.
 */
if( ! class_exists( 'SRWC_Spin_Records_CPT' ) ) :

    /**
     * Class SRWC_Spin_Records_CPT
     *
     * Handles the registration of the Spin Rewards Records Custom Post Type.
     */
    class SRWC_Spin_Records_CPT {

        /**
         * Constructor for the SRWC_Spin_Records_CPT class.
         * Hooks into WordPress to register the custom post type and statuses.
         */
        public function __construct() {
            add_action( 'init', array( $this, 'register_spin_records_cpt' ) );
            add_action( 'init', array( $this, 'flush_rules' ), 99 );
            add_filter( 'manage_srwc_spin_record_posts_columns', [ $this, 'add_columns' ] );
            add_action( 'manage_srwc_spin_record_posts_custom_column', [ $this, 'render_column_data' ], 10, 2 );
        }

        /**
         * Registers the Spin Rewards Records Custom Post Type.
         */
        public function register_spin_records_cpt() {
            $labels = array(
               'name'                    => esc_html__( 'Spin Rewards Records', 'spin-rewards-for-woocommerce' ),
					'singular_name'      => esc_html__( 'Spin Record', 'spin-rewards-for-woocommerce' ),
					'menu_name'          => esc_html__( 'Spin Records', 'spin-rewards-for-woocommerce' ),
					'name_admin_bar'     => esc_html__( 'Spin Record', 'spin-rewards-for-woocommerce' ),
					'view_item'          => esc_html__( 'View Spin Record', 'spin-rewards-for-woocommerce' ),
					'all_items'          => esc_html__( 'All Spin Records', 'spin-rewards-for-woocommerce' ),
					'search_items'       => esc_html__( 'Search Spin Records', 'spin-rewards-for-woocommerce' ),
					'parent_item_colon'  => esc_html__( 'Parent Spin Record:', 'spin-rewards-for-woocommerce' ),
					'not_found'          => esc_html__( 'No spin records found.', 'spin-rewards-for-woocommerce' ),
					'not_found_in_trash' => esc_html__( 'No spin records found in Trash.', 'spin-rewards-for-woocommerce' )
            );

            $args = array(
                'labels'              => $labels,
                'description'         => esc_html__( 'Spin Rewards Records for WooCommerce.', 'spin-rewards-for-woocommerce' ),
				'public'              => false,
				'show_ui'             => true,
				'capability_type'     => 'post',
				'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
				'map_meta_cap'        => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'show_in_menu'        => false,
				'hierarchical'        => false,
				'rewrite'             => false,
				'query_var'           => false,
				'supports'            => array( 'title' ),
				'show_in_nav_menus'   => false,
				'show_in_admin_bar'   => false,
            );

            register_post_type( 'srwc_spin_record', $args );
        }


        /**
         * Flush rewrite rules once after CPT is registered.
         */
        public function flush_rules() {
            if ( get_option( 'srwc_flush_rewrite_rules', true ) ) :
                flush_rewrite_rules();
                update_option( 'srwc_flush_rewrite_rules', false );
            endif;
        }

        /**
         * Adds custom columns to the Spin Records CPT list table.
         */
        public function add_columns( $columns ) {
            unset( $columns['date'] );

            // Only show customer name column if user_name is enabled
            $settings = get_option( 'srwc_settings', array() );
            if ( !empty( $settings['user_name'] ) && $settings['user_name'] === 'yes' ) :
                $columns['customer_name'] = esc_html__( 'Customer Name', 'spin-rewards-for-woocommerce' );
            endif;
            
            $columns['win_label']   = esc_html__( 'Win Label', 'spin-rewards-for-woocommerce' );
            $columns['coupon_code'] = esc_html__( 'Coupon Code', 'spin-rewards-for-woocommerce' );
            $columns['spin_date']   = esc_html__( 'Date', 'spin-rewards-for-woocommerce' );

            return $columns;
        }

        /**
         * Renders custom column data.
         */
        public function render_column_data( $column, $post_id ) {
            switch ( $column ) :

                case 'customer_name':
                    // Only render if user_name is enabled
                    $settings = get_option( 'srwc_settings', array() );
                    if ( !empty( $settings['user_name'] ) && $settings['user_name'] === 'yes' ) :
                        $name = get_post_meta( $post_id, 'srwc_customer_name', true );
                        echo esc_html( $name ? $name : 'Sir/Ma\'am' );
                    endif;
                    break;

                case 'win_label':
                    $label = get_post_meta( $post_id, 'srwc_win_label', true );
                    echo esc_html( $label ? $label : '-' );
                    break;

                case 'coupon_code':
                    $coupon_code = get_post_meta( $post_id, 'srwc_coupon_code', true );
                    if ( $coupon_code ) :
                        echo '<code>' . esc_html( $coupon_code ) . '</code>';
                    else :
                        echo '-';
                    endif;
                    break;

                case 'spin_date':
                    $spin_date = get_post_meta( $post_id, 'srwc_spin_date', true );
                    if ( $spin_date ) :
                        echo esc_html( date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $spin_date ) ) );
                    else :
                        echo '-';
                    endif;
                    break;

            endswitch;
        }
        
    }

    new SRWC_Spin_Records_CPT();
endif;

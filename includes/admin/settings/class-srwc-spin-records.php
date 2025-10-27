<?php
/**
 * Register Spin Records for SRWC plugin
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'SRWC_Spin_Records' ) ) :

    /**
     * Class SRWC_Spin_Records
     *
     * Handles the registration of the Spin Records.
     */
    class SRWC_Spin_Records {

        /**
         * Check if email has exceeded spin limit.
         *
         * @param string $email Customer email address
         * @return bool|int Returns false if no limit or limit not exceeded, or number of spins used if limit exceeded
         */
        public static function check_email_spin_limit( $email ) {
            if ( empty( $email ) ) :
                return false;
            endif;
            $settings = get_option( 'srwc_settings', array() );
            $spin_limit = ! empty( $settings['spin_per_email'] ) ? absint( $settings['spin_per_email'] ) : 0;

            if ( $spin_limit <= 0 ) :
                return false;
            endif;

            $args = array(
                'post_type'         => 'srwc_spin_record',
                'post_status'       => 'publish',
                'posts_per_page'    => -1,
                'meta_query'        => array(
                    array(
                        'key'       => 'srwc_customer_email',
                        'value'     => sanitize_email( $email ),
                        'compare'   => '='
                    )
                )
            );

            $existing_spins = get_posts( $args );
            $spin_count = count( $existing_spins );

            return ( $spin_count >= $spin_limit ) ? $spin_count : false;
        }

        /**
         * Create spin record.
         *
         * @param array $data Spin record data.
         * @return int|false Post ID if successful, false otherwise.
         */
        public static function create_spin_record( $data ) {
            $defaults = array(
                'customer_email' => '',
                'customer_name'  => '',
                'customer_mobile' => '',
                'win_label'      => '',
                'coupon_code'    => '',
                'coupon_type'    => '',
                'coupon_value'   => '',
                'spin_date'      => current_time( 'mysql' )
            );

            $data   = wp_parse_args( $data, $defaults );

            /* translators: %s: Customer email or "Guest" if not logged in. */
            $title  = sprintf( 
                esc_html__( 'Spin record - %s', 'spin-rewards-for-woocommerce' ), 
                $data['customer_email'] ? $data['customer_email'] : esc_html__( 'Guest', 'spin-rewards-for-woocommerce' )
            );

            $post_data = array(
                'post_title'   => $title,
                'post_status'  => 'publish',
                'post_type'    => 'srwc_spin_record',
                'post_author'  => 1, 
            );

            $post_id = wp_insert_post( $post_data );

            if ( $post_id && ! is_wp_error( $post_id ) ) :
                update_post_meta( $post_id, 'srwc_customer_email', sanitize_email( $data['customer_email'] ) );
                update_post_meta( $post_id, 'srwc_customer_name', sanitize_text_field( $data['customer_name'] ) );
                update_post_meta( $post_id, 'srwc_customer_mobile', sanitize_text_field( $data['customer_mobile'] ) );
                update_post_meta( $post_id, 'srwc_win_label', sanitize_text_field( $data['win_label'] ) );
                update_post_meta( $post_id, 'srwc_coupon_code', sanitize_text_field( $data['coupon_code'] ) );
                update_post_meta( $post_id, 'srwc_spin_date', sanitize_text_field( $data['spin_date'] ) );

                return $post_id;
            endif;

            return false;
        }
    }

    new SRWC_Spin_Records();
endif;

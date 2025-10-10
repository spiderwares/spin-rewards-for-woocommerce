<?php
/**
 * Register Spin Wheel Records CPT for SRWC plugin
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'SRWC_Spin_Wheel_Records' ) ) :

    class SRWC_Spin_Wheel_Records {

        public static function create_spin_record( $data ) {
            $defaults = array(
                'customer_email' => '',
                'customer_name'  => '',
                'win_label'      => '',
                'coupon_code'    => '',
                'coupon_type'    => '',
                'coupon_value'   => '',
                'spin_date'      => current_time( 'mysql' )
            );

            $data = wp_parse_args( $data, $defaults );

            // Create post title
            $title = sprintf( 
                esc_html__( '%s', 'spin-rewards-for-woocommerce' ), 
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
                // Save meta data
                update_post_meta( $post_id, 'srwc_customer_email', sanitize_email( $data['customer_email'] ) );
                update_post_meta( $post_id, 'srwc_customer_name', sanitize_text_field( $data['customer_name'] ) );
                update_post_meta( $post_id, 'srwc_win_label', sanitize_text_field( $data['win_label'] ) );
                update_post_meta( $post_id, 'srwc_coupon_code', sanitize_text_field( $data['coupon_code'] ) );
                update_post_meta( $post_id, 'srwc_spin_date', sanitize_text_field( $data['spin_date'] ) );

                return $post_id;
            endif;

            return false;
        }

    }

    new SRWC_Spin_Wheel_Records();
endif;

<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_Coupon' ) ) :

    class SRWC_Coupon {

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

            // AJAX handler
            add_action( 'wp_ajax_srwc_generate_coupon', array( $this, 'generate_coupon' ) );
            add_action( 'wp_ajax_nopriv_srwc_generate_coupon', array( $this, 'generate_coupon' ) );
        }

        /**
		 * Generate coupon.
		 */
        public function generate_coupon() {
            // Verify nonce for security
            if ( ! isset( $_POST['nonce'] ) || ! 
                wp_verify_nonce( 
                    sanitize_text_field( wp_unslash( $_POST['nonce'] ) ),
                    'srwc_nonce' 
                )
            ) :
                return;
            endif;

            $coupon_type   = isset( $_POST['coupon_type'] ) ? sanitize_text_field( wp_unslash( $_POST['coupon_type'] ) ) : 'percent';
            $value         = isset( $_POST['value'] ) ? floatval( wp_unslash( $_POST['value'] ) ) : 0;
            $win_label     = isset( $_POST['win_label'] ) ? sanitize_text_field( wp_unslash( $_POST['win_label'] ) ) : '';
            $customer_name = isset( $_POST['customer_name'] ) ? sanitize_text_field( wp_unslash( $_POST['customer_name'] ) ) : '';
        
            if ( ! empty( $_POST['customer_email'] ) ) :
                $customer_email = sanitize_email( wp_unslash( $_POST['customer_email'] ) );
            endif;
        
            // settings
            $code_type   = ! empty( $this->settings['code_type'] ) ? $this->settings['code_type'] : 'alphanumeric';
            $code_length = ! empty( $this->settings['coupon_length'] ) ? absint( $this->settings['coupon_length'] ) : 6;
            $prefix      = ! empty( $this->settings['coupon_prefix'] ) ? strtoupper( sanitize_text_field( $this->settings['coupon_prefix'] ) ) : '';
            $suffix      = ! empty( $this->settings['coupon_suffix'] ) ? strtoupper( sanitize_text_field( $this->settings['coupon_suffix'] ) ) : '';
            $expiry_days = ! empty( $this->settings['coupon_expiry_days'] ) ? absint( $this->settings['coupon_expiry_days'] ) : 7;
        
            $usage_limit            = ! empty( $this->settings['limit_coupon'] ) ? absint( $this->settings['limit_coupon'] ) : 1;
            $usage_limit_per_item   = ! empty( $this->settings['limit_coupon_to_x_items'] ) ? absint( $this->settings['limit_coupon_to_x_items'] ) : '';
            $usage_limit_per_user   = ! empty( $this->settings['limit_coupon_per_user'] ) ? absint( $this->settings['limit_coupon_per_user'] ) : '';
            $individual_use         = ! empty( $this->settings['individual_use_only'] ) && $this->settings['individual_use_only'] === 'yes' ? 'yes' : 'no';
            $exclude_sale           = ! empty( $this->settings['exclude_sale'] ) && $this->settings['exclude_sale'] === 'yes' ? 'yes' : 'no';
            $minimum_spend          = ! empty( $this->settings['minimum_spend'] ) ? floatval( $this->settings['minimum_spend'] ) : '';
            $maximum_spend          = ! empty( $this->settings['maximum_spend'] ) ? floatval( $this->settings['maximum_spend'] ) : '';
        
            $include_products       = ! empty( $this->settings['include_products'] ) ? $this->settings['include_products'] : array();
            $exclude_products       = ! empty( $this->settings['exclude_products'] ) ? $this->settings['exclude_products'] : array();
            $include_categories     = ! empty( $this->settings['include_categories'] ) ? $this->settings['include_categories'] : array();
            $exclude_categories     = ! empty( $this->settings['exclude_categories'] ) ? $this->settings['exclude_categories'] : array();
        
            // build coupon code
            $random_length = $code_length - strlen( $prefix ) - strlen( $suffix );
            $random_length = $random_length < 1 ? 1 : $random_length;
            $allowed       = ( $code_type === 'numeric' ) ? '0123456789' : 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        
            $random = '';
            for ( $i = 0; $i < $random_length; $i++ ) :
                $random .= $allowed[ wp_rand( 0, strlen( $allowed ) - 1 ) ];
            endfor;
        
            $coupon_code = strtoupper( $prefix . $random . $suffix );
        
            $coupon = array(
                'post_title'  => $coupon_code,
                'post_status' => 'publish',
                'post_author' => get_current_user_id(),
                'post_type'   => 'shop_coupon',
            );
        
            $new_coupon_id = wp_insert_post( $coupon );
        
            if ( $new_coupon_id ) :
                update_post_meta( $new_coupon_id, 'discount_type', $coupon_type );
                update_post_meta( $new_coupon_id, 'coupon_amount', $value );
                update_post_meta( $new_coupon_id, 'usage_limit', $usage_limit );
                update_post_meta( $new_coupon_id, 'limit_usage_to_x_items', $usage_limit_per_item );
                update_post_meta( $new_coupon_id, 'usage_limit_per_user', $usage_limit_per_user );
                update_post_meta( $new_coupon_id, 'individual_use', $individual_use );
                update_post_meta( $new_coupon_id, 'exclude_sale_items', $exclude_sale );
                update_post_meta( $new_coupon_id, 'minimum_amount', $minimum_spend );
                update_post_meta( $new_coupon_id, 'maximum_amount', $maximum_spend );
                update_post_meta( $new_coupon_id, 'product_ids', $include_products );
                update_post_meta( $new_coupon_id, 'exclude_product_ids', $exclude_products );
                update_post_meta( $new_coupon_id, 'product_categories', $include_categories );
                update_post_meta( $new_coupon_id, 'exclude_product_categories', $exclude_categories );

                $expiry_timestamp = $expiry_days ? strtotime( "+{$expiry_days} days" ) : '';
                update_post_meta( $new_coupon_id, 'date_expires', $expiry_timestamp );

                $date_expires   = $expiry_timestamp
                    ? date_i18n( function_exists( 'wc_date_format' ) ? wc_date_format() : get_option( 'date_format' ), $expiry_timestamp )
                    : '';

                // Create spin record
                if ( class_exists( 'SRWC_Spin_Records' ) ) :
                    $record_id = SRWC_Spin_Records::create_spin_record( array(
                        'customer_email' => $customer_email,
                        'customer_name'  => $customer_name,
                        'win_label'      => $win_label,
                        'coupon_code'    => $coupon_code,
                        'coupon_type'    => $coupon_type,
                        'spin_date'      => current_time( 'mysql' )
                    ) );
                endif;

                WC()->mailer();
                do_action( 'srwc_user_win_email', $customer_email, $coupon_code, $date_expires );

                do_action( 'srwc_admin_email', $customer_email, $coupon_code, $date_expires );

        
                wp_send_json_success( array(
                    'coupon_code'  => $coupon_code,
                    'date_expires' => $date_expires,
                ) );
                
            endif;
        
            wp_send_json_error( array( 'message' => 'Coupon creation failed' ) );
        }
        
        
    }

    new SRWC_Coupon();
endif;

<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_Helpers' ) ) :

    class SRWC_Helpers {

        /**
         * Get wait time between spins in milliseconds
         */
        public static function get_wait_milliseconds() {
            $settings = get_option( 'srwc_settings', array() );

            $time_spin_between      = isset( $settings['time_spin_between'] ) ? floatval( $settings['time_spin_between'] ) : 0;
            $time_spin_between_unit = ! empty( $settings['time_spin_between_unit'] ) ? $settings['time_spin_between_unit'] : 'hours';

            if ( $time_spin_between <= 0 ) :
                return 0;
            endif;

            $waitTime = $time_spin_between * 1000; 

            switch ( $time_spin_between_unit ) :
                case 'seconds':
                    $waitTime = $time_spin_between * 1000;
                    break;
                case 'minutes':
                    $waitTime = $time_spin_between * 60 * 1000;
                    break;
                case 'hours':
                    $waitTime = $time_spin_between * 60 * 60 * 1000;
                    break;
                case 'days':
                    $waitTime = $time_spin_between * 24 * 60 * 60 * 1000;
                    break;
            endswitch;

            return (int) $waitTime;
        }

        /**
         * Evaluate conditional tags
         */
        public static function evaluate_conditionals( $expression ) {
            $tags = array(
                'is_cart', 'is_checkout', 'is_product', 'is_shop',
                'is_product_category', 'is_home', 'is_front_page'
            );
        
            foreach ( $tags as $tag ) :
                if ( function_exists( $tag ) ) :
                    $value = $tag() ? 'true' : 'false';
                    $expression = preg_replace( '/\b' . $tag . '\(\)/', $value, $expression );
                endif;
            endforeach;
        
            $expression = str_replace( array( '||', '&&', '!' ), array( ' or ', ' and ', ' not ' ), $expression );
        
            if ( empty( $expression ) ) :
                return false;
            endif;
        
            return eval( 'return (' . $expression . ');' );
        }    

        /**
         * Format slide labels with coupon values
         */
        public static function srwc_slide_labels( $slides ) {
            foreach ( $slides as &$slide ) :
                if ( empty( $slide['coupon_type'] ) ) continue;
        
                $formatted  = '';
                $type       = $slide['coupon_type'];
        
                if ( $type === 'existing' && ! empty( $slide['coupon_code'] ) ) :
                    $coupon_id = function_exists( 'wc_get_coupon_id_by_code' ) ? wc_get_coupon_id_by_code( $slide['coupon_code'] ) : 0;
        
                    if ( $coupon_id ) :
                        $coupon = new WC_Coupon( $coupon_id );
                        $amount = $coupon->get_amount();
                        $discount_type = $coupon->get_discount_type();
        
                        if ( $discount_type === 'percent' ) :
                            $formatted = $amount . '%';
                        elseif ( in_array( $discount_type, array( 'fixed_cart', 'fixed_product' ), true ) ) :
                            $formatted = html_entity_decode( wp_strip_all_tags( wc_price( $amount ) ) );
                        else :
                            $formatted = $amount;
                        endif;
                    endif;
                
        
                elseif ( ! empty( $slide['value'] ) ) :
                    $value = floatval( $slide['value'] );
        
                    if ( $type === 'percent' ) :
                        $formatted = $value . '%';
                    elseif ( in_array( $type, array( 'fixed_cart', 'fixed_product' ), true ) ) :
                        $formatted = html_entity_decode( wp_strip_all_tags( wc_price( $value ) ) );
                    else :
                        $formatted = $value;
                    endif;
                endif;
        
                // Replace {coupon_amount} in Label
                if ( ! empty( $slide['label'] ) && $formatted ) :
                    $slide['label'] = str_replace( '{coupon_amount}', $formatted, $slide['label'] );
                endif;
            endforeach;
        
            return apply_filters( 'srwc_slide_labels_after', $slides );
        }
        
    }

endif;

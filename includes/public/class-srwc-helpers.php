<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_Helpers' ) ) :

class SRWC_Helpers {

    /**
     * Get wait time between spins in milliseconds
     *
     * @param array $settings Plugin settings
     * @return int Milliseconds
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
     *
     * @param string $expression Conditional expression
     * @return bool
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
    
        // Replace operators for eval compatibility
        $expression = str_replace( array( '||', '&&', '!' ), array( ' or ', ' and ', ' not ' ), $expression );
    
        // Basic safety check
        if ( empty( $expression ) ) :
            return false;
        endif;
    
        // Evaluate the final boolean expression
        return eval( 'return (' . $expression . ');' );
    }    

    /**
     * Format slide labels with coupon values
     *
     * @param array $slides slides data
     * @return array
     */
    public static function srwc_slide_labels( $slides ) {
        foreach ( $slides as &$slide ) :
            if ( ! empty( $slide['coupon_type'] ) && ! empty( $slide['value'] ) ) :
                $type  = $slide['coupon_type'];
                $value = floatval( $slide['value'] );
    
                if ( $type === 'percent' ) :
                    $formatted = $value . '%';
                elseif ( in_array( $type, array( 'fixed_cart', 'fixed_product' ), true ) ) :
                    $formatted = html_entity_decode( wp_strip_all_tags( wc_price( $value ) ) );
                else :
                    $formatted = $value;
                endif;
    
                if ( ! empty( $slide['label'] ) ) :
                    $slide['label'] = str_replace( '{coupon_amount}', $formatted, $slide['label'] );
                endif;
            endif;
        endforeach;

        $slides = apply_filters( 'srwc_slide_labels_after', $slides );
    
        return $slides;
    }
    
}

endif;

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

        $time_spin_between = ! empty( $settings['time_spin_between'] ) ? floatval( $settings['time_spin_between'] ) : 24;
        $time_spin_between_unit = ! empty( $settings['time_spin_between_unit'] ) ? $settings['time_spin_between_unit'] : 'hours';

        $waitMilliseconds = $time_spin_between * 1000; // default seconds

        switch ( $time_spin_between_unit ) {
            case 'minutes':
                $waitMilliseconds = $time_spin_between * 60 * 1000;
                break;
            case 'hours':
                $waitMilliseconds = $time_spin_between * 60 * 60 * 1000;
                break;
            case 'days':
                $waitMilliseconds = $time_spin_between * 24 * 60 * 60 * 1000;
                break;
            case 'seconds':
                $waitMilliseconds = $time_spin_between * 1000;
                break;
        }

        return (int) $waitMilliseconds;
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

        $expression = str_replace( array('||', '&&', '!'), array(' or ', ' and ', ' not '), $expression );

        try {
            return eval( 'return (' . $expression . ');' );
        } catch ( \Throwable $e ) {
            return false;
        }
    }

    /**
     * Format slide labels with coupon values
     *
     * @param array $slides Slides data
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
                    $formatted = html_entity_decode( strip_tags( wc_price( $value ) ) );
                else :
                    $formatted = $value;
                endif;

                if ( ! empty( $slide['label'] ) ) :
                    $slide['label'] = str_replace( '{coupon_amount}', $formatted, $slide['label'] );
                endif;
            endif;
        endforeach;

        return $slides;
    }
}

endif;

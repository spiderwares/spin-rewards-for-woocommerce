<?php
/**
 * Reports page view for Spin Rewards for WooCommerce
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// Get initial data
$args = array(
    'post_type'         => 'srwc_spin_record',
    'post_status'       => 'publish',
    'posts_per_page'    => -1
);

$spin_records = get_posts( $args );

// Calculate initial metrics
$total_spins        = count( $spin_records );
$emails_subscribed  = 0;
$coupons_given      = 0;

foreach ( $spin_records as $record ) :
    $email = get_post_meta( $record->ID, 'srwc_customer_email', true );
    $coupon_code = get_post_meta( $record->ID, 'srwc_coupon_code', true );

    if ( $email ) :
        $emails_subscribed++;
    endif;  
    if ( $coupon_code ) :
        $coupons_given++;
    endif;
endforeach;

wc_get_template(
    'spin-reports.php', 
    array(
        'total_spins'       => $total_spins,
        'emails_subscribed' => $emails_subscribed,
        'coupons_given'     => $coupons_given
    ),
    'spin-rewards-for-woocommerce/',
    SRWC_TEMPLATE_PATH
);

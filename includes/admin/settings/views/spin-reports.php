<?php
/**
 * Reports Page View
 *
 * Displays analytics summary for Spin Rewards for WooCommerce.
 *
 * @package Spin_Rewards_For_WooCommerce
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Fetch all spin record posts.
 */
$args = array(
    'post_type'      => 'srwc_spin_record',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
);

$spin_records = get_posts( $args );

/**
 * Initialize counters.
 */
$total_spins       = 0;
$emails_subscribed = 0;
$coupons_given     = 0;

if ( ! empty( $spin_records ) ) :
    $total_spins = count( $spin_records );

    foreach ( $spin_records as $record ) :
        $email       = get_post_meta( $record->ID, 'srwc_customer_email', true );
        $coupon_code = get_post_meta( $record->ID, 'srwc_coupon_code', true );

        if ( ! empty( $email ) ) :
            $emails_subscribed++;
        endif;

        if ( ! empty( $coupon_code ) ) :
            $coupons_given++;
        endif;
    endforeach;
endif;

/**
 * Load the template and pass data to it.
 */
wc_get_template(
    'spin-reports.php',
    array(
        'total_spins'       => $total_spins,
        'emails_subscribed' => $emails_subscribed,
        'coupons_given'     => $coupons_given,
    ),
    'spin-rewards-for-woocommerce/',
    SRWC_TEMPLATE_PATH
);

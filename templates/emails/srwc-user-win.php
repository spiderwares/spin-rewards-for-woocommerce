<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * SRWC User Win Email Template
 */

do_action( 'woocommerce_email_header', $email_heading, $email );

if ( ! empty( $email_body ) ) : ?>
<div style="margin: 20px 0; font-size: 16px; line-height: 1.6; color: #333;">
    <?php echo wp_kses_post( wpautop( wptexturize( $email_body ) ) ); ?>
</div>
<?php endif; ?>

<div style="background-color: #f8f9fa; border: 2px solid #e9ecef; border-radius: 12px; padding: 25px; margin: 25px auto; text-align: center; max-width: 320px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); font-family: Arial, sans-serif;">
    
    <?php if ( ! empty( $coupon_code ) ) : ?>
    <div style="margin-bottom: 15px;">
        <h3 style="margin: 0; font-size: 24px; font-weight: bold; color: #495057; letter-spacing: 1px; text-align: center;">
            <?php echo esc_html( $coupon_code ); ?>
        </h3>
    </div>
    <?php endif;

    if ( ! empty( $date_expires ) ) : ?>
    <div>
        <p style="margin: 0; font-size: 14px; color: #6c757d;">
            <?php
            // translators: %s is the coupon expiry date
            echo sprintf( esc_html__( 'Expires on: %s', 'spin-rewards-for-woocommerce' ), esc_html( $date_expires ) );
            ?>
        </p>
    </div>
    <?php endif; ?>

</div>

<?php if ( ! empty( $confirmation_url ) ) : ?>
<div style="text-align: center;">
    <div style="margin: 20px 0;">
        <a href="<?php echo esc_url( $confirmation_url ); ?>" 
           style="display: inline-block; background-color: #007bff; color: #ffffff; padding: 10px 15px; text-decoration: none; border-radius: 10px; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
            <?php echo esc_html__( 'Please Confirm to Subscribe', 'spin-rewards-for-woocommerce' ); ?>
        </a>
    </div>
</div>
<?php endif; ?>

<?php do_action( 'woocommerce_email_footer', $email ); 

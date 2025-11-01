
<?php 
/**
 * Spin Record Template
 * 
 */
if ( ! defined( 'ABSPATH' ) ) exit;  
?>

<div class="srwc-meta-box">
    <div class="srwc-meta-box-content">
        <div class="srwc-field-group">
            <?php if ( !empty( $settings['user_name'] ) && $settings['user_name'] === 'yes' ) : ?>
                <div class="srwc-field">
                    <label><?php esc_html_e( 'Customer Name', 'spin-rewards-for-woocommerce' ); ?></label>
                    <input type="text" name="srwc_customer_name" value="<?php echo esc_attr( $customer_name ); ?>"/>
                </div>
            <?php endif; 

            if ( !empty( $settings['user_mobile'] ) && $settings['user_mobile'] === 'yes' ) : ?>
                <div class="srwc-field">
                    <label><?php esc_html_e( 'Mobile Number', 'spin-rewards-for-woocommerce' ); ?></label>
                    <input type="text" name="srwc_customer_mobile" value="<?php echo esc_attr( $customer_mobile ); ?>"/>
                </div>
            <?php endif; ?>
            
            <div class="srwc-field">
                <label><?php esc_html_e( 'Win Label', 'spin-rewards-for-woocommerce' ); ?></label>
                <input type="text" value="<?php echo esc_attr( $win_label ); ?>" readonly/>
            </div>
        </div>
        
        <div class="srwc-field-group">
            <div class="srwc-field">
                <label><?php esc_html_e( 'Coupon Code', 'spin-rewards-for-woocommerce' ); ?></label>
                <input type="text" class="srwc-coupon-code" value="<?php echo esc_attr( $coupon_code ); ?>" readonly/>
            </div>
        </div>
    </div>
</div>
<?php wp_nonce_field( 'spin_rewards_save_nonce', 'spin_rewards_nonce' ); ?>
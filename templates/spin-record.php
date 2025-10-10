
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
            <div class="srwc-field">
                <label><?php esc_html_e( 'Customer Name', 'spin-rewards-for-woocommerce' ); ?></label>
                <input type="text" value="<?php echo esc_attr( $customer_name ); ?>" readonly/>
            </div>
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
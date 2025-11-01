<?php 
/**
 * Spin Reports Template
 * 
 */
if ( ! defined( 'ABSPATH' ) ) exit;  
?>

<div class="wrap srwc-reports-page">
    <h1><?php esc_html_e( 'Spin Rewards Reports', 'spin-rewards-for-woocommerce' ); ?></h1>
    
    <div class="srwc-reports-container">
        <!-- Reports Cards Section -->
        <div class="srwc-report-cards">
            <div class="srwc-report-card">
                <div class="srwc-report-title"><?php esc_html_e( 'Total Spins', 'spin-rewards-for-woocommerce' ); ?></div>
                <div class="srwc-report-value" id="total-spins"><?php echo esc_html( $total_spins ); ?></div>
            </div>
            
            <div class="srwc-report-card">
                <div class="srwc-report-title"><?php esc_html_e( 'Subscribed Emails', 'spin-rewards-for-woocommerce' ); ?></div>
                <div class="srwc-report-value" id="emails-subscribed"><?php echo esc_html( $emails_subscribed ); ?></div>
            </div>
            
            <div class="srwc-report-card">
                <div class="srwc-report-title"><?php esc_html_e( 'Coupons Awarded', 'spin-rewards-for-woocommerce' ); ?></div>
                <div class="srwc-report-value" id="coupons-given"><?php echo esc_html( $coupons_given ); ?></div>
            </div>
        </div>

        <!-- Actions Section -->
        <div class="srwc-reports-filters">
            <div class="srwc-date-filters">
                <div class="srwc-date-field">
                    <label><?php esc_html_e( 'From', 'spin-rewards-for-woocommerce' ); ?></label>
                    <input type="date" id="from-date" name="from_date" class="srwc-date-input">
                </div>
                
                <div class="srwc-date-field">
                    <label><?php esc_html_e( 'To', 'spin-rewards-for-woocommerce' ); ?></label>
                    <input type="date" id="to-date" name="to_date" class="srwc-date-input">
                </div>
            </div>
            
            <div class="srwc-actions">
                <button type="button" id="export-emails" class="button button-primary">
                    <?php esc_html_e( 'Export', 'spin-rewards-for-woocommerce' ); ?>
                </button>
            </div>
        </div>
    </div>
</div>
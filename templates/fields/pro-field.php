<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Pro version lock-only field
 */
?>
<td>
    <div class="srwc-pro-message">
        <?php 
            if ( ! empty( $field['pro_version_message'] ) ) :
                echo esc_html( $field['pro_version_message'] );
            else:
                echo esc_html__( 'This feature is available in the Pro version only.', 'spin-rewards-for-woocommerce' );
            endif;
        ?>

        <?php echo esc_html__( 'Click', 'spin-rewards-for-woocommerce' ); ?>
        <a href="<?php echo esc_url( SRWC_PRO_VERSION_URL ); ?>" target="_blank">
            <?php echo esc_html__( 'here', 'spin-rewards-for-woocommerce' ); ?>
        </a>
        <?php echo esc_html__( ' to buy', 'spin-rewards-for-woocommerce' ); ?>.
    </div>
</td>
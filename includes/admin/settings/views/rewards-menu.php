<?php 
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>
<div class="cosmic_page cosmic_settings_page wrap">

    <h2 class="srwc_notice_wrapper"></h2>

    <!-- Navigation tabs for plugin settings -->
    <div class="cosmic_settings_page_nav">
        <h2 class="nav-tab-wrapper">

            <!-- General settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=cosmic-srwc&tab=general' ) ); ?>" 
               class="<?php echo esc_attr( $active_tab === 'general' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( SRWC_URL . 'assets/img/setting.svg'); ?>" />
                <?php esc_html_e( 'General', 'spin-rewards-for-woocommerce' ); ?>
            </a>

            <!-- Popup settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=cosmic-srwc&tab=popup' ) ); ?>" 
               class="<?php echo esc_attr( $active_tab === 'popup' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( SRWC_URL . 'assets/img/popup.svg'); ?>" />
                <?php esc_html_e( 'Popup', 'spin-rewards-for-woocommerce' ); ?>
            </a>

            <!-- Spin Wheel settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=cosmic-srwc&tab=spin-rewards' ) ); ?>" 
               class="<?php echo esc_attr( $active_tab === 'spin-rewards' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( SRWC_URL . 'assets/img/rewards.svg'); ?>" />
                <?php esc_html_e( 'Spin Rewards', 'spin-rewards-for-woocommerce' ); ?>
            </a>

            <!-- Wheel Slides settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=cosmic-srwc&tab=wheel-slides' ) ); ?>" 
               class="<?php echo esc_attr( $active_tab === 'wheel-slides' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( SRWC_URL . 'assets/img/slides.svg'); ?>" />
                <?php esc_html_e( 'Wheel Slides', 'spin-rewards-for-woocommerce' ); ?>
            </a>

            <!-- Wheel Design settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=cosmic-srwc&tab=wheel-design' ) ); ?>" 
               class="<?php echo esc_attr( $active_tab === 'wheel-design' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( SRWC_URL . 'assets/img/design.svg'); ?>" />
                <?php esc_html_e( 'Wheel Design', 'spin-rewards-for-woocommerce' ); ?>
            </a>

            <!-- Offer Coupon settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=cosmic-srwc&tab=offer-coupon' ) ); ?>" 
               class="<?php echo esc_attr( $active_tab === 'offer-coupon' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( SRWC_URL . 'assets/img/offer-coupons.svg'); ?>" />
                <?php esc_html_e( 'Offer Coupon', 'spin-rewards-for-woocommerce' ); ?>
            </a>

            <!-- Notification settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=cosmic-srwc&tab=notification' ) ); ?>" 
               class="<?php echo esc_attr( $active_tab === 'notification' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( SRWC_URL . 'assets/img/notification.svg'); ?>" />
                <?php esc_html_e( 'Notification', 'spin-rewards-for-woocommerce' ); ?>
            </a>

            <!-- Email API settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=cosmic-srwc&tab=email-api' ) ); ?>" 
               class="<?php echo esc_attr( $active_tab === 'email-api' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( SRWC_URL . 'assets/img/email.svg'); ?>" />
                <?php esc_html_e( 'Email API', 'spin-rewards-for-woocommerce' ); ?>
            </a>


        </h2>
    </div>

    <!-- Content area for the active settings tab -->
    <div class="cosmic_settings_page_content">
        <?php
        // Load the content for the currently active tab dynamically.
        require_once SRWC_PATH . 'includes/admin/settings/views/' . $active_tab . '.php';
        ?>
    </div>
</div>

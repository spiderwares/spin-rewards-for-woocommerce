<?php 
/**
 * Spin Wheel Template
 * 
 */
if ( ! defined( 'ABSPATH' ) ) exit;  
?>

<div class="srwc-wheel-modal">
  <div class="srwc-wheel-container">
    
    <!-- Left Side: Wheel -->
    <div class="srwc-wheel-left">
      <div class="srwc-wheel">
        <div class="wheel-inner">
          <canvas id="srwc_wheel_canvas"></canvas>
        </div>
        <!-- Pointer -->
        <div class="srwc-pointer">
          <div class="srwc-pointer-cutout"></div>
        </div>
      </div>
    </div>

    <!-- Right Side: Controls -->
    <div class="srwc-wheel-right">
      <div class="srwc-close">&times;</div>

      <!-- Title -->
      <div class="srwc-title">
        <?php 
          $title = !empty($settings['rewards_title']) ? $settings['rewards_title'] : 'SPIN TO WIN!';
          echo wp_kses_post( $title );
        ?>
      </div>

      <!-- Form -->
      <div class="srwc-wheel-controls">
        <?php if (!empty($settings['user_name']) && $settings['user_name'] === 'yes') : ?>
            <input type="text" class="srwc-input srwc-name" placeholder="<?php esc_attr_e( 'Please enter your name', 'spin-rewards-for-woocommerce' ); ?>" required/>
            <div class="srwc-error srwc-name-error"></div>
        <?php endif; ?>

        <!-- Mobile Number Field - Pro Version via Filter -->
        <?php
        echo wp_kses_post( apply_filters( 'srwc_pro_mobile_field', '', array(
            'settings' => $settings,
        ) ) );
        ?>
        
        <input type="email" class="srwc-input srwc-email" placeholder="<?php esc_attr_e( 'Please enter your email', 'spin-rewards-for-woocommerce' ); ?>" required/>
        <div class="srwc-error srwc-email-error"></div>

        <?php if (!empty($settings['gdpr_checkbox']) && $settings['gdpr_checkbox'] === 'yes') : ?>
            <div class="srwc-gdpr-container">
                <label class="srwc-gdpr-label">
                    <input type="checkbox" class="srwc-gdpr-checkbox" required/>
                    <span class="srwc-gdpr-text"><?php echo wp_kses_post(!empty($settings['gdpr_message']) ? $settings['gdpr_message'] : 'I agree with the term and condition'); ?></span>
                </label>
                <div class="srwc-error srwc-gdpr-error"></div>
            </div>
        <?php endif; ?>

        <?php $btn_text = !empty($settings['spin_button_text']) ? $settings['spin_button_text'] : 'Spin Now'; ?>
        <button class="srwc-spin-btn">
          <?php echo esc_html($btn_text); ?>
        </button>
      </div>

      <!-- Win/Loss Message -->
      <div class="srwc-win-message">
        <div class="srwc-win-text"></div>
      </div>
    </div>
  </div>
</div>

<!-- Float Spin Button -->
<div class="srwc-floating-btn" data-hide-icon="<?php echo esc_attr(!empty($settings['hide_icon']) ? $settings['hide_icon'] : 'no'); ?>">
  <div class="srwc-mini-wheel">
      <div class="srwc-mini-wheel-inner"></div>
  </div>
</div>
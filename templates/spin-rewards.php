<?php 
/**
 * Spin Rewards Template
 * 
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;  
?>

<!-- Background Effects -->
<div class="srwc-bg-effects"></div>

<div class="srwc-wheel-modal">
  <div class="srwc-wheel-container">
    
    <div class="srwc-wheel-left">
      <div class="srwc-wheel">
        <div class="wheel-inner">
          <canvas id="srwc_wheel_canvas"></canvas>
        </div>
        <div class="srwc-pointer">
          <div class="srwc-pointer-cutout"></div>
        </div>
      </div>
    </div>
    
    <div class="srwc-wheel-right">
      <div class="srwc-close">&times;</div>
      
      <!-- Win Effects -->
      <div class="srwc-firework" id="srwc-firework"></div>
      
      <!-- Title -->
      <div class="srwc-title">
        <?php 
          $title = !empty($settings['rewards_title']) ? $settings['rewards_title'] : 'SPIN TO WIN!';
          echo wp_kses_post( $title );
          ?>
      </div>
      
      <!-- Form -->
      <div class="srwc-form-controls">
        <?php if (!empty($settings['user_name']) && $settings['user_name'] === 'yes') : ?>
            <input type="text" class="srwc-input srwc-name" placeholder="<?php esc_attr_e( 'Please enter your name', 'spin-rewards-for-woocommerce' ); ?>" required/>
            <div class="srwc-error srwc-name-error"></div>
            <?php endif; ?>
            
        <?php
          echo wp_kses_post( apply_filters( 'srwc_wheel_pro_field', '', array(
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
          <span class="srwc-loader" style="display: none;"></span>
          <?php echo esc_html($btn_text); ?>
        </button>
      </div>

      <!-- Win/Loss Message -->
      <div class="srwc-win-message">
        <div class="srwc-win-text"></div>
      </div>
      
      <!-- Close Button at Bottom -->
      <?php if (!empty($settings['show_close_button']) && $settings['show_close_button'] === 'yes') : ?>
        <div class="srwc-close-bottom">
          <button class="srwc-close-btn">
            <span class="srwc-close-text">
              <?php echo esc_html(!empty($settings['close_button_text']) ? $settings['close_button_text'] : 'Close Now'); ?>
            </span>
          </button>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Float Spin Button -->
<div class="srwc-floating-btn" data-hide-icon="<?php echo esc_attr(!empty($settings['hide_icon']) ? $settings['hide_icon'] : 'no'); ?>">
    <?php if ( !empty($settings['custom_popup_icon_image']) ) : ?>
        <?php 
            $icon_img = esc_url($settings['custom_popup_icon_image']);
            $is_svg   = (bool) preg_match('/\.svg(\?.*)?$/i', $icon_img);
        ?>
        <?php if ($is_svg) : ?>
            <div class="srwc-mini-icon srwc-mini-icon--svg">
                <div class="srwc-mini-icon-mask"></div>
            </div>
        <?php else : ?>
            <div class="srwc-mini-icon">
                <img src="<?php echo esc_url($icon_img); ?>" alt="spin icon" />
            </div>
        <?php endif; ?>
    <?php else : ?>
        <div class="srwc-mini-wheel">
            <div class="srwc-mini-wheel-inner">
                <canvas id="srwc-mini-wheel-canvas" width="70" height="70"></canvas>
            </div>
        </div>
    <?php endif; ?>
</div>

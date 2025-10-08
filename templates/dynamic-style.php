<?php
/**
 * Dynamic inline styles for Spin Rewards for WooCommerce.
 *
 * @package Spin_Rewards_For_WooCommerce
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( empty( $settings ) || ! is_array( $settings ) ) :
	return;
endif;

$bg_color   = !empty($settings['background_color']) ? $settings['background_color'] : '#087988ff';
$text_color = !empty($settings['text_color']) ? $settings['text_color'] : '#ffffffff';

$bg_image = !empty($settings['background_image']) ? $settings['background_image'] : 'default_img';
$custom_bg_image = !empty($settings['custom_background_image']) ? $settings['custom_background_image'] : '';
$bg_blend_mode = !empty($settings['background_blend_mode']) ? $settings['background_blend_mode'] : 'overlay';

$btn_text_color     = !empty($settings['spin_button_text_color']) ? $settings['spin_button_text_color'] : '#ffffff';
$btn_bg_color       = !empty($settings['spin_button_bg_color']) ? $settings['spin_button_bg_color'] : '#111111ff';
$btn_bg_hover_color = !empty($settings['spin_button_hover_bg_color']) ? $settings['spin_button_hover_bg_color'] : '#000000ff';

$icon_position = !empty($settings['icon_display_position']) ? $settings['icon_display_position'] : 'bottom-right';
$hide_icon = !empty($settings['hide_icon']) ? $settings['hide_icon'] : 'no';

?>

.srwc-wheel-container {
    color: <?php echo esc_html( $text_color ); ?>;
    <?php if($bg_image === 'custom' && !empty($custom_bg_image)): ?>
        background: <?php echo esc_html( $bg_color ); ?> url('<?php echo esc_url($custom_bg_image); ?>');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-blend-mode: <?php echo esc_html( $bg_blend_mode ); ?>;
    <?php elseif($bg_image === 'default_img'): ?>
        background: <?php echo esc_html( $bg_color ); ?> url('<?php echo esc_url(SRWC_URL . 'assets/img/2020.png'); ?>');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-blend-mode: <?php echo esc_html( $bg_blend_mode ); ?>;
    <?php else: ?>
        background: <?php echo esc_html( $bg_color ); ?>;
    <?php endif; ?>
}

.srwc-spin-btn {
    background: <?php echo esc_html( $btn_bg_color ); ?>;
    color: <?php echo esc_html( $btn_text_color ); ?>;
}

.srwc-spin-btn:hover{
    background: <?php echo esc_html( $btn_bg_hover_color ); ?>;
}

/* Floating Button */
.srwc-floating-btn {
    <?php
    switch($icon_position) {
        case 'top-left':
            echo 'top: 40px; left: 20px; right: auto; bottom: auto;';
            break;
        case 'top-right':
            echo 'top: 40px; right: 20px; left: auto; bottom: auto;';
            break;
        case 'bottom-left':
            echo 'bottom: 40px; left: 20px; right: auto; top: auto;';
            break;
        case 'bottom-right':
            echo 'bottom: 40px; right: 20px; left: auto; top: auto;';
            break;
        case 'middle-left':
            echo 'top: 50%; left: 20px; right: auto; bottom: auto; transform: translateY(-50%);';
            break;
        case 'middle-right':
            echo 'top: 50%; right: 20px; left: auto; bottom: auto; transform: translateY(-50%);';
            break;
        default:
            echo 'bottom: 40px; right: 20px; left: auto; top: auto;';
    }
    ?>
}

/* Hide icon */
<?php if($hide_icon === 'yes'): ?>
.srwc-floating-btn.srwc-hidden {
    display: none !important;
}
<?php endif; ?>

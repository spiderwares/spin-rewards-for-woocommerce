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

$bg_color               = !empty($settings['background_color']) ? $settings['background_color'] : '#087988ff';
$rewards_title_color    = !empty($settings['rewards_title_color']) ? $settings['rewards_title_color'] : '#ffffffff';
$text_color             = !empty($settings['text_color']) ? $settings['text_color'] : '#ffffffff';

$bg_image           = !empty($settings['background_image']) ? $settings['background_image'] : 'default_img';
$custom_bg_image    = !empty($settings['custom_background_image']) ? $settings['custom_background_image'] : '';
$bg_blend_mode      = !empty($settings['background_blend_mode']) ? $settings['background_blend_mode'] : 'overlay';
$icon_position      = !empty($settings['icon_display_position']) ? $settings['icon_display_position'] : 'bottom-right';
$hide_icon          = !empty($settings['hide_icon']) ? $settings['hide_icon'] : 'no';

$btn_text_color             = !empty($settings['spin_button_text_color']) ? $settings['spin_button_text_color'] : '#ffffff';
$btn_bg_color               = !empty($settings['spin_button_bg_color']) ? $settings['spin_button_bg_color'] : '#111111ff';
$btn_bg_hover_color         = !empty($settings['spin_button_hover_bg_color']) ? $settings['spin_button_hover_bg_color'] : '#000000ff';
$wheel_pointer_color        = !empty($settings['wheel_pointer_color']) ? $settings['wheel_pointer_color'] : '#000000ff';
$wheel_pointer_cutout_color = !empty($settings['wheel_pointer_cutout_color']) ? $settings['wheel_pointer_cutout_color'] : '#ffffff';
$wheel_center_color         = !empty($settings['wheel_center_color']) ? $settings['wheel_center_color'] : '#ffffff';
$wheel_border_color         = !empty($settings['wheel_border_color']) ? $settings['wheel_border_color'] : '#ffffff';
$wheel_pointer_cutout_image = !empty($settings['wheel_pointer_cutout_image']) ? $settings['wheel_pointer_cutout_image'] : '';
$error_message_color        = !empty($settings['error_message_color']) ? $settings['error_message_color'] : '#ff4444';
$error_message_font_size    = !empty($settings['error_message_font_size']) ? $settings['error_message_font_size'] : '14';
$error_message_font_unit    = !empty($settings['error_message_font_size_unit']) ? $settings['error_message_font_size_unit'] : 'px';

$mini_wheel = '';
if (!empty($settings['slides']) && is_array($settings['slides'])) :
    $total = count($settings['slides']);
    $stops = [];
    
    foreach ($settings['slides'] as $i => $slide) :
        $color = !empty($slide['color']) ? $slide['color'] : '#d2691e';
        $stops[] = $color . ' ' . ($i * 360 / $total) . 'deg ' . (($i + 1) * 360 / $total) . 'deg';
    endforeach;
    
    $mini_wheel = 'conic-gradient(' . implode(', ', $stops) . ')';
endif;
?>

.srwc-win-text {
    color: <?php echo esc_html( $text_color ); ?>;
}

.srwc-wheel-container {
    color: <?php echo esc_html( $rewards_title_color ); ?>;
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
        // case 'middle-left':
        //     echo 'top: 50%; left: 20px; right: auto; bottom: auto; transform: translateY(-50%);';
        //     break;
        // case 'middle-right':
        //     echo 'top: 50%; right: 20px; left: auto; bottom: auto; transform: translateY(-50%);';
        //     break;
        default:
            echo 'bottom: 40px; right: 20px; left: auto; top: auto;';
    }
    ?>
}

<?php if($hide_icon === 'yes'): ?>
.srwc-floating-btn.srwc-hidden {
    display: none !important;
}
<?php endif; ?>

.srwc-error {
    color: <?php echo esc_html( $error_message_color ); ?> !important;
    font-size: <?php echo esc_html( $error_message_font_size . $error_message_font_unit ); ?> !important;
}

.srwc-pointer::after {
    background: <?php echo esc_html( $wheel_pointer_color ); ?>;
}

.srwc-pointer .srwc-pointer-cutout {
    <?php if(!empty($wheel_pointer_cutout_image)): ?>
        background: url('<?php echo esc_url($wheel_pointer_cutout_image); ?>') !important;
        background-size: contain !important;
        background-repeat: no-repeat !important;
        background-position: center !important;
    <?php else: ?>
        background: <?php echo esc_html( $wheel_pointer_cutout_color ); ?> !important;
    <?php endif; ?>
}

.srwc-mini-wheel-inner {
    background: <?php echo esc_html( $mini_wheel ); ?> !important;
}

.srwc-pointer::before {
    background: <?php echo esc_html( $wheel_center_color ); ?>;
}

.srwc-wheel {
    background: <?php echo esc_html( $wheel_border_color ); ?>;
}
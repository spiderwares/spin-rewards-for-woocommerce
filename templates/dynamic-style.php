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

$bg_color           = !empty($settings['background_color']) ? $settings['background_color'] : '#087988ff';
$text_color         = !empty($settings['text_color']) ? $settings['text_color'] : '#ffffff';
$bg_image           = !empty($settings['background_image']) ? $settings['background_image'] : 'default_img';
$custom_bg_image    = !empty($settings['custom_background_image']) ? $settings['custom_background_image'] : '';
$bg_blend_mode      = !empty($settings['background_blend_mode']) ? $settings['background_blend_mode'] : 'overlay';
$icon_position      = !empty($settings['icon_display_position']) ? $settings['icon_display_position'] : 'bottom-right';
$hide_icon          = !empty($settings['hide_icon']) ? $settings['hide_icon'] : 'no';

$btn_text_color             = !empty($settings['spin_button_text_color']) ? $settings['spin_button_text_color'] : '#ffffff';
$btn_hover_text_color       = !empty($settings['spin_button_text_hover_color']) ? $settings['spin_button_text_hover_color'] : '#ffffff';
$btn_bg_color               = !empty($settings['spin_button_bg_color']) ? $settings['spin_button_bg_color'] : '#111111';
$btn_bg_hover_color         = !empty($settings['spin_button_hover_bg_color']) ? $settings['spin_button_hover_bg_color'] : '#000000';
$wheel_pointer_color        = !empty($settings['wheel_pointer_color']) ? $settings['wheel_pointer_color'] : '#000000';
$error_message_color        = !empty($settings['error_message_color']) ? $settings['error_message_color'] : '#ff4444';
$error_message_font_size    = !empty($settings['error_message_font_size']) ? $settings['error_message_font_size'] : '14';
$email_border               = !empty($settings['email_border']) ? $settings['email_border'] : '10px';
$name_border                = !empty($settings['name_border']) ? $settings['name_border'] : '10px';
$wheel_pointer_cutout_color = !empty($settings['wheel_pointer_cutout_color']) ? $settings['wheel_pointer_cutout_color'] : '#ffffff';
$wheel_pointer_image        = !empty($settings['wheel_pointer_image']) ? $settings['wheel_pointer_image'] : '';
$close_btn_text_color       = !empty($settings['close_btn_text_color']) ? $settings['close_btn_text_color'] : '#ff4444';
$option_color               = !empty($settings['not_display_option_color']) ? $settings['not_display_option_color'] : '#333333';
$option_hover_color         = !empty($settings['not_display_option_hover_color']) ? $settings['not_display_option_hover_color'] : '#000000';

?>
.srwc-form-controls .srwc-email {
    border-radius: <?php echo esc_html( $email_border ); ?>px;
}

.srwc-form-controls .srwc-name {
    border-radius: <?php echo esc_html( $name_border ); ?>px;
}
.srwc-win-text {
    color: <?php echo esc_html( $text_color ); ?>;
}

.srwc-pointer .srwc-pointer-cutout {
    <?php if(!empty($wheel_pointer_image)): ?>
        background: url('<?php echo esc_url($wheel_pointer_image); ?>') !important;
        background-size: contain !important;
        background-repeat: no-repeat !important;
    <?php else: ?>
        background: <?php echo esc_html( $wheel_pointer_cutout_color ); ?> !important;
    <?php endif; ?>
}

.srwc-wheel-container {
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

.srwc-spin-btn:hover {
    color: <?php echo esc_html( $btn_hover_text_color ); ?>;
}

.srwc-spin-btn:hover{
    background: <?php echo esc_html( $btn_bg_hover_color ); ?>;
}

.srwc-floating-btn {
    <?php
    switch($icon_position) {
        case 'top-left':
            echo 'top: 15px; left: 0px; right: auto; bottom: auto;';
            break;
        case 'top-right':
            echo 'top: 15px; right: 0px; left: auto; bottom: auto;';
            break;
        case 'bottom-left':
            echo 'bottom: 15px; left: 0px; right: auto; top: auto;';
            break;
        case 'bottom-right':
            echo 'bottom: 15px; right: 0px; left: auto; top: auto;';
            break;
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
    font-size: <?php echo esc_html( $error_message_font_size ); ?>px !important;
}

.srwc-pointer::after {
    background: <?php echo esc_html( $wheel_pointer_color ); ?>;
}

.srwc-option-link {
    color: <?php echo esc_html( $option_color ); ?>;
}

.srwc-option-link:hover {
    color: <?php echo esc_html( $option_hover_color ); ?>;
}

<?php
// Output custom CSS if provided
$custom_css = !empty($settings['custom_css']) ? $settings['custom_css'] : '';
if (!empty($custom_css)) :
    echo wp_strip_all_tags($custom_css);
endif;
?>
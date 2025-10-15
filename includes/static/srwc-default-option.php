<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters(
    'srwc_default_options',
    array(
        'srwc_settings'     => array(       
            'enable'                        => 'yes',
            'spin_per_email'                => 1,
            'time_spin_between'             => 24,
            'time_spin_between_unit'        => 'hours',
            'popup_trigger'                 => 'show_wheel',
            'initial_delay'                 => 1,
            'time_on_close'                 => 1,
            'show_again'                    => 24,
            'hide_icon'                     => 'no',
            'shop_page'                     => 'yes',
            'home_page'                     => 'no',
            'blog_page'                     => 'no',
            'conditional_tags'              => '',
            'icon_display_position'         => 'bottom-right',
            'user_name'                     => 'yes',
            'user_name_require'             => 'no',
            'name_border'                   => 10,
            'email_border'                  => 10,
            'auto_hide_wheel'               => 0,
            'win_message'                   => 'Congratulations! You have won a {coupon_label} discount coupon. The coupon has been sent to the email address you provided when spinning. Redeem it at checkout {checkout} now!',
            'lose_message'                  => 'OOPS! No luck this time. Try again!',
            'gdpr_checkbox'                 => 'no',
            'gdpr_message'                  => 'I agree with the term and condition',
            'code_type'                     => 'alphanumeric',
            'coupon_length'                 => 6,
            'coupon_prefix'                 => '',
            'coupon_suffix'                 => '',
            'coupon_expiry_days'            => 30,
            'individual_use_only'           => 'no',
            'exclude_sale'                  => 'no',
            'minimum_spend'                 => '',
            'maximum_spend'                 => '',
            'limit_coupon'                  => 1,
            'limit_coupon_to_x_items'       => 1,
            'limit_coupon_per_user'         => 1,
            'wheel_speed_spin'              => '3',
            'wheel_pointer'                 => 'center',
            'wheel_pointer_color'           => '#f70707',
            'wheel_pointer_cutout_type'     => 'color',
            'wheel_center_color'            => '#ffffff',
            'wheel_border_color'            => '#ffffff',
            'background_blend_mode'         => 'none',
            'background_color'              => '#189a7a',
            'text_color'                    => '#000000',
            'rewards_title'                 => 'SPIN TO WIN!',
            'spin_button_text'              => 'Spin Now',
            'spin_button_text_size'         => 18,
            'spin_button_border'            => 10,
            'spin_button_text_color'        => '#ffffff',
            'spin_button_bg_color'          => '#ff9000',
            'spin_button_hover_bg_color'    => '#ffad42',
            'wheel_text_size'               => 18,
            'wheel_size'                    => 100,
            'display_currency'              => 'symbol',
            'enable_customer_email'         => 'yes',
            'enable_mailchimp'              => 'no',
            'name_required_message'         => 'Please enter your name',
            'email_required_message'        => 'Please enter your email',
            'email_invalid_message'         => 'Please enter a valid email address',
            'spin_limit_email_message'      => 'You’ve reached the limit of {limit} spins for this email address.',
            'wait_spin_message'             => 'You must wait {time} before spinning again.',
            'gdpr_required_message'         => 'Please agree with our term and condition.',
            'error_message_color'           => '#ffffff',
            'error_message_font_size'       => 14,

            // Default wheel slides 
            'slides' => array(
                array(
                    'coupon_type' => 'none',
                    'label' => 'Not Lucky',
                    'value' => '0',
                    'probability' => '17',
                    'color' => '#ffe0b2'
                ),
                array(
                    'coupon_type' => 'percent',
                    'label' => '{coupon_amount} OFF',
                    'value' => '15',
                    'probability' => '17',
                    'color' => '#d43606'
                ),
                array(
                    'coupon_type' => 'none',
                    'label' => 'Not Lucky',
                    'value' => '0',
                    'probability' => '17',
                    'color' => '#b2ffe0'
                ),
                array(
                    'coupon_type' => 'percent',
                    'label' => '{coupon_amount} OFF',
                    'value' => '5',
                    'probability' => '17',
                    'color' => '#e65100'
                ),
                array(
                    'coupon_type' => 'none',
                    'label' => 'Not Lucky',
                    'value' => '0',
                    'probability' => '17',
                    'color' => '#ffb74d'
                ),
                array(
                    'coupon_type' => 'fixed_product',
                    'label' => '{coupon_amount} OFF',
                    'value' => '10',
                    'probability' => '15',
                    'color' => '#fb8c00'
                )
            ),
        ),
    )
);
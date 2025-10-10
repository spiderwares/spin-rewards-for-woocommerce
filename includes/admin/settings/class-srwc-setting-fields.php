<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_Rewards_Fields' ) ) :

    /**
     * Class SRWC_Rewards_Fields
     * Handles the admin settings for Spin Rewards for WooCommerce.
     */
    class SRWC_Rewards_Fields {

        /**
         * Generates the general settings fields for spin rewards configuration.
         *
         * @return array The settings fields for the general configuration.
         */
        public static function general_field() {

            $fields = array(

                'enable' => array(
                    'title'      => esc_html__( 'Enable', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'yes',
                    'name'       => 'srwc_settings[enable]',
                ),

                'spin_per_email' => array(
                    'title'      => esc_html__( 'Limit of Spins per Email', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => '',
                    'name'       => 'srwc_settings[spin_per_email]',
                    'desc'       => esc_html__( 'Set how many times a customer can spin the wheel using the same email address.', 'spin-rewards-for-woocommerce' ),
                ),
                
                'time_spin_between' => array(
                    'title'      => esc_html__( 'Time Between Spins', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => '24',
                    'name'       => 'srwc_settings[time_spin_between]',
                    'desc'       => esc_html__( 'Set the minimum time a customer must wait before spinning the wheel again.', 'spin-rewards-for-woocommerce' ),
                ),

                'time_spin_between_unit' => array(
                    'title'      => esc_html__( 'Time Between Spins Unit', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect',
                    'default'    => 'hours',
                    'name'       => 'srwc_settings[time_spin_between_unit]',
                    'options'    => array(
                        'seconds' => esc_html__( 'Seconds', 'spin-rewards-for-woocommerce' ),
                        'minutes' => esc_html__( 'Minutes', 'spin-rewards-for-woocommerce' ),
                        'hours'   => esc_html__( 'Hours', 'spin-rewards-for-woocommerce' ),
                        'days'    => esc_html__( 'Days', 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'hours',
                ),

                'small_screen' => array(
                    'title'      => esc_html__( 'Small Screen', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'yes',
                    'name'       => 'srwc_settings[small_screen]',
                    'desc'       => esc_html__( 'Enable wheel display on screens smaller than 760px.', 'spin-rewards-for-woocommerce' ),
                ),

                'spin_allow_block_list' => array(
                    'title'       => esc_html__( 'Choose using allow/block list', 'spin-rewards-for-woocommerce' ),
                    'field_type'  => 'srwcpro',
                    'default'     => 'allow',
                    'name'        => 'srwc_settings[spin_allow_block_list]',
                    'options'     => array(
                        'allow' => array(
                            'label' => esc_html__( 'Allow List', 'spin-rewards-for-woocommerce' ),
                            'desc'  => esc_html__( 'Only the email addresses listed below will be allowed to spin the wheel.', 'spin-rewards-for-woocommerce' ),
                        ),
                        'block' => array(
                            'label' => esc_html__( 'Block List', 'spin-rewards-for-woocommerce' ),
                            'desc'  => esc_html__( 'Email addresses listed below will be blocked from spinning, while all other emails will remain eligible.', 'spin-rewards-for-woocommerce' ),
                        ),
                    ),
                ),

                'auto_spin' => array(
                    'title'      => esc_html__( 'Reset Spins Automatically', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => 'yes',
                    'name'       => 'srwc_settings[auto_spin]',
                ),


            );

            return apply_filters( 'srwc_general_fields', $fields );
        }
        /**
         * Generates the popup settings fields for spin rewards configuration.
         *
         * @return array The settings fields for the popup configuration.
         */
        public static function popup_field() {

            $fields = array(

                'popup_trigger' => array(
                    'title'      => esc_html__( 'Popup Trigger Options', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect',
                    'default'    => 'show_wheel',
                    'name'       => 'srwc_settings[popup_trigger]',
                    'options'    => array(
                        'popup_icon' => esc_html__( 'Open the wheel only when user takes a specific action.', 'spin-rewards-for-woocommerce' ),
                        'show_wheel' => esc_html__( 'Automatically display the wheel after a set delay.', 'spin-rewards-for-woocommerce' ),
                        'on_scroll'  => esc_html__( 'Show the wheel after users scroll down a specific value. (Pro)', 'spin-rewards-for-woocommerce' ),
                        'on_exit'    => esc_html__( 'Trigger the wheel when the user moves the mouse toward closing the browser. (Pro)', 'spin-rewards-for-woocommerce' ),
                        'random'     => esc_html__( 'Randomly use one of the above triggers. (Pro)', 'spin-rewards-for-woocommerce' ),
                    ),
                    'disabled_options'   => array( 'on_scroll', 'on_exit', 'random' ),
                ),

                'initial_delay' => array(
                    'title'      => esc_html__( 'Initial Delay', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => 0,
                    'name'       => 'srwc_settings[initial_delay]',
                    'desc'       => esc_html__( 'Set a delay before the popup icon appears after the trigger action. The delay is randomly chosen within the range you provide. Enter values as min,max (in seconds). Example: 1,2.', 'spin-rewards-for-woocommerce' ),
                    'unit'       => array(
                        'seconds' => esc_html__( 'Seconds', 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'seconds',
                    'unit_disabled' => true,
                ),

                'time_on_close' => array(
                    'title'      => esc_html__( 'Re-display the popup after this time if the wheel is closed without a spin', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => '0',
                    'name'       => 'srwc_settings[time_on_close]',
                    'unit'       => array(
                        'minutes' => esc_html__( 'Minutes', 'spin-rewards-for-woocommerce' ),
                        'hours'   => esc_html__( 'Hours', 'spin-rewards-for-woocommerce' ),
                        'days'    => esc_html__( 'Days', 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'minutes',
                ),

                'show_again' => array(
                    'title'      => esc_html__( 'After one spin, show popup again', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => '0',
                    'name'       => 'srwc_settings[show_again]',
                    'unit'       => array(
                        'seconds' => esc_html__( 'Seconds', 'spin-rewards-for-woocommerce' ),
                        'minutes' => esc_html__( 'Minutes', 'spin-rewards-for-woocommerce' ),
                        'hours'   => esc_html__( 'Hours', 'spin-rewards-for-woocommerce' ),
                        'days'    => esc_html__( 'Days', 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'seconds',
                ),

                'hide_icon' => array(
                    'title'      => esc_html__( 'Hide Icon', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[hide_icon]',
                    'desc'       => esc_html__( 'Hide the popup icon once the user closes the wheel.', 'spin-rewards-for-woocommerce' ),
                ),

                'assign_page' => array(
                    'title'         => esc_html__('Assign Page', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'shop_page' => array(
                    'title'      => esc_html__( 'Show on Shop Page', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'yes',
                    'name'       => 'srwc_settings[shop_page]',
                    'desc'       => esc_html__( 'Show popup icon only on Shop page.', 'spin-rewards-for-woocommerce' ),
                ),

                'home_page' => array(
                    'title'      => esc_html__( 'Show on Home Page', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[home_page]',
                    'desc'       => esc_html__( 'Show popup icon only on Home page.', 'spin-rewards-for-woocommerce' ),
                ),

                'blog_page' => array(
                    'title'      => esc_html__( 'Show on Blog Page', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[blog_page]',
                    'desc'       => esc_html__( 'Show popup icon only on Blog page.', 'spin-rewards-for-woocommerce' ),
                ),

                'conditional_tags' => array(
                    'title'      => esc_html__( 'Conditional Tags', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => '',
                    'name'       => 'srwc_settings[conditional_tags]',
                    'desc'       => esc_html__( 'Let you control on which pages WooCommerce Spin Rewards icon appears using', 'spin-rewards-for-woocommerce' ) . 
                                    ' <a href="https://developer.wordpress.org/themes/basics/conditional-tags/" target="_blank">' . 
                                    esc_html__( 'WP\'s conditional tags', 'spin-rewards-for-woocommerce' ) . '</a><br>' .

                                   esc_html__( '"Shop Page", Home Page" and "Blog Page" settings need to be turned off before conditional tags will work.', 'spin-rewards-for-woocommerce' ) . '<br><br>' .
                                   '<strong>' . esc_html__( 'Specific Conditional Tags for Display:', 'spin-rewards-for-woocommerce' ) . '</strong><br>' .

                                   '• ' . '<b>' . esc_html__( 'is_cart()', 'spin-rewards-for-woocommerce' ) . '</b> ' . 
                                   esc_html__( 'to show only on cart page', 'spin-rewards-for-woocommerce' ) . '<br>' .

                                   '• ' . '<b>' . esc_html__( 'is_checkout()', 'spin-rewards-for-woocommerce' ) . '</b> ' . 
                                   esc_html__( 'to show only on checkout page', 'spin-rewards-for-woocommerce' ) . '<br>' .

                                   '• ' . '<b>' . esc_html__( 'is_product_category()', 'spin-rewards-for-woocommerce' ) . '</b> ' . 
                                   esc_html__( 'to show only on WooCommerce category page', 'spin-rewards-for-woocommerce' ) . '<br>' .
                                   
                                   '• ' . '<b>' . esc_html__( 'is_shop()', 'spin-rewards-for-woocommerce' ) . '</b> ' . 
                                   esc_html__( 'to show only on WooCommerce shop page', 'spin-rewards-for-woocommerce' ) . '<br>' .

                                   '• ' . '<b>' . esc_html__( 'is_product()', 'spin-rewards-for-woocommerce' ) . '</b> ' . 
                                   esc_html__( 'to show only on WooCommerce single product page', 'spin-rewards-for-woocommerce' ) . '<br><br>' .

                                   esc_html__( '***Use || to combine two or more conditionals. The wheel will display if any of the conditions match.e.g ' ) . '<b>' . 
                                   esc_html__( 'is_cart() || is_checkout()', 'spin-rewards-for-woocommerce' ) . '</b> ' . 
                                   esc_html__('Show the wheel on both the Cart and Checkout pages.***', 'spin-rewards-for-woocommerce' ) . '<br>' .

                                   esc_html__( '***Add an exclamation mark ! before a conditional to hide the wheel when that condition is true.e.g ' ) . '<b>' . 
                                   esc_html__( '!is_home()', 'spin-rewards-for-woocommerce' ) . '</b> ' . 
                                   esc_html__(' Hide the wheel on the Homepage.***', 'spin-rewards-for-woocommerce' ),
                ),

                'wheel_design' => array(
                    'title'         => esc_html__('Wheel Popup Icon Design', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'icon_display_position' => array(
                    'title'      => esc_html__( 'Icon Display Position', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect',
                    'default'    => 'show_wheel',
                    'name'       => 'srwc_settings[icon_display_position]',
                    'options'    => array(
                        'top-left'      => esc_html__( 'Top Left', 'spin-rewards-for-woocommerce' ),
                        'top-right'     => esc_html__( 'Top Right', 'spin-rewards-for-woocommerce' ),
                        'bottom-left'   => esc_html__( 'Bottom left', 'spin-rewards-for-woocommerce' ),
                        'bottom-right'  => esc_html__( 'Bottom Right', 'spin-rewards-for-woocommerce' ),
                        'middle-left'   => esc_html__( 'Middle Left (Pro)', 'spin-rewards-for-woocommerce' ),
                        'middle-right'  => esc_html__( 'Middle Right (Pro)', 'spin-rewards-for-woocommerce' ),
                    ),
                    'disabled_options'   => array( 'middle-left', 'middle-right' ),
                ),

                'custom_popup_icon' => array(
                    'title'      => esc_html__( 'Custom Popup Icon', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => '',
                    'name'       => 'srwc_settings[custom_popup_icon]',

                ),

                'custom_icon_color' => array(
                    'title'       => esc_html__( 'Custom Icon Color', 'spin-rewards-for-woocommerce' ),
                    'field_type'  => 'srwcpro', 
                    'default'     => '#ffffff',
                    'name'        => 'srwc_settings[custom_icon_color]',
                ),

                'custom_icon_bg_color' => array(
                    'title'       => esc_html__( 'Custom Icon Background', 'spin-rewards-for-woocommerce' ),
                    'field_type'  => 'srwcpro', 
                    'default'     => '#161616ff',
                    'name'        => 'srwc_settings[custom_icon_bg_color]',
                ),


            );

            return apply_filters( 'srwc_popup_fields', $fields );
        }

        public static function spin_rewards_field() {

            $fields = array(

                'user_name' => array(
                    'title'      => esc_html__( 'Name', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[user_name]',
                    'data_show'  => '.name_option',
                ),

                'user_on_mobile' => array(
                    'title'      => esc_html__( 'On Mobile', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'yes',
                    'name'       => 'srwc_settings[user_on_mobile]',
                    'style'      => 'user_name.yes',
                    'extra_class'=> 'name_option',
                ),

                'user_name_require' => array(
                    'title'      => esc_html__( 'Required', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'yes',
                    'name'       => 'srwc_settings[user_name_require]',
                    'style'      => 'user_name.yes',
                    'extra_class'=> 'name_option',
                ),

                'user_phone' => array(
                    'title'      => esc_html__( 'Mobile Number', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => 'yes',
                    'name'       => 'srwc_settings[user_phone]',
                ),

                'after_spining' => array(
                    'title'         => esc_html__('After Spinning', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'auto_hide_wheel' => array(
                    'title'      => esc_html__( 'Auto-hide wheel', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => 0,
                    'name'       => 'srwc_settings[auto_hide_wheel]',
                    'desc'       => esc_html__( 'Wheel hides automatically after spinning.', 'spin-rewards-for-woocommerce' ),
                    'unit'       => array(
                        'seconds' => esc_html__( 'Seconds', 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'seconds',
                    'unit_disabled' => true,
                ),

                'win_animation' => array(
                    'title'      => esc_html__( 'Win Animation', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => 'alphanumeric',
                    'name'       => 'srwc_settings[win_animation]',
                    'options'    => array(
                        'none'  => esc_html__( 'None', 'spin-rewards-for-woocommerce' ),
                        'fire'  => esc_html__( 'Firework', 'spin-rewards-for-woocommerce' ),
                    ),
                ),

                'win_message' => array(
                    'title'      => esc_html__( 'Win Message', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwceditor',
                    'default'    => esc_html__( 'Congratulations! You have won a {coupon_label} discount coupon. The coupon has been sent to the email address you provided when spinning. Redeem it at checkout {checkout} now!', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[win_message]',
                    'desc'       => esc_html__( 'Add notes or instructions for this coupon.', 'spin-rewards-for-woocommerce' ),
                ),

                'lose_message' => array(
                    'title'      => esc_html__( 'Lose Message', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwceditor',
                    'default'    => esc_html__( 'Oops! No luck this time. Try again!', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[lose_message]',
                ),

                'coupon_settings' => array(
                    'title'         => esc_html__('Apply Coupon Button Settings', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'apply_coupon_button' => array(
                    'title'      => esc_html__( 'Apply Coupon Button', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[apply_coupon_button]',
                    'desc'       => esc_html__( 'Show Apply Coupon button for coupon prize', 'spin-rewards-for-woocommerce' ),
                ),

            );

            return apply_filters( 'srwc_spin_rewards_fields', $fields );
        }


        public static function offer_coupon_field() {

            $fields = array(

                'code_type' => array(
                    'title'      => esc_html__( 'Coupon Type', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect',
                    'default'    => 'alphanumeric',
                    'name'       => 'srwc_settings[code_type]',
                    'options'    => array(
                        'alphanumeric'  => esc_html__( 'Alphanumeric', 'spin-rewards-for-woocommerce' ),
                        'numeric'       => esc_html__( 'Numeric', 'spin-rewards-for-woocommerce' ),
                    ),
                    'desc' => esc_html__( 'Select the type of coupon code.', 'spin-rewards-for-woocommerce' ),
                ),

                'coupon_length'  => array(
                    'title'      => esc_html__( 'Coupon Length', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => 6,
                    'name'       => 'srwc_settings[coupon_length]',
                    'desc'       => esc_html__( 'Set the length of the generated coupon code.', 'spin-rewards-for-woocommerce' ),
                ),

                'coupon_prefix'  => array(
                    'title'      => esc_html__( 'Coupon Prefix', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => '',
                    'name'       => 'srwc_settings[coupon_prefix]',
                    'desc'       => esc_html__( 'Add a prefix to the generated coupon code (e.g., SAVE-).', 'spin-rewards-for-woocommerce' ),
                ),

                'coupon_suffix'  => array(
                    'title'      => esc_html__( 'Coupon Suffix', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => '',
                    'name'       => 'srwc_settings[coupon_suffix]',
                    'desc'       => esc_html__( 'Add a suffix to the generated coupon code (e.g., -SAVE).', 'spin-rewards-for-woocommerce' ),
                ),

                'coupon_expiry_days' => array(
                    'title'      => esc_html__( 'Coupon Expiry', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => 30,
                    'name'       => 'srwc_settings[coupon_expiry_days]',
                    'desc'       => esc_html__( 'Number of days after which the coupon will expire.', 'spin-rewards-for-woocommerce' ),
                    'unit'       => array(
                        'days' => esc_html__( "Day's", 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'days',
                    'unit_disabled' => true,
                ),

                'usage_restrictions_title' => array(
                    'title'         => esc_html__('Usage Restriction', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'individual_use_only' => array(
                    'title'      => esc_html__( 'Individual use only', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[individual_use_only]',
                    'desc'       => esc_html__( 'Check this box if the coupon cannot be used in conjunction with other coupons.', 'spin-rewards-for-woocommerce' ),
                ),

                'exclude_sale' => array(
                    'title'      => esc_html__( 'Exclude Sale Items', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[exclude_sale]',
                    'desc'       => esc_html__( 'Prevent the coupon from applying to products already on sale.', 'spin-rewards-for-woocommerce' ),
                ),

                'minimum_spend' => array(
                    'title'      => esc_html__( 'Minimum spend ', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => '',
                    'name'       => 'srwc_settings[minimum_spend]',
                    'desc'       => esc_html__( 'The minimum spend to use the coupon.', 'spin-rewards-for-woocommerce' ),
                ),

                'maximum_spend' => array(
                    'title'      => esc_html__( 'Maximum spend ', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => '',
                    'name'       => 'srwc_settings[maximum_spend]',
                    'desc'       => esc_html__( 'The maximum spend to use the coupon.', 'spin-rewards-for-woocommerce' ),
                ),

                'include_products' => array(
                    'title'      => esc_html__( 'Include Products', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect2',
                    'default'    => array(),
                    'name'       => 'srwc_settings[include_products]',
                    'options'    => SRWC_Options::get_product_options(),
                    'multiple'   => true,
                    'placeholder'=> esc_html__( 'Please add a Product...', 'spin-rewards-for-woocommerce' ),
                    'desc'       => esc_html__( 'Selected products will be inclluded from this coupon.', 'spin-rewards-for-woocommerce' ),
                ),

                'exclude_products' => array(
                    'title'      => esc_html__( 'Exclude Products', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect2',
                    'default'    => array(),
                    'name'       => 'srwc_settings[exclude_products]',
                    'options'    => SRWC_Options::get_product_options(),
                    'multiple'   => true,
                    'placeholder'=> esc_html__( 'Please exclude a Product...', 'spin-rewards-for-woocommerce' ),
                    'desc'       => esc_html__( 'Selected products will be excluded from this coupon.', 'spin-rewards-for-woocommerce' ),
                ),

                'include_categories' => array(
                    'title'      => esc_html__( 'Include Categories', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect2',
                    'default'    => array(),
                    'name'       => 'srwc_settings[include_categories]',
                    'options'    => SRWC_Options::get_category_options(),
                    'multiple'   => true,
                    'placeholder'=> esc_html__( 'Please add a Category...', 'spin-rewards-for-woocommerce' ),
                    'desc'       => esc_html__( 'Only products in these categories will be eligible for the coupon.', 'spin-rewards-for-woocommerce' ),
                ),

                'exclude_categories' => array(
                    'title'      => esc_html__( 'Exclude Categories', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect2',
                    'default'    => array(),
                    'name'       => 'srwc_settings[exclude_categories]',
                    'options'    => SRWC_Options::get_category_options(),
                    'multiple'   => true,
                    'placeholder'=> esc_html__( 'Please exclude a Category...', 'spin-rewards-for-woocommerce' ),
                    'desc'       => esc_html__( 'Products in these categories will be excluded from the coupon.', 'spin-rewards-for-woocommerce' ),
                ),

                'usage_limit' => array(
                    'title'         => esc_html__('Usage limits', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),
                
                'limit_coupon'  => array(
                    'title'      => esc_html__( 'Usage limit per coupon', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => 1,
                    'name'       => 'srwc_settings[limit_coupon]',
                    'desc'       => esc_html__( 'Set the total number of times this coupon can be used before it becomes invalid.', 'spin-rewards-for-woocommerce' ),
                ),

                'limit_coupon_to_x_items'  => array(
                    'title'      => esc_html__( 'Limit usage to X items', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => 1,
                    'name'       => 'srwc_settings[limit_coupon_to_x_items]',
                    'desc'       => esc_html__( 'Set the total number of times this coupon can be used before it becomes invalid.', 'spin-rewards-for-woocommerce' ),
                ),

                'limit_coupon_per_user'  => array(
                    'title'      => esc_html__( 'Usage limit per user', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => 1,
                    'name'       => 'srwc_settings[limit_coupon_per_user]',
                    'desc'       => esc_html__( 'Set the total number of times this coupon can be used before it becomes invalid.', 'spin-rewards-for-woocommerce' ),
                ),

            );

            return apply_filters( 'srwc_offer_coupon_fields', $fields );
        }

        public static function wheel_design_field() {

            $fields = array( 

                // 'full_wheel' => array(
                //     'title'      => esc_html__( 'Show in Full Wheel', 'spin-rewards-for-woocommerce' ),
                //     'field_type' => 'srwcswitch',
                //     'default'    => 'yes',
                //     'name'       => 'srwc_settings[full_wheel]',
                //     'desc'       => esc_html__( 'Enable to show the full wheel on desktop.', 'spin-rewards-for-woocommerce' ),
                // ),

                'wheel_speed_spin' => array(
                    'title'      => esc_html__( 'Wheel Speed Spin', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect',
                    'default'    => 'three',
                    'name'       => 'srwc_settings[wheel_speed_spin]',
                    'options'    => array(
                        'one'   => esc_html__( '1', 'spin-rewards-for-woocommerce' ),
                        'two'   => esc_html__( '2', 'spin-rewards-for-woocommerce' ),
                        'three' => esc_html__( '3', 'spin-rewards-for-woocommerce' ),
                        'four'  => esc_html__( '4', 'spin-rewards-for-woocommerce' ),
                        'five'  => esc_html__( '5 (Pro)', 'spin-rewards-for-woocommerce' ),
                        'six'   => esc_html__( '6 (Pro)', 'spin-rewards-for-woocommerce' ),
                        'seven' => esc_html__( '7 (Pro)', 'spin-rewards-for-woocommerce' ),
                        'eight' => esc_html__( '8 (Pro)', 'spin-rewards-for-woocommerce' ),
                    ),
                    'disabled_options'   => array( 'five', 'six', 'seven', 'eight' ),
                ),

                'wheel_time_duration' => array(
                    'title'      => esc_html__( 'Wheel Time Duration', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => '3',
                    'name'       => 'srwc_settings[wheel_time_duration]',
                ),

                'wheel_text_size' => array(
                    'title'      => esc_html__( 'Adjust Wheel Text Size', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => '18',
                    'name'       => 'srwc_settings[wheel_text_size]',
                    'unit'       => array(
                        'px'            => esc_html__( 'PX', 'spin-rewards-for-woocommerce' ),
                        'percentage'    => esc_html__( '%', 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'px',
                ),

                'wheel_size' => array(
                    'title'      => esc_html__( 'Adjust Wheel Size', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => '100',
                    'name'       => 'srwc_settings[wheel_size]',
                    'unit'       => array(
                        'px'            => esc_html__( 'PX', 'spin-rewards-for-woocommerce' ),
                        'percentage'    => esc_html__( '%', 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'percentage',
                ),

                'wheel_pointer' => array(
                    'title'      => esc_html__( 'Wheel pointer Position', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect',
                    'default'    => 'show_wheel',
                    'name'       => 'srwc_settings[wheel_pointer]',
                    'options'    => array(
                        'center' => esc_html__( 'Center', 'spin-rewards-for-woocommerce' ),
                        'top'    => esc_html__( 'Top (Pro)', 'spin-rewards-for-woocommerce' ),
                        'right'  => esc_html__( 'Right (Pro)', 'spin-rewards-for-woocommerce' ),
                        'bottom' => esc_html__( 'Bottom (Pro)', 'spin-rewards-for-woocommerce' ),
                        'random' => esc_html__( 'Random (Pro)', 'spin-rewards-for-woocommerce' ),
                    ),
                    'disabled_options'   => array( 'top', 'right', 'bottom', 'random' ),
                ),

                'wheel_pointer_color' => array(
                    'title'      => esc_html__( 'Wheel Pointer Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#000',
                    'name'       => 'srwc_settings[wheel_pointer_color]',
                ),

                'wheel_pointer_cutout_type' => array(
                    'title'      => esc_html__( 'Wheel Pointer Cutout Type', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect',
                    'options'    => array(
                        'color' => esc_html__( 'Color', 'spin-rewards-for-woocommerce' ),
                        'custom'  => esc_html__( 'Custom Image', 'spin-rewards-for-woocommerce' ),
                    ),
                    'default'    => 'color',
                    'name'       => 'srwc_settings[wheel_pointer_cutout_type]',
                    'data_hide'  => '.wheel_pointer_cutout_image_option, .wheel_pointer_cutout_color_option',
                    'data_show'  => array(
                        'custom'  => '.wheel_pointer_cutout_image_option',
                        'color'  => '.wheel_pointer_cutout_color_option',
                    ),
                ),
                'wheel_pointer_cutout_color' => array(
                    'title'      => esc_html__( 'Wheel Pointer Cutout Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#000000ff',
                    'name'       => 'srwc_settings[wheel_pointer_cutout_color]',
                    'style'      => 'wheel_pointer_cutout_type.color',
                    'extra_class'=> 'wheel_pointer_cutout_color_option',
                ),

                'wheel_pointer_cutout_image' => array(
                    'title'      => esc_html__( 'Wheel Pointer Cutout Image', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcmedia',
                    'default'    => '',
                    'name'       => 'srwc_settings[wheel_pointer_cutout_image]',
                    'style'      => 'wheel_pointer_cutout_type.custom',
                    'extra_class'=> 'wheel_pointer_cutout_image_option',
                ),

                'wheel_center_color' => array(
                    'title'      => esc_html__( 'Wheel Center Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#ffffffff',
                    'name'       => 'srwc_settings[wheel_center_color]',
                ),

                'wheel_border_color' => array(
                    'title'      => esc_html__( 'Wheel Border Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#ffffffff',
                    'name'       => 'srwc_settings[wheel_border_color]',
                ),  

                'wheel_border_width' => array(
                    'title'      => esc_html__( 'Wheel Border Width', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => '4',
                    'name'       => 'srwc_settings[wheel_border_width]',
                    'unit'       => array(
                        'px' => esc_html__( 'PX', 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'px',
                    'unit_disabled' => true,
                    'desc'       => esc_html__( 'Set the width of the wheel border.', 'spin-rewards-for-woocommerce' ),
                ),

                'background_image' => array(
                    'title'      => esc_html__( 'Background Image', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect',
                    'options'    => array(
                        'default_img' => esc_html__( 'Default', 'spin-rewards-for-woocommerce' ),
                        'custom'  => esc_html__( 'Custom Image', 'spin-rewards-for-woocommerce' ),
                    ),
                    'default'    => 'default_img',
                    'name'       => 'srwc_settings[background_image]',
                    'data_hide'  => '.bg_image_option',
                    'data_show'  => array(
                        'custom'  => '.bg_image_option',
                    ),
                ),

                'custom_background_image' => array(
                    'title'      => esc_html__( 'Custom Background Image', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcmedia',
                    'default'    => '',
                    'name'       => 'srwc_settings[custom_background_image]',
                    'style'      => 'background_image.custom',
                    'extra_class'=> 'bg_image_option',
                ),

                'background_blend_mode' => array(
                    'title'      => esc_html__( 'Background Blend Mode', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect',
                    'options'    => array(
                        'none' => esc_html__( 'None', 'spin-rewards-for-woocommerce' ),
                        'overlay' => esc_html__( 'Overlay', 'spin-rewards-for-woocommerce' ),
                        'multiply' => esc_html__( 'Multiply', 'spin-rewards-for-woocommerce' ),
                        'screen' => esc_html__( 'Screen', 'spin-rewards-for-woocommerce' ),
                        'soft-light' => esc_html__( 'Soft Light', 'spin-rewards-for-woocommerce' ),
                        'hard-light' => esc_html__( 'Hard Light', 'spin-rewards-for-woocommerce' ),
                        'color-dodge' => esc_html__( 'Color Dodge', 'spin-rewards-for-woocommerce' ),
                        'color-burn' => esc_html__( 'Color Burn', 'spin-rewards-for-woocommerce' ),
                        'darken' => esc_html__( 'Darken', 'spin-rewards-for-woocommerce' ),
                        'lighten' => esc_html__( 'Lighten', 'spin-rewards-for-woocommerce' ),
                        'normal' => esc_html__( 'Normal', 'spin-rewards-for-woocommerce' ),
                    ),
                    'default'    => 'overlay',
                    'name'       => 'srwc_settings[background_blend_mode]',
                    'desc'       => esc_html__( 'How the background color blends with the background image.', 'spin-rewards-for-woocommerce' ),
                ),

                'background_color' => array(
                    'title'      => esc_html__( 'Background Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#087988ff',
                    'name'       => 'srwc_settings[background_color]',
                ),

                'text_color' => array(
                    'title'      => esc_html__( 'Text Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#ffffffff',
                    'name'       => 'srwc_settings[text_color]',
                ),

                'rewards_title' => array(
                    'title'      => esc_html__( 'Rewards Title', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwceditor',
                    'default'    => esc_html__( 'GET YOUR CHANCE TO WIN A PRIZE!', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[rewards_title]',
                ),

                'rewards_title_color' => array(
                    'title'      => esc_html__( 'Rewards Title Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#ffffff',
                    'name'       => 'srwc_settings[rewards_title_color]',
                ),

                'spin_button_text' => array(
                    'title'      => esc_html__( 'Spin Button Text', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => esc_html__( 'Spin Now', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[spin_button_text]',
                    'desc'       => esc_html__( 'Text to display on the Spin Wheel button.', 'spin-rewards-for-woocommerce' ),
                ),

                'spin_button_text_size' => array(
                    'title'      => esc_html__( 'Spin Button Text Size', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => '18',
                    'name'       => 'srwc_settings[spin_button_text_size]',
                    'unit'       => array(
                        'px'            => esc_html__( 'PX', 'spin-rewards-for-woocommerce' ),
                        'percentage'    => esc_html__( '%', 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'px',
                ),

                'spin_button_text_color' => array(
                    'title'      => esc_html__( 'Spin Button Text Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#ffffff',
                    'name'       => 'srwc_settings[spin_button_text_color]',
                ),

                'spin_button_bg_color' => array(
                    'title'      => esc_html__( 'Spin Button Background Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#111111ff',
                    'name'       => 'srwc_settings[spin_button_bg_color]',
                ),

                'spin_button_hover_bg_color' => array(
                    'title'      => esc_html__( 'Spin Button Background Hover Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#000000ff',
                    'name'       => 'srwc_settings[spin_button_hover_bg_color]',
                ),

                'spin_bg_effects' => array(
                    'title'      => esc_html__( 'Background Effects', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => '',
                    'name'       => 'srwc_settings[spin_bg_effects]',
                ),

            );

            return apply_filters( 'srwc_wheel_design_fields', $fields );
        }

        public static function wheel_slides_field() {

            // Default slides configuration
            $default_slides = array(
                array(
                    'coupon_type' => 'none',
                    'label' => 'Not Lucky',
                    'value' => '0',
                    'probability' => '17',
                    'color' => '#ffe0b2',
                    'default' => '0'
                ),
                array(
                    'coupon_type' => 'percent',
                    'label' => '{coupon_amount}% OFF',
                    'value' => '15',
                    'probability' => '17',
                    'color' => '#d43606',
                    'default' => '0'
                ),
                array(
                    'coupon_type' => 'none',
                    'label' => 'Not Lucky',
                    'value' => '0',
                    'probability' => '17',
                    'color' => '#b2ffe0',
                    'default' => '0'
                ),
                array(
                    'coupon_type' => 'percent',
                    'label' => '{coupon_amount}% OFF',
                    'value' => '5',
                    'probability' => '17',
                    'color' => '#e65100',
                    'default' => '0'
                ),
                array(
                    'coupon_type' => 'none',
                    'label' => 'Not Lucky',
                    'value' => '0',
                    'probability' => '17',
                    'color' => '#ffb74d',
                    'default' => '0'
                ),
                array(
                    'coupon_type' => 'fixed_product',
                    'label' => '₹ {coupon_amount} OFF',
                    'value' => '10',
                    'probability' => '15',
                    'color' => '#fb8c00',
                    'default' => '1'
                )
            );

            $fields = array( 

                'slides' => array(
                    'title'         => esc_html__('Slides Table', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwcslidesoption',
                    'name'          => 'srwc_settings[slides]',
                    'default'       => $default_slides, 
                ),
            );

            return apply_filters( 'srwc_wheel_slides_fields', $fields );
        }

        /**
         * Generates the customer notification email settings fields.
         *
         * @return array The settings fields for customer notification emails.
         */
        public static function notification_field() {

            $fields = array(

                'enable_customer_email' => array(
                    'title'      => esc_html__( 'Enable Customer Notification', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'yes',
                    'name'       => 'srwc_settings[enable_customer_email]',
                    'desc'       => esc_html__( 'Send an email notification to the customer when they win a coupon from the spin wheel.', 'spin-rewards-for-woocommerce' ),
                ),

                'admin_notification_title' => array(
                    'title'         => esc_html__('Admin Notification', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'enable_admin_email' => array(
                    'title'      => esc_html__( 'Enable Admin Notification', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => 'yes',
                    'name'       => 'srwc_settings[enable_admin_email]',
                    'desc'       => esc_html__( 'Send an email notification to the site admin when a customer wins a coupon from the spin wheel.', 'spin-rewards-for-woocommerce' ),
                ),

            );

            return apply_filters( 'srwc_customer_notification_fields', $fields );
        }

        public static function email_api_field() {

            $fields = array(

                'enable_mailchimp' => array(
                    'title'      => esc_html__( 'Enable Mailchimp', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[enable_mailchimp]',
                    'desc'       => esc_html__( 'Turn on to use MailChimp system', 'spin-rewards-for-woocommerce' ),
                    'data_show'  => '.enable_mailchimp',
                ),

                'mailchimp_double_optin' => array(
                    'title'      => esc_html__( 'Mailchimp Double Optin', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[mailchimp_double_optin]',
                    'desc'       => esc_html__( 'If enabled, a confirm subscription email will be sent to each subscriber for them to confirm that they subscribe to your list.', 'spin-rewards-for-woocommerce' ),
                    'style'      => 'enable_mailchimp.yes',
                    'extra_class'=> 'enable_mailchimp',
                ),

                'mailchimp_api_key' => array(
                    'title'      => esc_html__( 'API Key', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => '',
                    'name'       => 'srwc_settings[mailchimp_api_key]',
                    'desc'       => esc_html__( 'The API key for connecting with your MailChimp account. Get your API key ', 'spin-rewards-for-woocommerce' ) . '<a href="https://login.mailchimp.com/login/unified-login?referrer=%2Faccount%2Fapi%2F" target="_blank">' . esc_html__( 'here', 'spin-rewards-for-woocommerce' ) . '</a>.',
                    'style'      => 'enable_mailchimp.yes',
                    'extra_class'=> 'enable_mailchimp',
                ),

                'mailchimp_lists' => array(
                    'title'      => esc_html__( 'Mailchimp Lists', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect2',
                    'default'    => array(),
                    'name'       => 'srwc_settings[mailchimp_lists]',
                    'options'    => array(), // Will be populated via AJAX
                    'multiple'   => true,
                    'placeholder'=> esc_html__( 'Select lists...', 'spin-rewards-for-woocommerce' ),
                    'style'      => 'enable_mailchimp.yes',
                    'extra_class'=> 'enable_mailchimp',
                ),

                'activecampaign_title' => array(
                    'title'         => esc_html__('Active Campaign', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'enable_activecampaign' => array(
                    'title'      => esc_html__( 'Active Campaign', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[enable_activecampaign]',
                    'desc'       => esc_html__( 'Turn on to use ActiveCampaign system', 'spin-rewards-for-woocommerce' ),
                    'data_show'  => '.enable_activecampaign',
                ),

                'activecampaign_api_key' => array(
                    'title'      => esc_html__( 'Active Campaign API Key', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => '',
                    'name'       => 'srwc_settings[activecampaign_api_key]',
                    'style'      => 'enable_activecampaign.yes',
                    'extra_class'=> 'enable_activecampaign',
                ),

                'activecampaign_api_url' => array(
                    'title'      => esc_html__( 'Active Campaign API URL', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => '',
                    'name'       => 'srwc_settings[activecampaign_api_url]',
                    'style'      => 'enable_activecampaign.yes',
                    'extra_class'=> 'enable_activecampaign',
                ),

                'activecampaign_lists' => array(
                    'title'      => esc_html__( 'Active Campaign List', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => array(),
                    'name'       => 'srwc_settings[activecampaign_lists]',
                    'options'    => array(), // Will be populated via AJAX
                    'multiple'   => true,
                    'placeholder'=> esc_html__( 'Type list name', 'spin-rewards-for-woocommerce' ),
                    'style'      => 'enable_activecampaign.yes',
                    'extra_class'=> 'enable_activecampaign',
                ),

                'sendgrid_title' => array(
                    'title'         => esc_html__('SendGrid', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'enable_sendgrid' => array(
                    'title'      => esc_html__( 'SendGrid', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[enable_sendgrid]',
                    'desc'       => esc_html__( 'Turn on to use SendGrid system', 'spin-rewards-for-woocommerce' ),
                    'data_show'  => '.enable_sendgrid',
                ),

                'sendgrid_api_key' => array(
                    'title'      => esc_html__( 'SendGrid API Key', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => '',
                    'name'       => 'srwc_settings[sendgrid_api_key]',
                    'desc'       => esc_html__( '*This is the API key that\'s shown only once when you created it, not the API key ID.', 'spin-rewards-for-woocommerce' ) . '<br>' .
                                   esc_html__( '**This API Key must have full-access permission of API Keys. You can set it ', 'spin-rewards-for-woocommerce' ) . '<a href="https://app.sendgrid.com/settings/api_keys" target="_blank">' . esc_html__( 'here', 'spin-rewards-for-woocommerce' ) . '</a>.',
                    'style'      => 'enable_sendgrid.yes',
                    'extra_class'=> 'enable_sendgrid',
                ),

                'sendgrid_lists' => array(
                    'title'      => esc_html__( 'Sendgrid Lists', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => array(),
                    'name'       => 'srwc_settings[sendgrid_lists]',
                    'options'    => array(
                        'none' => esc_html__( 'Do not add to any list', 'spin-rewards-for-woocommerce' ),
                    ),
                    'multiple'   => false,
                    'placeholder'=> esc_html__( 'Select list...', 'spin-rewards-for-woocommerce' ),
                    'style'      => 'enable_sendgrid.yes',
                    'extra_class'=> 'enable_sendgrid',
                ),

                'metrilo_title' => array(
                    'title'         => esc_html__('Metrilo', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'enable_metrilo' => array(
                    'title'      => esc_html__( 'Metrilo', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[enable_metrilo]',
                    'desc'       => esc_html__( 'Turn on to use Metrilo system', 'spin-rewards-for-woocommerce' ),
                    'data_show'  => '.enable_metrilo',
                ),

                'metrilo_token' => array(
                    'title'      => esc_html__( 'Metrilo Token', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => '',
                    'name'       => 'srwc_settings[metrilo_token]',
                    'style'      => 'enable_metrilo.yes',
                    'extra_class'=> 'enable_metrilo',
                ),

                'metrilo_tag' => array(
                    'title'      => esc_html__( 'Metrilo Tag', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => '',
                    'name'       => 'srwc_settings[metrilo_tag]',
                    'desc'       => esc_html__( 'Please enter tags separated by comma(,)', 'spin-rewards-for-woocommerce' ),
                    'style'      => 'enable_metrilo.yes',
                    'extra_class'=> 'enable_metrilo',
                ),

                'subscribed_title' => array(
                    'title'         => esc_html__('Subscribed', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'enable_subscribed' => array(
                    'title'      => esc_html__( 'Subscribed', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[enable_subscribed]',
                    'desc'       => esc_html__( 'If the user has opted in for receiving emails.', 'spin-rewards-for-woocommerce' ),
                ),

                'hubspot_title' => array(
                    'title'         => esc_html__('Hubspot', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'enable_hubspot' => array(
                    'title'      => esc_html__( 'Hubspot', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[enable_hubspot]',
                    'desc'       => esc_html__( 'Turn on to use Hubspot system', 'spin-rewards-for-woocommerce' ),
                    'data_show'  => '.enable_hubspot',
                ),

                'hubspot_api_key' => array(
                    'title'      => esc_html__( 'Hubspot API Key', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => '',
                    'name'       => 'srwc_settings[hubspot_api_key]',
                    'desc'       => esc_html__( '**The API key for connecting with your Hubspot account. Get your API key ', 'spin-rewards-for-woocommerce' ) . '<a href="https://developers.hubspot.com/docs/api/private-apps" target="_blank">' . esc_html__( 'here', 'spin-rewards-for-woocommerce' ) . '</a>.',
                    'style'      => 'enable_hubspot.yes',
                    'extra_class'=> 'enable_hubspot',
                ),

                'klaviyo_title' => array(
                    'title'         => esc_html__('Klaviyo', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'enable_klaviyo' => array(
                    'title'      => esc_html__( 'Klaviyo', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[enable_klaviyo]',
                    'desc'       => esc_html__( 'Turn on to use Klaviyo system', 'spin-rewards-for-woocommerce' ),
                    'data_show'  => '.enable_klaviyo',
                ),

                'klaviyo_api_key' => array(
                    'title'      => esc_html__( 'Klaviyo API Key', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => '',
                    'name'       => 'srwc_settings[klaviyo_api_key]',
                    'desc'       => esc_html__( '**The API key for connecting with your Klaviyo account. Get your API key ', 'spin-rewards-for-woocommerce' ) . '<a href="https://www.klaviyo.com/account#api-keys-tab" target="_blank">' . esc_html__( 'here', 'spin-rewards-for-woocommerce' ) . '</a>.',
                    'style'      => 'enable_klaviyo.yes',
                    'extra_class'=> 'enable_klaviyo',
                ),

                'klaviyo_lists' => array(
                    'title'      => esc_html__( 'Klaviyo Lists', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => array(),
                    'name'       => 'srwc_settings[klaviyo_lists]',
                    'options'    => array(),
                    'multiple'   => true,
                    'placeholder'=> esc_html__( 'Select lists...', 'spin-rewards-for-woocommerce' ),
                    'style'      => 'enable_klaviyo.yes',
                    'extra_class'=> 'enable_klaviyo',
                ),

                'brevo_title' => array(
                    'title'         => esc_html__('Brevo (Sendinblue)', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'enable_brevo' => array(
                    'title'      => esc_html__( 'Brevo (Sendinblue)', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[enable_brevo]',
                    'desc'       => esc_html__( 'Turn on to use Brevo system', 'spin-rewards-for-woocommerce' ),
                    'data_show'  => '.enable_brevo',
                ),

                'brevo_api_key' => array(
                    'title'      => esc_html__( 'Brevo API Key', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => '',
                    'name'       => 'srwc_settings[brevo_api_key]',
                    'desc'       => esc_html__( '**The API key for connecting with your Brevo account. Get your API key ', 'spin-rewards-for-woocommerce' ) . '<a href="https://app.brevo.com/settings/keys/api" target="_blank">' . esc_html__( 'here', 'spin-rewards-for-woocommerce' ) . '</a>.',
                    'style'      => 'enable_brevo.yes',
                    'extra_class'=> 'enable_brevo',
                ),

                'brevo_lists' => array(
                    'title'      => esc_html__( 'Brevo Lists', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => array(),
                    'name'       => 'srwc_settings[brevo_lists]',
                    'options'    => array(),
                    'multiple'   => true,
                    'placeholder'=> esc_html__( 'Select lists...', 'spin-rewards-for-woocommerce' ),
                    'style'      => 'enable_brevo.yes',
                    'extra_class'=> 'enable_brevo',
                    'desc'       => esc_html__( 'When you are mapping to the SMS field, the Mobile Number should be passed with the proper country code.', 'spin-rewards-for-woocommerce' ) . '<br>' .
                                   esc_html__( 'For example, it can only accept the value to be either +91xxxxxxxxxx or 0091xxxxxxxxxx form. Any other value entered would result in an error, hence the form submission will not be successful.', 'spin-rewards-for-woocommerce' ) . '<br>' .
                                   esc_html__( 'This means that the field type has to be a TEXT type if you want it to accept both formats (i.e +91xxxxxxxxxx or 0091xxxxxxxxxx). E.g 0061467029760 or +61467029760', 'spin-rewards-for-woocommerce' ),
                ),

                'sendy_title' => array(
                    'title'         => esc_html__('Sendy', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'enable_sendy' => array(
                    'title'      => esc_html__( 'Sendy', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[enable_sendy]',
                    'desc'       => esc_html__( 'Turn on to use Sendy system', 'spin-rewards-for-woocommerce' ),
                    'data_show'  => '.enable_sendy',
                ),

                'sendy_api_key' => array(
                    'title'      => esc_html__( 'Sendy API Key', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => '',
                    'name'       => 'srwc_settings[sendy_api_key]',
                    'desc'       => esc_html__( '**The API key for connecting with your Sendy account. Get your API key ', 'spin-rewards-for-woocommerce' ) . '<a href="https://sendy.co/api" target="_blank">' . esc_html__( 'here', 'spin-rewards-for-woocommerce' ) . '</a>.',
                    'style'      => 'enable_sendy.yes',
                    'extra_class'=> 'enable_sendy',
                ),

                'sendy_login_url' => array(
                    'title'      => esc_html__( 'Sendy Login URL', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => '',
                    'name'       => 'srwc_settings[sendy_login_url]',
                    'desc'       => esc_html__( '**Your domain Sendy url, including http:// or https:// in the url. Example: https://sendy.co/demo', 'spin-rewards-for-woocommerce' ),
                    'style'      => 'enable_sendy.yes',
                    'extra_class'=> 'enable_sendy',
                ),

                'sendy_brand' => array(
                    'title'      => esc_html__( 'Sendy Brand', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => array(),
                    'name'       => 'srwc_settings[sendy_brand]',
                    'options'    => array(),
                    'multiple'   => false,
                    'placeholder'=> esc_html__( 'Select brand...', 'spin-rewards-for-woocommerce' ),
                    'style'      => 'enable_sendy.yes',
                    'extra_class'=> 'enable_sendy',
                ),

            );

            return apply_filters( 'srwc_email_api_fields', $fields );
        }

        public static function localization_field() {
            $fields = array(

                'name_required_message' => array(
                    'title'      => esc_html__( 'Name Required Message', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => esc_html__( 'Please enter your name', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[name_required_message]',
                    'style'      => 'user_name.yes',
                    'extra_class'=> 'name_option',
                    'desc'       => esc_html__( 'Custom message to display when name is required but not provided.', 'spin-rewards-for-woocommerce' ),
                ),

                'email_required_message' => array(
                    'title'      => esc_html__( 'Email Required Message', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => esc_html__( 'Please enter your email', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[email_required_message]',
                    'desc'       => esc_html__( 'Custom message to display when email is required but not provided.', 'spin-rewards-for-woocommerce' ),
                ),

                'email_invalid_message' => array(
                    'title'      => esc_html__( 'Email Invalid Message', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => esc_html__( 'Please enter a valid email address', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[email_invalid_message]',
                    'desc'       => esc_html__( 'Custom message to display when email format is invalid.', 'spin-rewards-for-woocommerce' ),
                ),

                'mobile_message'  => array(
                    'title'      => esc_html__( 'Mobile Required Message', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcpro',
                    'default'    => 'Please enter your mobile.',
                    'name'       => 'srwc_settings[mobile_message]',
                    'desc'       => esc_html__( 'Add a message to the mobile.', 'spin-rewards-for-woocommerce' ),
                ),

                'design_title' => array(
                    'title'         => esc_html__('Design', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'error_message_color' => array(
                    'title'      => esc_html__( 'Error Message Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#ff4444',
                    'name'       => 'srwc_settings[error_message_color]',
                    'desc'       => esc_html__( 'Color for validation error messages.', 'spin-rewards-for-woocommerce' ),
                ),

                'error_message_font_size' => array(
                    'title'      => esc_html__( 'Error Message Font Size', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => '14',
                    'name'       => 'srwc_settings[error_message_font_size]',
                    'unit'       => array(
                        'px' => esc_html__( 'PX', 'spin-rewards-for-woocommerce' ),
                        'em' => esc_html__( 'EM', 'spin-rewards-for-woocommerce' ),
                        'rem' => esc_html__( 'REM', 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'px',
                    'desc'       => esc_html__( 'Font size for validation error messages.', 'spin-rewards-for-woocommerce' ),
                ),

            );

            return apply_filters( 'srwc_localization_fields', $fields );
        }
    }

endif;

<?php

// Exit if accessed directly.
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
                    'default'    => 1,
                    'name'       => 'srwc_settings[spin_per_email]',
                    'min'        => 1,
                    'max'        => null,
                    'desc'       => esc_html__( 'Set how many times a customer can spin the wheel using the same email address. Must be greater than 0.', 'spin-rewards-for-woocommerce' ),
                ),

                'time_spin_between' => array(
                    'title'      => esc_html__( 'Time Between 2 Spins', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => 1,
                    'name'       => 'srwc_settings[time_spin_between]',
                    'unit'       => array(
                        'seconds' => esc_html__( 'Seconds', 'spin-rewards-for-woocommerce' ),
                        'minutes' => esc_html__( 'Minutes', 'spin-rewards-for-woocommerce' ),
                        'hours'   => esc_html__( 'Hours', 'spin-rewards-for-woocommerce' ),
                        'days'    => esc_html__( 'Days', 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'hours',
                    'desc'       => esc_html__( 'Set the minimum time a customer must wait before spinning the wheel again.', 'spin-rewards-for-woocommerce' ),
                ),

            );

            return apply_filters( 'srwc_general_fields', $fields );
        }

        /**
         * Generates the popup fields for spin rewards configuration.
         *
         * @return array The popup fields for the popup configuration.
         */
        public static function popup_field() {

            $fields = array(

                'popup_trigger' => array(
                    'title'      => esc_html__( 'Popup Trigger Options', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect',
                    'default'    => 'show_wheel',
                    'name'       => 'srwc_settings[popup_trigger]',
                    'options'    => array(
                        'popup_icon' => esc_html__( 'Popup icon', 'spin-rewards-for-woocommerce' ),
                        'show_wheel' => esc_html__( 'Automatically display the wheel after a set delay', 'spin-rewards-for-woocommerce' ),
                        'on_scroll'  => esc_html__( 'Show the wheel after users scroll down a specific value (Pro)', 'spin-rewards-for-woocommerce' ),
                        'on_exit'    => esc_html__( 'Trigger the wheel when the user moves the mouse toward closing the browser (Pro)', 'spin-rewards-for-woocommerce' ),
                    ),
                    'disabled_options'   => array( 'on_scroll', 'on_exit' ),
                ),

                'initial_delay' => array(
                    'title'      => esc_html__( 'Initial Delay', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => 0,
                    'name'       => 'srwc_settings[initial_delay]',
                    'desc'       => esc_html__( 'Set a delay (in seconds) before the popup icon appears after the trigger action. Enter a single number of seconds, e.g., 2.', 'spin-rewards-for-woocommerce' ),
                    'unit'       => array(
                        'seconds' => esc_html__( 'Second\'s', 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'seconds',
                    'unit_disabled' => true,
                ),

                'time_on_close' => array(
                    'title'      => esc_html__( 'Re-display the popup after this time if the wheel is closed without a spin', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => 1,
                    'name'       => 'srwc_settings[time_on_close]',
                    'unit'       => array(
                        'minutes' => esc_html__( 'Minutes', 'spin-rewards-for-woocommerce' ),
                        'hours'   => esc_html__( 'Hours', 'spin-rewards-for-woocommerce' ),
                        'days'    => esc_html__( 'Days', 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'days',
                ),

                'show_again' => array(
                    'title'      => esc_html__( 'After one spin, show popup again', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => 24,
                    'name'       => 'srwc_settings[show_again]',
                    'unit'       => array(
                        'seconds' => esc_html__( 'Seconds', 'spin-rewards-for-woocommerce' ),
                        'minutes' => esc_html__( 'Minutes', 'spin-rewards-for-woocommerce' ),
                        'hours'   => esc_html__( 'Hours', 'spin-rewards-for-woocommerce' ),
                        'days'    => esc_html__( 'Days', 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'hours',
                ),

                'hide_icon' => array(
                    'title'      => esc_html__( 'Hide Icon', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'yes',
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

                                   esc_html__( '***Use || to combine two or more conditionals. The wheel will display if any of the conditions match.e.g ', 'spin-rewards-for-woocommerce' ) . '<b>' . 
                                   esc_html__( 'is_cart() || is_checkout()', 'spin-rewards-for-woocommerce' ) . '</b> ' . 
                                   esc_html__('Show the wheel on both the Cart and Checkout pages.***', 'spin-rewards-for-woocommerce' ) . '<br>' .

                                   esc_html__( '***Add an exclamation mark ! before a conditional to hide the wheel when that condition is true.e.g ', 'spin-rewards-for-woocommerce' ) . '<b>' . 
                                   esc_html__( '!is_home()', 'spin-rewards-for-woocommerce' ) . '</b> ' . 
                                   esc_html__(' Hide the wheel on the Homepage.***', 'spin-rewards-for-woocommerce' ),
                ),

                'wheel_design' => array(
                    'title'         => esc_html__('Popup Icon Design', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'icon_display_position' => array(
                    'title'      => esc_html__( 'Popup Icon Position', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect',
                    'default'    => 'bottom-right',
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

            );

            return apply_filters( 'srwc_popup_fields', $fields );
        }

        /**
         * Generates the spin rewards fields for spin rewards configuration.
         *
         * @return array The spin rewards fields for the spin rewards configuration.
         */

        public static function spin_rewards_field() {

            $fields = array(

                'user_name' => array(
                    'title'      => esc_html__( 'Name', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'yes',
                    'name'       => 'srwc_settings[user_name]',
                    'data_show'  => '.name_option',
                ),

                'user_name_require' => array(
                    'title'      => esc_html__( 'Name Required', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[user_name_require]',
                    'style'      => 'user_name.yes',
                    'extra_class'=> 'name_option',
                ),

                'name_border' => array(
                    'title'      => esc_html__( 'Name Border Radius', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => 10,
                    'name'       => 'srwc_settings[name_border]',
                    'desc'       => esc_html__( 'Set the border width for the name input field.', 'spin-rewards-for-woocommerce' ),
                    'unit'       => array(
                        'px' => esc_html__( 'PX', 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'px',
                    'unit_disabled' => true,
                    'style'      => 'user_name.yes',
                    'extra_class'=> 'name_option',
                ),

                'email_border' => array(
                    'title'      => esc_html__( 'Email Border Radius', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => 10,
                    'name'       => 'srwc_settings[email_border]',
                    'desc'       => esc_html__( 'Set the border width for the name input field.', 'spin-rewards-for-woocommerce' ),
                    'unit'       => array(
                        'px' => esc_html__( 'PX', 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'px',
                    'unit_disabled' => true,
                ),

                'after_spining' => array(
                    'title'         => esc_html__('After Spinning', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'auto_hide_wheel' => array(
                    'title'      => esc_html__( 'Auto hide wheel', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => 0,
                    'name'       => 'srwc_settings[auto_hide_wheel]',
                    'desc'       => esc_html__( 'Wheel hides automatically after spinning.', 'spin-rewards-for-woocommerce' ),
                    'unit'       => array(
                        'seconds' => esc_html__( 'Second\'s', 'spin-rewards-for-woocommerce' ),
                    ),
                    'unit_selected' => 'seconds',
                    'unit_disabled' => true,
                ),

                'win_message' => array(
                    'title'      => esc_html__( 'Win Message', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwceditor',
                    'default'    => esc_html__( 'Congratulations! You have won a {coupon_label} discount coupon! We’ve sent the coupon to the email address you used during the spin. Use it at {checkout} and enjoy your savings!', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[win_message]',
                    'desc'       =>esc_html__( '{coupon_label} - Label of coupon that customers win' , 'spin-rewards-for-woocommerce' ) . '<br>' .
                                   esc_html__( '{checkout} - Link to checkout page' , 'spin-rewards-for-woocommerce' ),
                ),

                'lose_message' => array(
                    'title'      => esc_html__( 'Loss Message', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwceditor',
                    'default'    => esc_html__( 'OOPS! No luck this time. Try again!', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[lose_message]',
                ),

                'gdpr_title' => array(
                    'title'         => esc_html__('GDPR Settings', 'spin-rewards-for-woocommerce'),
                    'field_type'    => 'srwctitle',
                    'extra_class'   => 'heading',
                    'default'       => '',
                ),

                'gdpr_checkbox' => array(
                    'title'      => esc_html__( 'GDPR Checkbox', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[gdpr_checkbox]',
                    'desc'       => esc_html__( 'Enable GDPR consent checkbox on the spin wheel form.', 'spin-rewards-for-woocommerce' ),
                    'data_show'  => '.gdpr_option',
                ),

                'gdpr_message' => array(
                    'title'      => esc_html__( 'GDPR Message', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwceditor',
                    'default'    => esc_html__( 'I agree with the term and condition', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[gdpr_message]',
                    'desc'       => esc_html__( 'Custom message for the GDPR consent checkbox.', 'spin-rewards-for-woocommerce' ),
                    'style'      => 'gdpr_checkbox.yes',
                    'extra_class'=> 'gdpr_option',
                ),

            );

            return apply_filters( 'srwc_spin_rewards_fields', $fields );
        }

        /**
         * Generates the offer coupon fields for spin rewards configuration.
         *
         * @return array The offer coupon fields for the offer coupon configuration.
         */

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

                'allow_free_shipping' => array(
                    'title'      => esc_html__( 'Allow Free Shipping', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[allow_free_shipping]',
                    'desc'       => esc_html__( 'Check this box if the coupon grants free shipping. A ', 'spin-rewards-for-woocommerce' ) . 
                                    ' <a href="https://woocommerce.com/document/free-shipping/" target="_blank">' . 
                                    esc_html__( 'free shipping method', 'spin-rewards-for-woocommerce' ) . '</a>'.
                                    esc_html__( ' must be enabled in your shipping zone and be set to require "a valid free shipping coupon" (see the "Free Shipping Requires" setting).', 'spin-rewards-for-woocommerce' ),
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

                'apply_coupon_limit' => array(
                    'title'      => esc_html__( 'Apply Coupon Limit', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcnumber',
                    'default'    => 1,
                    'name'       => 'srwc_settings[apply_coupon_limit]',
                    'desc'       => esc_html__( 'The maximum number of times a coupon can be applied to an order.', 'spin-rewards-for-woocommerce' ),
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

        /**
         * Generates the wheel design fields for spin rewards configuration.
         *
         * @return array The wheel design fields for the wheel design configuration.
         */
        public static function wheel_design_field() {

            $fields = array( 

                'wheel_speed_spin' => array(
                    'title'      => esc_html__( 'Wheel Speed Spin', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect',
                    'default'    => 'five',
                    'name'       => 'srwc_settings[wheel_speed_spin]',
                    'options'    => array(
                        'one'   => esc_html__( '1 (pro)', 'spin-rewards-for-woocommerce' ),
                        'two'   => esc_html__( '2 (pro)', 'spin-rewards-for-woocommerce' ),
                        'three' => esc_html__( '3 (pro)', 'spin-rewards-for-woocommerce' ),
                        'four'  => esc_html__( '4 (pro)', 'spin-rewards-for-woocommerce' ),
                        'five'  => esc_html__( '5', 'spin-rewards-for-woocommerce' ),
                        'six'   => esc_html__( '6 (Pro)', 'spin-rewards-for-woocommerce' ),
                        'seven' => esc_html__( '7 (Pro)', 'spin-rewards-for-woocommerce' ),
                        'eight' => esc_html__( '8 (Pro)', 'spin-rewards-for-woocommerce' ),
                        'nine'  => esc_html__( '9 (Pro)', 'spin-rewards-for-woocommerce' ),
                        'ten'   => esc_html__( '10 (Pro)', 'spin-rewards-for-woocommerce' ),
                    ),
                    'disabled_options'   => array( 'one', 'two', 'three', 'four', 'six', 'seven', 'eight', 'nine', 'ten' ),
                ),

                'wheel_pointer' => array(
                    'title'      => esc_html__( 'Wheel Pointer Position', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect',
                    'default'    => 'center',
                    'name'       => 'srwc_settings[wheel_pointer]',
                    'options'    => array(
                        'center' => esc_html__( 'Center', 'spin-rewards-for-woocommerce' ),
                        'top'    => esc_html__( 'Top (Pro)', 'spin-rewards-for-woocommerce' ),
                        'bottom' => esc_html__( 'Bottom (Pro)', 'spin-rewards-for-woocommerce' ),
                        'right'  => esc_html__( 'Right (Pro)', 'spin-rewards-for-woocommerce' ),
                        'left'   => esc_html__( 'Left (Pro)', 'spin-rewards-for-woocommerce' ),
                    ),
                    'disabled_options'   => array( 'top', 'bottom', 'right', 'left' ),
                ),

                'wheel_pointer_color' => array(
                    'title'      => esc_html__( 'Wheel Pointer Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#f70707',
                    'name'       => 'srwc_settings[wheel_pointer_color]',
                ),

                'wheel_pointer_type' => array(
                    'title'      => esc_html__( 'Wheel Pointer Type', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcselect',
                    'options'    => array(
                        'color'  => esc_html__( 'Color', 'spin-rewards-for-woocommerce' ),
                        'custom' => esc_html__( 'Custom Image', 'spin-rewards-for-woocommerce' ),
                    ),
                    'default'    => 'color',
                    'name'       => 'srwc_settings[wheel_pointer_type]',
                    'data_hide'  => '.wheel_pointer_image_option, .wheel_pointer_cutout_color_option',
                    'data_show'  => array(
                        'custom' => '.wheel_pointer_image_option',
                        'color'  => '.wheel_pointer_cutout_color_option',
                    ),
                    'disabled_options'   => array( 'custom' ),
                ),

                'wheel_pointer_cutout_color' => array(
                    'title'      => esc_html__( 'Wheel Pointer Cutout Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#ffffff',
                    'name'       => 'srwc_settings[wheel_pointer_cutout_color]',
                    'style'      => 'wheel_pointer_type.color',
                    'extra_class'=> 'wheel_pointer_cutout_color_option',
                ),

                'wheel_center_color' => array(
                    'title'      => esc_html__( 'Wheel Center Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#ffffff',
                    'name'       => 'srwc_settings[wheel_center_color]',
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
                        'none'          => esc_html__( 'None', 'spin-rewards-for-woocommerce' ),
                        'overlay'       => esc_html__( 'Overlay', 'spin-rewards-for-woocommerce' ),
                        'multiply'      => esc_html__( 'Multiply', 'spin-rewards-for-woocommerce' ),
                        'screen'        => esc_html__( 'Screen', 'spin-rewards-for-woocommerce' ),
                        'soft-light'    => esc_html__( 'Soft Light', 'spin-rewards-for-woocommerce' ),
                        'hard-light'    => esc_html__( 'Hard Light', 'spin-rewards-for-woocommerce' ),
                        'color-dodge'   => esc_html__( 'Color Dodge', 'spin-rewards-for-woocommerce' ),
                        'color-burn'    => esc_html__( 'Color Burn', 'spin-rewards-for-woocommerce' ),
                        'darken'        => esc_html__( 'Darken', 'spin-rewards-for-woocommerce' ),
                        'lighten'       => esc_html__( 'Lighten', 'spin-rewards-for-woocommerce' ),
                        'normal'        => esc_html__( 'Normal', 'spin-rewards-for-woocommerce' ),
                    ),
                    'default'    => 'overlay',
                    'name'       => 'srwc_settings[background_blend_mode]',
                    'desc'       => esc_html__( 'How the background color blends with the background image.', 'spin-rewards-for-woocommerce' ),
                ),

                'background_color' => array(
                    'title'      => esc_html__( 'Background Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#189a7a',
                    'name'       => 'srwc_settings[background_color]',
                ),

                'text_color' => array(
                    'title'      => esc_html__( 'Win & Loss Text Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#000000',
                    'name'       => 'srwc_settings[text_color]',
                ),

                'not_display_wheel_again' => array(
                    'title'      => esc_html__( 'Not Display Wheel Again', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwcswitch',
                    'default'    => 'no',
                    'name'       => 'srwc_settings[not_display_wheel_again]',
                    'desc'       => esc_html__( 'If enabled, the wheel will not be displayed again for the same user.', 'spin-rewards-for-woocommerce' ),
                    'data_show'  => '.not-display-options',
                ),

                'not_display_option_never' => array(
                    'title'      => esc_html__( 'Never Text', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => esc_html__( 'Never', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[not_display_option_never]',
                    'desc'       => esc_html__( 'Text for the Never option.', 'spin-rewards-for-woocommerce' ),
                    'style'      => 'not_display_wheel_again.yes',
                    'extra_class'=> 'not-display-options',
                ),

                'not_display_option_remind_later' => array(
                    'title'      => esc_html__( 'Remind Later Text', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => esc_html__( 'Remind later', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[not_display_option_remind_later]',
                    'desc'       => esc_html__( 'Text for the Remind later option.', 'spin-rewards-for-woocommerce' ),
                    'style'      => 'not_display_wheel_again.yes',
                    'extra_class'=> 'not-display-options',
                ),

                'not_display_option_no_thanks' => array(
                    'title'      => esc_html__( 'No Thanks Text', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => esc_html__( 'No thanks', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[not_display_option_no_thanks]',
                    'desc'       => esc_html__( 'Text for the No thanks option.', 'spin-rewards-for-woocommerce' ),
                    'style'      => 'not_display_wheel_again.yes',
                    'extra_class'=> 'not-display-options',
                ),

                'not_display_option_color' => array(
                    'title'      => esc_html__( 'Option Text Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#333333',
                    'name'       => 'srwc_settings[not_display_option_color]',
                    'desc'       => esc_html__( 'Color for the Option Text', 'spin-rewards-for-woocommerce' ),
                    'style'      => 'not_display_wheel_again.yes',
                    'extra_class'=> 'not-display-options',
                ),

                'not_display_option_hover_color' => array(
                    'title'      => esc_html__( 'Option Hover Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#000000',
                    'name'       => 'srwc_settings[not_display_option_hover_color]',
                    'desc'       => esc_html__( 'Hover color for the Option Text', 'spin-rewards-for-woocommerce' ),
                    'style'      => 'not_display_wheel_again.yes',
                    'extra_class'=> 'not-display-options',
                ),
                
                'rewards_title' => array(
                    'title'      => esc_html__( 'Rewards Title', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwceditor',
                    'default'    => esc_html__( 'SPIN TO WIN!', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[rewards_title]',
                ),

                'spin_button_text' => array(
                    'title'      => esc_html__( 'Spin Button Text', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => esc_html__( 'Spin Now', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[spin_button_text]',
                    'desc'       => esc_html__( 'Text to display on the Spin Wheel button.', 'spin-rewards-for-woocommerce' ),
                ),

                'spin_button_text_color' => array(
                    'title'      => esc_html__( 'Spin Button Text Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#ffffff',
                    'name'       => 'srwc_settings[spin_button_text_color]',
                ),

                'spin_button_text_hover_color' => array(
                    'title'      => esc_html__( 'Spin Button Text Hover Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#ffffff',
                    'name'       => 'srwc_settings[spin_button_text_hover_color]',
                ),

                'spin_button_bg_color' => array(
                    'title'      => esc_html__( 'Spin Button Background Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#ff9000',
                    'name'       => 'srwc_settings[spin_button_bg_color]',
                ),

                'spin_button_hover_bg_color' => array(
                    'title'      => esc_html__( 'Spin Button Hover Color', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwccolor',
                    'default'    => '#ffad42',
                    'name'       => 'srwc_settings[spin_button_hover_bg_color]',
                ),
            );

            return apply_filters( 'srwc_wheel_design_fields', $fields );
        }

        /**
         * Generates the wheel slides fields for spin rewards configuration.
         *
         * @return array The wheel slides fields for the wheel slides configuration.
         */
        public static function wheel_slides_field() {

            // Get default slides configuration from default options
            $default_options = include SRWC_PATH . 'includes/static/srwc-default-option.php';
            $default_slides = $default_options['srwc_settings']['slides'];

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
         * Generates the notification fields for spin rewards configuration.
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
                    'desc'       => esc_html__( 'Send an email notification to the customer when they win a coupon from the spin rewards.', 'spin-rewards-for-woocommerce' ),
                ),

            );

            return apply_filters( 'srwc_notification_fields', $fields );
        }

        /**
         * Generates the email API fields for spin rewards configuration.
         *
         * @return array The email API fields for the email API configuration.
         */
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
                    'title'      => esc_html__( 'Mailchimp Audience ID', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => '',
                    'name'       => 'srwc_settings[mailchimp_lists]',
                    'desc'       => esc_html__( 'The Audience ID to subscribe users to. Get your Audience ID ', 'spin-rewards-for-woocommerce' ) . '<a href="https://us16.admin.mailchimp.com/audience/settings/" target="_blank">' . esc_html__( 'here', 'spin-rewards-for-woocommerce' ) . '</a>.',
                    'multiple'   => true,
                    'placeholder'=> esc_html__( 'Enter Audience ID', 'spin-rewards-for-woocommerce' ),
                    'style'      => 'enable_mailchimp.yes',
                    'extra_class'=> 'enable_mailchimp',
                ),
            );

            return apply_filters( 'srwc_email_api_fields', $fields );
        }

        /**
         * Generates the localization fields for spin rewards configuration.
         *
         * @return array The localization fields for the localization configuration.
         */
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

                'mobile_invalid_message' => array(
                    'title'      => esc_html__( 'Mobile Invalid Message', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => esc_html__( 'Please enter a valid mobile number', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[mobile_invalid_message]',
                    'desc'       => esc_html__( 'Custom message to display when mobile format is invalid.', 'spin-rewards-for-woocommerce' ),
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

                'spin_limit_email_message' => array(
                    'title'      => esc_html__( 'Spin Limit Email Message', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => esc_html__( 'You’ve reached your spin limit.', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[spin_limit_email_message]',
                    'desc'       => esc_html__( 'Custom message to display when email spin limit is exceeded.', 'spin-rewards-for-woocommerce' ),
                ),

                'wait_spin_message' => array(
                    'title'      => esc_html__( 'Wait Time Message', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => esc_html__( 'You must wait {time} before spinning again.', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[wait_spin_message]',
                    'desc'       => esc_html__( 'Custom message to display when user must wait between spins. Use {time} placeholder for the wait time.', 'spin-rewards-for-woocommerce' ),
                ),

                'gdpr_required_message' => array(
                    'title'      => esc_html__( 'GDPR Required Message', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => esc_html__( 'Please agree with our term and condition.', 'spin-rewards-for-woocommerce' ),
                    'name'       => 'srwc_settings[gdpr_required_message]',
                    'desc'       => esc_html__( 'Custom message to display when GDPR checkbox is not checked.', 'spin-rewards-for-woocommerce' ),
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
                    'default'    => '#ffffff',
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
                    ),
                    'unit_selected' => 'px',
                    'unit_disabled' => true,
                    'desc'       => esc_html__( 'Font size for validation error messages.', 'spin-rewards-for-woocommerce' ),
                ),

            );

            return apply_filters( 'srwc_localization_fields', $fields );
        }

        /**
         * Generates the custom CSS fields for spin rewards configuration.
         *
         * @return array The custom CSS fields for the custom CSS configuration.
         */
        public static function custom_css_field() {
            $fields = array(

                'custom_css_class' => array(
                    'title'      => esc_html__( 'Custom CSS Class', 'spin-rewards-for-woocommerce' ),
                    'field_type' => 'srwctext',
                    'default'    => '',
                    'name'       => 'srwc_settings[custom_css_class]',
                    'placeholder' => 'my-custom-wheel',
                    'desc'       => esc_html__( 'Add a custom CSS class to the wheel modal container. This class will be added to the .srwc-wheel-modal element.', 'spin-rewards-for-woocommerce' ),
                ),

                'custom_css' => array(
                    'title'       => esc_html__( 'Custom CSS', 'spin-rewards-for-woocommerce' ),
                    'field_type'  => 'srwctextarea',
                    'default'     => '',
                    'name'        => 'srwc_settings[custom_css]',
                    'rows'        => 12,
                    'placeholder' => esc_html__( '/* Add your custom CSS here */', 'spin-rewards-for-woocommerce' ),
                    'desc'        => esc_html__( 'Add your custom CSS code here. This CSS will be applied to the spin wheel on the frontend.', 'spin-rewards-for-woocommerce' ),
                ),

            );

            return apply_filters( 'srwc_custom_css_fields', $fields );
        }
    }

endif;

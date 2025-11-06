<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_Mailchimp' ) ) :

     /**
	 * Class SRWC_Mailchimp
     * 
	 */
    class SRWC_Mailchimp {

        /**
         * Plugin settings
         * @var array
         */
        protected $settings;

        /**
         * Constructor for the class.
         */
        public function __construct() {
            $this->events_handler();
        }

        /**
         * Initialize hooks and filters.
         */
        public function events_handler(){
            $this->settings = get_option( 'srwc_settings', array() );

            // Subscribe user
            add_action( 'wp_ajax_srwc_mailchimp_subscribe', array( $this, 'subscribe_user' ) );
            add_action( 'wp_ajax_nopriv_srwc_mailchimp_subscribe', array( $this, 'subscribe_user' ) );
            
            // Confirmation handler for double opt-in
            add_action( 'init', array( $this, 'handle_confirmation' ) );
        }

        public function subscribe_user() {

            if ( ! isset( $_POST['nonce'] ) || ! 
                wp_verify_nonce( 
                    sanitize_text_field( wp_unslash( $_POST['nonce'] ) ),
                    'srwc_nonce' 
                )
            ) :
                return;
            endif;

            if ( empty( $this->settings['enable_mailchimp'] ) || $this->settings['enable_mailchimp'] !== 'yes' ) :      
                wp_send_json_error( array( 'message' => 'Mailchimp disabled' ), 400 );
            endif;

            $email        = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
            $name         = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
            $country_code = isset( $_POST['country_code'] ) ? sanitize_text_field( wp_unslash( $_POST['country_code'] ) ) : '';
            $mobile       = isset( $_POST['mobile'] ) ? sanitize_text_field( wp_unslash( $_POST['mobile'] ) ) : '';

            if ( empty( $email ) || ! is_email( $email ) ) :
                wp_send_json_error( array( 'message' => 'Invalid email' ), 400 );
            endif;

            $api_key  = isset( $this->settings['mailchimp_api_key'] ) ? trim( $this->settings['mailchimp_api_key'] ) : '';
            $list_id  = isset( $this->settings['mailchimp_lists'] ) ? trim( $this->settings['mailchimp_lists'] ) : '';
            $double   = isset( $this->settings['mailchimp_double_optin'] ) && $this->settings['mailchimp_double_optin'] === 'yes';

            if ( empty( $api_key ) || empty( $list_id ) ) :
                wp_send_json_error( array( 'message' => 'Missing Mailchimp config' ), 400 );
            endif;

            // Extract datacenter from API key
            $dc = 'us1';
                if ( strpos( $api_key, '-' ) !== false ) :
                $parts = explode( '-', $api_key );
                if ( ! empty( $parts[1] ) ) :
                    $dc = $parts[1];
                endif;
            endif;

            $endpoint     = sprintf( 'https://%s.api.mailchimp.com/3.0/lists/%s/members', $dc, rawurlencode( $list_id ) );
            $merge_fields = array();

            if ( ! empty( $this->settings['user_name'] ) && $this->settings['user_name'] === 'yes' && ! empty( $name ) ) :
                $merge_fields['FNAME'] = $name;
            endif;

            if ( ! empty( $this->settings['user_mobile'] ) && $this->settings['user_mobile'] === 'yes' && ! empty( $mobile ) ) :
                $full_mobile = $country_code && $mobile ? $country_code . ' ' . $mobile : $mobile;
                $merge_fields['PHONE'] = $full_mobile;
            endif;

            // If double opt-in is enabled, send confirmation email instead of directly subscribing
            if ( $double ) :
                $confirmation_token = wp_generate_password( 32, false );
                
                $subscription_data = array(
                    'email'        => $email,
                    'name'         => $name,
                    'country_code' => $country_code,
                    'mobile'       => $mobile,
                    'api_key'      => $api_key,
                    'list_id'      => $list_id,
                    'merge_fields' => $merge_fields,
                    'dc'           => $dc,
                );
                
                set_transient( 'srwc_mailchimp_pending_' . $confirmation_token, $subscription_data, 7 * DAY_IN_SECONDS );
                
                // Generate confirmation URL
                $confirmation_url = add_query_arg(
                    array(
                        'srwc_mailchimp_confirm' => '1',
                        'token'                  => $confirmation_token,
                        'email'                  => rawurlencode( $email ),
                    ),
                    home_url( '/' )
                );
                
                set_transient( 'srwc_mailchimp_confirmation_url_' . md5( $email ), $confirmation_url, 7 * DAY_IN_SECONDS );
                
                wp_send_json_success( array( 'message' => 'Confirmation email will be sent with your win email. Please check your email to confirm subscription.' ) );
                return;
            endif;

            // Direct subscription when double opt-in is disabled
            $payload = array(
                'email_address' => $email,
                'status'        => 'subscribed',
            );

            if ( ! empty( $merge_fields ) ) :
                $payload['merge_fields'] = $merge_fields;
            endif;

            $response = wp_remote_post( $endpoint, array(
                'timeout' => 20,
                'headers' => array(
                    'Authorization' => 'Basic ' . base64_encode( 'user:' . $api_key ),
                    'Content-Type'  => 'application/json',
                ),
                'body'    => wp_json_encode( $payload ),
            ) );

            if ( is_wp_error( $response ) ) :
                wp_send_json_error( array( 'message' => $response->get_error_message() ), 500 );
            endif;

            $code = wp_remote_retrieve_response_code( $response );
            $body = wp_remote_retrieve_body( $response );

            if ( $code >= 200 && $code < 300 ) :
                wp_send_json_success( array( 'message' => 'Subscribed' ) );
            endif;

            wp_send_json_error( array( 'message' => 'Mailchimp error', 'response' => $body ), $code );
        }

        /**
         * Handle Mailchimp confirmation when user clicks confirmation link
         */
        public function handle_confirmation() {

            if ( ! isset( $_POST['nonce'] ) || ! 
                wp_verify_nonce( 
                    sanitize_text_field( wp_unslash( $_POST['nonce'] ) ),
                    'srwc_nonce' 
                )
            ) :
                return;
            endif;
            
            if ( ! isset( $_GET['srwc_mailchimp_confirm'] ) || $_GET['srwc_mailchimp_confirm'] !== '1' ) :
                return;
            endif;

            $token = isset( $_GET['token'] ) ? sanitize_text_field( wp_unslash( $_GET['token'] ) ) : '';
            $email = isset( $_GET['email'] ) ? sanitize_email( wp_unslash( $_GET['email'] ) ) : '';

            if ( empty( $token ) || empty( $email ) ) :
                wp_die( esc_html__( 'Invalid confirmation link.', 'spin-rewards-for-woocommerce' ), esc_html__( 'Error', 'spin-rewards-for-woocommerce' ), array( 'response' => 400 ) );
                return;
            endif;

            // Get subscription data from transient
            $subscription_data = get_transient( 'srwc_mailchimp_pending_' . $token );

            if ( false === $subscription_data ) :
                wp_die( esc_html__( 'Confirmation link has expired or is invalid. Please try subscribing again.', 'spin-rewards-for-woocommerce' ), esc_html__( 'Error', 'spin-rewards-for-woocommerce' ), array( 'response' => 400 ) );
                return;
            endif;

            if ( $subscription_data['email'] !== $email ) :
                wp_die( esc_html__( 'Invalid confirmation link.', 'spin-rewards-for-woocommerce' ), esc_html__( 'Error', 'spin-rewards-for-woocommerce' ), array( 'response' => 400 ) );
                return;
            endif;

            $endpoint = sprintf( 'https://%s.api.mailchimp.com/3.0/lists/%s/members', $subscription_data['dc'], rawurlencode( $subscription_data['list_id'] ) );
            $payload  = array(
                'email_address' => $subscription_data['email'],
                'status'        => 'subscribed',
            );

            if ( ! empty( $subscription_data['merge_fields'] ) ) :
                $payload['merge_fields'] = $subscription_data['merge_fields'];
            endif;

            $response = wp_remote_post( $endpoint, array(
                'timeout' => 20,
                'headers' => array(
                    'Authorization' => 'Basic ' . base64_encode( 'user:' . $subscription_data['api_key'] ),
                    'Content-Type'  => 'application/json',
                ),
                'body'    => wp_json_encode( $payload ),
            ) );

            // Delete transient regardless of success/failure
            delete_transient( 'srwc_mailchimp_pending_' . $token );

            if ( is_wp_error( $response ) ) :
                wp_die( 
                    esc_html__( 'An error occurred while confirming your subscription. Please try again later.', 'spin-rewards-for-woocommerce' ),
                    esc_html__( 'Error', 'spin-rewards-for-woocommerce' ),
                    array( 'response' => 500 )
                );
                return;
            endif;

            $code = wp_remote_retrieve_response_code( $response );
            $body = wp_remote_retrieve_body( $response );

            if ( $code >= 200 && $code < 300 ) :
                $template_path = SRWC_TEMPLATE_PATH . 'emails/srwc-mailchimp.php';
                include $template_path;
                exit;
            else :
                wp_die( 
                    esc_html__( 'An error occurred while confirming your subscription. Please try again later.', 'spin-rewards-for-woocommerce' ),
                    esc_html__( 'Error', 'spin-rewards-for-woocommerce' ),
                    array( 'response' => 500 )
                );
            endif;
        }
    }

    new SRWC_Mailchimp();
endif;



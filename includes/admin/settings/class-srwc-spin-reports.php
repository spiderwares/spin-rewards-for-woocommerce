<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_Spin_Reports' ) ) :

    /**
	 * Class SRWC_Spin_Reports
     * 
	 */
    class SRWC_Spin_Reports {

        /**
		 * Plugin settings.
		 *
		 * @var array
		 */
        public $settings;  

        /**
         * Constructor for the class.
         */
        public function __construct() {
            $this->events_handler();
        }
        
        /**
         * Initialize hooks and filters.
         */
        private function events_handler() {
            $this->settings = get_option( 'srwc_settings', array() );

            // AJAX handler to export emails
            add_action( 'wp_ajax_srwc_export_emails', [ $this, 'export_emails' ] );
            add_action( 'wp_ajax_nopriv_srwc_export_emails', [ $this, 'export_emails' ] );
        }

        /**
         * AJAX handler to export emails
         */
        public function export_emails() {
            check_ajax_referer( 'srwc_admin_nonce', 'nonce' );
        
            $from_date = isset( $_POST['from_date'] ) ? sanitize_text_field( wp_unslash( $_POST['from_date'] ) ) : '';
            $to_date   = isset( $_POST['to_date'] ) ? sanitize_text_field( wp_unslash( $_POST['to_date'] ) ) : '';
        
            // Fetch spin records
            $args = array(
                'post_type'      => 'srwc_spin_record',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'meta_query'     => array(
                    array(
                        'key'     => 'srwc_customer_email',
                        'compare' => 'EXISTS'
                    )
                )
            );
        
            if ( $from_date && $to_date ) :
                $args['meta_query'][] = array(
                    'key'     => 'srwc_spin_date',
                    'value'   => array( $from_date, $to_date . ' 23:59:59' ),
                    'compare' => 'BETWEEN',
                    'type'    => 'DATETIME'
                );
            endif;
        
            $spin_records = get_posts( $args );
            $csv_data     = array();
            $show_name    = ! empty( $this->settings['user_name'] ) && $this->settings['user_name'] === 'yes';
            $show_mobile  = ! empty( $this->settings['user_mobile'] ) && $this->settings['user_mobile'] === 'yes';
        
            // Build CSV headers based on enabled fields
            $headers = array( 'Email' );
            if ( $show_name ) :
                $headers[] = 'Name';
            endif;

            if ( $show_mobile ) :
                $headers[] = 'Mobile Number';
            endif;
            
            $headers[] = 'Spin Date';
            $headers[] = 'Win Label';
            $headers[] = 'Coupon Code';
            
            $csv_data[] = $headers;
        
            foreach ( $spin_records as $record ) :
                $email       = get_post_meta( $record->ID, 'srwc_customer_email', true );
                $name        = get_post_meta( $record->ID, 'srwc_customer_name', true );
                $mobile      = get_post_meta( $record->ID, 'srwc_customer_mobile', true );
                $spin_date   = get_post_meta( $record->ID, 'srwc_spin_date', true );
                $win_label   = get_post_meta( $record->ID, 'srwc_win_label', true );
                $coupon_code = get_post_meta( $record->ID, 'srwc_coupon_code', true );
        
                if ( $email ) :
                    // Build CSV row based on enabled fields
                    $row = array( $email );
                    
                    if ( $show_name ) :
                        $row[] = $name ?: 'Sir/Ma\'am';
                    endif;
                    
                    if ( $show_mobile ) :
                        $row[] = $mobile ?: '';
                    endif;
                    
                    $row[] = $spin_date ? date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $spin_date ) ) : '';
                    $row[] = $win_label ?: '';
                    $row[] = $coupon_code ?: '';
                    
                    $csv_data[] = $row;
                endif;
            endforeach;
        
            // Generate CSV
            $filename = 'spin-rewards-emails-' . date_i18n( 'Y-m-d-H-i-s' ) . '.csv';
            
            header( 'Content-Type: text/csv' );
            header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
        
            $output = fopen( 'php://output', 'w' );
            foreach ( $csv_data as $row ) :
                fputcsv( $output, $row );
            endforeach;
            
            // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose
            fclose( $output );
            exit;
        }

    }

    // Initialize the class.
    new SRWC_Spin_Reports();

endif;

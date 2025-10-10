<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_Spin_Wheel_Reports' ) ) :

    class SRWC_Spin_Wheel_Reports {

        /**
         * Constructor for the class.
         */
        public function __construct() {
            $this->event_handler();
        }
        
        /**
         * Initialize hooks and filters.
         */
        private function event_handler() {

            // AJAX handler to export emails
            add_action( 'wp_ajax_srwc_export_emails', [ $this, 'export_emails' ] );
            add_action( 'wp_ajax_nopriv_srwc_export_emails', [ $this, 'export_emails' ] );
        }

        /**
         * AJAX handler to export emails
         */
        public function export_emails() {
            check_ajax_referer( 'srwc_admin_nonce', 'nonce' );

            $from_date = isset( $_POST['from_date'] ) ? sanitize_text_field( $_POST['from_date'] ) : '';
            $to_date = isset( $_POST['to_date'] ) ? sanitize_text_field( $_POST['to_date'] ) : '';

            // Get spin records with emails
            $args = array(
                'post_type' => 'srwc_spin_record',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => 'srwc_customer_email',
                        'compare' => 'EXISTS'
                    )
                )
            );

            if ( $from_date && $to_date ) :
                $args['meta_query'][] = array(
                    'key' => 'srwc_spin_date',
                    'value' => array( $from_date, $to_date . ' 23:59:59' ),
                    'compare' => 'BETWEEN',
                    'type' => 'DATETIME'
                );
            endif;

            $spin_records = get_posts( $args );

            // Prepare CSV data
            $csv_data = array();
            $csv_data[] = array( 'Email', 'Name', 'Spin Date', 'Win Label', 'Coupon Code' );

            foreach ( $spin_records as $record ) :
                $email          = get_post_meta( $record->ID, 'srwc_customer_email', true );
                $name           = get_post_meta( $record->ID, 'srwc_customer_name', true );
                $spin_date      = get_post_meta( $record->ID, 'srwc_spin_date', true );
                $win_label      = get_post_meta( $record->ID, 'srwc_win_label', true );
                $coupon_code    = get_post_meta( $record->ID, 'srwc_coupon_code', true );

                if ( $email ) :
                    $csv_data[] = array(
                        $email,
                        $name ? $name : 'Sir/Ma\'am',
                        $spin_date ? date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $spin_date ) ) : '',
                        $win_label ? $win_label : '',
                        $coupon_code ? $coupon_code : ''
                    );
                endif;
            endforeach;

            // Generate CSV
            $filename = 'spin-rewards-emails-' . date( 'Y-m-d-H-i-s' ) . '.csv';
            
            header( 'Content-Type: text/csv' );
            header( 'Content-Disposition: attachment; filename="' . $filename . '"' );

            $output = fopen( 'php://output', 'w' );
            foreach ( $csv_data as $row ) :
                fputcsv( $output, $row );
            endforeach;
            fclose( $output );
            exit;
        }

    }

    // Initialize the class.
    new SRWC_Spin_Wheel_Reports();

endif;

<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_Options' ) ) :

    /**
     * Class SRWC_Options
     * Handles product and category options for Spin Rewards for WooCommerce.
     */
    class SRWC_Options {

        /**
         * Get all published products as options array
         *
         * @return array Array of product options with ID as key and name as value
         */
        public static function get_product_options() {
            $product_options = array();

            if ( function_exists( 'wc_get_products' ) ) :
                $products = wc_get_products( 
                    array( 
                        'status' => 'publish', 
                        'limit' => -1 
                    ) 
                );

                foreach ( $products as $product ) :
                    $product_options[ $product->get_id() ] = $product->get_name();
                endforeach;
            endif;

            return $product_options;
        }

        /**
         * Get all product categories as options array
         *
         * @return array Array of category options with term_id as key and name as value
         */
        public static function get_category_options() {
            $category_options = array();

            $categories = get_terms( 
                array( 
                    'taxonomy' => 'product_cat', 
                    'hide_empty' => false 
                ) 
            );

            foreach ( $categories as $cat ) :           
                if ( ! is_wp_error( $cat ) ) :
                    $category_options[ $cat->term_id ] = $cat->name;
                endif;
            endforeach;

            return $category_options;
        }
    }

endif;

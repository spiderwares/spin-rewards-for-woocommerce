<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

foreach ( $fields as $field_Key => $field ) : 
    $field_Val  = isset( $options[ $field_Key ] ) ? $options[ $field_Key ] : $field['default']; 
    $field_type = isset( $field[ 'field_type' ] ) ? $field[ 'field_type' ] : ''; ?>

    <tr class="<?php echo isset( $field['extra_class'] ) ? esc_attr( $field['extra_class'] ) : '';  ?>"

        <?php if( isset($field[ 'style' ] ) && !empty( $field[ 'style' ] ) ): 
            $style = explode('.', $field['style'], 2); ?>
            style="<?php echo esc_attr( ( isset( $options[ $style[0] ] ) && $options[ $style[0] ] == $style[1] ) ? '' : 'display: none;' ); ?>" 
        <?php endif; ?> >

        <?php if( $field['field_type'] != 'srwcslidesoption' ):  ?>
            <th scope="row" class="srwc-label <?php echo esc_attr( $field_type ); ?>" <?php echo ( $field_type === 'srwctitle' ) ? 'colspan="2"' : ''; ?>>
                <?php echo esc_html( $field['title'] ); ?>
            </th>
        <?php endif; ?>
        
        <?php
        
            switch ( $field['field_type'] ) :

                case "srwcswitch":
                    wc_get_template(
                        'fields/switch-field.php', 
                        array(
                            'field'     => $field,
                            'field_Val' => $field_Val,
                            'field_Key' => $field_Key,
                        ),
                        'spin-rewards-for-woocommerce/',
                        SRWC_TEMPLATE_PATH
                    );
                    break;

                case "srwcnumber":
                    wc_get_template(
                        'fields/number-field.php', 
                        array(
                            'field'     => $field,
                            'field_Val' => $field_Val,
                            'field_Key' => $field_Key,
                        ),
                        'spin-rewards-for-woocommerce/',
                        SRWC_TEMPLATE_PATH
                    );
                    break;

                case "srwcselect":
                    wc_get_template(
                        'fields/select-field.php', 
                        array(
                            'field'     => $field,
                            'field_Val' => $field_Val,
                            'field_Key' => $field_Key,
                        ),
                        'spin-rewards-for-woocommerce/',
                        SRWC_TEMPLATE_PATH
                    );
                    break;

                case "srwccolor":
                    wc_get_template(
                        'fields/color-field.php', 
                        array(
                            'field'     => $field,
                            'field_Val' => $field_Val,
                            'field_Key' => $field_Key,
                        ),
                        'spin-rewards-for-woocommerce/',
                        SRWC_TEMPLATE_PATH
                    );
                    break;

                case "srwctext":
                    wc_get_template(
                        'fields/text-field.php', 
                        array(
                            'field'     => $field,
                            'field_Val' => $field_Val,
                            'field_Key' => $field_Key,
                        ),
                        'spin-rewards-for-woocommerce/',
                        SRWC_TEMPLATE_PATH
                    );
                    break;

                case "srwctextarea":
                    wc_get_template(
                        'fields/textarea-field.php', 
                        array(
                            'field'     => $field,
                            'field_Val' => $field_Val,
                            'field_Key' => $field_Key,
                        ),
                        'spin-rewards-for-woocommerce/',
                        SRWC_TEMPLATE_PATH
                    );
                    break;
                
                case "srwceditor":
                    wc_get_template(
                        'fields/editor-field.php', 
                        array(
                            'field'     => $field,
                            'field_Val' => $field_Val,
                            'field_Key' => $field_Key,
                        ),
                        'spin-rewards-for-woocommerce/',
                        SRWC_TEMPLATE_PATH
                    );
                    break;

                case "srwcselect2":
                    wc_get_template(
                        'fields/select2-field.php', 
                        compact( 'field', 'field_Val', 'field_Key' ),
                        'spin-rewards-for-woocommerce/',
                        SRWC_TEMPLATE_PATH
                    );
                    break;

                case "srwcmedia":
                    wc_get_template(
                        'fields/media-field.php',
                        array(
                            'field'     => $field,
                            'field_Val' => $field_Val,
                            'field_Key' => $field_Key,
                        ),
                        'spin-rewards-for-woocommerce/',
                        SRWC_TEMPLATE_PATH
                    );
                    break;

                case "srwcslidesoption":
                    wc_get_template(
                        'fields/slides-option.php',
                        array(
                            'field'     => $field,
                            'field_Val' => $field_Val,
                            'field_Key' => $field_Key,
                        ),
                        'spin-rewards-for-woocommerce/',
                        SRWC_TEMPLATE_PATH
                    );
                    break;

                case "srwctime":
                    ob_start();
                    $html = ob_get_clean();
        
					// Apply Pro filter only for srwctime field
					echo wp_kses_post( apply_filters( 'srwc_time_field', $html, $field, $field_Val, $field_Key ) );
                    break;
                
            endswitch;
        ?>
    </tr>

<?php endforeach; ?>
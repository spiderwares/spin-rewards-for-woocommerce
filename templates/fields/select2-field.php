<?php
/**
 * Select2 Field Template
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit; 
?>

<td class="forminp forminp-select2">
    <input type="hidden" name="<?php echo esc_attr( $field['name'] ); ?>[]" value="" />
    <select 
        class="srwc-select2" 
        name="<?php echo esc_attr( $field['name'] ); ?>[]" 
        id="<?php echo esc_attr( $field_Key ); ?>" 
        data-placeholder="<?php echo esc_attr( isset( $field['placeholder'] ) ? $field['placeholder'] : '' ); ?>"
        <?php echo ! empty( $field['multiple'] ) ? 'multiple="multiple"' : ''; ?> >

        <?php if ( ! empty( $field['options'] ) && is_array( $field['options'] ) ) : ?>
            <?php foreach ( $field['options'] as $option_key => $option_label ) : ?>
                <option 
                    value="<?php echo esc_attr( $option_key ); ?>" 
                    <?php if ( is_array( $field_Val ) ) :
                        selected( in_array( $option_key, $field_Val ), true );
                    else :
                        selected( $field_Val, $option_key );
                    endif; ?> >
                    <?php echo esc_html( $option_label ); ?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
    
    <p><?php echo isset( $field['desc'] ) ? wp_kses_post( $field['desc'] ) : ''; ?></p>
</td>
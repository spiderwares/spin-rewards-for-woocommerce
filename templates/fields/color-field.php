<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Color picker field HTML
 */
?>
<td>
    <input 
        name="<?php echo isset( $field['name'] ) ? esc_attr( $field['name'] ) : ''; ?>" 
        id="<?php echo esc_attr( $field_Key ); ?>" 
        type="text" 
        class="wp-color-picker" 
        value="<?php echo esc_attr( $field_Val ); ?>" 
        placeholder="<?php echo isset( $field['placeholder'] ) ? esc_attr( $field['placeholder'] ) : ''; ?>" 
        data-default-color="<?php echo esc_attr( isset( $field['default'] ) ? $field['default'] : '#ffffff' ); ?>"
    />

    <br/>
    <p><?php echo isset( $field['desc'] ) ? wp_kses_post( $field['desc'] ) : ''; ?></p>
</td>

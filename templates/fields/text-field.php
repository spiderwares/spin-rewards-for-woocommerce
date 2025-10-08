<?php
/**
 *  Text Field Template
 */
// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<td>
    <div class="srwc-text-field">
        <input type="text" 
               id="<?php echo esc_attr( $field_Key ); ?>" 
               name="<?php echo isset( $field['name'] ) ? esc_attr( $field['name'] ) : ''; ?>" 
               value="<?php echo esc_attr( $field_Val ); ?>" 
               placeholder="<?php echo isset( $field['placeholder'] ) ? esc_attr( $field['placeholder'] ) : ''; ?>" />
    </div>
    <p><?php echo isset( $field['desc'] ) ? wp_kses_post( $field['desc'] ) : ''; ?></p>
</td>
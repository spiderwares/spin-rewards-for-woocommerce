<?php
/**
 *  Number Field Template
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<?php
/**
 * Number Field Template
 */

defined( 'ABSPATH' ) || exit;
?>

<td>
    <div class="srwc-number-field">
        <input type="number" 
               id="<?php echo esc_attr( $field_Key ); ?>" 
               name="<?php echo isset( $field['name'] ) ? esc_attr( $field['name'] ) : ''; ?>" 
               value="<?php echo esc_attr( $field_Val ); ?>" 
               min="<?php echo isset( $field['min'] ) ? esc_attr( $field['min'] ) : '0'; ?>" 
               max="<?php echo isset( $field['max'] ) ? esc_attr( $field['max'] ) : ''; ?>" 
               step="<?php echo isset( $field['step'] ) ? esc_attr( $field['step'] ) : '1'; ?>" />

        <?php if ( isset( $field['unit'] ) && is_array( $field['unit'] ) ) : ?>
            <?php if ( isset( $field['unit_disabled'] ) && $field['unit_disabled'] ) : ?>
                <span class="srwc-unit-text">
                    <?php echo esc_html( $field['unit'][ $field['unit_selected'] ] ); ?>
                </span>
            <?php else : ?>
                <?php
                // load saved options for unit
                $options = get_option( 'srwc_settings', array() );
                $selected_unit = isset( $options[ $field_Key . '_unit' ] ) ? $options[ $field_Key . '_unit' ] : $field['unit_selected'];
                ?>
                <select name="srwc_settings[<?php echo esc_attr( $field_Key . '_unit' ); ?>]">
                    <?php foreach ( $field['unit'] as $key => $label ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $selected_unit, $key ); ?>>
                            <?php echo esc_html( $label ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    
    <p><?php echo isset( $field['desc'] ) ? wp_kses_post( $field['desc'] ) : ''; ?></p>
</td>


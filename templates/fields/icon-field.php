<?php
/**
 * Icon Field Template
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<td>
    <div class="srwc-icon-field">
        <div class="srwc-icon-grid">
            <?php 
            $icons = $field['icons'];
            if ( is_array( $icons ) && !empty( $icons ) ) :
                foreach( $icons as $icon_name ) : 
                    $display_name = str_replace( '-', ' ', $icon_name );
                    $display_name = ucwords( $display_name );
            ?>
                <div class="srwc-icon-option <?php echo ( $field_Val == $icon_name ) ? 'selected' : ''; ?>" data-value="<?php echo esc_attr( $icon_name ); ?>">
                    <div class="srwc-icon-display">
                        <i class="srwc-icon srwc-<?php echo esc_attr($icon_name); ?>"></i>
                        <span class="srwc-icon-name"><?php echo esc_html( $display_name ); ?></span>
                    </div>
                </div>
            <?php 
                endforeach; 
            else:
                echo '<p style="color: red;">No icons available or icons array is empty.</p>';
            endif;
            ?>
        </div>
        <input type="hidden" 
               id="<?php echo esc_attr( $field_Key ); ?>" 
               name="<?php echo isset( $field['name'] ) ? esc_attr( $field['name'] ) : ''; ?>" 
               value="<?php echo esc_attr( $field_Val ); ?>" />
    </div>
    <p><?php echo isset( $field['desc'] ) ? wp_kses_post( $field['desc'] ) : ''; ?></p>
</td>
<?php
/**
 *  Media Field Template
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<td>
    <div class="srwc-media" data-field-key="<?php echo esc_attr($field_Key); ?>">
        <input type="hidden" 
               class="srwc-media-url" 
               id="<?php echo esc_attr($field_Key); ?>" 
               name="<?php echo esc_attr($field['name']); ?>" 
               value="<?php echo esc_attr($field_Val); ?>" 
               readonly />

        <div class="srwc-media-preview" data-img-style="width: 10rem;">
            <?php if ( ! empty($field_Val)) : ?>
                <img class="srwc-media-img" src="<?php echo esc_url($field_Val); ?>" alt="Preview" />
            <?php endif; ?>
        </div>

        <div class="srwc-media-buttons">
            <span type="button" class="button srwc-media-upload">
                <?php esc_html_e('Add Image', 'spin-rewards-for-woocommerce'); ?>
            </span>
            <span type="button" class="button srwc-media-remove"<?php echo empty($field_Val) ? ' style="display:none;"' : ''; ?>>
                <?php esc_html_e('Remove', 'spin-rewards-for-woocommerce'); ?>
            </span>
        </div>
    </div>
    <p><?php echo isset( $field['desc'] ) ? wp_kses_post( $field['desc'] ) : ''; ?></p>
</td>
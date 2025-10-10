<?php
/**
 * Spin Wheel Slides Field Template
 */

// Prevent direct access to the file.
defined( 'ABSPATH' ) || exit;
?>

<td colspan="2">
    <table class="srwc-slides-table">
        <thead>
            <tr>
                <th class="srwc-index"><?php esc_html_e( 'Index', 'spin-rewards-for-woocommerce' ); ?></th>
                <th class="srwc-coupon-type"><?php esc_html_e( 'Coupon Type', 'spin-rewards-for-woocommerce' ); ?></th>
                <th class="srwc-label"><?php esc_html_e( 'Label', 'spin-rewards-for-woocommerce' ); ?></th>
                <th class="srwc-value"><?php esc_html_e( 'Value', 'spin-rewards-for-woocommerce' ); ?></th>
                <th class="srwc-probability"><?php esc_html_e( 'Probability(%)', 'spin-rewards-for-woocommerce' ); ?></th>
                <th class="srwc-color"><?php esc_html_e( 'Color', 'spin-rewards-for-woocommerce' ); ?></th>
                <th><?php esc_html_e( 'Action', 'spin-rewards-for-woocommerce' ); ?></th>
            </tr>
        </thead>
        <tbody class="srwc-repeater-body">
            <tr class="srwc-repeater-template" style="display: none;">
                <td class="srwc-center">
                    <span class="srwc-slide-index">1</span>
                </td>
                <td>
                    <select class="srwc-coupon-type" name="<?php echo esc_attr( $field['name'] ); ?>[coupon_type][]">
                        <option value="none"><?php esc_html_e( 'None', 'spin-rewards-for-woocommerce' ); ?></option>
                        <option value="existing"><?php esc_html_e( 'Existing coupon', 'spin-rewards-for-woocommerce' ); ?></option>
                        <option value="percent"><?php esc_html_e( 'Percentage discount', 'spin-rewards-for-woocommerce' ); ?></option>
                        <option value="fixed_product"><?php esc_html_e( 'Fixed product discount', 'spin-rewards-for-woocommerce' ); ?></option>
                        <option value="fixed_cart"><?php esc_html_e( 'Fixed cart discount', 'spin-rewards-for-woocommerce' ); ?></option>
                        <option value="custom"><?php esc_html_e( 'Custom', 'spin-rewards-for-woocommerce' ); ?></option>
                    </select>
                </td>
                <td>
                    <input type="text" class="srwc-slide-label" name="<?php echo esc_attr( $field['name'] ); ?>[label][]" value="Not Lucky" placeholder="<?php esc_attr_e( 'Enter label', 'spin-rewards-for-woocommerce' ); ?>">
                </td>
                <td>
                    <input type="number" class="srwc-slide-value" name="<?php echo esc_attr( $field['name'] ); ?>[value][]" value="0" min="0" step="1">
                    <select class="srwc-coupon-select srwc-select2" name="<?php echo esc_attr( $field['name'] ); ?>[coupon_code][]" data-placeholder="<?php esc_attr_e( 'Enter Code', 'spin-rewards-for-woocommerce' ); ?>" style="display: none;">
                        <option value=""><?php esc_html_e( 'Enter Code', 'spin-rewards-for-woocommerce' ); ?></option>
                    </select>
                    <input type="text" class="srwc-slide-custom-value" name="<?php echo esc_attr( $field['name'] ); ?>[custom_value][]" value="" placeholder="<?php esc_attr_e( 'Value/Code', 'spin-rewards-for-woocommerce' ); ?>" style="display: none;">
                </td>
                <td>
                    <input type="number" class="srwc-slide-probability" name="<?php echo esc_attr( $field['name'] ); ?>[probability][]" value="17" min="0" max="100" step="1">
                </td>
                <td class="srwc-center">
                    <div class="srwc-color-picker">
                        <input type="text" class="srwc-slide-color wp-color-picker" name="<?php echo esc_attr( $field['name'] ); ?>[color][]" value="#ffe0b2">
                    </div>
                </td>
                <td class="srwc-center">
                    <button class="srwc-remove-repeater-row" title="<?php esc_attr_e( 'Remove row', 'spin-rewards-for-woocommerce' ); ?>"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="28" height="28" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M49 14h-9v-1c0-2.757-2.243-5-5-5h-6c-2.757 0-5 2.243-5 5v1h-9a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h34a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2zm-21-1c0-.551.449-1 1-1h6c.551 0 1 .449 1 1v1h-8zM48.28 23.655A2.001 2.001 0 0 0 46.8 23H17.2a2.001 2.001 0 0 0-1.991 2.191l2.458 25.688c.279 2.92 2.848 5.122 5.976 5.122h16.714c3.127 0 5.697-2.202 5.976-5.122l2.458-25.688a2 2 0 0 0-.511-1.536zM27.326 50.996c-.043.002-.085.004-.128.004a2 2 0 0 1-1.994-1.874l-1.2-19a2.001 2.001 0 0 1 1.87-2.122 2.005 2.005 0 0 1 2.122 1.87l1.2 19a2.001 2.001 0 0 1-1.87 2.122zm11.47-1.87a2 2 0 1 1-3.992-.252l1.2-19a2 2 0 0 1 3.992.252z" fill="#f44336" opacity="1" data-original="#000000" class=""></path></g></svg></button>
                </td>
            </tr>

            <!-- Existing slides -->
            <?php if ( ! empty( $field_Val ) && is_array( $field_Val ) ) : ?>
                <?php foreach ( $field_Val as $index => $slide ) : ?>
                    <tr class="srwc-slide-row">
                        <td class="srwc-center">
                            <span class="srwc-slide-index"><?php echo esc_html( $index + 1 ); ?></span>
                        </td>
                        <td>
                            <select class="srwc-coupon-type" name="<?php echo esc_attr( $field['name'] ); ?>[coupon_type][]">
                                <option value="none" <?php selected( isset( $slide['coupon_type'] ) ? $slide['coupon_type'] : 'none', 'none' ); ?>><?php esc_html_e( 'None', 'spin-rewards-for-woocommerce' ); ?></option>
                                <option value="existing" <?php selected( isset( $slide['coupon_type'] ) ? $slide['coupon_type'] : 'none', 'existing' ); ?>><?php esc_html_e( 'Existing coupon', 'spin-rewards-for-woocommerce' ); ?></option>
                                <option value="percent" <?php selected( isset( $slide['coupon_type'] ) ? $slide['coupon_type'] : 'none', 'percent' ); ?>><?php esc_html_e( 'Percentage discount', 'spin-rewards-for-woocommerce' ); ?></option>
                                <option value="fixed_product" <?php selected( isset( $slide['coupon_type'] ) ? $slide['coupon_type'] : 'none', 'fixed_product' ); ?>><?php esc_html_e( 'Fixed product discount', 'spin-rewards-for-woocommerce' ); ?></option>
                                <option value="fixed_cart" <?php selected( isset( $slide['coupon_type'] ) ? $slide['coupon_type'] : 'none', 'fixed_cart' ); ?>><?php esc_html_e( 'Fixed cart discount', 'spin-rewards-for-woocommerce' ); ?></option>
                                <option value="custom" <?php selected( isset( $slide['coupon_type'] ) ? $slide['coupon_type'] : 'none', 'custom' ); ?>><?php esc_html_e( 'Custom', 'spin-rewards-for-woocommerce' ); ?></option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="srwc-slide-label" name="<?php echo esc_attr( $field['name'] ); ?>[label][]" value="<?php echo esc_attr( isset( $slide['label'] ) ? $slide['label'] : '' ); ?>" placeholder="<?php esc_attr_e( 'Enter label', 'spin-rewards-for-woocommerce' ); ?>">
                        </td>
                        <td>
                            <input type="number" class="srwc-slide-value" name="<?php echo esc_attr( $field['name'] ); ?>[value][]" value="<?php echo esc_attr( isset( $slide['value'] ) ? $slide['value'] : '0' ); ?>" min="0" step="1" style="<?php echo (isset( $slide['coupon_type'] ) && in_array($slide['coupon_type'], ['existing', 'custom'])) ? 'display: none;' : ''; ?>">
                            <select class="srwc-coupon-select srwc-select2" name="<?php echo esc_attr( $field['name'] ); ?>[coupon_code][]" style="<?php echo (isset( $slide['coupon_type'] ) && $slide['coupon_type'] === 'existing') ? '' : 'display: none;'; ?>" data-placeholder="<?php esc_attr_e( 'Enter Code', 'spin-rewards-for-woocommerce' ); ?>">
                                <option value=""><?php esc_html_e( 'Enter Code', 'spin-rewards-for-woocommerce' ); ?></option>
                                <?php if (isset( $slide['coupon_code'] ) && !empty( $slide['coupon_code'] )) : ?>
                                    <option value="<?php echo esc_attr( $slide['coupon_code'] ); ?>" selected><?php echo esc_html( $slide['coupon_code'] ); ?></option>
                                <?php endif; ?>
                            </select>
                            <input type="text" class="srwc-slide-custom-value" name="<?php echo esc_attr( $field['name'] ); ?>[custom_value][]" value="<?php echo esc_attr( isset( $slide['custom_value'] ) ? $slide['custom_value'] : '' ); ?>" placeholder="<?php esc_attr_e( 'Value/Code', 'spin-rewards-for-woocommerce' ); ?>" style="<?php echo (isset( $slide['coupon_type'] ) && $slide['coupon_type'] === 'custom') ? '' : 'display: none;'; ?>">
                        </td>
                        <td>
                            <input type="number" class="srwc-slide-probability" name="<?php echo esc_attr( $field['name'] ); ?>[probability][]" value="<?php echo esc_attr( isset( $slide['probability'] ) ? $slide['probability'] : '17' ); ?>" min="0" max="100" step="1">
                        </td>
                        <td class="srwc-center">
                            <div class="srwc-color-picker">
                                <input type="text" class="srwc-slide-color wp-color-picker" name="<?php echo esc_attr( $field['name'] ); ?>[color][]" value="<?php echo esc_attr( isset( $slide['color'] ) ? $slide['color'] : '#ffe0b2' ); ?>">
                            </div>
                        </td>
                        <td class="srwc-center">
                            <button class="srwc-remove-repeater-row">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="28" height="28" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M49 14h-9v-1c0-2.757-2.243-5-5-5h-6c-2.757 0-5 2.243-5 5v1h-9a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h34a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2zm-21-1c0-.551.449-1 1-1h6c.551 0 1 .449 1 1v1h-8zM48.28 23.655A2.001 2.001 0 0 0 46.8 23H17.2a2.001 2.001 0 0 0-1.991 2.191l2.458 25.688c.279 2.92 2.848 5.122 5.976 5.122h16.714c3.127 0 5.697-2.202 5.976-5.122l2.458-25.688a2 2 0 0 0-.511-1.536zM27.326 50.996c-.043.002-.085.004-.128.004a2 2 0 0 1-1.994-1.874l-1.2-19a2.001 2.001 0 0 1 1.87-2.122 2.005 2.005 0 0 1 2.122 1.87l1.2 19a2.001 2.001 0 0 1-1.87 2.122zm11.47-1.87a2 2 0 1 1-3.992-.252l1.2-19a2 2 0 0 1 3.992.252z" fill="#f44336" opacity="1" data-original="#000000" class=""></path></g></svg>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr class="srwc-slide-footer">
                <td colspan="7">

                    <button class="srwc-add-repeater-row srwc-admin-button">
                        <span><?php esc_html_e( 'Add Slide', 'spin-rewards-for-woocommerce' ); ?></span>
                    </button>

                    <div id="srwc-update-rate-msg" class="srwc-error"></div>
                </td>
            </tr>
        </tfoot>
    </table>
</td>
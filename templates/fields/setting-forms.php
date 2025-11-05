<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<form method="post" action="options.php" enctype="multipart/form-data" class="srwc-settings-form">
    <table class="form-table">
        <tr class="heading">
            <th colspan="2">
                <?php echo esc_html( $title ); ?>
            </th>
        </tr>
        <tr>
        <?php
            wc_get_template(
                'fields/manage-fields.php',
                array(
                    'metaKey' => $metaKey,
                    'fields'  => $fields,
                    'options' => $options,
                ),
                'spin-rewards-for-woocommerce/fields/',
                SRWC_TEMPLATE_PATH
            );
        ?>
        </tr>
        <tr class="submit">
            <th colspan="2">
                <?php settings_fields( $metaKey ); ?>
                <?php submit_button(); ?>
                <?php settings_errors( 'srwc_settings' ); ?>
            </th>
        </tr>
    </table>
</form>
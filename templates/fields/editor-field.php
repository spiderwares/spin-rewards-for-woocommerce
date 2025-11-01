<?php
/**
 * Editor Field Template
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<td>
    <?php
    $editor_id = 'srwc_' . $field_Key;
    $editor_settings = array(
        'textarea_name' => $field['name'],
        'textarea_rows' => 5,
        'media_buttons' => true,
        'tinymce' => array(
            'toolbar1' => 'formatselect,bold,italic,underline,strikethrough,blockquote,bullist,numlist,alignleft,aligncenter,alignright,alignjustify,link,unlink,removeformat,table,forecolor,backcolor,pastetext,spellchecker,fullscreen',
            'toolbar2' => '',
        ),
    );

    wp_editor( $field_Val, $editor_id, $editor_settings );
    ?>
    
    <p class="description"><?php echo isset( $field['desc'] ) ? wp_kses_post( $field['desc'] ) : ''; ?></p>
</td>
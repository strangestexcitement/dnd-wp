<?php
/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */
 
/**
 * custom option and settings
 */
function game_settings_init() {
    // Register a new setting for "game" page.
    register_setting( 'game', 'game_options' );
 
    // Register a new section in the "game" page.
    add_settings_section(
        'game_section_site_info',
        __( 'Site Info', 'game' ), 'game_section_site_info_callback',
        'game'
    );
 
    // Register a new field in the "game_section_site_info" section, inside the "game" page.
    add_settings_field(
        'game_field_attributions', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Attributions', 'game' ),
        'game_field_attributions_cb',
        'game',
        'game_section_site_info',
        array(
            'label_for'         => 'game_field_attributions',
            'class'             => 'game_row',
            'game_custom_data' => 'custom',
        )
    );

    // Register a new field in the "game_section_site_info" section, inside the "game" page.
    add_settings_field(
        'game_field_default_character_image', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Default Character Image', 'game' ),
        'game_field_default_character_image_cb',
        'game',
        'game_section_site_info',
        array(
            'label_for'         => 'game_field_default_character_image',
            'class'             => 'game_row',
            'game_custom_data' => 'custom',
        )
    );

    // Register a new field in the "game_section_site_info" section, inside the "game" page.
    add_settings_field(
        'game_field_default_player_image', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Default Player Image', 'game' ),
        'game_field_default_player_image_cb',
        'game',
        'game_section_site_info',
        array(
            'label_for'         => 'game_field_default_player_image',
            'class'             => 'game_row',
            'game_custom_data' => 'custom',
        )
    );
}
 
/**
 * Register our game_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'game_settings_init' );
 
 
/**
 * Custom option and settings:
 *  - callback functions
 */
 
 
/**
 * Developers section callback function.
 *
 * @param array $args  The settings array, defining title, id, callback.
 */
function game_section_site_info_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Enter information about the site.', 'game' ); ?></p>
    <?php
}
 
/**
 * Attributions field callback function.
 *
 * WordPress has magic interaction with the following keys: label_for, class.
 * - the "label_for" key value is used for the "for" attribute of the <label>.
 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
 * Note: you can add custom key value pairs to be used inside your callbacks.
 *
 * @param array $args
 */
function game_field_attributions_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'game_options' );
    $label = esc_attr( $args['label_for'] );
    $content = $options[$label];
    $name = "game_options[$label]";
    $editor = array(
        'textarea_rows' => 15,
        'tabindex' => 1,
        'id' => $label,
        'media_buttons' => false,
        'textarea_name' => $name,
    );
    wp_editor($content, $label, $editor);
    ?>
    <p class="description">
        <?php esc_html_e( 'Add any additional attributions and/or credits.', 'game' ); ?>
    </p>
    <?php
}

// default images

function game_field_default_character_image_cb( $args ) {
    $options = get_option( 'game_options' );
    $label = esc_attr( $args['label_for'] );
    $content = $options[$label];
    $name = "game_options[$label]";

	wp_enqueue_media();

	?>
        <div class='image-preview-wrapper'>
            <img id='character-image-preview' src='<?php echo wp_get_attachment_url( intval($content)); ?>' height='100'>
        </div>
        <input id="upload_character_image_button" type="button" class="button upload_image_button" value="<?php _e( 'Select image' ); ?>" />
        <input id="reset_character_image_button" type="button" class="button reset_image_to_default_button" value="<?php _e( 'Reset to default' ); ?>" />
        <input type='hidden' name="<?= $name ?>" id='character_image_attachment_id' class='image_attachment_id' value='<?= $content ?>'>
    <?php
}

function game_field_default_player_image_cb( $args ) {
    $options = get_option( 'game_options' );
    $label = esc_attr( $args['label_for'] );
    $content = $options[$label];
    $name = "game_options[$label]";

	wp_enqueue_media();

	?>
        <div class='image-preview-wrapper'>
            <img id='player-image-preview' src='<?php echo wp_get_attachment_url( intval($content)); ?>' height='100'>
        </div>
        <input id="upload_player_image_button" type="button" class="button upload_image_button" value="<?php _e( 'Select image' ); ?>" />
        <input id="reset_player_image_button" type="button" class="button reset_image_to_default_button" value="<?php _e( 'Reset to default' ); ?>" />
        <input type='hidden' name="<?= $name ?>" id='player_image_attachment_id' class='image_attachment_id' value='<?= $content ?>'>
    <?php
}








 
/**
 * Add the top level menu page.
 */
function game_options_page() {
    add_menu_page(
        'Game Options',
        'Game Options',
        'manage_options',
        'game',
        'game_options_page_html'
    );
}
 
 
/**
 * Register our game_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'game_options_page' );
 
 
/**
 * Top level menu callback function
 */
function game_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
 
    // add error/update messages
 
    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'game_messages', 'game_message', __( 'Settings Saved', 'game' ), 'updated' );
    }
 
    // show error/update messages
    settings_errors( 'game_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "game"
            settings_fields( 'game' );
            // output setting sections and their fields
            // (sections are registered for "game", each field is registered to a specific section)
            do_settings_sections( 'game' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}
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
        'game_section_people',
        __( 'People', 'game' ), 'game_section_people_callback',
        'game'
    );
 
    // Register a new field in the "game_section_people" section, inside the "game" page.
    add_settings_field(
        'game_field_dm', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'DM', 'game' ),
        'game_field_dm_cb',
        'game',
        'game_section_people',
        array(
            'label_for'         => 'game_field_dm',
            'class'             => 'game_row',
            'game_custom_data' => 'custom',
        )
    );

    // Register a new field in the "game_section_people" section, inside the "game" page.
    add_settings_field(
      'game_field_players', // As of WP 4.6 this value is used only internally.
                              // Use $args' label_for to populate the id inside the callback.
          __( 'Players', 'game' ),
      'game_field_players_cb',
      'game',
      'game_section_people',
      array(
          'label_for'         => 'game_field_players',
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
function game_section_people_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Enter the people playing the game.', 'game' ); ?></p>
    <?php
}
 
/**
 * Pill field callbakc function.
 *
 * WordPress has magic interaction with the following keys: label_for, class.
 * - the "label_for" key value is used for the "for" attribute of the <label>.
 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
 * Note: you can add custom key value pairs to be used inside your callbacks.
 *
 * @param array $args
 */
function game_field_dm_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'game_options' );
    ?>
    <input type="text" 
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['game_custom_data'] ); ?>"
            name="game_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?php echo esc_attr( $options[$args['label_for']] ); ?>">
    <p class="description">
        <?php esc_html_e( 'Enter the name of the Game/Dungeon Master.', 'game' ); ?>
    </p>
    <?php
}

function game_field_players_cb( $args ) {
  // Get the value of the setting we've registered with register_setting()
  $options = get_option( 'game_options' );
  ?>
  <textarea 
          id="<?php echo esc_attr( $args['label_for'] ); ?>"
          data-custom="<?php echo esc_attr( $args['game_custom_data'] ); ?>"
          name="game_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
<?php echo esc_attr( $options[$args['label_for']] ); ?>
</textarea>
  <p class="description">
      <?php esc_html_e( 'Enter the players.', 'game' ); ?>
  </p>
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
        'game_options',
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
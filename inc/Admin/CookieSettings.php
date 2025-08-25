<?php

class CookieSettings {
    public function register() {
        add_action('admin_init', array($this, 'lion_cookie_custom_settings'));
    }

    public function lion_cookie_custom_settings() {
        // Színbeállítások regisztrálása
        register_setting('lion_cookie_settings_group', 'right_button');
        register_setting('lion_cookie_settings_group', 'right_button_hover');
        register_setting('lion_cookie_settings_group', 'details_button');
        register_setting('lion_cookie_settings_group', 'details_button_hover');
        register_setting('lion_cookie_settings_group', 'popup_image');

        // Színbeállítások szekció
        add_settings_section(
            'lion_cookie_section',
            __('Szín Beállítások', 'lion-cookie'),
            null,
            'lion_cookie_settings'
        );

        // Színválasztók megjelenítése egy kártyán
        add_settings_field(
            'color_settings',
            '',
            array($this, 'color_settings_callback'),
            'lion_cookie_settings',
            'lion_cookie_section'
        );

        // Képfeltöltés szekció
        add_settings_section(
            'lion_cookie_image_section',
            __('Kép Beállítások', 'lion-cookie'),
            null,
            'lion_cookie_settings'
        );

        // Képfeltöltés megjelenítése külön kártyán
        add_settings_field(
            'image_settings',
            '',
            array($this, 'image_settings_callback'),
            'lion_cookie_settings',
            'lion_cookie_image_section'
        );
    }

    // Színválasztók megjelenítése egy kártyán
    public function color_settings_callback() {
        $right_button = esc_attr(get_option('right_button'));
        $right_button_hover = esc_attr(get_option('right_button_hover'));
        $details_button = esc_attr(get_option('details_button'));
        $details_button_hover = esc_attr(get_option('details_button_hover'));

        ?>
        <div class="color-settings-card">
            <label><?php _e('Jobb oldali gombok színe:', 'lion-cookie'); ?></label>
            <input type="text" name="right_button" value="<?php echo $right_button; ?>" class="my-color-field" data-default-color="#effeff" />

            <label><?php _e('Jobb oldali gombok hover színe:', 'lion-cookie'); ?></label>
            <input type="text" name="right_button_hover" value="<?php echo $right_button_hover; ?>" class="my-color-field" data-default-color="#effeff" />

            <label><?php _e('Részletek gomb színe:', 'lion-cookie'); ?></label>
            <input type="text" name="details_button" value="<?php echo $details_button; ?>" class="my-color-field" data-default-color="#effeff" />

            <label><?php _e('Részletek gomb hover színe:', 'lion-cookie'); ?></label>
            <input type="text" name="details_button_hover" value="<?php echo $details_button_hover; ?>" class="my-color-field" data-default-color="#effeff" />
        </div>
        <?php
    }

    // Képfeltöltés megjelenítése külön kártyán
    public function image_settings_callback() {
        $popup_image = esc_attr(get_option('popup_image'));

        ?>
        <div class="image-settings-card">
            <label><?php _e('Popup Kép:', 'lion-cookie'); ?></label>
            <input type="hidden" name="popup_image" id="popup_image" value="<?php echo $popup_image; ?>" />
            <button class="upload_image_button button"><?php _e('Kép kiválasztása', 'lion-cookie'); ?></button>

            <?php if ($popup_image): ?>
                <div class="popup-image-preview">
                    <img src="<?php echo esc_url($popup_image); ?>" alt="<?php _e('Popup Kép Előnézet', 'lion-cookie'); ?>" style="max-width: 150px; margin-top: 10px;" />
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
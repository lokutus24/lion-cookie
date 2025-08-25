<?php

class AdminMenu {

    private $cookieStatistics;

    public function __construct() {
        $this->cookieStatistics = new CookieStatistics();
    }

    public function register() {
        add_action('admin_menu', array($this, 'add_admin_pages'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_admin_pages() {
        add_menu_page(
            'Lion Cookie',
            'Lion Cookie',
            'manage_options',
            'lion_cookie_settings',
            array($this, 'admin_index'),
            'dashicons-admin-customizer',
            20
        );

        add_submenu_page(
            'lion_cookie_settings',
            __('Cookie Statisztikák', 'lion-cookie'),
            __('Statisztikák', 'lion-cookie'),
            'manage_options',
            'lion_cookie_statistics',
            array($this->cookieStatistics, 'display_statistics_page')
        );
    }

    public function admin_index() {
        ?>
        <div class="cookie-admin-container">
            <form method="post" action="options.php">
                <?php
                settings_fields('lion_cookie_settings_group');
                do_settings_sections('lion_cookie_settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function register_settings() {
        register_setting('lion_cookie_settings_group', 'enable_cookie_plugin');

        add_settings_section(
            'lion_cookie_settings_section',
            __('Lion Cookie Beállítások', 'lion-cookie'),
            null,
            'lion_cookie_settings'
        );

        add_settings_field(
            'enable_cookie_plugin',
            '',
            array($this, 'enable_cookie_plugin_html'),
            'lion_cookie_settings',
            'lion_cookie_settings_section'
        );
    }

    public function enable_cookie_plugin_html() {
        $option = get_option('enable_cookie_plugin');
        ?>
        <div class="switch-card">
            <h2><?php _e('Süti Popup Engedélyezése', 'lion-cookie'); ?></h2>
            <label class="switch">
                <input type="checkbox" name="enable_cookie_plugin" value="1" <?php checked(1, $option, true); ?>>
                <span class="slider round"></span>
            </label>
        </div>
        <?php
    }
}
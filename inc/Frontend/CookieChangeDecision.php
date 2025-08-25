<?php

class CookieChangeDecision {

    public function register() {
        add_action('wp_footer', [$this, 'render_cookie_change_icon']);
    }

    public function render_cookie_change_icon() {


        ?>
        <button id="cookie-settings-icon" style="display: none;" aria-label="<?php _e('Cookie settings', 'lion-cookie'); ?>">
            <img src="<?php echo plugin_dir_url(__FILE__) . '../../assets/frontend/img/cookie.jpg'; ?>" alt="Logo" class="cookie-logo">
        </button>
        <?php
    }
}

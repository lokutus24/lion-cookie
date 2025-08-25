<?php

class CookiePopup {
    public function register() {

        if (get_option('enable_cookie_plugin')) {
            add_action('wp_footer', array($this, 'display_popup'));
        }

        add_action('init', array($this, 'start_session'));
        add_action('wp_ajax_handle_cookie_decision', array($this, 'handle_cookie_decision'));
        add_action('wp_ajax_nopriv_handle_cookie_decision', array($this, 'handle_cookie_decision'));
    }

    public function start_session() {
        if (!session_id()) {
            session_start();
        }

        if (isset($_SESSION['cookie_preferences'])) {
            return;
        }

        $_SESSION['cookie_preferences'] = null;
    }

    public function display_popup() {

        // if (isset($_SESSION['cookie_preferences'])) {
        //     return;
        // }

        $popup_image = get_option('popup_image', '');

        ?>
        <div id="cookie-popup" class="cookie-popup">
            <div class="cookie-left">
                <?php if ($popup_image): ?>
                    <img src="<?php echo esc_url($popup_image); ?>" alt="Logo" class="cookie-logo">
                <?php endif; ?>
            </div>

            <div class="cookie-center">
                <p class="site-uses-cookie">
                    <?php _e('Ez az oldal sütiket használ', 'lion-cookie'); ?>
                </p>
                <p class="cookie-use-info">
                    <?php _e('Weboldalunkon „cookie”-kat (továbbiakban „süti”) alkalmazunk. Ezek olyan fájlok, melyek információt tárolnak webes böngészőjében. Ehhez az Ön hozzájárulása szükséges.', 'lion-cookie'); ?>
                </p>
                <p class="cookie-use-info">
                    <?php _e('A „sütiket” az elektronikus hírközlésről szóló 2003. évi C. törvény, az elektronikus kereskedelmi szolgáltatások, az információs társadalommal összefüggő szolgáltatások egyes kérdéseiről szóló 2001. évi CVIII. törvény, valamint az Európai Unió előírásainak megfelelően használjuk. Azon weblapoknak, melyek az Európai Unió országain belül működnek, a „sütik” használatához, és ezeknek a felhasználó számítógépén vagy egyéb eszközén történő tárolásához a felhasználók hozzájárulását kell kérniük.', 'lion-cookie'); ?>
                </p>
                <!-- details-btn → cookie-details-btn -->
                <button id="showDetails" class="cookie-btn cookie-details-btn">
                    <?php _e('Részletek', 'lion-cookie'); ?>
                </button>
            </div>

            <div class="cookie-right">
                <button id="acceptAll" class="cookie-btn accept-btn">
                    <?php _e('Összes engedélyezése', 'lion-cookie'); ?>
                </button>
                <button id="rejectAll" class="cookie-btn reject-btn">
                    <?php _e('Elutasít', 'lion-cookie'); ?>
                </button>
            </div>
        </div>
        <?php
    }

    public function handle_cookie_decision() {
        if (!isset($_POST['preferences'])) {
            wp_send_json_error('No preferences provided.');
        }

        $preferences = json_decode(stripslashes($_POST['preferences']), true);

        if (!is_array($preferences)) {
            wp_send_json_error('Invalid preferences format.');
        }

        $_SESSION['cookie_preferences'] = $preferences;

        if (isset($_SESSION['cookie_preferences'])) {
            $unique_id = session_id();
            $option_name = 'lion_cookie_stat_' . $unique_id;

            update_option($option_name, json_encode($preferences));
        }

        wp_send_json_success('Preferences saved.');
    }
}

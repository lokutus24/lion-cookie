<?php

class CookieDetails
{
    public function register() {
        if (get_option('enable_cookie_plugin')) {
            add_action('wp_footer', array($this, 'display_cookie_details'));
        }
    }

    public function display_cookie_details() {

        $popup_image = get_option('popup_image', '');

        // Ha a 'user_accepted_cookies' süti létezik, dekódoljuk:
        $cookie_preferences = json_decode(stripslashes($_COOKIE['user_accepted_cookies'] ?? '{}'), true);

        // Ha a preferences-ben benne van a 'statistics' vagy 'marketing' engedélyezés, ezek alapján jelöljük be a checkboxokat
        $statistics_checked = isset($cookie_preferences['statistics']) && $cookie_preferences['statistics'] ? 'checked' : '';
        $marketing_checked  = isset($cookie_preferences['marketing'])  && $cookie_preferences['marketing']  ? 'checked' : '';

        ?>
        <!-- Popup konténer -->
        <div id="cookie-details-popup" class="cookie-details-popup hidden" data-cookies="">
        
            <button id="closeDetailsPopupX" class="close-details-btn">×</button>
            <!-- A belső tartalom konténere -->
            <div class="cookie-details-popup-content">
                
                <!-- Logó (ha van beállítva) -->
                <?php if ($popup_image): ?>
                    <img src="<?php echo esc_url($popup_image); ?>" alt="Logo" class="cookie-logo-details">
                <?php endif; ?>

                <div class="cookie-category-container">

                    <!-- Szükséges sütik -->
                    <div class="cookie-category">
                        <button class="cookie-accordion" data-panel-id="necessary-cookies">
                            <?php _e('Szükséges sütik', 'lion-cookie'); ?>
                        </button>
                        <div class="cookie-panel" id="necessary-cookies">
                            <div class="cookie-row">
                                <p class="cookie-description">
                                    <?php _e('A szükséges sütik alapvető funkciók, például az oldal navigációja és a weboldal biztonságos területeihez való hozzáférés engedélyezésével segítenek a weboldal használhatóvá tételében. Ezek a sütik nélkül a weboldal nem működhet megfelelően.', 'lion-cookie'); ?>
                                </p>
                                <label class="cookie-switch">
                                    <input type="checkbox" id="toggle-necessary" disabled checked>
                                    <span class="cookie-slider round"></span>
                                </label>
                            </div>
                            <div class="cookie-list">
                                <!-- Itt tudod felsorolni, milyen konkrét sütik tartoznak ide -->
                            </div>
                        </div>
                    </div>

                    <!-- Statisztikai sütik -->
                    <div class="cookie-category">
                        <button class="cookie-accordion" data-panel-id="statistics-cookies">
                            <?php _e('Statisztikai sütik', 'lion-cookie'); ?>
                        </button>
                        <div class="cookie-panel" id="statistics-cookies">
                            <div class="cookie-row">
                                <p class="cookie-description">
                                    <?php _e('A statisztikai sütik segítenek a weboldal tulajdonosainak megérteni, hogyan lépnek kapcsolatba a látogatók a weboldalakkal azáltal, hogy anonim módon gyűjtik és jelentik az információkat.', 'lion-cookie'); ?>
                                </p>
                                <label class="cookie-switch">
                                    <input type="checkbox" id="toggle-statistics" <?php echo $statistics_checked; ?>>
                                    <span class="cookie-slider round"></span>
                                </label>
                            </div>
                            <div class="cookie-list">
                                <!-- Sütik listája -->
                            </div>
                        </div>
                    </div>

                    <!-- Marketing sütik -->
                    <div class="cookie-category">
                        <button class="cookie-accordion" data-panel-id="marketing-cookies">
                            <?php _e('Marketing sütik', 'lion-cookie'); ?>
                        </button>
                        <div class="cookie-panel" id="marketing-cookies">
                            <div class="cookie-row">
                                <p class="cookie-description">
                                    <?php _e('A marketing sütik a látogatók nyomon követésére szolgálnak különböző weboldalakon. Céljuk olyan hirdetések megjelenítése, amelyek relevánsak és érdekesek az egyes felhasználók számára, így értékesebbek a kiadók és harmadik fél hirdetők számára.', 'lion-cookie'); ?>
                                </p>
                                <label class="cookie-switch">
                                    <input type="checkbox" id="toggle-marketing" <?php echo $marketing_checked; ?>>
                                    <span class="cookie-slider round"></span>
                                </label>
                            </div>
                            <div class="cookie-list">
                                <!-- Sütik listája -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Láb -->
                <div class="cookie-details-popup-footer">
                    <button id="saveSettings" class="cookie-btn">
                        <?php _e('Kiválasztottak engedélyezése', 'lion-cookie'); ?>
                    </button>
                    <button id="closeDetailsPopup" class="cookie-btn reject-btn">
                        <?php _e('Vissza', 'lion-cookie'); ?>
                    </button>
                </div>

            </div>
        </div>
        <?php
    }
}
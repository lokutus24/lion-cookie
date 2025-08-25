<?php

class CookieDescriptions
{
    public static function get_descriptions() {
        return [
            // Szükséges sütik
            'wp_test_cookie' => __('A WordPress által használt teszt süti annak ellenőrzésére, hogy a böngésző engedélyezi-e a sütiket.', 'lion-cookie'),
            'wordpress_logged_in' => __('A WordPress ezt a sütit használja a bejelentkezett felhasználók azonosítására, és a bejelentkezett állapot fenntartására.', 'lion-cookie'),
            'wp-settings-' => __('Ez a WordPress süti a felhasználó admin felületének és dashboardjának testreszabott megjelenését tárolja.', 'lion-cookie'),
            'wp-settings-time-' => __('Ez a WordPress süti a beállítások időbélyegét tárolja, és segít a felhasználói testreszabás fenntartásában.', 'lion-cookie'),
            'woocommerce_cart_hash' => __('A WooCommerce ezt a sütit használja annak megállapítására, hogy a vásárlói kosár módosult-e.', 'lion-cookie'),
            'woocommerce_items_in_cart' => __('A WooCommerce használja a kosárban lévő tételek nyomon követésére.', 'lion-cookie'),
            'wp_woocommerce_session_' => __('A WooCommerce használja a felhasználói munkamenet azonosítására és a kosár adatok megőrzésére a böngészés során.', 'lion-cookie'),
            'wordpress_test_cookie' => __('A WordPress által használt teszt süti annak ellenőrzésére, hogy a böngésző engedélyezi-e a sütiket.'),
            'wp_lang' => __('A WordPress ezt a sütit a felhasználó által kiválasztott nyelvi beállítás tárolására használja.'),
            'wp-settings-1' => __('A WordPress ezt a sütit a felhasználói beállítások mentésére használja az adminisztrációs felület és az irányítópult személyre szabásához.'),
            'wp-settings-time-1' => __('A WordPress ezt a sütit a beállítások időbélyegének tárolására használja, hogy megőrizze a felhasználó személyre szabott beállításait.'),
            'PHPSESSID' => __('A PHPSESSID egy alapértelmezett süti, amit a PHP használ a felhasználói munkamenetek (sessionök) azonosítására és kezelésére a szerver és a kliens között.'),

            // Statisztikai sütik
            '_ga' => __('A Google Analytics által használt süti a felhasználók megkülönböztetésére szolgál.', 'lion-cookie'),
            '_gid' => __('A Google Analytics által használt süti a felhasználók megkülönböztetésére, naponta frissítve.', 'lion-cookie'),
            '_gat' => __('A Google Analytics által használt süti a lekérdezési arány csökkentésére.', 'lion-cookie'),
            '__utma' => __('Ez a Google Analytics süti a felhasználók és munkamenetek megkülönböztetésére szolgál.', 'lion-cookie'),
            '__utmb' => __('A Google Analytics ezt a sütit használja új munkamenetek/megtekintések meghatározására.', 'lion-cookie'),
            '__utmc' => __('Ez a Google Analytics által használt süti a régebbi böngészési munkamenetek kezelésére szolgál.', 'lion-cookie'),
            '__utmz' => __('A Google Analytics ezen sütije nyomon követi a forgalmi forrásokat és navigációs útvonalakat.', 'lion-cookie'),
            '_gat_gtag_UA_' => __('A Google Analytics által használt süti egy speciális Google Analytics mérés azonosítójához kapcsolódóan.', 'lion-cookie'),
            '_gads' => __('Google Ads szolgáltatáshoz tartozó süti a hirdetések megjelenítésére és teljesítménymérésére szolgál.', 'lion-cookie'),
            '_gac_' => __('Google Ads süti, amely a kampányok hatékonyságát követi nyomon.', 'lion-cookie'),
            '_hj' => __('A Hotjar által használt süti, amely a látogatók viselkedésének követésére szolgál.', 'lion-cookie'),
            '_hjTLDTest' => __('Hotjar süti, amely a legmagasabb szintű tartomány azonosítására szolgál a követéshez.', 'lion-cookie'),

            // Marketing sütik
            '_fbp' => __('A Facebook Pixel által használt süti a hirdetések célzására és a felhasználói viselkedés követésére.', 'lion-cookie'),
            '_fbc' => __('A Facebook Pixel által használt süti, amely rögzíti a hirdetési kattintásokat.', 'lion-cookie'),
            '_gcl_au' => __('Google AdSense süti, amely a hirdetések hatékonyságát méri.', 'lion-cookie'),
            'IDE' => __('A Google DoubleClick hirdetési platform által használt süti, amely a hirdetések teljesítményének nyomon követésére szolgál.', 'lion-cookie'),
            'DSID' => __('A Google DoubleClick által használt süti a hirdetések személyre szabására több eszközön.', 'lion-cookie'),
            'fr' => __('A Facebook által használt süti a felhasználók azonosítására és a hirdetések hatékonyságának nyomon követésére.', 'lion-cookie'),
            'personalization_id' => __('A Twitter által használt süti a hirdetések személyre szabására.', 'lion-cookie'),
            '_tt_' => __('A TikTok által használt süti a felhasználói viselkedés követésére.', 'lion-cookie'),
            'MUID' => __('A Microsoft által használt süti a felhasználók azonosítására a különböző Microsoft szolgáltatásokban.', 'lion-cookie'),
            'cto_' => __('A Criteo hirdetési szolgáltatás süti a hirdetések célzására.', 'lion-cookie'),
            'li_fat_id' => __('A LinkedIn által használt süti a felhasználók viselkedésének nyomon követésére a LinkedIn hirdetésekhez.', 'lion-cookie'),
            'bcookie' => __('A LinkedIn által használt süti a böngészők azonosítására és a biztonság növelésére.', 'lion-cookie'),
            'lidc' => __('A LinkedIn által használt süti a hirdetések teljesítményének nyomon követésére.', 'lion-cookie'),
            'guest_id' => __('A Twitter által használt süti a nem bejelentkezett felhasználók azonosítására.', 'lion-cookie'),
            'uid' => __('A felhasználók egyedi azonosítására szolgáló süti a különböző hirdetési hálózatok által.', 'lion-cookie'),
            'C' => __('A HubSpot által használt süti a marketingkampányok követésére.', 'lion-cookie'),
            'cid' => __('A felhasználók egyedi azonosítására szolgáló süti a hirdetési hálózatok által.', 'lion-cookie'),
            'sbjs_migrations' => __('Információt tárol a sütik migrációjáról vagy verziófrissítéséről az eszközön.' , 'lion-cookie'),
            'sbjs_current_add' => __('Tárolja a látogató aktuális interakcióival kapcsolatos adatokat, például az aktuális érkezési forrást vagy kampányinformációkat.' , 'lion-cookie'),
            'sbjs_first_add' => __('A látogató első interakciójának adatait tartalmazza, például az első érkezési forrást vagy a látogatás időpontját.' , 'lion-cookie'),
            'sbjs_current' => __('Részletes adatokat tárol az aktuális látogatásról, például forrásokat, közvetítőket, kampányokat és más marketinginformációkat.' , 'lion-cookie'),
            'sbjs_first' => __('A látogató első látogatásának részleteit tárolja, hasonlóan az aktuális látogatási adatokhoz, de a legelső érkezés alapján.' , 'lion-cookie'),
            'sbjs_udata' => __('Információkat tartalmaz a látogató böngészőjéről és eszközéről, például az IP-címről és az operációs rendszerről.' , 'lion-cookie'),
            'sbjs_session' => __('Nyomon követi a látogatások számát és az aktuális oldallátogatás URL-jét a munkamenet során.' , 'lion-cookie'),
        ];
    }
}
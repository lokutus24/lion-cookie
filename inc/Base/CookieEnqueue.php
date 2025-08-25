<?php

class CookieEnqueue
{
    public function register() {
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdmin']);
        add_action('wp_footer', [$this, 'enqueueFrontend']);
    }

    public function enqueueAdmin() {
        wp_enqueue_style('cookie-admin', plugin_dir_url(__FILE__) . '../../assets/admin/css/cookie-admin.css');
        wp_enqueue_script('cookie-admin-js', plugin_dir_url(__FILE__) . '../../assets/admin/js/cookie-admin.js');

        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_media();
    }

    public function enqueueFrontend() {
        if (get_option('enable_cookie_plugin')) {
            wp_enqueue_style('cookie-frontend', plugin_dir_url(__FILE__) . '../../assets/frontend/css/cookie-frontend.css');

            // Sorrend biztosítása
            wp_enqueue_script(
                'cookie-details-js',
                plugin_dir_url(__FILE__) . '../../assets/frontend/js/cookie-details.js',
                array(), // Nincs előfeltétel
                false,
                true
            );

            wp_localize_script('cookie-details-js', 'cookieDescriptions', [
                'descriptions' => CookieDescriptions::get_descriptions(),
                'valueLabel' => __('Érték:', 'lion-cookie'),
            ]);

            wp_enqueue_script(
                'cookie-popup-js',
                plugin_dir_url(__FILE__) . '../../assets/frontend/js/cookie-popup.js',
                array('cookie-details-js'), // `cookie-details.js` betöltés után fut
                false,
                true
            );

            wp_localize_script('cookie-popup-js', 'ajaxObject', [
                'ajax_url' => admin_url('admin-ajax.php'),
            ]);

            wp_enqueue_script(
                'cookie-change-decision',
                plugin_dir_url(__FILE__) . '../../assets/frontend/js/cookie-change-decision.js',
                array('cookie-details-js', 'cookie-popup-js'), // Mindkettő után fut
                false,
                true
            );
        }
    }
}

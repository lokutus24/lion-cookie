<?php

class TrackingCodeManagerBlocker
{
    public function register()
    {
        add_action('init', [$this, 'maybe_block'], 0);
    }

    public function maybe_block()
    {
        if (is_admin()) {
            return;
        }

        // Get consent cookie
        $prefs = isset($_COOKIE['user_accepted_cookies']) ? json_decode(stripslashes($_COOKIE['user_accepted_cookies']), true) : [];

        $marketing = $prefs['marketing'] ?? false;
        $statistics = $prefs['statistics'] ?? false;

        if (!$marketing && !$statistics) {
            if (function_exists('tcmp_head')) {
                $priority = get_option('TCM_HookPriority', defined('TCMP_HOOK_PRIORITY_DEFAULT') ? TCMP_HOOK_PRIORITY_DEFAULT : 10);
                remove_filter('wp_head', 'tcmp_head', $priority);
                remove_action('wp_body_open', 'tcmp_body', $priority);
                remove_action('wp_footer', 'tcmp_footer', $priority);
            }
        }
    }
}

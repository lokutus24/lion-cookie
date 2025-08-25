<?php

class CookieDeactivate {
    public static function deactivate(): void
    {
        flush_rewrite_rules();
    }

    public function register() {
        register_deactivation_hook(__FILE__, [ $this, 'deactivate' ]);
    }
}
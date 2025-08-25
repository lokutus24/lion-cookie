<?php

class CookieActivate {
    public static function activate(): void
    {
        flush_rewrite_rules();
    }

    public function register() {
        register_activation_hook(__FILE__, [ $this, 'activate' ]);
    }
}
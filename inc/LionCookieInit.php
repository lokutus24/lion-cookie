<?php

spl_autoload_register(function ($class_name) {
    $root = plugin_dir_path(__FILE__);

    $classes = [
        'CookieUpdater' => 'Base/CookieUpdater.php',
        'CookieActivate' => 'Base/CookieActivate.php',
        'CookieDeactivate' => 'Base/CookieDeactivate.php',
        'CookieEnqueue' => 'Base/CookieEnqueue.php',
        'TrackingCodeManagerBlocker' => 'Base/TrackingCodeManagerBlocker.php',
        
        'AdminMenu' => 'Admin/AdminMenu.php',
        'CookieSettings' => 'Admin/CookieSettings.php',
        'CookieStatistics' => 'Admin/CookieStatistics.php',

        'CookiePopupStyles' => 'Frontend/CookiePopupStyles.php',
        'CookiePopup' => 'Frontend/CookiePopup.php',
        'CookieDetails' => 'Frontend/CookieDetails.php',
        'CookieDescriptions' => 'Frontend/CookieDescriptions.php',
        'CookieChangeDecision' => 'Frontend/CookieChangeDecision.php',
    ];

    if (isset($classes[$class_name])) {
        require_once $root . $classes[$class_name];
    }
});

final class LionCookieInit {
    public static function get_services(): array {
        return [
            CookieActivate::class,
            CookieDeactivate::class,
            CookieEnqueue::class,
            AdminMenu::class,
            CookieSettings::class,
            CookiePopupStyles::class,
            CookiePopup::class,
            CookieDetails::class,
            CookieDescriptions::class,
            CookieStatistics::class,
            CookieChangeDecision::class,
            TrackingCodeManagerBlocker::class,
            CookieUpdater::class,
        ];
    }

    public static function register_services(): void {
        foreach (self::get_services() as $class) {
            $service = self::instantiate($class);
            if (method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    private static function instantiate($class) {
        return new $class();
    }
}

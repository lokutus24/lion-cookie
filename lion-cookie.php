<?php
/*
Plugin Name: Lion Cookie
Plugin URI: https://lionstack.hu
Description: Cookie plugin - Lion Stack.
Version: 1.3
Author: Lion Stack
Author URI: https://lionstack.hu
*/

defined('ABSPATH') or die('No script kiddies please!');

if (!defined('COOKIE_VERSION')) {
    define('COOKIE_VERSION', 'v0.1.2');
}

require_once plugin_dir_path(__FILE__) . 'inc/LionCookieInit.php';

if (class_exists('LionCookieInit')) {
    LionCookieInit::register_services();
}

function lion_cookie_load_textdomain() {
    load_plugin_textdomain('lion-cookie', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'lion_cookie_load_textdomain');



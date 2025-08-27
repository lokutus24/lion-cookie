<?php
/**
 * Plugin update checker for GitHub releases.
 */
namespace Inc\Base;

class CookieUpdater
{
    public function registerFunction()
    {
        add_filter('pre_set_site_transient_update_plugins', array($this, 'check_update'));
    }

    public function check_update($transient)
    {
        if (empty($transient->checked)) {
            return $transient;
        }

        $plugin_slug = $this->pluginName;
        $current_version = defined('COOKIE_VERSION') ? COOKIE_VERSION : null;

        if (!$current_version) {
            return $transient;
        }

        https://github.com/lokutus24/lion-cookie

        $response = wp_remote_get('https://api.github.com/repos/lokutus24/lion-cookie/releases/latest');

        if (!is_wp_error($response) && isset($response['response']['code']) && $response['response']['code'] == 200) {
            $data = json_decode(wp_remote_retrieve_body($response));

            if (isset($data->tag_name) && version_compare($current_version, $data->tag_name, '<')) {

                $package_url = $data->zipball_url;
                if (!empty($data->assets)) {
                    foreach ($data->assets as $asset) {
                        if (
                            isset($asset->name)
                            && strpos($asset->name, 'mib-connector.zip') !== false
                            && isset($asset->browser_download_url)
                        ) {
                            $package_url = $asset->browser_download_url;
                            break;
                        }
                    }
                }

                $transient->response[$plugin_slug] = (object) array(
                    'slug'        => dirname($plugin_slug),
                    'plugin'      => $plugin_slug,
                    'new_version' => $data->tag_name,
                    'url'         => $data->html_url,
                    'package'     => $package_url,
                );
            }
        }

        return $transient;
    }
}

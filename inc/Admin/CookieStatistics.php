<?php

class CookieStatistics {
    public function register() {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_styles_and_scripts'));
    }

    public function enqueue_styles_and_scripts() {
        wp_enqueue_script(
            'chart-js',
            'https://cdn.jsdelivr.net/npm/chart.js',
            array(),
            null,
            true
        );

        wp_enqueue_script(
            'cookie-stats-js',
            plugin_dir_url(__FILE__) . '../../assets/admin/js/cookie-chart.js',
            array('chart-js'),
            null,
            true
        );

        $data = $this->get_statistics_data();
        wp_localize_script('cookie-stats-js', 'cookieStatsData', [
            'totalSessions' => $data['total_sessions'],
            'allAccepted' => $data['all_accepted'],
            'allRejected' => $data['all_rejected'],
            'acceptanceTypes' => [
                'necessaryOnly' => $data['necessary_only'],
                'necessaryMarketing' => $data['necessary_marketing'],
                'necessaryStatistics' => $data['necessary_statistics'],
            ]
        ]);

        wp_localize_script('cookie-stats-js', 'cookieStatsLabels', [
            'allAccepted' => __('Mindent elfogadott', 'lion-cookie'),
            'allRejected' => __('Elutasított', 'lion-cookie'),
            'necessaryOnly' => __('Csak a szükségesek', 'lion-cookie'),
            'necessaryMarketing' => __('Szükségesek és marketing', 'lion-cookie'),
            'necessaryStatistics' => __('Szükségesek és statisztika', 'lion-cookie'),
        ]);
    }

    private function get_statistics_data() {
        global $wpdb;
        $prefix = 'lion_cookie_stat_';

        $results = $wpdb->get_results("SELECT option_value FROM {$wpdb->options} WHERE option_name LIKE '{$prefix}%'");

        $stats = [
            'total_sessions' => 0,
            'all_accepted' => 0,
            'all_rejected' => 0,
            'necessary_only' => 0,
            'necessary_marketing' => 0,
            'necessary_statistics' => 0
        ];

        foreach ($results as $row) {
            $preferences = json_decode($row->option_value, true);

            if (!$preferences || !isset($preferences['necessary'])) {
                continue;
            }

            $stats['total_sessions']++;

            if ($preferences['necessary'] && $preferences['statistics'] && $preferences['marketing']) {
                $stats['all_accepted']++;
            } elseif (!$preferences['necessary'] && !$preferences['statistics'] && !$preferences['marketing']) {
                $stats['all_rejected']++;
            } elseif ($preferences['necessary'] && !$preferences['statistics'] && !$preferences['marketing']) {
                $stats['necessary_only']++;
            } elseif ($preferences['necessary'] && !$preferences['statistics'] && $preferences['marketing']) {
                $stats['necessary_marketing']++;
            } elseif ($preferences['necessary'] && $preferences['statistics'] && !$preferences['marketing']) {
                $stats['necessary_statistics']++;
            }
        }

        return $stats;
    }

    public function display_statistics_page() {
        $data = $this->get_statistics_data();

        $total_sessions = $data['total_sessions'];
        $total_acceptance_rate = $total_sessions ? round(($data['all_accepted'] / $total_sessions) * 100, 2) : 0;

        $acceptance_count = $data['all_accepted'] +
            $data['necessary_marketing'] +
            $data['necessary_statistics'];

        $acceptance_rate = $total_sessions ? round(($acceptance_count / $total_sessions) * 100, 2) : 0;

        ?>
        <div class="cookie-stats-container">
            <div class="cookie-stat-card">
                <h3><?php _e('Cookie Döntések Statisztikái', 'lion-cookie'); ?></h3>
                <div class="cookie-stat-data-grid">
                    <div class="stat-item">
                        <span class="stat-title"><?php _e('Összes Munkamenet', 'lion-cookie'); ?>:</span>
                        <span class="stat-value"><?php echo $total_sessions; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-title"><?php _e('Mindent elfogadott', 'lion-cookie'); ?>:</span>
                        <span class="stat-value accepted"><?php echo $data['all_accepted']; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-title"><?php _e('Elutasított (csak a szükségeseket fogadta el)', 'lion-cookie'); ?>:</span>
                        <span class="stat-value rejected"><?php echo $data['necessary_only']; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-title"><?php _e('Szükségesek és marketing elfogadva', 'lion-cookie'); ?>:</span>
                        <span class="stat-value marketing"><?php echo $data['necessary_marketing']; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-title"><?php _e('Szükségesek és statisztika elfogadva', 'lion-cookie'); ?>:</span>
                        <span class="stat-value statistics"><?php echo $data['necessary_statistics']; ?></span>
                    </div>
                    <br>
                    <div class="stat-item percentage-stat-item">
                        <span class="stat-title"><?php _e('Teljes elfogadási arány', 'lion-cookie'); ?>:</span>
                        <span class="stat-value rate"><?php echo $total_acceptance_rate . '%'; ?></span>
                    </div>
                    <br>
                    <div class="stat-item">
                        <span class="stat-title"><?php _e('Részleges elfogadási arány', 'lion-cookie'); ?>:</span>
                        <span class="stat-value rate"><?php echo $acceptance_rate . '%'; ?></span>
                    </div>
                </div>
            </div>
            <div class="charts-container">
                <div class="chart-container cookie-stat-card first-chart">
                    <canvas id="cookieChartAcceptanceRates"></canvas>
                    <div id="legendAcceptanceRates" class="chart-legend"></div>
                    <p class="chart-label"><?php _e('Elfogadási és elutasítási Arányok', 'lion-cookie'); ?></p>
                </div>

                <div class="chart-container cookie-stat-card">
                    <canvas id="cookieChartAcceptanceTypes"></canvas>
                    <div id="legendAcceptanceTypes" class="chart-legend"></div>
                    <p class="chart-label"><?php _e('Elfogadási Típusok', 'lion-cookie'); ?></p>
                </div>
            </div>
        </div>
        <?php
    }
}
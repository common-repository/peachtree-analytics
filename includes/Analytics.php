<?php

declare(strict_types=1);

namespace Peachtree;

use RuntimeException;

/**
 * @since      v0.1
 * @author     Peachtree LLC <info@getpeachtree.com>
 */
final class Analytics
{
    /**
     * The current version of the plugin.
     *
     * @since    v0.1
     * @var      string $version The current version of the plugin.
     */
    public const VERSION = 'v2.0.0';

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    v0.1
     */
    public static function run(): void
    {
        static $initialized = false;
        if ($initialized) {
            throw new RuntimeException('Can not re-initialize the Peachtree plugin!');
        }
        $initialized = true;

        add_action('admin_init', static function () {
            /* Register Settings */
            register_setting(
                'general',
                'pt_site_id'
            );

            /* Create settings section */
            add_settings_section(
                'peachtree-settings',
                'Peachtree Settings',
                static function () {
                    echo 'Settings for your Peachtree integration';
                },
                'general'
            );

            /* Create settings field */
            add_settings_field(
                'peachtree-settings-site-id',
                'Peachtree Site ID',
                static function () {
                    ?>
                    <label for="peachtree-settings-site-id">
                        <input id="peachtree-settings-site-id" type="text" value="<?= get_option('pt_site_id'); ?>"
                               name="pt_site_id">
                    </label>
                    <?php
                },
                'general',
                'peachtree-settings'
            );
        });

        add_action('wp_head', static function () {
            if (!$siteId = get_option('pt_site_id')) {
                return;
            }

            $status_code = http_response_code();
            echo <<<HTML
<meta name="peachtree-id" content="{$siteId}">
<script async onload="peachtreeLoaded()" src="https://peachtree.app/js/analytics.js"></script>
<script type="application/javascript">
    function peachtreeLoaded() {
        PeachTree.onEvent((event) => { 
            let metadata = {};
            if (event === 'pageview') {
                metadata['status_code'] = $status_code;
                if (document.referrer) {
                    metadata['referrer'] = document.referrer;
                }
            }
            return metadata;
        });
    }
</script>
HTML;
        });
    }
}

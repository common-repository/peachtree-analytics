<?php

/**
 * @link              https://getpeachtree.com
 * @since             v0.1
 *
 * @wordpress-plugin
 * Plugin Name:       Peachtree Analytics
 * Plugin URI:        https://gitlab.com/peachtree-analytics/wordpress-plugin/-/wikis
 * Description:       Integrates your WordPress installation with Peachtree Analytics
 * Version:           2.0.0
 * Author:            Peachtree LLC
 * Author URI:        https://getpeachtree.com
 * License:           MIT
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// The core plugin class
require_once __DIR__ . '/vendor/autoload.php';

Peachtree\Analytics::run();

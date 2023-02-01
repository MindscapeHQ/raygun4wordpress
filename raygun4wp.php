<?php
/*
Plugin Name: Raygun4WP
Plugin URI: http://github.com/mindscapehq/raygun4wordpress
Description: Exceptional error, performance, user tracking and more with Raygun.com. This service integrates Raygun Crash Reporting which lets you monitor your site's health with beautiful graphs and comprehensive reports, so you are always aware of any points of failure. With Raygun's Real User Monitoring you can monitor the performance of every individual user session, so you can discover and fix fundamental bottlenecks that affect your end user experience. This plugin has a simple one-minute, no-code-required installation.
Version: 2.0.0.0
Author: Mindscape
Author URI: http://raygun.com
License: MIT
*/

require_once sprintf("%s/vendor/autoload.php", dirname(__FILE__));

$multisite_support_enabled = false;

if (version_compare(PHP_VERSION, '7.4', '<')) {
    function rg4wp_warn_php() {
        echo '<div class=\'updated fade\'><p><strong>Raygun4WP:</strong> Your server\'s PHP version is below 7.4. Raygun4WP requires at least this version to run; please update PHP to at least 7.4, or contact your administrator. Raygun4WP version 1.9.3 is recommended for use with older PHP versions (>=5.3.3).</p></div>';
    }
    add_action('admin_notices', 'rg4wp_warn_php');
    return;
} else if (is_multisite() && !$multisite_support_enabled) {
    function rg4wp_warn_multisite() {
        echo '<div class=\'updated fade\'><p><strong>Raygun4WP:</strong> This plugin is not guaranteed to work on multisite installations with certain environments. Please contact <a href="http://raygun.com/about/contact">Raygun</a> for more information.</p></div>';
    }
    add_action('admin_notices', 'rg4wp_warn_multisite');
} else {
    require dirname(__FILE__) . '/main.php';
}

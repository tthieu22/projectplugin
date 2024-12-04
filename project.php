<?php
/**
 * Plugin Name:       Project Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Tran Trong Hieu
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       tthieudev
 * Domain Path:       /languages
 * WC requires at least: 9.3
 * WC tested up to:   9.3.3
 * Requires Plugins:  
 * Tested up to:      6.6.2
 * Requires at least: 6.0
 * Tested up to:      6.6.2
 * Requires PHP:      7.4
 *
 * @package Project
 */


defined( 'ABSPATH' ) || exit;

if ( ! defined('TTHIEUDEV_PLUGIN_FILE' ) ) {
    define( 'TTHIEUDEV_PLUGIN_FILE', __FILE__ );
}

if ( ! class_exists( 'TthieuDev_Project' ) ) {
    require_once __DIR__ . '/includes/class-tthieudev-project.php';
}

$GLOBALS['TthieuDev'] = TthieuDev_Project::instance();

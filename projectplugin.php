<?php
/*
 * Plugin Name:       Project Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Tran Trong Hieu
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       tthieudev
 * Domain Path:       /languages
 */

defined("ABSPATH") or die("You can not access directly");

require(plugin_dir_path( __FILE__ ) . 'includes/tthieudev-core-function.php');

function tthieudev_elmentor(){
    require_once(__DIR__.'/includes/class-tthieudev-elementor.php');
    Tthieudev_Elementor::instance();
}

add_action('plugins_loaded','tthieudev_elmentor');
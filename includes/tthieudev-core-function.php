<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( 'PLUGIN_PATH' ) ) {
    define( 'PLUGIN_PATH', rtrim( plugin_dir_path( dirname( __FILE__ ) ), '/' ) . '/' );
}

array_map(fn($file) => require_once PLUGIN_PATH . 'includes/' . $file, [
    'class-tthieudev-project-custom-post-type.php',
    'class-tthieudev-project-advance-custom-field.php',
    'class-tthieudev-load-assets.php',
    'class-tthieudev-project-template-loader.php',
    'class-tthieudev-template-function.php',
    'class-tthieudev-breadcrumb.php',
    'class-tthieudev-project-setting.php',
    'class-tthieudev-elementor-helper.php',
]);

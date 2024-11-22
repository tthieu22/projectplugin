<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

if ( ! defined( 'PLUGIN_PATH' ) ) {
    // Define the PLUGIN_PATH constant if it's not already defined, pointing to the plugin directory path.
    define( 'PLUGIN_PATH', rtrim( plugin_dir_path( dirname( __FILE__ ) ), '/' ) . '/' );
    // echo PLUGIN_PATH;
}

/**
 * Core Function - Loading essential plugin files.
 * 
 * This section of the code uses the `array_map` function to loop through an array of file names.
 * For each file in the array, it requires the corresponding PHP file from the 'includes' folder 
 * in the plugin directory. This ensures that all the necessary classes and functions for the plugin 
 * are loaded.
 * 
 * The required files include:
 * - Custom Post Type, ACF, Asset Loader, Template Loader, and more, which are essential 
 *   for the core functionality of the plugin.
 */

// Loop through the list of required files and include them from the 'includes' directory.
array_map(fn($file) => require_once PLUGIN_PATH . 'includes/' . $file, [
    // List of core plugin files to be included 
    'class-tthieudev-load-assets.php',        
    'class-tthieudev-scripts-styles-elementor.php',         
    'class-tthieudev-project-custom-post-type.php',        
    'class-tthieudev-project-advance-custom-field.php',      
    'class-tthieudev-project-template-loader.php',   
    'class-tthieudev-template-function.php',               
    'class-tthieudev-breadcrumb.php',                     
    'class-tthieudev-project-setting.php',              
    'class-tthieudev-elementor-helper.php',               
    'class-tthieudev-shortcore-handler.php',          
]);
// shorcode : 
// [project categories="marketing" tags="IT| smart" tags="it" post_per_page="3" columns="3" style="grid" pagination="yes"]
//
//
//
//
//


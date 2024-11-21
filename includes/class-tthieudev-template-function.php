<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * TemplateLoader Class
 * 
 * This class provides functionality to load custom templates for the plugin. It searches for the template files
 * in the theme folder first, and if not found, falls back to the plugin's default template folder.
 * The class includes methods for locating and including templates with optional arguments.
 */

if (!class_exists('TemplateLoader')) {
    class TemplateLoader {

        /**
         * Locate the template file
         * 
         * This method searches for the specified template in the theme folder and falls back to the plugin's
         * default template folder if the template is not found in the theme.
         * 
         * @param string $template_name  The name of the template file to search for.
         * @param string $template_path  The folder path within the theme to search for the template.
         * @param string $default_path   The default path to the plugin's template folder if the template is not found in the theme.
         * 
         * @return string The full path of the located template file.
         */
        public static function locate_template( $template_name = '', $template_path = '', $default_path = '' ) {
            // Set the template path to search in 'projectplugin' folder if not specified.
            if ( ! $template_path ) {
                $template_path = 'projectplugin';
            }

            // Set default plugin templates path if not provided.
            if ( ! $default_path ) {
                $default_path = PLUGIN_PATH . 'templates/'; // Path to the default template folder within the plugin
            }

            // Search for the template file in the theme folder.
            $template = locate_template( $template_path . $template_name );

            // If not found in theme, use the default plugin template path.
            if ( ! $template ) {
                $template = $default_path . $template_name;
            }

            // Allow other functions or plugins to filter the located template.
            return apply_filters( 'template_loader_locate_template', $template, $template_name, $template_path, $default_path );
        }

        /**
         * Get and include the template file
         * 
         * This method includes the template file after locating it. It also allows for passing arguments to the template.
         * The arguments will be extracted and available as variables within the template.
         * 
         * @param string $template_name  The name of the template file to include.
         * @param array  $args           Optional array of arguments to pass to the template.
         * @param string $template_path  The folder path within the theme to search for the template.
         * @param string $default_path   The default path to the plugin's template folder if not found in the theme.
         */
        public static function get_template( $template_name = '', $args = [], $template_path = '', $default_path = '' ) {
            // Extract arguments to make them available as individual variables in the template.
            if ( ! empty( $args ) && is_array( $args ) ) {
                extract( $args );
            }

            // Locate the template file using the locate_template method.
            $template_file = self::locate_template( $template_name, $template_path, $default_path );

            // If the template file does not exist, log an error and exit.
            if ( ! file_exists( $template_file ) ) {
                doing_it_wrong( __FUNCTION__, sprintf( esc_html__( '<code>%s</code> does not exist.', 'TemplateLoader' ), esc_html( $template_file ) ), esc_html( TTHIEUDEV()->version ) );
                return;
            }

            // Include the located template file.
            include $template_file;
        }
    }
}

// Instantiate the TemplateLoader class if it is defined.
if ( class_exists( 'TemplateLoader' ) ) {
    new TemplateLoader();
}

<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly to prevent unauthorized access.
}

/**
 *  Project Loader Template Class
 * 
 * This class is responsible for overriding default WordPress templates with custom plugin templates 
 * for the 'project' custom post type. It ensures that specific templates are loaded for archives, 
 * single posts, and taxonomies associated with the 'project' post type.
 */

if ( ! class_exists( 'Class_Tthieudev_Project_Template_Loader' ) ) {
    class Class_Tthieudev_Project_Template_Loader {

        /**
         * Constructor
         * 
         * Hooks into the `template_include` filter to modify the template loading logic.
         */
        public function __construct() {
            add_filter( 'template_include', array( $this, 'load_project_template' ) );
        }

        /**
         * Load Project Template
         * 
         * Overrides the default template for the 'project' post type with plugin-specific templates 
         * if they exist. This method handles archives, single posts, and taxonomy templates.
         *
         * @param string $template The default template path provided by WordPress.
         * @return string The path to the template to be loaded.
         */
        public function load_project_template( $template ) {
            $plugin_template = ''; // Initialize the plugin template variable.

            // Check if it's an archive page for the 'project' post type.
            if ( is_post_type_archive( 'project' ) ) {
                $plugin_template = TemplateLoader::locate_template( 'pages/archive-project.php' );
            }
            // Check if it's a single post of the 'project' post type.
            elseif ( is_singular( 'project' ) ) {
                $plugin_template = TemplateLoader::locate_template( 'pages/single-project.php' );
            }
            // Check if it's a taxonomy page for 'project_category' or 'project_tag'.
            elseif ( is_tax( 'project_category' ) || is_tax( 'project_tag' ) ) {
                $plugin_template = TemplateLoader::locate_template( 'pages/taxonomy-project_category.php' );
            }

            // If a valid plugin template is found and exists, use it instead of the default.
            if ( $plugin_template && file_exists( $plugin_template ) ) {
                return $plugin_template;
            }

            // Fall back to the default template if no plugin-specific template is found.
            return $template;
        }
    }
}

// Instantiate the class if it exists to enable the functionality.
if ( class_exists( 'Class_Tthieudev_Project_Template_Loader' ) ) {
    new Class_Tthieudev_Project_Template_Loader();
}

<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Widget Manager Class
 * 
 * This class is responsible for managing and registering custom widgets in Elementor. It hooks into
 * the Elementor lifecycle to register widgets and categories during the appropriate actions.
 * It includes methods for both widget registration and custom category registration.
 */

if (!class_exists('Tthieudev_Widget_Manager')) {
    class Tthieudev_Widget_Manager {
        
        /**
         * Constructor
         * 
         * The constructor hooks the widget and category registration methods into Elementor's actions.
         * It sets up two hooks:
         * 1. 'elementor/widgets/widgets_registered' - Registers widgets when Elementor has registered all widgets.
         * 2. 'elementor/elements/categories_registered' - Registers custom widget categories.
         */
        public function __construct() {
            // Define actions to register widgets and categories
            $actions = [
                'elementor/widgets/widgets_registered' => 'register_widgets', // Register widgets after Elementor widgets are registered
                'elementor/elements/categories_registered' => 'register_categories', // Register custom widget categories
            ];

            // Attach methods to the respective actions
            foreach ($actions as $hook => $method) {
                add_action($hook, [$this, $method]);
            }
        }

        /**
         * Register Custom Widgets
         * 
         * This method registers the custom widgets with Elementor. It loads the widget file
         * and registers it with the Elementor widget manager.
         * 
         * @param \Elementor\Widgets_Manager $widgets_manager Elementor's widgets manager instance.
         */
        public function register_widgets($widgets_manager) {
            // Include the widget class file
            require_once PLUGIN_PATH . 'includes/widgets/widget-get-list-project.php';
            
            // Register the widget with Elementor
            $widgets_manager->register( new List_Project() );
        }

        /**
         * Register Custom Widget Categories
         * 
         * This method registers a new category in Elementor's widget panel for grouping custom widgets.
         * It adds a new category 'Project' with an icon to categorize widgets related to projects.
         * 
         * @param \Elementor\Elements_Manager $elements_manager Elementor's elements manager instance.
         */
        public function register_categories($elements_manager) {
            // Add a new category for widgets in Elementor's widget panel
            $elements_manager->add_category(
                'project_tthieudev', // Unique category identifier
                [
                    'title' => esc_html__( 'Project', 'tthieudev' ), // Category title
                    'icon' => 'fa fa-plug', // Icon for the category (Font Awesome plug icon)
                ]
            );
        }
    }
}

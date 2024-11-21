<?php
if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

/**
 * Class for registering and managing the "Project" Custom Post Type (CPT) and its associated taxonomies
 */
if ( ! class_exists( 'Class_TthieuDev_Project_Custom_Post_Type' ) ) {
    class Class_TthieuDev_Project_Custom_Post_Type {
        public function __construct() {
            // List of hooks and their respective methods
            $actions = [
                'init' => ['register_cpt', 'register_taxonomies'], // Register CPT and taxonomies during the 'init' action
                'admin_menu' => ['custom_admin_menu'],            // Add custom admin menu
            ];

            // Attach each method to the corresponding hook
            foreach ($actions as $hook => $methods) {
                foreach ((array) $methods as $method) {
                    add_action($hook, [$this, $method]);
                }
            }
        }

        /**
         * Register the "Project" Custom Post Type (CPT)
         */
        public function register_cpt() {
            $labels = [
                "name" => esc_html__("Projects", "tthieudev"),
                "singular_name" => esc_html__("Project", "tthieudev"),
                "menu_name" => esc_html__("All Project", "tthieudev"),
                "add_new" => esc_html__("Add New Project", "tthieudev"),
                "add_new_item" => esc_html__("Add New Project", "tthieudev"),
                "edit_item" => esc_html__("Edit Project", "tthieudev"),
                "new_item" => esc_html__("New Project", "tthieudev"),
                "view_item" => esc_html__("View Project", "tthieudev"),
                "search_items" => esc_html__("Search Projects", "tthieudev"),
                "not_found" => esc_html__("No Projects found", "tthieudev"),
                "not_found_in_trash" => esc_html__("No Projects found in Trash", "tthieudev"),
            ];

            $args = [
                "label" => esc_html__("Projects", "tthieudev"),
                "labels" => $labels,
                "public" => true,
                "publicly_queryable" => true,
                "show_ui" => true,
                'hierarchical' => true, // Allows parent-child relationship
                "show_in_rest" => true, // Enables block editor (Gutenberg)
                "has_archive" => true,
                "show_in_menu" => true,
                'show_in_quick_edit' => true,
                "rewrite" => ["slug" => "project", "with_front" => true], // Custom permalink structure
                "supports" => ["title", "editor", "thumbnail", "page-attributes"], // Features enabled for this CPT
                "taxonomies" => ["project_category", "project_tag"], // Associated taxonomies
                'template' => [
                    ['core/paragraph', ['content' => 'This is the default template content']],
                ],
                'menu_icon' => 'dashicons-archive', // Admin menu icon
            ];

            register_post_type("project", $args);
        }
        
        /**
         * Register the taxonomies: "project_category" and "project_tag" for the "Project" CPT
         */
        public function register_taxonomies() {
            // Category taxonomy
            $category_labels = [
                "name" => esc_html__("Categories", "tthieudev"),
                "singular_name" => esc_html__("Category", "tthieudev"),
            ];

            $category_args = [
                "label" => esc_html__("Categories", "tthieudev"),
                "labels" => $category_labels,
                "public" => true,
                "hierarchical" => true, // Acts as a category
                "show_in_rest" => true, // Enables block editor
                "rewrite" => ['slug' => 'project-category', 'with_front' => true],
            ];

            register_taxonomy("project_category", ["project"], $category_args);

            // Tag taxonomy
            $tag_labels = [
                "name" => esc_html__("Tags", "tthieudev"),
                "singular_name" => esc_html__("Tag", "tthieudev"),
            ];

            $tag_args = [
                "label" => esc_html__("Tags", "tthieudev"),
                "labels" => $tag_labels,
                "public" => true,
                "hierarchical" => false, // Acts as a tag
                "show_in_rest" => true,
                "rewrite" => ['slug' => 'project-tag', 'with_front' => true],
            ];

            register_taxonomy("project_tag", ["project"], $tag_args);

            // Ensure permalink structure is refreshed
            if (function_exists('flush_rewrite_rules')) {
                flush_rewrite_rules();
            }

            // Add default categories
            $default_categories = ["Web Development", "App ", "Marketing"];
            foreach ($default_categories as $term) {
                if (!term_exists($term, 'project_category')) {
                    wp_insert_term($term, 'project_category');
                }
            }

            // Add default tags
            $default_tags = ["IT", "Technology", "Design"];
            foreach ($default_tags as $term) {
                if (!term_exists($term, 'project_tag')) {
                    wp_insert_term($term, 'project_tag');
                }
            }
        }

        /**
         * Add a custom submenu page under the "Project" CPT
         */
        public function custom_admin_menu(){
            add_submenu_page(
                'edit.php?post_type=project',  // Parent menu slug
                'Setting Project',            // Page title
                'Setting Project',            // Menu title
                'manage_options',             // Capability required
                'setting_project',            // Menu slug
                array( $this, 'render_setting_project' ) // Callback function for content
            );
        } 
        
        /**
         * Render the content of the custom settings page
         */
        public function render_setting_project() {
            echo TemplateLoader::get_template('pages/setting-layout.php'); // Load the template file
        }
    }
}

// Initialize the class when the plugin is loaded
if (class_exists('Class_TthieuDev_Project_Custom_Post_Type')) {
    new Class_TthieuDev_Project_Custom_Post_Type();
}

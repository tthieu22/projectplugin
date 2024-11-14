<?php
if (!defined('ABSPATH')) {
    exit;
}

if ( ! class_exists( 'Class_TthieuDev_Project_Advance_Custom_Field' ) ) {
    class Class_TthieuDev_Project_Custom_Post_Type {
        public function __construct() {
            add_action('init', [$this, 'register_cpt']);
            add_action('init', [$this, 'register_taxonomies']);
        }
        
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
                'hierarchical' => true,
                "show_in_rest" => true,
                "has_archive" => true,
                "show_in_menu" => true,
                "rewrite" => ["slug" => "project", "with_front" => true],
                "supports" => ["title", "editor", "thumbnail", "page-attributes"],
                "taxonomies" => ["project_category", "project_tag"],
                'template' => [
                    ['core/paragraph', ['content' => 'This is the default template content']]
                ],
            ];

            register_post_type("project", $args);
        }
        
        public function register_taxonomies() {
            $category_labels = [
                "name" => esc_html__("Categories", "tthieudev"),
                "singular_name" => esc_html__("Category", "tthieudev"),
            ];

            $category_args = [
                "label" => esc_html__("Categories", "tthieudev"),
                "labels" => $category_labels,
                "public" => true,
                "hierarchical" => true,
                "show_in_rest" => true,
                "rewrite" => ['slug' => 'project-category', 'with_front' => true],
            ];

            register_taxonomy("project_category", ["project"], $category_args);

            $tag_labels = [
                "name" => esc_html__("Tags", "tthieudev"),
                "singular_name" => esc_html__("Tag", "tthieudev"),
            ];

            $tag_args = [
                "label" => esc_html__("Tags", "tthieudev"),
                "labels" => $tag_labels,
                "public" => true,
                "hierarchical" => false,
                "show_in_rest" => true,
                "rewrite" => ['slug' => 'project-tag', 'with_front' => true],
            ];

            register_taxonomy("project_tag", ["project"], $tag_args);

            if (function_exists('flush_rewrite_rules')) {
                flush_rewrite_rules();
            }

            $default_categories = ["Web Development", "Design", "Marketing"];
            foreach ($default_categories as $term) {
                if (!term_exists($term, 'project_category')) {
                    wp_insert_term($term, 'project_category');
                }
            }

            $default_tags = ["IT", "Technology", "Design"];
            foreach ($default_tags as $term) {
                if (!term_exists($term, 'project_tag')) {
                    wp_insert_term($term, 'project_tag');
                }
            }
        }
        
    }
}

// Initialize the class when the plugin is loaded
if (class_exists('Class_TthieuDev_Project_Custom_Post_Type')) {
    $tthieuDev_Project_CPT = new Class_TthieuDev_Project_Custom_Post_Type();
}

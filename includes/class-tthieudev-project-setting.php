<?php
if (!defined("ABSPATH")) exit;

if (!class_exists('Project_Settings')) {
    class Project_Settings {

        public function __construct() {
            add_action('admin_post_save_project_settings', array($this, 'save_settings'));
            add_action('pre_get_posts', array($this, 'set_posts_per_page_for_archive'));
        }

        public function save_settings() {
            if (!current_user_can('manage_options')) {
                return;
            }

            // Check nonce for security
            if (!isset($_POST['project_settings_nonce']) || !wp_verify_nonce($_POST['project_settings_nonce'], 'save_project_settings')) {
                return;
            }

            // Save single settings
            if (isset($_POST['submit_single_settings'])) {
                update_option('checked-show-category-single', isset($_POST['checked-show-category-single']) ? '1' : '0');
                update_option('checked-show-tag-single', isset($_POST['checked-show-tag-single']) ? '1' : '0');
                update_option('checked-show-sub-title', isset($_POST['checked-show-sub-title']) ? '1' : '0');
                update_option('checked-show-client', isset($_POST['checked-show-client']) ? '1' : '0');
                update_option('checked-show-date', isset($_POST['checked-show-date']) ? '1' : '0');
                update_option('checked-show-value', isset($_POST['checked-show-value']) ? '1' : '0');
                update_option('checked-show-image', isset($_POST['checked-show-image']) ? '1' : '0');
            }

            // Save archive settings
            if (isset($_POST['submit_archive_settings'])) {
                update_option('checked-show-pagination', isset($_POST['checked-show-pagination']) ? '1' : '0');
                update_option('checked-show-title-archive', isset($_POST['checked-show-title-archive']) ? '1' : '0');
                update_option('checked-show-category-archive', isset($_POST['checked-show-category-archive']) ? '1' : '0');
                update_option('checked-show-tag-archive', isset($_POST['checked-show-tag-archive']) ? '1' : '0');
                update_option('page-number', isset($_POST['page-number']) ? intval($_POST['page-number']) : 3);
            }

            // Redirect back with a success message
            wp_redirect(add_query_arg('settings-updated', 'true', wp_get_referer()));
            exit;
        }

        // Method to set posts per page for archive
        public function set_posts_per_page_for_archive($query) {
            if ((is_post_type_archive('project') || is_tax('project_category') || is_tax('project_tag')) && !is_admin() && $query->is_main_query()) {
                $posts_per_page = get_option('page-number', 3);

                // Optionally, override with URL parameter
                if (isset($_GET['total']) && is_numeric($_GET['total'])) {
                    $posts_per_page = $_GET['total'];
                }

                // Set query parameters
                $query->set('posts_per_page', $posts_per_page);
                $query->set('orderby', 'meta_value_num');
                $query->set('order', 'DESC');
                $query->set('meta_type', 'NUMERIC');
            }
        }
    }
}

// Initialize the class if it exists
if (class_exists('Project_Settings')) {
    new Project_Settings();
}

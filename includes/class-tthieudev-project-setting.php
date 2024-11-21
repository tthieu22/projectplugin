<?php
if (!defined("ABSPATH")) exit;

/**
 *  Project Setting Class
 * 
 * This class is responsible for handling the settings of the 'Project' custom post type.
 * It includes methods for saving settings from the admin area and modifying the query for 
 * archive pages to control the number of posts displayed.
 */
if (!class_exists('Project_Settings')) {
    class Project_Settings {

        /**
         * Constructor
         * Initializes the actions for saving settings and modifying archive queries.
         */
        public function __construct() {
            // Hook for saving settings submitted from the admin page
            add_action('admin_post_save_project_settings', array($this, 'save_settings'));
            
            // Hook for customizing query parameters for archive pages
            add_action('pre_get_posts', array($this, 'set_posts_per_page_for_archive'));
        }

        /**
         * Save Project Settings
         * Handles saving both single and archive settings from the admin form.
         */
        public function save_settings() {
            // Ensure the user has the required capability
            if (!current_user_can('manage_options')) {
                return;
            }

            // Verify the nonce for security
            if (!isset($_POST['project_settings_nonce']) || !wp_verify_nonce($_POST['project_settings_nonce'], 'save_project_settings')) {
                return;
            }

            // Save settings for single project view
            if (isset($_POST['submit_single_settings'])) {
                update_option('checked-show-category-single', isset($_POST['checked-show-category-single']) ? '1' : '0');
                update_option('checked-show-tag-single', isset($_POST['checked-show-tag-single']) ? '1' : '0');
                update_option('checked-show-sub-title', isset($_POST['checked-show-sub-title']) ? '1' : '0');
                update_option('checked-show-client', isset($_POST['checked-show-client']) ? '1' : '0');
                update_option('checked-show-date', isset($_POST['checked-show-date']) ? '1' : '0');
                update_option('checked-show-value', isset($_POST['checked-show-value']) ? '1' : '0');
                update_option('checked-show-image', isset($_POST['checked-show-image']) ? '1' : '0');
            }

            // Save settings for project archive view
            if (isset($_POST['submit_archive_settings'])) {
                update_option('checked-show-pagination', isset($_POST['checked-show-pagination']) ? '1' : '0');
                update_option('checked-show-title-archive', isset($_POST['checked-show-title-archive']) ? '1' : '0');
                update_option('checked-show-category-archive', isset($_POST['checked-show-category-archive']) ? '1' : '0');
                update_option('checked-show-tag-archive', isset($_POST['checked-show-tag-archive']) ? '1' : '0');
                update_option('page-number', isset($_POST['page-number']) ? intval($_POST['page-number']) : 3);
            }

            // Redirect to the previous page with a success message
            wp_redirect(add_query_arg('settings-updated', 'true', wp_get_referer()));
            exit;
        }

        /**
         * Set Posts Per Page for Archive
         * Modifies the query to control the number of posts displayed on archive pages.
         *
         * @param WP_Query $query The query object.
         */
        public function set_posts_per_page_for_archive($query) {
            // Apply changes only for the main query of the 'project' archive or taxonomy pages
            if ((is_post_type_archive('project') || is_tax('project_category') || is_tax('project_tag')) && !is_admin() && $query->is_main_query()) {
                // Get the number of posts per page from the settings, default to 3
                $posts_per_page = get_option('page-number', 3);

                // Allow overriding the value with a URL parameter
                if (isset($_GET['total']) && is_numeric($_GET['total'])) {
                    $posts_per_page = $_GET['total'];
                }

                // Set query parameters for pagination and ordering
                $query->set('posts_per_page', $posts_per_page);
                $query->set('orderby', 'meta_value_num');
                $query->set('order', 'DESC');
                $query->set('meta_type', 'NUMERIC');
            }
        }
    }
}

// Initialize the Project_Settings class if it exists
if (class_exists('Project_Settings')) {
    new Project_Settings();
}

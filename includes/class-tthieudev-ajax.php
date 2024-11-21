<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('Tthieudev_Ajax')) {
    class Tthieudev_Ajax {
        /**
         * Constructor method to initialize the class.
         * Registers AJAX actions for both authenticated and unauthenticated users.
         */
        public function __construct() {
            // AJAX actions and their corresponding methods
            $actions = [
                'wp_ajax_load_post_project_ajax' => 'load_post_project_ajax',
                'wp_ajax_nopriv_load_post_project_ajax' => 'load_post_project_ajax',
                'wp_ajax_handle_your_ajax_request' => 'handle_your_ajax_request',
                'wp_ajax_nopriv_handle_your_ajax_request' => 'handle_your_ajax_request',
            ];

            // Register AJAX actions
            foreach ($actions as $action => $method) {
                add_action($action, [$this, $method]);
            }
        }

        /**
         * Handles the AJAX request for loading project posts.
         */
        public function load_post_project_ajax() {
            // Verify the security nonce for AJAX requests.
            if (!check_ajax_referer('tthieudev-security-ajax', 'security', false)) {
                wp_send_json_error(['message' => 'Invalid security token.']);
                wp_die();
            }

            // Fetch settings for loading posts
            $settings = get_option('project_settings', []);
            $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

            // Build the query arguments
            $args = [
                'post_type'      => 'project',
                'post_status'    => 'publish',
                'paged'          => $paged,
                'posts_per_page' => $settings['posts_per_page'] ?? 10,
                'post__not_in'   => [$settings['current_post_id'] ?? 0],
            ];

            // Taxonomy query
            $tax_query = [];
            if (!empty($settings['selected_categories'])) {
                $tax_query[] = [
                    'taxonomy' => 'project_category',
                    'field'    => 'slug',
                    'terms'    => $settings['selected_categories'],
                ];
            }

            if (!empty($settings['selected_tags'])) {
                $tax_query[] = [
                    'taxonomy' => 'project_tag',
                    'field'    => 'slug',
                    'terms'    => $settings['selected_tags'],
                ];
            }

            if (!empty($tax_query)) {
                $args['tax_query'] = [
                    'relation' => 'OR',
                    ...$tax_query,
                ];
            }

            // Query posts
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                ob_start();
                while ($query->have_posts()) {
                    $query->the_post();
                    TemplateLoader::get_template('item/elementors/list-project-display.php');
                }
                wp_send_json_success([
                    'posts' => ob_get_clean(),
                    'total_pages' => $query->max_num_pages,
                ]);
            } else {
                wp_send_json_error(['message' => 'No posts found.']);
            }

            wp_die();
        }

        /**
         * Handles the AJAX request for fetching max posts.
         */
        public function handle_your_ajax_request() {
            // Verify nonce
            if (!isset($_POST['security_tthieu']) || !wp_verify_nonce($_POST['security_tthieu'], 'tthieudev-security-ajax-max')) {
                wp_send_json_error(['message' => 'Permission Denied']);
                wp_die();
            }

            // Fetch max posts logic
            $max_posts = TthieuDev_Elementor_Helper::get_max_posts();

            if ($max_posts === false) {
                wp_send_json_error(['message' => 'Unable to fetch max posts.']);
            } else {
                wp_send_json_success(['max_posts' => $max_posts]);
            }

            wp_die();
        }
    }
}

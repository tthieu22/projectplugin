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
            if (!check_ajax_referer('tthieudev-security-ajax', 'security', false)) {
                wp_send_json_error(['message' => 'Invalid security token.']);
                wp_die();
            }
            $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
            $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 10;
            $selected_tags = isset($_POST['selected_tags']) ? $_POST['selected_tags'] : [];
            $selected_categories = isset($_POST['selected_categories']) ? $_POST['selected_categories'] : [];
            $current_post_id = isset($_POST['current_post_id']) ? intval($_POST['current_post_id']) : 0;
            $args = [
                'post_type' => 'project',
                'post_status' => 'publish',
                'paged' => $paged,  
                'posts_per_page' => $posts_per_page,
                'post__not_in' => [$current_post_id],
            ];
            $tax_query = [];
            if (!empty($selected_categories)) {
                $tax_query[] = [
                    'taxonomy' => 'project_category',
                    'field' => 'slug',
                    'terms' => $selected_categories,
                ];
            }

            if (!empty($selected_tags)) {
                $tax_query[] = [
                    'taxonomy' => 'project_tag',
                    'field' => 'slug',
                    'terms' => $selected_tags,
                ];
            }

            if (!empty($tax_query)) {
                $args['tax_query'] = [
                    'relation' => 'OR',
                    ...$tax_query,
                ];
            }
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

       public function handle_your_ajax_request() {
            if (!check_ajax_referer('tthieudev-security-ajax-max', 'security_tthieu', false)) {
                wp_send_json_error(['message' => 'Invalid security token.']);
                wp_die();
            }
            $selected_tags = isset($_POST['selected_tags']) ? $_POST['selected_tags'] : [];
            $selected_categories = isset($_POST['selected_categories']) ? $_POST['selected_categories'] : [];
            $current_post_id = isset($_POST['current_post_id']) ? intval($_POST['current_post_id']) : 0;
            $max_posts = self::get_max_posts($selected_tags, $selected_categories, $current_post_id);

            if ($max_posts === false) {
                wp_send_json_error(['message' => 'Unable to fetch max posts.']);
            } else {
                wp_send_json_success(['max_posts' => $max_posts]);
            }

            wp_die();
        }
        


    }
}
if ( class_exists( 'Tthieudev_Ajax' ) ) {
    new Tthieudev_Ajax();
}

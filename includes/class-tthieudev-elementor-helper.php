<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Prevent direct access.
}

if ( ! class_exists( 'TthieuDev_Elementor_Helper' ) ) {
    class TthieuDev_Elementor_Helper {

        /**
         * Retrieve the list of project tags.
         *
         * @return array Associative array of tag slugs and names.
         */
        public static function get_project_tags() {
            $tags = get_terms([
                'taxonomy' => 'project_tag', 
                'hide_empty' => false,
            ]);

            $options = [];
            foreach ($tags as $tag) {
                $options[$tag->slug] = $tag->name;
            }

            return $options;
        }

        /**
         * Retrieve the list of project categories.
         *
         * @return array Associative array of category slugs and names.
         */
        public static function get_project_categories() {
            $categories = get_terms([
                'taxonomy' => 'project_category',
                'hide_empty' => false,
            ]);

            $options = [];
            foreach ($categories as $category) {
                $options[$category->slug] = $category->name;
            }

            return $options;
        }

        /**
         * Get the total number of unique project posts based on categories and tags.
         *
         * @return int Total count of unique posts.
         */
        public static function get_max_posts() {
            // Retrieve settings for loading posts.
            $settings = get_option('project_settings');
            $posts_per_page = isset($settings['posts_per_page']) ? $settings['posts_per_page'] : 10; // Default to 10 if not set
            $show_title = isset($settings['show_title']) ? $settings['show_title'] : true;
            $show_categories = isset($settings['show_categories']) ? $settings['show_categories'] : true;
            $show_tags = isset($settings['show_tags']) ? $settings['show_tags'] : true;
            $selected_categories = isset($settings['selected_categories']) ? $settings['selected_categories'] : [];
            $selected_tags = isset($settings['selected_tags']) ? $settings['selected_tags'] : [];
            $current_post_id = isset($settings['current_post_id']) ? $settings['current_post_id'] : 0;
            $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

            // Prepare the query arguments for fetching posts.
            $args = [
                'post_type'      => 'project',        // Custom post type to query.
                'post_status'    => 'publish',        // Only fetch published posts.
                'paged'          => $paged,           // Current page number for pagination.
                'post__not_in'   => [$current_post_id], // Exclude the current post from the results.
                'posts_per_page' => $posts_per_page,  // Number of posts to load per page.
            ];

            // Build the taxonomy query for filtering by categories and tags.
            $tax_query = [];
            if (!empty($selected_categories)) {
                $tax_query[] = [
                    'taxonomy' => 'project_category',  // Taxonomy for project categories.
                    'field'    => 'slug',             // Match categories by slug.
                    'terms'    => $selected_categories,
                    'operator' => 'IN',               // Match any of the selected categories.
                ];
            }

            if (!empty($selected_tags)) {
                $tax_query[] = [
                    'taxonomy' => 'project_tag',       // Taxonomy for project tags.
                    'field'    => 'slug',             // Match tags by slug.
                    'terms'    => $selected_tags,
                    'operator' => 'IN',               // Match any of the selected tags.
                ];
            }

            if (!empty($tax_query)) {
                $args['tax_query'] = [
                    'relation' => 'OR', // Combine multiple taxonomy filters with OR logic.
                ];
                $args['tax_query'] = array_merge($args['tax_query'], $tax_query);
            }


            // Execute the WP_Query with the prepared arguments.
            $query = new WP_Query($args);

            // Calculate max posts based on the query result
            $max_posts = $query->found_posts; // This gives the total number of posts based on the query

            return $max_posts;

        }


        /**
         * Get the number of unique project posts based on the given categories.
         *
         * @param array $categories Array of category slugs.
         * @return int Total count of unique posts.
         */
        public static function get_max_posts_by_categories($categories) {
            $unique_posts = [];

            foreach ($categories as $slug) {
                $query = new WP_Query([
                    'post_type' => 'project',
                    'tax_query' => [
                        [
                            'taxonomy' => 'project_category',
                            'field'    => 'slug',
                            'terms'    => $slug,
                        ],
                    ],
                    'fields' => 'ids',
                    'posts_per_page' => -1, 
                ]);

                if (!empty($query->posts)) {
                    $unique_posts = array_merge($unique_posts, $query->posts);
                }
            }

            $unique_posts = array_unique($unique_posts);
            return count($unique_posts);
        }
    }
}

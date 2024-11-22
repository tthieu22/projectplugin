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
        public static function get_max_posts($selected_tags, $selected_categories, $current_post_id) {
            // Cấu hình các tham số cho WP_Query
            $args = [
                'post_type'      => 'project',
                'post_status'    => 'publish',
                'post__not_in'   => [$current_post_id], // Loại trừ bài viết hiện tại
            ];

            // Cấu hình Tax Query (Lọc theo danh mục và thẻ)
            $tax_query = [];

            // Nếu có selected_categories, thêm vào tax_query
            if (!empty($selected_categories)) {
                $tax_query[] = [
                    'taxonomy' => 'project_category',
                    'field'    => 'slug',
                    'terms'    => $selected_categories,
                    'operator' => 'IN', // Lọc theo các danh mục này
                ];
            }

            // Nếu có selected_tags, thêm vào tax_query
            if (!empty($selected_tags)) {
                $tax_query[] = [
                    'taxonomy' => 'project_tag',
                    'field'    => 'slug',
                    'terms'    => $selected_tags,
                    'operator' => 'IN', // Lọc theo các thẻ này
                ];
            }

            // Thêm tax_query vào args nếu có
            if (!empty($tax_query)) {
                $args['tax_query'] = [
                    'relation' => 'OR',  // Lọc theo danh mục hoặc thẻ (hoặc)
                ];
                $args['tax_query'] = array_merge($args['tax_query'], $tax_query);
            }

            // Thực thi truy vấn
            $query = new WP_Query($args);

            // Trả về tổng số bài viết tìm thấy
            return $query->found_posts;
        }


    }
}

// Initialize the class
if (class_exists('TthieuDev_Elementor_Helper')) {
    new TthieuDev_Elementor_Helper();
}

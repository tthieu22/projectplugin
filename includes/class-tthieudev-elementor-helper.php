<?php defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'TthieuDev_Elementor_Helper' ) ) {
    class TthieuDev_Elementor_Helper {
        
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

        public static function get_max_posts($selected_tags, $selected_categories, $current_post_id) {
            // Cấu hình các tham số cho WP_Query
            $args = [
                'post_type'      => 'project',
                'post_status'    => 'publish',
                'post__not_in'   => [$current_post_id], 
            ];

            $tax_query = [];

            if (!empty($selected_categories)) {
                $tax_query[] = [
                    'taxonomy' => 'project_category',
                    'field'    => 'slug',
                    'terms'    => $selected_categories,
                    'operator' => 'IN', 
                ];
            }

            if (!empty($selected_tags)) {
                $tax_query[] = [
                    'taxonomy' => 'project_tag',
                    'field'    => 'slug',
                    'terms'    => $selected_tags,
                    'operator' => 'IN',
                ];
            }

            if (!empty($tax_query)) {
                $args['tax_query'] = [
                    'relation' => 'OR',  
                ];
                $args['tax_query'] = array_merge($args['tax_query'], $tax_query);
            }

            $query = new WP_Query($args);

            return $query->found_posts;
        }


    }
    return new TthieuDev_Elementor_Helper();
}

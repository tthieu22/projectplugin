<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
class Tthieudev_Ajax {
    public function __construct() {
        $actions = [
            'wp_ajax_load_post_project_ajax',
            'wp_ajax_nopriv_load_post_project_ajax',
        ];

        foreach ($actions as $action) {
            add_action($action, [$this, 'load_post_project_ajax']);
        }
    }

    function load_post_project_ajax() {
        check_admin_referer( 'tthieudev-security-ajax', 'security' );

        $settings = get_option('project_settings');
        $posts_per_page = $settings['posts_per_page'];
        $show_title = $settings['show_title'];
        $show_categories = $settings['show_categories'];
        $show_tags = $settings['show_tags'];
        $selected_categories = $settings['selected_categories'];
        $selected_tags = $settings['selected_tags'];
        $current_post_id = $settings['current_post_id'];
        $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

        $args = [
            'post_type'      => 'project',
            'post_status'    => 'publish',
            'paged'          => $paged,
            'post__not_in'   => [$current_post_id],
            'posts_per_page' => $posts_per_page,
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
                ...$tax_query,
            ];
        }
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            ob_start(); 

            while ($query->have_posts()) {
                $query->the_post();
                TemplateLoader::get_template('item/elementors/list-project-display.php' ); 
            }

            $total_pages = $query->max_num_pages;
            wp_send_json_success([
                'posts' => ob_get_clean(),
                'total_pages' => $total_pages,
            ]);
        } else {
            wp_send_json_error(['message' => 'No more posts.']);
        }

        wp_die();
    }
}

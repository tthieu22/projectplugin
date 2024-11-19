<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

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
        $categories = self::get_project_categories();
        $tags = self::get_project_tags(); 
        $category_posts = []; 
        $tag_posts = []; 
        $unique_posts = []; 

        $current_post_id = get_the_ID(); // ID of the current post.

        // Retrieve posts associated with categories.
        foreach ($categories as $slug => $name) {
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
                $category_posts[$slug] = $query->posts;
            }
        }

        // Retrieve posts associated with tags.
        foreach ($tags as $slug => $name) {
            $query = new WP_Query([
                'post_type' => 'project',
                'tax_query' => [
                    [
                        'taxonomy' => 'project_tag',
                        'field'    => 'slug',
                        'terms'    => $slug,
                    ],
                ],
                'fields' => 'ids',
                'posts_per_page' => -1,
            ]);

            if (!empty($query->posts)) {
                $tag_posts[$slug] = $query->posts;
            }
        }

        // Process and filter duplicate posts and the current post.
        foreach ($category_posts as $category_post_ids) {
            foreach ($category_post_ids as $post_id) {
                if ($post_id === $current_post_id || in_array($post_id, $unique_posts)) {
                    continue;
                }

                $is_in_tag = false;
                foreach ($tag_posts as $tag_post_ids) {
                    if (in_array($post_id, $tag_post_ids)) {
                        $is_in_tag = true;
                        break;
                    }
                }

                if (!$is_in_tag) {
                    $unique_posts[] = $post_id;
                }
            }
        }

        // Add posts from tags if not already in the list.
        foreach ($tag_posts as $tag_post_ids) {
            foreach ($tag_post_ids as $post_id) {
                if ($post_id !== $current_post_id && !in_array($post_id, $unique_posts)) {
                    $unique_posts[] = $post_id;
                }
            }
        }

        return count($unique_posts);
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

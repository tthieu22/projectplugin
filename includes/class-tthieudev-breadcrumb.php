<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

if ( ! class_exists( 'Tthieudev_Breadcrumb' ) ) {
    class Tthieudev_Breadcrumb {
        public static function display() {
            if (!is_front_page()) {
                echo '<nav class="breadcrumb-custom">';
                echo '<a href="' . home_url() . '">' . __('Home', 'tthieudev') . '</a> > ';

                if (is_singular('project')) {
                    echo '<a href="' . get_post_type_archive_link('project') . '">' . __('Projects', 'tthieudev') . '</a> > ';
                    the_title();
                } elseif (is_post_type_archive('project')) {
                    echo __('Projects', 'tthieudev');
                } elseif (is_tax('project_category') || is_tax('project_tag')) {
                    $term = get_queried_object();
                    echo '<a href="' . get_post_type_archive_link('project') . '">' . __('Projects', 'tthieudev') . '</a> > ';
                    echo single_term_title('', false);
                } elseif (is_category() || is_single()) {
                    the_category(' > ');
                    if (is_single()) {
                        echo " > ";
                        the_title();
                    }
                } elseif (is_page()) {
                    echo the_title();
                } elseif (is_archive()) {
                    echo post_type_archive_title('', false);
                }

                echo '</nav>';
            }
        }
    }
}
<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Class_Tthieudev_Shortcode_Handler' ) ) {
    class Class_Tthieudev_Shortcode_Handler {

        public function __construct() {
            add_action( 'init', [ $this, 'register_shortcodes' ] );
        }

        public function register_shortcodes() {
            add_shortcode( 'project', [ $this, 'list_project' ] );
        }

        public function list_project( $atts ) {
            $atts = shortcode_atts(
                [
                    'categories'     => '',
                    'tags'           => '',
                    'post_per_page'  => 3,
                    'columns'        => 3,
                    'style'          => 'grid',
                    'pagination'     => 'yes',
                ],
                $atts,
                'project'
            );

            // Xử lý categories và tags dựa trên dấu |
            $categories = $this->parse_tax_input( $atts['categories'], '|' );
            $tags = $this->parse_tax_input( $atts['tags'], '|' );

            $post_per_page = max( 1, (int) $atts['post_per_page'] );
            $columns = max( 1, min( 6, (int) $atts['columns'] ) );
            $style = esc_attr( $atts['style'] );
            $pagination = esc_attr( $atts['pagination'] );
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

            $args = [
                'post_type'      => 'project',
                'post_status'    => 'publish',
                'posts_per_page' => $post_per_page,
                'paged'          => $paged,
            ];

            // Xây dựng tax_query
            $tax_query = [];
            if ( ! empty( $categories ) ) {
                $tax_query[] = [
                    'taxonomy' => 'project_category',
                    'field'    => 'slug',
                    'terms'    => $categories,
                    'operator' => 'IN',
                ];
            }

            if ( ! empty( $tags ) ) {
                $tax_query[] = [
                    'taxonomy' => 'project_tag',
                    'field'    => 'slug',
                    'terms'    => $tags,
                    'operator' => 'IN',
                ];
            }

            if ( ! empty( $tax_query ) ) {
                $args['tax_query'] = [
                    'relation' => 'OR',
                ];
                $args['tax_query'] = array_merge( $args['tax_query'], $tax_query );
            }

            $args = apply_filters( 'tthieudev_project_query_args', $args, $atts );

            // Truy vấn bài viết
            $query = new WP_Query( $args );

            if ( $query->have_posts() ) {
                ob_start();
                echo '<div class="project-list-content" data-style="' . esc_attr( $style ) . '" data-columns="' . esc_attr( $columns ) . '"style="grid-template-columns:repeat('. esc_attr( $columns ) .' , 1fr)">' ;
                while ( $query->have_posts() ) {
                    $query->the_post();
                    TemplateLoader::get_template( 'item/shortcode/list-project.php' );
                }
                echo '</div>';
                if ( 'yes' === $pagination ) {
                    $this->render_pagination( $query );
                }

                wp_reset_postdata();
                return ob_get_clean();
            }

            return apply_filters( 'tthieudev_project_no_posts_message', '<p>No projects found.</p>' );
        }

        private function render_pagination( $query ) {
            echo '<div class="pagination-main"><div id="pagination-container">';
            global $wp_query;
            $temp_query = $wp_query;
            $wp_query = $query;

            TemplateLoader::get_template( 'item/panigation.php' );

            $wp_query = $temp_query;
            echo '</div></div>';
        }

        /**
         * Xử lý danh sách danh mục hoặc thẻ từ chuỗi đầu vào với dấu phân tách
         *
         * @param string $input Chuỗi đầu vào
         * @param string $delimiter Dấu phân tách (ví dụ: '|')
         * @return array Mảng các danh mục hoặc thẻ đã xử lý
         */
        private function parse_tax_input( $input, $delimiter = ',' ) {
            $input = trim( $input );
            if ( empty( $input ) ) {
                return [];
            }

            // Tách theo dấu phân tách, giữ nguyên khoảng trắng trong tên
            $items = preg_split( '/\s*' . preg_quote( $delimiter, '/' ) . '\s*/', $input );

            // Xóa các phần tử trống và trả về mảng
            return array_filter( array_map( 'sanitize_text_field', $items ) );
        }
    }
}

if ( class_exists( 'Class_Tthieudev_Shortcode_Handler' ) ) {
    new Class_Tthieudev_Shortcode_Handler();
}
<?php defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'TthieuDev_Shortcore_Handler' ) ) {
    class TthieuDev_Shortcore_Handler {

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

            $query = new WP_Query( $args );

            if ( $query->have_posts() ) {
                ob_start();
                echo '<div class="project-list-content" data-style="' . esc_attr( $style ) . '" data-columns="' . esc_attr( $columns ) . '"style="grid-template-columns:repeat('. esc_attr( $columns ) .' , 1fr)">' ;
                while ( $query->have_posts() ) {
                    $query->the_post();
                    tthieudev_get_template( 'item/shortcode/list-project.php' );
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

            tthieudev_get_template( 'item/panigation.php' );

            $wp_query = $temp_query;
            echo '</div></div>';
        }
        
		/**
		 * Process a list of categories or tags from an input string with a delimiter
		 *
		 * @param string $input Input string
		 * @param string $delimiter Delimiter (e.g., '|')
		 * @return array Processed array of categories or tags
		 */
        private function parse_tax_input( $input, $delimiter = ',' ) {
            $input = trim( $input );
            if ( empty( $input ) ) {
                return [];
            }

            $items = preg_split( '/\s*' . preg_quote( $delimiter, '/' ) . '\s*/', $input );

            return array_filter( array_map( 'sanitize_text_field', $items ) );
        }
    }
    return new TthieuDev_Shortcore_Handler();
}

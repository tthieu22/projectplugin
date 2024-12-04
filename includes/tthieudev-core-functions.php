<?php defined('ABSPATH') || exit;

if ( !function_exists( 'tthieudev_locate_template' ) ) {
    function tthieudev_locate_template( $template_name = '', $template_path = '', $default_path = '' ) {
        if ( ! $template_path ) {
            $template_path = 'projectplugin';
        }

        if ( ! $default_path ) {
            $default_path = TTHIEUDEV_PLUGIN_PATH . 'templates/';
        }

        $template = locate_template( $template_path . $template_name );

        if ( ! $template ) {
            $template = $default_path . $template_name;
        }

        return apply_filters( 'tthieudev_locate_template', $template, $template_name, $template_path, $default_path );
    }
}

if ( !function_exists( 'tthieudev_get_template' ) ) {
    function tthieudev_get_template( $template_name = '', $args = [], $template_path = '', $default_path = '' ) {
        if ( ! empty( $args ) && is_array( $args ) ) {
            extract( $args );
        }

        $template_file = tthieudev_locate_template( $template_name, $template_path, $default_path );

        if ( ! file_exists( $template_file ) ) {
            doing_it_wrong( __FUNCTION__, sprintf( esc_html__( '<code>%s</code> does not exist.', 'TthieuDev_TemplateLoader' ), esc_html( $template_file ) ), esc_html( TTHIEUDEV()->version ) );
            return;
        }

        include $template_file;
    }
}

if ( !function_exists( 'tthieudev_breadcrumb' ) ) {
	function tthieudev_breadcrumb() {
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

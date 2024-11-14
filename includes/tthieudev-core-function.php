<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'PLUGIN_PATH' ) ) {
    define( 'PLUGIN_PATH', rtrim( plugin_dir_path( dirname( __FILE__ ) ), '/' ) . '/' );
}

require_once( PLUGIN_PATH . 'includes/class-tthieudev-project-custom-post-type.php');
require_once( PLUGIN_PATH . 'includes/class-tthieudev-project-advance-custom-field.php');
require_once( PLUGIN_PATH . 'includes/class-tthieudev-setting-project.php');
require_once( PLUGIN_PATH . 'includes/class-tthieudev-load-assets.php');

function project_template_loader( $template ) {
    // Variable stores template path
    $plugin_template = '';
    // Check if it is an archive page of 'project'
    if ( is_post_type_archive( 'project' ) ) {
        $plugin_template = PLUGIN_PATH . 'templates/pages/archive-project.php';
    }
    // Check if it is a single page of 'project'
    elseif ( is_singular( 'project' ) ) {
        $plugin_template = PLUGIN_PATH . 'templates/pages/single-project.php';
    }
    // Check if taxonomy page of 'project_category' or 'project_tag'
    elseif ( is_tax( 'project_category' ) || is_tax( 'project_tag' ) ) {
        $plugin_template = PLUGIN_PATH . 'templates/pages/taxonomy-project_category.php';
    }
    // If template exists, return template
    if ( isset( $plugin_template ) && file_exists( $plugin_template ) ) {
        return $plugin_template;
    }
    // If there is no matching template, return the default template
    return $template;
}
// Apply filter to change template
add_filter( 'template_include', 'project_template_loader' );

// Create a breadcrumb function in the main plugin file
function tthieudev_custom_breadcrumb() {
    if (!is_front_page()) {
        echo '<nav class="breadcrumb-custom">';
        echo '<a href="' . home_url() . '">' . __('Home', 'tthieudev') . '</a> > ';

        if (is_singular('project')) {
            // Link to archive of post type project
            echo '<a href="' . get_post_type_archive_link('project') . '">' . __('Projects', 'tthieudev') . '</a> > ';
            the_title(); // Displays the title of the current post
        } elseif (is_post_type_archive('project')) {
            echo __('Projects', 'tthieudev'); // Title archive
        } elseif (is_tax('project_category') || is_tax('project_tag')) {
            // Show breadcrumb for taxonomy
            $term = get_queried_object();
            $taxonomy_name = $term->taxonomy;
            echo '<a href="' . get_post_type_archive_link('project') . '">' . __('Projects', 'tthieudev') . '</a> > ';
            $taxonomy_label = $taxonomy_name === 'project_category' ? __('Categories', 'tthieudev') : __('Tags', 'tthieudev');
            
            // echo '<a href="' . get_term_link($term) . '">' . $taxonomy_label . '</a> > ';
            echo single_term_title('', false); // Show current term name
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


/**
 * Get locate template
 */
if ( !function_exists( 'tthieudev_locate_template' ) ) {
    function tthieudev_locate_template( $template_name = '', $template_path = '', $default_path = '' ) {
        // Set variable to search in woocommerce-tour-booking folder of theme.
        if ( !$template_path ) {
            $template_path = 'ProjectPlugin';
        }
 
        // Set default plugin templates path.
        if ( !$default_path ) {
            $default_path = PLUGIN_PATH . 'templates/'; // Path to the template folder
        }
 
        // Search template file in theme folder.
        $template = locate_template( $template_path . $template_name );
 
        // Get plugins template file.
        if ( !$template ) {
            $template = $default_path . $template_name;
        }


        return apply_filters( 'tthieudev_locate_template', $template, $template_name, $template_path, $default_path );
    }
}

/**
 * Get woocommerce-tour-booking template
 */
if ( !function_exists( 'tthieudev_get_template' ) ) {
    function tthieudev_get_template( $template_name = '', $args = [], $tempate_path = '', $default_path = '' ) {
        // extract $args
        if ( !empty( $args ) && is_array( $args ) ) extract( $args );

        $template_file = tthieudev_locate_template( $template_name, $tempate_path, $default_path );

        if ( !file_exists( $template_file ) ) {
            doing_it_wrong( _FUNCTION_, sprintf( esc_html_( '<code>%s</code> does not exist.', 'ProjectPlugin' ), esc_html( $template_file ) ), esc_html( OVATB()->version ) );
            return;
        }

        // nosemgrep audit.php.lang.security.file.inclusion-arg
        include $template_file;
    }
}

// tthieudev_get_template( 'forms/booking/fixed-date.php', $args );


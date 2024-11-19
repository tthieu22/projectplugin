<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * TemplateLoader Class
 */
class TemplateLoader {

    /**
     * Get locate template
     */
    public static function locate_template( $template_name = '', $template_path = '', $default_path = '' ) {
        // Set variable to search in TemplateLoader folder of theme.
        if ( ! $template_path ) {
            $template_path = 'projectplugin';
        }

        // Set default plugin templates path.
        if ( ! $default_path ) {
            $default_path = PLUGIN_PATH . 'templates/'; // Path to the template folder
        }

        // Search template file in theme folder.
        $template = locate_template( $template_path . $template_name );

        // Get plugin template file if not found in theme.
        if ( ! $template ) {
            $template = $default_path . $template_name;
        }

        return apply_filters( 'template_loader_locate_template', $template, $template_name, $template_path, $default_path );
    }

    /**
     * Get template
     */
    public static function get_template( $template_name = '', $args = [], $template_path = '', $default_path = '' ) {
        // extract $args
        if ( ! empty( $args ) && is_array( $args ) ) {
            extract( $args );
        }

        $template_file = self::locate_template( $template_name, $template_path, $default_path );

        if ( ! file_exists( $template_file ) ) {
            doing_it_wrong( __FUNCTION__, sprintf( esc_html__( '<code>%s</code> does not exist.', 'TemplateLoader' ), esc_html( $template_file ) ), esc_html( OVATB()->version ) );
            return;
        }

        // nosemgrep audit.php.lang.security.file.inclusion-arg
        include $template_file;
    }
}
if ( class_exists( 'TemplateLoader' ) ) {
    new TemplateLoader();
}

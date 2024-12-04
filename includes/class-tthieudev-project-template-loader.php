<?php defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'TthieuDev_Project_Template_Loader' ) ) {
    class TthieuDev_Project_Template_Loader {

        public function __construct() {
            add_filter( 'template_include', array( $this, 'load_project_template' ) );
        }

        public function load_project_template( $template ) {

            $plugin_template = '';
            if ( is_post_type_archive( 'project' ) ) {
                $plugin_template = tthieudev_locate_template( 'pages/archive-project.php' );
            }
            elseif ( is_singular( 'project' ) ) {
                $plugin_template = tthieudev_locate_template( 'pages/single-project.php' );
            }
            elseif ( is_tax( 'project_category' ) || is_tax( 'project_tag' ) ) {
                $plugin_template = tthieudev_locate_template( 'pages/taxonomy-project_category.php' );
            }
            if ( $plugin_template && file_exists( $plugin_template ) ) {
                return $plugin_template;
            }
            return $template;
        }
    }
    return new TthieuDev_Project_Template_Loader();
}

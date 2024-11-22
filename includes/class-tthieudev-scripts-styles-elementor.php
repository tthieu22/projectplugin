<?php
if (!defined('PLUGIN_URI')) {
    define('PLUGIN_URI', plugin_dir_url(__FILE__));
}

/**
 * Enqueue styles and scripts for Elementor Widgets (frontend & admin).
 */
if (!class_exists('Tthieudev_Scripts_Styles_Elementor')) {
    class Tthieudev_Scripts_Styles_Elementor {

        public function __construct() {
            // Map actions to methods
            $hooks = [
                'wp_enqueue_scripts' => ['enqueue_frontend_assets'],
                // 'admin_enqueue_scripts' => ['enqueue_admin_assets'],
                // 'elementor/editor/after_enqueue_scripts' => ['enqueue_elementor_editor_scripts'],
            ];

            // Loop through hooks and register methods
            foreach ($hooks as $action => $methods) {
                foreach ($methods as $method) {
                    add_action($action, [$this, $method]);
                }
            }
        }
         /**
         * Enqueue scripts for Elementor editor.
         */
        public function enqueue_elementor_editor_scripts() {
            wp_enqueue_script(
                'tthieudev-editor',
                PLUGIN_URI . 'assets/js/elementors/max-post.js',
                ['jquery', 'elementor-editor'],
                '1.0.0',
                true
            );

            wp_enqueue_style(
                'widget_get_list_project_css_editor',
                PLUGIN_URI . "assets/css/elementors/widget-get-list-project.css",
                [],
                '1.0.0',
                'all'
            );
            wp_localize_script(
                'tthieudev-editor',
                'tthieudev',
                [
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'security_tthieu' => wp_create_nonce('tthieudev-security-ajax-max'),
                ]
            );
        }

        /**
         * Enqueue frontend styles and scripts.
         */
        public function enqueue_frontend_assets() {
            wp_enqueue_style(
                'widget_get_list_project_css',
                PLUGIN_URI . "assets/css/elementors/widget-get-list-project.css",
                [],
                '1.0.0',
                'all'
            );

            wp_enqueue_style(
                'shortcode_get_list_project_css',
                PLUGIN_URI . "assets/css/elementors/shortcode-list-project.css",
                [],
                '1.0.0',
                'all'
            );

            wp_enqueue_script(
                'shortcode_project_js',
                PLUGIN_URI . "assets/js/elementors/short-code.js",
                ['jquery'],
                '1.0.0',
                true
            );
            wp_enqueue_script(
                'widget_get_list_project_js',
                PLUGIN_URI . "assets/js/elementors/widget-get-list-project.js",
                ['jquery'],
                '1.0.0',
                true
            );
            wp_localize_script(
                'widget_get_list_project_js',
                'ajax_object',
                [
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'security' => wp_create_nonce('tthieudev-security-ajax'),
                ]
            );
        }


        /**
         * Enqueue admin styles and scripts.
         */
        public function enqueue_admin_assets() {
            wp_enqueue_style(
                'widget_get_list_project_admin_css',
                PLUGIN_URI . "assets/css/elementors/admin-widget-get-list-project.css",
                [],
                '1.0.0',
                'all'
            );
            wp_enqueue_script(
                'widget_get_list_project_admin_js',
                PLUGIN_URI . "assets/js/elementors/admin-widget-get-list-project.js",
                ['jquery'],
                '1.0.0',
                true
            );
        }

       
    }
}
if ( class_exists( 'Tthieudev_Scripts_Styles_Elementor' ) ) {
    new Tthieudev_Scripts_Styles_Elementor();
}

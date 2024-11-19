<?php
if ( ! defined( 'PLUGIN_URI' ) ) {
    define( 'PLUGIN_URI', plugin_dir_url( __FILE__ ) );
}

class Tthieudev_Scripts_Styles_Elementor {
    public function __construct() {
        $actions = [
            'wp_enqueue_scripts' => ['enqueue_frontend_styles', 'enqueue_frontend_scripts'],
            'admin_enqueue_scripts' => ['enqueue_admin_styles', 'enqueue_admin_scripts'],
        ];

        foreach ($actions as $action => $methods) {
            foreach ($methods as $method) {
                add_action($action, [$this, $method]);
            }
        }
    }


    /**
     * Enqueue frontend styles (CSS)
     */
    public function enqueue_frontend_styles() {
        wp_enqueue_style( 
            'widget_get_list_project_css', 
            PLUGIN_URI . "assets/css/elementors/widget-get-list-project.css", 
            [], 
            '1.0.0', 
            'all' 
        );
    }

    /**
     * Enqueue frontend scripts (JavaScript)
     */
    public function enqueue_frontend_scripts() {
        wp_enqueue_script( 
            'widget_get_list_project_js', 
            PLUGIN_URI . "assets/js/elementors/widget-get-list-project.js", 
            [ 'jquery' ], 
            '1.0.0', 
            true 
        );

        // Localize script to pass data to JavaScript
        wp_localize_script( 
            'widget_get_list_project_js', 
            'ajax_object', 
            [
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'security' => wp_create_nonce( 'tthieudev-security-ajax' ),
            ]
        );
    }

    /**
     * Enqueue admin styles (CSS)
     */
    public function enqueue_admin_styles() {
        wp_enqueue_style( 
            'widget_get_list_project_admin_css', 
            PLUGIN_URI . "assets/css/elementors/admin-widget-get-list-project.css", 
            [], 
            '1.0.0', 
            'all' 
        );
    }

    /**
     * Enqueue admin scripts (JavaScript)
     */
    public function enqueue_admin_scripts() {
        wp_enqueue_script( 
            'widget_get_list_project_admin_js', 
            PLUGIN_URI . "assets/js/elementors/admin-widget-get-list-project.js", 
            [ 'jquery' ], 
            '1.0.0', 
            true 
        );
    }
}

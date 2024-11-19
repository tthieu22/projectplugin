<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Tthieudev_Widget_Manager {
    public function __construct() {
        $actions = [
            'elementor/widgets/widgets_registered' => 'register_widgets',
            'elementor/elements/categories_registered' => 'register_categories',
        ];

        foreach ($actions as $hook => $method) {
            add_action($hook, [$this, $method]);
        }
    }


    public function register_widgets($widgets_manager) {
        require_once PLUGIN_PATH . 'includes/widgets/widget-get-list-project.php';
        $widgets_manager->register( new List_Project() );
    }

    public function register_categories($elements_manager) {
        $elements_manager->add_category(
            'project_tthieudev',
            [
                'title' => esc_html__( 'Project', 'tthieudev' ),
                'icon' => 'fa fa-plug',
            ]
        );
    }
}

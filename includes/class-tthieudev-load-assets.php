<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define plugin base URL constant
if (!defined('PLUGIN_URI')) {
    define('PLUGIN_URI', rtrim(plugin_dir_url(dirname(__FILE__)), '/') . '/');
}

// Check if the class doesn't already exist
if (!class_exists('Class_Tthieudev_Load_Assets')) {
    class Class_Tthieudev_Load_Assets {
        public function __construct() {
            $actions = [
                'wp_enqueue_scripts' => ['load_styles_frontend', 'load_scripts_frontend'],
                'admin_enqueue_scripts' => ['load_styles_admin', 'load_scripts_admin'],
            ];

            foreach ($actions as $hook => $methods) {
                foreach ($methods as $method) {
                    add_action($hook, [$this, $method]);
                }
            }
        }


        /**
         * Load styles for the frontend
         */
        public function load_styles_frontend() {
            wp_enqueue_style('bootstrap_min_css', PLUGIN_URI . "assets/css/library/bootstrap.min.css", array(), '1.0.0', 'all');
            wp_enqueue_style('font_awesome_cdn', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css", array(), '6.6.0', 'all');
            wp_enqueue_style('wrapper', PLUGIN_URI . "assets/css/frontend/wrapper.css", array(), '1.0.0', 'all');
            wp_enqueue_style('style-archive-project', PLUGIN_URI . "assets/css/frontend/archive-project.css", array(), '1.0.0', 'all');
            wp_enqueue_style('style-single-project', PLUGIN_URI . "assets/css/frontend/single-project.css", array(), '1.0.0', 'all');
        }

        /**
         * Load scripts for the frontend
         */
        public function load_scripts_frontend() {
            wp_enqueue_script('jquery_js', PLUGIN_URI . "assets/js/library/jquery-3.7.1.js", array('jquery'), '1.0.0', true);
            wp_enqueue_script('bootstrap_min_js', PLUGIN_URI . "assets/js/library/bootstrap.min.js", array('jquery'), '1.0.0', true);

            // Localize a variable for AJAX requests
            wp_localize_script('jquery_js', 'ajaxurl', array(
                'baseURL' => admin_url('admin-ajax.php')
            ));
        }

        /**
         * Load styles for the backend (admin panel)
         */
        public function load_styles_admin() {
            wp_enqueue_style('bootstrap_min_css', PLUGIN_URI . "assets/css/library/bootstrap.min.css", array(), '1.0.0', 'all');
            wp_enqueue_style('font_awesome_cdn', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css", array(), '6.6.0', 'all');
            wp_enqueue_style('style-setting-project', PLUGIN_URI . "assets/css/admin/setting-project.css", array(), '1.0.0', 'all');
        }

        /**
         * Load scripts for the backend (admin panel)
         */
        public function load_scripts_admin() {
            wp_enqueue_script('jquery_js', PLUGIN_URI . "assets/js/library/jquery-3.7.1.js", array('jquery'), '1.0.0', true);
            wp_enqueue_script('bootstrap_min_js', PLUGIN_URI . "assets/js/library/bootstrap.min.js", array('jquery'), '1.0.0', true);
            wp_enqueue_script('setting_project', PLUGIN_URI . "assets/js/admin/setting-project.js", array('jquery'), '1.0.0', true);

            // Localize a variable for AJAX requests
            wp_localize_script('jquery_js', 'ajaxurl', array(
                'baseURL' => admin_url('admin-ajax.php')
            ));
        }
    }
}

// Initialize the class if it exists
if (class_exists('Class_Tthieudev_Load_Assets')) {
    new Class_Tthieudev_Load_Assets();
}

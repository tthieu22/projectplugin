<?php defined( 'ABSPATH' ) || exit;

if (!class_exists('TthieuDev_Assets')) {
    class TthieuDev_Assets {

        public function __construct() {
            $actions = [
                'admin_enqueue_scripts' => ['load_styles_admin', 'load_scripts_admin'],
                'wp_enqueue_scripts' => ['load_styles_frontend', 'load_scripts_frontend', 'enqueue_frontend_assets'],
            ];
            foreach ($actions as $hook => $methods) {
                foreach ($methods as $method) {
                    add_action($hook, [$this, $method]);
                }
            }

            // Elementor specific hooks
            add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_elementor_editor_scripts']);
        }

        // Frontend styles
        public function load_styles_frontend() {
            wp_enqueue_style('bootstrap_min_css', TTHIEUDEV_PLUGIN_URI . "assets/css/library/bootstrap.min.css", [], '1.0.0', 'all');
            wp_enqueue_style('font_awesome_cdn', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css", [], '6.6.0', 'all');
            wp_enqueue_style('wrapper', TTHIEUDEV_PLUGIN_URI . "assets/css/frontend/wrapper.css", [], '1.0.0', 'all');
            wp_enqueue_style('style-archive-project', TTHIEUDEV_PLUGIN_URI . "assets/css/frontend/archive-project.css", [], '1.0.0', 'all');
            wp_enqueue_style('style-single-project', TTHIEUDEV_PLUGIN_URI . "assets/css/frontend/single-project.css", [], '1.0.0', 'all');
            wp_enqueue_style('style-pagination', TTHIEUDEV_PLUGIN_URI . "assets/css/frontend/pagination.css", [], '1.0.0', 'all');
        }

        // Frontend scripts
        public function load_scripts_frontend() {
            wp_enqueue_script('jquery_js', TTHIEUDEV_PLUGIN_URI . "assets/js/library/jquery-3.7.1.js", ['jquery'], '1.0.0', true);
            wp_enqueue_script('bootstrap_min_js', TTHIEUDEV_PLUGIN_URI . "assets/js/library/bootstrap.min.js", ['jquery'], '1.0.0', true);
            wp_localize_script('jquery_js', 'ajaxurl', ['baseURL' => admin_url('admin-ajax.php')]);
        }

        // Admin styles
        public function load_styles_admin() {
            wp_enqueue_style('font_awesome_cdn', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css", [], '6.6.0', 'all');
            wp_enqueue_style('style-setting-project', TTHIEUDEV_PLUGIN_URI . "assets/css/admin/setting-project.css", [], '1.0.0', 'all');
            wp_enqueue_style('style-list-project', TTHIEUDEV_PLUGIN_URI . "assets/css/admin/list-project.css", [], '1.0.0', 'all');
        }

        // Admin scripts
        public function load_scripts_admin() {
            wp_enqueue_script('bootstrap_min_js', TTHIEUDEV_PLUGIN_URI . "assets/js/library/bootstrap.min.js", ['jquery'], '1.0.0', true);
            wp_enqueue_script('setting_project', TTHIEUDEV_PLUGIN_URI . "assets/js/admin/setting-project.js", ['jquery'], '1.0.0', true);
            wp_enqueue_script('list_project', TTHIEUDEV_PLUGIN_URI . "assets/js/admin/list-project.js", ['jquery'], '1.0.0', true);
            wp_localize_script('jquery_js', 'ajaxurl', ['baseURL' => admin_url('admin-ajax.php')]);
        }

        // Elementor editor styles and scripts
        public function enqueue_elementor_editor_scripts() {
            wp_enqueue_script('tthieudev-editor', TTHIEUDEV_PLUGIN_URI . 'assets/js/elementors/max-post.js', ['jquery', 'elementor-editor'], '1.0.0', true);
            wp_enqueue_style('widget_get_list_project_css_editor', TTHIEUDEV_PLUGIN_URI . "assets/css/elementors/widget-get-list-project.css", [], '1.0.0', 'all');
            wp_localize_script('tthieudev-editor', 'tthieudev', ['ajax_url' => admin_url('admin-ajax.php'), 'security_tthieu' => wp_create_nonce('tthieudev-security-ajax-max')]);
        }

        // Frontend Elementor assets
        public function enqueue_frontend_assets() {
            wp_enqueue_style('widget_get_list_project_css', TTHIEUDEV_PLUGIN_URI . "assets/css/elementors/widget-get-list-project.css", [], '1.0.0', 'all');
            wp_enqueue_style('shortcode_get_list_project_css', TTHIEUDEV_PLUGIN_URI . "assets/css/elementors/shortcode-list-project.css", [], '1.0.0', 'all');
            wp_enqueue_style('widget_mailer_project', TTHIEUDEV_PLUGIN_URI . "assets/css/elementors/widget-mailer.css", [], '1.0.0', 'all');
            wp_enqueue_script('shortcode_project_js', TTHIEUDEV_PLUGIN_URI . "assets/js/elementors/short-code.js", ['jquery'], '1.0.0', true);
            wp_enqueue_script('widget_get_list_project_js', TTHIEUDEV_PLUGIN_URI . "assets/js/elementors/widget-get-list-project.js", ['jquery'], '1.0.0', true);
            wp_localize_script('widget_get_list_project_js', 'ajax_object', ['ajax_url' => admin_url('admin-ajax.php'), 'security' => wp_create_nonce('tthieudev-security-ajax')]);
        }

        // Admin Elementor assets
        public function enqueue_admin_assets() {
            wp_enqueue_style('widget_get_list_project_admin_css', TTHIEUDEV_PLUGIN_URI . "assets/css/elementors/admin-widget-get-list-project.css", [], '1.0.0', 'all');
            wp_enqueue_script('widget_get_list_project_admin_js', TTHIEUDEV_PLUGIN_URI . "assets/js/elementors/admin-widget-get-list-project.js", ['jquery'], '1.0.0', true);
        }

    }
    return new TthieuDev_Assets();
}

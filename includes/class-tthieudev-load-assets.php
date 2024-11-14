<?php
if (!defined('ABSPATH')) {
    exit;
}

if ( ! defined( 'PLUGIN_URI' ) ) {
    define( 'PLUGIN_URI', rtrim( plugin_dir_url( dirname( __FILE__ ) ), '/' ) . '/' );
}

if ( ! class_exists( 'Class_Tthieudev_Load_Assets' ) ) {
    class Class_Tthieudev_Load_Assets {
        public function __construct() {
            //  frontend
            add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );
            //  backend (admin)
            add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
        }

        public function load_assets() {
            wp_enqueue_style( 'bootstrap_min_css', PLUGIN_URI . "assets/css/library/bootstrap.min.css", array(), '1.0.0', 'all' );
            wp_enqueue_style( 'font_awesome_cdn', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css", array(), '6.6.0', 'all' );
            wp_enqueue_style( 'wrapper', PLUGIN_URI . "assets/css/frontend/wrapper.css", array(), '1.0.0', 'all' );
            wp_enqueue_style( 'style-archive-project', PLUGIN_URI . "assets/css/frontend/archive-project.css", array(), '1.0.0', 'all' );
            wp_enqueue_style( 'style-single-project', PLUGIN_URI . "assets/css/frontend/single-project.css", array(), '1.0.0', 'all' );

            // Nạp các file JS
            wp_enqueue_script( 'jquery_js', PLUGIN_URI . "assets/js/library//jquery-3.7.1.js", array( 'jquery' ), '1.0.0', true );
            wp_enqueue_script( 'bootstrap_min_js', PLUGIN_URI . "assets/js/library/bootstrap.min.js", array( 'jquery' ), '1.0.0', true );

            // Cung cấp biến `ajaxurl` cho JavaScript để thực hiện các yêu cầu AJAX
            wp_localize_script( 'my_script', 'ajaxurl', array(
                'baseURL' => admin_url( 'admin-ajax.php' )
            ) );
        }
    }
}
if ( class_exists( 'Class_Tthieudev_Load_Assets' ) ) {
    $project_plugin = new Class_Tthieudev_Load_Assets();
}

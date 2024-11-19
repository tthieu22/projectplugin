<?php

if ( ! defined( 'ABSPATH' ) ) { 
    exit; 
}


final class Tthieudev_Elementor { 
    const VERSION = '1.0.0';
    const MINIMUM_ELEMENTOR_VERSION  = '3.7.0';
    const MINIMUM_PHP_VERSION = '7.0.0';
    private static $_instance  = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        if ( $this->is_compatible() ) {
            $this->include_files();
            add_action( 'elementor/init', [ $this, 'init' ] );        }
    }
    public function include_files() {
        require_once PLUGIN_PATH . 'includes/class-tthieudev-scripts-styles-elementor.php';
        require_once PLUGIN_PATH . 'includes/class-tthieudev-ajax.php';
        require_once PLUGIN_PATH . 'includes/class-tthieudev-widget-manager.php';
    }

    public function init() {
        new Tthieudev_Scripts_Styles_Elementor();
        new Tthieudev_Ajax();
        new Tthieudev_Widget_Manager();
    }
    
    public function is_compatible() {
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
            return false;
        }
        // Kiểm tra phiên bản Elementor tối thiểu
        if ( ! defined( 'ELEMENTOR_VERSION' ) || ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return false;
        }
        if ( ! version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION , '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return false;
        }
        return true;
    }

    public function admin_notice_missing_main_plugin() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'tthieudev' ),
            '<strong>' . esc_html__( 'ELEMENTOR ADDON SHARE', 'tthieudev' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'tthieudev' ) . '</strong>'
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function admin_notice_minimum_elementor_version() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            esc_html__( '"%1$s" requires Elementor version "%2$s" or greater.', 'tthieudev' ),
            '<strong>' . esc_html__( 'ELEMENTOR ADDON SHARE', 'tthieudev' ) . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function admin_notice_minimum_php_version() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            esc_html__( '"%1$s" requires PHP version "%2$s" or greater.', 'tthieudev' ),
            '<strong>' . esc_html__( 'ELEMENTOR ADDON SHARE', 'tthieudev' ) . '</strong>',
            self::MINIMUM_PHP_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }


}
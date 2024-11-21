<?php

if ( ! defined( 'ABSPATH' ) ) { 
    exit; 
}

/**
 * Main class for the Tthieudev Elementor Addon.
 */
final class Tthieudev_Elementor { 
    const VERSION = '1.0.0'; // Plugin version
    const MINIMUM_ELEMENTOR_VERSION  = '3.7.0'; // Minimum Elementor version required
    const MINIMUM_PHP_VERSION = '7.0.0'; // Minimum PHP version required

    private static $_instance  = null; // Singleton instance of the class

    /**
     * Get the singleton instance of the class.
     *
     * @return Tthieudev_Elementor Instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor.
     * Checks compatibility and initializes the plugin.
     */
    public function __construct() {
        if ( $this->is_compatible() ) {
            $this->include_files();
            add_action( 'elementor/init', [ $this, 'init' ] );
        }
    }

    /**
     * Include required files for the plugin.
     */
    public function include_files() {
        require_once PLUGIN_PATH . 'includes/class-tthieudev-scripts-styles-elementor.php';
        require_once PLUGIN_PATH . 'includes/class-tthieudev-ajax.php';
        require_once PLUGIN_PATH . 'includes/class-tthieudev-widget-manager.php';
    }

    /**
     * Initialize the plugin components.
     */
    public function init() {
        new Tthieudev_Scripts_Styles_Elementor();
        new Tthieudev_Ajax();
        new Tthieudev_Widget_Manager();
    }
    
    /**
     * Check compatibility of the plugin with Elementor and PHP versions.
     *
     * @return bool True if compatible, otherwise false.
     */
    public function is_compatible() {
        // Check if Elementor is loaded.
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
            return false;
        }

        // Check Elementor version.
        if ( ! defined( 'ELEMENTOR_VERSION' ) || ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return false;
        }

        // Check PHP version.
        if ( ! version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION , '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return false;
        }

        return true;
    }

    /**
     * Display an admin notice if Elementor is not installed or activated.
     */
    public function admin_notice_missing_main_plugin() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'tthieudev' ),
            '<strong>' . esc_html__( 'ELEMENTOR ADDON SHARE', 'tthieudev' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'tthieudev' ) . '</strong>'
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
     * Display an admin notice if Elementor version is lower than required.
     */
    public function admin_notice_minimum_elementor_version() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            esc_html__( '"%1$s" requires Elementor version "%2$s" or greater.', 'tthieudev' ),
            '<strong>' . esc_html__( 'ELEMENTOR ADDON SHARE', 'tthieudev' ) . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
     * Display an admin notice if PHP version is lower than required.
     */
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

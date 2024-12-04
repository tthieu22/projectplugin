<?php defined('ABSPATH') || exit;

/**
 * Main Project Plugin Class.
 *
 * @class TthieuDev_Project
 */
final class TthieuDev_Project {
    /**
     * Project plugin version.
     *
     * @var string|null
     */
    public $version = null;

    /**
     * The single instance of the class.
     *
     * @var TthieuDev_Project|null
     */
    protected static $_instance = null;

    /**
     * Main Project Instance.
     *
     * @return TthieuDev_Project The single instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor method to initialize the plugin.
     * Sets the version, defines constants, and includes necessary files.
     */
    public function __construct() {
        $this->version = $this->set_version();
        $this->define_constants();
        $this->includes();
        $this->init_hooks();
    }

    /**
     * Set plugin version.
     *
     * @return string The version of the plugin.
     */
    private function set_version() {
        return '1.0.0';
    }

    /**
     * Define plugin constants.
     */
    private function define_constants() {
        $this->define( 'TTHIEUDEV_PLUGIN_PATH', plugin_dir_path(TTHIEUDEV_PLUGIN_FILE));
        $this->define( 'TTHIEUDEV_PLUGIN_URI', plugin_dir_url(TTHIEUDEV_PLUGIN_FILE));
        $this->define( 'TTHIEUDEV_PLUGIN_INC', TTHIEUDEV_PLUGIN_PATH .'includes/' );
        $this->define( 'TTHIEUDEV_PLUGIN_TEXTDOMAIN', 'tthieudev-project' );
        $this->define( 'TTHIEUDEV_PLUGIN_LANG_PATH', dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Include necessary files for the plugin.
     * This includes various PHP files for different functionalities.
     */
    public function includes() {

        // Core functions
        require_once TTHIEUDEV_PLUGIN_INC . 'tthieudev-core-functions.php';

        // Ajax handler
        require_once TTHIEUDEV_PLUGIN_INC . 'class-tthieudev-ajax.php';

        // Cron jobs
        require_once TTHIEUDEV_PLUGIN_INC . 'class-tthieudev-cron.php';

        // Custom roles
        require_once TTHIEUDEV_PLUGIN_INC . 'class-tthieudev-custom-role.php';

        if ( is_admin() ) {
            
        }
        // Elementor helper
        require_once TTHIEUDEV_PLUGIN_INC . 'class-tthieudev-elementor-helper.php';

        // Elementor integration
        require_once TTHIEUDEV_PLUGIN_INC . 'class-tthieudev-elementor.php';

        // Load assets
        require_once TTHIEUDEV_PLUGIN_INC . 'class-tthieudev-assets.php';

        // Mail handling
        require_once TTHIEUDEV_PLUGIN_INC . 'class-tthieudev-mail.php';

        // ACF for projects
        require_once TTHIEUDEV_PLUGIN_INC . 'class-tthieudev-project-advance-custom-field.php';

        // Custom post type for projects
        require_once TTHIEUDEV_PLUGIN_INC . 'class-tthieudev-project-custom-post-type.php';

        // Project list table (admin)
        require_once TTHIEUDEV_PLUGIN_INC . 'class-tthieudev-project-list-table.php';

        // Project settings
        require_once TTHIEUDEV_PLUGIN_INC . 'class-tthieudev-project-setting.php';

        // Project template loader
        require_once TTHIEUDEV_PLUGIN_INC . 'class-tthieudev-project-template-loader.php';

        // Shortcode handler
        require_once TTHIEUDEV_PLUGIN_INC . 'class-tthieudev-shortcore-handler.php';

        // Custom user fields
        require_once TTHIEUDEV_PLUGIN_INC . 'class-tthieudev-user-custom-fields.php';

        
    }

    /**
     * Initialize hooks for actions and filters.
     */
    private function init_hooks() {
        add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
    }

    /**
     * Hook into the plugins_loaded action.
     */
    public function plugins_loaded() {
        // Load text domain for translation.
        load_plugin_textdomain( TTHIEUDEV_PLUGIN_TEXTDOMAIN, false, TTHIEUDEV_PLUGIN_LANG_PATH );
    }

    /**
     * Define constant if not already set.
     *
     * @param string      $name  Constant name.
     * @param string|bool $value Constant value.
     */
    private function define( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
        }
    }
}

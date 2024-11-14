<?php
if (!defined('ABSPATH')) {
    exit;
}

if ( ! defined( 'PLUGIN_PATH' ) ) {
    define( 'PLUGIN_PATH', rtrim( plugin_dir_path( dirname( __FILE__ ) ), '/' ) . '/' );
}

if(!class_exists('Class_Tthieudev_Setting_Project')){
    class Class_Tthieudev_Setting_Project{
        public function __construct() {
            add_action('admin_menu',array($this,'custom_admin_menu'));
        }
        function custom_admin_menu(){
            add_menu_page( 'Setting Project', 'Setting Project', 'manage_options', 'setting_project', array( $this, 'render_setting_project' ), '', 10 );
            add_submenu_page( 'setting_project','Add Setting Page', 'Add Setting', 'manage_options', 'add_setting',  array( $this, 'render_add_setting' ), 1 );

        } 

        // Main Settings Page Content
        public function render_setting_project() {
            echo '<h1>Setting Project Page</h1>';
        }

        // Submenu "Add Setting" Content
        public function render_add_setting() {
            echo '<h1>Add Setting Page</h1>';
        }
    }
}

if ( class_exists( 'Class_Tthieudev_Setting_Project' ) ) {
    $setting_project = new Class_Tthieudev_Setting_Project();
}

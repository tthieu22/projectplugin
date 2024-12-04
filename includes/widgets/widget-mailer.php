<?php defined('ABSPATH') || exit;

use Elementor\Widget_Base;
class Widget_Mailer extends Widget_Base {
     public function get_name() {
        return 'mailer-project';
    }

    public function get_title() {
        return esc_html__( 'Mail Project', 'tthieudev' );
    }

    public function get_icon() {
        return 'eicon-unread';
    }

    public function get_categories() {
        return [ 'project_tthieudev' ];
    }
    protected function render() {
        tthieudev_get_template('forms/form-mailer-widget.php');
    }

}
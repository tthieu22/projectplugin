<?php defined( 'ABSPATH' ) || exit;

if (!class_exists('TthieuDev_Project_Setting')) {
    class TthieuDev_Project_Setting {
        public function __construct() {
            add_action('admin_post_save_project_settings', array($this, 'save_settings'));
            add_action('pre_get_posts', array($this, 'set_posts_per_page_for_archive'));

        }
        public function save_settings() {
            if (!current_user_can('manage_options')) {
                return;
            }
            if (!isset($_POST['project_settings_nonce']) || !wp_verify_nonce($_POST['project_settings_nonce'], 'save_project_settings')) {
                return;
            }

            if (isset($_POST['submit_single_settings'])) {
                update_option('checked-show-category-single', isset($_POST['checked-show-category-single']) ? '1' : '0');
                update_option('checked-show-tag-single', isset($_POST['checked-show-tag-single']) ? '1' : '0');
                update_option('checked-show-sub-title', isset($_POST['checked-show-sub-title']) ? '1' : '0');
                update_option('checked-show-client', isset($_POST['checked-show-client']) ? '1' : '0');
                update_option('checked-show-date', isset($_POST['checked-show-date']) ? '1' : '0');
                update_option('checked-show-value', isset($_POST['checked-show-value']) ? '1' : '0');
                update_option('checked-show-image', isset($_POST['checked-show-image']) ? '1' : '0');
            }

            if (isset($_POST['submit_archive_settings'])) {
                update_option('checked-show-pagination', isset($_POST['checked-show-pagination']) ? '1' : '0');
                update_option('checked-show-title-archive', isset($_POST['checked-show-title-archive']) ? '1' : '0');
                update_option('checked-show-category-archive', isset($_POST['checked-show-category-archive']) ? '1' : '0');
                update_option('checked-show-tag-archive', isset($_POST['checked-show-tag-archive']) ? '1' : '0');
                update_option('page-number', isset($_POST['page-number']) ? intval($_POST['page-number']) : 3);
            }
            if (isset($_POST['submit_email_settings'])) {
                // All
                update_option('send_from_email', isset($_POST['send_from_email']) ? sanitize_email($_POST['send_from_email']) : '');
                update_option('recipient', isset($_POST['recipient']) ? sanitize_text_field($_POST['recipient']) : ['']);
                update_option('thank_you_page', isset($_POST['thank_you_page']) ? intval($_POST['thank_you_page']) : '');
                update_option('error_page', isset($_POST['error_page']) ? intval($_POST['error_page']) : '');   
                // Admin
                update_option('subject_admin', isset($_POST['subject_admin']) ? sanitize_text_field($_POST['subject_admin']) : '');
                update_option('from_name_admin', isset($_POST['from_name_admin']) ? sanitize_text_field($_POST['from_name_admin']) : '');
                update_option('message_admin', isset($_POST['message_admin']) ? wp_kses_post($_POST['message_admin']) : '');
                // Customer
                update_option('subject_customer', isset($_POST['subject_customer']) ? sanitize_text_field($_POST['subject_customer']) : '');
                update_option('from_name_customer', isset($_POST['from_name_customer']) ? sanitize_text_field($_POST['from_name_customer']) : '');
                update_option('message_customer', isset($_POST['message_customer']) ? wp_kses_post($_POST['message_customer']) : '');
                // Mail option
                
                if (isset($_POST['mail_option']) && in_array($_POST['mail_option'], ['admin', 'customer', 'both'])) {
                    update_option('mail_option', wp_kses_post($_POST['mail_option']));
                } else {
                    update_option('mail_option', 'both'); 
                }
            }
            if (isset($_POST['submit_cron_project_settings'])) {
                update_option('cron_enable', isset($_POST['cron_enable']) ? '1' : '0');
                update_option('x_day_pick_up', isset($_POST['x_day_pick_up']) ? sanitize_text_field($_POST['x_day_pick_up']) : '');
                update_option('recurring_email_every_x_seconds', isset($_POST['recurring_email_every_x_seconds']) ? sanitize_text_field($_POST['recurring_email_every_x_seconds']) : '');
                
                update_option('subject_mail_cron', isset($_POST['subject_mail_cron']) ? sanitize_text_field($_POST['subject_mail_cron']) : '');
                update_option('from_name_cron', isset($_POST['from_name_cron']) ? sanitize_text_field($_POST['from_name_cron']) : '');
                update_option('from_mail_cron', isset($_POST['from_mail_cron']) ? sanitize_text_field($_POST['from_mail_cron']) : '');
                update_option('message_mail_cron', isset($_POST['message_mail_cron']) ? wp_kses_post($_POST['message_mail_cron']) : '');

            }
            wp_redirect(add_query_arg('settings-updated', 'true', wp_get_referer()));
            exit;
        }

        public function set_posts_per_page_for_archive($query) {
            if ((is_post_type_archive('project') || is_tax('project_category') || is_tax('project_tag')) && !is_admin() && $query->is_main_query()) {
                $posts_per_page = get_option('page-number', 3);

                if (isset($_GET['total']) && is_numeric($_GET['total'])) {
                    $posts_per_page = $_GET['total'];
                }

                $query->set('posts_per_page', $posts_per_page);
                $query->set('orderby', 'meta_value_num');
                $query->set('order', 'DESC');
                $query->set('meta_type', 'NUMERIC');
            }
        }
    }
    return new TthieuDev_Project_Setting();
}

<?php defined( 'ABSPATH' ) || exit;

if (!class_exists('TthieuDev_Cron')) {
    class TthieuDev_Cron {
        public function __construct() {
            add_action('init', [$this, 'register_cron_job']);
            add_action('bl_cron_hook', [$this, 'cron_update_status_send_mail']);
            add_filter('cron_schedules', [$this, 'custom_cron_schedule']);
            register_deactivation_hook(__FILE__, [$this, 'deactivate_cron_job']);
        }

        public function custom_cron_schedule($schedules) {
            $time_recurring = get_option('recurring_email_every_x_seconds', 300);
            
            if (!is_numeric($time_recurring) || $time_recurring <= 0) {
                $time_recurring = 300;
            }

            $old_schedule = get_option('old_cron_schedule');
            if ($old_schedule && $old_schedule !== $time_recurring) {
                wp_clear_scheduled_hook('bl_cron_hook');
            }

            $schedules['every_' . $time_recurring . '_seconds'] = array(
                'interval' => $time_recurring,
                'display'  => __('Every ' . $time_recurring . ' seconds')
            );

            update_option('old_cron_schedule', $time_recurring);

            return $schedules;
        }

        public function register_cron_job() {
            $enable = get_option('cron_enable', '0');
            $time_recurring = get_option('recurring_email_every_x_seconds', 300);
            
            if ($enable == '1') {
                $cron_schedule = 'every_' . $time_recurring . '_seconds';
                if (!wp_next_scheduled('bl_cron_hook')) {
                    wp_schedule_event(time(), $cron_schedule, 'bl_cron_hook');
                }
            } else {
                wp_clear_scheduled_hook('bl_cron_hook');
            }
        }

        public function cron_update_status_send_mail() {
            $time_after_start = (int) get_option('x_day_pick_up', 1); 
            $time_after_start *= 60; 
            $current_time = current_time('timestamp');

            global $wpdb;
            $table_postmeta = $wpdb->prefix . 'postmeta';
            $table_posts = $wpdb->prefix . 'posts';

            $query_select = $wpdb->prepare(
                "SELECT DISTINCT p.ID
                 FROM {$table_posts} p
                 JOIN {$table_postmeta} sm ON p.ID = sm.post_id AND sm.meta_key = 'status' AND sm.meta_value = 'processing'
                 JOIN {$table_postmeta} cd ON p.ID = cd.post_id AND cd.meta_key = 'created_date' AND cd.meta_value REGEXP '^[0-9]+$'
                 WHERE p.post_status = 'publish'
                   AND %d - CAST(cd.meta_value AS UNSIGNED) >= %d",
                $current_time,
                $time_after_start
            );

            $post_ids = $wpdb->get_col($query_select);

            if (!empty($post_ids)) {
                $placeholders = implode(',', array_fill(0, count($post_ids), '%d'));
                $query_update = $wpdb->prepare(
                    "UPDATE {$table_postmeta}
                     SET meta_value = 'pending'
                     WHERE meta_key = 'status'
                       AND post_id IN ($placeholders)",
                    ...$post_ids
                );

                $updated_rows = $wpdb->query($query_update);

                if ($updated_rows > 0) {
                    foreach ($post_ids as $post_id) {
                        $data = [
                            'email'         => get_post_meta($post_id, 'email', true),
                            'time'          => get_the_time('', $post_id),
                            'title'         => get_the_title($post_id),
                            'status'        => get_post_meta($post_id, 'status', true),
                            'phone'         => get_post_meta($post_id, 'phone', true),
                            'first_name'    => get_post_meta($post_id, 'first_name', true),
                            'last_name'     => get_post_meta($post_id, 'last_name', true),
                            'project_id'    => get_post_meta($post_id, 'project_id', true),
                            'address'       => get_post_meta($post_id, 'address', true),
                            'information'   => get_post_meta($post_id, 'information', true),
                        ];

                        if (!empty($data['email'])) { 
                            TthieuDev_Mail::send_email_update_order($data);
                            // error_log("Email order ID: $post_id");
                        } else {
                            error_log("Email not found for order ID: $post_id");
                        }
                    }

                    error_log("Updated $updated_rows orders to 'pending' status.");
                } else {
                    error_log("No orders found to update.");
                }
            } else {
                error_log("No orders found to update.");
            }

            wp_reset_postdata();
        }

        public function deactivate_cron_job() {
            $timestamp = wp_next_scheduled('bl_cron_hook');
            if ($timestamp) {
                $unscheduled = wp_unschedule_event($timestamp, 'bl_cron_hook');
                if (!$unscheduled) {
                    error_log("Failed to unschedule cron job.");
                }
            }
        }
    }
    return new TthieuDev_Cron();
}
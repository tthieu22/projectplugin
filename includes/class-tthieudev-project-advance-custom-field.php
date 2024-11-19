<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Class_TthieuDev_Project_Advance_Custom_Field' ) ) {
    class Class_TthieuDev_Project_Advance_Custom_Field {
        public function __construct() {
            add_action('add_meta_boxes', [$this, 'add_project_meta_box']);
            add_action('save_post', [$this, 'save_project_meta_box']);
        }

        public function add_project_meta_box() {
            add_meta_box(
                'project_details',                  // ID 
                __('Project Details', 'tthieudev'), // Title
                [$this, 'display_project_meta_box'],// function callback show display meta boxes
                'project',                          // Post Type to which the meta box is added
                'normal',                           // Display position (normal, side, advanced)
                'high'                              // Display priority
            );
        }

        public function display_project_meta_box($post) {
            $sub_title = get_post_meta($post->ID, 'sub_title', true);
            $client = get_post_meta($post->ID, 'client', true);
            $date = get_post_meta($post->ID, 'date', true);
            $value = get_post_meta($post->ID, 'value', true);

            // Nonce field for security
            wp_nonce_field(basename(__FILE__), 'project_meta_box_nonce');

            ?>
            <p>
                <label for="sub_title"><?php esc_html_e('Sub Title', 'tthieudev'); ?></label>
                <input type="text" name="sub_title" id="sub_title" value="<?php echo esc_attr($sub_title); ?>" class="widefat">
            </p>
            <p>
                <label for="client"><?php esc_html_e('Client', 'tthieudev'); ?></label>
                <input type="text" name="client" id="client" value="<?php echo esc_attr($client); ?>" class="widefat">
            </p>
            <p>
                <label for="date"><?php esc_html_e('Date', 'tthieudev'); ?></label>
                <input type="date" name="date" id="date" value="<?php echo esc_attr($date); ?>" class="widefat">
            </p>
            <p>
                <label for="value"><?php esc_html_e('Value', 'tthieudev'); ?></label>
                <input type="text" name="value" id="value" value="<?php echo esc_attr($value); ?>" class="widefat">
            </p>
            <?php
        }

        public function save_project_meta_box($post_id) {
            if (!isset($_POST['project_meta_box_nonce']) || !wp_verify_nonce($_POST['project_meta_box_nonce'], basename(__FILE__))) {
                return $post_id;
            }
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
            $fields = ['sub_title', 'client', 'date', 'value'];
            foreach ($fields as $field) {
                $new_value = isset($_POST[$field]) ? sanitize_text_field($_POST[$field]) : '';
                update_post_meta($post_id, $field, $new_value);
            }
        }

    }

}
if (class_exists('Class_TthieuDev_Project_Advance_Custom_Field')) {
    new Class_TthieuDev_Project_Advance_Custom_Field();
}

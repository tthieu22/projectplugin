<?php defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'TthieuDev_Project_Advance_Custom_Field' ) ) {
    class TthieuDev_Project_Advance_Custom_Field {
        public function __construct() {
            add_action('add_meta_boxes_project', [$this, 'add_project_meta_box']);
            add_action('add_meta_boxes_project_order', [$this, 'add_order_meta_box']);
            add_action('save_post_project', [$this, 'save_project_meta_box']);
            add_action('save_post_project_order', [$this, 'save_order_meta_box']);
        }

        public function add_project_meta_box() {
            add_meta_box(
                'project_details',                  
                __('Project Details', 'tthieudev'),
                [$this, 'display_project_meta_box'],
                'project',                          
                'normal',                        
                'high'                            
            );
        }

        public function add_order_meta_box() {
            add_meta_box(
                'order_detail',                  
                __('Order Details', 'tthieudev'), 
                [$this, 'display_order_meta_box'],
                'project_order',                          
                'normal',                    
                'high'                              
            );
        }

        public function display_project_meta_box($post) {
            $sub_title = get_post_meta($post->ID, 'sub_title', true);
            $client = get_post_meta($post->ID, 'client', true);
            $date = get_post_meta($post->ID, 'date', true);
            $value = get_post_meta($post->ID, 'value', true);

            wp_nonce_field(basename(__FILE__), 'project_meta_box_nonce');

            ?>
            <p>
                <label for="sub_title"><?php esc_html_e('Sub Title', 'tthieudev'); ?></label>
                <input type="text" name="sub_title" id="sub_title" value="<?php echo esc_attr($sub_title); ?>" class="widefat"/>
            </p>
            <p>
                <label for="client"><?php esc_html_e('Client', 'tthieudev'); ?></label>
                <input type="text" name="client" id="client" value="<?php echo esc_attr($client); ?>" class="widefat"/>
            </p>
            <p>
                <label for="date"><?php esc_html_e('Date', 'tthieudev'); ?></label>
                <input type="date" name="date" id="date" value="<?php echo esc_attr($date); ?>" class="widefat"/>
            </p>
            <p>
                <label for="value"><?php esc_html_e('Value', 'tthieudev'); ?></label>
                <input type="number" name="value" id="value" value="<?php echo esc_attr($value); ?>" class="widefat"/>
            </p>
            <?php
        }

        public function display_order_meta_box($post) {
            $first_name = get_post_meta($post->ID, 'first_name', true);
            $last_name = get_post_meta($post->ID, 'last_name', true);
            $phone = get_post_meta($post->ID, 'phone', true);
            $email = get_post_meta($post->ID, 'email', true);
            $address = get_post_meta($post->ID, 'address', true);
            $selected_project = get_post_meta($post->ID, 'project', true);
            $information = get_post_meta($post->ID, 'information', true);
            $status = get_post_meta($post->ID, 'status', true);
            wp_nonce_field(basename(__FILE__), 'mailer_project_nonce');

            // Hiển thị các trường
            ?>
            <p>
                <label for="first_name"><?php esc_html_e('First Name', 'tthieudev'); ?></label>
                <input type="text" name="first_name" id="first_name" value="<?php echo esc_attr($first_name); ?>" class="widefat"/>
            </p>
            <p>
                <label for="last_name"><?php esc_html_e('Last Name', 'tthieudev'); ?></label>
                <input type="text" name="last_name" id="last_name" value="<?php echo esc_attr($last_name); ?>" class="widefat"/>
            </p>
            <p>
                <label for="phone"><?php esc_html_e('Phone', 'tthieudev'); ?></label>
                <input type="number" name="phone" id="phone" value="<?php echo esc_attr($phone); ?>" class="widefat"/>
            </p>
            <p>
                <label for="email"><?php esc_html_e('Email', 'tthieudev'); ?></label>
                <input type="email" name="email" id="email" value="<?php echo esc_attr($email); ?>" class="widefat"/>
            </p>
            <p>
                <label for="address"><?php esc_html_e('Address', 'tthieudev'); ?></label>
                <input type="text" name="address" id="address" value="<?php echo esc_attr($address); ?>" class="widefat"/>
            </p>
            <p>
                <label for="project"><?php esc_html_e('Project', 'tthieudev'); ?></label>
                <select name="project" id="project" class="widefat">
                    <option value="" disabled><?php esc_html_e('Select a project', 'tthieudev'); ?></option>
                    <?php
                    $projects = get_posts([
                        'post_type'      => 'project', 
                        'posts_per_page' => -1,        
                        'orderby'        => 'title',  
                        'order'          => 'ASC',
                    ]);
                    foreach ($projects as $project) {
                        $selected = selected($selected_project, $project->ID, false); 
                        echo '<option value="' . esc_attr($project->ID) . '" ' . $selected . '>' . esc_html($project->post_title) . '</option>';
                    }
                    ?>
                </select>

            </p>

            <p>
                <label for="information"><?php esc_html_e('Addition information', 'tthieudev'); ?></label>
                <textarea name="information" id="information" rows="7" cols="50" class="widefat"><?php echo esc_textarea($information); ?></textarea>
            </p>
                <label for="status"><?php esc_html_e('Status', 'tthieudev'); ?></label><br>
                <select name="status" id="status">
                    <option value="pending" <?php selected($status, 'pending'); ?>><?php esc_html_e('Pending', 'tthieudev'); ?></option>
                    <option value="processing" <?php selected($status, 'processing'); ?>><?php esc_html_e('Processing', 'tthieudev'); ?></option>
                    <option value="completed" <?php selected($status, 'completed'); ?>><?php esc_html_e('Completed', 'tthieudev'); ?></option>
                </select>
            </p>
            <?php
        }

        public function save_project_meta_box($post_id) {
            // Verify nonce for security
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

        public function save_order_meta_box($post_id) {
            // Verify nonce for security
            if (!isset($_POST['mailer_project_nonce']) || !wp_verify_nonce($_POST['mailer_project_nonce'], basename(__FILE__))) {
                return $post_id;
            }
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
            $fields = ['first_name', 'last_name', 'phone', 'email','address','project','information','status','order_time'];
            foreach ($fields as $field) {
                $new_value = isset($_POST[$field]) ? sanitize_text_field($_POST[$field]) : '';
                update_post_meta($post_id, $field, $new_value);
            }
        }


    }
    return new TthieuDev_Project_Advance_Custom_Field();
}

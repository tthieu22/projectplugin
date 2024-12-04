<?php defined( 'ABSPATH' ) || exit;

if (!class_exists('TthieuDev_Custom_Role')) {
    class TthieuDev_Custom_Role {
        public function __construct() {
            add_action('init', [$this, 'create_project_order_manager_role']);
            // add_action('admin_menu', [$this, 'restrict_admin_menu']);
            // add_action('admin_init', [$this, 'restrict_admin_pages']);
            // add_action('admin_init', 'add_order_caps');
            register_deactivation_hook(__FILE__, [$this, 'remove_project_order_manager_role']);
        }

        public function create_project_order_manager_role() {
            if (!get_role('project_order_manager')) {
                add_role('project_order_manager', __('Project Order Manager', 'tthieudev'), [
                    'read' => true,
                    'edit' => true,
                ]);
            }

            $role = get_role('project_order_manager');
            if ($role) {
                $project_capabilities = [
                    'edit_project', 'edit_projects', 'edit_others_projects', 'publish_projects',
                    'read_project', 'read_private_projects', 'delete_projects', 'delete_others_projects',
                    'create_project', 'delete_private_projects', 'delete_published_projects', 'edit_private_projects',
                    'edit_published_projects', 'manage_project_terms', 'assign_project_terms'
                ];
                foreach ($project_capabilities as $capability) {
                    $role->add_cap($capability);
                }
            }
        }

        public function restrict_admin_menu() {
            if (current_user_can('project_order_manager')) {
                global $menu;
                $allowed = ['edit.php?post_type=project', 'edit.php?post_type=order', 'post'];

                foreach ($menu as $key => $item) {
                    if (!in_array($item[2], $allowed)) {
                        unset($menu[$key]);
                    }
                }
            }
        }

        public function restrict_admin_pages() {
            if (current_user_can('project_order_manager')) {
                $screen = get_current_screen();
                if ($screen && !in_array($screen->post_type, ['project', 'order'])) {
                    wp_redirect(admin_url('edit.php?post_type=project'));
                    exit;
                }
            }
        }
        function add_order_caps() {
            $role = get_role('administrator');
            $role->add_cap('edit_orders'); // Cho phép chỉnh sửa đơn hàng
            $role->add_cap('delete_orders'); // Cho phép xóa đơn hàng
            $role->remove_cap('create_orders'); // Hủy bỏ quyền tạo đơn hàng
        }

        public function remove_project_order_manager_role() {
            remove_role('project_order_manager');
        }
    }

    return new TthieuDev_Custom_Role();
}
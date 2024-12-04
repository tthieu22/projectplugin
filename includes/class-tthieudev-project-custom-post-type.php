<?php defined( 'ABSPATH' ) || exit;

if (!class_exists('TthieuDev_Project_Custom_Post_Type')) {
    class TthieuDev_Project_Custom_Post_Type {
        public function __construct() {
            $actions = [
                'init' => ['register_cpt_project', 'register_taxonomies', 'register_cpt_order'],
                'admin_menu' => ['custom_admin_menu', 'menu_wplist_project', 'add_project_order_submenu'],
            ];

            foreach ($actions as $hook => $methods) {
                foreach ((array)$methods as $method) {
                    add_action($hook, [$this, $method]);
                }
            }
        }


        public function register_cpt_project() {
            $labels = [
                "name" => esc_html__("Projects", "tthieudev"),
                "singular_name" => esc_html__("Project", "tthieudev"),
                "menu_name" => esc_html__("All Project", "tthieudev"),
                "add_new" => esc_html__("Add New Project", "tthieudev"),
                "edit_item" => esc_html__("Edit Project", "tthieudev"),
                "view_item" => esc_html__("View Project", "tthieudev"),
                "search_items" => esc_html__("Search Projects", "tthieudev"),
                "not_found" => esc_html__("No Projects found", "tthieudev"),
            ];

            $args = [
                "label" => esc_html__("Projects", "tthieudev"),
                "labels" => $labels,
                "public" => true,
                "show_ui" => true,
                "show_in_rest" => true,
                "has_archive" => true,
                "rewrite" => ["slug" => "project", "with_front" => true],
                "supports" => ["title", "editor", "thumbnail", "page-attributes"],
                "taxonomies" => ["project_category", "project_tag"],
                'menu_icon' => 'dashicons-archive',
            ];

            register_post_type("project", $args);
        }

        public function register_cpt_order() {
            $labels = [
                "name" => esc_html__("Orders", "tthieudev"),
                "singular_name" => esc_html__("Order", "tthieudev"),
                "menu_name" => esc_html__("All Order", "tthieudev"),
                "add_new" => esc_html__("Add New Order", "tthieudev"),  
                "edit_item" => esc_html__("Edit Order", "tthieudev"),
                "view_item" => esc_html__("View Order", "tthieudev"),
                "search_items" => esc_html__("Search Orders", "tthieudev"),
                "not_found" => esc_html__("No Orders found", "tthieudev"),
            ];

            $args = [
                "label" => esc_html__("Orders", "tthieudev"),
                "labels" => $labels,
                "public" => true,
                "show_ui" => true,
                "show_in_rest" => false,
                "show_in_menu" => false,
                "has_archive" => true,
                "rewrite" => ["slug" => "project_order", "with_front" => true],
                "supports" => ["title", "editor", "thumbnail", "page-attributes"],
                'capabilities' => [
                    'create_posts' => false,
                ],
                'map_meta_cap' => true,
            ];

            register_post_type("project_order", $args);
        }
        public function add_project_order_submenu() {
            add_submenu_page(
                'edit.php?post_type=project',
                esc_html__("All Orders", "tthieudev"), 
                esc_html__("Orders", "tthieudev"), 
                'edit_posts', 
                'edit.php?post_type=project_order'
            );
        }


        public function register_taxonomies() {
            $category_labels = [
                "name" => esc_html__("Categories", "tthieudev"),
                "singular_name" => esc_html__("Category", "tthieudev"),
            ];

            $category_args = [
                "label" => esc_html__("Categories", "tthieudev"),
                "labels" => $category_labels,
                "public" => true,
                "hierarchical" => true,
                "show_in_rest" => true,
                "rewrite" => ['slug' => 'project-category', 'with_front' => true],
            ];

            register_taxonomy("project_category", ["project"], $category_args);

            $tag_labels = [
                "name" => esc_html__("Tags", "tthieudev"),
                "singular_name" => esc_html__("Tag", "tthieudev"),
            ];

            $tag_args = [
                "label" => esc_html__("Tags", "tthieudev"),
                "labels" => $tag_labels,
                "public" => true,
                "hierarchical" => false,
                "show_in_rest" => true,
                "rewrite" => ['slug' => 'project-tag', 'with_front' => true],
            ];

            register_taxonomy("project_tag", ["project"], $tag_args);

            if (function_exists('flush_rewrite_rules')) {
                flush_rewrite_rules();
            }
        }

        public function custom_admin_menu() {
            add_submenu_page(
                'edit.php?post_type=project',
                'Setting Project',
                'Setting Project',
                'manage_options',
                'setting_project',
                [$this, 'render_setting_project']
            );
        }

        public function render_setting_project() {
            tthieudev_get_template('pages/setting-layout.php');
        }

        public function menu_wplist_project() {
            add_submenu_page(
                'edit.php?post_type=project',
                'List Project',
                'List Project',
                'manage_options',
                'wp_list_project',
                [$this, 'display_project_list_table']
            );
        }

        function display_project_list_table() {
            $project_list_table = new TthieuDev_Project_List_Table();
            $project_list_table->prepare_items();
            ?>
            <div class="wrap wrapper-list-table-project">
                <h1 class="wp-heading-inline">
                    <a href="<?php echo esc_url(admin_url('admin.php?page=wp_list_project')); ?>">
                        <?php esc_html_e('Projects'); ?>
                    </a>
                </h1>
                <form method="get">
                    <?php
                    $project_list_table->search_box('Search', 'project');
                    $project_list_table->display();
                    ?>
                </form>
            </div>
            <?php
        }
    }
    return new TthieuDev_Project_Custom_Post_Type();
}

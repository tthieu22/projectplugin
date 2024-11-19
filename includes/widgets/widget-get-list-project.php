<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class List_Project extends Widget_Base {
    public function get_name() {
        return 'get_list_project';
    }

    public function get_title() {
        return esc_html__( 'List Project', 'tthieudev' );
    }

    public function get_icon() {
        return 'eicon-post-list';
    }

    public function get_categories() {
        return [ 'project_tthieudev' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'tthieudev' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'project_categories',
            [
                'label' => esc_html__('Project Categories', 'tthieudev'),
                'type' => Controls_Manager::SELECT2,
                'options' => TthieuDev_Elementor_Helper::get_project_categories(),
                'multiple' => true,
                'default' => [],
            ]
        );
        $this->add_control(
            'project_tags',
            [
                'label' => esc_html__('Project Tags', 'tthieudev'),
                'type' => Controls_Manager::SELECT2,
                'options' => TthieuDev_Elementor_Helper::get_project_tags(),
                'multiple' => true,
                'default' => [],
            ]
        );

        $this->add_control(
            'show_project_title',
            [
                'label' => esc_html__( 'Show Project Title', 'tthieudev' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'tthieudev' ),
                'label_off' => esc_html__( 'Hide', 'tthieudev' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_project_categories',
            [
                'label' => esc_html__( 'Show Project Categories', 'tthieudev' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'tthieudev' ),
                'label_off' => esc_html__( 'Hide', 'tthieudev' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_project_tags',
            [
                'label' => esc_html__( 'Show Project Tags', 'tthieudev' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'tthieudev' ),
                'label_off' => esc_html__( 'Hide', 'tthieudev' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );


        $this->add_control(
            'show_panigation_get_list',
            [
                'label' => esc_html__( 'Show Panigation', 'tthieudev' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'tthieudev' ),
                'label_off' => esc_html__( 'Hide', 'tthieudev' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__( 'Posts Per Page', 'tthieudev' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 3,
                'min' => 1,
                'max' =>  TthieuDev_Elementor_Helper::get_max_posts(),
            ]
        );
        $this->add_control(
            'column',
            [
                'label' => esc_html__( 'Column', 'tthieudev' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'max' => 4, // Đặt max động dựa vào danh mục được chọn
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $selected_categories = isset($settings['project_categories']) ? $settings['project_categories'] : [];
        $selected_tags = isset($settings['project_tags']) ? $settings['project_tags'] : [];
        $current_post_id = isset($GLOBALS['post']) ? $GLOBALS['post']->ID : 0; 
        $show_title = isset($settings['show_project_title']) ? $settings['show_project_title'] : 'yes';
        $show_categories = isset($settings['show_project_categories']) ? $settings['show_project_categories'] : 'yes';
        $show_tags = isset($settings['show_project_tags']) ? $settings['show_project_tags'] : 'yes';
        $show_panigation = isset($settings['show_panigation_get_list']) ? $settings['show_panigation_get_list'] : 'yes';
        $column = isset($settings['column']) ? $settings['column'] : 5;
        $posts_per_page = isset($settings['posts_per_page']) ? $settings['posts_per_page'] : 3;

        $col = ($column == 4) ? 4 : (($column == 3) ? 3 : (($column == 2) ? 2 : 1));
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $data_widget_get_list_project = [
            'selected_categories' => $selected_categories,
            'selected_tags' => $selected_tags,
            'show_title' => $show_title,
            'show_categories' => $show_categories,
            'show_tags' => $show_tags,
            'posts_per_page' => $posts_per_page,
            'current_post_id' => $current_post_id,
        ];
        update_option('project_settings', $data_widget_get_list_project);

        $args = [
            'post_type'      => 'project',
            'post_status'    => 'publish',
            'post__not_in'   => [$current_post_id],
            'posts_per_page' => $posts_per_page,
            'paged'          => $paged, 
        ];

        $tax_query = [];
        if (!empty($selected_categories)) {
            $tax_query[] = [
                'taxonomy' => 'project_category',
                'field'    => 'slug',
                'terms'    => $selected_categories,
                'operator' => 'IN',
            ];
        }

        if (!empty($selected_tags)) {
            $tax_query[] = [
                'taxonomy' => 'project_tag',
                'field'    => 'slug',
                'terms'    => $selected_tags,
                'operator' => 'IN',
            ];
        }

        if (!empty($tax_query)) {
            $args['tax_query'] = [
                'relation' => 'OR',
            ];
            $args['tax_query'] = array_merge($args['tax_query'], $tax_query);
        }

        $query = new WP_Query($args);

        ?>
        <div class="wrapper">
            <div class="content-archive-post gap-20" id="posts-container" style="grid-template-columns: repeat(<?php echo $col; ?>, 1fr);">
            <?php
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    TemplateLoader::get_template('item/elementors/list-project-display.php');
                endwhile;
                wp_reset_postdata();
                
                // Nếu có phân trang
                if($show_panigation == 'yes') :
                    ?>
                    </div> <!-- Đóng div của content-archive-post sau khi đã kết thúc vòng lặp -->

                    <div class="pagination-main mt-4">
                        <div id="pagination-container">
                            <?php
                            global $wp_query; 
                            $temp_query = $wp_query;
                            $wp_query = $query;

                            TemplateLoader::get_template( 'item/panigation.php' );

                            $wp_query = $temp_query; 
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
                
            else :
                echo '<p>No projects found</p>';
            endif;
            ?>
        </div>
    </div>
    <?php
    }


}

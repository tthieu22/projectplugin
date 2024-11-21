<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;


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
        // Section: Select Categories & Tags
        $this->start_controls_section(
            'content_tag_categories',
            [
                'label' => esc_html__('Select Categories & Tags', 'tthieudev'),
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

        $this->end_controls_section();

        // Section: Display Text
        $this->start_controls_section(
            'content_text',
            [
                'label' => esc_html__('Display Text', 'tthieudev'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_project_title',
            [
                'label' => esc_html__('Show Project Title', 'tthieudev'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'tthieudev'),
                'label_off' => esc_html__('Hide', 'tthieudev'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_project_categories',
            [
                'label' => esc_html__('Show Project Categories', 'tthieudev'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'tthieudev'),
                'label_off' => esc_html__('Hide', 'tthieudev'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_project_tags',
            [
                'label' => esc_html__('Show Project Tags', 'tthieudev'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'tthieudev'),
                'label_off' => esc_html__('Hide', 'tthieudev'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__('Show Pagination', 'tthieudev'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'tthieudev'),
                'label_off' => esc_html__('Hide', 'tthieudev'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->end_controls_section();

        // Section: Settings
        $this->start_controls_section(
            'content_settings',
            [
                'label' => esc_html__('Settings', 'tthieudev'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Posts Per Page', 'tthieudev'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3,
                'min' => 1,
                'max' => 50, // Sử dụng biến $max_posts đã kiểm tra
                'step' => 1, // Đặt bước nhảy (có thể tùy chỉnh)
                'input_attributes' => [
                    'aria-label' => esc_html__('Posts Per Page', 'tthieudev'),
                ],
                'description' => esc_html__('Set the number of posts to display per page', 'tthieudev'), 
            ]
        );


        $this->add_control(
            'column',
            [
                'label' => esc_html__('Select Columns', 'tthieudev'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' =>'3',
                'options' => [
                    '1' => esc_html__('1 Column', 'tthieudev'),
                    '2' => esc_html__('2 Columns', 'tthieudev'),
                    '3' => esc_html__('3 Columns', 'tthieudev'),
                    '4' => esc_html__('4 Columns', 'tthieudev'),
                ],
                'frontend_available' => true,
            ]
        );
        $this->add_responsive_control(
            'gap_item',
            [
                'label' => esc_html__( 'Gap', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wrapper .content-archive-post' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'margin_item',
            [
                'label' => esc_html__( 'Margin Item', 'tthieudev' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => 0,
                    'right' => 10,
                    'bottom' => 0,
                    'left' => 10,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wrapper .content-archive-post' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Section: Style
        $this->start_controls_section(
            'heading_style_section',
            [
                'label' => esc_html__('Heading', 'tthieudev'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .wrapper .content-archive-post .content-post .project-item h2 a',
            ]
        );
        $this->add_control(
            'divider_2', 
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'solid', // Kiểu đường kẻ
                'color' => '#333', // Màu sắc đường kẻ
                'width' => '100%', // Chiều rộng
            ]
        );

        $this->add_control(
            'margin_title',
            [
                'label' => esc_html__( 'Margin', 'tthieudev' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wrapper .content-archive-post .content-post .project-item h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'padding_title',
            [
                'label' => esc_html__( 'Padding', 'tthieudev' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wrapper .content-archive-post .content-post .project-item h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'divider_3', 
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'solid', // Kiểu đường kẻ
                'color' => '#333', // Màu sắc đường kẻ
                'width' => '100%', // Chiều rộng
            ]
        );

        $this->add_control(
            'heading_text_align',
            [
                'label' => esc_html__( 'Alignment', 'tthieudev' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'tthieudev' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'tthieudev' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'tthieudev' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .wrapper .content-archive-post .content-post .project-item h2' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        // Tabs: Normal & Hover
        $this->start_controls_tabs('style_tabs_title');

        // Tab: Normal
        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__('Normal', 'tthieudev'),
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'tthieudev'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wrapper .content-archive-post .content-post .project-item h2 a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();

        // Tab: Hover
        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__('Hover', 'tthieudev'),
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Title Color Hover', 'tthieudev'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wrapper .content-archive-post .content-post .project-item h2 a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        // Add hover styles here if needed
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        // Category & Tag Style  // Category & Tag Style  // Category & Tag Style  // Category & Tag Style  // Category & Tag Style  // Category & Tag Style  // Category & Tag Style  // Category & Tag Style  // Category & Tag Style  // Category & Tag Style  // Category & Tag Style 
        $this->start_controls_section(
            'cat_tags_style_section',
            [
                'label' => esc_html__('Style Categories & Tags', 'tthieudev'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'category_tag_typography',
                'selector' => '{{WRAPPER}} .wrapper .content-archive-post .content-post .project-categories a',
            ]
        );
        $this->add_control(
            'margin_category_tag',
            [
                'label' => esc_html__( 'Margin', 'tthieudev' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wrapper .content-archive-post .content-post .project-categories' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'padding_category_tag',
            [
                'label' => esc_html__( 'Padding', 'tthieudev' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wrapper .content-archive-post .content-post .project-categories' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'category_tag_text_align',
            [
                'label' => esc_html__( 'Alignment', 'tthieudev' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'tthieudev' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'tthieudev' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'tthieudev' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .wrapper .content-archive-post .content-post .project-categories' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        // Tabs: Normal & Hover
        $this->start_controls_tabs('style_tabs_category');

        // Tab: Normal
        $this->start_controls_tab(
            'style_normal_tab_category_tag',
            [
                'label' => esc_html__('Normal', 'tthieudev'),
            ]
        );
        $this->add_control(
            'category_tag_color',
            [
                'label' => esc_html__('Categories & Tags Color', 'tthieudev'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wrapper .content-archive-post .content-post .project-categories a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();

        // Tab: Hover
        $this->start_controls_tab(
            'style_hover_tab_category_tag',
            [
                'label' => esc_html__('Hover', 'tthieudev'),
            ]
        );

        $this->add_control(
            'category_tag_color_hover',
            [
                'label' => esc_html__('Categories & Tags Color Hover', 'tthieudev'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wrapper .content-archive-post .content-post .project-categories a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        // Mask Section

        $this->start_controls_section(
            'gradient_section',
            [
                'label' => esc_html__('Custom Gradient Mask', 'tthieudev'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'gradient_preview',
                'label' => esc_html__('Gradient Preview', 'tthieudev'),
                'types' => ['gradient'],
                'selector' => '{{WRAPPER}} .wrapper .content-archive-post .content-archive-item .mark',
            ]
        );

        $this->end_controls_section();

        // Pagination
        $this->start_controls_section(
            'style_section_pagination',
            [
                'label' => esc_html__( 'Pagination Section', 'tthieudev' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'margin_pagination',
            [
                'label' => esc_html__( 'Margin', 'tthieudev' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => 10,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wrapper .pagination-main' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'padding_pagination',
            [
                'label' => esc_html__( 'Padding', 'tthieudev' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wrapper .pagination-main' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs(
            'style_tabs_panigation'
        );
        $this->start_controls_tab(
            'style_normal_tab_panigation',
            [
                'label' => esc_html__( 'Normal', 'tthieudev' ),
            ]
        );
        $this->add_control(
            'pagination_text_color',
            [
                'label' => esc_html__('Text Color', 'tthieudev'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wrapper .pagination-main #pagination-container a.page-link' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wrapper .pagination-main .nav-links .page-numbers .page-num' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wrapper .pagination-main .nav-links .page-numbers span.page-next' => 'color: {{VALUE}}',

                ],
            ]
        );
        $this->add_control(
            'pagination_tag_color',
            [
                'label' => esc_html__('Background Color', 'tthieudev'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wrapper .pagination-main #pagination-container a.page-link' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wrapper .pagination-main .nav-links .page-numbers' => 'background-color: {{VALUE}}',

                ],
            ]
        );
        // Content
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_hover_tab_pagination',
            [
                'label' => esc_html__( 'Hover', 'tthieudev' ),
            ]
        );
        $this->add_control(
            'pagination_text_color_hover',
            [
                'label' => esc_html__('Text Color Hover & Active', 'tthieudev'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wrapper .pagination-main #pagination-container a.page-link:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wrapper .pagination-main .nav-links .page-numbers .page-num:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wrapper .pagination-main #pagination-container a.page-link.active' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wrapper .pagination-main .nav-links .page-numbers span.page-next:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wrapper .pagination-main .nav-links .page-numbers.current .page-num' => 'color: {{VALUE}}',


                ],
            ]
        );
        $this->add_control(
            'pagination_tag_color_hover',
            [
                'label' => esc_html__('Background Color Hover & Active', 'tthieudev'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wrapper .pagination-main #pagination-container a.page-link:hover' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wrapper .pagination-main .nav-links .page-numbers:hover' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wrapper .pagination-main #pagination-container a.page-link.active' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wrapper .pagination-main .nav-links span.page-numbers.current span' => 'background-color: {{VALUE}}',


                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control(
            'divider_1', 
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'solid', // Kiểu đường kẻ
                'color' => '#333', // Màu sắc đường kẻ
                'width' => '100%', // Chiều rộng
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'pagination_typography',
                'selector' => '{{WRAPPER}} .wrapper .content-archive-post .content-post .project-categories a',
            ]
        );
        $this->add_responsive_control(
            'gap_pagination',
            [
                'label' => esc_html__( 'Gap', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wrapper .pagination-main .nav-links' => 'gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wrapper .pagination-main .nav-links' => 'gap: {{SIZE}}{{UNIT}};',
                ],
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
        $show_pagination = isset($settings['show_pagination']) ? $settings['show_pagination'] : 'yes';
        // $column = isset($settings['column']) ? $settings['column'] : 5;
        $posts_per_page = isset($settings['posts_per_page']) ? $settings['posts_per_page'] : 3;

        // $col = ($column == 4) ? 4 : (($column == 3) ? 3 : (($column == 2) ? 2 : 1));
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
        <div class="wrapper w-100">
            <div class="content-archive-post gap-20" id="posts-container" style="grid-template-columns:repeat(<?php echo $settings['column']; ?>, 1fr)" >
            <?php
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    TemplateLoader::get_template('item/elementors/list-project-display.php');
                endwhile;
                wp_reset_postdata();
                
                // Nếu có phân trang
                if($show_pagination == 'yes') :
                    ?>
                    </div> <!-- Đóng div của content-archive-post sau khi đã kết thúc vòng lặp -->

                    <div class="pagination-main">
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

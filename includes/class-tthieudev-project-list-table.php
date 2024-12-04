<?php defined( 'ABSPATH' ) || exit;

if (!class_exists('TthieuDev_Project_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

    class TthieuDev_Project_List_Table extends WP_List_Table {

        public function __construct() {
            parent::__construct([
                'singular' => 'project',
                'plural'   => 'projects', 
                'ajax'     => false 
            ]);
        }

        public function get_columns() {
            $columns = [
                'ID'          => 'ID',                    
                'post_title'  => 'Title',              
                'sub_title'   => 'Sub Title',         
                'client'      => 'Client',              
                'date'        => 'Date',                    
                'value'       => 'Value',                   
            ];

            return $columns;
        }
        

        function column_cb($item) {
            return sprintf(
                '<input type="checkbox" name="project_ids[]" value="%s" />',
                $item['ID']
            );
        }
        
        public function prepare_items() {
            $meta_key = 'managetoplevel_page_' . $_GET['page'] . 'columnshidden';
            $hidden = (is_array(get_user_meta(get_current_user_id(), $meta_key, true))) ? get_user_meta(get_current_user_id(), $meta_key, true) : array();
            $this->_column_headers = [
                $this->get_columns(),
                $hidden,
                $this->get_sortable_columns(),
            ];

            $per_page = 5;
            $current_page = $this->get_pagenum();
            $id_search = isset($_GET['id_search']) ? sanitize_text_field($_GET['id_search']) : ''; 
            $title_search = isset($_GET['title_search']) ? sanitize_text_field($_GET['title_search']) : ''; 
            $client_search = isset($_GET['client_search']) ? sanitize_text_field($_GET['client_search']) : ''; 
            $date_search = isset($_GET['date_search']) ? sanitize_text_field($_GET['date_search']) : ''; 

            $args = [
                'post_type'      => 'project',
                'posts_per_page' => $per_page,
                'paged'          => $current_page,
                'order'           => !empty($_GET['order']) ? $_GET['order'] : 'asc', 
            ];

            if (!empty($id_search)) {
                $args['p'] = $id_search;  
            }
            if (!empty($title_search)) {
                $args['s'] = $title_search;  
            }
            if (!empty($client_search)) {
                $args['meta_query'] = [
                    [
                        'key'     => 'client',  
                        'value'   => $client_search,  
                        'compare' => 'LIKE',  
                    ]
                ];
            }
            if (!empty($date_search)) {
                $date = date('Y-m-d', strtotime($date_search)); 
                $args['meta_query'] = [
                    [
                        'key'     => 'date',  
                        'value'   => $date,   
                        'compare' => '=',    
                        'type'    => 'DATE', 
                    ]
                ];
            }

            $query = new WP_Query($args);

            $this->items = [];
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();

                    $this->items[] = [
                        'ID'         => get_the_ID(),
                        'post_title' => get_the_title(),
                        'sub_title'  => get_post_meta(get_the_ID(), 'sub_title', true),
                        'client'     => get_post_meta(get_the_ID(), 'client', true),
                        'date'       => get_post_meta(get_the_ID(), 'date', true),
                        'value'      => get_post_meta(get_the_ID(), 'value', true),
                        'actions'    => $this->get_actions(get_the_ID()),
                    ];
                }
            }

            $this->set_pagination_args([
                'total_items' => $query->found_posts,
                'per_page'    => $per_page,
                'total_pages' => $query->max_num_pages,
            ]);

            wp_reset_postdata();
        }

        public function get_actions($post_id) {
            $edit_url = get_edit_post_link($post_id); 
            $trash_url = get_delete_post_link($post_id); 
            $view_url = get_permalink($post_id); 

            return '
                <a href="' . esc_url($edit_url) . '">Edit</a> | 
                <a href="' . esc_url($trash_url) . '" class="submitdelete">Trash</a> | 
                <a href="' . esc_url($view_url) . '" target="_blank">View</a>';
        }

        function column_default($item, $column_name) {
            switch ($column_name) {
                case 'ID':
                case 'post_title':
                case 'sub_title':
                case 'client':
                case 'date':
                case 'value':
                default:
                    return esc_html($item[$column_name]);
            }
        }

        protected function get_sortable_columns() {
            $sortable_columns = [
                'ID'    => ['ID', false],
            ];
            return $sortable_columns;
        }
        function usort_reorder($a, $b) {
            $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'ID'; 

            $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc'; 

            $result = strcmp($a[$orderby], $b[$orderby]);

            return ($order === 'asc') ? $result : -$result;
        }

        public function display_rows() {
            foreach ($this->items as $item) {
                $edit_url = admin_url('post.php?action=edit&post=' . $item['ID']);

                echo '<tr>';
                echo '<td><a href="' . esc_url($edit_url) . '">' . esc_html($item['ID']) . '</a></td>';            
                echo '<td><a href="' . esc_url($edit_url) . '">' . esc_html($item['post_title']) . '</a></td>';     
                echo '<td>' . esc_html($item['sub_title']) . '</td>';   
                echo '<td>' . esc_html($item['client']) . '</td>';       
                echo '<td>' . esc_html($item['date']) . '</td>';         
                echo '<td>' . esc_html($item['value']) . '</td>';   
                echo '<tr><td colspan="7">'; 
                echo $item['actions'];
                echo '</td></tr>';
            }
        }
        public function search_box( $text, $input_id ) {
            if ( empty( $_GET['s'] ) && ! $this->has_items() ) {
                return;
            }
            $input_id = $input_id . '-search-input';
            foreach ( $_GET as $key => $value ) {
                if ( 's' === $key || 'paged' === $key ) {
                    continue;
                }
                if ( is_array( $value ) ) {
                    foreach ( $value as $sub_key => $sub_value ) {
                        echo '<input type="hidden" name="' . esc_attr( $key ) . '[' . esc_attr( $sub_key ) . ']" value="' . esc_attr( $sub_value ) . '" />';
                    }
                } else {
                    echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '" />';
                }
            }
            TthieuDev_TemplateLoader::get_template('forms/form-search-list-table-project.php');
        }

        function display_search_criteria() {
            $id_search = isset($_GET['id_search']) ? sanitize_text_field($_GET['id_search']) : '';
            $title_search = isset($_GET['title_search']) ? sanitize_text_field($_GET['title_search']) : '';
            $client_search = isset($_GET['client_search']) ? sanitize_text_field($_GET['client_search']) : '';
            $date_search = isset($_GET['date_search']) ? sanitize_text_field($_GET['date_search']) : '';

            $search_criteria = [];

            if (!empty($id_search)) {
                $search_criteria[] = esc_html__('ID: ') . esc_html($id_search);
            }
            if (!empty($title_search)) {
                $search_criteria[] = esc_html__('Title: ') . esc_html($title_search);
            }
            if (!empty($client_search)) {
                $search_criteria[] = esc_html__('Client: ') . esc_html($client_search);
            }
            if (!empty($date_search)) {
                $search_criteria[] = esc_html__('Date: ') . esc_html($date_search);
            }

            if (count($search_criteria) > 0) {
                echo '<p><strong>' . esc_html__('Search results for:') . '</strong> ' . implode(', ', $search_criteria) . '</p>';
            }
        }


    }
}

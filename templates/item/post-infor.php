<?php 
defined("ABSPATH") or die("You can not access directly");
?>
<div class="bg-content-author">
   <?php
    // Get values of custom fields
    $post_id = get_the_ID();
    $sub_title = get_post_meta( $post_id, 'sub_title', true );
    $client = get_post_meta( $post_id, 'client', true );
    $date = get_post_meta( $post_id, 'date', true );
    $value = get_post_meta( $post_id, 'value', true );
    // Display custom fields if any
    $categories = get_the_terms( get_the_ID(), 'project_category' ); // Lấy các category
    if ( $categories && ! is_wp_error( $categories ) ) : 
        $category_links = array();
        foreach ( $categories as $category ) {
            $category_links[] = '<a class="fs-3 text-black" href="' . esc_url( get_term_link( $category ) ) . '">' . esc_html( $category->name ) . '</a>';
        }
        echo '<div class="cate-list d-flex m-0 flex-column gap-5">' .'<strong>Categories</strong>' .'<div class="d-flex text-co m-0 gap-5">' . implode( ', ', $category_links ) .'</div> </div>' ;

    endif;

    if ( ! empty( $sub_title ) ) {
        echo '<p><strong>' . esc_html__( 'Sub Title:', 'tthieudev' ) . '</strong> ' . esc_html( $sub_title ) . '</p>';
    }

    if ( ! empty( $client ) ) {
        echo '<p><strong>' . esc_html__( 'Client:', 'tthieudev' ) . '</strong> ' . esc_html( $client ) . '</p>';
    }

    if ( ! empty( $date ) ) {
        $formatted_date = date( 'd/m/Y', strtotime( $date ) ); // Định dạng thành ngày/tháng/năm
        echo '<p><strong>' . esc_html__( 'Date:', 'tthieudev' ) . '</strong> ' . esc_html( $formatted_date ) . '</p>';
    }


    if ( ! empty( $value ) ) {
        echo '<p><strong>' . esc_html__( 'Value:', 'tthieudev' ) . '</strong> ' . esc_html( $value ) . '</p>';
    }
    ?>
</div>
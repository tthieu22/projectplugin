<?php defined( 'ABSPATH' ) || exit; ?>

<div class="bg-content-author">
   <?php

    $post_id = get_the_ID();
    $sub_title = get_post_meta( $post_id, 'sub_title', true );
    $client = get_post_meta( $post_id, 'client', true );
    $date = get_post_meta( $post_id, 'date', true );
    $value = get_post_meta( $post_id, 'value', true );

    if (get_option('checked-show-category-single') == '1') {
        tthieudev_get_template('item/get-list-categories.php' );
    }

    if (get_option('checked-show-tag-single') == '1') {
        tthieudev_get_template('item/get-list-tags.php' );
    }

    if (get_option('checked-show-sub-title') == '1' && ! empty( $sub_title ) ) {
        echo '<p><strong>' . esc_html__( 'Sub Title', 'tthieudev' ) . '</strong> ' . esc_html( $sub_title ) . '</p>';
    }

    if (get_option('checked-show-client') == '1' && ! empty( $client ) ) {
        echo '<p><strong>' . esc_html__( 'Client', 'tthieudev' ) . '</strong> ' . esc_html( $client ) . '</p>';
    }

    if (get_option('checked-show-date') == '1' && ! empty( $date ) ) {
        $formatted_date = date( 'd/m/Y', strtotime( $date ) ); // Định dạng thành ngày/tháng/năm
        echo '<p><strong>' . esc_html__( 'Date', 'tthieudev' ) . '</strong> ' . esc_html( $formatted_date ) . '</p>';
    }

    if (get_option('checked-show-value') == '1' && ! empty( $value ) ) {
        echo '<p><strong>' . esc_html__( 'Value', 'tthieudev' ) . '</strong> ' . esc_html( $value ) . ' USD</p>';
    }
    ?>
</div>

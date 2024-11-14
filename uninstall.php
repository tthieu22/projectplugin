<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Kiểm tra xem plugin có thực sự được gỡ bỏ không
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// // Xóa tùy chọn plugin trong cơ sở dữ liệu
// delete_option( 'my_plugin_option' );

// // Xóa các bảng cơ sở dữ liệu nếu plugin sử dụng bảng riêng
// global $wpdb;
// $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}my_plugin_table" );

// // Xóa các tệp đã được plugin tạo ra
// $uploads_dir = wp_upload_dir();
// $file_to_delete = $uploads_dir['basedir'] . '/my-plugin-file.txt';
// if ( file_exists( $file_to_delete ) ) {
//     unlink( $file_to_delete );
// }

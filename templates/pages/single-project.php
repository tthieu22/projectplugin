<?php defined( 'ABSPATH' ) || exit;
get_header(); 
tthieudev_get_template( 'item/banner.php' );
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        tthieudev_get_template('content/single-detail.php' ); 

    endwhile;
else :
    echo '<p>' . esc_html__( 'Sorry, no project found.', 'tthieudev' ) . '</p>';
endif;

get_footer();
<?php 
defined("ABSPATH") or die("You can not access directly");
get_header(); 
TemplateLoader::get_template( 'item/banner-header.php' );
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        TemplateLoader::get_template('content/single-detail.php' ); 

    endwhile;
else :
    echo '<p>' . esc_html__( 'Sorry, no project found.', 'tthieudev' ) . '</p>';
endif;

get_footer();
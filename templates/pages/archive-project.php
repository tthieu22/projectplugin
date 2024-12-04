<?php defined( 'ABSPATH' ) || exit; 

get_header(); 
tthieudev_get_template( 'item/banner.php' );
?>
<div class="wrapper ">
    <div class="content-archive-post gap-20">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <?php tthieudev_get_template( 'content/item-project.php' ); ?> 
            <?php endwhile; ?>
        <?php else : ?>
            <p><?php _e('No projects found.', 'tthieudev'); ?></p>
        <?php endif; ?>
    </div>

    <div class="container">
        <div class="row">
            <?php 
            if (get_option('checked-show-pagination') == '1'){
                tthieudev_get_template( 'item/panigation.php' );
            }
            ?>
        </div>
    </div>

</div>

<?php
get_footer(); 

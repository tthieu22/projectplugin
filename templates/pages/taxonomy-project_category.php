<?php defined( 'ABSPATH' ) || exit; 
get_header(); 
tthieudev_get_template( 'item/banner.php' );
?>
<?php if ( have_posts() ) : ?>
    <div class="wrapper">
        <div class="content-archive-post gap-20">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php tthieudev_get_template('content/item-project.php' ); ?> 
            <?php endwhile; ?>
        </div>
        <div class="container">
        <div class="row">
            <?php tthieudev_get_template('item/panigation.php' ); ?> 
        </div>
    </div>
    </div>
<?php else : ?>
    <p><?php _e('No projects found.', 'tthieudev'); ?></p>
<?php endif; ?>

<?php
get_footer();

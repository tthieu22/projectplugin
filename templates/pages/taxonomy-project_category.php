<?php 
defined("ABSPATH") or die("You can not access directly");
get_header(); 
TemplateLoader::get_template( 'item/banner.php' );
?>
<?php if ( have_posts() ) : ?>
    <div class="wrapper">
        <div class="content-archive-post gap-20">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php TemplateLoader::get_template('content/item-project.php' ); ?> 
            <?php endwhile; ?>
        </div>
        <div class="container">
        <div class="row">
            <?php TemplateLoader::get_template('item/panigation.php' ); ?> 
        </div>
    </div>
    </div>
<?php else : ?>
    <p><?php _e('No projects found.', 'tthieudev'); ?></p>
<?php endif; ?>

<?php
get_footer();

<?php 
defined("ABSPATH") or die("You can not access directly");
get_header(); 
?>

<div class="project-archive-banner position-relative mb-4">
    <div class="img-banner-custom w-100 h-100 position-absolute left-0 top-0"></div>
    <h1 class="text-lg-center text-uppercase fw-bold text-white"><?php _e('Archives: Projects', 'tthieudev'); ?></h1>
    <?php Tthieudev_Breadcrumb::display(); ?>
</div>

<div class="wrapper ">
    <div class="content-archive-post gap-20">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <?php echo TemplateLoader::get_template( 'content/item-project.php' ); ?> 
            <?php endwhile; ?>
        <?php else : ?>
            <p><?php _e('No projects found.', 'tthieudev'); ?></p>
        <?php endif; ?>
    </div>

    <div class="container">
        <div class="row mt-4">
            <?php 
            if (get_option('checked-show-pagination') == '1'){
                TemplateLoader::get_template( 'item/panigation.php' );
            }
            ?>
        </div>
    </div>

</div>

<?php
get_footer(); 

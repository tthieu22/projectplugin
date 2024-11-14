<?php 
defined("ABSPATH") or die("You can not access directly");
get_header(); 
?>

<div class="project-archive-banner position-relative mb-4">
    <div class="img-banner-custom w-100 h-100 position-absolute left-0 top-0"></div>
    <h1 class="text-lg-center text-uppercase fw-bold text-white"><?php _e('Archives: Projects', 'tthieudev'); ?></h1>
    <?php tthieudev_custom_breadcrumb(); ?>
</div>

<div class="wrapper ">
    <div class="content-archive-post gap-20">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <?php tthieudev_get_template( './item/post-item-project.php' ); ?> 
            <?php endwhile; ?>
        <?php else : ?>
            <p><?php _e('No projects found.', 'tthieudev'); ?></p>
        <?php endif; ?>
    </div>

    <div class="container">
        <div class="row mt-4">
            <?php tthieudev_get_template( './item/panigation.php' ); ?> 
        </div>
    </div>

</div>

<?php
get_footer(); // Tải footer từ theme
?>
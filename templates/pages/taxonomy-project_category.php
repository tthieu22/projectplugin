<?php 
defined("ABSPATH") or die("You can not access directly");
get_header(); 
// get info taxonomy  (category)
$term = get_queried_object();
?>
<div class="project-archive-banner position-relative mb-4">
    <div class="img-banner-custom w-100 h-100 position-absolute left-0 top-0"></div>
    <h1 class="text-lg-center text-uppercase fw-bold text-white"><?php echo esc_html( $term->name ); ?> Projects</h1>

    <?php Tthieudev_Breadcrumb::display();
 ?>
</div>
<?php if ( have_posts() ) : ?>
    

    <div class="wrapper">
        <div class="content-archive-post gap-20">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php TemplateLoader::get_template('content/item-project.php' ); ?> 
            <?php endwhile; ?>
        </div>
        <div class="container">
        <div class="row mt-4">
            <?php TemplateLoader::get_template('item/panigation.php' ); ?> 
        </div>
    </div>
    </div>

<?php else : ?>
    <p><?php _e('No projects found.', 'tthieudev'); ?></p>
<?php endif; ?>

<?php
get_footer();

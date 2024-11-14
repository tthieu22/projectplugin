<?php 
defined("ABSPATH") or die("You can not access directly");
?> 
<div class="position-relative">
    <a class="content-archive-item " href="<?php the_permalink(); ?>">
        <div class="img h-100">
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="project-thumbnail h-100">
                    <?php the_post_thumbnail( 'large' );  ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="mark position-absolute w-100 h-100 top-0 left-0"></div>
        <div class="content-post position-absolute left-0 bottom-0">
            <div class="project-item">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php tthieudev_get_template( './item/get-list-category.php' ); ?> 
            </div>
        </div>
    </a>
</div>
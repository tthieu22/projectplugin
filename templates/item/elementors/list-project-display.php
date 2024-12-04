<?php defined( 'ABSPATH' ) || exit; ?>

<div class="widget-list-project-item">
    <a href="<?php the_permalink(); ?>">
        <div class="content-project">
            <div class="img">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="project-thumbnail h-100 w-100">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="content-postion">
                <div class="content-project">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php  tthieudev_get_template('item/get-list-categories.php' ); ?>
                    <?php  tthieudev_get_template('item/get-list-tags.php' ); ?>
                </div>
            </div>
        </div>    
    </a>
</div>
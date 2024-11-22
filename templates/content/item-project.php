<?php 
defined("ABSPATH") or exit("You cannot access this file directly.");
?> 

<div class="position-relative w-100 box-item">
    <a class="content-archive-item w-100" href="<?php echo esc_url(get_permalink()); ?>">
        <div class="img h-100 w-100">
            <?php if (has_post_thumbnail()) : ?>
                <div class="project-thumbnail h-100 w-100">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="mark position-absolute w-100 h-100 top-0 left-0"></div>
        <div class="content-post position-absolute left-0 bottom-0">
            <div class="project-item">
                <?php if (get_option('checked-show-title-archive') == '1') : ?>
                    <h2>
                        <a href="<?php echo esc_url(get_permalink()); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                <?php endif; ?>

                <?php if (get_option('checked-show-category-archive') == '1') : ?>
                    <?php TemplateLoader::get_template('item/get-list-categories.php'); ?>
                <?php endif; ?>

                <?php if (get_option('checked-show-tag-archive') == '1') : ?>
                    <div class="project-tags">
                        <?php TemplateLoader::get_template('item/get-list-tags.php'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </a>
</div>

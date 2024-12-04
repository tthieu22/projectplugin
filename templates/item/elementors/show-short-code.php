<?php defined( 'ABSPATH' ) || exit;

?>
<div class="item-project">
    <a href="<?php the_permalink(); ?>">
        <div class="project-box" >
            <div class="img">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="project-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="content-position">
                <div class="content">
                    <h2 class="project-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php TthieuDev_TemplateLoader::get_template('item/get-list-categories.php'); ?>
                    <?php TthieuDev_TemplateLoader::get_template('item/get-list-tags.php'); ?>
                </div>
            </div>
        </div>
    </a>
</div>
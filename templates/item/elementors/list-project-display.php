<?php
defined("ABSPATH") or die("You can not access directly");

$settings = get_option('project_settings');

$show_title = $settings['show_title'];
$show_categories = $settings['show_categories'];
$show_tags = $settings['show_tags'];

?>

<div class="position-relative p-0 w-100">
    <a class="content-archive-item w-100" href="<?php the_permalink(); ?>">
        <div class="img h-100 w-100">
            <?php if (has_post_thumbnail()) : ?>
                <div class="project-thumbnail h-100 w-100">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="mark position-absolute w-100 h-100 top-0 left-0 "></div>
        <div class="content-post position-absolute left-0 bottom-0 w-100">
            <div class="project-item w-100">
                <?php if ($show_title === 'yes') : ?>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php endif; ?>

                <?php if ($show_categories === 'yes') : ?>
                    <?php  TemplateLoader::get_template('item/get-list-categories.php' ); ?>
                <?php endif; ?>

                <?php if ($show_tags === 'yes') : ?>
                    <?php  TemplateLoader::get_template('item/get-list-tags.php' ); ?>
                <?php endif; ?>
            </div>
        </div>
    </a>
</div>
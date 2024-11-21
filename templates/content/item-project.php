<?php 
defined("ABSPATH") or die("You can not access directly");
?> 
<div class="position-relative w-100">
    <a class="content-archive-item w-100 " href="<?php the_permalink(); ?>">
        <div class="img h-100 w-100">
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="project-thumbnail h-100 w-100">
                    <?php the_post_thumbnail( 'large' );  ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="mark position-absolute w-100 h-100 top-0 left-0"></div>
        <div class="content-post position-absolute left-0 bottom-0">
            <div class="project-item ">
                <h2><a href="<?php the_permalink(); ?>">
                    <?php 
                    if (get_option('checked-show-title-archive') == '1'){
                        the_title();
                    } ?>
                </a></h2>
                    <?php 
                    if (get_option('checked-show-category-archive') == '1') {
                        TemplateLoader::get_template('item/get-list-categories.php' ); 
                    }
                    ?>
                    <?php
                    if (get_option('checked-show-tag-archive') == '1') {
                        echo "<br>";
                        TemplateLoader::get_template('item/get-list-tags.php' ); 
                    }
                    ?>
            </div>
        </div>
    </a>
</div>
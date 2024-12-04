<?php defined( 'ABSPATH' ) || exit; ?>

<div class="project-categories text-white">
    <?php 
    $categories = get_the_terms(get_the_ID(), 'project_category');
    if ($categories && !is_wp_error($categories)) : 
        $category_links = array();
        foreach ($categories as $category) {
            $category_links[] = '<a class="fs-3" href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a>';
        }
        echo '<span class="categories-label"><strong>' . __('Categories', 'tthieudev') . '</strong></span><br>' . implode(' &nbsp;&nbsp;', $category_links);
    endif;
    ?>
</div>

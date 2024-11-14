<?php 
defined("ABSPATH") or die("You can not access directly");
?>
<div class="project-categories text-white">
    <?php 
    $tags = get_the_terms( get_the_ID(), 'project_category' ); // Lấy các category
    if ( $tags && ! is_wp_error( $tags ) ) : 
        $category_links = array();
        foreach ( $tags as $tag ) {
            $tag_links[] = '<a class="fs-3" href="' . esc_url( get_term_link( $tag ) ) . '">' . esc_html( $tag->name ) . '</a>';
        }
        echo '<span class="categories-label">' . __('Tags:', 'tthieudev') . '</span> ' . implode( ' / ', $tag_links );
    endif;
    ?>
</div>
<?php 
defined("ABSPATH") or die("You can not access directly");
?>
<div class="project-categories text-white">
    <?php 
    $categories = get_the_terms( get_the_ID(), 'project_category' ); // Lấy các category
    if ( $categories && ! is_wp_error( $categories ) ) : 
        $category_links = array();
        foreach ( $categories as $category ) {
            $category_links[] = '<a class="fs-3" href="' . esc_url( get_term_link( $category ) ) . '">' . esc_html( $category->name ) . '</a>';
        }
        echo '<span class="categories-label">' . __('', 'tthieudev') . '</span> ' . implode( ' / ', $category_links );
    endif;
    ?>
</div>
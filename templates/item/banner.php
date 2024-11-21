<?php 
defined("ABSPATH") or die("You can not access directly");
$term = get_queried_object();
?>
<div class="project-archive-banner position-relative mb-4">
    <div class="img-banner-custom w-100 h-100 position-absolute left-0 top-0"></div>
    <h1 class="text-center text-uppercase fw-bold text-white">
    <?php
    if ( is_post_type_archive( 'project' ) ) {
        echo esc_html('Archives: Projects', 'tthieudev');
    }
    elseif ( is_singular( 'project' ) ) {
        the_title();
    }
    elseif ( is_tax( 'project_category' ) || is_tax( 'project_tag' ) ) {
        echo esc_html( $term->name ) .' &nbsp;Projects';
    }
    Tthieudev_Breadcrumb::display();
    ?>
    </h1>
</div>
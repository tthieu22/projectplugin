<?php defined( 'ABSPATH' ) || exit; ?>

<div class="pagination-main">
    <?php 
        the_posts_pagination([
        'mid_size' => 1,
        'prev_text' => '<span class="page-next"><i class="fas fa-chevron-left"></i></span>',
        'next_text' => '<span class="page-next"><i class="fas fa-chevron-right"></i></span>',
        'screen_reader_text' => ' ',
        'before_page_number' => '<span class="page-num">',
        'after_page_number' => '</span>',
        'end_size' => 1,
        ]); 
    ?>
</div>
    
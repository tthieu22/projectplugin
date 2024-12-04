<?php defined( 'ABSPATH' ) || exit; ?>

<div class="project-item">
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="project-thumbnail">
            <?php the_post_thumbnail( 'large' ); ?>
        </div>
    <?php endif; ?>
    
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <div><?php the_excerpt(); ?></div>
    
    <div class="project-tags">
        <?php 
        $tags = get_the_terms( get_the_ID(), 'project_tag' ); // Lấy các tag
        if ( $tags && ! is_wp_error( $tags ) ) : 
            $tag_links = array();
            foreach ( $tags as $tag ) {
                $tag_links[] = '<a href="' . esc_url( get_term_link( $tag ) ) . '">' . esc_html( $tag->name ) . '</a>';
            }
            echo '<span class="tags-label">' . __('Tags:', 'tthieudev') . '</span> ' . implode( ', ', $tag_links );
        endif;
        ?>
    </div>
</div>

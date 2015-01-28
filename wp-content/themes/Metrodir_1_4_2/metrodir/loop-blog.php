<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <?php get_template_part('/include/html/pattern','blog'); ?>
<?php endwhile; // end of the loop.
if ( $wp_query->max_num_pages > 1 ): ?>
    <?php wp_link_pages('before=<div id="page-links">&after=</div>&pagelink=page %'); ?>
    <div class="older-posts">
        <?php previous_posts_link( '<i class="fa fa-arrow-circle-right"></i>'.__( 'Newer Entries', 'metrodir' ) ); ?>
        <?php next_posts_link( '<i class="fa fa-arrow-circle-left"></i>'.__( 'Older Entries', 'metrodir' ) ); ?>
    </div>
<?php endif; ?>
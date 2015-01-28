<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <?php get_template_part('/include/html/pattern','company'); ?>
<?php endwhile; // end of the loop. ?>


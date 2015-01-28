<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large'); if( has_post_thumbnail() && $large_image_url[0]):  ?>
        <div class="sidebar-post with-image">
        <div class="sidebar-post-image">
            <?php echo '<a href="'.get_permalink().'" title="'.get_the_title().'" class="opacity">'.get_the_post_thumbnail($post->ID,array(80,80)).'</a>'; ?>
        </div>
    <?php else: ?>
        <div class="sidebar-post">
    <?php endif; ?>
    <div class="sidebar-post-content">
        <div class="sidebar-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
        <?php $custom_fields = get_post_custom(); if(isset($custom_fields['metro_company_doc_desc'][0])): ?>
            <div class="sidebar-post-desc">
                <?php echo $custom_fields['metro_company_doc_desc'][0]; ?>
            </div>
        <?php endif; ?>
        <div class="sidebar-post-more"><a href="<?php the_permalink(); ?>"><i class="fa fa-arrow-circle-right"></i><?php echo __('Read More','metrodir'); ?></a></div>
    </div>
    </div>
<?php endwhile; ?>
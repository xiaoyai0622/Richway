<div class="blog-list-preview<?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large'); if( has_post_thumbnail() &&  $large_image_url[0]) echo ' with-image'; ?>" id="post-<?php the_ID(); ?>">

    <?php if( has_post_thumbnail() ):  ?>
        <?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large'); if ($large_image_url[0]): ?>
            <div class="blog-list-image">
                <a class="opacity" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(array(620,330)); ?></a>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="blog-list-title-comments">
        <div class="blog-list-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
        <div class="blog-list-comments"><a href="<?php the_permalink(); ?>#comments"><i class="fa fa-comment"></i><?php comments_number('0', '1', '%'); ?></a></div>
    </div>

    <div class="blog-list-description"><?php the_excerpt(); ?></div>

    <div class="blog-list-links">
        <div class="blog-list-meta"><span><i class="fa fa-calendar"></i><?php the_time('F d, Y'); ?></span><span>|</span><span><?php metrodir_posted_author(); ?></span><span>|</span><span><?php if ( count( get_the_category() ) ) printf( __( '%2$s', 'metrodir' ), '', get_the_category_list( ', ' ) ); ?></span></div>
        <div class="blog-list-more-link"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'metrodir' ), the_title_attribute( 'echo=0' ) ) ); ?>"><i class="fa fa-arrow-circle-right"></i><?php echo __('Read More', 'metrodir'); ?></a></div>
    </div>

</div>
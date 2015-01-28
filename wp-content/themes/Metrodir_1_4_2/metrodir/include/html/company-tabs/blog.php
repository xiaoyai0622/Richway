<!-- Sidebar --><div id="sidebar">

    <?php get_template_part('/include/html/frame','sidebar-blog'); ?>

</div><!-- /Sidebar -->

<!-- Content Center --><div id="content-center">

    <?php
    $blog_array = json_decode(htmlspecialchars_decode(get_post_meta(get_the_ID(), 'metro_blog', true)));
    $count_blog_arr = count((array)$blog_array);
    $blog_all_posts = get_post_meta(get_the_ID(), 'metro_blog_all_posts', true);
    $author = get_the_author();
    ?>

    <?php if($blog_all_posts == "all"): ?>

        <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => -1,
                'author_name' => $author
            );
            $query = uou_generate_query($args);
        ?>

        <?php if($query->have_posts()): ?>

            <?php $i = 1; while($query->have_posts()) : $query->the_post(); ?>

                <?php get_template_part('/include/html/pattern','blog'); ?>
                <?php $i++; ?>

            <?php endwhile; wp_reset_postdata(); ?>

        <?php else: ?>

            <div class="notification-notice"><div class="notification-inner"><i class="fa fa-exclamation-circle"></i> <?php echo __('No Posts.','glocal_site'); ?></div></div>

        <?php endif; ?>

    <?php else: ?>

        <?php if (is_object($blog_array) && $count_blog_arr >= 1): ?>

            <?php $i = 1; $k = 1;?>
            <?php foreach($blog_array as $_post) { if($k == $i) { $main = wp_get_attachment_image_src($_post); } $k++; } $k = 1; ?>
            <?php foreach($blog_array as $_post) : ?>
                <?php
                    $qpost = "p=".$_post;
                    query_posts($qpost);
                ?>
                <?php if ( have_posts() ): ?><?php the_post(); ?>

                    <?php get_template_part('/include/html/pattern','blog'); ?>

                <?php wp_reset_query(); ?>
                <?php endif;?>

            <?php $k++; ?>
            <?php endforeach; ?>

        <?php else: ?>

            <div class="notification-notice"><div class="notification-inner"><i class="fa fa-exclamation-circle"></i> <?php echo __('No Posts.','glocal_site'); ?></div></div>

        <?php endif; ?>

    <?php endif; ?>

</div><!-- /Content Center -->

<div class="clear"></div>

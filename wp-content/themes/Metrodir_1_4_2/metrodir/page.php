<?php
get_header();
the_post();
//Sidebar options
$opt_metrodir_sidebar = get_option('opt_metrodir_sidebar');
?>

    <!-- Content --><div id="content" class="sample">

    <?php get_template_part('/include/html/frame','breadcrumbs')?>

    <?php if ( has_post_thumbnail() ): ?>
        <?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large'); ?>
        <?php if ($large_image_url[0]): ?>
            <div class="box-container">
                <div class="project-image">
                    <a class="opacity colorbox" href="<?php echo $large_image_url[0]; ?>" title="'<?php the_title_attribute('echo=0'); ?>" >
                        <?php the_post_thumbnail(array(940,460),array('title' => strip_tags($post->post_title), 'alt' => strip_tags($post->post_title))); ?>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Content Inner --><div id="content-inner" class="sidebar-<?php echo $opt_metrodir_sidebar; ?>"><div class="box-container">

            <!-- Sidebar --><div id="sidebar"><?php get_template_part('/include/html/frame','sidebar-single'); ?></div><!-- /Sidebar -->

            <!-- Content Center --><div id="content-center">

                <div class="project-body body">
                    <?php the_content(); ?>
                </div>

            </div><!-- /Content Center -->

            <div class="clear"></div>

        </div></div><!-- /Content Inner -->

</div><!-- /Content -->

<?php get_template_part ('footer');
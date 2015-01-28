<?php
/*
Template Name: Blog
*/

get_header();

//Sidebar options
$opt_metrodir_sidebar = get_option('opt_metrodir_sidebar');
global $rtl;
?>

<!-- Content --><div id="content" class="blog-list">

    <!-- Breadcrumbs --><div id="breadcrumbs"><div class="box-container">


            <div class="breadcrumbs-page-title"><h1><?php echo __('Blog', 'metrodir') ?></h1></div>

            <?php if($rtl): ?>
                <div class="breadcrumbs">
                    <?php echo __('Blog', 'metrodir') ?>
                    <span><i class="fa fa-chevron-left"></i> <a href="<?php echo home_url(); ?>"><?php echo __('Home', 'metrodir') ?></a></span>
                </div>
            <?php else: ?>
                <div class="breadcrumbs">
                    <span><a href="<?php echo home_url(); ?>"><?php echo __('Home', 'metrodir') ?></a> <i class="fa fa-chevron-right"></i> </span>
                    <?php echo __('Blog', 'metrodir') ?>
                </div>
            <?php endif; ?>

        </div></div><!-- Breadcrumbs -->

    <!-- Content Inner --><div id="content-inner" class="sidebar-<?php echo $opt_metrodir_sidebar; ?>"><div class="box-container">

        <!-- Sidebar --><div id="sidebar">

            <?php get_template_part('/include/html/frame','sidebar-blog'); ?>

        </div><!-- /Sidebar -->

        <!-- Content Center --><div id="content-center">

            <?php
                global $wp_query;
                query_posts(array(
                    'paged' => $wp_query->get('paged'),
                    'post_type' => array('post')
                ));
            ?>

            <div id="blog-list-block">
                <?php get_template_part('loop-blog'); ?>
            </div>

            <?php if ( $wp_query->max_num_pages > 1 ): ?>
                <?php wp_link_pages('before=<div id="page-links">&after=</div>&pagelink=page %'); ?>
                <div class="older-posts">
                    <?php previous_posts_link( '<i class="fa fa-arrow-circle-right"></i>'.__( 'Newer Entries', 'metrodir' ) ); ?>
                    <?php next_posts_link( '<i class="fa fa-arrow-circle-left"></i>'.__( 'Older Entries', 'metrodir' ) ); ?>
                </div>
            <?php endif; ?>

            <?php wp_reset_query(); wp_reset_postdata(); ?>

        </div><!-- /Content Center -->

        <div class="clear"></div>

    </div></div><!-- /Content Inner -->

</div><!-- /Content -->

<?php get_template_part('footer');



<?php
get_header();
the_post();

//Sidebar options
$opt_metrodir_sidebar = get_option('opt_metrodir_sidebar');
?>

<!-- Content --><div id="content" class="blog-post">

    <?php get_template_part('/include/html/frame','breadcrumbs')?>

    <!-- Content Inner --><div id="content-inner" class="sidebar-<?php echo $opt_metrodir_sidebar; ?>"><div class="box-container">

        <!-- Sidebar --><div id="sidebar">

            <?php get_template_part('/include/html/frame','sidebar-blog'); ?>

        </div><!-- /Sidebar -->

        <!-- Content Center --><div id="content-center">

            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <?php if ( has_post_thumbnail()): ?>
                <?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large'); ?>
                <?php if ($large_image_url[0]): ?>
                    <div class="blog-post-image">
                        <a class="opacity colorbox" href="<?php echo $large_image_url[0]; ?>" title="<?php echo the_title_attribute('echo=0'); ?>" ><?php the_post_thumbnail(array(620,330)); ?></a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="blog-post-body body"><?php the_content(); ?></div>

            <div class="blog-post-info">

                <div class="blog-post-meta"><span><?php metrodir_posted_author(); ?></span><?php if ( count( get_the_category() ) ) printf( '<span>|</span><span>'.__( '%2$s', 'metrodir' ), '', get_the_category_list( ', ' ).'</span>' ); ?></div>

                <div class="blog-post-social">
                    <?php get_template_part ('/include/php/share','social'); ?>
                    <ul class="social-links">
                        <li class="facebook"><a href="#social" title="Facebook" onClick="metrodir_share_FB()"><i class="fa fa-facebook"></i></a></li>
                        <li class="google"><a href="#social" title="Google +"  onClick="metrodir_share_GP()"><i class="fa fa-google-plus"></i></a></li>
                        <li class="twitter"><a href="#social" title="Twitter" onClick="metrodir_share_TW()"><i class="fa fa-twitter fa-lg"></i></a></li>
                        <li class="linkedin"><a href="#social" title="Linkedin" onClick="metrodir_share_LI()"><i class="fa fa-linkedin-square fa-lg"></i></a></li>
                        <li class="pinterest"><a href="#social" title="Pinterest" onClick="metrodir_share_PI()"><i class="fa fa-pinterest fa-lg"></i></a></li>
                        <li class="dribbble"><a href="#social" title="Dribbble" onClick="metrodir_share_DB()"><i class="fa fa-dribbble fa-lg"></i></a></li>
                    </ul>
                </div>

            </div>

            <?php if ( comments_open() ): ?>
                <div id="comments" class="comment-message">
                    <?php comments_template( '' ); //Call Comments Template ?>
                </div>
            <?php endif; ?>

            </div>

        </div><!-- /Content Center -->

        <div class="clear"></div>

    </div></div><!-- /Content Inner -->

</div><!-- /Content -->

<?php get_template_part ('footer');
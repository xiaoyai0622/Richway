<?php

get_header();

if (isset($_GET['s'])) $words = $_GET['s'];

//Sidebar options
$opt_metrodir_sidebar = get_option('opt_metrodir_sidebar');
?>

<!-- Content --><div id="content" class="blog-list-search">

    <!-- Breadcrumbs --><div id="breadcrumbs"><div class="box-container">

            <div class="breadcrumbs-page-title"><h1><?php echo __('Search Blog', 'metrodir') ?></h1></div>
            <div class="breadcrumbs">
                <span><a href="<?php echo home_url(); ?>"><?php echo __('Home', 'metrodir') ?></a> <i class="fa fa-chevron-right"></i> </span>
                <?php echo __('Search Blog', 'metrodir') ?>
            </div>

    </div></div><!-- Breadcrumbs -->

    <!-- Content Inner --><div id="content-inner" class="sidebar-<?php echo $opt_metrodir_sidebar; ?>"><div class="box-container">

            <!-- Sidebar --><div id="sidebar">

                <?php get_template_part('/include/html/frame','sidebar-blog'); ?>

            </div><!-- /Sidebar -->

            <!-- Content Center --><div id="content-center">

                <?php
                    global $wp_query;
                    query_posts(array(
                        'post_type' => array('post'),
                        'posts_per_page' => -1,
                    ));

                    $blog_search_count = 0;
                ?>

                <div class="title">
                    <?php if (!($words)): ?>
                        <?php echo __('results','metrodir'); ?>
                    <?php else: ?>
                        <?php echo __('results for search', 'metrodir').' "'.$words.'"'; ?>
                    <?php endif; ?>
                </div>

                <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

                    <?php
                        $search_title = get_the_title();
                        $title = strtolower($words);
                        if ($title) {
                            $search_title_str = ' '.strtolower($search_title);
                            $title_result = strpos($search_title_str, $title, 0);
                        } else {
                            $title_result = true;
                        }

                        $search_text = get_the_excerpt();
                        $text = strtolower($words);
                        if ($text) {
                            $search_text_str = ' '.strtolower($search_text);
                            $text_result = strpos($search_text_str, $text, 0);
                        } else {
                            $text_result = true;
                        }
                    ?>

                    <?php if ($title_result OR $text_result): ?>

                        <?php get_template_part('/include/html/pattern','blog'); ?>

                        <?php $blog_search_count++; ?>

                    <?php endif ?>

                <?php endwhile; // end of the loop. ?>

                <div id="search-results" style="display: none;"><?php if (!($words)) echo "ALL"; else if ($blog_search_count == 0) echo 'NO'; else echo $blog_search_count; ?></div>

                <?php wp_reset_query(); wp_reset_postdata(); ?>

            </div><!-- /Content Center -->

            <div class="clear"></div>

    </div></div><!-- /Content Inner -->

</div><!-- /Content -->


<?php get_template_part ('footer');

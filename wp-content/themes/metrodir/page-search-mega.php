<?php

get_header();

if (isset($_GET['specification'])) $metrodir_megasearch_spec = $_GET['specification']; else $metrodir_megasearch_spec = '';
if (isset($_GET['s'])) $words = strtolower($_GET['s']); else $words = '';
if ($metrodir_megasearch_spec == "all")
    $posttype = array('post', 'company', 'event', 'product');
else
    $posttype = array($metrodir_megasearch_spec);

//Sidebar options
$opt_metrodir_sidebar = get_option('opt_metrodir_sidebar');
?>

<!-- Content --><div id="content" class="mega-search">

    <!-- Breadcrumbs --><div id="breadcrumbs"><div class="box-container">

        <div class="breadcrumbs-page-title"><h1><?php echo __('Global Search', 'metrodir') ?></h1></div>
        <div class="breadcrumbs">
            <span><a href="<?php echo home_url(); ?>"><?php echo __('Home', 'metrodir') ?></a> <i class="fa fa-chevron-right"></i> </span>
            <?php echo __('Global Search', 'metrodir') ?>
        </div>

    </div></div><!-- Breadcrumbs -->

    <!-- Content Inner --><div id="content-inner" class="sidebar-<?php echo $opt_metrodir_sidebar; ?>"><div class="box-container">

        <!-- Sidebar --><div id="sidebar">

            <?php get_template_part('/include/html/frame','sidebar-single'); ?>

        </div><!-- /Sidebar -->

        <!-- Content Center --><div id="content-center">

            <?php

                query_posts(array(
                    'post_type' => $posttype,
                    'posts_per_page' => -1,
                    'suppress_filters' => 1
                ));

                $search_count = 0;

            ?>

            <div class="title">
                <?php if (!($words) AND ($metrodir_megasearch_spec == "all")): ?>
                    <?php echo __('results','metrodir'); ?>
                <?php elseif (!($words) AND !($metrodir_megasearch_spec == "all")): ?>
                    <?php echo __('results for', 'metrodir').' "'.$metrodir_megasearch_spec.'"'; ?>
                <?php else: ?>
                    <?php echo __('results for search', 'metrodir').' "'.$words.'" and "'.$metrodir_megasearch_spec.'"'; ?>
                <?php endif; ?>
            </div>

            <?php if ($words OR $metrodir_megasearch_spec): ?>

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
                        $custom_fields = get_post_custom();
                        if(isset($custom_fields['metro_company_doc_desc'][0]) AND $custom_fields['metro_company_doc_desc'][0]){
                            $search_desc_text = $custom_fields['metro_company_doc_desc'][0];
                        } else {
                            $search_desc_text = '';
                        }
                        $search_desc_text = ' '.strtolower($search_desc_text);
                        $text = strtolower($words);
                        if ($text) {
                            $search_text_str = ' '.strtolower($search_text);
                            $text_result = strpos($search_text_str, $text, 0);
                            $desc_text_result = strpos($search_desc_text, $text, 0);
                        } else {
                            $text_result = true;
                        }

                        $post_id = get_the_ID();
                        $post_type = get_post_type($post_id);
                    ?>

                    <?php if ($title_result OR $text_result OR $desc_text_result): ?>

                        <?php if ($post_type == "company"): ?>
                            <?php get_template_part('/include/html/pattern','company'); ?>
                        <?php else: ?>
                            <?php get_template_part('/include/html/pattern','blog'); ?>
                        <?php endif; ?>

                        <?php $search_count++; ?>

                    <?php endif; ?>

                <?php endwhile; // end of the loop. ?>

                <div id="search-results" style="display: none;"><?php if ($search_count == 0) echo 'NO'; else if (!($words)) echo "ALL"; else echo $search_count; ?></div>

                <?php wp_reset_query(); wp_reset_postdata(); ?>

            <?php endif; ?>

        </div><!-- /Content Center -->

        <div class="clear"></div>

    </div></div><!-- /Content Inner -->

</div><!-- /Content -->

<?php get_template_part ('footer');
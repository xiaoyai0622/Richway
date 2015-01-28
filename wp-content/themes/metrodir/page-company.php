<?php
/*
Template Name: Company
*/

get_header();

//Sidebar options
$opt_metrodir_sidebar = get_option('opt_metrodir_sidebar');
//List Count
$opt_metrodir_company_list_count = get_option('opt_metrodir_company_list_count');
if ($opt_metrodir_company_list_count == "All") $opt_metrodir_company_list_count = -1;
//Search option
$opt_metrodir_search_def = get_option('opt_metrodir_search_def');
?>

<?php if ($opt_metrodir_search_def == "true"): ?>
    <?php get_template_part('/include/html/frame','search'); ?>
<?php endif; ?>

<?php get_template_part ('/include/html/str-home', 'map'); ?>

<?php get_template_part('/include/php/companymarkers'); ?>

<!-- Content --><div id="content" class="company-list">

    <!-- Content Inner --><div id="content-inner" class="sidebar-<?php echo $opt_metrodir_sidebar; ?>"><div class="box-container">

        <!-- Sidebar --><div id="sidebar"><?php get_template_part('/include/html/frame','sidebar')?></div><!-- /Sidebar -->

        <!-- Content Center --><div id="content-center">

            <div class="title">
                <h1><?php echo __('Company','metrodir'); ?></h1>
            </div>

            <?php
                global $wp_query;
                query_posts(array(
                    'paged' => $wp_query->get('paged'),
                    'post_type' => array('company'),
                    'posts_per_page' => $opt_metrodir_company_list_count
                ));
            ?>

            <?php if(function_exists('metrodir_pagenavi') && $wp_query->max_num_pages > 1): ?>
                <div class="pager-top">
                    <?php metrodir_pagenavi(); ?>
                </div>
            <?php endif; ?>

            <div id="company-list-block">
                <?php get_template_part('loop'); ?>
            </div>

            <?php if(function_exists('metrodir_pagenavi') && $wp_query->max_num_pages > 1): ?>
                <div class="pager-bottom">
                    <?php metrodir_pagenavi(); ?>
                </div>
            <?php endif; ?>

            <?php wp_reset_query(); wp_reset_postdata(); ?>

        </div><!-- /Content Center -->

        <div class="clear"></div>

    </div></div><!-- /Content Inner -->

</div><!-- /Content -->

<?php get_template_part ('footer');



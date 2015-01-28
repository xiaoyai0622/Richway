<?php

get_header();

if (isset($_GET['s'])) $metrodir_search_s = $_GET['s']; else $metrodir_search_s = '';
if (isset($_GET['where'])) $metrodir_search_location = $_GET['where']; else $metrodir_search_location = '';
if (isset($_GET['cat'])) $metrodir_search_cat = $_GET['cat']; else $metrodir_search_cat = '';
if (isset($_GET['company_category'])) $metrodir_search_category = $_GET['company_category']; else $metrodir_search_category = '';
if (isset($_GET['pageds'])) $metrodir_search_pageds = $_GET['pageds']; else $metrodir_search_pageds = 1;

//Sidebar option
$opt_metrodir_sidebar = get_option('opt_metrodir_sidebar');
$opt_metrodir_search_sidebar = get_option('opt_metrodir_search_sidebar');
//Search option
$opt_metrodir_search_def = get_option('opt_metrodir_search_def');
$opt_metrodir_search_style = get_option('opt_metrodir_search_style');
$opt_metrodir_search_fix_map = get_option('opt_metrodir_search_fix_map');
$opt_metrodir_search_fix_map_position = get_option('opt_metrodir_search_fix_map_position');
//Pages option
$opt_metrodir_search_subcat = get_option('opt_metrodir_search_subcat');
$opt_metrodir_search_list_count = get_option('opt_metrodir_search_list_count');
if ($opt_metrodir_search_list_count == "All") $opt_metrodir_search_list_count = -1;
?>

<?php if ($opt_metrodir_search_def == "true"): ?>
    <?php get_template_part('/include/html/frame','search'); ?>
<?php endif; ?>

<?php if ($opt_metrodir_search_fix_map == "true"): ?>
    <div id="fixed-map-container" class="position-<?php echo $opt_metrodir_search_fix_map_position; ?>">
<?php endif;?>

    <?php get_template_part ('/include/html/str-home','map'); ?>

<?php if ($opt_metrodir_search_fix_map == "true"): ?>
    </div>
<?php endif;?>

<?php get_template_part('/include/php/companymarkers'); ?>

<!-- Content --><div id="content" class="search-list">

    <!-- Content Inner --><div id="content-inner"<?php if ($opt_metrodir_search_sidebar == "true") echo ' class="sidebar-'.$opt_metrodir_sidebar.'"'; else echo ' class="without-sidebar"'; ?>><div class="box-container">

            <?php if ($opt_metrodir_search_sidebar == "true"): ?>
                <!-- Sidebar --><div id="sidebar">
                    <?php get_template_part('/include/html/frame','sidebar-single'); ?>
                </div><!-- /Sidebar -->
            <?php endif; ?>

            <!-- Content Center --><div id="content-center">

                <?php
                parse_str($_SERVER['QUERY_STRING']);

                if (!isset($orderby)) $orderby = "date";
                if (!isset($order)) $order = "ASC";
                if (!isset($company_category)) $company_category = '';

                $count_search_result = 0;
                ?>

                <div class="title<?php if ($company_category AND !$metrodir_search_s AND !$metrodir_search_location) echo ' category'; ?>">
                    <h1>
                        <?php if (!$metrodir_search_s AND !$metrodir_search_location AND !$company_category): ?>
                            <?php echo __('results', 'metrodir'); ?>
                        <?php elseif ($company_category AND !($metrodir_search_s) AND !($metrodir_search_location)): ?>
                            <?php $cat = get_term_by('slug', $company_category, 'company_category'); echo __('Category - ', 'metrodir').$cat->name; ?>
                        <?php else: ?>
                            <?php echo __('results for search', 'metrodir').' "'; ?>
                            <?php if ($metrodir_search_s) { echo $metrodir_search_s; } ?>
                            <?php if (($metrodir_search_s) AND (($metrodir_search_location) OR ($company_category))) {echo '" AND "'; } ?>
                            <?php if ($metrodir_search_location) { echo __('Location','metrodir').': '.$metrodir_search_location.' '; } ?>
                            <?php if ($metrodir_search_location AND $company_category) echo ', '; ?>
                            <?php  if ($company_category) { $cat = get_term_by('slug', $company_category, 'company_category'); echo __('Category','metrodir').': '.$cat->name; } ?>
                            <?php echo '"'; ?>
                        <?php endif; ?>
                    </h1>
                </div>

                <?php if ($opt_metrodir_search_subcat == "true"): ?>
                    <?php get_template_part('/include/html/frame','subcategories'); ?>
                <?php endif; ?>

                <?php if (!($company_category AND !$metrodir_search_s AND !$metrodir_search_location)): ?>
                    <!-- Search Sorting --><div id="search-sorting">

                        <form method="get" action="<?php echo home_url(); ?>/">

                            <input type="hidden" value="<?php echo $metrodir_search_s; ?>" name="s" id="sorting-s">
                            <input type="hidden" value="<?php echo $company_category; ?>" name="company_category" id="sorting-categories">
                            <input type="hidden" value="<?php echo $company_category; ?>" name="cat" id="sorting-categories">
                            <input type="hidden" value="<?php echo $metrodir_search_location; ?>" name="where" id="sorting-locations">
                            <input type="hidden" value="Search Now" name="search_simple" id="sorting-dir-search">

                            <div class="sortby">
                                <label for="orderby"><?php echo __('Sort by','metrodir').':'; ?></label>
                                <select id="sorting-sortby" name="orderby">
                                    <option value="date"><?php echo __('Date','metrodir'); ?></option>
                                    <option value="title"><?php echo __('Title','metrodir'); ?></option>
                                </select>
                            </div>

                            <div class="def-sortby" style="display:none"><?php echo $orderby; ?></div>

                            <div class="sort">
                                <label for="order"><?php echo __('Direction','metrodir').':'; ?></label>
                                <select id="sorting-sort" name="order">
                                    <option value="ASC">&and;</option>
                                    <option value="DESC">&or;</option>
                                </select>
                            </div>

                            <div class="def-sort" style="display:none"><?php echo $order; ?></div>

                        </form>

                        <div class="clear"></div>

                    </div><!-- /Search Sorting -->
                <?php endif; ?>

                <?php
                    global $wp_query;

                    if ($company_category) {
                        $q_args = array(
                            'post_type' => array('company'),
                            'posts_per_page' => $opt_metrodir_search_list_count,
                            'company_category' => $company_category,
                            'orderby' => $orderby,
                            'order' => $order,
                            'paged' => $metrodir_search_pageds,
                            's' => $metrodir_search_s,

                        );

                        if ($metrodir_search_location) {
                            $q_args['meta_query'] = array(
                                'relation' => 'AND',
                            );
/*
                            $q_args['meta_query'][] = array(
                                'key' => 'metro_address_zip',
                            );
*/
                            $q_args['meta_query'][] = array(
                                'key' => 'metro_address_country_name',
                            );

                            $q_args['meta_query'][] = array(
                                'key' => 'metro_address_region_name',
                            );

                            $q_args['meta_query'][] = array(
                                'key' => 'metro_address_name',
                            );

                            $q_args['meta_query'][] = array(
                                'value' => $metrodir_search_location,
                                'compare' => 'LIKE',
                            );
                        }

                        query_posts($q_args);
                    } else {
                        $q_args = array(
                            'post_type' => array('company'),
                            'posts_per_page' => $opt_metrodir_search_list_count,
                            'orderby' => $orderby,
                            'order' => $order,
                            'paged' => $metrodir_search_pageds,
                            's' => $metrodir_search_s,
                        );

                        if ($metrodir_search_location) {
                            $q_args['meta_query'] = array(
                                'relation' => 'AND',
                            );
/*
                            $q_args['meta_query'][] = array(
                                'key' => 'metro_address_zip',
                            );
*/
                            $q_args['meta_query'][] = array(
                                'key' => 'metro_address_country_name',
                            );

                            $q_args['meta_query'][] = array(
                                'key' => 'metro_address_region_name',
                            );

                            $q_args['meta_query'][] = array(
                                'key' => 'metro_address_name',
                            );

                            $q_args['meta_query'][] = array(
                                'value' => $metrodir_search_location,
                                'compare' => 'LIKE',
                            );
                        }

                        query_posts($q_args);
                    }

                ?>

                <?php if(function_exists('metrodir_pagenavi_search') && $wp_query->max_num_pages > 1): ?>
                    <?php if ($company_category AND !($metrodir_search_s) AND !($metrodir_search_location)) echo '<div class="pager-top">'; ?>
                        <?php metrodir_pagenavi_search(); ?>
                    <?php if ($company_category AND !($metrodir_search_s) AND !($metrodir_search_location)) echo '</div>'; ?>
                <?php endif; ?>

                <div class="search-results-container">

                    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

                        <?php if ($opt_metrodir_search_style == "default"): ?>
                            <?php get_template_part('/include/html/pattern','company'); ?>
                        <?php elseif ($opt_metrodir_search_style == "thumb"): ?>
                            <?php get_template_part('/include/html/pattern','company-thumb'); ?>
                        <?php endif; ?>

                        <?php $count_search_result++ ?>

                    <?php endwhile; // end of the loop. ?>

                </div>

                <?php if(function_exists('metrodir_pagenavi_search') && $wp_query->max_num_pages > 1): ?>
                    <?php metrodir_pagenavi_search(); ?>
                <?php endif; ?>

                <?php wp_reset_query(); wp_reset_postdata(); ?>

                <div id="search-results" style="display: none;"><?php if (!$metrodir_search_s AND !$metrodir_search_location AND !$company_category) echo "ALL"; else if ($company_category AND !($metrodir_search_s) AND !($metrodir_search_location)) echo ''; else if ($count_search_result == 0) echo 'NO'; else if ($count_search_result == $opt_metrodir_search_list_count) echo $count_search_result.' per page '; else echo $count_search_result; ?></div>

            </div><!-- /Content Center -->

            <div class="clear"></div>

        </div></div><!-- /Content Inner -->

</div><!-- /Content -->

<?php get_template_part ('footer');
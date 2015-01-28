<?php // Get variables

$opt_metrodir_sidebanner = get_option('opt_metrodir_site_sidebanner');
$opt_metrodir_sidebanner_url = get_option('opt_metrodir_site_sidebanner_url');
$opt_metrodir_sidebanner_window = get_option('opt_metrodir_site_sidebanner_window');
$opt_metrodir_sidebanner_nofollow = get_option('opt_metrodir_site_sidebanner_nofollow');

$opt_metrodir_sidebanner_1 = get_option('opt_metrodir_site_sidebanner_1');
$opt_metrodir_sidebanner_1_url = get_option('opt_metrodir_site_sidebanner_1_url');
$opt_metrodir_sidebanner_1_window = get_option('opt_metrodir_site_sidebanner_1_window');
$opt_metrodir_sidebanner_1_nofollow = get_option('opt_metrodir_site_sidebanner_1_nofollow');

$opt_metrodir_sidebanner_2 = get_option('opt_metrodir_site_sidebanner_2');
$opt_metrodir_sidebanner_2_url = get_option('opt_metrodir_site_sidebanner_2_url');
$opt_metrodir_sidebanner_2_window = get_option('opt_metrodir_site_sidebanner_2_window');
$opt_metrodir_sidebanner_2_nofollow = get_option('opt_metrodir_site_sidebanner_2_nofollow');

$opt_metrodir_sidebar_featured = get_option('opt_metrodir_sidebar_featured');
$opt_metrodir_sidebar_featured_count = get_option('opt_metrodir_sidebar_featured_count');

$opt_metrodir_sidebar_recently = get_option('opt_metrodir_sidebar_recently');
$opt_metrodir_sidebar_recently_count = get_option('opt_metrodir_sidebar_recently_count');

$opt_metrodir_sidebar_latest = get_option('opt_metrodir_sidebar_latest');
$opt_metrodir_sidebar_latest_count = get_option('opt_metrodir_sidebar_latest_count');

$opt_metrodir_sidebar_customblck_active = get_option('opt_metrodir_sidebar_customblck_active');
$opt_metrodir_sidebar_customblck_h2 = get_option('opt_metrodir_sidebar_customblck_h2');
$opt_metrodir_sidebar_customblck = get_option('opt_metrodir_sidebar_customblck');

?>

<?php if ($opt_metrodir_sidebar_featured == "true"): ?>
    <div id="featured-block">
        <div class="title">
            <h2><?php echo __('Featured','metrodir'); ?></h2>
        </div>
        <div class="featured-block-content">

            <?php
            global $wp_query;
            query_posts(array(
                'post_type' => array('company'),
                'meta_key' => 'metro_featured',
                'posts_per_page' => $opt_metrodir_sidebar_recently_count
            ));
            ?>

            <?php get_template_part('loop-sidebar')?>

            <?php wp_reset_query(); wp_reset_postdata(); ?>

        </div>
    </div>
<?php endif ?>

<?php if ($opt_metrodir_sidebar_recently == "true"): ?>
<div id="recently-added">
    <div class="title">
        <h2><?php echo __('Recently Added','metrodir'); ?></h2>
    </div>
    <div class="recently-added-content">

        <?php
            global $wp_query;
            query_posts(array(
                'post_type' => array('company'),
                'posts_per_page' => $opt_metrodir_sidebar_recently_count
            ));
        ?>

        <?php get_template_part('loop-sidebar')?>

        <?php wp_reset_query(); wp_reset_postdata(); ?>

    </div>
</div>
<?php endif ?>

<div id="two-images-banner">
    <?php if($opt_metrodir_sidebanner_1): ?>
        <a class="opacity" href="<?php echo $opt_metrodir_sidebanner_1_url; ?>" style="background-image: url(<?php echo $opt_metrodir_sidebanner_1; ?>);"<?php if ($opt_metrodir_sidebanner_1_nofollow == "true") echo ' rel="nofollow"'; if ($opt_metrodir_sidebanner_1_window == "true") echo ' target="_blank"'; ?>></a>
    <?php endif; ?>
    <?php if($opt_metrodir_sidebanner_2): ?>
        <a class="opacity" href="<?php echo $opt_metrodir_sidebanner_2_url; ?>" style="background-image: url(<?php echo $opt_metrodir_sidebanner_2; ?>);"<?php if ($opt_metrodir_sidebanner_2_nofollow == "true") echo ' rel="nofollow"'; if ($opt_metrodir_sidebanner_2_window == "true") echo ' target="_blank"'; ?>></a>
    <?php endif; ?>
    <div class="clear"></div>
</div>

<?php if ($opt_metrodir_sidebar_latest == "true"): ?>
<div id="latest-posts">
    <div class="title">
        <h2><?php echo __('Latest Posts','metrodir'); ?></h2>
    </div>
    <div class="recently-added-content">

        <?php
            global $wp_query;
            query_posts(array(
                'post_type' => array('post'),
                'posts_per_page' => $opt_metrodir_sidebar_latest_count
            ));
        ?>

        <?php get_template_part('loop-sidebar')?>

        <?php wp_reset_query(); wp_reset_postdata(); ?>

    </div>
</div>
<?php endif; ?>

<?php if($opt_metrodir_sidebanner): ?>
    <div id="one-image-banner">
        <a class="opacity" href="<?php echo $opt_metrodir_sidebanner_url; ?>" style="background-image: url(<?php echo $opt_metrodir_sidebanner; ?>);"<?php if ($opt_metrodir_sidebanner_nofollow == "true") echo ' rel="nofollow"'; if ($opt_metrodir_sidebanner_window == "true") echo ' target="_blank"'; ?>></a>
    </div>
<?php endif; ?>

<?php if ($opt_metrodir_sidebar_customblck_active == "true"): ?>
    <div id="custom-block">
        <div class="title">
            <h2><?php echo $opt_metrodir_sidebar_customblck_h2; ?></h2>
        </div>
        <div class="custom-block-content">

            <?php echo $opt_metrodir_sidebar_customblck; ?>

        </div>
    </div>
<?php endif ?>
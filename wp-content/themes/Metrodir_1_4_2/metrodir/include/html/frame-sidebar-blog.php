<?php
//Blog Categories
$args = array(
    'type' 			=> 'content',
    'orderby' 		=> 'name',
    'order' 		=> 'ASC',
    'hide_empty'	=> 1,
    'taxonomy'		=> 'category',
);
$categories = get_categories($args);

$opt_metrodir_sidebar_search = get_option('opt_metrodir_sidebar_search');

if (isset($_GET['s'])) $words = $_GET['s'];
?>

<?php if ($opt_metrodir_sidebar_search == "true"): ?>
    <div class="sidebar-search-block">
        <form id="sidebar-search" action="<?php echo home_url(); ?>">
            <input type="text" class="sidebar-search-input" name="s" for="s" placeholder="<?php echo __('Search', 'metrodir'); ?>"<?php if (isset($words)) echo ' value="'.$words.'"' ?>>
            <div class="submit"><i class="fa fa-search"></i><input type="submit" class="sidebar-search-submit" name="search_blog" value="search" /></div>
        </form>
    </div>
<?php endif; ?>

<div id="blog-categories">
    <div class="block-title">
        <h2><?php echo __('Categories','metrodir'); ?></h2>
    </div>
    <ul class="blog-categories-list">
        <?php foreach ($categories as $category ) : ?>
            <li class="blog-category">
                <a href="<?php echo home_url(); ?>/category/<?php echo $category->slug; ?>"><?php echo $category->name; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php get_template_part('/include/html/frame','sidebar'); ?>

<?php if ( !dynamic_sidebar('primary-widget-area') ): // start primary widget area ?>

    <div class="block-title">
        <h2><?php _e( 'Archives', 'metrodir' ); ?></h2>
    </div>

    <ul class="entries-list">
        <?php wp_get_archives( 'type=monthly' ); ?>
    </ul>

    <div class="block-title">
        <h2><?php _e( 'Meta', 'metrodir' ); ?></h2>
    </div>

    <ul class="meta">
        <?php wp_register(); ?>
        <li><?php wp_loginout(); ?></li>
        <?php wp_meta(); the_tags();?>
    </ul>

<?php endif; // end primary widget area ?>
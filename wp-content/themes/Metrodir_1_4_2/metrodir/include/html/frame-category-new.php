<?php
//Blog Categories
global $def_cat_style;

$opt_metrodir_home_category = get_option('opt_metrodir_home_category');
$opt_metrodir_home_category_image = get_option('opt_metrodir_home_category_image');

if (get_option('opt_metrodir_home_category_sub') == "true") {

    $categories = get_terms('company_category', array(
        'hide_empty'		=> false,
        'orderby'			=> 'name'
    ));

    $hCategories = array();

    uou_get_all_terms($categories, $hCategories);

    $categories = $hCategories;

} else {

    $args = array(
        'type' 			=> 'company',
        'orderby' 		=> 'name',
        'order' 		=> 'ASC',
        'hide_empty'	=> 1,
        'taxonomy'		=> 'company_category',
        'parent' => 0
    );

    $categories = get_categories($args);

}

$opt_metrodir_category_version = get_option('opt_metrodir_category_version');
?>

<?php if ($categories && ($opt_metrodir_home_category == "true")): ?>

    <!-- Categories New --><div id="categories-new" class="box-container"><div class="categories-new-container">

        <?php foreach ($categories as $category ): ?>

            <?php if ($category->count > 0): ?>

                <?php
                    $cat_id = $category->term_id;
                    $color = get_option( 'metrodir_category_'.$cat_id.'_color', '' );
                    $icon = get_option( 'metrodir_category_'.$cat_id.'_icon', '' );
                    $custom_icon = get_option( 'metrodir_category_'.$cat_id.'_icon_image', '' );
                    if ($opt_metrodir_home_category_image == "true") {
                        $image = get_option( 'metrodir_category_'.$cat_id.'_image', '' );
                    }
                ?>

                <div class="category-item-block<?php if ($opt_metrodir_category_version == "new-hidden") echo ' hidden'; ?>">

                    <div class="category-item-header<?php if ($opt_metrodir_category_version == "new-hidden") echo ' hidden'; ?>">

                        <?php if (isset($image) AND $image): ?>

                            <div class="category-item-image">
                                <?php if ($opt_metrodir_category_version == "new-hidden"): ?>
                                    <a class="opacity" style="background-image: url(<?php echo $image; ?>);"></a>
                                <?php else: ?>
                                    <a class="opacity" href="<?php echo get_term_link(intval($category->term_id), 'company_category'); ?>" title="<?php echo $category->name; ?>" style="background-image: url(<?php echo $image; ?>);"></a>
                                <?php endif; ?>
                            </div>

                        <?php else: ?>

                            <div class="category-item-icon<?php if ($custom_icon) echo ' custom'; ?>">

                                <?php if ($opt_metrodir_category_version == "new-hidden"): ?>
                                    <a title="<?php echo $category->name; ?>" style="background-color:<?php if ($color) echo $color; else if ($def_cat_style[$category->slug]["color"]) echo $def_cat_style[$category->slug]["color"]; else echo $def_cat_style["default"]["color"]; ?>;">
                                        <?php if ($custom_icon): ?>
                                            <i class="custom-icon" style="background-image: url(<?php echo $custom_icon ?>);"></i>
                                        <?php elseif ($icon): ?>
                                            <i class="fa <?php echo $icon; ?> fa-2x"></i>
                                        <?php elseif ($def_cat_style[$category->slug]["icon"]): ?>
                                            <i class="fa <?php echo $def_cat_style[$category->slug]["icon"]; ?> fa-2x"></i>
                                        <?php else: ?>
                                            <i class="fa <?php echo $def_cat_style["default"]["icon"]; ?> fa-2x"></i>
                                        <?php endif; ?>
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo get_term_link(intval($category->term_id), 'company_category'); ?>" title="<?php echo $category->name; ?>" style="background-color:<?php if ($color) echo $color; else if ($def_cat_style[$category->slug]["color"]) echo $def_cat_style[$category->slug]["color"]; else echo $def_cat_style["default"]["color"]; ?>;">
                                        <?php if ($custom_icon): ?>
                                            <i class="custom-icon" style="background-image: url(<?php echo $custom_icon ?>);"></i>
                                        <?php elseif ($icon): ?>
                                            <i class="fa <?php echo $icon; ?> fa-2x"></i>
                                        <?php elseif ($def_cat_style[$category->slug]["icon"]): ?>
                                            <i class="fa <?php echo $def_cat_style[$category->slug]["icon"]; ?> fa-2x"></i>
                                        <?php else: ?>
                                            <i class="fa <?php echo $def_cat_style["default"]["icon"]; ?> fa-2x"></i>
                                        <?php endif; ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                        <?php endif; ?>

                        <?php
                            $class_overflow = '';
                            $strlen_trnm = strlen ( $category->name );
                            if($strlen_trnm >= 14) {
                                $class_overflow = ' overflow';
                            }
                        ?>

                        <div class="category-item-title-container" style="background-color:<?php if ($color) echo $color; else if ($def_cat_style[$category->slug]["color"]) echo $def_cat_style[$category->slug]["color"]; else echo $def_cat_style["default"]["color"]; ?>;">

                            <?php if ($opt_metrodir_category_version == "new-hidden"): ?>
                                <a title="<?php echo $category->name; ?>">
                            <?php else: ?>
                                <a href="<?php echo get_term_link(intval($category->term_id), 'company_category'); ?>" title="<?php echo $category->name; ?>">
                            <?php endif; ?>

                                <div class="category-item-title<?php echo $class_overflow; ?>"><?php echo $category->name; ?></div>

                                <div class="category-item-count">(<?php echo $category->count; ?>)</div>

                            </a>

                        </div>

                    </div>

                    <div class="categories-item-list<?php if ($opt_metrodir_category_version == "new-hidden") echo ' hidden'; ?>">

                        <ul class="categories-item-list-menu">

                            <?php
                                query_posts(array(
                                    'post_type' => array('company'),
                                    'company_category' => $category->slug,
                                    'posts_per_page' => 5,
                                    'parent' => 0
                                ));
                            ?>

                            <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

                                <li>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </li>

                            <?php endwhile; ?>

                            <?php wp_reset_query(); ?>

                            <?php if($category->count >= 6): ?>

                                <li class="view-all">
                                    <a href="<?php echo get_term_link(intval($category->term_id), 'company_category'); ?>">
                                        <i class="fa fa-arrow-circle-right"></i>
                                        <?php echo __('View All','metrodir'); ?>
                                    </a>
                                </li>

                            <?php elseif($opt_metrodir_category_version == "new-hidden"): ?>

                                <li class="view-all">
                                    <a href="<?php echo get_term_link(intval($category->term_id), 'company_category'); ?>">
                                        <i class="fa fa-arrow-circle-right"></i>
                                        <?php echo __('Show Category Page','metrodir'); ?>
                                    </a>
                                </li>

                            <?php endif; ?>

                        </ul>

                    </div>

                </div>

                <?php if (!empty($category->children)): ?>

                    <?php foreach ($category->children as $subcategory ): ?>

                        <?php
                        $cat_id = $subcategory->term_id;
                        $color = get_option( 'metrodir_category_'.$cat_id.'_color', '' );
                        $icon = get_option( 'metrodir_category_'.$cat_id.'_icon', '' );
                        $custom_icon = get_option( 'metrodir_category_'.$cat_id.'_icon_image', '' );
                        if ($opt_metrodir_home_category_image == "true") {
                            $image = get_option( 'metrodir_category_'.$cat_id.'_image', '' );
                        }
                        ?>

                        <div class="category-item-block<?php if ($opt_metrodir_category_version == "new-hidden") echo ' hidden'; ?>">

                            <div class="category-item-header<?php if ($opt_metrodir_category_version == "new-hidden") echo ' hidden'; ?>">

                                <?php if (isset($image) AND $image): ?>

                                    <div class="category-item-image">
                                        <?php if ($opt_metrodir_category_version == "new-hidden"): ?>
                                            <a class="opacity" style="background-image: url(<?php echo $image; ?>);"></a>
                                        <?php else: ?>
                                            <a class="opacity" href="<?php echo get_term_link(intval($subcategory->term_id), 'company_category'); ?>" title="<?php echo $subcategory->name; ?>" style="background-image: url(<?php echo $image; ?>);"></a>
                                        <?php endif; ?>
                                    </div>

                                <?php else: ?>

                                    <div class="category-item-icon<?php if ($custom_icon) echo ' custom'; ?>">

                                        <?php if ($opt_metrodir_category_version == "new-hidden"): ?>
                                            <a title="<?php echo $subcategory->name; ?>" style="background-color:<?php if ($color) echo $color; else if ($def_cat_style[$subcategory->slug]["color"]) echo $def_cat_style[$subcategory->slug]["color"]; else echo $def_cat_style["default"]["color"]; ?>;">
                                                <?php if ($custom_icon): ?>
                                                    <i class="custom-icon" style="background-image: url(<?php echo $custom_icon ?>);"></i>
                                                <?php elseif ($icon): ?>
                                                    <i class="fa <?php echo $icon; ?> fa-2x"></i>
                                                <?php elseif ($def_cat_style[$subcategory->slug]["icon"]): ?>
                                                    <i class="fa <?php echo $def_cat_style[$subcategory->slug]["icon"]; ?> fa-2x"></i>
                                                <?php else: ?>
                                                    <i class="fa <?php echo $def_cat_style["default"]["icon"]; ?> fa-2x"></i>
                                                <?php endif; ?>
                                            </a>
                                        <?php else: ?>
                                            <a href="<?php echo get_term_link(intval($subcategory->term_id), 'company_category'); ?>" title="<?php echo $subcategory->name; ?>" style="background-color:<?php if ($color) echo $color; else if ($def_cat_style[$subcategory->slug]["color"]) echo $def_cat_style[$subcategory->slug]["color"]; else echo $def_cat_style["default"]["color"]; ?>;">
                                                <?php if ($custom_icon): ?>
                                                    <i class="custom-icon" style="background-image: url(<?php echo $custom_icon ?>);"></i>
                                                <?php elseif ($icon): ?>
                                                    <i class="fa <?php echo $icon; ?> fa-2x"></i>
                                                <?php elseif ($def_cat_style[$subcategory->slug]["icon"]): ?>
                                                    <i class="fa <?php echo $def_cat_style[$subcategory->slug]["icon"]; ?> fa-2x"></i>
                                                <?php else: ?>
                                                    <i class="fa <?php echo $def_cat_style["default"]["icon"]; ?> fa-2x"></i>
                                                <?php endif; ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                <?php endif; ?>

                                <?php
                                $class_overflow = '';
                                $strlen_trnm = strlen ( $subcategory->name );
                                if($strlen_trnm >= 14) {
                                    $class_overflow = ' overflow';
                                }
                                ?>

                                <div class="category-item-title-container" style="background-color:<?php if ($color) echo $color; else if ($def_cat_style[$subcategory->slug]["color"]) echo $def_cat_style[$subcategory->slug]["color"]; else echo $def_cat_style["default"]["color"]; ?>;">

                                    <?php if ($opt_metrodir_category_version == "new-hidden"): ?>
                                    <a title="<?php echo $subcategory->name; ?>">
                                        <?php else: ?>
                                        <a href="<?php echo get_term_link(intval($subcategory->term_id), 'company_category'); ?>" title="<?php echo $subcategory->name; ?>">
                                            <?php endif; ?>

                                            <div class="category-item-title<?php echo $class_overflow; ?>"><?php echo $subcategory->name; ?></div>

                                            <div class="category-item-count">(<?php echo $subcategory->count; ?>)</div>

                                        </a>

                                </div>

                            </div>

                            <div class="categories-item-list<?php if ($opt_metrodir_category_version == "new-hidden") echo ' hidden'; ?>">

                                <ul class="categories-item-list-menu">

                                    <?php
                                    query_posts(array(
                                        'post_type' => array('company'),
                                        'company_category' => $subcategory->slug,
                                        'posts_per_page' => 5,
                                        'parent' => 0
                                    ));
                                    ?>

                                    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

                                        <li>
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </li>

                                    <?php endwhile; ?>

                                    <?php wp_reset_query(); ?>

                                    <?php if($subcategory->count >= 6): ?>

                                        <li class="view-all">
                                            <a href="<?php echo get_term_link(intval($subcategory->term_id), 'company_category'); ?>">
                                                <i class="fa fa-arrow-circle-right"></i>
                                                <?php echo __('View All','metrodir'); ?>
                                            </a>
                                        </li>

                                    <?php elseif($opt_metrodir_category_version == "new-hidden"): ?>

                                        <li class="view-all">
                                            <a href="<?php echo get_term_link(intval($subcategory->term_id), 'company_category'); ?>">
                                                <i class="fa fa-arrow-circle-right"></i>
                                                <?php echo __('Show Category Page','metrodir'); ?>
                                            </a>
                                        </li>

                                    <?php endif; ?>

                                </ul>

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php endif; ?>

            <?php endif; ?>

        <?php endforeach; ?>

    <div class="clear"></div></div></div><!-- /Categories New -->

<?php endif; ?>
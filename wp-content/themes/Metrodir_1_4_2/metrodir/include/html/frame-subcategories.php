<?php // Get variables
    global $def_cat_style;

    $get_id_parent_cat = get_term_by( 'slug', $company_category, 'company_category' );

    $args = array(
        'child_of' => $get_id_parent_cat->term_id ,
        'parent' => get_query_var(''),
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => 0,
        'hierarchical' => 1,
        'taxonomy' => 'company_category',
        'pad_counts' => true );

    $categories = get_categories($args);
?>

<?php if (count($categories) > 0): ?>

    <div class="subcategories-items-list">

        <?php foreach($categories as $category): ?>

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

        </div>

        <?php endforeach; ?>

    <div class="clear"></div>

    </div>

<?php endif;
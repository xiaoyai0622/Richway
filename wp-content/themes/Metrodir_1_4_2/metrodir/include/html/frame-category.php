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

?>


<?php if ($categories && ($opt_metrodir_home_category == "true")): ?>

    <!-- Categories --><div id="categories" class="box-container"><ul class="categories-menu">

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

                    <?php if (isset($image) AND $image): ?>

                        <li class="categories-menu-item-image">
                            <a class="opacity" href="<?php echo get_term_link(intval($category->term_id), 'company_category'); ?>" title="<?php echo $category->name; ?>" style="background-image: url(<?php echo $image; ?>);">
                                <span class="name"><?php echo $category->name; ?></span>
                            </a>
                        </li>

                    <?php else: ?>

                        <li class="categories-menu-item">
                            <a href="<?php echo get_term_link(intval($category->term_id), 'company_category'); ?>" title="<?php echo $category->name; ?>" style="background:<?php if ($color) echo $color; else if ($def_cat_style[$category->slug]["color"]) echo $def_cat_style[$category->slug]["color"]; else echo $def_cat_style["default"]["color"]; ?>;">
                                <?php if ($custom_icon): ?>
                                    <i class="custom-icon" style="background-image: url(<?php echo $custom_icon ?>)"></i>
                                <?php elseif ($icon): ?>
                                    <i class="fa <?php echo $icon; ?> fa-2x"></i>
                                <?php elseif ($def_cat_style[$category->slug]["icon"]): ?>
                                    <i class="fa <?php echo $def_cat_style[$category->slug]["icon"]; ?> fa-2x"></i>
                                <?php else: ?>
                                    <i class="fa <?php echo $def_cat_style["default"]["icon"]; ?> fa-2x"></i>
                                <?php endif; ?>
                                <span class="name"><?php echo $category->name; ?></span>
                            </a>
                        </li>

                    <?php endif; ?>

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

                            <?php if (isset($image) AND $image): ?>

                                <li class="categories-menu-item-image">
                                    <a class="opacity" href="<?php echo get_term_link(intval($subcategory->term_id), 'company_category'); ?>" title="<?php echo $subcategory->name; ?>" style="background-image: url(<?php echo $image; ?>);">
                                        <span class="name"><?php echo $subcategory->name; ?></span>
                                    </a>
                                </li>

                            <?php else: ?>

                                <li class="categories-menu-item">
                                    <a href="<?php echo get_term_link(intval($subcategory->term_id), 'company_category'); ?>" title="<?php echo $subcategory->name; ?>" style="background:<?php if ($color) echo $color; else if ($def_cat_style[$subcategory->slug]["color"]) echo $def_cat_style[$subcategory->slug]["color"]; else echo $def_cat_style["default"]["color"]; ?>;">
                                        <?php if ($custom_icon): ?>
                                            <i class="custom-icon" style="background-image: url(<?php echo $custom_icon ?>)"></i>
                                        <?php elseif ($icon): ?>
                                            <i class="fa <?php echo $icon; ?> fa-2x"></i>
                                        <?php elseif ($def_cat_style[$subcategory->slug]["icon"]): ?>
                                            <i class="fa <?php echo $def_cat_style[$subcategory->slug]["icon"]; ?> fa-2x"></i>
                                        <?php else: ?>
                                            <i class="fa <?php echo $def_cat_style["default"]["icon"]; ?> fa-2x"></i>
                                        <?php endif; ?>
                                        <span class="name"><?php echo $subcategory->name; ?></span>
                                    </a>
                                </li>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    <?php endif; ?>

                <?php endif; ?>

            <?php endforeach; ?>

        </ul><div class="clear"></div></div><!-- /Categories -->

<?php endif; ?>
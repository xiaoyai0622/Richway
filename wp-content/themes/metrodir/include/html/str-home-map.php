<?php
//Companies Categories

global $def_cat_style;

if (get_option('opt_metrodir_map_subcat') == "true") {

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


if(isset($_GET['adv-submit'])){
    $company_category = $_GET['company_category'];
}

$opt_metrodir_search_def = get_option('opt_metrodir_search_def');
?>

<!-- Map Wrapper --><div id="map-wrapper"<?php if (get_option('opt_metrodir_map_hide') == "true") echo ' class="load-hide"'; ?>>

    <!-- Map --><div id = "map" class = "map"><div id = "map-frame" class = "map-frame"></div></div><!-- /Map -->

    <!-- Map Control Button --><div id="map-control">

        <div class="map-control hide"><a href="#" id="hide-map-button" class="hide-map-button map-expanded"><i class="fa fa-chevron-circle-up"></i><span><?php echo __('Hide Map','metrodir'); ?></span></a></div>

        <div class="map-control show"><a href="#" id="show-map-button" class="show-map-button map-collapsed"><i class="fa fa-chevron-circle-down"></i><span><?php echo __('Show Map','metrodir'); ?></span></a></div>

    </div><!-- /Map Control Button -->

    <?php $map_disablebtn = get_option('opt_metrodir_map_disablebtn'); if($map_disablebtn == "true"): ?>
        <!-- Map Contron --><div class="disable-map-control"><a href="#" id="disable-map-button" class="disable-map-button map-enable"><i class="fa fa-unlock fa-2x"></i></a></div><!-- /Map Contron -->
    <?php endif; ?>

    <!-- Map Trobber --><div id = "map-trobber"></div><!-- Map Trobber -->

    <!-- Map Error --><div id = "map-error"><span><?php echo __('No search results','metrodir').'.'; ?></span></div><!-- Map Error -->

</div><!-- /Map Wrapper -->

<?php if ($categories): ?>
    <!-- Industries Tabs --><div id="industries-tabs">
        <ul class="industries-tabs box-container">
            <li class="label"><?php echo __('Show on map','metrodir'); ?></li>
            <?php
            $index = 0;
            foreach ($categories as $category ) {
                if (($category->slug) && ($category->count > 0)) {
                    $cat_id = $category->term_id;
                    $icon = get_option( 'metrodir_category_'.$cat_id.'_icon', '' );
                    $color = get_option( 'metrodir_category_'.$cat_id.'_color', '' );
                    $custom_icon = get_option( 'metrodir_category_'.$cat_id.'_icon_image', '' );
                    $index++;
                    $class = '';
                    if ((isset($company_category) AND $company_category == '') AND ($index == 1)) {$class = $class.' active';}
                    else if (isset($company_category) AND $category->slug == $company_category) {$class = $class.' active';}
                    if ($index == 1) $class = $class.' first';
                    if ($color) {
                        echo'<li class="'. $class.'"><a href="#" id="'.$category->slug.'" class="'.$category->slug.'" title="'.$category->name.'" style="border: 1px solid '.$color.'; background-color: '.$color.';">';
                    } else if ($def_cat_style[$category->slug]['color']) {
                        echo'<li class="'. $class.'"><a href="#" id="'.$category->slug.'" class="'.$category->slug.'" title="'.$category->name.'" style="border: 1px solid '.$def_cat_style[$category->slug]['color'].'; background-color: '.$def_cat_style[$category->slug]['color'].';">';
                    } else {
                        echo'<li class="'. $class.'"><a href="#" id="'.$category->slug.'" class="'.$category->slug.'" title="'.$category->name.'" style="border: 1px solid '.$def_cat_style["default"]['color'].'; background-color: '.$def_cat_style["default"]['color'].';">';
                    }
                    echo '<i class="';
                    if ($custom_icon) {
                        echo 'custom-icon" style="background-image: url('.$custom_icon.')';
                    } else if ($icon) {
                        echo 'fa '.$icon;
                    } else if ($def_cat_style[$category->slug]['icon']) {
                        echo 'fa '.$def_cat_style[$category->slug]['icon'];
                    } else {
                        echo 'fa '.$def_cat_style["default"]['icon'];
                    }
                    echo '"></i></a></li>';
                    if (!empty($category->children)) {
                        foreach ($category->children as $subcategory ) {
                            if (($subcategory->slug) && ($subcategory->count > 0)) {
                                $cat_id = $subcategory->term_id;
                                $icon = get_option( 'metrodir_category_'.$cat_id.'_icon', '' );
                                $color = get_option( 'metrodir_category_'.$cat_id.'_color', '' );
                                $custom_icon = get_option( 'metrodir_category_'.$cat_id.'_icon_image', '' );
                                $index++;
                                $class = '';
                                if ((isset($company_category) AND $company_category == '') AND ($index == 1)) {$class = $class.' active';}
                                else if (isset($company_category) AND $subcategory->slug == $company_category) {$class = $class.' active';}
                                if ($index == 1) $class = $class.' first';
                                if ($color) {
                                    echo'<li class="'. $class.'"><a href="#" id="'.$subcategory->slug.'" class="'.$subcategory->slug.'" title="'.$subcategory->name.'" style="border: 1px solid '.$color.'; background-color: '.$color.';">';
                                } else if ($def_cat_style[$subcategory->slug]['color']) {
                                    echo'<li class="'. $class.'"><a href="#" id="'.$subcategory->slug.'" class="'.$subcategory->slug.'" title="'.$subcategory->name.'" style="border: 1px solid '.$def_cat_style[$subcategory->slug]['color'].'; background-color: '.$def_cat_style[$subcategory->slug]['color'].';">';
                                } else {
                                    echo'<li class="'. $class.'"><a href="#" id="'.$subcategory->slug.'" class="'.$subcategory->slug.'" title="'.$subcategory->name.'" style="border: 1px solid '.$def_cat_style["default"]['color'].'; background-color: '.$def_cat_style["default"]['color'].';">';
                                }
                                echo '<i class="';
                                if ($custom_icon) {
                                    echo 'custom-icon" style="background-image: url('.$custom_icon.')';
                                } else if ($icon) {
                                    echo 'fa '.$icon;
                                } else if ($def_cat_style[$subcategory->slug]['icon']) {
                                    echo 'fa '.$def_cat_style[$subcategory->slug]['icon'];
                                } else {
                                    echo 'fa '.$def_cat_style["default"]['icon'];
                                }
                                echo '"></i></a></li>';
                            }
                        }
                    }
                }
            }
            ?>
        </ul>

        <!-- Searching Category --><div id="company_category_search" style="display: none;"><?php if (isset($company_category)) echo $company_category; ?></div><!-- /Searching Category -->

        <?php if ($opt_metrodir_search_def == "false"): ?>
            <!-- Sorting Category --><select style="display: none;"  id="category-selector-default" class="category-selector-default" name="company_category">
                <?php
                $categories = get_terms('company_category', array(
                    'hide_empty'		=> false,
                    'orderby'			=> 'name'
                ));
                $hCategories = array();

                uou_get_all_terms($categories, $hCategories);

                echo uou_generate_list($hCategories, $company_category);
                ?>
            </select><!-- /Sorting Category -->
        <?php endif; ?>

    </div><!-- /Industries Tabs -->

<?php endif; ?>

<?php
//Get Variables
if (isset($_GET['search_simple'])) {
    if (isset($_GET['s'])) $metrodir_search_s = $_GET['s'];
    if (isset($_GET['where'])) $metrodir_search_location = $_GET['where'];
}
$opt_metrodir_home_defcat = get_option('opt_metrodir_home_defcat');
$metrodir_search_category = '';
if (is_front_page() AND $opt_metrodir_home_defcat != "Select a category:") {
    $metrodir_search_category = strtolower($opt_metrodir_home_defcat);
} else if (isset($_GET['cat'])) {
    if (isset($_GET['cat'])) $metrodir_search_category = $_GET['cat'];
} else if (isset($_GET['company_category'])) {
    if (isset($_GET['company_category'])) $metrodir_search_category = $_GET['company_category'];
} else {
    if (isset($company_category)) $metrodir_search_category = $company_category;
}
//Site Options
$opt_metrodir_search_adv = get_option('opt_metrodir_search_adv');
$opt_metrodir_search_radius = get_option('opt_metrodir_search_radius');
$opt_metrodir_search_dist_min = get_option('opt_metrodir_search_dist_min');
$opt_metrodir_search_dist_max = get_option('opt_metrodir_search_dist_max');
$opt_metrodir_search_dist_def = get_option('opt_metrodir_search_dist_def');
$opt_metrodir_search_dist_kmmi =  get_option('opt_metrodir_map_kmmi');
$opt_metrodir_search_days_max =  get_option('opt_metrodir_search_days_max');
//Need to Know
$opt_metrodir_home_version = get_option('opt_metrodir_home_version');
$opt_metrodir_home_search_rev = get_option('opt_metrodir_home_search_rev');

?>

<!-- Search --><div id="search" class="<?php if($opt_metrodir_search_adv == 'true') echo 'with-advanced'; else echo 'without-advanced'; if ($opt_metrodir_home_version == "strv") echo ' without-map'; if ($opt_metrodir_home_version == "slider") echo ' with-slider'; ?>"><div id="search-shadow"></div><div class="box-container">

    <?php if($opt_metrodir_search_adv == 'true'): ?>
    <!-- Advanced Search Button --><div class="advanced-search-control">
        <a href="#" class="advanced-search-button show" title="<?php echo __('Show Advanced Search','metrodir'); ?>"><i class="fa fa-align-justify"></i></a>
        <a href="#" class="advanced-search-button hide" title="<?php echo __('Hide Advanced Search','metrodir'); ?>"><i class="fa fa-align-justify"></i></a>
    </div><!-- /Advanced Search Button -->
    <?php endif; ?>

    <!-- Default Search --><form id="default-search" class="default-search clearfix" role="search" action="<?php echo home_url(); ?>" >
        <input type="text" id="search-what"  class="text-input-black input-text" name="s" placeholder="<?php echo __('Insert company name','metrodir'); ?>" value="<?php if (isset($metrodir_search_s)) echo $metrodir_search_s; ?>" />
        <input type="text" id="search-where" class="text-input-black input-text" name="where" placeholder="<?php echo __('Select a location','metrodir'); ?>" autocomplete="off"  value="<?php if (isset($metrodir_search_location)) echo $metrodir_search_location; ?>" />
        <select  id="category-selector-default" class="category-selector-default" name="company_category" tabindex="1" onchange="jQuery('#scategory-input-default').focus().val(jQuery(this).val()).select();">
            <option value=""><?php echo  '- '.__('Select Category','metrodir').' -'; ?></option>
            <?php
            $categories = get_terms('company_category', array(
                'hide_empty'		=> false,
                'orderby'			=> 'name'
            ));
            $hCategories = array();

            uou_get_all_terms($categories, $hCategories);

            echo uou_generate_list($hCategories, $metrodir_search_category);
            ?>
        </select>

        <?php
        global $wp_query;
        query_posts(array(
            'paged' => $wp_query->get('paged'),
            'post_type' => array('company'),
            'posts_per_page' => -1
        )); ?>

        <?php $index = 0; if ( have_posts() ) while ( have_posts() ) : the_post();

            $index++;

            $companus[$index][1] = get_the_title();

            $terms = get_the_terms( $post->ID, 'company_category' );
            $item_cats = array();
            $item_cats_slugs = array();
            $i = 0;
            if(is_array($terms)) {
                foreach ($terms as $term ) {
                    $i++;
                    $item_cats_slugs[$i] = $term->slug;
                }
            } else {
                $item_cats_slugs[1] = "nocat";
                $i = 1;
            }
            if ($i == 1) {
                $companus[$index][2] = $item_cats_slugs[1];
                $custom_fields = get_post_custom();
                $country = $custom_fields['metro_address_country_name'][0];
                $region = $custom_fields['metro_address_region_name'][0];
                $name = $custom_fields['metro_address_name'][0];

                $item_addr_lat = $custom_fields['metro_address_lat'][0];
                $item_addr_lng = $custom_fields['metro_address_lng'][0];

                $places[$index][1] = $country;
                $places[$index][2] = $region;
                $places[$index][3] = $name;
                $address = "";
                if (($country) AND ($region) AND ($name)) {
                    $address = $country.', '.$region.', '.$name;
                } else if (($country) AND ($region)) {
                    $address = $country.', '.$region;
                } else if (($country) AND ($name)) {
                    $address = $country.', '.$name;
                } else if (($region) AND ($name)) {
                    $address = $region.', '.$name;
                } else if ($country) {
                    $address = $country;
                } else if ($region) {
                    $address = $region;
                } else if ($name) {
                    $address = $name;
                }
                $companus[$index][3] = $item_addr_lat;
                $companus[$index][4] = $address;
                $companus[$index][5] = get_permalink();
                $companus[$index][6] = get_the_post_thumbnail();
                $companus[$index][7] = $item_addr_lng;
            } else if ($i > 1) {
                $companus[$index][2] = $item_cats_slugs[1];
                $custom_fields = get_post_custom();
                $country = $custom_fields['metro_address_country_name'][0];
                $region = $custom_fields['metro_address_region_name'][0];
                $name = isset($custom_fields['metro_address_name'][0]);

                $item_addr_lat = $custom_fields['metro_address_lat'][0];
                $item_addr_lng = $custom_fields['metro_address_lng'][0];

                $places[$index][1] = $country;
                $places[$index][2] = $region;
                $places[$index][3] = $name;
                $address = "";
                if (($country) AND ($region) AND ($name)) {
                    $address = $country.', '.$region.', '.$name;
                } else if (($country) AND ($region)) {
                    $address = $country.', '.$region;
                } else if (($country) AND ($name)) {
                    $address = $country.', '.$name;
                } else if (($region) AND ($name)) {
                    $address = $region.', '.$name;
                } else if ($country) {
                    $address = $country;
                } else if ($region) {
                    $address = $region;
                } else if ($name) {
                    $address = $name;
                }
                $companus[$index][3] = $item_addr_lat;
                $companus[$index][4] = $address;
                $companus[$index][5] = get_permalink();
                $companus[$index][6] = get_the_post_thumbnail();
                $companus[$index][7] = $item_addr_lng;
                for ($k = 2; $k <= $i; $k++) {
                    $index++;
                    $companus[$index][1] = $companus[$index - 1][1];
                    $companus[$index][2] = $item_cats_slugs[$k];
                    $companus[$index][3] = $companus[$index - 1][3];
                    $companus[$index][4] = $companus[$index - 1][4];
                    $companus[$index][5] = $companus[$index - 1][5];
                    $companus[$index][6] = $companus[$index - 1][6];
                    $companus[$index][7] = $companus[$index - 1][7];
                    $places[$index][1] = $places[$index - 1][1];
                    $places[$index][2] = $places[$index - 1][2];
                    $places[$index][3] = $places[$index - 1][3];
                }
            }
        endwhile;
        ?>
        <input type="text" id="scategory-input-default" style="display: none;" name="cat"/>
        <div class="submit"><i class="fa fa-search"></i><input type="submit" class="submit" value="<?php echo __('Search Now','metrodir'); ?>" title="<?php echo __('Search Now','metrodir'); ?>" name="search_simple" /></div>
        <div class="clear"></div>
    </form><!-- /Default Search -->

    <?php if($opt_metrodir_search_adv == 'true'): ?>
    <!-- Advanced Search --><div id="adv-search-container"><div class="box-container"><form id="advanced-search" class="advanced-search search-collapsed clearfix"  action="<?php echo home_url(); ?>">
        <?php if($opt_metrodir_search_radius == "true"): ?>
            <div class="clearfix">
                <div class="label"><?php echo __('Distance around my position','metrodir').':'; ?></div>
                <div id="slider-distance" class="slider"></div>
                <div id="distance" class="slider-value"></div>
            </div>
        <?php endif; ?>

        <div class="clearfix" style="display: none">
            <div class="label"><?php echo __('Rating','metrodir').':'; ?></div>
            <div id="slider-rating" class="slider"></div>
            <div id="rating" class="slider-value"></div>
        </div>
        <div class="clearfix">
            <div class="label"><?php echo __('Days Published','metrodir').':'; ?></div>
            <div id="slider-days-published" class="slider"></div>
            <div id="days-published" class="slider-value"></div>
        </div>
        <div class="location-fields clearfix">
            <div class="label"><?php echo __('Location','metrodir').':'; ?></div>
            <select id="country-selector-advanced" name="where" tabindex="1">
                <option value=""><?php echo __('Country','metrodir'); ?></option>

                <?php
                $places_count = 1;
                for ($index = 1; $index <= count($places); $index++) {

                    if ($places[$index][1]) {
                        $counter = 0;
                        if(isset($places_filtered)){
                            for ($i = 1; $i <= count($places_filtered); $i++ ) {
                                if ($places_filtered[$i] == $places[$index][1]) {
                                    $counter++;
                                }
                            }
                        }
                        if ($counter == 0) {
                            $places_filtered[$places_count] = $places[$index][1];
                            $places_count++;
                        }
                    }
                }
                if (isset($places_filtered)) {
                    asort($places_filtered);
                    $index = 0;
                    foreach($places_filtered as $places) {
                        $index++;
                        $places = preg_replace('/([^\pL\pN\pP\pS\pZ])|([\xC2\xA0])/u', ' ', $places);
                        $places = str_replace('  ',' ', $places);
                        $places = trim($places);
                        $places_filtered_val = str_replace(' ', '_', $places);
                        echo '<option value="'.strtolower($places_filtered_val).'">'.$places.'</option>';
                        if ($index != count($places_filtered)) {echo ' ';}
                    }
                }

                ?>
            </select>
            <input type="text" class="input-region text-input-black" placeholder="<?php echo __('Region','metrodir'); ?>" name="region" />
            <input type="text" class="input-city text-input-black" placeholder="<?php echo __('Address','metrodir'); ?>" name="address" />
        </div>
        <div class="clearfix">
            <div class="label"><?php echo __('Industry','metrodir').':'; ?></div>
            <select id="category-selector-advanced" name="company_category" tabindex="1">
                <option value=""><?php echo '- '.__('Select','metrodir').' -'; ?></option>
                <?php
                $categories = get_terms('company_category', array(
                    'hide_empty'		=> false,
                    'orderby'			=> 'name'
                ));
                $hCategories = array();

                uou_get_all_terms($categories, $hCategories);

                echo uou_generate_list($hCategories,$metrodir_search_category);
                ?>
            </select>
        </div>
        <?php
        $name_field = add_fields_search();
        $count_field = count($name_field);

        for ($ind = 0; $ind < $count_field; $ind++) {
            $addfields[$ind][0] = $name_field[$ind];
            $value = 'opt_metrodir_advsearch_fields_'.$ind.'';
            $addfields[$ind][1]= get_option($value);
            if($addfields[$ind][1] == "true"):?>
                <div class="clearfix">
                    <div class="label"><?php echo $addfields[$ind][0]; ?>:</div>
                    <input type="text" class="input-additional text-input-black" placeholder="<?php echo  $addfields[$ind][0]; ?>" name="<?php echo  strtolower($addfields[$ind][0]); ?>"/>
                </div>
            <?php
            endif;
        }
        ?>

        <?php
        $name_field = add_type_fields_search();
        $count_field = count($name_field);

        for ($ind = 0; $ind < $count_field; $ind++) {
            $addfields[$ind][0] = $name_field[$ind];
            $value = 'opt_metrodir_advsearch_fields_type_'.$ind.'';
            $addfields[$ind][1]= get_option($value);
            if($addfields[$ind][1] == "true"):?>
                <div class="clearfix">
                    <div class="label">
                        <?php $fied_type_echo = str_replace('-',' ',$addfields[$ind][0]); $fied_type_echo = str_replace('_',' ',$fied_type_echo); echo $fied_type_echo; ?>:</div>
                    <input type="text" class="input-additional text-input-black" placeholder="<?php echo  $fied_type_echo; ?>" name="<?php echo  strtolower($addfields[$ind][0]); ?>"/>
                </div>
            <?php
            endif;
        }
        ?>
        <div class="clearfix"><div class="submit"><i class="fa fa-search"></i><input type="submit" class="submit" value="<?php echo __('Search Now','metrodir'); ?>" title="<?php echo __('Search Now','metrodir'); ?>" name="adv_search" /></div></div>

        <input id="distance-input" name="distance" style="display: none" />
        <input id="rating-input" name="rating" style="display: none"/>
        <input id="days-published-input" name="days" style="display: none"/>
    </form></div></div><!-- /Advanced Search -->
    <?php endif; ?>

    <!-- Search Params --><div id="search-params" style="display: none">
        <?php
        if($opt_metrodir_search_dist_kmmi){
            echo '<div class="abrv">'.$opt_metrodir_search_dist_kmmi.'</div>';
        } else {
            echo '<div class="abrv">'.__('km','metrodir').'</div>';
        }
        echo '<div class="mininmum">'.$opt_metrodir_search_dist_min.'</div>';
        echo '<div class="maximum">'.$opt_metrodir_search_dist_max.'</div>';
        echo '<div class="default">'.$opt_metrodir_search_dist_def.'</div>';

        if($opt_metrodir_search_days_max){
            echo '<div class="dmax">'.$opt_metrodir_search_days_max.'</div>';
        } else {
            echo '<div class="dmax">300</div>';
        }
        ?>
    </div><!-- /Search Params -->

</div></div><div class="clear"></div><!-- /Search -->


<?php wp_reset_query(); wp_reset_postdata();
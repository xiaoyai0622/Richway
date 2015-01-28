<?php

get_header();

// Get variables MetroDir_Options
//Search options
$opt_metrodir_search_radius = get_option('opt_metrodir_search_radius');
//Page options;
$opt_metrodir_search_subcat = get_option('opt_metrodir_search_subcat');
//Sidebar options
$opt_metrodir_sidebar = get_option('opt_metrodir_sidebar');
$opt_metrodir_search_sidebar = get_option('opt_metrodir_search_sidebar');
//Search option
$opt_metrodir_search_def = get_option('opt_metrodir_search_def');
$opt_metrodir_search_style = get_option('opt_metrodir_search_style');
//List Count
$opt_metrodir_company_list_count = get_option('opt_metrodir_company_list_count');
//Default Markers Style
$metrodir_markers_type = get_option('opt_metrodir_markers_type');
$metrodir_markers_info = get_option('opt_metrodir_markers_info');
global $def_cat_style;
//Search Get Params
if (isset($_GET['company_category'])) $company_category = $_GET['company_category'];
if (isset($_GET['where'])) {
    $metrodir_search_location_get =  $_GET['where'];
    $metrodir_search_location = str_replace("_", " ", $metrodir_search_location_get);
}
if (isset($_GET['region'])) $metrodir_search_region = $_GET['region'];
if (isset($_GET['address'])) $metrodir_search_address  = $_GET['address'];
if (isset($_GET['distance'])) $metrodir_search_distance = $_GET['distance'];
if (isset($_GET["days"])) $metrodir_search_days = $_GET["days"];

//Get advanced fields
$name_field = add_fields_search();
$count_field = count($name_field);
$kind = 0;
for ($ind = 0; $ind < $count_field; $ind++) {
    $addfields[$ind][0] = $name_field[$ind];
    $value = 'opt_metrodir_advsearch_fields_'.$ind.'';
    $addfields[$ind][1]= get_option($value);

    if($addfields[$ind][1] == "true"){
        $adv_fields[$kind][0] = strtolower($addfields[$ind][0]);
        $get_str = preg_replace('/\s+/', "_", $adv_fields[$kind][0]);
        $adv_fields[$kind][1] = isset($_GET[$get_str]) ? $_GET[$get_str] : NULL;
        $kind++;
    }
}

//Get types fields
$adv_fields_types = add_type_fields_search();
$count_field_type = count($adv_fields_types);

for ($indext = 0; $indext < $count_field_type; $indext++) {
    $get_strt = $adv_fields_types[$indext];
    $addfields_type[$adv_fields_types[$indext]] = isset($_GET[$get_strt]) ? $_GET[$get_strt] : NULL;
}
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

<!-- Content --><div id="content" class="search-adv">

    <!-- Content Inner --><div id="content-inner"<?php if ($opt_metrodir_search_sidebar == "true") echo ' class="sidebar-'.$opt_metrodir_sidebar.'"'; else echo ' class="without-sidebar"'; ?>><div class="box-container">

        <?php if ($opt_metrodir_search_sidebar == "true"): ?>
            <!-- Sidebar --><div id="sidebar">
                <?php get_template_part('/include/html/frame','sidebar-single'); ?>
            </div><!-- /Sidebar -->
        <?php endif; ?>

        <!-- Content Center --><div id="content-center">

            <?php
                global $wp_query;
                function filter_where($where = '') {
                    $metrodir_search_days = $_GET["days"];
                    $days_published = date('Y-m-d', strtotime('-'.$metrodir_search_days.' days'));
                    $where .= " AND post_date > '".$days_published."'";
                    return $where;
                }

                $settings = return_settings();

                add_filter( 'posts_where', 'filter_where' );

                parse_str($_SERVER['QUERY_STRING']);

                if (!isset($orderby)) $orderby = "date";

                query_posts(array(
                    'post_type' => array('company'),
                    'posts_per_page' => -1,
                    'company_category' => $company_category,
                    'orderby' => $orderby,
                    'order' => $order
                ));
            ?>

            <div class="title">
                <h1>
                    <?php echo __('results for search','metrodir').' "'; ?>
                    <?php
                    if($metrodir_search_location OR $metrodir_search_region OR $metrodir_search_address){
                        echo __('Location','metrodir').': '.$metrodir_search_location.' '.$metrodir_search_region.' '.$metrodir_search_address.', ';
                    }

                    if($company_category){
                        $cat = get_term_by('slug', $company_category, 'company_category');
                        echo __('Category','metrodir').': '.$cat->name.', ';
                    }

                    if($opt_metrodir_search_radius == "true"){
                        if($metrodir_search_distance){
                            if($metrodir_search_distance == 9999999999999){
                                $metrodir_search_distance_print = "Unlimited";
                            } else {
                                $metrodir_search_distance_print = $metrodir_search_distance;
                            }

                            echo __('Distance','metrodir').': '.$metrodir_search_distance_print.' km, ';
                        }
                    }

                    if(isset($metrodir_search_days)){
                        if($metrodir_search_days == 9999999999999){
                            $metrodir_search_days_print = "Unlimited";
                        } else {
                            $metrodir_search_days_print = $metrodir_search_days;
                        }

                        echo __('Days Published','metrodir').': '.$metrodir_search_days_print.' days.';
                    }
                    ?>
                    <?php echo '"'; ?>
                </h1>
            </div>

            <?php if ($opt_metrodir_search_subcat == "true"): ?>
                <?php get_template_part('/include/html/frame','subcategories'); ?>
            <?php endif; ?>

            <div id="company_category" style = "display: none;"><?php echo $company_category; ?></div>

            <!-- Search Sorting --><div id="search-sorting">

                <form method="get" action="<?php echo home_url(); ?>/search/">

                    <?php $params = array(); parse_str($_SERVER['QUERY_STRING'],$params); ?>

                    <?php foreach ($params as  $key => $param ): ?>
                        <?php if (($key != "pagination") AND ($key != "orderby") AND ($key != "order")): ?>
                            <input type="hidden" id="sorting-<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo $param; ?>">
                        <?php endif; ?>
                    <?php endforeach; ?>

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

            <?php
                $search_summ_add = '';
                if (isset($metrodir_search_location))
                    $search_summ_add .= $metrodir_search_location.' ';
                if (isset($metrodir_search_region))
                    $search_summ_add .= $metrodir_search_region.' ';
                if (isset($metrodir_search_address))
                    $search_summ_add .= $metrodir_search_address;
                if($opt_metrodir_search_radius == "true"){
                    if(isset($metrodir_search_location) OR isset($metrodir_search_region) OR isset($metrodir_search_address)){
                        $radius_search = simplexml_load_file('http://maps.google.com/maps/api/geocode/xml?address='.$search_summ_add.'&sensor=false');
                        if(isset($radius_search->result->geometry->location->lat)){
                            $center_lat = $radius_search->result->geometry->location->lat;
                            $center_lng = $radius_search->result->geometry->location->lng;
                        } else {
                            require_once(get_template_directory().'/skl/plugin/geoplugin.php');
                            $geoplugin = new geoPlugin();
                            $geoplugin->locate();
                            $center_lat = $geoplugin->latitude;
                            $center_lng = $geoplugin->longitude;
                        }
                    } else {
                        require_once(get_template_directory().'/skl/plugin/geoplugin.php');
                        $geoplugin = new geoPlugin();
                        $geoplugin->locate();
                        $center_lat = $geoplugin->latitude;
                        $center_lng = $geoplugin->longitude;
                    }
                }
                $search_count = 0;
            ?>

            <div id="search-list-block">
                <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                    <?php
                        $custom_fields = get_post_custom();
                        $search_where = '';
                        if (isset($custom_fields['metro_address_zip'][0]))
                            $search_where .= $custom_fields['metro_address_zip'][0].' ';
                        if (isset($custom_fields['metro_address_country_name'][0]))
                            $search_where .= $custom_fields['metro_address_country_name'][0].' ';
                        if (isset($custom_fields['metro_address_region_name'][0]))
                            $search_where .= $custom_fields['metro_address_region_name'][0].' ';
                        if (isset($custom_fields['metro_address_name'][0]))
                            $search_where .= $custom_fields['metro_address_name'][0];
                        if (isset($custom_fields['metro_address_lat'][0])) $search_lat = $custom_fields['metro_address_lat'][0];
                        if (isset($custom_fields['metro_address_lng'][0])) $search_lng = $custom_fields['metro_address_lng'][0];

                        if ($opt_metrodir_search_radius == "true") {
                            //Filter by radius
                            $radiusInKm = intval($metrodir_search_distance); //Set distance
                            $cenLat = floatval($center_lat); // Point by search
                            $cenLng = floatval($center_lng); // Point by search
                            $lat = floatval($search_lat); // Lat. company
                            $lng = floatval($search_lng); // Long. company
                            $distance = ( 6371 * acos( cos( deg2rad($cenLat) ) * cos( deg2rad( $lat ) ) * cos( deg2rad( $lng ) - deg2rad($cenLng) ) + sin( deg2rad($cenLat) ) * sin( deg2rad( $lat ) ) ) );
                        }

                        $where =  strtolower($metrodir_search_location);
                        $region =  strtolower($metrodir_search_region);
                        $address =  strtolower($metrodir_search_address);

                        if ($where) {
                            $search_where_str = strtolower($search_where);
                            $result = strpos($search_where_str, $where, 0);
                        }

                        if ($region) {
                            $search_where_str = strtolower($search_where);
                            $result_region = strpos($search_where_str, $region, 0);
                        }

                        if ($address) {
                            $search_where_str = strtolower($search_where);
                            $result_address = strpos($search_where_str, $address, 0);
                        }

                        //advanced fields search
                        $adv_fields_count = count($adv_fields);

                        for ($cnt = 0; $cnt < $adv_fields_count; $cnt++) {
                            $search_field = $adv_fields[$cnt][0];
                            $search_field_str = preg_replace('/\s+/', "_", $search_field);

                            if ($search_field_str == "number_of_employees") { $search_field_str = "empl"; }
                            if ($search_field_str == "legal_entity") { $search_field_str = "legal"; }

                            $search_advfield_str = 'metro_company_doc_'.$search_field_str;

                            if ($search_field_str == "range_of_services_tags") { $search_field_str = "tags"; $search_advfield_str = 'metro_company_'.$search_field_str; }

                            $search_advfield = strtolower($custom_fields[$search_advfield_str][0]);
                            $search_advfield = preg_replace('/\s+/', "", $search_advfield);
                            $search_req = strtolower($adv_fields[$cnt][1]);

                            if ($search_req) {
                                $result_advfield[$cnt] = strpos($search_advfield, $search_req, 0);
                                $result_display = array_search(false, $result_advfield, true);
                                //mirror
                                if ($result_display != false) { $result_display = true; }
                            }
                        }

                        //Types fields search
                        $meta_key_used= get_post_custom_keys($post->ID);

                        $i=0;
                        foreach ($meta_key_used as $meta_key) {
                            $check = strtolower('wpcf-');
                            $check_key = $meta_key;
                            $result_check =  strpos($check_key, $check, 0);

                            if ($result_check !== false){
                                $field = substr($meta_key, 5);
                                $fields[$i] = $field;
                                $i++;
                            }
                        }

                        $fields_arr_num = count($fields);
                        $num = 0;
                        if ( is_plugin_active('types/wpcf.php') ) {
                            for ($index = 0; $index < count($fields); $index++) {
                                $fields_type[$fields[$index]] = types_render_field($fields[$index], array("output"=>"raw"));
                                $search_req_t = $addfields_type[$fields[$index]];
                                $search_advfield_t = $fields_type[$fields[$index]];

                                if($search_req_t){
                                    $result_advfield_t[$index] = strpos($search_advfield_t, $search_req_t, 0);
                                    $result_display_t = array_search(false, $result_advfield_t, true);
                                    //mirror
                                    if($result_display_t != false){ $result_display_t = true; }
                                }
                            }
                        }
                    ?>

                    <?php if ($result !== false):?>
                        <?php if ($result_region !== false):?>
                            <?php if ($result_address !== false):?>
                                <?php if ($distance <= $radiusInKm):?>
                                    <?php if ($result_address !== false):?>
                                        <?php if($result_display == false AND $result_display !== 0): ?>
                                            <?php if( $result_display_t == false AND  $result_display_t !== 0): ?>

                                                <?php if ($opt_metrodir_search_style == "default"): ?>
                                                    <?php get_template_part('/include/html/pattern','company'); ?>
                                                <?php elseif ($opt_metrodir_search_style == "thumb"): ?>
                                                    <?php get_template_part('/include/html/pattern','company-thumb'); ?>
                                                <?php endif; ?>

                                                <?php $search_count++; ?>

                                                <?php
                                                    $found_companus[$search_count][1] = $custom_fields['metro_address_lat'][0];
                                                    $found_companus[$search_count][2] = $custom_fields['metro_address_lng'][0];
                                                    $terms = get_the_terms( get_the_ID(), 'company_category' );
                                                    $item_cats = array();
                                                    $item_cats_id = array();
                                                    $item_cats_slugs = array();
                                                    $i = 0;
                                                    if(is_array($terms)) {
                                                        foreach ($terms as $term ) {
                                                            $i++;
                                                            $item_cats_id[$i] = $term->term_id;
                                                            $item_cats_slugs[$i] = $term->slug;
                                                            if ($company_category == $term->slug) {
                                                                $item_cats_id[1] = $term->term_id;
                                                                $item_cats_slugs[1] = $term->slug;
                                                            }
                                                        }
                                                    } else {
                                                        $item_cats_slugs[1] = "default";
                                                        $i = 1;
                                                    }
                                                    $found_companus[$search_count][9] = '';
                                                    $color = get_option('metrodir_category_'.$item_cats_id[1].'_color', '' );
                                                    $icon = get_option( 'metrodir_category_'.$item_cats_id[1].'_icon', '' );
                                                    $custom_marker = get_option( 'metrodir_category_'.$item_cats_id[1].'_marker_image', '' );
                                                    if ($metrodir_markers_type == 'image') {
                                                        if ($custom_marker) {
                                                            $found_companus[$search_count][9] = $custom_marker;
                                                        } else if ($def_cat_style[$item_cats_slugs[1]]["marker"]) {
                                                            $found_companus[$search_count][9] = get_template_directory_uri().$def_cat_style[$item_cats_slugs[1]]["marker"];
                                                        } else {
                                                            $found_companus[$search_count][9] = get_template_directory_uri().$def_cat_style['default']["marker"];
                                                        }
                                                    }
                                                    if ($icon) {
                                                        $found_companus[$search_count][7] = $icon;
                                                    } else if ($def_cat_style[$item_cats_slugs[1]]["icon"]) {
                                                        $found_companus[$search_count][7] = $def_cat_style[$item_cats_slugs[1]]["icon"];
                                                    } else {
                                                        $found_companus[$search_count][7] = $def_cat_style["default"]["icon"];
                                                    }
                                                    if ($color) {
                                                        $found_companus[$search_count][8] =  $color;
                                                    } else if ($def_cat_style[$item_cats_slugs[1]]["color"]) {
                                                        $found_companus[$search_count][8] =  $def_cat_style[$item_cats_slugs[1]]["color"];
                                                    } else {
                                                        $found_companus[$search_count][8] =  $def_cat_style["default"]["color"];
                                                    }
                                                    //Get Rating variable
                                                    $id = get_the_ID();
                                                    $item = new stdClass();
                                                    $item->rating = get_post_meta( $id, 'rating', true );
                                                    $rating = '';
                                                    if ($item->rating) {
                                                        $rating .= '<div class="marker-rating">';
                                                        for ($i = 1; $i <= $item->rating['max']; $i++) {
                                                            $rating .= '<i class="fa ';
                                                            if (($item->rating['val'] + 1 - $i) > 1) $rating .= "fa-star"; else if (($item->rating['val'] + 1 - $i) > 0.5) $rating .= "fa-star-half-o"; else $rating .= 'fa-star-o';
                                                            $rating .= ' fa-lg"></i>';
                                                        }
                                                        $rating .= '</div>';
                                                    } else {
                                                        $rating = '<div class="marker-rating"></div>';
                                                    }
                                                    $found_companus[$search_count][3] = $item_cats_slugs[1];
                                                    $found_companus[$search_count][4] = get_the_title();

                                                    if (isset($custom_fields['metro_address_country_name'][0])) {
                                                        $country = $custom_fields['metro_address_country_name'][0];
                                                    }
                                                    if (isset($custom_fields['metro_address_region_name'][0])) {
                                                        $region = $custom_fields['metro_address_region_name'][0];
                                                    }
                                                    if (isset($custom_fields['metro_address_name'][0])) {
                                                        $name = $custom_fields['metro_address_name'][0];
                                                    }
                                                    if (isset($custom_fields['metro_address_zip'][0])) {
                                                        $name = $custom_fields['metro_address_zip'][0] + ', ' + $name;
                                                    }

                                                    if ($metrodir_markers_info == "address") {
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
                                                        $found_companus[$search_count][10] = $address;
                                                    } else if ($metrodir_markers_info == "desc") {
                                                        $found_companus[$search_count][10] = $custom_fields['metro_company_doc_desc'][0];
                                                    } else if ($metrodir_markers_info == "phone") {
                                                        $found_companus[$search_count][10] = $custom_fields['metro_company_doc_phone'][0];
                                                    }

                                                    if ($metrodir_markers_type == 'image') {
                                                        $found_companus[$search_count][5] = '<div class="marker-content image-marker"><div class="marker-image"><a class="opacity" href="'.get_permalink().'" title="'.addcslashes(get_the_title() , '\'').'">'.get_the_post_thumbnail().'</a></div><div class="marker-description"><div class="marker-name"><a href="'.get_permalink().'" title="'.addcslashes(get_the_title() , '\'').'">'.addcslashes(get_the_title() , '\'').'</a></div>'.$rating.'<div class="marker-address">'.addcslashes($found_companus[$search_count][10], '\'').'</div><div class="marker-link"><a href="'.get_permalink().'" title="'.addcslashes(get_the_title() , '\'').'"><i class="fa fa-arrow-circle-right"></i>Read More</a></div></div></div>';
                                                    } else {
                                                        $found_companus[$search_count][5] = '<div id="map-marker-id-'.$search_count.'" class="marker-container map-no-over"><div class="marker-on-map" style="background: '.$found_companus[$search_count][8].';"><div class="marker-content"><div class="marker-image"><a class="opacity" href="'.get_permalink().'" title="'.addcslashes(get_the_title() , '\'').'">'.get_the_post_thumbnail().'</a></div><div class="marker-description"><div class="marker-name"><a href="'.get_permalink().'" title="'.addcslashes(get_the_title() , '\'').'">'.addcslashes(get_the_title() , '\'').'</a></div>'.$rating.'<div class="marker-address">'.addcslashes($found_companus[$search_count][10], '\'').'</div><div class="marker-link"><a href="'.get_permalink().'" title="'.addcslashes(get_the_title() , '\'').'"><i class="fa fa-arrow-circle-right"></i>Read More</a></div></div></div><i class="marker-icon fa '.$found_companus[$search_count][7].'" title="'.addcslashes(get_the_title() , '\'').'"></i><div class="marker-close" title="Close"><i class="fa fa-times"></i></div></div><div class="map-triangle map-click" style="border-left: 16px solid '.$found_companus[$search_count][8].';"></div></div>';
                                                    }
                                                    $found_companus[$search_count][6] = $search_count;
                                                ?>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endwhile; // end of the loop. ?>
            </div>

            <?php remove_filter( 'posts_where', 'filter_where' ); ?>

            <?php wp_reset_query(); wp_reset_postdata(); ?>

            <div id="search-results" style="display: none;"><?php if ($search_count == 0) echo 'NO'; else echo $search_count; ?></div>

            <?php
                if (isset($found_companus) AND $found_companus) {
                    echo'<div id="search-markers" style="display: none;">';
                    $markers_counter = 0;
                    for ($index = 1; $index <= count($found_companus); $index++) {
                        if ($found_companus[$index][1]) { $markers_counter++;
                            echo '<div id="search-marker-'.$markers_counter.'" class="'.$marker_load_indikator.'">';
                                echo '<div class="lat">'.$found_companus[$index][1].'</div>';
                                echo '<div class="lan">'.$found_companus[$index][2].'</div>';
                                if ($company_category) {
                                    echo '<div class="group">'.$company_category.'</div>';
                                } else {
                                    echo '<div class="group">'.$found_companus[$index][3].'</div>';
                                }
                                if ($found_companus[$index][9]) {
                                    echo '<div class="icon">'.$found_companus[$index][9].'</div>';
                                } else {
                                    echo '<div class="icon">'.get_template_directory_uri().'/images/pix-map.png</div>';
                                }
                                echo '<div class="html">'.$found_companus[$index][5].'</div>';
                                echo '<div class="id">marker-id-'.$found_companus[$index][6].'</div>';
                            echo '</div>';
                        }
                    }
                    echo'<div id="search_markers_count">'.$markers_counter.'</div>';
                    echo'</div>';
                }
            ?>

        </div><!-- /Content Center -->

        <div class="clear"></div>

    </div></div><!-- /Content Inner -->

</div><!-- /Content -->

<?php get_template_part ('footer');
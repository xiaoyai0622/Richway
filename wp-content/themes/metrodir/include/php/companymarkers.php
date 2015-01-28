<!-- Map Support Scripts --><div id="ajax_map" class="inline-scripts">
<?php
    $settings = return_settings();
    $center_single_company = return_single_company();
    $item_adrs_sng_lat = return_item_adrs_sng_lat();
    $item_adrs_sng_lng = return_item_adrs_sng_lng();
    $item_first_cat = return_item_first_cat();

global $def_cat_style;

// Get variables metrodir_Options
//Site options
$metrodir_map_type = get_option('opt_metrodir_map_type');
$metrodir_draggable_map = get_option('opt_metrodir_map_drag');
$metrodir_scrollwheel_map = get_option('opt_metrodir_map_scroll');
$metrodir_map_zoom = get_option('opt_metrodir_map_zoom');
$metrodir_markers_type = get_option('opt_metrodir_markers_type');
$metrodir_markers_info = get_option('opt_metrodir_markers_info');
$metrodir_map_clusters = get_option('opt_metrodir_map_clusters');
$metrodir_map_clusters_grid = get_option('opt_metrodir_map_clusters_grid');
$metrodir_map_clusters_min = get_option('opt_metrodir_map_clusters_min');
$metrodir_map_clusters_icons_url = get_option('opt_metrodir_map_clusters_icons_url');
$centre_map = get_option('opt_metrodir_map_centermap');
$centre_addr_lat = get_option('opt_metrodir_company_cntr_address_lat');
$centre_addr_lng = get_option('opt_metrodir_company_cntr_address_lng');


    global $wp_query;
    query_posts(array(
    'post_type' => array('company'),
        'meta_query'  => array(
            'relation' => 'AND',
            array(
                'key' => 'metro_address_lat',
                'compare' => 'EXISTS'
            ),
            array(
                'key' => 'metro_address_lng',
                'compare' => 'EXISTS'
            )),
        'posts_per_page' => -1
    ));

    $index = 0;
?>


    <?php if ( have_posts() ) while ( have_posts() ) : the_post();

        $index++;

        $companus[$index][1] = get_the_title();
        $companus[$index][11] = get_the_ID();
        $companus[$index][12] = '';
        $companus[$index][13] = '';

        //Get Rating variable
        $id = get_the_ID();
        $item = new stdClass();
        $item->rating = get_post_meta( $id, 'rating', true );
        $rating = '';
        if ($item->rating) {
            $rating .= '<div class="marker-rating">';
            for ($i = 1; $i <= $item->rating['max']; $i++) {
                $rating .= '<i class="fa ';
                if (($item->rating['val'] + 1 - $i) >= 1) $rating .= "fa-star"; else if (($item->rating['val'] + 1 - $i) >= 0.5) $rating .= "fa-star-half-o"; else $rating .= 'fa-star-o';
                $rating .= ' fa-lg"></i> ';
            }
            $rating .= '</div>';
        } else {
            $rating = '<div class="marker-rating"></div>';
        }

        $companus[$index][10] = $rating;

        $terms = get_the_terms( $post->ID, 'company_category' );
        $item_cats = array();
        $item_cats_slugs = array();
        $item_cats_term_id = array();
        $i = 0;
        if(is_array($terms)) {
            foreach ($terms as $term ) {
                $i++;
                $item_cats_slugs[$i] = $term->slug;
                $item_cats_term_id[$i] = $term->term_id;
            }
        } else {
            $item_cats_slugs[1] = "default";
            $i = 1;
        }
        if ($i == 1) {
            $companus[$index][2] = $item_cats_slugs[1];
            $color = get_option('metrodir_category_'.$item_cats_term_id[1].'_color', '' );
            $icon = get_option( 'metrodir_category_'.$item_cats_term_id[1].'_icon', '' );
            $custom_icon = get_option( 'metrodir_category_'.$item_cats_term_id[1].'_icon_image', '' );
            $custom_marker = get_option( 'metrodir_category_'.$item_cats_term_id[1].'_marker_image', '' );
            if ($metrodir_markers_type == 'image') {
                if ($custom_marker) {
                    $companus[$index][13] = $custom_marker;
                } else if ($def_cat_style[$item_cats_slugs[1]]["marker"]) {
                    $companus[$index][13] = get_template_directory_uri().$def_cat_style[$item_cats_slugs[1]]["marker"];
                } else {
                    $companus[$index][13] = get_template_directory_uri().$def_cat_style['default']["marker"];
                }
            }
            if ($custom_icon) {
                $companus[$index][8] = '';
                $companus[$index][12] =  '<i style="background-image: url('.$custom_icon.');"></i>';
            } else if ($icon) {
                $companus[$index][8] = ' fa '.$icon;
            } else if ($def_cat_style[$item_cats_slugs[1]]["icon"]) {
                $companus[$index][8] = ' fa '.$def_cat_style[$item_cats_slugs[1]]["icon"];
            } else {
                $companus[$index][8] = ' fa '.$def_cat_style["default"]["icon"];
            }
            if ($color) {
                $companus[$index][9] =  $color;
            } else if ($def_cat_style[$item_cats_slugs[1]]["color"]) {
                $companus[$index][9] =  $def_cat_style[$item_cats_slugs[1]]["color"];
            } else {
                $companus[$index][9] =  $def_cat_style["default"]["color"];
            }
            $custom_fields = get_post_custom();

            $item_addr_lat = $custom_fields['metro_address_lat'][0];
            $item_addr_lng = $custom_fields['metro_address_lng'][0];

            $country = ''; $region = ''; $name = '';

            if (isset($custom_fields['metro_address_country_name'][0]) AND $custom_fields['metro_address_country_name'][0]) {
                $country = $custom_fields['metro_address_country_name'][0];
                $places[$index][1] = $country;
            }
            if (isset($custom_fields['metro_address_region_name'][0]) AND $custom_fields['metro_address_region_name'][0]) {
                $region = $custom_fields['metro_address_region_name'][0];
                $places[$index][2] = $region;
            }
            if (isset($custom_fields['metro_address_name'][0]) AND $custom_fields['metro_address_name'][0]) {
                $name = $custom_fields['metro_address_name'][0];
                $places[$index][3] = $name;
            }
            if (isset($custom_fields['metro_address_zip'][0]) AND $custom_fields['metro_address_zip'][0]) {
                if (isset($name) AND $name) {
                    $name = $custom_fields['metro_address_zip'][0].', '.$name;
                } else {
                    $name = $custom_fields['metro_address_zip'][0];
                }
            }

            $address = "";
            if ($country AND $region AND $name) {
                $address = $country.', '.$region.', '.$name;
            } else if ($country AND $region) {
                $address = $country.', '.$region;
            } else if ($country AND $name) {
                $address = $country.', '.$name;
            } else if ($region AND $name) {
                $address = $region.', '.$name;
            } else if ($country) {
                $address = $country;
            } else if ($region) {
                $address = $region;
            } else if ($name) {
                $address = $name;
            }

            $companus[$index][4] = $address;
            if ($metrodir_markers_info == "address") {
                $companus[$index][14] = $companus[$index][4];
            } else if ($metrodir_markers_info == "desc") {
                $companus[$index][14] = $custom_fields['metro_company_doc_desc'][0];
            } else if ($metrodir_markers_info == "phone") {
                $companus[$index][14] = '<i class="fa fa-phone"></i> '.$custom_fields['metro_company_doc_phone'][0].'<br/><i class="fa fa-envelope"></i> <a href="mailto:'.$custom_fields['metro_company_soc_email'][0].'" title="'.$custom_fields['metro_company_soc_email'][0].'">'.$custom_fields['metro_company_soc_email'][0].'</a>';
            }

            $companus[$index][3] = $item_addr_lat;
            $companus[$index][5] = get_permalink();
            $companus[$index][6] = get_the_post_thumbnail();
            $companus[$index][7] = $item_addr_lng;
        } else if ($i > 1) {
            $companus[$index][2] = $item_cats_slugs[1];
            $color = get_option('metrodir_category_'.$item_cats_term_id[1].'_color', '' );
            $icon = get_option( 'metrodir_category_'.$item_cats_term_id[1].'_icon', '' );
            $custom_icon = get_option( 'metrodir_category_'.$item_cats_term_id[1].'_icon_image', '' );
            $custom_marker = get_option( 'metrodir_category_'.$item_cats_term_id[1].'_marker_image', '' );
            if ($metrodir_markers_type == 'image') {
                if ($custom_marker) {
                    $companus[$index][13] = $custom_marker;
                } else if ($def_cat_style[$item_cats_slugs[1]]["marker"]) {
                    $companus[$index][13] = get_template_directory_uri().$def_cat_style[$item_cats_slugs[1]]["marker"];
                } else {
                    $companus[$index][13] = get_template_directory_uri().$def_cat_style['default']["marker"];
                }
            }
            if ($custom_icon) {
                $companus[$index][8] = '';
                $companus[$index][12] =  '<i style="background-image: url('.$custom_icon.');"></i>';
            } else if ($icon) {
                $companus[$index][8] = ' fa '.$icon;
            } else if ($def_cat_style[$item_cats_slugs[1]]["icon"]) {
                $companus[$index][8] = ' fa '.$def_cat_style[$item_cats_slugs[1]]["icon"];
            } else {
                $companus[$index][8] = ' fa '.$def_cat_style["default"]["icon"];
            }
            if ($color) {
                $companus[$index][9] =  $color;
            } else if ($def_cat_style[$item_cats_slugs[1]]["color"]) {
                $companus[$index][9] =  $def_cat_style[$item_cats_slugs[1]]["color"];
            } else {
                $companus[$index][9] =  $def_cat_style["default"]["color"];
            }
            $custom_fields = get_post_custom();

            $item_addr_lat = $custom_fields['metro_address_lat'][0];
            $item_addr_lng = $custom_fields['metro_address_lng'][0];

            $country = ''; $region = ''; $name = '';

            if (isset($custom_fields['metro_address_country_name'][0]) AND $custom_fields['metro_address_country_name'][0]) {
                $country = $custom_fields['metro_address_country_name'][0];
                $places[$index][1] = $country;
            }
            if (isset($custom_fields['metro_address_region_name'][0]) AND $custom_fields['metro_address_region_name'][0]) {
                $region = $custom_fields['metro_address_region_name'][0];
                $places[$index][2] = $region;
            }
            if (isset($custom_fields['metro_address_name'][0]) AND $custom_fields['metro_address_name'][0]) {
                $name = $custom_fields['metro_address_name'][0];
                $places[$index][3] = $name;
            }
            if (isset($custom_fields['metro_address_zip'][0]) AND $custom_fields['metro_address_zip'][0]) {
                if (isset($name) AND $name) {
                    $name = $custom_fields['metro_address_zip'][0].', '.$name;
                } else {
                    $name = $custom_fields['metro_address_zip'][0];
                }
            }

            $address = "";
            if ($country AND $region AND $name) {
                $address = $country.', '.$region.', '.$name;
            } else if ($country AND $region) {
                $address = $country.', '.$region;
            } else if ($country AND $name) {
                $address = $country.', '.$name;
            } else if ($region AND $name) {
                $address = $region.', '.$name;
            } else if ($country) {
                $address = $country;
            } else if ($region) {
                $address = $region;
            } else if ($name) {
                $address = $name;
            }

            $companus[$index][4] = $address;
            if ($metrodir_markers_info == "address") {
                $companus[$index][14] = $companus[$index][4];
            } else if ($metrodir_markers_info == "desc") {
                $companus[$index][14] = $custom_fields['metro_company_doc_desc'][0];
            } else if ($metrodir_markers_info == "phone") {
                $companus[$index][14] = '<i class="fa fa-phone"></i> '.$custom_fields['metro_company_doc_phone'][0].'<br/><i class="fa fa-envelope"></i> <a href="mailto:'.$custom_fields['metro_company_soc_email'][0].'" title="'.$custom_fields['metro_company_soc_email'][0].'">'.$custom_fields['metro_company_soc_email'][0].'</a>';
            }

            $companus[$index][3] = $item_addr_lat;
            $companus[$index][5] = get_permalink();
            $companus[$index][6] = get_the_post_thumbnail();
            if ($custom_fields['metro_featured'][0] == "on") $companus[$index][6] = $companus[$index][6].'<div class="company-listing-featured">'.__('Featured','metrodir').'</div>';
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
                $companus[$index][10] = $companus[$index - 1][10];
                $companus[$index][11] = $companus[$index - 1][11];
                $companus[$index][14] = $companus[$index - 1][14];
                $color = get_option('metrodir_category_'.$item_cats_term_id[$k].'_color', '' );
                $icon = get_option( 'metrodir_category_'.$item_cats_term_id[$k].'_icon', '' );
                $custom_icon = get_option( 'metrodir_category_'.$item_cats_term_id[$k].'_icon_image', '' );
                $custom_marker = get_option( 'metrodir_category_'.$item_cats_term_id[$k].'_marker_image', '' );
                if ($metrodir_markers_type == 'image') {
                    if ($custom_marker) {
                        $companus[$index][13] = $custom_marker;
                    } else if ($def_cat_style[$item_cats_slugs[$k]]["marker"]) {
                        $companus[$index][13] = get_template_directory_uri().$def_cat_style[$item_cats_slugs[$k]]["marker"];
                    } else {
                        $companus[$index][13] = get_template_directory_uri().$def_cat_style['default']["marker"];
                    }
                }
                if ($custom_icon) {
                    $companus[$index][8] = '';
                    $companus[$index][12] =  '<i style="background-image: url('.$custom_icon.');"></i>';
                } else if ($icon) {
                    $companus[$index][8] = ' fa '.$icon;
                } else if ($def_cat_style[$item_cats_slugs[$k]]["icon"]) {
                    $companus[$index][8] = ' fa '.$def_cat_style[$item_cats_slugs[$k]]["icon"];
                } else {
                    $companus[$index][8] = ' fa '.$def_cat_style["default"]["icon"];
                }
                if ($color) {
                    $companus[$index][9] =  $color;
                } else if ($def_cat_style[$item_cats_slugs[$k]]["color"]) {
                    $companus[$index][9] =  $def_cat_style[$item_cats_slugs[$k]]["color"];
                } else {
                    $companus[$index][9] =  $def_cat_style["default"]["color"];
                }
                if (isset($places[$index - 1][1]))
                    $places[$index][1] = $places[$index - 1][1];
                if (isset($places[$index - 1][2]))
                    $places[$index][2] = $places[$index - 1][2];
                if (isset($places[$index - 1][3]))
                    $places[$index][3] = $places[$index - 1][3];
            }
        }
       endwhile;

    // Map load option
    $zoom = 10;
    if ($metrodir_map_zoom) {
        $zoom = $metrodir_map_zoom;
    }

    $map_type = "ROADMAP";
    if($metrodir_map_type){
        $map_type = $metrodir_map_type;
    }

    $draggable_map = "true";
    if($metrodir_draggable_map){
        $draggable_map = $metrodir_draggable_map;
    }

    $scrollwheel_map = "false";
    if($metrodir_scrollwheel_map){
        $scrollwheel_map = $metrodir_scrollwheel_map;
    }

    // Get default Map category
    $center_def = false;
    $center_cat = get_option('opt_metrodir_home_defcat');
    if(!$center_cat or $center_cat == 'Select a category:'){
        $center_cat = "nocat";
    } else {
        $center_def = true;
    }
    $term = get_term_by('name', $center_cat, 'company_category');
    $center_cat = $term->slug;
    // Get center map coordinate and custom category
    $center_lat = 0;
    $center_lng = 0;
    if (isset($companus)) {
        if (($center_single_company == "ye") && ($item_adrs_sng_lat)) {
            $center_lat = $item_adrs_sng_lat;
            $center_lng = $item_adrs_sng_lng;
            $center_cat = $item_first_cat;
            $zoom = 15;
        } else if (($centre_addr_lat) && ($centre_map == "centre_addr")) {
            $center_lat = $centre_addr_lat;
            $center_lng = $centre_addr_lng;
        } else if (($centre_map == "centre_random")) {
            $index = 0;
            if (! $center_def) {
                $randomize = rand(1, count($companus));
            } else {
                do {
                    $randomize = rand(1, count($companus));
                    $index++;
                } while (($center_cat != $companus[$randomize][2]) OR ($index <= count($companus)));
            }
            $center_cat = $companus[$randomize][2];
            $center_lat = $companus[$randomize][3];
            $center_lng = $companus[$randomize][7];
        } else if (($centre_map == "centre_last")) {
            if (! $center_def) {
                $center_cat = $companus[1][2];
                $center_lat = $companus[1][3];
                $center_lng = $companus[1][7];
            } else {
                for ($index = 1; $index <= count($companus); $index++) {
                    if ($center_cat == $companus[$index][2]) {
                        $center_cat = $companus[$index][2];
                        $center_lat = $companus[$index][3];
                        $center_lng = $companus[$index][7];
                        break;
                    }
                }
            }
        } else if ($centre_map == "centre_geomap") {
            require_once(get_template_directory().'/skl/plugin/geoplugin.php');
            $geoplugin = new geoPlugin();
            $geoplugin->locate();
            if (isset($geoplugin->latitude) AND isset($geoplugin->longitude)) {
                $center_lat = $geoplugin->latitude;
                $center_lng = $geoplugin->longitude;
            } else {
                $center_lat = 10;
                $center_lng = 10;
            }

        }
    } else {
        require_once(get_template_directory().'/skl/plugin/geoplugin.php');
        $geoplugin = new geoPlugin();
        $geoplugin->locate();
        if (isset($geoplugin->latitude) AND isset($geoplugin->longitude)) {
            $center_lat = $geoplugin->latitude;
            $center_lng = $geoplugin->longitude;
        } else {
            $center_lat = 10;
            $center_lng = 10;
        }
    }
    echo'<div id="map_options" style="display:none">';
    echo'<div class="draggable">'.$draggable_map.'</div>';
    echo'<div class="scrollwheel">'.$scrollwheel_map.'</div>';
    echo'<div class="maptype">'.$map_type.'</div>';
    echo'<div class="zoom">'.$zoom.'</div>';
    if ($metrodir_map_clusters == 'true' AND $metrodir_markers_type == 'image') {
        echo'<div class="clusters">true</div>';
        echo'<div class="clusters-grid">'.$metrodir_map_clusters_grid.'</div>';
        echo'<div class="clusters-min">'.$metrodir_map_clusters_min.'</div>';
        if ($metrodir_map_clusters_icons_url) echo'<div class="clusters-url">'.$metrodir_map_clusters_icons_url.'</div>'; else echo'<div class="clusters-url">'.get_template_directory_uri().'/images/clusters/cluster-</div>';
    } else {
        echo'<div class="clusters">false</div>';
    }
    echo '<div class="markers-type">'.$metrodir_markers_type.'</div>';
    if ($center_def) echo '<div class="markers-category-def">true</div>'; else echo '<div class="markers-category-def">false</div>';
    echo'</div>';
    echo'<div id="markers_container" style="display:none">';
    echo'<div id="markers_center"><div class="latitude">'.$center_lat.'</div><div class="longitude">'.$center_lng.'</div><div class="category">'.$center_cat.'</div><div class="option">'.$centre_map.'</div></div>';
    if (isset($companus)) {
        echo'<div id="markers">';
        $markers_counter = 0;
        for ($index = 1; $index <= count($companus); $index++) {
            if ($companus[$index][3]) { $markers_counter++;
                if ($index == 1) {
                    $marker_load_indikator = 'load';
                } else if ($companus[$index][11] == $companus[$index - 1][11]) {
                    $marker_load_indikator = '';
                } else {
                    $marker_load_indikator = 'load';
                }
                if ($center_def) {
                    if ($center_cat == $companus[$index][2]) {
                        $marker_load_indikator .= ' load-def';
                    } else {
                        $marker_load_indikator .= '';
                    }
                }
                echo'<div id="marker-'.$markers_counter.'" class="'.$marker_load_indikator.'">';
                echo '<div class="lat">'.$companus[$index][3].'</div>';
                echo '<div class="lan">'.$companus[$index][7].'</div>';
                echo '<div class="group">'.$companus[$index][2].'</div>';
                echo '<div class="name">'.$companus[$index][1].'</div>';
                echo '<div class="where">'.$companus[$index][4].'</div>';
                echo '<div class="id">marker-id-'.$index.'</div>';
                if ($companus[$index][13]) {
                    echo '<div class="icon">'.$companus[$index][13].'</div>';
                    echo '<div class="html"><div class="marker-content image-marker"><div class="marker-image"><a href="'.$companus[$index][5].'" title="'.addcslashes($companus[$index][1] , '\'').'">'.$companus[$index][6].'</a></div><div class="marker-description"><div class="marker-name"><a href="'.$companus[$index][5].'" title="'.addcslashes($companus[$index][1] , '\'').'">'.addcslashes($companus[$index][1] , '\'').'</a></div>'.$companus[$index][10].'<div class="marker-address">'.addcslashes($companus[$index][14] , '\'').'</div><div class="marker-link"><a href="'.$companus[$index][5].'" title="'.addcslashes($companus[$index][1] , '\'').'"><i class="fa fa-arrow-circle-right"></i>'.__('Read More','metrodir').'</a></div></div></div></div></div>';
                } else {
                    echo '<div class="icon">'.get_template_directory_uri().'/images/pix-map.png</div>';
                    echo '<div class="html"><div id="map-marker-id-'.$index.'" class="marker-container map-no-over"><div class="marker-on-map" style="background: '.$companus[$index][9].';"><div class="marker-content"><div class="marker-image"><a href="'.$companus[$index][5].'" title="'.addcslashes($companus[$index][1] , '\'').'">'.$companus[$index][6].'</a></div><div class="marker-description"><div class="marker-name"><a href="'.$companus[$index][5].'" title="'.addcslashes($companus[$index][1] , '\'').'">'.addcslashes($companus[$index][1] , '\'').'</a></div>'.$companus[$index][10].'<div class="marker-address">'.addcslashes($companus[$index][14] , '\'').'</div><div class="marker-link"><a href="'.$companus[$index][5].'" title="'.addcslashes($companus[$index][1] , '\'').'"><i class="fa fa-arrow-circle-right"></i>'.__('Read More','metrodir').'</a></div></div></div><i class="marker-icon'.$companus[$index][8].'" title="'.addcslashes($companus[$index][1] , '\'').'">'.$companus[$index][12].'</i><div class="marker-close" title="Close"><i class="fa fa-times"></i></div></div><div class="map-triangle map-click" style="border-left: 16px solid '.$companus[$index][9].';"></div></div></div></div>';
                }
            }
        }
        echo'</div>';
        echo'<div id="markers_count">'.$markers_counter.'</div>';
        echo'</div>';
    }
    if (isset($places)) {
        $places_count = 1;
        for ($index = 1; $index <= count($places); $index++) {
            for ($index_inner = 1; $index_inner <= 2; $index_inner++) {
                if ($places[$index][$index_inner]) {
                    $counter = 0;
                    if(isset($places_filtered)){
                        for ($i = 1; $i <= count($places_filtered); $i++ ) {
                            if ($places_filtered[$i] == $places[$index][$index_inner]) {
                                $counter++;
                            }
                        }
                    }
                    if ($counter == 0) {
                        $places_filtered[$places_count] = $places[$index][$index_inner];
                        $places_count++;
                    }
                }
            }
        }
        if (isset($places_filtered)) {
            asort($places_filtered);
            echo'<script type="text/javascript">'."\n";
            echo'var $ = jQuery.noConflict();'."\n";
            echo'jQuery(document).ready(function(){'."\n";
            echo'var places = ['."\n";
            $index = 0;
            foreach($places_filtered as $places) {
                $index++;
                $places = preg_replace('/([^\pL\pN\pP\pS\pZ])|([\xC2\xA0])/u', ' ', $places);
                $places = str_replace('  ',' ', $places);
                $places = trim($places);
                echo'{ value: "'.$places.'"}'; if ($index != count($places_filtered)) {echo ','."\n";}
            }
            echo'];'."\n";
            echo'jQuery("#search-where").autocomplete({'."\n";
            echo'maxItemsToShow : 10,'."\n";
            echo'source         : places,'."\n";
            echo'select         : function( event, ui ) { jQuery("#search-where").val( ui.item.value ); if (jQuery("#map").length) { ajaxGetMarkers(); } return false; },'."\n";
            echo'minLength      : 0,});'."\n";
            echo'});'."\n";
            echo'jQuery("#search-where").click(function(){$(this).autocomplete( "search", "" );});'."\n";
            echo'</script>'."\n";
        }
    }
?>

<?php wp_reset_query(); wp_reset_postdata(); ?>

</div><!-- /Map Support Scripts -->
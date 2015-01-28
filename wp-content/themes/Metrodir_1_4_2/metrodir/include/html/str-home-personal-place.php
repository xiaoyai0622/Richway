<?php
$item_adrs_sng_lat = return_item_adrs_sng_lat();
$item_adrs_sng_lng = return_item_adrs_sng_lng();

$terms = get_the_terms( $post->ID, 'company_category' );

$item_cats_slugs = array();
if(is_array($terms)) {
    foreach ($terms as $term ) {
        $i++;
        $item_cats_slugs[$i] = $term->slug;
        $item_cats_slugs_id[$i] = $term->term_id;
    }
} else {
    $item_cats_slugs[1] = "default";
}

$custom_marker = get_option('glocal_category_'.$item_cats_slugs_id[1].'_marker');

if ($custom_marker) {
    $icon_single =  $custom_marker;
} else {
    $icon_single = get_template_directory_uri().'/images/markers/'.$item_cats_slugs[1].'.png';
}

$permalink = get_permalink();
$thumb = get_the_post_thumbnail();
$title = get_the_title();

$custom_fields = get_post_custom();
$country = $custom_fields['glocal_address_country_name'][0];
$region = $custom_fields['glocal_address_region_name'][0];
$name = $custom_fields['glocal_address_name'][0];
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


//Get Rating variable
$id = get_the_ID();
$item = new stdClass();
$item->rating = get_post_meta( $id, 'rating', true );
$rating = '';
if ($item->rating) {
    for ($i = 1; $i <= $item->rating['max']; $i++) {
        $rating .= '<i class="fa ';
        if (($item->rating['val'] + 1 - $i) >= 1) $rating .= "fa-star"; else if (($item->rating['val'] + 1 - $i) >= 0.5) $rating .= "fa-star-half-o"; else $rating .= 'fa-star-o';
        $rating .= ' fa-lg"></i> ';
    }
} else {
    $rating = '';
}
?>


<script type="text/javascript">
    jQuery(document).ready(function(){

        jQuery("#mapsingle").goMap({
            navigationControl: false,
            mapTypeControl: false,
            scrollwheel: false,
            draggablemaps: false,
            disableDoubleClickZoom: true,
            maptype                 : 'ROADMAP',
            zoom                    : 17,
            markers: [
                {
                    latitude: <?php echo $item_adrs_sng_lat+0.005; ?>,
                    longitude: <?php echo $item_adrs_sng_lng; ?>,
                    icon        : '<?php echo get_template_directory_uri().'/images/pix-bg.png' ?>'
                },
                {
                latitude: <?php echo $item_adrs_sng_lat; ?>,
                longitude: <?php echo $item_adrs_sng_lng; ?>,
                html: {
                    content:  '<div class="html"><div style="height: 120px; width: 320px; overflow: hidden; position: relative;"><div class="map-image" style="float: left; width: 120px; height: 120px; background: #CCCCCC;"><a href="<?php echo $permalink; ?>"><?php echo $thumb; ?></a></div><div style="float: left; width: 190px; height: 120px; padding: 0 0 0 10px;"><div><a style="display: block; font-size: 14px; font-weight: bold; line-height: 20px; overflow: hidden; max-height: 40px;" class="map-title" href="<?php echo $permalink; ?>"><?php echo $title; ?></a></div><div style="height: 16px"><?php echo $rating; ?></div><div style="font-size: 12px; color: #CCCCCC; margin: 0 0 2px 0; overflow: hidden; max-height: 48px;"><?php echo addcslashes($address , '\''); ?></div></div></div></div></div>',
                    popup: true
                },
                icon        : '<?php echo $icon_single; ?>'
                }
            ],
            hideByClick: true
        });
        jQuery.goMap.fitBounds();
    });
</script>


<div id="header-map" style="position: relative" >

    <div id="mapsingle" style="width: 100%; height: 300px; "></div>

    <div id="mapoverlay" style="position: absolute; width: 100%; height: 70px; bottom: 0; left: 0; right: 0; background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.2) 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);"></div>

</div>
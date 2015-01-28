var $ = jQuery.noConflict();
/* global document */
jQuery(document).ready(function(){

    /* Get map options */
    var options_container = jQuery("div#map_options");

    var draggable = options_container.find(".draggable").html();
    var scrollwheel = options_container.find(".scrollwheel").html();
    var maptype = options_container.find(".maptype").html();
    var zoom = options_container.find(".zoom").html();
    var clusters = options_container.find(".clusters").html();
    var markers_type = options_container.find(".markers-type").html();

    if (draggable == "true") {
        draggable = true;
    } else {
        draggable = false;
    }

    if (scrollwheel == "true") {
        scrollwheel = true;
    } else {
        scrollwheel = false;
    }

    zoom = Number(zoom);

    if (clusters == 'true') {
        clusters = true;
    } else {
        clusters = false;
    }

    var markers_center  = jQuery("div#markers_center");

    var map_lat = markers_center.find(".latitude").html();
    var map_lng = markers_center.find(".longitude").html();
    var map_mrk = markers_center.find(".marker").html();
    var map_ctr = markers_center.find(".option").html();


    /*** Load Map on Contact and Company Pages. ***/

    jQuery('#company-page-map').gMap({
        latitude        : map_lat,
        longitude       : map_lng,
        zoom            : 10,
        icon            : { image: map_mrk, iconsize: [40, 58], iconanchor: [0, 58] },
        scaleControl    : true,
        scrollwheel     : false,
        markers         : [{latitude : map_lat, longitude : map_lng}]
    });

    jQuery('#contact-page-map').gMap({
        latitude        : map_lat,
        longitude       : map_lng,
        zoom            : 10,
        icon            : { image: map_mrk, iconsize: [40, 58], iconanchor: [0, 58] },
        scaleControl    : true,
        scrollwheel     : false,
        markers         : [{latitude : map_lat, longitude : map_lng}]
    });


    /*** Load Major Map. ***/

    var map_centration_indikator;

    if ( jQuery("#content").hasClass('company')) {
        map_centration_indikator = 'center';
    } else if (map_ctr == "centre_world") {
        zoom = 3;
    } else if (map_ctr == "center_all") {
        map_centration_indikator = 'all';
    } else {
        map_centration_indikator = 'center';
    }

    if (jQuery("div#map").length) {

        loadmap(draggable, scrollwheel, maptype, zoom);

        jQuery.goMap.ready(function(){

            overlay = $.goMap.overlay;

            if (jQuery("div#content").hasClass("search-list")) {
                ajaxGetMarkers();
            } else if (jQuery("div#content").hasClass("search-adv")) {
                searchGetMarkers();
            } else {
                addmarkers(map_centration_indikator,markers_type);
            }

            if (clusters) {
                var markers = [];

                for (var i in $.goMap.markers) {
                    var temp = $($.goMap.mapId).data($.goMap.markers[i]);
                    markers.push(temp);
                }

                var markerclusterer = new MarkerClusterer($.goMap.map, markers);
            }

        });

        /*** Load Hidden Map. ***/

        if (jQuery("#map-wrapper").hasClass('load-hide')) {
            setTimeout(function(){
                jQuery("#map-control").addClass('active');
                jQuery('#map').animate({ height: '100px' });
                jQuery(".map-control.show").show();
                jQuery(".map-control.hide").hide();
            }, 500);
        }

        /*** Disable Map Button. ***/

        if (draggable == false) {
            jQuery('#disable-map-button').removeClass('map-enable').addClass('map-disable');
            jQuery('#disable-map-button').find('i').removeClass('fa-unlock').addClass('fa-lock');
        }

        jQuery('#disable-map-button').click(function(event) {
            event.preventDefault();
            if ( jQuery(this).hasClass('map-enable') ) {
                jQuery(this).removeClass('map-enable').addClass('map-disable');
                jQuery(this).find('i').removeClass('fa-unlock').addClass('fa-lock');
                jQuery("#map").removeData();
                jQuery("#map-trobber").fadeIn(500);
                options_container.find(".draggable").html("false");
                setTimeout(function(){
                    loadmap(false, scrollwheel, maptype, zoom); // Call map reload -----------------------------------------
                    overlay = $.goMap.overlay;
                    addmarkers(map_centration_indikator,markers_type);
                }, 1000);
            } else {
                jQuery(this).removeClass('map-disable').addClass('map-enable');
                jQuery(this).find('i').removeClass('fa-lock').addClass('fa-unlock');
                jQuery("#map").removeData();
                jQuery("#map-trobber").fadeIn(500);
                options_container.find(".draggable").html("true");
                setTimeout(function(){
                    loadmap(true, scrollwheel, maptype, zoom); // Call map reload ------------------------------------------
                    overlay = $.goMap.overlay;
                    addmarkers(map_centration_indikator,markers_type);
                }, 1000);
            }
        });


        /*** Show/Hide Map. ***/

        jQuery(".map-control").click(function() {
            if (jQuery(this).hasClass('hide')) {
                jQuery(this).parent('div').addClass('active');
                if (jQuery(".advanced-search-control").hasClass('active')) {
                    jQuery('#adv-search-container').slideToggle(485);
                    jQuery(".advanced-search-control").removeClass('active');
                    jQuery("#search-shadow").fadeOut(500);
                    jQuery(".advanced-search-control").find("a.show").css('display','block');
                    jQuery(".advanced-search-control").find("a.hide").hide();
                }
                jQuery('#map').animate({ height: '100px' });
                jQuery(".map-control.show").show();
                jQuery(".map-control.hide").hide();
            }
            if (jQuery(this).hasClass('show')) {
                jQuery(this).parent('div').removeClass('active');
                jQuery('#map').animate({ height: '485px' });
                jQuery(".map-control.hide").show();
                jQuery(".map-control.show").hide();
                setTimeout(function() { ajaxGetMarkers() }, 500);
            }
        });

        /*** Listener Scripts. ***/

        var marker = jQuery("div.marker-on-map");
        var marker_container = jQuery("div.marker-container");

        marker.find("i.marker-icon").live('click', function() {
            var marker = jQuery("div.marker-on-map");
            var marker_container = jQuery("div.marker-container");
            marker.css('width', '40px').css('height','40px');
            marker.find("div.marker-content").hide();
            marker.find("i.marker-icon").show();
            marker_container.removeClass("map-over").addClass("map-no-over");
            marker_container.find("div.map-triangle").removeClass("map-no-click").addClass("map-click");
            marker.find("div.marker-close").hide();
            jQuery(this).parent("div.marker-on-map").find("div.marker-close").show();
            jQuery(this).parent("div.marker-on-map").parent("div.marker-container").removeClass("map-no-over").addClass("map-over");
            jQuery(this).parent("div.marker-on-map").parent("div.marker-container").find("div.map-triangle").removeClass("map-click").addClass("map-no-click");
            jQuery(this).parent("div.marker-on-map").find("i.marker-icon").hide();
            jQuery(this).parent("div.marker-on-map").animate({ width: '400px', height: '153px'}, 250);
            jQuery(this).parent("div.marker-on-map").find("div.marker-content").fadeIn(250);
            displayPoint(jQuery(this).parent("div.marker-on-map").parent("div.marker-container").attr("id"));
        });

        marker.parent("div.marker-container.map-no-over").find("div.map-click").live('click', function() {
            var marker = jQuery("div.marker-on-map");
            var marker_container = jQuery("div.marker-container");
            marker.css('width', '40px').css('height','40px');
            marker.find("div.marker-content").hide();
            marker.find("i.marker-icon").show();
            marker_container.removeClass("map-over").addClass("map-no-over");
            marker_container.find("div.map-triangle").removeClass("map-no-click").addClass("map-click");
            marker.find("div.marker-close").hide();
            jQuery(this).parent("div.marker-container").find("div.marker-on-map").find("div.marker-close").show();
            jQuery(this).parent("div.marker-container").removeClass("map-no-over").addClass("map-over");
            jQuery(this).parent("div.marker-container").find("div.map-triangle").removeClass("map-click").addClass("map-no-click");
            jQuery(this).parent("div.marker-container").find("div.marker-on-map").find("i.marker-icon").hide();
            jQuery(this).parent("div.marker-container").find("div.marker-on-map").animate({ width: '400px', height: '153px'}, 250);
            jQuery(this).parent("div.marker-container").find("div.marker-on-map").find("div.marker-content").fadeIn(250);
            displayPoint(jQuery(this).parent("div.marker-container").attr("id"));
        });

        marker.find("div.marker-close").find("i").live('click', function() {
            var marker_container = jQuery("div.marker-container");
            jQuery(this).parent("div.marker-close").parent("div.marker-on-map").animate({ width: '40px', height: '40px'}, 250);
            jQuery(this).parent("div.marker-close").parent("div.marker-on-map").find("div.marker-content").fadeOut(250);
            jQuery(this).parent("div.marker-close").parent("div.marker-on-map").find("i.marker-icon").show();
            marker_container.removeClass("map-over").addClass("map-no-over");
            marker_container.find("div.map-triangle").removeClass("map-no-click").addClass("map-click");
            jQuery(this).parent("div.marker-close").hide();
        });

    }

    /*** Show/Hide adv Search. ***/

    jQuery(".advanced-search-control").find("a").click(function() {
        jQuery('#adv-search-container').slideToggle(485);
        if (jQuery("form#advanced-search").height() > 430) jQuery("form#advanced-search").css('height','430px').css('overflow-y', 'scroll');
        if (jQuery(this).hasClass('hide')) {
            jQuery(this).parent('div').removeClass('active');
            jQuery("#search-shadow").fadeOut(500);
            jQuery(".advanced-search-control").find("a.show").css('display','block');
            jQuery(".advanced-search-control").find("a.hide").hide();
        }
        if (jQuery(this).hasClass('show')) {
            if (jQuery("#map-control").hasClass('active')) {
                jQuery(this).removeClass('active');
                jQuery('#map').animate({ height: '485px' });
                jQuery(".map-control.hide").show();
                jQuery(".map-control.show").hide();
                setTimeout(function() { ajaxGetMarkers() }, 500);
            }
            jQuery(this).parent('div').addClass('active');
            jQuery("#search-shadow").fadeIn(500);
            jQuery(".advanced-search-control").find("a.show").hide();
            jQuery(".advanced-search-control").find("a.hide").css('display','block');
        }
    });

if (jQuery("#map").length && (jQuery("#markers_count").html() != 0)) {
    /* Hiding all the markers on the map. */
    for (var i in $.goMap.markers) {
        if (this[i] !== 0) {
            $.goMap.showHideMarker(jQuery.goMap.markers[i], false);
        }
    }

    var category = jQuery("#markers_center").find(".category").html();
    var company_category_search = jQuery("#company_category_search").html();
    if (company_category_search) {
        category = company_category_search;
    }
    if (category) {
        jQuery.goMap.showHideMarkerByGroup(category, true);
        var active_cat = jQuery('#industries-tabs ul').find("li.active").find("a").attr("id");
        if (active_cat != category) {
            jQuery('#industries-tabs ul li').removeClass('active');
            var category_container = 'a.' + category
            jQuery('#industries-tabs ul li').find(category_container).parent().addClass('active');
        }
    } else {
        active_cat = jQuery('#industries-tabs ul').find("li.active").find("a").attr("id");
        jQuery.goMap.showHideMarkerByGroup(active_cat, true);
    }

    if(jQuery("#industries-tabs").length ) {

        /* Processing clicks on the tabs under the map. Revealing corresponding to each tab markers. */
        jQuery('#industries-tabs ul li a').click(function(event) {
            /* Preventing default link action */
            event.preventDefault();

            if (jQuery("#default-search").length) {
                jQuery('#default-search #category-selector-default').val($(this).attr('class'));
                jQuery('#default-search .jquery-selectbox-currentItem').html($(this).attr('title'));
                jQuery('#default-search #scategory-input-default').val($(this).attr('class'));
            } else {
                jQuery('#category-selector-default').val($(this).attr('class'));
            }

            jQuery('#industries-tabs ul li').removeClass('active');
            jQuery(this).parent('li').addClass('active');

            if (jQuery("#hide-map-button").hasClass("map-expanded")) {
                ajaxGetMarkers();
            }


        });

    } else {
        jQuery.goMap.showHideMarkerByGroup("nocat", true);
    }
}
});

function reloadmap() {

    var options_container = jQuery("div#map_options");

    var draggable = options_container.find(".draggable").html();
    var scrollwheel = options_container.find(".scrollwheel").html();
    var maptype = options_container.find(".maptype").html();
    var zoom = options_container.find(".zoom").html();
    var clusters = options_container.find(".clusters").html();
    var markers_type = options_container.find(".markers-type").html();

    if (draggable == "true") {
        draggable = true;
    } else {
        draggable = false;
    }
    if (scrollwheel == "true") {
        scrollwheel = true;
    } else {
        scrollwheel = false;
    }

    zoom = Number(zoom);

    if (clusters == 'true') {
        clusters = true;
    } else {
        clusters = false;
    }

    loadmap(draggable, scrollwheel, maptype, zoom);

    var markers_center  = jQuery("div#markers_center");
    var map_ctr = markers_center.find(".option").html();

    var map_centration_indikator;

    if (map_ctr == "centre_world") {
        zoom = 3;
    } else if (map_ctr == "center_all") {
        map_centration_indikator = 'all';
    } else {
        map_centration_indikator = 'center';
    }

    overlay = $.goMap.overlay;

    addmarkers(map_centration_indikator,markers_type);

    if (clusters) {
        var markers = [];

        for (var i in $.goMap.markers) {
            var temp = $($.goMap.mapId).data($.goMap.markers[i]);
            markers.push(temp);
        }

        var markerclusterer = new MarkerClusterer($.goMap.map, markers);
    }

}

function reloadclearmap() {
    var options_container = jQuery("div#map_options");

    var draggable = options_container.find(".draggable").html();
    var scrollwheel = options_container.find(".scrollwheel").html();
    var maptype = options_container.find(".maptype").html();
    var zoom = options_container.find(".zoom").html();
    var clusters = options_container.find(".clusters").html();
    var markers_type = options_container.find(".markers-type").html();

    if (draggable == "true") {
        draggable = true;
    } else {
        draggable = false;
    }
    if (scrollwheel == "true") {
        scrollwheel = true;
    } else {
        scrollwheel = false;
    }

    zoom = Number(zoom);

    if (clusters == 'true') {
        clusters = true;
    } else {
        clusters = false;
    }

    loadmap(draggable, scrollwheel, maptype, zoom);
}

function loadmap(draggable, scrollwheel, maptype, zoom) {

    jQuery("#map").goMap({
        draggablemaps           : draggable,
        mapTypeControl          : true,
        mapTypeControlOptions   : { position: "LEFT", style: "DROPDOWN_MENU"},
        scrollwheel             : scrollwheel,
        panControl              : false,
        maptype                 : maptype,
        zoom                    : zoom
});

}

function addmarkers(map_centration_indikator,markers_type) {

    var companus = new Array();
    var companus_count = $("#markers_count").html();
    var load_index = 0;
    for (i=1; i<=companus_count; i++) {
        var companu_id = '#marker-' + i;
        var load_param = false;
        var load_param_index = $("#map_options").find(".markers-category-def").html();
        if (load_param_index == "true") {
            load_param = $(companu_id).hasClass('load-def');
        } else {
            load_param = $(companu_id).hasClass('load');
        }
        if (load_param) {
            load_index++;
            companus[load_index] = new Array();
            companus[load_index][1] = $(companu_id).find("div.lat").html();
            companus[load_index][2] = $(companu_id).find("div.lan").html();
            companus[load_index][3] = $(companu_id).find("div.group").html();
            companus[load_index][4] = $(companu_id).find("div.icon").html();
            companus[load_index][5] = $(companu_id).find("div.html").html();
            companus[load_index][8] = $(companu_id).find("div.id").html();
        }

    }
    if (markers_type == 'html') {
        for (i=1; i<=load_index; i++) {
            $.goMap.createMarker({
                latitude    : companus[i][1],
                longitude   : companus[i][2],
                id          : companus[i][8],
                group       : companus[i][3],
                icon        : companus[i][4]
            });

            displayInfoBox(companus[i][8], true);

        }
    } else {
        for (i=1; i<=load_index; i++) {
            $.goMap.createMarker({
                latitude    : companus[i][1],
                longitude   : companus[i][2],
                id          : companus[i][8],
                group       : companus[i][3],
                icon        : companus[i][4],
                html        : companus[i][5]
            });
        }
    }
    if (map_centration_indikator == 'center') {
        var markers_center = jQuery("div#markers_center");
        $.goMap.createMarker({
            latitude    : markers_center.find(".latitude").html(),
            longitude   : markers_center.find(".longitude").html(),
            id          : 'center',
            icon        : ''
        });
    }

    if (jQuery("div#content").hasClass("company-list")) {
        jQuery.goMap.fitBounds();
    } else if (map_centration_indikator == 'all') {
        jQuery.goMap.fitBounds();
    } else if (map_centration_indikator == 'center') {
        displayPoint('center');
    }

    $.goMap.removeMarker('center');

    jQuery("#map-trobber").fadeOut(500);

}


function displayPoint(marker) {
    var position = $($.goMap.mapId).data(marker).position;
    $.goMap.map.panTo(position);
}

function displayInfoBox(marker, indikator){

    var content = 'div#' + marker;

    if (indikator) {

        var content_get = 'div#map-' + marker;

        var newElems = document.createElement('div');

        newElems.id = marker;

        document.body.appendChild(newElems);

        $(content).html($(content_get).html());

        $(content).addClass('marker-container').addClass('map-no-over');

        $(content).appendTo(overlay.getPanes().floatPane);

        var position = $($.goMap.mapId).data(marker).position;

        $.goMap.createListener({type:'map'}, 'bounds_changed', function() {

            var markerOffset = overlay.getProjection().fromLatLngToDivPixel(position);
            $(content).css({ top:markerOffset.y, left:markerOffset.x });

        });
        $(content).show();

    } else {
        $(content).hide();
    }

}
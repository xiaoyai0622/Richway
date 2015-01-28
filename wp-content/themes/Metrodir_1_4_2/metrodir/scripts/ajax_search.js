(function(jQuery) {
    jQuery.fn.typeWatch = function(o) {
// The default input types that are supported
        var _supportedInputTypes =
            ['TEXT', 'TEXTAREA', 'PASSWORD', 'TEL', 'SEARCH', 'URL', 'EMAIL', 'DATETIME', 'DATE', 'MONTH', 'WEEK', 'TIME', 'DATETIME-LOCAL', 'NUMBER', 'RANGE'];

// Options
        var options = jQuery.extend({
            wait: 750,
            callback: function() { },
            highlight: true,
            captureLength: 2,
            inputTypes: _supportedInputTypes
        }, o);

        function checkElement(timer, override) {
            var value = jQuery(timer.el).val();

// Fire if text >= options.captureLength AND text != saved text OR if override AND text >= options.captureLength
            if ((value.length >= options.captureLength && value.toUpperCase() != timer.text)
                || (override && value.length >= options.captureLength))
            {
                timer.text = value.toUpperCase();
                timer.cb.call(timer.el, value);
            }
        };

        function watchElement(elem) {
            var elementType = elem.type.toUpperCase();
            if (jQuery.inArray(elementType, options.inputTypes) >= 0) {

// Allocate timer element
                var timer = {
                    timer: null,
                    text: jQuery(elem).val().toUpperCase(),
                    cb: options.callback,
                    el: elem,
                    wait: options.wait
                };

// Set focus action (highlight)
                if (options.highlight) {
                    jQuery(elem).focus(
                        function() {
                            this.select();
                        });
                }

// Key watcher / clear and reset the timer
                var startWatch = function(evt) {
                    var timerWait = timer.wait;
                    var overrideBool = false;
                    var evtElementType = this.type.toUpperCase();

// If enter key is pressed and not a TEXTAREA and matched inputTypes
                    if (typeof evt.keyCode != 'undefined' && evt.keyCode == 13 && evtElementType != 'TEXTAREA' && jQuery.inArray(evtElementType, options.inputTypes) >= 0) {
                        timerWait = 1;
                        overrideBool = true;
                    }

                    var timerCallbackFx = function() {
                        checkElement(timer, overrideBool)
                    }

// Clear timer
                    clearTimeout(timer.timer);
                    timer.timer = setTimeout(timerCallbackFx, timerWait);
                };

                jQuery(elem).on('keydown paste cut input', startWatch);
            }
        };

// Watch Each Element
        return this.each(function() {
            watchElement(this);
        });

    };
})(jQuery);


if (jQuery("#map").length) {
    // set interactive search
    var $ = jQuery.noConflict();
    var search = $('#directory-search'),
        searchInput = $('#search-what'),
        locationInput = $('#search-where'),
        categoryInput = $('#scategory-input-default');

    if(true){
        searchInput.typeWatch({
            callback: function() {
                ajaxGetMarkers();
            },
            wait: 500,
            highlight: false,
            captureLength: 0
        });
        locationInput.typeWatch({
            callback: function() {
                ajaxGetMarkers();
            },
            wait: 500,
            highlight: false,
            captureLength: 0
        });
        locationInput.select(function(){
            ajaxGetMarkers();
        });
        categoryInput.select(function(){
            ajaxGetMarkers();
        });
    }
}


function ajaxGetMarkers() {

    var trobber = $("#map-trobber");
    trobber.fadeIn(500);

    var error = $("#map-error");
    error.hide();

    var options_container = jQuery("div#map_options");
    var clusters = options_container.find(".clusters").html();
    var markers_type = options_container.find(".markers-type").html();

    if (clusters == 'true') {
        clusters = true;
    } else {
        clusters = false;
    }
    if (clusters) {
        jQuery("#map").removeData();
        reloadclearmap();
    } else {
        $.goMap.clearMarkers();
    }

    var what, where, cat;
    if (jQuery("#default-search").length) {
        what = $("#search-what").val();
        where = $("#search-where").val();
        cat = $("#category-selector-default").val();
    } else {
        what = '';
        where = '';
        cat = $("#category-selector-default").val();
    }

    if (cat == "allcat") {
        jQuery('#industries-tabs').removeClass('hidden');
    } else {
        jQuery('#industries-tabs').addClass('hidden');
    }
    if (what.length >= 1 ) what = TrimStr(what).toLowerCase();
    if (where.length >= 1 ) where = TrimStr(where).toLowerCase();
    if (cat) cat = cat.toLowerCase(); else cat = "allcat";
    var companus = new Array();
    var companus_count = $("#markers_count").html();
    for (i=1; i<=companus_count; i++) {
        var companu_id = '#marker-' + i;
        companus[i] = new Array();
        companus[i][1] = $(companu_id).find("div.lat").html();
        companus[i][2] = $(companu_id).find("div.lan").html();
        companus[i][3] = $(companu_id).find("div.group").html();
        companus[i][4] = $(companu_id).find("div.icon").html();
        companus[i][6] = $(companu_id).find("div.name").html();
        companus[i][7] = $(companu_id).find("div.where").html();
        companus[i][8] = $(companu_id).find("div.id").html();
        if ($(companu_id).hasClass('load')) {
            companus[i][9] = true;
        } else {
            companus[i][9] = false;
        }
        companus[i][10] = $(companu_id).find("div.html").html();
        displayInfoBox(companus[i][8], false);
    }
    var counter = 0;
    for (i=1; i<=companus_count; i++) {
        var companu_group = companus[i][3]; companu_group = companu_group.toLowerCase();
        var companu_name = companus[i][6]; companu_name = companu_name.toLowerCase();
        var companu_where = companus[i][7]; companu_where = companu_where.toLowerCase();
        if (companu_group == cat) {
            if (companu_name.indexOf(what) >= 0) {
                if (companu_where.indexOf(where) >= 0) {
                    if (markers_type == 'html') {
                        $.goMap.createMarker({
                            latitude    : companus[i][1],
                            longitude   : companus[i][2],
                            id          : companus[i][8],
                            group       : companus[i][3],
                            icon        : companus[i][4]
                        });
                        displayInfoBox(companus[i][8], true);

                    } else {
                        $.goMap.createMarker({
                            latitude    : companus[i][1],
                            longitude   : companus[i][2],
                            id          : companus[i][8],
                            group       : companus[i][3],
                            icon        : companus[i][4],
                            html        : companus[i][10]
                        });
                    }
                    counter++;
                }
            }
        } else if (cat == "allcat") {
            if (companu_name.indexOf(what) >= 0) {
                if (companu_where.indexOf(where) >= 0) {
                    if (companus[i][9]) {
                        if (markers_type == 'html') {
                            $.goMap.createMarker({
                                latitude    : companus[i][1],
                                longitude   : companus[i][2],
                                id          : companus[i][8],
                                group       : companus[i][3],
                                icon        : companus[i][4]
                            });
                            displayInfoBox(companus[i][8], true);

                        } else {
                            $.goMap.createMarker({
                                latitude    : companus[i][1],
                                longitude   : companus[i][2],
                                id          : companus[i][8],
                                group       : companus[i][3],
                                icon        : companus[i][4],
                                html        : companus[i][10]
                            });
                        }
                        counter++;
                    }
                }
            }
        }
    }
    if (counter == 0) {
        var map_lat = $("#markers_center").find("div.latitude").html();
        var map_lng = $("#markers_center").find("div.longitude").html();
        map_lat = Number(map_lat);
        map_lng = Number(map_lng);
        $.goMap.createMarker({
            latitude    : map_lat + 0.2,
            longitude   : map_lng + 0.3,
            icon        : '   ',
            id          : 'center-1'
        });
        $.goMap.createMarker({
            latitude    : map_lat - 0.2,
            longitude   : map_lng - 0.3,
            icon        : '   ',
            id          : 'center-2'
        });
        $.goMap.createMarker({
            latitude    : map_lat + 0.2,
            longitude   : map_lng - 0.3,
            icon        : '   ',
            id          : 'center-3'
        });
        $.goMap.createMarker({
            latitude    : map_lat - 0.2,
            longitude   : map_lng + 0.3,
            icon        : '   ',
            id          : 'center-4'
        });
        error.show();
        setTimeout(function(){error.fadeOut(500);}, 5000);
    }

    jQuery.goMap.fitBounds();

    $.goMap.removeMarker('center-1');
    $.goMap.removeMarker('center-2');
    $.goMap.removeMarker('center-3');
    $.goMap.removeMarker('center-4');

    if (clusters) {

        var markers = [];

        for (var i in $.goMap.markers) {
            var temp = $($.goMap.mapId).data($.goMap.markers[i]);
            markers.push(temp);
        }

        var markerclusterer = new MarkerClusterer($.goMap.map, markers);

    }

    setTimeout(function(){jQuery("#map-trobber").fadeOut(500);}, 500);


}

function searchGetMarkers() {

    var trobber = $("#map-trobber");
    trobber.fadeIn(500);

    var error = $("#map-error");
    error.hide();

    var options_container = jQuery("div#map_options");
    var clusters = options_container.find(".clusters").html();
    var markers_type = options_container.find(".markers-type").html();

    if (clusters == 'true') {
        clusters = true;
    } else {
        clusters = false;
    }
    if (clusters) {
        jQuery("#map").removeData();
        reloadclearmap();
    } else {
        $.goMap.clearMarkers();
    }

    var companus = new Array();
    var companus_count = $("#search_markers_count").html();
    for (i=1; i<=companus_count; i++) {
        var companu_id = '#search-marker-' + i;
        companus[i] = new Array();
        companus[i][1] = $(companu_id).find("div.lat").html();
        companus[i][2] = $(companu_id).find("div.lan").html();
        companus[i][3] = $(companu_id).find("div.group").html();
        companus[i][4] = $(companu_id).find("div.icon").html();
        companus[i][8] = $(companu_id).find("div.id").html();
        companus[i][9] = $(companu_id).find("div.html").html();
    }
    var counter = 0;
    for (i=1; i<=companus_count; i++) {
        if (markers_type == 'html') {
            $.goMap.createMarker({
                latitude    : companus[i][1],
                longitude   : companus[i][2],
                id          : companus[i][8],
                group       : companus[i][3],
                icon        : companus[i][4]
            });
            displayInfoBox(companus[i][8], true);

        } else {
            $.goMap.createMarker({
                latitude    : companus[i][1],
                longitude   : companus[i][2],
                id          : companus[i][8],
                group       : companus[i][3],
                icon        : companus[i][4],
                html        : companus[i][9]
            });
        }
        counter++;
    }
    if (counter == 0) {
        error.show();
    } else {

        if (clusters) {

            var markers = [];

            for (var i in $.goMap.markers) {
                var temp = $($.goMap.mapId).data($.goMap.markers[i]);
                markers.push(temp);
            }

            var markerclusterer = new MarkerClusterer($.goMap.map, markers);

        }

        jQuery.goMap.fitBounds();
    }

    jQuery("#map-trobber").fadeOut(500);

}

function TrimStr(s) {
    s = s.replace( /^\s+/g, '');
    return s.replace( /\s+$/g, '');
}
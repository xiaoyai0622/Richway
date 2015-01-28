function gps_convert() {


    var geocoder;
    var start_lat = jQuery("#opt_metrodir_company_address_lat").val();
    var start_lng = jQuery("#opt_metrodir_company_address_lng").val();
    var address = jQuery("#opt_metrodir_company_address").val();


    geocoder = new google.maps.Geocoder();
    geocoder.geocode( { address: address, region: 'en'}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {

            var latlng = new google.maps.LatLng(start_lat,start_lng);
            var options = {
                zoom: 15,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };


            jQuery('#opt_metrodir_company_address_lat').val(results[0].geometry.location.lat());
            jQuery('#opt_metrodir_company_address_lng').val(results[0].geometry.location.lng());
            jQuery("#metrodir_convert_gps_log").html("Geocode was successful. Status: " + status);

        } else {
            jQuery("#metrodir_convert_gps_log").html("Error! Geocode was not successful for the following reason: " + status);
        }
    });
}

function gps_convert_cntr() {


    var geocoder;
    var start_lat = jQuery("#opt_metrodir_company_cntr_address_lat").val();
    var start_lng = jQuery("#opt_metrodir_company_cntr_address_lng").val();
    var address = jQuery("#opt_metrodir_company_cntr_address").val();


    geocoder = new google.maps.Geocoder();
    geocoder.geocode( { address: address, region: 'en'}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {

            var latlng = new google.maps.LatLng(start_lat,start_lng);
            var options = {
                zoom: 15,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };


            jQuery('#opt_metrodir_company_cntr_address_lat').val(results[0].geometry.location.lat());
            jQuery('#opt_metrodir_company_cntr_address_lng').val(results[0].geometry.location.lng());
            jQuery("#metrodir_cntr_convert_gps_log").html("Geocode was successful. Status: " + status);

        } else {
            jQuery("#metrodir_cntr_convert_gps_log").html("Error! Geocode was not successful for the following reason: " + status);
        }
    });
}


/*** Equal Heights function. ***/
var $ = jQuery.noConflict();

/* Page Ready Scripts */
/*** 1. Menu Support Scripts. ***/
/*** 2. Mobile Menu Script. ***/
/*** 3. Adding sliders for the advanced search form. Implementing switching between default and advanced search forms. ***/
/*** 4. Slider for Partners and Featured Companies blocks. ***/
/*** 5. Calling selectbox() plugin to create custom stylable select lists. ***/
/*** 6. Adding <input> placeholders (for IE 8-9). ***/
/*** 7. Colorbox for portfolio images and user admin-cp. ***/
/*** 8. Login & Register form. ***/
/*** 9. Contact forms. ***/
/*** 10. Sorting Form on Search pages. ***/
/*** 11. Add <div> container on submin button in comment form. ***/
/*** 12. Show results in title on search pages. ***/
/*** 13. Company tabs switching. ***/
/*** 14. Scroll Top Button Support Script. ***/
/*** 15. Theme Switcher Scripts. ***/
/*** 16. Fix For hide load adv search. ***/
/*** 17. Claim listing script. ***/
/*** 18. Home tabs switching. ***/
/*** 19. Megasearch select ***/
/*** 20. Category Block Show Companies list ***/
/*** 21. Icon change for RTL support ***/
/*** 22. Remove Class for RTL support ***/
/*** 23. Fix for ui-autocomplete in boxed version. ***/
/*** 24. Fixed Map on Search Pages Switch. ***/
jQuery(document).ready(function(){

    /*** 1. Menu Support Scripts. ***/

    var logo = jQuery("#logo");
    var header_one = jQuery("#header-style-one");
    var header_two = jQuery("#header-style-two");

    if (header_one.find("#main-menu").width() > 720) {
        logo.css('height', '85px').css('width','100%');
        logo.find("a").css('margin', '16px auto 0 auto').css('width', logo.find("img").width());
    }

    if (header_two.find("#main-menu").width() > 720) {
        header_two.find("#main-menu > div > ul").css('margin','0');
        logo.css('height', '85px').css('width','100%');
        logo.find("a").css('margin', '16px auto 0 auto').css('width', logo.find("img").width());
    }

    var menu_container = jQuery('#sf-menu');

    menu_container.superfish({
        delay:      350,
        speed:      'normal'
    });


    /*** 2. Mobile Menu Script. ***/

    if (jQuery("#fixed-map-container").length && jQuery(window).width() > 1120) {
        menu_container.mobileMenu({
            switchWidth: 1300,
            prependTo: '#main-menu',
            combine: false
        });
    } else {
        menu_container.mobileMenu({
            switchWidth: 751,
            prependTo: '#main-menu',
            combine: false
        });
    }


    /*** 3. Adding sliders for the advanced search form. Implementing switching between default and advanced search forms. ***/

	/* Calling slider() function and setting slider options. */
    var search_params = jQuery("#search-params");
    var valuedist = search_params.find(".default").html();
    var mindist = search_params.find(".mininmum").html();
    var maxdist = search_params.find(".maximum").html();
    var abrv = search_params.find(".abrv").html();
    var maxday = search_params.find(".dmax").html();

    var slider_distance = jQuery("#slider-distance");

    slider_distance.slider({
		range: 'min',
        value: Number(valuedist),
        min:  Number(mindist),
        max: Number(maxdist),
		slide: function( event, ui ) {
            if ( ui.value == maxdist ) {
                jQuery('#distance').text( '∞' );
                jQuery('#distance-input').attr( 'value', 9999999999999 );
            } else {
                jQuery('#distance').text( ui.value + ' ' + abrv );
                jQuery('#distance-input').attr('value', ui.value );
            }
		}
	});
	/* Showing the default value on the page load. */
    jQuery('#distance').text( slider_distance.slider('value') + ' ' + abrv  );
    jQuery('#distance-input').attr( 'value', slider_distance.slider('value') );

	/* Calling slider() function and setting slider options. */

    var slider_days = jQuery("#slider-days-published");

    slider_days.slider({
		range: 'min',
		value: 10,
		min: 0,
		max: Number(maxday),
		slide: function( event, ui ) {
            if ( ui.value == maxday ) {
                jQuery('#days-published').text( '∞' );
                jQuery('#days-published-input').attr( 'value', 9999999999999 );
            } else {
                jQuery('#days-published').text( '< ' + ui.value );
                jQuery('#days-published-input').attr('value', ui.value );
            }
		}
	});
	/* Showing the default value on the page load. */
	jQuery('#days-published').text( '< ' + slider_days.slider('value') );
    jQuery('#days-published-input').attr('value', slider_days.slider('value') );


    /*** 4. Slider for Partners and Featured Companies blocks. ***/

    jQuery(".carusel").flexslider({
        animation: "slide",
        slideshow: false,
        directionNav: false,
        keyboardNav: false
    });

    jQuery(".carusel-auto").flexslider({
        animation: "slide",
        slideshow: true,
        directionNav: false,
        keyboardNav: false
    });

    jQuery('#slideshow').flexslider({
        controlNav: false
    });


    /*** 5. Calling selectbox() plugin to create custom stylable select lists. ***/

	jQuery('#category-selector-default').selectbox({
		animationSpeed: "fast",
        listboxMaxSize: 418
	});

	jQuery('#category-selector-advanced').selectbox({
		animationSpeed: "fast",
        listboxMaxSize: 168
	});

	jQuery('#country-selector-advanced').selectbox({
		animationSpeed: "fast",
		listboxMaxSize: 208
	});

    jQuery('#sorting-sortby').selectbox({
        animationSpeed: "fast",
        listboxMaxSize: 84
    });

    jQuery('#sorting-sort').selectbox({
        animationSpeed: "fast",
        listboxMaxSize: 84
    });


    /*** 6. Adding <input> placeholders (for IE 8-9). ***/

	jQuery('textarea, input[type="text"]').placeholder();


    /*** 7. Colorbox for portfolio images and user admin-cp. ***/

    jQuery('.colorbox').colorbox({ maxWidth: '95%', maxHeight: '95%' });

    jQuery('.colorbox-popup').colorbox({
        iframe          : true,
        overlayClose    : false,
        maxWidth        : "940",
        width           : "95%",
        height          : "95%",
        fixed           : true
    });


    /*** 8. Login & Register form. ***/

	jQuery('#login-link').click(function() {
        jQuery(this).parent("li.login").addClass('active');
        jQuery("#login-shadow").css('height',$("html").height()).fadeIn(500);
        jQuery(this).parent("li.login").find("#login-form").animate({ top: '80px' }, 500);
        jQuery(this).parent("li.login").find("#login-form").find("#login-form-container").fadeIn(750);
	});

    jQuery("#login-shadow").click(function() {
        var loginform = jQuery("#login-form");
        loginform.parent("li.login").removeClass('active');
        jQuery("#login-shadow").fadeOut(500);
        loginform.animate({ top: '-400px' }, 500);
        loginform.find("#login-form-container").fadeOut(500);
    });


    /*** 9. Contact forms. ***/

    // Needed variables
    var $contactform = $('#contact-message-form');

    $contactform.submit(function(){
        $('input[type=submit]').attr('disabled', 'disabled');
        $.ajax({
            type: "POST",
            dataType : 'json',
            data: $(this).serialize()+"&action=send_mail_metrodir"
            }).success(function(response)
            {
                if(response.success == 200){
                    el = '<div class="notification-success"><i class="fa fa-exclamation-circle"></i> '+ response.message +'</div>';
                }
                else
                {
                    el = '<div class="notification-error"><i class="fa fa-times-circle"></i> ERROR: '+ response.message +'</div>';
                }

                // Hide any previous response text
                $("#contact-message-form .notification-error,#contact-message-form .notification-success").remove();
                e = $(el);
                e.hide();
                // Show response message
                $contactform.prepend(e);
                e.show('fade');
                $('input[type=submit]').removeAttr('disabled', 'disabled');
            });
        return false;
    });

    // Needed variables
    var $contactsingleform 	= $('#contact-single-message-form');

    $contactsingleform.submit(function(){
        $('input[type=submit]').attr('disabled', 'disabled');
        $.ajax({
            type: "POST",
            dataType : 'json',
            data: $(this).serialize()+"&action=send_single_mail_metrodir"
            }).success(function(response)
            {
                if(response.success == 200){
                    el = '<div class="notification-success"><i class="fa fa-exclamation-circle"></i> '+ response.message +'</div>';
                }
                else
                {
                    el = '<div class="notification-error"><i class="fa fa-times-circle"></i> ERROR: '+ response.message +'</div>';
                }

                // Hide any previous response text
                $("#contact-single-message-form .notification-error,#contact-single-message-form .notification-success").remove();
                e = $(el);
                e.hide();
                // Show response message
                $contactsingleform.prepend(e);
                e.show('fade');
                $('input[type=submit]').removeAttr('disabled', 'disabled');
            });
        return false;
    });


    /*** 10. Sorting Form on Search pages. ***/

    var sorting = jQuery('#search-sorting'),
        form = sorting.find('form'),
        count = sorting.find('#sorting-pagination'),
        sortby = sorting.find('#sorting-sortby'),
        sort = sorting.find('#sorting-sort');

    var values = { };

    if (sorting.find('.def-sortby').html()) {
        values.sortby = sorting.find('.def-sortby').html();
        sorting.find(".sortby").find(".jquery-selectbox-currentItem").html(sorting.find('.def-sortby').html());
    } else {
        values.sortby = 'date';
        sorting.find(".sortby").find(".jquery-selectbox-currentItem").html('date');
    }

    values.sort = sorting.find('.def-sort').html();

    if (sorting.find('.def-sort').html() == "ASC") {
        sorting.find(".sort").find(".jquery-selectbox-currentItem").html("∧");
    } else {
        sorting.find(".sort").find(".jquery-selectbox-currentItem").html("∨");
    }

    values.count = sorting.find('.def-pagination').html();

    if (sorting.find('.def-pagination').html() == "99999") {
        sorting.find(".count").find(".jquery-selectbox-currentItem").html("ALL");
    } else {
        sorting.find(".count").find(".jquery-selectbox-currentItem").html(sorting.find('.def-pagination').html());
    }

    sortby.val(values.sortby);
    sort.val(values.sort);
    count.val(values.count);

    count.change(function(event) {
        form.submit();
    });

    sortby.change(function(event) {
        form.submit();
    });

    sort.change(function(event) {
        form.submit();
    });


    /*** 11. Add <div> container on submin button in comment form. ***/

    var input_container = jQuery("form#comment-message-form > p.form-submit");
    if (input_container.length) {
        var html = input_container.html();
        input_container.html('<div class="submit"><i class="fa fa-sign-out"></i>' + html + '</div>');
    }


    /*** 12. Show results in title on search pages. ***/

    var content_search = jQuery("#content");
    var content_search_center = jQuery("#content-center");
    var search_results = jQuery("#search-results");

    if (content_search.hasClass('search-adv') || content_search.hasClass('search-list')) {
        var search_title = content_search_center.find("div.title > h1").html();
        var search_count = search_results.html();
        content_search_center.find("div.title > h1").html(search_count + ' ' + search_title);
        if (search_count == "NO") jQuery("#search-sorting").css('display','none');
    }

    if (content_search.hasClass('blog-list-search')) {
        var search_title_blog = content_search_center.find("div.title").html();
        var search_count_blog = search_results.html();
        content_search_center.find("div.title").html(search_count_blog + ' ' + search_title_blog);
    }

    if (content_search.hasClass('mega-search')) {
        var search_title_mega = content_search_center.find("div.title").html();
        var search_count_mega = search_results.html();
        content_search_center.find("div.title").html(search_count_mega + ' ' + search_title_mega);
    }


    /*** 13. Company tabs switching. ***/

    var hash = window.location.hash;

    var company_tab = jQuery("#company-tabs-active");
    var company_tab_li = company_tab.find("li");
    var company_tab_li_a = company_tab.find("li").find("a");

    if ( jQuery(hash).length ) {
        jQuery('.company-tabs-content').slideUp(500);
        jQuery(hash).delay(500).slideDown(500);
        company_tab_li.removeClass('active');
        var link_index = '#company-tabs-active li .' + hash.slice(1);
        jQuery(link_index).parent().addClass('active');
    } else {
        if (jQuery(".company-tabs").length) {
            jQuery('.company-tabs-content').slideUp(300);
            window.location.hash = 'company-tabs';
            jQuery('#company-tabs-page').slideDown(300);
        }
    }

    company_tab_li_a.click(function(event) {
        event.preventDefault();
        company_tab_li.removeClass('active');
        jQuery(this).parent().addClass('active');
        jQuery('.company-tabs-content').slideUp(500);
        var tabID = $(this).attr('class');
        window.location.hash = tabID;
        jQuery('#' + tabID).delay(500).slideDown(500);
        return false;
    });


    /*** 14. Scroll Top Button Support Script. ***/

    var e = jQuery(".scrollTop");
    var windowheight = 300;
    var speed = 300;

    e.click(function(){
        jQuery("html:not(:animated)" +( !jQuery.browser.opera ? ",body:not(:animated)" : "")).animate({ scrollTop: 0}, speed );
        return false;
    });
    function show_scrollTop(){
        ( jQuery(window).scrollTop()>windowheight ) ? e.fadeIn(speed) : e.fadeOut(speed);
    }
    jQuery(window).scroll( function(){show_scrollTop()} ); show_scrollTop();


    /*** 15. Theme Switcher Scropts. ***/

    var theme_switcher = jQuery("#theme-switcher");
    var switcher_toggle_button =  jQuery("#switcher-toggle-button");

    if (jQuery("html").width() < 1024) {
        theme_switcher.removeClass('visible').stop(true, false).animate({ left: '-242px' });
    }

    switcher_toggle_button.click(function() {
        if ( theme_switcher.hasClass('visible') == true ) {
            theme_switcher.removeClass('visible').stop(true, false).animate({ left: '-242px' });
        } else {
            theme_switcher.addClass('visible').stop(true, false).animate({ left: 0 });
        }
    });

    var color_switcher = jQuery("#color-switcher").find("li");

    color_switcher.click(function() {
        var color = jQuery(this).attr('class');
        var themepath = jQuery("#themepath").html();
        jQuery('#theme-color-css').attr('href', themepath + '/css/color-' + color + '.css');
        color_switcher.find('i').removeClass('fa').removeClass('fa-check');
        jQuery(this).find('i').addClass('fa').addClass('fa-check');
    });

    var header_container = jQuery('header');
    var section_container = jQuery('section');
    var footer_container = jQuery('footer');

    var body_container = jQuery('body');

    var map_container = jQuery("#map");
    var map_trobber = jQuery("#map-trobber");

    var background_switcher = jQuery("#background-switcher");

    jQuery('#layout-switcher').on('change', function() {
        currentLayout = this.value;
        if( currentLayout == 'boxed' ) {
            header_container.addClass('boxed');
            section_container.addClass('boxed');
            footer_container.addClass('boxed');
            body_container.addClass('background-1');
            background_switcher.find('li.background-1').find('i').addClass('fa').addClass('fa-check');
            map_container.removeData();
            map_trobber.fadeIn(500);
            setTimeout(function(){
                reloadmap();
            }, 1000);
        } else if ( currentLayout == 'fullscreen' ) {
            header_container.removeClass('boxed');
            section_container.removeClass('boxed');
            footer_container.removeClass('boxed');
            body_container.removeClass('background-1');
            body_container.removeClass('background-2');
            body_container.removeClass('background-3');
            background_switcher.find('li').find('i').removeClass('fa').removeClass('fa-check');
            map_container.removeData();
            map_trobber.fadeIn(500);
            setTimeout(function(){
                reloadmap();
            }, 1000);
        }
    });

    background_switcher.find('li').click(function() {
        currentLayout = $('#layout-switcher').val();
        if( currentLayout == 'boxed' ) {
            background = $(this).attr('class');
            body_container.removeClass();
            body_container.addClass(background);
            background_switcher.find('li').find('i').removeClass('fa').removeClass('fa-check');
            $(this).find('i').addClass('fa').addClass('fa-check');
        } else {
            alert('Background is visible only in boxed layout. Please select boxed layout.');
        }
    });


    /*** 16. Fix For hide load adv search. ***/

    var adv_search_container = jQuery("#adv-search-container");

    if (jQuery(window).width() >= 768) {
        adv_search_container.css('top','60px').hide();
    } else if (jQuery(window).width() >= 480) {
        adv_search_container.css('top','110px').hide();
    } else {
        adv_search_container.css('top','210px').hide();
    }


    /*** 17. Claim listing script. ***/

    jQuery('#claim-company').click(function() {
        jQuery('#claim-company-form').slideToggle(500);
        if (jQuery(this).find('i').hasClass('fa-chevron-circle-down')) {
            jQuery(this).find('i').removeClass('fa-chevron-circle-down').addClass('fa-chevron-circle-up');
        } else {
            jQuery(this).find('i').removeClass('fa-chevron-circle-up').addClass('fa-chevron-circle-down');
        }
    });

    jQuery("#send-claim").click(function() {

        var form = $("#claim-company-form");
        var postId = form.data('post-id');
        var values = {};
        var validator = true;

        if(!form.find("#claim-name").val()) validator = false;
        if(!form.find("#claim-email").val()) validator = false;
        if(!form.find("#claim-login").val()) validator = false;

        if(validator) {
            jQuery.post(MyAjax.ajaxurl, {
                action: 'action_item_claim',
                nonce: MyAjax.ajaxnonce,
                post_id: postId,
                claim_name: form.find("#claim-name").val(),
                claim_email: form.find("#claim-email").val(),
                claim_login: form.find("#claim-login").val(),
                claim_comm: form.find("#claim-comm").val(),
                rating_values: values
            }, function(data) {
                form = jQuery("#claim-company-form");
                if(data != "nonce" && data != "already" && data != "nonce"){
                    form.replaceWith(data);
                    if (jQuery.fn.inFieldLabels) {
                        form.find("label").inFieldLabels();
                    }
                }
                form.find(".message.success").show();
                form.find(".message.error").hide();
                form.find(".message.br").hide();
                return false;
            });

        } else {
            // show error message
            form.find(".message.success").hide();
            form.find(".message.error").show();
            form.find(".message.br").show();
            return false;
        }
    });


    /*** 18. Home tabs switching. ***/

    var home_tabs_active = jQuery("#home-tabs-active");

    if (home_tabs_active.hasClass('home-tabs')) {

        var hash_home = window.location.hash;
        if ( jQuery(hash_home).length ) {
            jQuery('.home-tab-content').slideUp(500);
            jQuery(hash_home).delay(500).slideDown(500);
            home_tabs_active.find("li").removeClass('active');
            var home_tabs_hash = '#home-tabs-active li .' + hash_home.slice(1);
            jQuery(home_tabs_hash).parent().addClass('active');
        } else {
            if (jQuery(".home-tabs").length) {
                jQuery('.home-tab-content').slideUp(300);
                var home_tabs_welcome = jQuery("#home-tabs-welcome");
                if (home_tabs_welcome.length) {
                    window.location.hash = 'home-tabs-welcome';
                    home_tabs_welcome.slideDown(300);
                } else if ($('#home-tabs-category').length) {
                    window.location.hash = 'home-tabs-category';
                    jQuery('#home-tabs-category').slideDown(300);
                } else if ($('#home-tabs-custom').length) {
                    window.location.hash = 'home-tabs-custom';
                    jQuery('#home-tabs-custom').slideDown(300);
                }

            }
        }

        home_tabs_active.find('li').find('a').click(function(event) {
            event.preventDefault();
            home_tabs_active.find("li").removeClass('active');
            jQuery(this).parent().addClass('active');
            jQuery('.home-tab-content').slideUp(500);
            var tabID = jQuery(this).attr('class');
            window.location.hash = tabID;
            jQuery('#' + tabID).delay(500).slideDown(500);
            return false;
        });

    }


    /*** 19. Megasearch select ***/

    var megasearch_button = jQuery(".megasearch-select-button");
    var megasearch_form = jQuery(".megasearch-container-inner").find('form');
    var megasearch = jQuery("ul.megasearch-select-list");

    megasearch_button.click(function() {
        jQuery(this).parent('div.megasearch-select').find('ul').slideToggle(500);
        if (jQuery(this).hasClass('active')) {
            jQuery(this).removeClass('active');
        } else {
            jQuery(this).addClass('active');
        }
    });

    megasearch.find("li").click(function() {
        megasearch.find("li").removeClass('active');
        var getclass = jQuery(this).attr('class');
        jQuery(this).addClass('active');
        jQuery("#megasearch-specification").val(getclass);
        var geticon = jQuery(this).find('i').attr('class');
        megasearch_button.find('i').attr('class',geticon + ' fa-lg');
        megasearch_button.removeClass('active');
        jQuery('div.megasearch-select').find('ul').slideUp(500);
    });

    megasearch_form.find("input#megasearch-keywords").click(function() {
        megasearch_button.removeClass('active');
        jQuery('div.megasearch-select').find('ul').slideUp(500);
    });


    /*** 20. Category Block Show Companies list ***/

    var categorylistheader = jQuery(".category-item-header.hidden");

    categorylistheader.click(function() {
        if (jQuery(this).parent(".category-item-block.hidden").find(".categories-item-list.hidden").hasClass("show")) {
            jQuery(this).parent(".category-item-block.hidden").find(".categories-item-list.hidden").slideUp(500);
            jQuery(this).parent(".category-item-block.hidden").find(".categories-item-list.hidden").removeClass("show");
        } else {
            categorylistheader.parent(".category-item-block.hidden").find(".categories-item-list.hidden").removeClass("show");
            categorylistheader.parent(".category-item-block.hidden").find(".categories-item-list.hidden").slideUp(500);
            jQuery(this).parent(".category-item-block.hidden").find(".categories-item-list.hidden").slideDown(500);
            jQuery(this).parent(".category-item-block.hidden").find(".categories-item-list.hidden").addClass("show");
        }

    });


    /*** 21. Icon change for RTL support ***/

    var rtl_container = jQuery("body.rtl");

    rtl_container.find('i').each(function() {
        if (jQuery(this).hasClass('fa-arrow-circle-right')) {
            jQuery(this).removeClass('fa-arrow-circle-right').addClass('fa-arrow-circle-left');
        }
        if (jQuery(this).hasClass('fa-sign-out')) {
            jQuery(this).removeClass('fa-sign-out').addClass('fa-sign-in');
        }
        if (jQuery(this).hasClass('fa-star-half-o')) {
            jQuery(this).removeClass('fa-star-half-o').addClass('fa-star');
        }
    });


    /*** 22. Remove Class for RTL support ***/

    if (jQuery("body").hasClass('rtl')) {
        jQuery("section").removeClass('no-rtl');
        jQuery("header").removeClass('no-rtl');
        jQuery("footer").removeClass('no-rtl');
    }


    /*** 23. Fix for ui-autocomplete in boxed version. ***/

    if (jQuery("section").hasClass('boxed')) jQuery(".ui-autocomplete").addClass('boxed');


    /*** 24. Fixed Map on Search Pages Switch. ***/

    var position = 'left';

    if  (jQuery("#fixed-map-container").length && jQuery(window).width() > 1120) {
        if (jQuery("#fixed-map-container").hasClass('position-right')) position = 'right';
        jQuery("body").addClass('fixed-map-'+position).addClass('fixed-map');
        var map_height = jQuery(window).height() - jQuery("#wpadminbar").height();
        jQuery("#map").css('height', map_height);
        var map_width = jQuery(window).width() - (62 + jQuery("#main-content").width());
        jQuery("#map-wrapper").css('min-width', map_width).css('width', map_width);
    }

});


/* Page Load Scripts */
/*** 1. Load footer always window button. ***/
/*** 2. Effect for <h1> in Breadcrumbs on Page Load. ***/
/*** 3. Load Flickr Block. ***/
jQuery(window).load(function(){

    /*** 1. Load footer always window button. ***/


    var footer_block = jQuery("#footer");
    var footer_height = footer_block.height() + jQuery("#copyright").height();

    jQuery("footer").css('margin-top', -1*footer_height);
    jQuery("#footer-mirror").css('height', footer_height);


    /*** 2. Effect for <h1> in Breadcrumbs on Page Load. ***/

    jQuery("div#breadcrumbs h1").animate({ margin: 0, opacity: 1 }, 300);


    /*** 3. Load Flickr Block. ***/

    var flickr_feed = jQuery("#flickr-feed");

    flickr_feed.each(function() {
        var flickr_id = jQuery(this).html();
        jQuery(this).html('<ul></ul>');
        jQuery(this).find('ul').jflickrfeed({
            limit           : 6,
            qstrings        : { id: flickr_id },
            itemTemplate    : '<li><a class="opacity" href="{{image_b}}"><img src="{{image_s}}" alt="{{title}}" /></a></li>'
        });
    });

});


/* Page Resize Scripts */
/*** 1. Fixed Map on Search Pages Switch. ***/
jQuery(window).resize(function() {

    /*** 1. Fixed Map on Search Pages Switch. ***/

    var position = 'left';

    if  (jQuery("#fixed-map-container").length && jQuery(window).width() > 1120) {
        if (jQuery("#fixed-map-container").hasClass('position-right')) position = 'right';
        jQuery("body").addClass('fixed-map-'+position).addClass('fixed-map');
        var map_height = jQuery(window).height() - jQuery("#wpadminbar").height();
        jQuery("#map").css('height', map_height);
        var map_width = jQuery(window).width() - (62 + jQuery("#main-content").width());
        jQuery("#map-wrapper").css('min-width', map_width).css('width', map_width);
    } else {
        if (jQuery("#fixed-map-container").hasClass('position-right')) position = 'right';
        jQuery("body").removeClass('fixed-map-'+position).removeClass('fixed-map');
        jQuery("#map").css('height','');
        jQuery("#map-wrapper").css('min-width', '').css('width', '');
    }

});


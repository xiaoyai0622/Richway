var shortname = 'metrodir';

jQuery(document).ready(function() {

    jQuery(document).on("click", ".check-addressmeta", function(event) {

        var postId = jQuery(this).data('post-id');
        var divFixCompany = jQuery(this);
        jQuery(this).find('i').removeClass('fa-exclamation-triangle fa-lg').addClass('fa-spinner fa-spin');

        jQuery.post(MyAjax.ajaxurl, { action: 'action_check_addressmeta', nonce: MyAjax.ajaxnonce, post_id: postId }, function(data) {

            if(data != "nonce" && data != "already" && data != "nonce"){
                console.log(data);
                if (data == 'good0'){
                    divFixCompany.css('background','green');
                    divFixCompany.find('i').removeClass('fa-spinner fa-spin').addClass('fa-check fa-lg');
                    setTimeout(function() {
                        divFixCompany.fadeOut(500);
                    }, 500);
                } else if (data == 'bad0') {
                    divFixCompany.css('background','red');
                    divFixCompany.find('i').removeClass('fa-spinner fa-spin').addClass('fa-ban fa-lg');
                }
            }
        });
    });

	window.original_send_to_editor = window.send_to_editor;
	
	window.send_to_editor = function(html) {
		var portInput = jQuery("#"+shortname+"_portfolio_image_url", window.parent.document);
		if(portInput.length) {
			imgurl = jQuery('img', html).attr('src');
			portInput.val(imgurl);	
		}else {
			window.original_send_to_editor(html);	
		}
		tb_remove();
	};

    jQuery("#colorSelector").ColorPicker({
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onBeforeShow: function () {
            jQuery(this).ColorPickerSetColor(jQuery("#metrodir_category_color").val());
        },
        onChange: function (hsb, hex, rgb) {
            jQuery("#metrodir_category_color").val('#' + hex);
            jQuery("#colorSelector > div").css('background-color', '#' + hex);
        }
    });

    //Tabs in admipanel
    jQuery("#admin-tabs").easytabs({
        animate			: true,
        updateHash		: true
    });

    if (jQuery('#uou_custom_fields_wrapper ul').length){
        jQuery('#uou_custom_fields_wrapper ul').sortable({

            handle: jQuery('#uou_custom_fields_wrapper li .head'),
            items: '> li',
            stop: function(event, ui) {

                /// RETURN FALSE FOR SHOWING THE CONTENT
                jQuery('#uou_custom_fields_wrapper ul').CustomFieldRefresh();

            }

        });
    }

});

(function($){

    $.fn.extend({
        removeItemGallery: function() {
            jQuery(this).parent().fadeOut(200, function() {
                jQuery(this).remove();
                jQuery(this).parent().renderGallery();
                jQuery('#company_gallery_frame ul.gallery_images').renderGallery();
            });

        },
        renderGallery: function() {
            var ulCont = this;
            var theInput = jQuery('input#metrodir_company_gallery');
            var theArr = {};
            ulCont.children('li').each(function(i, obj) {
                theArr[i] = jQuery(this).find('input[name="image_id"]').val();
            });
            var theValue = JSON.stringify(theArr);
            theInput.val(theValue);
            jQuery('#company_gallery_frame ul.gallery_images').sortable({
                items: '> li',
                stop: function(event, ui) {
                    jQuery('#company_gallery_frame ul.gallery_images').renderGallery();
                }
            });
        },
        add_atth_to_gall: function() {
            var attachment = this;
            var attachment_id = attachment.find('img').attr('title');
            var attachment_image = attachment.find('img').attr('src');
            jQuery('#company_gallery_frame > ul').append('<li><input type="hidden" name="image_id" value="'+attachment_id+'"><img src="'+attachment_image+'" alt="" /><span class="remove" onclick="jQuery(this).removeItemGallery();"><i class="fa fa-times-circle fa-2x"></i></span></li>');
            jQuery('#company_gallery_frame ul.gallery_images').renderGallery();
        },
        insertUOUCustomField: function() {

            var buttonCont = this;
            var mainCont = this.parent();
            var ulCont = jQuery('#uou_custom_fields_wrapper ul');
            mainCont.find('.updated').remove();
            // values
            var label = mainCont.find('input.value_label');
            var value = mainCont.find('input.value_value');

            if(label.val() != '') {

                var markup = '<li><div class="head">'+
                    '<span class="title" onclick="jQuery(this).openInsider();"><i class="fa fa-chevron-down"></i>'+label.val()+'</span>'+
                    '</div><div class="insider" style="display: none;">'+
                    '<div class="one-half"><label>Label</label>'+
                    '<input type="text" class="widefat value_label" value="'+label.val()+'" onblur="jQuery(this).valueChangeLabel2(); jQuery(\'#uou_custom_fields_wrapper ul\').CustomFieldRefresh();" />'+
                    '<em style="margin: 10px 0 0; display: block;">Label of your Custom Field</em></div>'+
                    '<div class="one-half last"><label>Value</label>'+
                    '<input type="text" class="widefat value_value" value="'+escape(value.val())+'" />'+
                    '<em style="margin: 10px 0 0; display: block;">Your value. This is displayed in the fron end. HTML accepted</em></div>'+
                    '<div class="clear"></div><div class="bDivider"></div><input type="button" class="button" value="Remove Value" onclick="jQuery(this).removeCustomField();" /><div class="clear"></div></div></li>';

                ulCont.append(markup);

                ulCont.find('li:last input').each(function() { jQuery(this).val(unescape(jQuery(this).val())); });

                jQuery('#uou_custom_fields_wrapper ul').sortable({
                    handle: jQuery('#uou_custom_fields_wrapper li .head'),
                    items: '> li',
                    stop: function(event, ui) {
                        jQuery('#uou_custom_fields_wrapper ul').CustomFieldRefresh();
                    }
                });

                jQuery('#uou_custom_fields_wrapper ul').CustomFieldRefresh();
                mainCont.find('input.value_label').val('').focus();
                mainCont.find('input.value_value').val('');

            } else {
                jQuery("#add_custom_field_form").before('<div class="error">Please insert a label</siv>');
            }

        },

        CustomFieldRefresh: function() {
            var ulCont = this;
            var theInput = jQuery('#uou_custom_fields');
            var theArr = {};
            ulCont.children('li').each(function(i, obj) {
                theArr[i] = {};
                var label = jQuery(this).find('input.value_label').val();
                theArr[i]['label'] = label;
                var value = jQuery(this).find('input.value_value').val();
                theArr[i]['value'] = value;
            });

            var theValue = JSON.stringify(theArr);
            theInput.val(theValue);

        },

        removeCustomField: function() {
            var thisCont = this;
            thisCont.parent().parent().slideUp(200, function() {
                jQuery(this).remove();
                jQuery('#uou_custom_fields_wrapper ul').CustomFieldRefresh();
            });

        },
        openInsider: function() {

            var mainCont = this.parent('div').parent('li');
            var insider = mainCont.find('.insider');
            insider.slideToggle(500);
            if (mainCont.find('.title').find('i').hasClass('fa-chevron-down')) {
                mainCont.find('.title').find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            } else {
                mainCont.find('.title').find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            }


        },
        valueChangeLabel2: function() {

            var label = this.val();
            var header = this.parent().parent().siblings('.head').children('.title');

            header.text(label);

        }
    });

})(jQuery);

// Media select button
var mediaUpload = '';

var $mediaSelect = jQuery('input[type="button"].media-select');

if($mediaSelect.length){

    var formfield=null;
    $mediaSelect.click(function(){
        var buttonID = jQuery(this).attr("id").toString();
        var inputID = buttonID.replace("_selectMedia", "");
        mediaUpload = inputID;
        formfield = inputID;
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        jQuery('#TB_overlay,#TB_closeWindowButton').bind("click",function(){formfield=null;});
        return false;
    });

    formfield=null;
    window.original_send_to_editor = window.send_to_editor;
    window.send_to_editor = function(html) {
        if (formfield) {
            var imgUrl = jQuery('img', html).attr('src');
            jQuery('#'+mediaUpload).val(imgUrl);
            tb_remove();
        } else {
            window.original_send_to_editor(html);
        }
        formfield=null;
    };
}

function loadicon() {
    jQuery("#icon-shower").attr('class', 'fa ' + jQuery("#metrodir_category_icon").val() + ' fa-lg');
}

function loadmenuicon($class) {
    jQuery($class).parent('label').find("i").attr('class', 'fa ' + jQuery($class).val() + ' fa-lg');
}

function updateItems(ids, field_id){
    var current_items = getCurrentItems(field_id);

    var to_remove = jQuery.grep(current_items, function(n, i){
        return jQuery.inArray(n, ids) == -1;
    });

    jQuery('#'+field_id+' ul.items').children('li').each(function() {
        var id = parseInt(jQuery(this).attr('data-value'));
        if(to_remove.indexOf(id) != -1){
            jQuery(this).remove();
        }
    });
}
function addItemToList(data_object, field_id){
    var leave = false;
    jQuery('#'+field_id+' ul.items').children('li').each(function() {
        var id = parseInt(jQuery(this).attr('data-value'));
        if(parseInt(data_object.id) == id){
            leave = true;
            return false;
        }
    });
    if(leave) return;

    jQuery('#'+field_id+' > ul.items').append('<li clas="item" data-value="'+data_object.id+'"><div><img src="'+data_object.thumb+'" alt="" /></div><span class="item_title">'+data_object.title+'</span><span class="remove" onclick="removeItem(this, '+field_id+');"><i class="fa fa-times-circle fa-2x"></i></span></li>');
    renderItems();
}
function getCurrentItems(field_id){
    var theArr = [];
    jQuery('#'+field_id+' ul.items').children('li').each(function() {
        theArr.push(parseInt(jQuery(this).attr('data-value')));
    });
    return theArr;
}
function selectPostTypeItems(postID, field_id, post_type, search_uri)
{
    tb_show('Select '+post_type, search_uri);
    return false;
}
function renderItems(){
    jQuery('.data_frame').each(function(){
        var field_id = jQuery(this).attr('id');
        console.info(field_id);
        var theInput = jQuery('input[name="'+field_id+'"]');
        var theArr = {};
        jQuery('#'+field_id+' ul.items').children('li').each(function(i, obj) {
            console.info(i);
            theArr[i] = parseInt(jQuery(this).attr('data-value'));
        });
        var theValue = JSON.stringify(theArr);
        theInput.val(theValue);
        console.info(theValue);
        init_sortable(field_id);
    });
}
function init_sortable(field_id){
    jQuery('#'+field_id+' ul.items').sortable({
        items: '> li',
        stop: function(event, ui) {
            renderItems();
        }
    });
}
function removeItem(item, field_id){
    jQuery(item).parent().fadeOut(200, function() {
        jQuery(this).remove();
        renderItems();
    });
}
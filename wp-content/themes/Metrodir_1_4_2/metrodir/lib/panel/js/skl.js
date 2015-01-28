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
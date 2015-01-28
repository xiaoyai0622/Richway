<?php
    include_once('../../../../../../../../wp-load.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <title>Insert Columns</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/jquery/jquery.js"></script>

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/skl/plugin/uou-shortcodes/css/shortcodes_admin.css" media="screen" />

    <script type="text/javascript">

        // Register Function For Insert Code
        function insertShortcode() {

            // Open Tag
            var short = '[column';

            // Check Column
            if(jQuery('#tabs > li.current').text() == '1/1') {
               short += ' type="one"'
            } else if (jQuery('#tabs > li.current').text() == '1/2') {
                short += ' type="half"'
            } else if (jQuery('#tabs > li.current').text() == '1/3') {
                short += ' type="one-third"'
            } else if (jQuery('#tabs > li.current').text() == '2/3') {
                short += ' type="two-third"'
            }

            // Close Tag
            short += ']<br/>TEXT<br/>[/column]';

            // Insert To Editor
            if(window.tinyMCE) {

                tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, short );
                tinyMCEPopup.editor.execCommand('mceRepaint');
                tinyMCEPopup.close();

            }
            return;
        }

        jQuery(document).ready(function() {

            selectedContent = tinyMCE.activeEditor.selection.getContent();

            // Close Modal Window
            jQuery('#mceModalBlocker').click(function() { tinyMCEPopup.close(); });

            // Create Tabs For Modal
            if(jQuery('#tabs').length > 0) {

                var tabsCont = jQuery('#tabs');
                var tabbedCont = jQuery('#tabbed');
                tabsCont.children('li:first').addClass('current');
                tabbedCont.children('li:first').addClass('current').show();

                tabsCont.children('li').click(function() {

                    if(jQuery(this).attr('class') != 'current') {

                        var itemClicked = jQuery(this).index();
                        tabsCont.children('li.current').removeClass('current');
                        jQuery(this).addClass('current');

                        tabbedCont.children('li.current').removeClass('current').hide();
                        tabbedCont.children('li:eq('+itemClicked+')').addClass('current').show();

                    }
                });

            }

        });

    </script>
</head>

<body>

<ul id="tabs">
    <li>1/1</li>
    <li>1/2</li>
    <li>1/3</li>
    <li>2/3</li>
</ul>

<ul id="tabbed">

    <li>
        <div style="width: 100%; padding: 10px 0;">
            <p>Insert 1/1 Column</p>
        </div>
    </li>

    <li>
        <div style="width: 100%; padding: 10px 0;">
            <p>Insert 1/2 Column</p>
        </div>
    </li>

    <li>
        <div style="width: 100%; padding: 10px 0;">
            <p>Insert 1/3 Column</p>
        </div>
    </li>

    <li>
        <div style="width: 100%; padding: 10px 0;">
            <p>Insert 2/3 Column</p>
        </div>
    </li>

</ul>

<div class="separator-modal"></div>

<div class="fieldset">

    <input type="button" value="Close" class="button white" style="float: left;" onclick="tinyMCEPopup.close();" />
    <input type="button" value="Insert" class="button blue" style="float: right;" onclick="insertShortcode();" />

</div>

</body>
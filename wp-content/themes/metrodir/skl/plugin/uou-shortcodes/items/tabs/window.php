<?php
    include_once('../../../../../../../../wp-load.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <title>Insert tabs... auto insert</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/jquery/jquery.js"></script>

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/skl/plugin/uou-shortcodes/css/shortcodes_admin.css" media="screen" />

    <script type="text/javascript">

        jQuery(document).ready(function() {

            // Open Tag
            var short = '[tabs';

            // Close Tag
            short += ']<br/>[tab title="title1"]TEXT[/tab]<br/>[tab title="title2"]TEXT[/tab]<br/>[tab title="title3"]TEXT[/tab]<br/>[/tabs]';

            // Insert To Editor
            if(window.tinyMCE) {

                tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, short );
                tinyMCEPopup.editor.execCommand('mceRepaint');
                tinyMCEPopup.close();

            }
            return;
        });

    </script>
</head>

<body>

        <div style="width: 100%; padding: 10px 0;">
            <p>
             <img src="<?php echo get_template_directory_uri() ?>/images/loader.gif" height="50" width="50"/>
            </p>
        </div>


<div class="fieldset">

    <input type="button" value="Close" class="button white" style="float: left;" onclick="tinyMCEPopup.close();" />
    <input type="button" value="Insert" class="button blue" style="float: right;" onclick="insertShortcode();" />

</div>

</body>
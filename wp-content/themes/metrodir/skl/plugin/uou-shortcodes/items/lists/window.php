<?php
	include_once('../../../../../../../../wp-load.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Insert Lists</title>
    
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/jquery/jquery.js"></script>
    
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/skl/plugin/uou-shortcodes/css/shortcodes_admin.css" media="screen" />
    
    <script type="text/javascript">

        // Register Function For Insert Code
		function insertShortcode() {

            // Default Var
            var f_text = jQuery('#title-list');
            var f_type = jQuery('#type');

            // Open Tag
            var short = '[list';

            if(f_text.val() != '') { short += ' title="'+f_text.val()+'"'; }

            short += ' type="'+f_type.children('option:selected').val()+'"';

            // Dummy Text
            short += ']<li>Lorem ipsum dolor sit amet</li><li>Consectetur adipisicing elit</li>[/list]';

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

			var textTitle = jQuery('#title-list');
            textTitle.val(selectedContent);

		});
	
	</script>
</head>

<body>
    <div style="float: left; width: 100%; padding: 10px 0;">

        <div class="column-left">

            <div class="fieldset">
                <label for="title-list">Title For List</label>
                <input id="title-list" name="title-list"/>
            </div>

        </div>

        <div class="column-right">

            <div class="fieldset">

                <label for="type">Type</label>
                <select id="type">
                    <option value="bullets">Bullet List</option>
                    <option value="check">Check List</option>
                </select>

            </div>

        </div>

    </div>

    <div class="separator-modal"></div>
        
    <div class="fieldset">
    
        <input type="button" value="Close" class="button white" style="float: left;" onclick="tinyMCEPopup.close();" />
        <input type="button" value="Insert" class="button blue" style="float: right;" onclick="insertShortcode();" />
        
    </div>

</body>
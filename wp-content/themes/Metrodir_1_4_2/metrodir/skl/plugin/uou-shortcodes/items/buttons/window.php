<?php
	include_once('../../../../../../../../wp-load.php');
    $metrodir_first_color = get_option('opt_metrodir_color_first');
    $metrodir_color_second = get_option('opt_metrodir_color_second');
    $metrodir_color_bg = get_option('opt_metrodir_color_bg');
    $metrodir_color_font = get_option('opt_metrodir_color_font');
    $metrodir_color_font_back = get_option('opt_metrodir_color_font_back');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Insert Button</title>
    
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
			var f_text = jQuery('#text');
			var f_link = jQuery('#link');
			var f_color = jQuery('#color');
			var f_type = jQuery('#type');
			var f_target = jQuery('#target');

			// Open Tag
			var short = '[button';

			if(f_link.val() != '') { short += ' link="'+f_link.val()+'"'; }
			else { short += ' link="#"'; }

			if(f_color.val() != 'default') {short += ' color="'+f_color.children('option:selected').val()+'"'; }

			if(f_type.val() == 'big-button') { short += ' type="'+f_type.children('option:selected').val()+'"'; }

			if(f_target.children('option:selected').val() != 'normal') { short += ' target="_blank"'; }
			
			// Close Tag
			short += ']'+f_text.val()+'[/button]';
			
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
			
			// Default Var
			var text = jQuery('#text');

			text.val(selectedContent);
			
		});
	</script>
</head>

<body>
    <div style="float: left; width: 100%; padding: 10px 0;">

        <div class="column-left">
        
            <div class="fieldset">
                <label for="text">Button Text</label>
                <input id="text" value="" type="text" />
            </div>
            
            <div class="separator-modal"></div>
        
            <div class="fieldset">
                <label for="link">Link</label>
                <input id="link" value="" type="text" />
            </div>
            
            <div class="separator-modal"></div>
        
            <div class="fieldset">
                <label for="color">Color</label>
                <select id="color">
                    <option value="default">Like First color accent (<?php echo $metrodir_first_color;?>)</option>
                    <option value="second">Like Second color accent (<?php echo $metrodir_color_second;?>)</option>
                    <option value="background">Like Background color accent (<?php echo $metrodir_color_bg;?>)</option>
                    <option value="grey">Like Theme Grey color accent (<?php echo $metrodir_color_font_back;?>)</option>
                    <option value="hover">Like Theme Hover color accent (<?php echo $metrodir_color_font;?>)</option>
                </select>
            </div>
            
        </div>

    	<div class="column-right">
        
            <div class="fieldset">
            
                <label for="target">Target</label>
                <select id="target">
                    <option value="normal">None</option>
                    <option value="_blank">_blank (Opens in new window)</option>
                </select>
                <em class="desc">Your button target.</em>
            
            </div>
            
        </div>
        
    </div>
            
    <div class="separator-modal"></div>

    <div class="fieldset">
    
        <input type="button" value="Close" class="button white" style="float: left;" onclick="tinyMCEPopup.close();" />
        <input type="button" value="Insert" class="button blue" style="float: right;" onclick="insertShortcode();" />
        
    </div>

</body>
<?php

/*-----------------------------------------------------------------------------------*/
/* Add default options after activation */
/*-----------------------------------------------------------------------------------*/
//@since 2.0 Mod by denzel, replace the previous functions that does not work..
function propanel_default_settings_install(){

if(is_admin()):
 
	global $pagenow;
	
	// check if we are on theme activation page and activated is true.
	if(@$pagenow == 'themes.php' && @$_GET['activated'] == true):

	//if we are on theme activation page, do the following..
	
		$template = get_option('of_template');

			foreach($template as $t):
				@$option_name = $t['id'];
				@$default_value = $t['std'];
				$value_check = get_option("$option_name");
				if($value_check == ''){
				  update_option("$option_name","$default_value");
				}	
		
			endforeach;
	endif; //end if $pagenow
  
endif; //end if is_admin check

}
add_action('init','propanel_default_settings_install',90);

/*-----------------------------------------------------------------------------------*/
/* Admin Backend */
/*-----------------------------------------------------------------------------------*/
function propanel_siteoptions_admin_head() { ?>

<script type="text/javascript">
jQuery(function(){
var message = '<p><strong>Activation Successful!</strong> This theme\'s settings are located under <a href="<?php echo admin_url('admin.php?page=siteoptions'); ?>">Appearance > Site Options</a>.</p>';
jQuery('.themes-php #message2').html(message);
});
</script>
    
    
    <?php }

add_action('admin_head', 'propanel_siteoptions_admin_head');






/* new */
function generateCSS() {
    $colorbody = get_option('opt_metrodir_color_bg');
    if (!$colorbody)$colorbody = "#FFFFFF";
    $background = get_option('opt_metrodir_site_background');
    if (!$background OR ((get_option('opt_metrodir_boxed_version') == "no") AND ((get_option('opt_metrodir_site_no_boxed_bg') == "false")))) $background = "none"; else $background = 'url('.$background.')';
    $horizontal = get_option('opt_metrodir_site_background_horizontal');
    if (!$horizontal) $horizontal = "center";
    $vertical = get_option('opt_metrodir_site_background_vertical');
    if (!$vertical) $vertical = "top";
    $repeat = get_option('opt_metrodir_site_background_repeat');
    if (!$repeat) $repeat = "repeat";
    $attachment = get_option('opt_metrodir_site_background_fixed');
    if ($attachment == "true") $attachment = "fixed"; else $attachment = "scroll";
    $colorfirst = get_option('opt_metrodir_color_first');
    if (!$colorfirst) $colorfirst = "#FFFFFF";
    $colorsecond = get_option('opt_metrodir_color_second');
    if (!$colorsecond) $colorsecond = "#FFFFFF";
    $fontcolor = get_option('opt_metrodir_color_font');
    if (!$fontcolor) $fontcolor = "#40555c";
    $fontcolor_minor = get_option('opt_metrodir_color_font_minor');
    if (!$fontcolor_minor) $fontcolor_minor = "#7e949b";
    $fontcolor_back = get_option('opt_metrodir_color_font_back');
    if (!$fontcolor_back) $fontcolor_back = "#f5f5f5";
    $color_border = get_option('opt_metrodir_color_border');
    if (!$color_border) $color_border = "#dedede";
    $color_border_light = get_option('opt_metrodir_color_border_light');
    if (!$color_border_light) $color_border_light = "#eaeaea";


    $file_input =  get_template_directory()."/css/less.css";
    $file_output = get_template_directory()."/css/color.css";
    require (get_template_directory()."/lib/class/lessc.inc.php");

    $content = file_get_contents($file_input);

    $less = new lessc;
    $variables = array(
        'colorfirst' => $colorfirst,
        'colorsecond' => $colorsecond,
        'colorbody' => $colorbody,
        'background' => $background,
        'horizontal' => $horizontal,
        'vertical' => $vertical,
        'repeat' => $repeat,
        'attachment' => $attachment,
        'fontcolor' => $fontcolor,
        'fontcolorminor' => $fontcolor_minor,
        'fontcolorback' => $fontcolor_back,
        'colorborder' => $color_border,
        'colorborderlight' => $color_border_light
    );

    $css = $less->parse($content, $variables);

    @chmod($file_output, 0777);
    $editcss =  @file_put_contents($file_output, $css);
    @chmod($file_output, 0755);

    $file_output = get_template_directory()."/css/color-first.css";

    @chmod($file_output, 0777);
    $editcss2 =  @file_put_contents($file_output, $css);
    @chmod($file_output, 0755);

    $file_output = get_template_directory()."/css/color-second.css";

    $variables = array(
        'colorfirst' => "#32beeb",
        'colorsecond' => "#1a1a1a",
        'colorbody' => $colorbody,
        'background' => $background,
        'horizontal' => $horizontal,
        'vertical' => $vertical,
        'repeat' => $repeat,
        'attachment' => $attachment,
        'fontcolor' => $fontcolor,
        'fontcolorminor' => $fontcolor_minor,
        'fontcolorback' => $fontcolor_back,
        'colorborder' => $color_border,
        'colorborderlight' => $color_border_light
    );

    $css = $less->parse($content, $variables);

    @chmod($file_output, 0777);
    $editcss3 =  @file_put_contents($file_output, $css);
    @chmod($file_output, 0755);

    $file_output = get_template_directory()."/css/color-third.css";

    $variables = array(
        'colorfirst' => "#e14d43",
        'colorsecond' => "#363b3f",
        'colorbody' => $colorbody,
        'background' => $background,
        'horizontal' => $horizontal,
        'vertical' => $vertical,
        'repeat' => $repeat,
        'attachment' => $attachment,
        'fontcolor' => $fontcolor,
        'fontcolorminor' => $fontcolor_minor,
        'fontcolorback' => $fontcolor_back,
        'colorborder' => $color_border,
        'colorborderlight' => $color_border_light
    );

    $css = $less->parse($content, $variables);

    @chmod($file_output, 0777);
    $editcss4 =  @file_put_contents($file_output, $css);
    @chmod($file_output, 0755);

    $file_output = get_template_directory()."/css/color-fourth.css";

    $variables = array(
        'colorfirst' => "#a3b745",
        'colorsecond' => "#523f6d",
        'colorbody' => $colorbody,
        'background' => $background,
        'horizontal' => $horizontal,
        'vertical' => $vertical,
        'repeat' => $repeat,
        'attachment' => $attachment,
        'fontcolor' => $fontcolor,
        'fontcolorminor' => $fontcolor_minor,
        'fontcolorback' => $fontcolor_back,
        'colorborder' => $color_border,
        'colorborderlight' => $color_border_light
    );

    $css = $less->parse($content, $variables);

    @chmod($file_output, 0777);
    $editcss5 =  @file_put_contents($file_output, $css);
    @chmod($file_output, 0755);

    if($editcss === false AND $editcss2 === false AND $editcss3 === false AND $editcss4 === false AND $editcss5 === false)
        return false;
    else
        return true;

}

function get_admin_post() {
    $post_id = absint( isset($_GET['post']) ? $_GET['post'] : ( isset($_POST['post_ID']) ? $_POST['post_ID'] : 0 ) );
    $post = $post_id != 0 ? get_post( $post_id ) : false; // Post Object, like in the Theme loop
    return $post;
}

function build_metaboxes() {
    global $metaBoxes;

    $post = get_admin_post();

    if(!$post) {
        if(isset($_GET["post_type"])){
            $post = new stdClass();
            $post->post_type = $_GET["post_type"];
        }
    }
    if(isset($post->post_type) && isset($metaBoxes[$post->post_type]) && !empty($metaBoxes[$post->post_type])){
         $box = new Meta_Box($metaBoxes[$post->post_type]);
    }

}
add_action("admin_menu", "build_metaboxes");







<?php
	
	//Load fcvSettings Class
	$flx_settings 	= fcvSettings::get_Instance();
	$settings = $flx_settings->get();
	
	//Send Mail Action
    if(isset($_POST['action']))
    {
        if(trim($_POST['action']) == 'send_mail_metrodir')
        {
            $flx_settings->sendmail();
        }

        if(trim($_POST['action']) == 'send_single_mail_metrodir')
        {
            $flx_settings->sendsinglemail();
        }
    }

	//Style and JS for metrodir Panel
	function metrodir_panel_head() {
		echo '<link rel="stylesheet" type="text/css" href="'.metrodir_PANEL_CSS .'/style.css" />'."\n";
	}
	
	//Style and JS for Wordpress Admin
	function metrodir_wpadmin_head() {
		echo '<link rel="stylesheet" type="text/css" href="' . metrodir_PANEL_CSS . '/admin.css" />'."\n";
        echo '<link rel="stylesheet" type="text/css" href="' . metrodir_CSSDIR . '/font-awesome.css" />'."\n";
        echo '<link rel="stylesheet" type="text/css" href="' . metrodir_ADMIN . '/colorpicker.css" />'."\n";
        echo '<script type="text/javascript" src="' . metrodir_ADMINJS . '/colorpicker.js"></script>'."\n";
        echo '<script type="text/javascript" src="'. metrodir_PANEL_JS. '/admin.js"></script>'. "\n";
        echo '<script type="text/javascript" src="'. metrodir_JS. '/jquery.easytabs.min.js"></script>'. "\n";
        echo '<script type="text/javascript" src="'. metrodir_PANEL_JS. '/ajaxupload_b.js"></script>'. "\n";
        echo '<div id="get_homeurl" data-homeurl="'.get_template_directory_uri().'"></div>';
	}




//Save image via AJAX
add_action('wp_ajax_portfolio_ajax_upload', 'portfolio_ajax_upload'); //Add support for AJAX save

function portfolio_ajax_upload(){

    sleep(1);

    global $wpdb; //Now WP database can be accessed
    global $post;

    $image_id = $_POST['data'];

    $image_filename = $_FILES[$image_id];

    $override['test_form'] = false; //see http://wordpress.org/support/topic/269518?replies=6
    $override['action'] = 'wp_handle_upload';

    $uploaded_image = wp_handle_upload($image_filename,$override);

    //// IF ISET POST ID WE ATTACH THIS IMAGE TO THE POST
    if(isset($_POST['post_id'])) {

        $post_id = $_POST['post_id'];

    } else { $post_id = ''; }

    /// INSERTS IN DABASE
    $attachment = array(
        'post_mime_type' => $uploaded_image['type'],
        'guid' => $uploaded_image['url'],
        'post_title' => preg_replace('/\.[^.]+$/', '', basename($image_filename['name'])),
        'post_content' => '',
        'post_parent' => $post_id,
        'post_status' => 'inherit'
    );

    $id = wp_insert_attachment($attachment, $uploaded_image['file'], $post_id);

    require_once(ABSPATH . 'wp-admin/includes/image.php');


    if(!empty($uploaded_image['error'])){

        echo 'Error: ' . $uploaded_image['error'];

    } else {

        if(isset($_POST['post_id'])) {

            /// RETURNS AN ARRAY INSTEAD
            echo json_encode(array(

                'url' => $uploaded_image['url'],
                'id' => $id,
                'thumb' => vt_resizer($uploaded_image['url'], 150, 150)

            ));

        } else {

            //update_option($image_id, $uploaded_image['url']);

            echo $uploaded_image['url'];

        }
        $attachment_data = wp_generate_attachment_metadata( $id, $uploaded_image['file'] );
        wp_update_attachment_metadata( $id, $attachment_data );
    }

    die();

}
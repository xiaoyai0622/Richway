<?php

// Add New Post Type For content
function metrodir_content_posttype() {
    global $shortname;
    register_post_type( 'content',
        array(
            'labels' => array(
                'name' => __( 'Team', 'metrodir'),
                'singular_name' => __( 'Team Item', 'metrodir'),
                'add_new' => __( 'Add New Item', 'metrodir'),
                'add_new_item' => __( 'Add New content Item', 'metrodir'),
                'edit_item' => __( 'Edit content Item', 'metrodir'),
                'new_item' => __( 'Add New content Item', 'metrodir'),
                'view_item' => __( 'View Item', 'metrodir'),
                'search_items' => __( 'Search content',  'metrodir'),
                'not_found' => __( 'No content items found',  'metrodir'),
                'not_found_in_trash' => __( 'No content items found in trash', 'metrodir')
            ),
            'public' => true,
            'supports' => array( 'title', 'thumbnail'),
            'capability_type' => 'post',
            'rewrite' => array("slug" => "content"),
            'menu_position' => 4
        )
    );
}

add_action('init', 'metrodir_content_posttype');

// Set as many image sizes as you want
add_filter("manage_edit-content_columns", "content_edit_columns");
add_action("manage_posts_custom_column",  "content_columns_display", 10, 2);


function content_edit_columns($content_columns){
    global $shortname;
    $content_columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "thumbnail" => __('Thumbnail', 'metrodir'),
        "title" => _x('Title', 'column name', 'metrodir'),
        "name" => __('Name', 'metrodir'),
        "position" => __('Position', 'metrodir'),
        "author" => __('Author', 'metrodir'),
        "date" => __('Date', 'metrodir'),
    );
    return $content_columns;
}

function content_columns_display($content_columns, $post_id){
    global $shortname;

    switch ($content_columns) {

        case "thumbnail":
            $width = (int) 80;
            $height = (int) 80;
            $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
            // image from gallery
            $attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
            if ($thumbnail_id)
                $thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
            elseif ($attachments) {
                foreach ( $attachments as $attachment_id => $attachment ) {
                    $thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
                }
            }
            if ( isset($thumb) && $thumb ) {
                echo $thumb;
            } else {
                echo __('Unavailable', 'metrodir');
            }
            break;

        case "name":
            $name = get_post_meta( $post_id, $shortname.'_content_name', true );
            if ($name) {
                echo $name;
            } else {
                echo __('Unavailable', 'metrodir');
            }
            break;

        case "position":
            $position = get_post_meta( $post_id, $shortname.'_content_position', true );
            if ($position) {
                echo $position;
            } else {
                echo __('Unavailable', 'metrodir');
            }
            break;

    }
}

// content item options
$prefix = $shortname . "_";
$metaBoxes = array();

$metaBoxes[] = array(
    'id' => 'content-options',
    'title' => __('Options', 'metrodir'),
    'pages' => array('content'),
    'context' => 'normal',
    'priority' => 'low',
    'fields' => array(
        array(
            'name' => __('Name', 'metrodir'),
            'id' => $prefix . 'content_name',
            'type' => 'text',
            'desc' => __('Person Name.', 'metrodir')
        ),
        array(
            'name' => __('Position', 'metrodir'),
            'id' => $prefix . 'content_position',
            'type' => 'text',
            'desc' => __('Person Position.', 'metrodir')
        ),

        array(
            'name' => __('Social Facebook Link', 'metrodir'),
            'id' => $prefix . 'content_soc_fb',
            'type' => 'text',
            'desc' => '',
        ),
        array(
            'name' => __('Social Google+ Link', 'metrodir'),
            'id' => $prefix . 'content_soc_gp',
            'type' => 'text',
            'desc' => '',
        ),
        array(
            'name' => __('Social Twitter Link', 'metrodir'),
            'id' => $prefix . 'content_soc_tw',
            'type' => 'text',
            'desc' => '',
        ),
        array(
            'name' => __('Social Linkedin Link', 'metrodir'),
            'id' => $prefix . 'content_soc_li',
            'type' => 'text',
            'desc' => '',
        ),
        array(
            'name' => __('Social Pinterest Link', 'metrodir'),
            'id' => $prefix . 'content_soc_pt',
            'type' => 'text',
            'desc' => '',
        ),
        array(
            'name' => __('Social Dribbble Link', 'metrodir'),
            'id' => $prefix . 'content_soc_dr',
            'type' => 'text',
            'desc' => '',
        ),

    )
);


$metaBoxes['content'] = array(
	  'id' => 'content-options',
	  'title' => __('Options', 'metrodir'),
	  'pages' => array('content'),
	  'context' => 'normal',
	  'priority' => 'low',
	  'fields_group' => array(
          array(
              'id' => 'options',
              'title' => 'Info',
              'marker' => 'fa-file',
              'fields' => array(
                  array(
                      'name' => __('Name', 'metrodir'),
                      'id' => $prefix . 'content_name',
                      'type' => 'text',
                      'desc' => __('Person Name.', 'metrodir')
                  ),
                  array(
                      'name' => __('Position', 'metrodir'),
                      'id' => $prefix . 'content_position',
                      'type' => 'text',
                      'desc' => __('Person Position.', 'metrodir')
                  ),

                  array(
                      'name' => __('Social Facebook Link', 'metrodir'),
                      'id' => $prefix . 'content_soc_fb',
                      'type' => 'text',
                      'desc' => '',
                  ),
                  array(
                      'name' => __('Social Google+ Link', 'metrodir'),
                      'id' => $prefix . 'content_soc_gp',
                      'type' => 'text',
                      'desc' => '',
                  ),
                  array(
                      'name' => __('Social Twitter Link', 'metrodir'),
                      'id' => $prefix . 'content_soc_tw',
                      'type' => 'text',
                      'desc' => '',
                  ),
                  array(
                      'name' => __('Social Linkedin Link', 'metrodir'),
                      'id' => $prefix . 'content_soc_li',
                      'type' => 'text',
                      'desc' => '',
                  ),
                  array(
                      'name' => __('Social Pinterest Link', 'metrodir'),
                      'id' => $prefix . 'content_soc_pt',
                      'type' => 'text',
                      'desc' => '',
                  ),
                  array(
                      'name' => __('Social Dribbble Link', 'metrodir'),
                      'id' => $prefix . 'content_soc_dr',
                      'type' => 'text',
                      'desc' => '',
                  )
              )
          )
      )
	);

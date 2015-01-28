<?php
class Meta_Box {

    private $meta_Box;
    private $shortname;

    function Meta_Box($meta_Box){
        global $shortname;

        if (!is_admin()) return;

        $this->meta_Box = $meta_Box;
        $this->shortname = $shortname;

        $currentPage = substr(strrchr($_SERVER['PHP_SELF'], '/'), 1, -4);
        if ($currentPage == 'page' || $currentPage == 'page-new' || $currentPage == 'post' || $currentPage == 'post-new') {
            add_action('admin_head', array(&$this, 'add_post_enctype'));
        }

        add_action('add_meta_boxes', array(&$this, 'add'));

        add_action('save_post', array(&$this, 'save'));
    }

    function add_post_enctype() {
        echo '
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#post").attr("enctype", "multipart/form-data");
			jQuery("#post").attr("encoding", "multipart/form-data");
		});
		</script>';
    }

    function add() {
        foreach ($this->meta_Box['pages'] as $page) {
            add_meta_box($this->meta_Box['id'], $this->meta_Box['title'], array(&$this, 'show'), $page, $this->meta_Box['context'], $this->meta_Box['priority']);
        }
    }

    function show() {
        global $post;

        $post_id = $post->ID;

        // Use nonce for verification
        echo '<input type="hidden" name="flexicv_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';


        // Company tabs b-e
        echo '<div id="admin-tabs">';
        echo '<ul class="tabs">';

        foreach ($this->meta_Box['fields_group'] as $fields) {
            echo '<li class="bpanel-tab" style="padding-left: 5px;"><a href="#'.$fields['id'].'"><i class="fa '.$fields['marker'].' fa-lg"></i>'.$fields['title'].'</a></li>';
        }
        echo '</ul>';

        foreach ($this->meta_Box['fields_group'] as $fields) {
            echo '<div id="'.$fields['id'].'"><table class="form-table">';
            foreach ($fields['fields'] as $field) {

                echo '<tr>',
                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';

                $this->switch_metabox($field, $post_id);

                echo '<td>',
                '</tr>';
            }

            echo '</table></div>';

        }

        echo '</div>';

    }
    /**
     *    Switch template
     */
    private function switch_metabox(&$field, $post_id)
    {
        $meta = get_post_meta($post_id, $field['id'], true);
        switch ($field['type']) {

            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : (isset($field['std']) ? $field['std'] : ''), '" size="30" style="width:97%" />',
                '<br />', $field['desc'];
                break;

            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>',
                '<br />', $field['desc'];
                break;

            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;

            case 'radio':
                foreach ($field['options'] as $option) {
                    echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                }
                break;

            case 'button-gps':
                echo '<input id="metrodir_convert_gps" type="button" value="Convert address to GPS coordinates" onclick="initialize(); " style="float:left;"/><label id="metrodir_convert_gps_log" style="float:left; margin-left: 20px;">Put the Button</label>';
                echo '<div id="map_canvas" style="clear:both; width:800px; height:400px"></div>';
                break;

            case 'radio_icons':
                ?>
                <div style="margin: 0;padding: 10px 3px 10px 3px; background: #ccc;">
                    <?php
                    $i = 3;
                    foreach ($field['options'] as $option) {
                        echo '<span style="float: left; display: inline-block;margin: 0px 2% 5px 0px;width: 30%;vertical-align: top;text-align:left;"><span style="margin-right: 4px; vertical-align:top;padding-top: 5px;display: inline-block;"><input type="radio" name="', $field['id'], '" value="', $option, '"', $meta == $option ? ' checked="checked"' : '', '>', '', '</span>', '<img src="' . get_template_directory_uri() . '/icons/' . $option, '" alt=""><span style="margin-left: 4px; vertical-align:top;padding-top: 5px;display: inline-block;">', get_icons_name($option), '</span></span>';
                        $i++;
                        if (($i % 3) == 0)
                            echo '<div style="clear:both"></div>';
                    }
                    ?>
                    <div style="clear:both"></div>
                </div>
                <?php
                break;

            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;

            case 'file':
                echo $meta ? "$meta<br />" : '', '<input type="file" name="', $field['id'], '" id="', $field['id'], '" />',
                '<br />', $field['desc'];
                break;

            case 'image':
                echo $meta ? "<img src=\"$meta\" width=\"150\" height=\"150\" /><br />$meta<br />" : '', '<input type="file" name="', $field['id'], '" id="', $field['id'], '" />',
                '<br />', $field['desc'];
                break;

            case 'attach_link_img':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : (isset($field['std'])? $field['std']:''), '" size="30" style="width:97%" />',
                ' <input type="button" value="Select Image" class="media-select" id="', $field['id'], '_selectMedia" name="', $field['id'], '_selectMedia" style="width: 15%;">', $field['desc'];
                break;

            case 'portfolio_image':
                $gallery_id = get_post_meta($post_id, $field['id'], true);
                ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('#company_gallery_upload').each(function(){
                var the_button = jQuery(this);
                var image_id = jQuery(this).attr('id');
                new AjaxUpload(image_id, {
                    action: ajaxurl,
                    name: image_id,
                    data: {
                        action: 'portfolio_ajax_upload',
                        data: image_id,
                        post_id: <?php echo $post_id ?>
                    },
                    autoSubmit: true,
                    responseType: false,
                    onChange: function(file, extension){},
                    onSubmit: function(file, extension) {
                        if(extension == 'png' || extension == 'gif' || extension == 'jpg' || extension == 'jpeg') {
                            the_button.attr('disabled', 'disabled').val('Uploading').addClass('button-disabled');
                        } else {
                            alert('<?php _e('Upload only PNG, JPG or GIF files.', 'metrodir'); ?>');
                            return false;
                        }
                    },
                    onComplete: function(file, response) {
                        var theImage = jQuery.parseJSON(response);
                        the_button.removeAttr('disabled').removeClass('button-disabled');
                        if(response.search("Error") > -1){
                            alert("Uploading error :\n"+response);
                        }
                        else{
                            jQuery('#company_gallery_frame > ul').append('<li><input type="hidden" name="image_id" value="'+theImage.id+'"><img src="'+theImage.thumb+'" alt="" /> <span class="remove" onclick="jQuery(this).removeItemGallery();"><i class="fa fa-times-circle fa-2x"></i></span></li>');
                            jQuery('#company_gallery_frame ul.gallery_images').renderGallery();
                            the_button.val('<?php _e('Upload image to gallery', 'metrodir'); ?>');
                        }
                    }
                });
            });
        });
    </script>
    <div class="post-media-gal">
        <em><?php _e('Add from post media:', 'metrodir'); ?></em>
        <?php
        // get post attach media
        $args = array(
            'post_type' => 'attachment',
            'post_mime_type' =>'image',
            'post_status' => 'inherit',
            'posts_per_page' => -1,
            'post_parent' => $post_id,
            'orderby' => 'menu_order',
            'order' => 'ASC',
        );
        $companyqer = new WP_Query($args);
        if($companyqer->have_posts()) :
            ?>
            <ul class="post-media-gal-image">
                <?php
                while($companyqer->have_posts()) : $companyqer->the_post();
                    $image = wp_get_attachment_url(get_the_ID());
                    ?>
                    <li onclick="jQuery(this).add_atth_to_gall();">
                        <img src="<?php echo vt_resizer($image, 150, 150); ?>" alt="<?php the_ID(); ?>" title="<?php the_ID(); ?>" height="50px" width="50px" />
                    </li>
                <?php
                endwhile;
                wp_reset_postdata(); ?>
            </ul>
            <div class="clear"></div>
        <?php else: ?>
            <em><?php _e('No images in post media.', 'metrodir'); ?></em>
        <?php endif; ?>
    </div>

    <div id="company_gallery_frame">
        <input type="hidden" value='<?php echo $gallery_id; ?>' id="<?php echo $field['id']; ?>" name="<?php echo $field['id']; ?>" />
        <input type="button" class="button" value="<?php _e('Upload image to gallery', 'metrodir'); ?>" id="company_gallery_upload" />
        <ul class="gallery_images">
            <?php
            if(is_object(json_decode(htmlspecialchars_decode($gallery_id)))) : ?>
                <script type="text/javascript">
                    jQuery(document).ready(function() {
                        jQuery('#company_gallery_frame ul.gallery_images').sortable({
                            items: '> li',
                            stop: function(event, ui) {
                                jQuery('#company_gallery_frame ul.gallery_images').renderGallery();
                            }
                        });
                    });
                </script>
                <?php
                foreach(json_decode(htmlspecialchars_decode($gallery_id)) as $single_image) :
                    if($this_image = wp_get_attachment_image_src($single_image)) :
                        $image_url = vt_resizer($this_image[0], 150, 150);
                        ?>
                        <li>
                            <input type="hidden" name="image_id" value="<?php echo $single_image; ?>">
                            <img src="<?php echo $image_url ?>" alt="" />
                            <span class="remove" onclick="jQuery(this).removeItemGallery();"><i class="fa fa-times-circle fa-2x"></i></span>
                        </li>
                    <?php endif; endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
    <?php break;

        case 'custom_fields': ?>
            <div class="one-fifth">
                <label class="add-new-field"><?php _e('Add New Custom Field', 'metrodir'); ?></label>
                <div class="bDivider"></div>
                <div id="add_custom_field_form">
                    <div>
                        <p><label style="margin-bottom: 4px;"><?php _e('Label', 'metrodir'); ?></label>
                            <input type="text" class="widefat value_label" value="" id="add_custom_field_form_label" /></p>
                        <p><label style="margin-bottom: 4px;"><?php _e('Value', 'metrodir'); ?></label>
                            <input type="text" class="widefat value_value" value="" id="add_custom_field_form_value" /></p>
                        <input type="button" class="button" value="<?php _e('Add Custom Field', 'metrodir'); ?>" onclick="jQuery(this).insertUOUCustomField();" />
                    </div>
                </div>
            </div>

            <div class="four-fifths last values" id="uou_custom_fields_wrapper">
                <input type="hidden" value="<?php     $guou_cf_id = get_post_meta($post_id, $field['id'], true); echo htmlspecialchars($guou_cf_id); ?>" id="uou_custom_fields" name="uou_custom_fields" />
                <ul>
                    <?php
                    $the_custom_fields = json_decode($guou_cf_id);
                    if(is_object($the_custom_fields)) :
                        foreach($the_custom_fields as $custom_field) :
                            ?>
                            <li>
                                <div class="head">
                                    <span class="title" onclick="jQuery(this).openInsider();"><i class="fa fa-chevron-down"></i><?php echo esc_html($custom_field->label); ?></span>
                                </div>
                                <div class="insider" style="display: none;">
                                    <div class="one-half">
                                        <label><?php _e('Label', 'metrodir'); ?></label>
                                        <input type="text" class="widefat value_label" value="<?php echo esc_html($custom_field->label); ?>" onblur="jQuery(this).valueChangeLabel2(); jQuery('#uou_custom_fields_wrapper ul').CustomFieldRefresh();" />
                                        <em style="margin: 10px 0 0; display: block;"><?php _e('Label of your Custom Field', 'glocal'); ?></em></div>
                                    <div class="one-half last"><label><?php _e('Value', 'metrodir'); ?></label>
                                        <input type="text" class="widefat value_value" value="<?php echo esc_html($custom_field->value); ?>" />
                                        <em style="margin: 10px 0 0; display: block;"><?php _e('Your value. This is displayed in the front end. HTML accepted', 'metrodir'); ?></em></div>
                                    <div class="clear"></div><div class="bDivider"></div><input type="button" class="button" value="<?php _e('Remove Value','metrodir'); ?>" onclick="jQuery(this).removeCustomField();" /><div class="clear"></div>
                                </div>
                                <!-- /.insider/ -->
                            </li>
                        <?php endforeach;endif; ?>
                </ul>
            </div>
            <!-- /dropdown-value/ -->
            <div class="clear"></div>
            <!-- /clear/ -->
            <?php break;

            case 'custom_post_item':
                $meta_obj = json_decode(htmlspecialchars_decode($meta));
                ?>
                <div id="<?php echo $field['id'];?>" class="data_frame post-media-gal" data-type="<?php echo $field['post_type'];?>">

                    <input type="hidden" value='<?php echo $meta; ?>' name="<?php echo $field['id']; ?>" />

                    <?php
                    $ajax_url = add_query_arg(
                        array(
                            'action' => 'post_search_interface',
                            'post_id' => $post_id,
                            'field_id' => $field['id'],
                            'post_type' => $field['post_type'],
                            'update_callback' => 'updateItems',
                            'items_callback' => 'addItemToList',
                            'curr_callback' => 'getCurrentItems',
                            'TB_iframe' => 'true',
                        ),
                        admin_url( 'admin-ajax.php' )
                    );
                    ?>
                    <span><?php  echo $field['desc']; ?></span><br/>
                    <input class="button" value="<?php _e('Select '.$field['name'], 'metrodir'); ?>" onclick="selectPostTypeItems(<?php echo the_ID();?>, '<?php echo $field['id'];?>', '<?php echo $field['post_type'];?>', '<?php echo $ajax_url; ?>');" />

                    <ul class="items gallery_images">

                        <?php
						
                        if(is_object($meta_obj)) : ?>

                            <script type="text/javascript">

                                jQuery(document).ready(function() {
                                    init_sortable('<?php echo $field['id'];?>');
                                });

                            </script>

                            <?php

                            foreach($meta_obj as $item_id) :
                                $thumb_id = $item_id;


                                $title = get_the_title($item_id);
								
                                if($field['post_type'] != 'attachment'):
									$thumb_id = get_post_thumbnail_id($item_id);
								endif;				
								if($thumb_id && $thumb_id != 0):
									$image_url = vt_resize($thumb_id, null, 150, 150);
								else:
									$image_url = get_template_directory_uri().'/images/no_image.jpg';
								endif;
                                    ?>

                                    <li class="item" data-value="<?php echo $item_id; ?>">
                                        <div>
                                            <img src="<?php echo $image_url ?>" alt="" />
                                        </div>

                                        <span class="item_title"><?php echo $title;?></span>

                                        <span class="remove" onclick="removeItem(this, '<?php echo $field['id'];?>');"><i class="fa fa-times-circle fa-2x"></i></span>

                                    </li>

                                <?php endforeach; ?>

                        <?php endif; ?>

                    </ul>
                </div>
                <?php
                break;

        }
    }

    function ajax_get_avatar_url($get_avatar){
        preg_match("/src='(.*?)'/i", $get_avatar, $matches);
        return $matches[1];
    }

    function save($post_id) {

        // Fix null meta
        if(isset($_POST['metro_featured'])) { update_post_meta($post_id, 'metro_featured', $_POST['metro_featured']); } else { update_post_meta($post_id, 'metro_featured', ''); }
        if(isset($_POST['metro_address_zip'])) { update_post_meta($post_id, 'metro_address_zip', $_POST['metro_address_zip']); } else { update_post_meta($post_id, 'metro_address_zip', ''); }
        if(isset($_POST['metro_address_country_name'])) { update_post_meta($post_id, 'metro_address_country_name', $_POST['metro_address_country_name']); } else { update_post_meta($post_id, 'metro_address_country_name', ''); }
        if(isset($_POST['metro_address_region_name'])) { update_post_meta($post_id, 'metro_address_region_name', $_POST['metro_address_region_name']); } else { update_post_meta($post_id, 'metro_address_region_name', ''); }
        if(isset($_POST['metro_address_name'])) { update_post_meta($post_id, 'metro_address_name', $_POST['metro_address_name']); } else { update_post_meta($post_id, 'metro_address_name', ''); }

        // verify nonce

        $new = null;

        if (isset($_POST['flexicv_meta_box_nonce']))

            if (!wp_verify_nonce($_POST['flexicv_meta_box_nonce'], basename(__FILE__))) {

                return $post_id;

            }



        // check autosave

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {

            return $post_id;

        }

        /* echo '<pre>';
        print_r($_POST);
        die(); */

        // check permissions

        $new = null;

        if (isset( $_POST['post_type']) )

            if ('page' == $_POST['post_type']) {

                if (!current_user_can('edit_page', $post_id)) {

                    return $post_id;

                }

            } elseif (!current_user_can('edit_post', $post_id)) {

                return $post_id;

            }

        foreach ($this->meta_Box['fields_group'] as $fields) {
            foreach ($fields['fields'] as $field) {
                $name = $field['id'];

                $old = get_post_meta($post_id, $name, true);

                if (isset($_POST[$field['id']]) )

                    $new = $_POST[$field['id']];



                if ($field['type'] == 'file' || $field['type'] == 'image') {

                    $file = wp_handle_upload($_FILES[$name], array('test_form' => false));

                    $new = $file['url'];

                }

                /* echo $field['id'].' - '.$old.' - '.$new.'<br/>'; */

                if ($new && $new != $old) {

                    update_post_meta($post_id, $name, $new);

                } elseif ('' == $new && $old && $field['type'] != 'file' && $field['type'] != 'image') {

                    delete_post_meta($post_id, $name, $old);

                }
            }
        }

        /* echo '<pre>';
        die();  */

    }
}
?>
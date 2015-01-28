<?php

add_action( 'wp_ajax_nopriv_action_item_rate', 'uouStarsRateItem' );
add_action( 'wp_ajax_action_item_rate', 'uouStarsRateItem' );

	// Add New Post Type For stars
	function metrodir_stars_posttype() {
		global $shortname;
		register_post_type( 'stars',
			array(
				'labels' => array(
					'name' => __( 'Rating', 'metrodir'),
					'singular_name' => __( 'Rating Stars', 'metrodir'),
					'add_new' => __( 'Add New Stars', 'metrodir'),
					'add_new_item' => __( 'Add New stars', 'metrodir'),
					'edit_item' => __( 'Edit stars', 'metrodir'),
					'new_item' => __( 'Add New stars', 'metrodir'),
					'view_item' => __( 'View Stars', 'metrodir'),
					'search_items' => __( 'Search stars',  'metrodir'),
					'not_found' => __( 'No stars items found',  'metrodir'),
					'not_found_in_trash' => __( 'No stars items found in trash', 'metrodir')
				),
				'public' => true,
				'supports' => array( 'title', 'thumbnail'),
				'taxonomies' => array('stars_category'),
				'capability_type' => 'post',
				'rewrite' => array("slug" => "stars"),
				'menu_position' => 30
			)
		);
	}

	add_action('init', 'metrodir_stars_posttype');

	// Set as many image sizes as you want
	add_filter("manage_edit-stars_columns", "stars_edit_columns");
	add_action("manage_posts_custom_column",  "stars_columns_display", 10, 2);

    add_action( 'admin_head', 'StarsRemoveAddButton' );
    function StarsRemoveAddButton() {
        remove_submenu_page('edit.php?post_type=stars','post-new.php?post_type=stars');
        if((strpos($_SERVER['PHP_SELF'],'edit.php') !== false) && isset($_GET['post_type']) && ($_GET['post_type'] == 'stars')){
            echo '<style type="text/css">
                    a.add-new-h2 { display: none !important; }
                </style>';
        }
    }

	function stars_edit_columns($stars_columns){
		global $shortname;
		$stars_columns = array(
			"cb" => "<input type=\"checkbox\" />",
            'title'         => __( 'Name', 'metrodir'),
            'rating-post-id'=> __( 'Rating for', 'metrodir'),
            'rating-value'  => __( 'Rating', 'metrodir'),
            'rating-content'		=> __( 'Message', 'metrodir'),
            'date'          => __( 'Date', 'metrodir')
		);
		return $stars_columns;
	}



global $enabledRatings, $enabledRatingsMax;
$optionsPlugin = get_option("uou_opt_plugins");
if($optionsPlugin !== false) {
    $UouPlugins = json_decode(json_encode($optionsPlugin));}
else {
    $UouPlugins = json_decode(json_encode(uouLoadDefOptions()));}
$enabledRatingsMax = 5;
$enabledRatings = array();
for ($i=1; $i <= 5; $i++) {
    $number = "n".$i;
    if(isset($UouPlugins->stars->settings->rating->$number->on))
        $eName = $UouPlugins->stars->settings->rating->$number->on;
    if(isset($UouPlugins->stars->settings->rating->$number->name))
        $tName = $UouPlugins->stars->settings->rating->$number->name;
    if (isset($eName) AND $eName == "enable") {
        if (isset($tName)) $enabledRatings[$i] = $tName;
    }
}

	function stars_columns_display($stars_columns, $ratingId){

		switch ($stars_columns) {

            case "rating-name":
                $post = get_post( $ratingId );
                echo $post->post_title;
                break;
            case "rating-post-id":
                $postId = get_post_meta( $ratingId, 'post_id', true );
                $postLink = get_permalink( $postId );
                $post = get_post( $postId );
                echo '<strong><a href="'.$postLink.'" target="_blank">'.$post->post_title.'</a></strong>';
                break;
            case "rating-value":
                global $enabledRatings, $enabledRatingsMax;
                $meanRounded = intval(get_post_meta( $ratingId, 'rating_mean_rounded', true ));

                foreach ($enabledRatings as $key => $value) {
                    $rating = intval(get_post_meta( $ratingId, 'rating_'.$key, true ));
                    echo '<div class="rating clearfix">';
                    for($i = 1; $i <= $enabledRatingsMax; $i++) {
                        echo '<div class="star';
                        if ($i <= $rating) {
                            echo ' active';
                        }
                        echo '"></div>';
                    }
                    echo '<div class="rating-label">'.$value.'</div></div><div class="clearfix"></div>';

                }
                echo '<div class="rating clearfix">';
                for($i = 1; $i <= $enabledRatingsMax; $i++) {
                    echo '<div class="star';
                    if ($i <= $meanRounded) {
                        echo ' active';
                    }
                    echo '"></div>';
                }
                echo '<div class="rating-label">'.__('- Average -','metrodir').'</div></div><div class="clearfix"></div>';
                break;

            case "rating-content":
                $post = get_post( $ratingId );
                echo $post->post_content;

                break;
		}
	}
	
	$prefix = $shortname . "_";

$metaBoxes['stars'] = array(
	  'id' => 'stars-options',
	  'title' => __('Options', 'metrodir'),
	  'pages' => array('stars'),
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
                  'id' => $prefix . 'stars_name',
                  'type' => 'text',
                  'desc' => __('Name people', 'metrodir')
                )
                )
          )
      )
	);





function checkRated($postId) {
global $UouPlugins;

    $opt_metrodir_stars_htime = $UouPlugins->stars->settings->holdtime;
    $Check_time = (isset($opt_metrodir_stars_htime)) ? intval($opt_metrodir_stars_htime) : 60;

    $metaIp = get_post_meta($postId, "_rating_ip");
    $votedIp = (isset($metaIp[0]) && is_array($metaIp[0])) ? $metaIp[0] : array();
    $ip = $_SERVER['REMOTE_ADDR'];
    if(in_array($ip, array_keys($votedIp))) {
        $time = $votedIp[$ip];
        $now = time();
        if(round(($now - $time) / 60) > $Check_time) {
            return false;
        }
        return true;
    }
    return false;
}


function getSklStars($postId, $success = false) {
global $UouPlugins,$current_user;
        $args = array(
            'post_type' => 'stars',
            'post_status' => 'publish',
            'nopaging' => true,
            'meta_query' => array(
                array(
                    'key' => 'post_id',
                    'value' => $postId
                )
            )
        );
        $ratings = new WP_Query($args);
        $starsCount = 5;
        $metaIp = get_post_meta($postId, "_rating_ip");
        $votedIp = (isset($metaIp[0]) && is_array($metaIp[0])) ? $metaIp[0] : array();
        $rating_caps = true;

        if($UouPlugins->stars->restriction == 'enable'){

            $current_user = wp_get_current_user();
            if( isset( $current_user->roles ) && is_array( $current_user->roles ) && ( in_array('administrator', $current_user->roles)) ){
                $rating_admin_caps = true;
            }

            $check_cand_role = $current_user->roles;
            $cand_role_n = substr($check_cand_role[0],14);
            $cand_role = "role".$cand_role_n;

            if ($UouPlugins->acc->settings->$cand_role->caps->rating OR $rating_admin_caps){
                $rating_caps = true;
            } else {
                $rating_caps = false;
            }

        }
        ?>

        <div id="uou-stars-system" class="rating-system" data-post-id="<?php echo $postId ?>">
            <div id="get_homeurl" data-homeurl="<?php echo get_template_directory_uri(); ?>"></div>
            <div class="rating-container">
            <div class="title"><h2><?php echo __('Your Rating','metrodir'); ?></h2></div>
            <?php if($success): ?>
                <!-- Message --><div class="notification-success">
                    <i class="fa fa-exclamation-circle"></i> <?php echo __('Rating has been successfully sent.','metrodir'); ?>
                </div><!-- /Message -->
            <?php elseif(checkRated($postId)): ?>
                <!-- Message --><div class="notification-notice">
                    <i class="fa fa-exclamation-circle"></i> <?php echo __('Sorry, you already rated.','metrodir'); ?>
                </div><!-- /Message -->
            <?php else: ?>
                <?php if($rating_caps AND $rating_caps == true): ?>
                    <div class="rating-send">

                        <!-- Message --><div class="message error" style="display: none;">
                            <div class="notification-error">
                                <i class="fa fa-times-circle"></i> <?php _e('ERROR: Please complete the required fields','metrodir'); ?>
                            </div>
                        </div><!-- /Message -->

                        <!-- Message --><div class="message success"<?php if(!$success) echo ' style="display: none;"'; ?>>
                            <div class="notification-success">
                                <i class="fa fa-exclamation-circle"></i> <?php _e('Rating has been successfully sent','metrodir'); ?>
                            </div>
                        </div><!-- /Message -->

                        <div class="rating-ipnuts">

                            <div class="rating-details">
                                <div class="detail"><input id="rating-name" name="rating-name" type="text" placeholder="<?php echo __('Name','metrodir'); ?>" class="text-input-grey"></div>
                                <div class="detail"><textarea id="rating-description" name="rating-description" placeholder="<?php echo __('Description','metrodir'); ?>" class="text-input-grey comment-message-main"></textarea></div>
                                <button class="send-rating button-2-green"><i class="fa fa-arrow-circle-right"></i>  <?php _e('Send rating','metrodir'); ?></button>
                            </div>

                            <div class="ratings">
                                <?php for($i = 1; $i <= 4; $i++): ?>
                                    <?php
                                        $number = "n".$i;
                                        if (isset($UouPlugins->stars->settings->rating->$number->on)) $rating_enable = $UouPlugins->stars->settings->rating->$number->on;
                                        if (isset($UouPlugins->stars->settings->rating->$number->name)) $rating_name = $UouPlugins->stars->settings->rating->$number->name;
                                    ?>
                                    <?php if(isset($rating_enable) AND $rating_enable == "enable"): ?>
                                        <div class="rating" data-rating-id="<?php echo $i; ?>" data-rated-value="0">
                                            <div class="rating-title"><?php if (isset($rating_name)) echo $rating_name; ?></div>
                                            <div class="stars">
                                                <?php for($j = 1; $j <= $starsCount; $j++): ?><i class="star fa fa-star-o fa-lg" data-star-id="<?php echo $j; ?>"></i><?php endfor; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if(count($ratings->posts) > 0):  ?>
                <div class="title"><h2><?php echo count($ratings->posts).__(' Ratings','metrodir'); ?></h2></div>
                <div class="user-ratings">
                    <?php foreach ($ratings->posts as $rating): ?>
                    <div class="user-rating">
                        <div class="value">
                            <div class="user-values">
                                <?php
                                $sum = 0;
                                $count = 0;
                                ?>
                                <?php for($i = 1; $i <= 4; $i++): ?>
                                    <?php
                                    $number = "n".$i;
                                    if (isset($UouPlugins->stars->settings->rating->$number->on)) $rating_enable = $UouPlugins->stars->settings->rating->$number->on;  else $rating_enable = "disable";
                                    if (isset($UouPlugins->stars->settings->rating->$number->name)) $rating_name = $UouPlugins->stars->settings->rating->$number->name;
                                    ?>
                                    <?php if(isset($rating_enable) AND $rating_enable == "enable"): ?>
                                        <?php
                                        $stars = get_post_meta( $rating->ID, 'rating_'.$i, true );
                                        $stars = (!empty($stars)) ? intval($stars) : 0;
                                        $sum += $stars;
                                        $count++;
                                        ?>
                                        <div class="user-rating-send">
                                            <div class="rating-title"><?php if (isset($rating_name)) echo $rating_name; ?></div>
                                            <div class="user-stars">
                                                <?php for($j = 1; $j <= $starsCount; $j++): ?>
                                                    <i class="fa <?php if (($stars + 1 - $j) >= 1) echo "fa-star"; else echo 'fa-star-o'; ?> fa-lg"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <div class="user-values-stars">
                                <?php $mean = $sum / $count; ?>
                                <?php for($j = 1; $j <= $starsCount; $j++): ?>
                                    <i class="fa <?php if (($mean + 1 - $j) >= 1) echo "fa-star"; else if (($mean + 1 - $j) >= 0.5) echo "fa-star-half-o"; else echo 'fa-star-o'; ?> fa-lg"></i>
                                <?php endfor; ?>
                            </div>
                            <div class="showall"><?php echo __('Show Details','metrodir'); ?></div>
                        </div>
                        <div class="stars-description">
                            <div class="stars-name"><?php echo $rating->post_title; ?> - <span><?php echo $rating->post_date; ?></span></div>
                            <div class="stars-text">
                                <p><?php echo $rating->post_content; ?></p>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="clear"></div>
            <?php endif; ?>
            </div>
            <div class="clear"></div>
        </div>

    <?php
}


function CalcAverageRatingPost($postId) {
    $max = 5;
    $args = array(
        'post_type' => 'stars',
        'post_status' => 'publish',
        'nopaging' => true,
        'meta_query' => array(
            array(
                'key' => 'post_id',
                'value' => $postId
            )
        )
    );
    $ratings = new WP_Query($args);

    if(count($ratings->posts) > 0) {
        $sum = 0;
        foreach ($ratings->posts as $rating) {
            $sum += floatval(get_post_meta($rating->ID,'rating_mean',true));
        }
        $rounded = floatval($sum / count($ratings->posts));
        $full = floatval($sum / count($ratings->posts));
        return array( 'max' => $max, 'val' => $rounded, 'full' => $full, 'count' => count($ratings->posts));
    } else {
        return false;
    }

}

function WriteAverageRatingInDb($id, $post) {
    if (!isset($post)) {
        $post = get_post( intval($id) );
    }
    if ($post->post_type == 'stars') {
        $itemId = get_post_meta( $id, 'post_id', true );
        $rating = CalcAverageRatingPost($itemId, false);
        update_post_meta( $itemId, 'rating_rounded', $rating['val']);
        update_post_meta( $itemId, 'rating_full', $rating['full']);
        update_post_meta( $itemId, 'rating_max', $rating['max']);
        update_post_meta( $itemId, 'rating_count', $rating['count']);
        update_post_meta( $itemId, 'rating', $rating);
    }
}



function uouAddRating($data) {

    $postStatus = "publish";

    $rating = array(
        'post_author'    => $data->author,
        'post_title'     => $data->name,
        'post_content'   => $data->description,
        'post_status'    => $postStatus,
        'post_type'      => 'stars',
        'comment_status' => 'closed',
        'ping_status'    => 'closed'
    );
    $ratingId = wp_insert_post( $rating );
    if($ratingId == 0) return 0;

    update_post_meta( $ratingId, 'post_id' , $data->postId );

    $sum = 0;
    foreach ($data->values as $key => $value) {
        update_post_meta( $ratingId, 'rating_' . $key , $value );
        $sum += intval($value);
    }
    $mean = $sum / count($data->values);
    update_post_meta( $ratingId, 'rating_mean' , $mean );
    update_post_meta( $ratingId, 'rating_mean_rounded' , round($mean) );

    WriteAverageRatingInDb($ratingId, null);
    return $ratingId;
}


function uouStarsRateItem() {
    if(isset($_POST['post_id']) && isset($_POST['rating_name'])){

        $nonce = $_POST['nonce'];
        if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
            echo "nonce";
            exit();
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $postId = $_POST['post_id'];
        $ratedValues = $_POST['rating_values'];

        $metaIp = get_post_meta($postId, "_rating_ip");
        $votedIp = (isset($metaIp[0]) && is_array($metaIp[0])) ? $metaIp[0] : array();

        if(!checkRated($postId)) {
            $votedIp[$ip] = time();
            update_post_meta($postId, "_rating_ip", $votedIp);
            $post = get_post( $postId );
            $data = new StdClass;
            $data->postId = $postId;
            $data->author = $post->post_author;
            $data->name = strip_tags($_POST['rating_name']);
            $data->description = strip_tags($_POST['rating_description']);
            $data->values = $_POST['rating_values'];
            uouAddRating($data);
            echo getSklStars($postId, true);
        } else {
            echo "request exist";
        }
    } else {
        echo "so bad";
    }
    exit();
}
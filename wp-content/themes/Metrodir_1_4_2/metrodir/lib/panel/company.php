<?php

// Add New Post Type For company
function metrodir_company_posttype() {
    global $shortname;

    $opt_metrodir_slug_company = uougo('slug_company');

    if(!$opt_metrodir_slug_company){
        $opt_metrodir_slug_company = "company";
    }

    $opt_metrodir_slug_company_tax = uougo('slug_company_tax');

    if(!$opt_metrodir_slug_company_tax) {
        $opt_metrodir_slug_company_tax = "company_category";
    }

    register_post_type( 'company',
        array(
            'labels' => array(
                'name' => __( 'Company', 'metrodir'),
                'singular_name' => __( 'Company Item', 'metrodir'),
                'add_new' => __( 'Add New Item', 'metrodir'),
                'add_new_item' => __( 'Add New Company Item', 'metrodir'),
                'edit_item' => __( 'Edit Company Item', 'metrodir'),
                'new_item' => __( 'Add New Company Item', 'metrodir'),
                'view_item' => __( 'View Item', 'metrodir'),
                'search_items' => __( 'Search Company', 'metrodir'),
                'not_found' => __( 'No Company items found', 'metrodir'),
                'not_found_in_trash' => __( 'No Company items found in trash', 'metrodir')
            ),
            'public' => true,
            'publicly_queryable' => true,
            'query_var' => true,
            'supports' => array(
                'title',
                'thumbnail',
                'comments',
                'editor',
                'author'
            ),
            'taxonomies' => array('company_category'),
            'capability_type' => 'company',
            'rewrite' => array("slug" => $opt_metrodir_slug_company),
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => get_template_directory_uri().'/skl/framework/img/company.png',
            'menu_position' => 31
        )
    );

    // Add company Categories
    register_taxonomy('company_category', 'company',
        array(
            'labels' => array(
                'name' => _x( 'Company Categories', $shortname),
                'singular_name' => _x( 'Company Category', $shortname),
                'search_items' =>  __( 'Search Company Categories', 'metrodir'),
                'all_items' => __( 'All Company Categories', 'metrodir'),
                'edit_item' => __( 'Edit Company Category', 'metrodir'),
                'update_item' => __( 'Update Category', 'metrodir'),
                'add_new_item' => __( 'Add New Company Category', 'metrodir'),
                'new_item_name' => __( 'New Company Category Name', 'metrodir'),
                'menu_name' => __( 'Company Categories', 'metrodir'),
            ),
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array("slug" => $opt_metrodir_slug_company_tax),
            'capabilities' => array(
                'assign_terms' => 'assign_company_category'
            )
        )
    );
}

add_action('init', 'metrodir_company_posttype');

// Set as many image sizes as you want
add_filter("manage_edit-company_columns", "company_edit_columns");
add_action("manage_posts_custom_column",  "company_columns_display", 10, 2);


function company_edit_columns($company_columns){
    global $shortname;
    $company_columns = array(
        "cb" => "<input type=\"checkbox\" />",
        'thumbnail'		=> __( 'Image', 'metrodir'),
        "title" => _x('Title', 'column name', 'metrodir'),
        "address" => __('Address', 'metrodir'),
        "company_category" => __('Categories', 'metrodir'),
        "author" => __('Author', 'metrodir'),
        "date" => __('Date', 'metrodir'),
    );
    return $company_columns;
}

function company_columns_display($company_columns, $post_id){
    global $shortname;

    switch ($company_columns) {

        case "address":
            $adrs = get_post_meta( $post_id, 'metro_address_country_name', true );
            $adrs2 = get_post_meta( $post_id, 'metro_address_region_name', true );
            $adrs3 = get_post_meta( $post_id, 'metro_address_name', true );
            $adrs4 = get_post_meta( $post_id, 'metro_address_zip', true );
            $custom_fields = get_post_custom($post_id);
            if ($custom_fields['metro_address_zip'][0] === NULL)
                echo '<div class="check-addressmeta" data-post-id="'.$post_id.'"><i class="fa fa-exclamation-triangle fa-lg"></i> <div class="desc-check-featured">'.__('Click To Fix Meta','metrodir').'</div> </div>';

            if ($custom_fields['metro_address_country_name'][0] === NULL)
                echo '<div class="check-addressmeta" data-post-id="'.$post_id.'"><i class="fa fa-exclamation-triangle fa-lg"></i> <div class="desc-check-featured">'.__('Click To Fix Meta','metrodir').'</div> </div>';

            if ($custom_fields['metro_address_region_name'][0] === NULL)
                echo '<div class="check-addressmeta" data-post-id="'.$post_id.'"><i class="fa fa-exclamation-triangle fa-lg"></i> <div class="desc-check-featured">'.__('Click To Fix Meta','metrodir').'</div> </div>';

            if ($custom_fields['metro_address_name'][0] === NULL)
                echo '<div class="check-addressmeta" data-post-id="'.$post_id.'"><i class="fa fa-exclamation-triangle fa-lg"></i> <div class="desc-check-featured">'.__('Click To Fix Meta','metrodir').'</div> </div>';

            if($adrs4){
                echo 'ZIP: '.$adrs4.' ';
            }
            if ($adrs) {
                echo $adrs.', '.$adrs2.', '.$adrs3;
            } else {
                echo __('Unavailable', 'metrodir');
            }
            break;

        case "company_category":
            $terms = get_the_terms( $post_id, 'company_category' );
            $item_cats = array();
            $item_cats_slugs = array();

            if(is_array($terms)) {
                foreach ($terms as $term ) {
                    $item_cats[] = $term->name;
                    $item_cats_slugs[] = $term->slug;
                }
            }

            $item_cats_str = join(", ", $item_cats);
            echo  $item_cats_str;
            break;
    }
}

add_action( 'wp_ajax_nopriv_action_check_addressmeta', 'uouFixCompany_addressmeta' );
add_action( 'wp_ajax_action_check_addressmeta', 'uouFixCompany_addressmeta' );

function uouFixCompany_addressmeta(){
    if(isset($_POST['post_id'])){
        $nonce = $_POST['nonce'];
        if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
            echo "nonce";
            exit();
        }
        $postId = $_POST['post_id'];
        $custom_fields = get_post_custom($postId);
        if ($custom_fields['metro_address_zip'][0] === NULL)
            update_post_meta($postId, 'metro_address_zip', '');

        if ($custom_fields['metro_address_country_name'][0] === NULL)
            update_post_meta($postId, 'metro_address_country_name', '');

        if ($custom_fields['metro_address_region_name'][0] === NULL)
            update_post_meta($postId, 'metro_address_region_name', '');

        if ($custom_fields['metro_address_name'][0] === NULL)
            update_post_meta($postId, 'metro_address_name', '');

        echo 'good';
    } else {echo 'bad';}
}

add_action( 'company_category_edit_form_fields', 'edit_skl_item_category', 10, 2);
add_action( 'company_category_add_form_fields', 'add_skl_item_category', 10, 2);
function edit_skl_item_category($tag) {
    $color = get_option( 'metrodir_category_'.$tag->term_id.'_color', '' );
    $icon = get_option( 'metrodir_category_'.$tag->term_id.'_icon', '' );
    $image = get_option( 'metrodir_category_'.$tag->term_id.'_image', '' );
    $custom_icon = get_option( 'metrodir_category_'.$tag->term_id.'_icon_image', '' );
    $custom_marker = get_option( 'metrodir_category_'.$tag->term_id.'_marker_image', '' );
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="metrodir_category_color">Color</label></th>
        <td>
            <div style="position: relative; height: 36px; width: 36px; float: left; margin: -6px 6px -6px -6px;">
                <div id="colorSelector" style="position: relative; cursor: pointer; position: relative; top: 0; left: 0; width: 36px;height: 36px; background: url(<?php echo get_template_directory_uri().'/images/select.png'; ?>) center;">
                    <div style="position: absolute; top: 4px; left: 4px; width: 28px; height: 28px; background: <?php echo $color; ?> url(<?php echo get_template_directory_uri().'/images/select.png'; ?>) center;"></div>
                </div>
            </div>
            <input maxlength="7" size="7" type="text" name="metrodir_category_color" id="metrodir_category_color" value="<?php echo $color; ?>" style="width: 92%;" placeholder="#FFFFFF"/>
            <br />
            <p class="description">Color For Category</p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="metrodir_category_icon">Icon</label></th>
        <td>
            <i id="icon-shower" class="fa <?php echo $icon; ?> fa-lg" style="margin: -1px 10px -1px -1px; padding: 1px; width: 24px; height: 24px; text-align: center; line-height: 26px; display: block; float: left; border: 1px solid #d1e5ee; border-radius: 3px;"></i>
            <select name="metrodir_category_icon" id="metrodir_category_icon" onchange="jQuery(document).ready(function() { loadicon(); });" style="width: 92%">
                <option value=""<?php if($icon == "") echo ' selected' ?>>None</option>
                <option value="fa-globe"<?php if($icon == "fa-globe") echo ' selected' ?>>Default</option>
                <option value="fa-ambulance"<?php if($icon == "fa-ambulance") echo ' selected' ?>>Ambulance</option>
                <option value="fa-anchor"<?php if($icon == "fa-anchor") echo ' selected' ?>>Anchor</option>
                <option value="fa-android"<?php if($icon == "fa-android") echo ' selected' ?>>Android</option>
                <option value="fa-apple"<?php if($icon == "fa-apple") echo ' selected' ?>>Apple</option>
                <option value="fa-archive"<?php if($icon == "fa-archive") echo ' selected' ?>>Archive</option>
                <option value="fa-asterisk"<?php if($icon == "fa-asterisk") echo ' selected' ?>>Asterisk</option>
                <option value="fa-bell"<?php if($icon == "fa-bell") echo ' selected' ?>>Bell</option>
                <option value="fa-beer"<?php if($icon == "fa-beer") echo ' selected' ?>>Beer</option>
                <option value="fa-bolt"<?php if($icon == "fa-bolt") echo ' selected' ?>>Bolt</option>
                <option value="fa-book"<?php if($icon == "fa-book") echo ' selected' ?>>Book</option>
                <option value="fa-bookmark"<?php if($icon == "fa-bookmark") echo ' selected' ?>>Bookmark</option>
                <option value="fa-briefcase"<?php if($icon == "fa-briefcase") echo ' selected' ?>>Briefcase</option>
                <option value="fa-building-o"<?php if($icon == "fa-building-o") echo ' selected' ?>>Building</option>
                <option value="fa-bug"<?php if($icon == "fa-bug") echo ' selected' ?>>Bug</option>
                <option value="fa-bullhorn"<?php if($icon == "fa-bullhorn") echo ' selected' ?>>Bullhorn</option>
                <option value="fa-bullseye"<?php if($icon == "fa-bullseye") echo ' selected' ?>>Bullseye</option>
                <option value="fa-camera"<?php if($icon == "fa-camera") echo ' selected' ?>>Camera</option>
                <option value="fa-camera-retro"<?php if($icon == "fa-camera-retro") echo ' selected' ?>>Camera-retro</option>
                <option value="fa-certificate"<?php if($icon == "fa-certificate") echo ' selected' ?>>Certificate</option>
                <option value="fa-circle"<?php if($icon == "fa-circle") echo ' selected' ?>>Circle</option>
                <option value="fa-clock-o"<?php if($icon == "fa-clock-o") echo ' selected' ?>>Clock</option>
                <option value="fa-cloud"<?php if($icon == "fa-cloud") echo ' selected' ?>>Cloud</option>
                <option value="fa-code-fork"<?php if($icon == "fa-code-fork") echo ' selected' ?>>Code Fork</option>
                <option value="fa-coffee"<?php if($icon == "fa-coffee") echo ' selected' ?>>Coffee</option>
                <option value="fa-cog"<?php if($icon == "fa-cog") echo ' selected' ?>>Cog</option>
                <option value="fa-cogs"<?php if($icon == "fa-cogs") echo ' selected' ?>>Cogs</option>
                <option value="fa-comment"<?php if($icon == "fa-comment") echo ' selected' ?>>Comment</option>
                <option value="fa-comments"<?php if($icon == "fa-comments") echo ' selected' ?>>Comments</option>
                <option value="fa-compass"<?php if($icon == "fa-compass") echo ' selected' ?>>Compass</option>
                <option value="fa-credit-card"<?php if($icon == "fa-credit-card") echo ' selected' ?>>Credit Card</option>
                <option value="fa-cutlery"<?php if($icon == "fa-cutlery") echo ' selected' ?>>Cutlery</option>
                <option value="fa-desktop"<?php if($icon == "fa-desktop") echo ' selected' ?>>Desktop</option>
                <option value="fa-envelope"<?php if($icon == "fa-envelope") echo ' selected' ?>>Envelope</option>
                <option value="fa-eur"<?php if($icon == "fa-eur") echo ' selected' ?>>Euro</option>
                <option value="fa-eraser"<?php if($icon == "fa-eraser") echo ' selected' ?>>Eraser</option>
                <option value="fa-exclamation-triangle"<?php if($icon == "fa-exclamation-triangle") echo ' selected' ?>>Exclamation</option>
                <option value="fa-eye"<?php if($icon == "fa-eye") echo ' selected' ?>>Eye</option>
                <option value="fa-female"<?php if($icon == "fa-female") echo ' selected' ?>>Female</option>
                <option value="fa-fighter-jet"<?php if($icon == "fa-fighter-jet") echo ' selected' ?>>Fighter Jet</option>
                <option value="fa-film"<?php if($icon == "fa-film") echo ' selected' ?>>Film</option>
                <option value="fa-filter"<?php if($icon == "fa-filter") echo ' selected' ?>>Filter</option>
                <option value="fa-fire"<?php if($icon == "fa-fire") echo ' selected' ?>>Fire</option>
                <option value="fa-fire-extinguisher"<?php if($icon == "fa-fire-extinguisher") echo ' selected' ?>>Fire Extinguisher</option>
                <option value="fa-flag"<?php if($icon == "fa-flag") echo ' selected' ?>>Flag</option>
                <option value="fa-flag-checkered"<?php if($icon == "fa-flag-checkered") echo ' selected' ?>>Flag Checkered</option>
                <option value="fa-frown-o"<?php if($icon == "fa-frown-o") echo ' selected' ?>>Frown</option>
                <option value="fa-gamepad"<?php if($icon == "fa-gamepad") echo ' selected' ?>>Gamepad</option>
                <option value="fa-gift"<?php if($icon == "fa-gift") echo ' selected' ?>>Gift</option>
                <option value="fa-gavel"<?php if($icon == "fa-gavel") echo ' selected' ?>>Gavel</option>
                <option value="fa-glass"<?php if($icon == "fa-glass") echo ' selected' ?>>Glass</option>
                <option value="fa-h-square"<?php if($icon == "fa-h-square") echo ' selected' ?>>H Square</option>
                <option value="fa-headphones"<?php if($icon == "fa-headphones") echo ' selected' ?>>Headphones</option>
                <option value="fa-heart"<?php if($icon == "fa-heart") echo ' selected' ?>>Heart</option>
                <option value="fa-home"<?php if($icon == "fa-home") echo ' selected' ?>>Home</option>
                <option value="fa-key"<?php if($icon == "fa-key") echo ' selected' ?>>Key</option>
                <option value="fa-laptop"<?php if($icon == "fa-laptop") echo ' selected' ?>>Laptop</option>
                <option value="fa-leaf"<?php if($icon == "fa-leaf") echo ' selected' ?>>Leaf</option>
                <option value="fa-lightbulb-o"<?php if($icon == "fa-lightbulb-o") echo ' selected' ?>>Lightbulb</option>
                <option value="fa-magic"<?php if($icon == "fa-magic") echo ' selected' ?>>Magic</option>
                <option value="fa-magnet"<?php if($icon == "fa-magnet") echo ' selected' ?>>Magnet</option>
                <option value="fa-male"<?php if($icon == "fa-male") echo ' selected' ?>>Male</option>
                <option value="fa-map-marker"<?php if($icon == "fa-map-marker") echo ' selected' ?>>Map Marker</option>
                <option value="fa-medkit"<?php if($icon == "fa-medkit") echo ' selected' ?>>Medkit</option>
                <option value="fa-meh-o"<?php if($icon == "fa-meh-o") echo ' selected' ?>>Meh</option>
                <option value="fa-microphone"<?php if($icon == "fa-microphone") echo ' selected' ?>>Microphone</option>
                <option value="fa-mobile"<?php if($icon == "fa-mobile") echo ' selected' ?>>Mobile</option>
                <option value="fa-money"<?php if($icon == "fa-money") echo ' selected' ?>>Money</option>
                <option value="fa-music"<?php if($icon == "fa-music") echo ' selected' ?>>Music</option>
                <option value="fa-pencil"<?php if($icon == "fa-pencil") echo ' selected' ?>>Pencil</option>
                <option value="fa-phone"<?php if($icon == "fa-phone") echo ' selected' ?>>Phone</option>
                <option value="fa-pagelines"<?php if($icon == "pagelines") echo ' selected' ?>>Pagelines</option>
                <option value="fa-picture-o"<?php if($icon == "fa-picture-o") echo ' selected' ?>>Picture</option>
                <option value="fa-plane"<?php if($icon == "fa-plane") echo ' selected' ?>>Plane</option>
                <option value="fa-puzzle-piece"<?php if($icon == "fa-puzzle-piece") echo ' selected' ?>>Puzzle Piece</option>
                <option value="fa-road"<?php if($icon == "fa-road") echo ' selected' ?>>Road</option>
                <option value="fa-rocket"<?php if($icon == "fa-rocket") echo ' selected' ?>>Rocket</option>
                <option value="fa-shield"<?php if($icon == "fa-shield") echo ' selected' ?>>Shield</option>
                <option value="fa-shopping-cart"<?php if($icon == "fa-shopping-cart") echo ' selected' ?>>Shopping Cart</option>
                <option value="fa-signal"<?php if($icon == "fa-signal") echo ' selected' ?>>Signal</option>
                <option value="fa-smile-o"<?php if($icon == "fa-smile-o") echo ' selected' ?>>Smile</option>
                <option value="fa-star"<?php if($icon == "fa-star") echo ' selected' ?>>Star</option>
                <option value="fa-stethoscope"<?php if($icon == "fa-stethoscope") echo ' selected' ?>>Stethoscope</option>
                <option value="fa-suitcase"<?php if($icon == "fa-suitcase") echo ' selected' ?>>Suitcase</option>
                <option value="fa-tachometer"<?php if($icon == "fa-tachometer") echo ' selected' ?>>Tachometer</option>
                <option value="fa-thumb-tack"<?php if($icon == "fa-thumb-tack") echo ' selected' ?>>Thumb Tack</option>
                <option value="fa-ticket"<?php if($icon == "fa-ticket") echo ' selected' ?>>Ticket</option>
                <option value="fa-tint"<?php if($icon == "fa-tint") echo ' selected' ?>>Tint</option>
                <option value="fa-trash-o"<?php if($icon == "fa-trash-o") echo ' selected' ?>>Trash</option>
                <option value="fa-trophy"<?php if($icon == "fa-trophy") echo ' selected' ?>>Trophy</option>
                <option value="fa-truck"<?php if($icon == "fa-truck") echo ' selected' ?>>Truck</option>
                <option value="fa-umbrella"<?php if($icon == "fa-umbrella") echo ' selected' ?>>Umbrella</option>
                <option value="fa-usd"<?php if($icon == "fa-usd") echo ' selected' ?>>Usd</option>
                <option value="fa-user"<?php if($icon == "fa-user") echo ' selected' ?>>User</option>
                <option value="fa-user-md"<?php if($icon == "fa-user-md") echo ' selected' ?>>User MD</option>
                <option value="fa-users"<?php if($icon == "fa-users") echo ' selected' ?>>Users</option>
                <option value="fa-video-camera"<?php if($icon == "fa-video-camera") echo ' selected' ?>>Video Camera</option>
                <option value="fa-wheelchair"<?php if($icon == "fa-wheelchair") echo ' selected' ?>>Wheelchair</option>
                <option value="fa-windows"<?php if($icon == "fa-windows") echo ' selected' ?>>Windows</option>
                <option value="fa-wrench"<?php if($icon == "fa-wrench") echo ' selected' ?>>Wrench</option>
            </select>
            <p class="description">Icon For Category</p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="metrodir_category_image">Image</label></th>
        <td>
            <input type="text" name="metrodir_category_image" id="metrodir_category_image" value="<?php echo $image; ?>" style="width: 80%;"/>
            <input type="button" value="Select Image" class="media-select" id="metrodir_category_image_selectMedia" name="metrodir_category_image_selectMedia" style="width: 15%;">
            <br />
            <p class="description">Image For Category Block on Home Page</p>
        </td>
    </tr>

    <tr class="form-field">
        <th scope="row" valign="top"><label for="metrodir_category_icon_image">Custom Icon Image</label></th>
        <td>
            <input type="text" name="metrodir_category_icon_image" id="metrodir_category_icon_image" value="<?php echo $custom_icon; ?>" style="width: 80%;"/>
            <input type="button" value="Select Image" class="media-select" id="metrodir_category_icon_image_selectMedia" name="metrodir_category_icon_image_selectMedia" style="width: 15%;">
            <br />
            <p class="description">Custom Icon Image For Category (90x90 Min size recommended)</p>
        </td>
    </tr>

    <tr class="form-field">
        <th scope="row" valign="top"><label for="metrodir_category_marker_image">Custom Marker Image</label></th>
        <td>
            <input type="text" name="metrodir_category_marker_image" id="metrodir_category_marker_image" value="<?php echo $custom_marker; ?>" style="width: 80%;"/>
            <input type="button" value="Select Image" class="media-select" id="metrodir_category_marker_image_selectMedia" name="metrodir_category_marker_image_selectMedia" style="width: 15%;">
            <br />
            <p class="description">Custom Marker Image For Category</p>
        </td>
    </tr>

<?php
}
function add_skl_item_category($tag) {
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="metrodir_category_color">Category Color</label></th>
        <td>
            <div style="position: relative; height: 36px; width: 36px; float: left; margin: -6px 6px -6px -6px;">
                <div id="colorSelector" style="position: relative; cursor: pointer; position: relative; top: 0; left: 0; width: 36px;height: 36px; background: url(<?php echo get_template_directory_uri().'/images/select.png'; ?>) center;">
                    <div style="position: absolute; top: 4px; left: 4px; width: 28px; height: 28px; background: url(<?php echo get_template_directory_uri().'/images/select.png'; ?>) center;"></div>
                </div>
            </div>
            <input maxlength="7" size="7" type="text" name="metrodir_category_color" id="metrodir_category_color" style="width: 90%;" placeholder="#FFFFFF"/>
            <br />
            <p class="description">Color For Category</p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="metrodir_category_icon">Category Icon</label></th>
        <td>
            <i id="icon-shower" class="" style="margin: -1px 10px -1px -1px; padding: 1px; width: 24px; height: 24px; text-align: center; line-height: 26px; display: block; float: left; border: 1px solid #d1e5ee; border-radius: 3px;"></i>
            <select name="metrodir_category_icon" id="metrodir_category_icon" onchange="jQuery(document).ready(function() { loadicon(); });" style="width: 90%">
                <option value="" selected>None</option>
                <option value="fa-globe">Default</option>
                <option value="fa-ambulance">Ambulance</option>
                <option value="fa-anchor">Anchor</option>
                <option value="fa-android">Android</option>
                <option value="fa-apple">Apple</option>
                <option value="fa-archive">Archive</option>
                <option value="fa-asterisk">Asterisk</option>
                <option value="fa-bell">Bell</option>
                <option value="fa-beer">Beer</option>
                <option value="fa-bolt">Bolt</option>
                <option value="fa-book">Book</option>
                <option value="fa-bookmark">Bookmark</option>
                <option value="fa-briefcase">Briefcase</option>
                <option value="fa-building-o">Building</option>
                <option value="fa-bug">Bug</option>
                <option value="fa-bullhorn">Bullhorn</option>
                <option value="fa-bullseye">Bullseye</option>
                <option value="fa-camera">Camera</option>
                <option value="fa-camera-retro">Camera-retro</option>
                <option value="fa-certificate">Certificate</option>
                <option value="fa-circle">Circle</option>
                <option value="fa-clock-o">Clock</option>
                <option value="fa-cloud">Cloud</option>
                <option value="fa-code-fork">Code Fork</option>
                <option value="fa-coffee">Coffee</option>
                <option value="fa-cog">Cog</option>
                <option value="fa-cogs">Cogs</option>
                <option value="fa-comment">Comment</option>
                <option value="fa-comments">Comments</option>
                <option value="fa-compass">Compass</option>
                <option value="fa-credit-card">Credit Card</option>
                <option value="fa-cutlery">Cutlery</option>
                <option value="fa-desktop">Desktop</option>
                <option value="fa-envelope">Envelope</option>
                <option value="fa-eur">Euro</option>
                <option value="fa-eraser">Eraser</option>
                <option value="fa-exclamation-triangle">Exclamation</option>
                <option value="fa-eye">Eye</option>
                <option value="fa-female">Female</option>
                <option value="fa-fighter-jet">Fighter Jet</option>
                <option value="fa-film">Film</option>
                <option value="fa-filter">Filter</option>
                <option value="fa-fire">Fire</option>
                <option value="fa-fire-extinguisher">Fire Extinguisher</option>
                <option value="fa-flag">Flag</option>
                <option value="fa-flag-checkered">Flag Checkered</option>
                <option value="fa-frown-o">Frown</option>
                <option value="fa-gamepad">Gamepad</option>
                <option value="fa-gift">Gift</option>
                <option value="fa-gavel">Gavel</option>
                <option value="fa-glass">Glass</option>
                <option value="fa-h-square">H Square</option>
                <option value="fa-headphones">Headphones</option>
                <option value="fa-heart">Heart</option>
                <option value="fa-home">Home</option>
                <option value="fa-key">Key</option>
                <option value="fa-laptop">Laptop</option>
                <option value="fa-leaf">Leaf</option>
                <option value="fa-lightbulb-o">Lightbulb</option>
                <option value="fa-magic">Magic</option>
                <option value="fa-magnet">Magnet</option>
                <option value="fa-male">Male</option>
                <option value="fa-map-marker">Map Marker</option>
                <option value="fa-medkit">Medkit</option>
                <option value="fa-meh-o">Meh</option>
                <option value="fa-microphone">Microphone</option>
                <option value="fa-mobile">Mobile</option>
                <option value="fa-money">Money</option>
                <option value="fa-music">Music</option>
                <option value="fa-pencil">Pencil</option>
                <option value="fa-phone">Phone</option>
                <option value="fa-pagelines">Pagelines</option>
                <option value="fa-picture-o">Picture</option>
                <option value="fa-plane">Plane</option>
                <option value="fa-puzzle-piece">Puzzle Piece</option>
                <option value="fa-road">Road</option>
                <option value="fa-rocket">Rocket</option>
                <option value="fa-shield">Shield</option>
                <option value="fa-shopping-cart">Shopping Cart</option>
                <option value="fa-signal">Signal</option>
                <option value="fa-smile-o">Smile</option>
                <option value="fa-star">Star</option>
                <option value="fa-stethoscope">Stethoscope</option>
                <option value="fa-suitcase">Suitcase</option>
                <option value="fa-tachometer">Tachometer</option>
                <option value="fa-thumb-tack">Thumb Tack</option>
                <option value="fa-ticket">Ticket</option>
                <option value="fa-tint">Tint</option>
                <option value="fa-trash-o">Trash</option>
                <option value="fa-trophy">Trophy</option>
                <option value="fa-truck">Truck</option>
                <option value="fa-umbrella">Umbrella</option>
                <option value="fa-usd">Usd</option>
                <option value="fa-user">User</option>
                <option value="fa-user-md">User MD</option>
                <option value="fa-users">Users</option>
                <option value="fa-video-camera">Video Camera</option>
                <option value="fa-wheelchair">Wheelchair</option>
                <option value="fa-windows">Windows</option>
                <option value="fa-wrench">Wrench</option>
            </select>
            <p class="description">Icon For Category</p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="metrodir_category_image">Image</label></th>
        <td>
            <input type="text" name="metrodir_category_image" id="metrodir_category_image" style="width: 80%;"/>
            <input type="button" value="Select Image" class="media-select" id="metrodir_category_image_selectMedia" name="metrodir_category_image_selectMedia" style="width: 15%;">
            <br />
            <p class="description">Image For Category Block on Home Page</p>
        </td>
    </tr>

    <tr class="form-field">
        <th scope="row" valign="top"><label for="metrodir_category_icon_image">Custom Icon Image</label></th>
        <td>
            <input type="text" name="metrodir_category_icon_image" id="metrodir_category_icon_image" style="width: 80%;"/>
            <input type="button" value="Select Image" class="media-select" id="metrodir_category_icon_image_selectMedia" name="metrodir_category_icon_image_selectMedia" style="width: 15%;">
            <br />
            <p class="description">Custom Icon Image For Category (90x90 Min size recommended)</p>
        </td>
    </tr>

    <tr class="form-field">
        <th scope="row" valign="top"><label for="metrodir_category_marker_image">Custom Marker Image</label></th>
        <td>
            <input type="text" name="metrodir_category_marker_image" id="metrodir_category_marker_image" style="width: 80%;"/>
            <input type="button" value="Select Image" class="media-select" id="metrodir_category_marker_image_selectMedia" name="metrodir_category_marker_image_selectMedia" style="width: 15%;">
            <br />
            <p class="description">Custom Marker Image For Category</p>
        </td>
    </tr>

<?php
}




// TABLE COLUMNS
add_filter("manage_edit-company_category_columns", 'metrodir_category_columns');
function metrodir_category_columns($category_columns) {
    $new_columns = array(
        'cb'        		=> '<input type="checkbox" />',
        'name'      		=> __('Name', 'ait'),
        'color'			    => __('Color', 'ait'),
        'icon' 				=> __('Icon', 'ait'),
        'image'			    => __('Image', 'ait'),
        'custom_icon'		=> __('Custom Icon', 'ait'),
        'custom_marker'		=> __('Custom Marker', 'ait'),
        'description'     	=> __('Description', 'ait'),
        'slug'      		=> __('Slug', 'ait'),
        'posts'     		=> __('Items', 'ait'),
    );
    return $new_columns;
}

add_filter("manage_company_category_custom_column", 'manage_metrodir_category_columns', 10, 3);
function manage_metrodir_category_columns($out, $column_name, $cat_id) {
    $color = get_option( 'metrodir_category_'.$cat_id.'_color', '' );
    $icon = get_option( 'metrodir_category_'.$cat_id.'_icon', '' );
    $image = get_option( 'metrodir_category_'.$cat_id.'_image', '' );
    $custom_icon = get_option( 'metrodir_category_'.$cat_id.'_icon_image', '' );
    $custom_marker = get_option( 'metrodir_category_'.$cat_id.'_marker_image', '' );

    switch ($column_name) {

        case 'color':
            if(!empty($color)){
                $out .= '<div style="margin: 10px 5px; width: 25px; height: 25px; background-color: '.$color.';"></div>';
            }
            break;
        case 'icon':
            if(!empty($icon)){
                $out .= '<i class="fa '.$icon.' fa-2x" style="margin: 12px 2px;"></i>';
            }
            break;
        case 'image':
            if(!empty($image)){
                $out .= '<div style="background: url('.$image.') center center no-repeat; background-size: cover; width: 40px; height: 40px; margin: 5px 0;"></div>';
            }
            break;
        case 'custom_icon':
            if(!empty($custom_icon)){
                $out .= '<div style="background: url('.$custom_icon.') center center no-repeat; background-size: cover; width: 40px; height: 40px; margin: 5px 0;"></div>';
            }
            break;
        case 'custom_marker':
            if(!empty($custom_marker)){
                $out .= '<div style="background: url('.$custom_marker.') center center no-repeat; background-size: cover; width: 40px; height: 40px; margin: 5px 0;"></div>';
            }
            break;
        default:
            break;
    }
    return $out;
}



add_action( 'created_company_category', 'save_metrodir_category', 10, 2);
add_action( 'edited_company_category', 'save_metrodir_category', 10, 2);
function save_metrodir_category($term_id) {
    if (!$term_id) return;

    if (isset($_POST['metrodir_category_color'])){
        $name = 'metrodir_category_' .$term_id. '_color';
        update_option( $name, $_POST['metrodir_category_color'] );
    }

    if (isset($_POST['metrodir_category_icon'])){
        $name = 'metrodir_category_' .$term_id. '_icon';
        update_option( $name, $_POST['metrodir_category_icon'] );
    }

    if (isset($_POST['metrodir_category_image'])){
        $name = 'metrodir_category_' .$term_id. '_image';
        update_option( $name, $_POST['metrodir_category_image'] );
    }

    if (isset($_POST['metrodir_category_icon_image'])){
        $name = 'metrodir_category_' .$term_id. '_icon_image';
        update_option( $name, $_POST['metrodir_category_icon_image'] );
    }

    if (isset($_POST['metrodir_category_marker_image'])){
        $name = 'metrodir_category_' .$term_id. '_marker_image';
        update_option( $name, $_POST['metrodir_category_marker_image'] );
    }

}

add_action( 'deleted_term_taxonomy', 'delete_metrodir_category' );
function delete_metrodir_category($id) {
    delete_option( 'metrodir_category_'.$id.'_color' );
    delete_option( 'metrodir_category_'.$id.'_icon' );
    delete_option( 'metrodir_category_'.$id.'_image' );
    delete_option( 'metrodir_category_'.$id.'_icon_image' );
    delete_option( 'metrodir_category_'.$id.'_marker_image' );
}

// company item options
$prefix = $shortname . "_";

global $current_user;
$current_user = wp_get_current_user();
if( isset( $current_user->roles ) && is_array( $current_user->roles ) && ( in_array('administrator', $current_user->roles)) ){
    $featured_caps = true;
}

$check_cand_role = $current_user->roles;
$cand_role_n = substr($check_cand_role[0],14);
$cand_role = "role".$cand_role_n;
if (isset($UouPlugins->acc->settings->$cand_role->caps->featured) AND $UouPlugins->acc->settings->$cand_role->caps->featured){
    $featured_caps = true;
}

if($featured_caps){
    $featured_checkbox =
        array(
            'name' => __('Featured Company', 'metrodir'),
            'id' => $prefix . 'featured',
            'type' => 'checkbox',
        );
}
// Field restrictions engine
$fldrestr_phone_check = uou_rstrflds_check('phone','be');
$fldrestr_founded_check = uou_rstrflds_check('founded','be');
$fldrestr_legal_check = uou_rstrflds_check('legal','be');
$fldrestr_turnover_check = uou_rstrflds_check('turnover','be');
$fldrestr_nempls_check = uou_rstrflds_check('nempls','be');
$fldrestr_fax_check = uou_rstrflds_check('fax','be');
$fldrestr_email_check = uou_rstrflds_check('email','be');
$fldrestr_website_check = uou_rstrflds_check('website','be');

$fldrestr_phone = uou_rstrflds_check_metabox($fldrestr_phone_check, 'Phone', 'doc_phone', 'Company phone');
$fldrestr_founded = uou_rstrflds_check_metabox($fldrestr_founded_check, 'Founded', 'doc_founded', 'Founded company');
$fldrestr_legal = uou_rstrflds_check_metabox($fldrestr_legal_check, 'Legal Entity', 'doc_legal', '');
$fldrestr_turnover = uou_rstrflds_check_metabox($fldrestr_turnover_check, 'Turnover', 'doc_turnover', '');
$fldrestr_nempls = uou_rstrflds_check_metabox($fldrestr_nempls_check, 'Number of Employees', 'doc_empl', '');
$fldrestr_fax = uou_rstrflds_check_metabox($fldrestr_fax_check, 'Fax', 'soc_fax', '');
$fldrestr_email = uou_rstrflds_check_metabox($fldrestr_email_check, 'E-mail', 'soc_email', '');
$fldrestr_website = uou_rstrflds_check_metabox($fldrestr_website_check, 'Website', 'soc_web', '');

// generate meta_box options
$metaBoxes['company'] =
array
(
    'id' => 'company-options',
    'title' => __('Options', 'metrodir'),
    'pages' => array('company'),
    'context' => 'normal',
    'priority' => 'low',
    'fields_group' => array(
        array(
            'id' => 'company',
            'title' => 'Company info',
            'marker' => 'fa-map-marker',
            'fields' => array(

            $featured_checkbox,

            array(
                'name' => __('Welcome text', 'metrodir'),
                'id' => $prefix . 'wlctext_name',
                'type' => 'text',
                'desc' => __('Welcome text company', 'metrodir')
            ),
            array(
                'name' => __('Description', 'metrodir'),
                'id' => $prefix . 'company_doc_desc',
                'type' => 'textarea',
                'std' => '',
                'desc' => __('Description company.', 'metrodir')
            ),
            array(
                'name' => __('Company Image', 'metrodir' ),
                'id' => $prefix . 'company_image1_url',
                'type' => 'attach_link_img',
                'desc' => __('Add company image.', 'metrodir' )
            ),
            array(
                'name' => __('Social facebook', 'metrodir'),
                'id' => $prefix . 'company_soc_fb',
                'type' => 'text',
                'desc' => __('', 'metrodir')
            ),
            array(
                'name' => __('Social twitter', 'metrodir'),
                'id' => $prefix . 'company_soc_tw',
                'type' => 'text',
                'desc' => __('', 'metrodir')
            ),
            array(
                'name' => __('Social Google+', 'metrodir'),
                'id' => $prefix . 'company_soc_gp',
                'type' => 'text',
                'desc' => __('', 'metrodir')
            ),
            array(
                'name' => __('Social Linkedin', 'metrodir'),
                'id' => $prefix . 'company_soc_li',
                'type' => 'text',
                'desc' => __('', 'metrodir')
            ),
            array(
                'name' => __('Social Pinterest', 'metrodir'),
                'id' => $prefix . 'company_soc_pt',
                'type' => 'text',
                'desc' => __('', 'metrodir')
            ),
            array(
                'name' => __('Social Dribbble', 'metrodir'),
                'id' => $prefix . 'company_soc_dr',
                'type' => 'text',
                'desc' => __('', 'metrodir')
            ),
            array(
                'name' => __('Address company', 'metrodir'),
                'id' => $prefix . 'address_country_name',
                'type' => 'text',
                'desc' => __('Country', 'metrodir')
            ),
            array(
                'name' => __(' ', 'metrodir'),
                'id' => $prefix . 'address_region_name',
                'type' => 'text',
                'desc' => __('Region', 'metrodir')
            ),
            array(
                'name' => __('  ', 'metrodir'),
                'id' => $prefix . 'address_name',
                'type' => 'text',
                'desc' => __('Address', 'metrodir')
            ),
            array(
                'name' => __('  ', 'metrodir'),
                'id' => $prefix . 'address_zip',
                'type' => 'text',
                'desc' => __('ZIP codes', 'metrodir')
            ),
            array(
                'type' => 'button-gps',
                'id' => "",
                'name' => __('  ', 'metrodir'),
            ),
            array(
                'name' => __('GPS coordinate (this field need to show marker on map)', 'metrodir'),
                'id' => $prefix . 'address_lat',
                'type' => 'text',
                'std' => '0',
                'desc' => __('Latitude', 'metrodir')
            ),
            array(
                'name' => __(' ', 'metrodir'),
                'id' => $prefix . 'address_lng',
                'type' => 'text',
                'std' => '0',
                'desc' => __('longitude', 'metrodir')
            ),
            array(
                'name' => __('Show Streetview instead of the map in detail', 'metrodir'),
                'id' => $prefix . 'shw_strv',
                'type' => 'select',
                'options' => array('Map', 'Streetview', 'Blank'),
                'desc' => __('', 'metrodir')
            ),
            $fldrestr_founded,
            $fldrestr_legal,
            $fldrestr_turnover,
            $fldrestr_nempls,
            $fldrestr_phone,
            $fldrestr_fax,
            $fldrestr_email,
            array(
                'name' => __('Email contact form', 'metrodir'),
                'id' => $prefix . 'company_soc_email_form',
                'type' => 'select',
                'options' => array('Hide', 'Display'),
                'desc' => __('Contact form display on single company page', 'metrodir')
            ),
            array(
                'name' => __('Contact tabs', 'metrodir'),
                'id' => $prefix . 'company_contact_tabs_act',
                'type' => 'select',
                'options' => array('Hide', 'Display')
            ),
            $fldrestr_website,
            array(
                'name' => __('Range of Services tags', 'metrodir'),
                'id' => $prefix . 'company_tags',
                'type' => 'text',
                'desc' => __('(Separate by , )', 'metrodir')
            ),
            array(
                'name' => __('Opening Hours:', 'metrodir'),
                'id' => $prefix . 'company_soc_openhrs1',
                'type' => 'text',
                'desc' => __('1 interval, (days, hours !!Separate by , )', 'metrodir')
            ),
            array(
                'name' => __(' ', 'metrodir'),
                'id' => $prefix . 'company_soc_openhrs2',
                'type' => 'text',
                'desc' => __('2 interval', 'metrodir')
            ),
            array(
                'name' => __(' ', 'metrodir'),
                'id' => $prefix . 'company_soc_openhrs3',
                'type' => 'text',
                'desc' => __('3 interval', 'metrodir')
            ),
            array(
                'name' => __(' ', 'metrodir'),
                'id' => $prefix . 'company_soc_openhrs4',
                'type' => 'text',
                'desc' => __('4 interval', 'metrodir')
            )
        ),

        ),
        array(
            'id' => 'custom_fields_group',
            'title' => 'Custom Fields',
            'marker' => 'fa-indent',
            'fields' => array(
                array(
                    'name' => __('', 'metrodir'),
                    'id' => 'uou_custom_fields',
                    'type' => 'custom_fields',
                    'post_type' => 'product',
                    'desc' => __('For use need install and activate "WooCommerce" plugin. <a href="http://www.woothemes.com/woocommerce/">Install Plugin</a> ', 'metrodir')
                ),
            )
        ),
        array (
            'id' => 'portfolio',
            'title' => 'Portfolio',
            'marker' => 'fa-file',
            'fields' => array(
                array(
                    'name' => __('Activate portfolio tabs on site', 'metrodir'),
                    'id' => $prefix . 'company_portfolio_tabs_act',
                    'options' => array('Hide', 'Display'),
                    'type' => 'select'
                ),

                array(
                    'name' => __('Grid portfolio ', 'metrodir'),
                    'id' => $prefix . 'company_portfolio_grid',
                    'options' => array('1 column', '2 columns', '3 columns', '4 columns'),
                    'type' => 'select'
                ),

                array(
                    'name' => __('Gallery', 'metrodir'),
                    'id' => 'metrodir_company_gallery',
                    'type' => 'portfolio_image'
                )
            )
        ),
        array(
            'id' => 'events',
            'title' => 'Events',
            'marker' => 'fa-bell',
            'fields' => array(
                array(
                    'name' => __('Activate events tab on site', 'metrodir'),
                    'id' => $prefix . 'events_tabs_act',
                    'options' => array('Hide', 'Display'),
                    'type' => 'select',
                ),
                    array(
                        'name' => __('Events', 'metrodir'),
                        'id' => $prefix . 'event',
                        'type' => 'custom_post_item',
                        'post_type' => 'event',
                        'desc' => __('To use this feature you need install and activate the "Events Manager" plugin. <a href="themes.php?page=install-required-plugins">Install Required Plugins</a> ', 'metrodir')
                    )

            )
        ),
        array(
            'id' => 'post',
            'title' => 'Blog',
            'marker' => 'fa-pencil',
            'fields' => array(
                array(
                    'name' => __('Activate blog tab on site', 'metrodir'),
                    'id' => $prefix . 'blog_tabs_act',
                    'options' => array('Hide', 'Display'),
                    'type' => 'select'
                ),
                array(
                    'name' => __('Posts Display', 'metrodir'),
                    'id' => $prefix . 'blog_all_posts',
                    'options' => array('select', 'all'),
                    'type' => 'select'
                ),
                array(
                    'name' => __('Blog', 'metrodir'),
                    'id' => $prefix . 'blog',
                    'type' => 'custom_post_item',
                    'post_type' => 'post',
                    'desc' => ''
                )
            )
        ),
         array(
             'id' => 'products',
             'title' => 'Products/Services',
             'marker' => 'fa-suitcase',
             'fields' => array(
                 array(
                     'name' => __('Activate products/services tab on site', 'metrodir'),
                     'id' => $prefix . 'products_tabs_act',
                     'options' => array('Hide', 'Display'),
                     'type' => 'select',
                 ),
                 array(
                     'name' => __('Woocommerce cart', 'metrodir'),
                     'id' => $prefix . 'products_cart_act',
                     'options' => array('Hide', 'Display'),
                     'type' => 'select',
                 ),
                 array(
                     'name' => __('Products/Services', 'metrodir'),
                     'id' => $prefix . 'product',
                     'type' => 'custom_post_item',
                     'post_type' => 'product',
                     'desc' => __('For use need install and activate "WooCommerce" plugin. <a href="http://www.woothemes.com/woocommerce/">Install Plugin</a> ', 'metrodir')
                 )
             )
         ),
         array(
             'id' => 'customtab',
             'title' => 'Custom HTML tab',
             'marker' => 'fa-cog',
             'fields' => array(
                 array(
                     'name' => __('Activate custom tab', 'metrodir'),
                     'id' => $prefix . 'custom_tabs_act',
                     'options' => array('Hide', 'Display'),
                     'type' => 'select'
                 ),
                 array(
                     'name' => __('Title for custom tab', 'metrodir'),
                     'id' => $prefix . 'custom_tabs_title',
                     'type' => 'text',
                     'desc' => ''
                 ),
                 array(
                     'name' => __('Content for custom tab', 'metrodir'),
                     'id' => $prefix . 'custom_tabs_content',
                     'type' => 'textarea',
                     'desc' => 'HTML tags support'
                 )
            )
        )
    )

);
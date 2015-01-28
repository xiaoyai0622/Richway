<?php

class Menu_Fields_Attach {

    public function __construct() {
        add_action('init', array($this, 'menu_image_init'));
        add_filter('manage_nav-menus_columns', array($this, 'menu_image_nav_menu_manage_columns'), 11);
        add_action('save_post', array($this, 'menu_image_save_post_action'), 10, 1);

        add_action('init', array($this, 'menu_color_init'));
        add_filter('manage_nav-menus_columns', array($this, 'menu_color_nav_menu_manage_columns'), 11);
        add_action('save_post', array($this, 'menu_color_save_post_action'), 10, 1);

        add_action('init', array($this, 'menu_icon_init'));
        add_filter('manage_nav-menus_columns', array($this, 'menu_icon_nav_menu_manage_columns'), 11);
        add_action('save_post', array($this, 'menu_icon_save_post_action'), 10, 1);

        add_filter('wp_edit_nav_menu_walker', array($this, 'menu_custom_fields_edit_nav_menu_walker_filter'));
    }

    public function menu_image_init() {
        add_post_type_support( 'nav_menu_item', array( 'thumbnail' ) );
    }

    public function menu_color_init() {
        add_post_type_support( 'nav_menu_item', array( 'thumbnail' ) );
    }

    public function menu_icon_init() {
        add_post_type_support( 'nav_icon_item', array( 'thumbnail' ) );
    }

    public function menu_image_nav_menu_manage_columns( $columns ) {
        return $columns + array( 'image' => __( 'Image', 'metrodir' ) );
    }

    public function menu_color_nav_menu_manage_columns( $columns ) {
        return $columns + array( 'text' => __( 'Color', 'metrodir' ) );
    }

    public function menu_icon_nav_menu_manage_columns( $columns ) {
        return $columns + array( 'text' => __( 'Icon', 'metrodir' ) );
    }

    public function menu_image_save_post_action( $post_id ) {

        if (! empty( $_FILES["menu-item-image_$post_id"] ) ) {

            require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
            require_once( ABSPATH . "wp-admin" . '/includes/file.php' );
            require_once( ABSPATH . "wp-admin" . '/includes/media.php' );

            $movefile = wp_handle_upload( $_FILES["menu-item-image_$post_id"], array( 'test_form' => false ) );
            if ($movefile["url"]) update_post_meta( $post_id, "menu-item-image", esc_sql($movefile["url"]) );

        }

        if ( isset( $_POST['menu_item_remove_image'][$post_id] ) && ! empty( $_POST['menu_item_remove_image'][$post_id] ) ) {

            update_post_meta( $post_id, "menu-item-image", '' );

            $args = array(
                'post_type'   => 'attachment',
                'post_status' => NULL,
                'post_parent' => $post_id,
            );

            $attachments = get_posts( $args );
            if ( $attachments ) {
                foreach ( $attachments as $attachment ) {
                    wp_delete_attachment( $attachment->ID );
                }
            }
        }

    }

    public function menu_color_save_post_action( $post_id ) {
        if ( ! empty( $_POST["menu-item-color"][$post_id] ) ) {
            update_post_meta( $post_id, "menu-item-color", esc_sql( $_POST["menu-item-color"][$post_id] ) );
        } else {
            update_post_meta( $post_id, "menu-item-color", '' );
        }
    }

    public function menu_icon_save_post_action( $post_id ) {
        if ( ! empty( $_POST["menu-item-icon"][$post_id] ) ) {
            update_post_meta( $post_id, "menu-item-icon", esc_sql( $_POST["menu-item-icon"][$post_id] ) );
        } else {
            update_post_meta( $post_id, "menu-item-icon", '' );
        }
    }

    public function menu_custom_fields_edit_nav_menu_walker_filter() {
        return 'Custom_Field_Walker_Nav_Menu_Edit';
    }

}

$menu_fields = new Menu_Fields_Attach();

require_once(ABSPATH . 'wp-admin/includes/nav-menu.php');
class Custom_Field_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit {

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $_wp_nav_menu_max_depth;
        $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

        ob_start();
        $item_id = esc_attr( $item->ID );
        $removed_args = array(
            'action',
            'customlink-tab',
            'edit-menu-item',
            'menu-item',
            'page-tab',
            '_wpnonce',
        );

        $original_title = '';
        if ( 'taxonomy' == $item->type ) {
            $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
            if ( is_wp_error( $original_title ) )
                $original_title = false;
        } elseif ( 'post_type' == $item->type ) {
            $original_object = get_post( $item->object_id );
            $original_title = get_the_title( $original_object->ID );
        }

        $classes = array(
            'menu-item menu-item-depth-' . $depth,
            'menu-item-' . esc_attr( $item->object ),
            'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
        );

        $title = $item->title;

        if ( ! empty( $item->_invalid ) ) {
            $classes[] = 'menu-item-invalid';
            /* translators: %s: title of menu item which is invalid */
            $title = sprintf( __('%s (Invalid)', 'metrodir'), $item->title );
        } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
            $classes[] = 'pending';
            /* translators: %s: title of menu item in draft status */
            $title = sprintf( __('%s (Pending)', 'metrodir'), $item->title );
        }

        $title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

        $submenu_text = '';
        if ( 0 == $depth )
            $submenu_text = 'style="display: none;"';

        ?>
    <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
    <dl class="menu-item-bar">
        <dt class="menu-item-handle">
            <span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo $submenu_text; ?>><?php _e('sub item', 'metrodir'); ?></span></span>
					<span class="item-controls">
						<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
						<span class="item-order hide-if-js">
							<a href="<?php
                            echo wp_nonce_url(
                                add_query_arg(
                                    array(
                                        'action' => 'move-up-menu-item',
                                        'menu-item' => $item_id,
                                    ),
                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                ),
                                'move-menu_item'
                            );
                            ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'metrodir'); ?>">&#8593;</abbr></a>
							|
							<a href="<?php
                            echo wp_nonce_url(
                                add_query_arg(
                                    array(
                                        'action' => 'move-down-menu-item',
                                        'menu-item' => $item_id,
                                    ),
                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                ),
                                'move-menu_item'
                            );
                            ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'metrodir'); ?>">&#8595;</abbr></a>
						</span>
						<a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item', 'metrodir'); ?>" href="<?php
                        echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                        ?>"><?php _e('Edit Menu Item', 'metrodir'); ?></a>
					</span>
        </dt>
    </dl>

    <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
    <?php if( 'custom' == $item->type ) : ?>
        <p class="field-url description description-wide">
            <label for="edit-menu-item-url-<?php echo $item_id; ?>">
                <?php _e('URL', 'metrodir'); ?><br />
                <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
            </label>
        </p>
    <?php endif; ?>
    <p class="description description-thin">
        <label for="edit-menu-item-title-<?php echo $item_id; ?>">
            <?php _e('Navigation Label', 'metrodir'); ?><br />
            <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
        </label>
    </p>
    <p class="description description-thin">
        <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
            <?php _e('Title Attribute', 'metrodir'); ?><br />
            <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
        </label>
    </p>
    <p class="field-link-target description">
        <label for="edit-menu-item-target-<?php echo $item_id; ?>">
            <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
            <?php _e('Open link in a new window/tab', 'metrodir'); ?>
        </label>
    </p>
    <p class="field-css-classes description description-thin">
        <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
            <?php _e('CSS Classes (optional)', 'metrodir'); ?><br />
            <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
        </label>
    </p>
    <!-- Custom Color -->
    <p class="field-color description description-wide">
        <label for="edit-menu-item-color-<?php echo $item_id; ?>">
            <?php _e('Color', 'metrodir'); ?><br/>
            <?php $color = get_post_meta( $item_id, 'menu-item-color'); if (!$color) $color = get_option('opt_metrodir_color_second'); ?>
            <span style="display: block; position: relative; height: 36px; width: 36px; float: left; margin: -3px 6px -6px -3px;">
                        <span id="menu-item-color-<?php echo $item_id; ?>-colorSelector" style="display: block; position: relative; cursor: pointer; position: relative; top: 0; left: 0; width: 36px;height: 36px; background: url(<?php echo get_template_directory_uri().'/images/select.png'; ?>) center;">
                            <span style="display: block; position: absolute; top: 4px; left: 4px; width: 28px; height: 28px; background: <?php echo $color[0]; ?> url(<?php echo get_template_directory_uri().'/images/select.png'; ?>) center;"></span>
                        </span>
                    </span>
            <input maxlength="7" size="7" type="text" id="edit-menu-item-color-<?php echo $item_id; ?>" class="menu-item-color[<?php echo $item_id; ?>]" name="menu-item-color[<?php echo $item_id; ?>]" value="<?php echo $color[0]; ?>" style="width: 37%" placeholder="#FFFFFF"/>
        </label>
    </p>
    <?php echo '<script type="text/javascript"> var $ = jQuery.noConflict();'; ?>
    <?php echo '$(document).ready(function() {
                        $("#menu-item-color-'.$item_id.'-colorSelector").ColorPicker({
                            onShow: function (colpkr) {
                                $(colpkr).fadeIn(500);
                                return false;
                            },
                            onHide: function (colpkr) {
                                $(colpkr).fadeOut(500);
                                return false;
                            },
                            onBeforeShow: function () {
                                $(this).ColorPickerSetColor($("#edit-menu-item-color-'.$item_id.'").val());
                            },
                            onChange: function (hsb, hex, rgb) {
                                $("#edit-menu-item-color-'.$item_id.'").val(\'#\' + hex);
                                $("#menu-item-color-'.$item_id.'-colorSelector > span").css(\'background-color\', \'#\' + hex);
                            }
                        });
                    });'; ?>
    <?php echo '</script>'; ?>
    <!-- Custom Icon -->
    <p class="field-color description description-wide">
        <label for="edit-menu-item-icon-<?php echo $item_id; ?>">
            <?php _e('Icon', 'metrodir'); ?><br />
            <?php $icon_mass = get_post_meta( $item_id, 'menu-item-icon'); $icon = $icon_mass[0]; ?>
            <i class="fa <?php echo $icon; ?> fa-lg" style="color: black; margin: 1px 10px 1px 1px; padding: 1px; width: 24px; height: 24px; text-align: center; line-height: 26px; display: block; float: left; border: 1px solid #d1e5ee; border-radius: 3px;"></i>
            <select id="edit-menu-item-icon-<?php echo $item_id; ?>" name="menu-item-icon[<?php echo $item_id; ?>]" onchange="jQuery(document).ready(function() { loadmenuicon('#edit-menu-item-icon-<?php echo $item_id; ?>'); });" style="width: 39%">
                <option value=""<?php if($icon == "") echo ' selected' ?>>None</option>
                <option value="fa-link"<?php if($icon == "fa-link") echo ' selected' ?>>Default</option>
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
        </label>
    </p>
    <!-- Custom Image -->
    <p class="field-image description description-wide">
        <?php $image_mass = get_post_meta( $item_id, 'menu-item-image'); $image = $image_mass[0]; if (has_post_thumbnail($item_id)): ?>
            <?php print get_the_post_thumbnail( $item_id, array(100,100) ); ?><br/>
            <label>
                <?php _e("Remove both images", 'metrodir'); ?>
                <input type="checkbox" name="menu_item_remove_image[<?php echo $item_id; ?>]"/>
            </label>
        <?php elseif ($image): ?>
            <label>
                <?php echo '<span class="description" style=" display: block; height: 100px; width: 100px; background-image: url('.$image.'); background-size: cover; background-position: center center; background-repeat: no-repeat;"></span>'; ?><br/>
                <?php _e("Remove both images", 'metrodir'); ?>
                <input type="checkbox" name="menu_item_remove_image[<?php echo $item_id; ?>]"/>
            </label>
        <?php else: ?>
            <label for="edit-menu-item-image-<?php echo $item_id; ?>">
                <?php _e('Image', 'metrodir'); ?><br/>
                <input type="file" name="menu-item-image_<?php echo $item_id; ?>" id="edit-menu-item-image-<?php echo $item_id; ?>"/>
            </label>
        <?php endif; ?>
    </p>
    <p class="field-xfn description description-thin">
        <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
            <?php _e('Link Relationship (XFN)', 'metrodir'); ?><br />
            <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
        </label>
    </p>
    <p class="field-description description description-wide">
        <label for="edit-menu-item-description-<?php echo $item_id; ?>">
            <?php _e('Description', 'metrodir'); ?><br />
            <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
            <span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.', 'metrodir'); ?></span>
        </label>
    </p>

    <p class="field-move hide-if-no-js description description-wide">
        <label>
            <span><?php _e('Move', 'metrodir'); ?></span>
            <a href="#" class="menus-move-up"><?php _e('Up one', 'metrodir'); ?></a>
            <a href="#" class="menus-move-down"><?php _e('Down one', 'metrodir'); ?></a>
            <a href="#" class="menus-move-left"></a>
            <a href="#" class="menus-move-right"></a>
            <a href="#" class="menus-move-top"><?php _e('To the top', 'metrodir'); ?></a>
        </label>
    </p>

    <div class="menu-item-actions description-wide submitbox">
        <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
            <p class="link-to-original">
                <?php printf( __('Original: %s', 'metrodir'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
            </p>
        <?php endif; ?>
        <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
        echo wp_nonce_url(
            add_query_arg(
                array(
                    'action' => 'delete-menu-item',
                    'menu-item' => $item_id,
                ),
                admin_url( 'nav-menus.php' )
            ),
            'delete-menu_item_' . $item_id
        ); ?>"><?php _e('Remove', 'metrodir'); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
        ?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel', 'metrodir'); ?></a>
    </div>

    <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
    <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
    <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
    <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
    <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
    <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
    </div><!-- .menu-item-settings-->
    <ul class="menu-item-transport"></ul>
        <?php
        $output .= ob_get_clean();
    }
}

class header_one_uou_nav_menu extends Walker_Nav_Menu {

// add main/sub classes to li's and links
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

        // depth dependent classes
        $depth_classes = array(
            ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
            ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
            ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

        // passed classes
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

        // build html
        $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

        //Get custom fields content
        $image_url = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID, array(150,150)));
        if (!$image_url) $image_url = get_post_meta( $item->ID, 'menu-item-image');
        $color = get_post_meta( $item->ID, 'menu-item-color');
        $icon = get_post_meta( $item->ID, 'menu-item-icon');

        // $image_url[0] -- image path; $color[0] -- color; $icon[0] -- icon.

        if (isset($attributes) AND !empty($attributes)) {
            $item_output = '';
            if (isset($args->before)) $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            if ($depth > 0) {
                if (isset($icon[0]) AND $icon[0]) {
                    $icon[0] = '<div class="menu-image"><i class="fa '.$icon[0].'"></i></div>';
                    $item_output .= $icon[0].'<div class="menu-text">'. apply_filters( 'the_title', $item->title, $item->ID ) .'</div>';
                } else {
                    $item_output .= apply_filters( 'the_title', $item->title, $item->ID );
                }
            } else {
                if (isset($image_url[0]) AND $image_url[0]) {
                    $image_url[0] = ' style="background-image: url('.$image_url[0].');"';
                    $item_output .= '<div class="menu-image opacity"'.$image_url[0].'></div><div class="menu-text image">'. apply_filters( 'the_title', $item->title, $item->ID ) .'</div>';
                } else {
                    if (isset($color[0]) AND $color[0]) $color[0] = 'style="background-color: '.$color[0].';"'; else $color[0] = '';
                    if (isset($icon[0]) AND $icon[0]) $icon_fa = $icon[0]; else  $icon_fa = 'fa-link';
                    $item_output .= '<div class="menu-image"><i class="fa '.$icon_fa.' fa-2x" '.$color[0].'></i></div><div class="menu-text">'. apply_filters( 'the_title', $item->title, $item->ID ) .'</div>';
                }
            }
            $item_output .= '</a>';
            if (isset($args->after)) $item_output .= $args->after;
        } else {
            $item_output ='';
        }


        // build html
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

class header_two_uou_nav_menu extends Walker_Nav_Menu {

// add main/sub classes to li's and links
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

        // depth dependent classes
        $depth_classes = array(
            ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
            ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
            ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

        // passed classes
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

        // build html
        $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

        $attributes = ! empty( $item->attr_title ) ? ' class="' . esc_attr( $item->attr_title ) . '"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

        //Get custom fields content
        $image_url = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID, array(150,150)));
        $color = get_post_meta( $item->ID, 'menu-item-color');
        $icon = get_post_meta( $item->ID, 'menu-item-icon');

        // $image_url[0] -- image path; $color[0] -- color; $icon[0] -- icon.

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;


        // build html
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}
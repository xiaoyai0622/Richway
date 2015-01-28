<?php

add_action( 'wp_ajax_nopriv_action_item_claim', 'uouClaimAdd' );
add_action( 'wp_ajax_action_item_claim', 'uouClaimAdd' );

// Add New Post Type For Claim
function metrodir_claim_posttype() {
    global $shortname;
    register_post_type( 'claim',
        array(
            'labels' => array(
                'name' => __( 'Claims Listing', 'metrodir'),
                'singular_name' => __( 'Claim', 'metrodir'),
                'add_new' => __( 'Add New claim', 'metrodir'),
                'add_new_item' => __( 'Add New claim', 'metrodir'),
                'edit_item' => __( 'Edit claim', 'metrodir'),
                'new_item' => __( 'Add New claim', 'metrodir'),
                'view_item' => __( 'View claim', 'metrodir'),
                'search_items' => __( 'Search claim',  'metrodir'),
                'not_found' => __( 'No claim items found',  'metrodir'),
                'not_found_in_trash' => __( 'No claim items found in trash', 'metrodir')
            ),
            'public' => true,
            'supports' => array( 'title', 'thumbnail'),
            'taxonomies' => array('claim_category'),
            'capability_type' => 'post',
            'rewrite' => array("slug" => "claim"),
            'menu_position' => 29
        )
    );
}

add_action('init', 'metrodir_claim_posttype');

// Set as many image sizes as you want
add_filter("manage_edit-claim_columns", "claim_edit_columns");
add_action("manage_posts_custom_column",  "claim_columns_display", 10, 2);
add_action('admin_notices','ClaimNotice');
function claim_edit_columns($stars_columns){
    global $shortname;
    $stars_columns = array(
        "cb" => "<input type=\"checkbox\" />",
        'claim-approve'  => __( 'Action', 'metrodir'),
        'claim-name'         => __( 'Name', 'metrodir'),
        'claim-comm'         => __( 'Message', 'metrodir'),
        'claim-post-id'=> __( 'Claim for company', 'metrodir'),
        'claim-email'  => __( 'E-Mail', 'metrodir'),
        'date'          => __( 'Date', 'metrodir')
    );
    return $stars_columns;
}


add_action( 'admin_head', 'claimRemoveAddButton' );
function claimRemoveAddButton() {
    remove_submenu_page('edit.php?post_type=claim','post-new.php?post_type=claim');
    if((strpos($_SERVER['PHP_SELF'],'edit.php') !== false) && isset($_GET['post_type']) && ($_GET['post_type'] == 'claim')){
        echo '<style type="text/css">
                     a.add-new-h2 { display: none !important; }
                 </style>';
    }
}


function claim_columns_display($stars_columns, $claimId){

    switch ($stars_columns) {

        case "claim-name":
            $post = get_post( $claimId );
            echo $post->post_title;
            break;
        case "claim-post-id":
            $postId = get_post_meta( $claimId, 'item_id', true );
            $postLink = get_permalink( $postId );
            $post = get_post( $postId );
            echo '<a href="'.$postLink.'" target="_blank">'.$post->post_title.'</a>';

            break;
        case "claim-email":
            $val = get_post_meta( $claimId, 'email', true );
            echo $val;
            break;
        case "claim-comm":
            $val = get_post_meta( $claimId, 'comm', true );
            echo $val;
            break;
        case "claim-approve":
            $val = get_post_meta( $claimId, 'status', true );
            if ($val == 'approved') {
                echo '<div style=color:green;>'.__( 'Approved', 'metrodir').'</div>';
            } else {
                echo '<a href="'.admin_url('edit.php?post_type=claim&claim-post-id='.$claimId).'&claim-approve=approve" class="button">'.__( 'Approve and register user', 'metrodir').'</a>';
            }
            break;
    }

}

require_once metrodir_SKL . '/functions/accounts.php';
if (isset($_GET['claim-approve']) && !empty($_GET['claim-post-id'])) {
    ApproveClaim(intval($_GET['claim-post-id']));
}


function uouClaimAdd() {
    if(isset($_POST['post_id']) && isset($_POST['claim_name']) && isset($_POST['claim_email']) && isset($_POST['claim_login'])){

        $nonce = $_POST['nonce'];
        if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
            echo "nonce";
            exit();
        }

        // check login and email if exist
        if (username_exists( $_POST['claim_login'] )) {
            echo ' <div class="message error">
                        <div class="notification-error">
                            <div class="notification-inner">'.__( 'This username is already registered!', 'metrodir').'</div>
                        </div>
                     </div>';
            exit();
        }
        if (email_exists( $_POST['claim_email'] )) {
            echo ' <div class="message error">
                        <div class="notification-error">
                            <div class="notification-inner">'.__( 'This email is already registered!', 'metrodir').'</div>
                        </div>
                    </div>';
            exit();
        }

        $claim_att = array(
            'post_title'     => $_POST['claim_login'],
            'post_content'   => $_POST['claim_comm'],
            'post_type'      => 'claim',
            'post_status'    => 'publish',
            'comment_status' => 'closed',
            'ping_status'    => 'closed'
        );
        $claimId = wp_insert_post( $claim_att );
        if($claimId == 0) return 0;

        update_post_meta( $claimId, 'item_id' , $_POST['post_id'] );
        update_post_meta( $claimId, 'comm' , $_POST['claim_comm'] );
        update_post_meta( $claimId, 'username' , $_POST['claim_login'] );
        update_post_meta( $claimId, 'name' , $_POST['claim_name'] );
        update_post_meta( $claimId, 'email' , $_POST['claim_email'] );
        update_post_meta( $claimId, 'status' , 'new' );
        echo '                       <div class="message success">
                            <div class="notification-success">
                                <div class="notification-inner">'.__( 'Claim has been sent!', 'metrodir').'</div>
                            </div>
                        </div>';

    } else {
        echo '                       <div class="message error">
                            <div class="notification-error">
                                <div class="notification-inner">'.__( 'Error!', 'metrodir').'</div>
                            </div>
                        </div>';
    }
    exit();
}



function ApproveClaim($claimId) {

    global $claimMsg, $UouPlugins;

    $username = get_post_meta( $claimId, 'username', true );
    $email = get_post_meta( $claimId, 'email', true );
    $itemId = intval(get_post_meta( $claimId, 'item_id', true ));

    // Register
    $userId = metrodir_register_users($username,$email);

    if(is_wp_error( $userId )){
        $claimMsg = $userId->get_error_message();
    } else {

        // Set Role
        $role = (isset($UouPlugins->claim->role)) ? $UouPlugins->claim->role : "metrodir_role_1";
        $user = get_userdata( $userId );
        $user->set_role( $role );
        set_activation_time( $userId, $role );

        // Change Item to Author
        $item = get_post($itemId,'ARRAY_A');
        $itemUpdated = $item;
        $itemUpdated['post_author'] = $userId;

        $chStatus = wp_insert_post( $itemUpdated, true );
        if(is_wp_error( $chStatus )){
            $claimMsg = $chStatus->get_error_message();
        } else {
            // change status
            update_post_meta($claimId, 'status', 'approved');
            $claimMsg = __( 'Claim was approved! New user was registered and assignated to Item. Email with generated password was sent.', 'metrodir');
        }

    }

}

function ClaimNotice() {
    global $claimMsg;
    if(isset($claimMsg)){
        echo '<div class="updated"><p>'.$claimMsg.'</p></div>';
    }
}
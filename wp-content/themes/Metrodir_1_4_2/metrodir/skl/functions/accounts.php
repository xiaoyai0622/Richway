<?php
global $UouPlugins;
// Payment gateway (uou_payments) v.0.5
$opt_metrodir_pp_type =  get_option('opt_metrodir_pp_type');

$account[1][6] = $UouPlugins->acc->settings->role1->caps->maxcompany;
$account[1][7] = $UouPlugins->acc->settings->role1->caps->maxpost;
$account[1][8] = $UouPlugins->acc->settings->role1->caps->maxevent;
$account[1][9] = $UouPlugins->acc->settings->role1->caps->maxproduct;
$account[2][6] = $UouPlugins->acc->settings->role2->caps->maxcompany;
$account[2][7] = $UouPlugins->acc->settings->role2->caps->maxpost;
$account[2][8] = $UouPlugins->acc->settings->role2->caps->maxevent;
$account[2][9] = $UouPlugins->acc->settings->role2->caps->maxproduct;
$account[3][6] = $UouPlugins->acc->settings->role3->caps->maxcompany;
$account[3][7] = $UouPlugins->acc->settings->role3->caps->maxpost;
$account[3][8] = $UouPlugins->acc->settings->role3->caps->maxevent;
$account[3][9] = $UouPlugins->acc->settings->role3->caps->maxproduct;
$account[4][6] = $UouPlugins->acc->settings->role4->caps->maxcompany;
$account[4][7] = $UouPlugins->acc->settings->role4->caps->maxpost;
$account[4][8] = $UouPlugins->acc->settings->role4->caps->maxevent;
$account[4][9] = $UouPlugins->acc->settings->role4->caps->maxproduct;

// admin customization
add_action( 'admin_init', 'metrodir_reg_roles');
add_action( 'init', 'item_remove_field');
add_action( 'pre_get_posts', 'shw_att_role');
add_filter( 'manage_users_columns', 'metrodir_Users_Show_Details');
add_filter( 'manage_users_custom_column', 'shw_extr_data', 10, 3);
add_filter( 'pre_get_posts', 'shw_auth_items');
add_filter( 'views_edit-company', 'items_table_views');
add_filter( 'admin_notices', 'admin_notices' );

// require func
require_once dirname(__FILE__) . '/class-paypal.php';
require_once dirname(__FILE__) . '/accounts-reg.php';

function metrodir_reg_roles() {

    global $current_user, $account, $UouPlugins;

	// capability
	$capabilitiesAdmin = array(
        "edit_company" => true,
        "read_company" => true,
        "delete_company" => true,
        "publish_companys" => true,
        "edit_published_companys" => true,
        "edit_private_companys" => true,
        "read_private_companys" => true,
        "delete_private_companys" => true,
        "delete_published_companys" => true,
        "edit_events" => false,
        "publish_events" => false,
        "delete_events" => false,
        "edit_locations" => false,
        "publish_locations" => false,
        "delete_locations" => false,
        "edit_published_events" => true,
        "edit_others_companys" => true,
        "delete_companys" => true,
        "delete_others_companys" => true,
        "assign_company_category" => true,
        "upload_files" => true,
        "metrodir_account_upgrade" => false
	);

	// set admin capability
	$adminRole = get_role( 'administrator' );
	foreach ($capabilitiesAdmin as $key => $value) {
		$adminRole->add_cap( $key );
	}

	$subscriberRole = get_role( 'subscriber' );
	$subscriberRole->add_cap( 'metrodir_account_upgrade' );

	// update user roles by adminpanel
    if(isset($_GET['page']) && $_GET['page'] == 'siteoptions-plugins'){

        $opt_metrodir_acc_1_active = $UouPlugins->acc->settings->role1->on;
        $opt_metrodir_acc_1_name = $UouPlugins->acc->settings->role1->name;
        $opt_metrodir_acc_1_approve = $UouPlugins->acc->settings->role1->caps->approve;
        $opt_metrodir_acc_2_active = $UouPlugins->acc->settings->role2->on;
        $opt_metrodir_acc_2_name = $UouPlugins->acc->settings->role2->name;
        $opt_metrodir_acc_2_approve = $UouPlugins->acc->settings->role1->caps->approve;
        $opt_metrodir_acc_3_active = $UouPlugins->acc->settings->role3->on;
        $opt_metrodir_acc_3_name = $UouPlugins->acc->settings->role3->name;
        $opt_metrodir_acc_3_approve = $UouPlugins->acc->settings->role1->caps->approve;
        $opt_metrodir_acc_4_active = $UouPlugins->acc->settings->role4->on;
        $opt_metrodir_acc_4_name = $UouPlugins->acc->settings->role4->name;
        $opt_metrodir_acc_4_approve = $UouPlugins->acc->settings->role1->caps->approve;

        $prefixName = '';

        $capabilitiesmetrodir = array(
            "edit_companys" => true,
            "edit_company" => true,
            "read_private_companys" => false,
            "edit_published_companys" => true,
            "edit_published_posts" => true,
            "edit_published_events" => true,
            "edit_published_products" => true,
            "delete_companys" => false,
            "delete_published_companys" => false,
            "assign_company_category" => true,
            "read" => true,
            "upload_files" => true,
            "metrodir_account_upgrade" => true
        );

        if(isset($opt_metrodir_acc_1_active)){
            remove_role( 'metrodir_role_1' );
            $caps = $capabilitiesmetrodir;

            if ($opt_metrodir_acc_1_approve == "enable") {
                $caps["publish_companys"] = false;
                $caps["publish_posts"] = false;
                $caps["publish_products"] = false;
                $caps["publish_events"] = false;
            } else {
                $caps["publish_companys"] = true;
                $caps["publish_posts"] = true;
                $caps["publish_products"] = true;
                $caps["publish_events"] = true;
            }
            $caps["publish_locations"] = true;
            $caps["edit_posts"] = true;
            $caps["edit_products"] = true;
            $caps["edit_events"] = true;
            $caps["edit_locations"] = true;

            add_role( 'metrodir_role_1', $prefixName . $opt_metrodir_acc_1_name, $caps);
        } else {
            remove_role( 'metrodir_role_1' );
        }

        if(isset($opt_metrodir_acc_2_active)){
            remove_role( 'metrodir_role_2' );
            $caps = $capabilitiesmetrodir;

            if ($opt_metrodir_acc_2_approve == "enable") {
                $caps["publish_companys"] = false;
                $caps["publish_posts"] = false;
                $caps["publish_products"] = false;
                $caps["publish_events"] = false;
            } else {
                $caps["publish_companys"] = true;
                $caps["publish_posts"] = true;
                $caps["publish_products"] = true;
                $caps["publish_events"] = true;
            }
            $caps["publish_locations"] = true;
            $caps["edit_posts"] = true;
            $caps["edit_products"] = true;
            $caps["edit_events"] = true;
            $caps["edit_locations"] = true;

            add_role( 'metrodir_role_2', $prefixName . $opt_metrodir_acc_2_name, $caps);
        } else {
            remove_role( 'metrodir_role_2' );
        }

        if(isset($opt_metrodir_acc_3_active)){
            remove_role( 'metrodir_role_3' );
            $caps = $capabilitiesmetrodir;

            if ($opt_metrodir_acc_3_approve == "enable") {
                $caps["publish_companys"] = false;
                $caps["publish_posts"] = false;
                $caps["publish_products"] = false;
                $caps["publish_events"] = false;
            } else {
                $caps["publish_companys"] = true;
                $caps["publish_posts"] = true;
                $caps["publish_products"] = true;
                $caps["publish_events"] = true;
            }
            $caps["publish_locations"] = true;
            $caps["edit_posts"] = true;
            $caps["edit_products"] = true;
            $caps["edit_events"] = true;
            $caps["edit_locations"] = true;

            add_role( 'metrodir_role_3', $prefixName . $opt_metrodir_acc_3_name, $caps);
        } else {
            remove_role( 'metrodir_role_3' );
        }

        if(isset($opt_metrodir_acc_4_active)){
            remove_role( 'metrodir_role_4' );
            $caps = $capabilitiesmetrodir;

            if ($opt_metrodir_acc_4_approve == "enable") {
                $caps["publish_companys"] = false;
                $caps["publish_posts"] = false;
                $caps["publish_products"] = false;
                $caps["publish_events"] = false;
            } else {
                $caps["publish_companys"] = true;
                $caps["publish_posts"] = true;
                $caps["publish_products"] = true;
                $caps["publish_events"] = true;
            }
            $caps["publish_locations"] = true;
            $caps["edit_posts"] = true;
            $caps["edit_products"] = true;
            $caps["edit_events"] = true;
            $caps["edit_locations"] = true;

            add_role( 'metrodir_role_4', $prefixName . $opt_metrodir_acc_4_name, $caps);
        } else {
            remove_role( 'metrodir_role_4' );
        }
	}


	// check max items user
	$usrRoles = $current_user->roles;
	if (ismetrodirUser()) {
		if((strpos($_SERVER['PHP_SELF'],'post-new.php') !== false) && isset($_GET['post_type']) && ($_GET['post_type'] == 'company')){
			$params = array(
				'post_type'			=> 'company',
				'nopaging'			=> true,
				'author'			=> $current_user->ID
			);
			$itemsQuery = new WP_Query();
			$items = $itemsQuery->query($params);

			$redirectUrl = admin_url('edit.php?post_type=company&notification_message=1');

            $redirectUrl_fbd =  admin_url('edit.php?post_type=company&notification_message=3');

			if(in_array('metrodir_role_1', $usrRoles)){
                if(count($items) >= intval($account[1][6]) AND intval($account[1][6]) != 0  AND intval($account[1][6]) != -1){
                    header('Location: ' . $redirectUrl);
                } elseif (intval($account[1][6]) == -1) {
                    header('Location: ' . $redirectUrl_fbd);
                }
			} elseif (in_array('metrodir_role_2', $usrRoles)) {
                if(count($items) >= intval($account[2][6]) AND intval($account[2][6]) != 0  AND intval($account[2][6]) != -1){
                    header('Location: ' . $redirectUrl);
                } elseif (intval($account[2][6]) == -1) {
                    header('Location: ' . $redirectUrl_fbd);
                }
			} elseif (in_array('metrodir_role_3', $usrRoles)) {
                if(count($items) >= intval($account[3][6]) AND intval($account[3][6]) != 0  AND intval($account[3][6]) != -1){
                    header('Location: ' . $redirectUrl);
                } elseif (intval($account[3][6]) == -1) {
                    header('Location: ' . $redirectUrl_fbd);
                }
			} elseif (in_array('metrodir_role_4', $usrRoles)) {
                if(count($items) >= intval($account[4][6]) AND intval($account[4][6]) != 0  AND intval($account[4][6]) != -1){
                    header('Location: ' . $redirectUrl);
                } elseif (intval($account[4][6]) == -1) {
                    header('Location: ' . $redirectUrl_fbd);
                }
            }

            $redirectUrl2 = admin_url('edit.php?post_type=company&notification_message=2');

            $expiresdays =  metrodir_get_days_left();
            if($expiresdays != 'Unlimited'){
                        if(in_array('metrodir_role_1', $usrRoles)){
                            if(intval($expiresdays) <= 0){
                                header('Location: ' . $redirectUrl2);
                            }
                        } elseif (in_array('metrodir_role_2', $usrRoles)) {
                            if(intval($expiresdays) <= 0){
                                header('Location: ' . $redirectUrl2);
                            }
                        } elseif (in_array('metrodir_role_3', $usrRoles)) {
                            if(intval($expiresdays) <= 0){
                                header('Location: ' . $redirectUrl2);
                            }
                        } elseif (in_array('metrodir_role_4', $usrRoles)) {
                            if(intval($expiresdays) <= 0){
                                header('Location: ' . $redirectUrl2);
                            }
                        }
            }
		}

        if((strpos($_SERVER['PHP_SELF'],'post-new.php') !== false) && isset($_GET['post_type']) && ($_GET['post_type'] == 'event')){
            $params_events = array(
                'post_type'   => 'event',
                'nopaging'   => true,
                'author'   => $current_user->ID
            );
            $postQuery = new WP_Query();
            $events = $postQuery->query($params_events);

            $redirectUrl4 = admin_url('edit.php?post_type=event&notification_message=1');

            $redirectUrl4_fbd =  admin_url('edit.php?post_type=event&notification_message=3');

            if(in_array('metrodir_role_1', $usrRoles)){
                if(count($events) >= intval($account[1][8]) AND intval($account[1][8]) != 0  AND intval($account[1][8]) != -1){
                    header('Location: ' . $redirectUrl4);
                } elseif (intval($account[1][8]) == -1) {
                    header('Location: ' . $redirectUrl4_fbd);
                }
            } elseif (in_array('metrodir_role_2', $usrRoles)) {
                if(count($events) >= intval($account[2][8]) AND intval($account[2][8]) != 0  AND intval($account[2][8]) != -1){
                    header('Location: ' . $redirectUrl4);
                } elseif (intval($account[2][8]) == -1) {
                    header('Location: ' . $redirectUrl4_fbd);
                }
            } elseif (in_array('metrodir_role_3', $usrRoles)) {
                if(count($events) >= intval($account[3][8]) AND intval($account[3][8]) != 0  AND intval($account[3][8]) != -1){
                    header('Location: ' . $redirectUrl4);
                } elseif (intval($account[3][8]) == -1) {
                    header('Location: ' . $redirectUrl4_fbd);
                }
            } elseif (in_array('metrodir_role_4', $usrRoles)) {
                if(count($events) >= intval($account[4][8]) AND intval($account[4][8]) != 0  AND intval($account[4][8]) != -1){
                    header('Location: ' . $redirectUrl4);
                } elseif (intval($account[4][8]) == -1) {
                    header('Location: ' . $redirectUrl4_fbd);
                }
            }
        }

        if((strpos($_SERVER['PHP_SELF'],'post-new.php') !== false) && isset($_GET['post_type']) && ($_GET['post_type'] == 'product')){
            $params_products = array(
                'post_type'   => 'product',
                'nopaging'   => true,
                'author'   => $current_user->ID
            );
            $postQuery = new WP_Query();
            $products = $postQuery->query($params_products);

            $redirectUrl5 = admin_url('edit.php?post_type=product&notification_message=1');

            $redirectUrl5_fbd =  admin_url('edit.php?post_type=product&notification_message=3');

            if(in_array('metrodir_role_1', $usrRoles)){

                if(count($products) >= intval($account[1][9]) AND intval($account[1][9]) != 0  AND intval($account[1][9]) != -1){
                    header('Location: ' . $redirectUrl5);
                } elseif (intval($account[1][9]) == -1) {
                    header('Location: ' . $redirectUrl5_fbd);
                }

            } elseif (in_array('metrodir_role_2', $usrRoles)) {

                if(count($products) >= intval($account[2][9]) AND intval($account[2][9]) != 0  AND intval($account[2][9]) != -1){
                    header('Location: ' . $redirectUrl5);
                } elseif (intval($account[2][9]) == -1) {
                    header('Location: ' . $redirectUrl5_fbd);
                }

            } elseif (in_array('metrodir_role_3', $usrRoles)) {

                if(count($products) >= intval($account[3][9]) AND intval($account[3][9]) != 0  AND intval($account[3][9]) != -1){
                    header('Location: ' . $redirectUrl5);
                } elseif (intval($account[3][9]) == -1) {
                    header('Location: ' . $redirectUrl5_fbd);
                }

            } elseif (in_array('metrodir_role_4', $usrRoles)) {

                if(count($products) >= intval($account[4][9]) AND intval($account[4][9]) != 0  AND intval($account[4][9]) != -1){
                    header('Location: ' . $redirectUrl5);
                } elseif (intval($account[4][9]) == -1) {
                    header('Location: ' . $redirectUrl5_fbd);
                }

            }
        }

        if (php_sapi_name() == 'cli') {
            $args = $_SERVER['argv'];
        } else {
            parse_str($_SERVER['QUERY_STRING'], $args);
        }

        if((strpos($_SERVER['PHP_SELF'],'post-new.php') !== false AND $args == null )){
            $params_post = array(
                'post_type'   => 'post',
                'nopaging'   => true,
                'author'   => $current_user->ID
            );
            $postQuery = new WP_Query();
            $post = $postQuery->query($params_post);

            $redirectUrl3 = admin_url('edit.php?notification_message=1');

            $redirectUrl3_fbd = admin_url('edit.php?notification_message=3');

            if(in_array('metrodir_role_1', $usrRoles)){
                if(count($post) >= intval($account[1][7]) AND intval($account[1][7]) != 0  AND intval($account[1][7]) != -1){
                    header('Location: ' . $redirectUrl3);
                } elseif (intval($account[1][7]) == -1) {
                    header('Location: ' . $redirectUrl3_fbd);
                }
            } elseif (in_array('metrodir_role_2', $usrRoles)) {
                if(count($post) >= intval($account[2][7]) AND intval($account[2][7]) != 0  AND intval($account[2][7]) != -1){
                    header('Location: ' . $redirectUrl3);
                } elseif (intval($account[2][7]) == -1) {
                    header('Location: ' . $redirectUrl3_fbd);
                }
            } elseif (in_array('metrodir_role_3', $usrRoles)) {
                if(count($post) >= intval($account[3][7]) AND intval($account[3][7]) != 0  AND intval($account[3][7]) != -1){
                    header('Location: ' . $redirectUrl3);
                } elseif (intval($account[3][7]) == -1) {
                    header('Location: ' . $redirectUrl3_fbd);
                }
            } elseif (in_array('metrodir_role_4', $usrRoles)) {
                if(count($post) >= intval($account[4][7]) AND intval($account[4][7]) != 0  AND intval($account[4][7]) != -1){
                    header('Location: ' . $redirectUrl3);
                } elseif (intval($account[4][7]) == -1) {
                    header('Location: ' . $redirectUrl3_fbd);
                }
            }
        }

        if((strpos($_SERVER['PHP_SELF'],'media-new.php') !== false)){

            $redirectUrl3 = admin_url('profile.php?notification_message=2');

            $expiresdays2 =  metrodir_get_days_left();
            if($expiresdays != 'Unlimited'){
                if(in_array('metrodir_role_1', $usrRoles)){
                    if($expiresdays2 <= 0){
                        header('Location: ' . $redirectUrl3);
                    }
                } elseif (in_array('metrodir_role_2', $usrRoles)) {
                    if($expiresdays2 <= 0){
                        header('Location: ' . $redirectUrl3);
                    }
                } elseif (in_array('metrodir_role_3', $usrRoles)) {
                    if($expiresdays2 <= 0){
                        header('Location: ' . $redirectUrl3);
                    }
                } elseif (in_array('metrodir_role_4', $usrRoles)) {
                    if($expiresdays2 <= 0){
                        header('Location: ' . $redirectUrl3);
                    }
                }
            }
        }

	}
}

/**
 * Show items only for roles
 */
function shw_auth_items($query) {
	if (ismetrodirUser()) {
		if((strpos($_SERVER['PHP_SELF'],'edit.php') !== false) && isset($_GET['post_type']) && ($_GET['post_type'] == 'company')){
			$query->set('author',$GLOBALS['current_user']->ID);
		}
	}
	return $query;
}

function items_table_views($views) {
	if (ismetrodirUser()) {
		global $wpdb;

		$user = wp_get_current_user();
		$type = 'company';

		$query = "SELECT post_status, COUNT( * ) AS num_posts FROM {$wpdb->posts} WHERE post_type = %s AND post_author = %d";
		$query .= ' GROUP BY post_status';

		$count = $wpdb->get_results( $wpdb->prepare( $query, $type, $user->ID ), ARRAY_A );

		$stats = array();
		foreach ( get_post_stati() as $state )
			$stats[$state] = 0;

		foreach ( (array) $count as $row )
			$stats[$row['post_status']] = $row['num_posts'];

		$stats = (object) $stats;

		global $locked_post_status, $avail_post_stati;

		$post_type = $type;

		if ( !empty($locked_post_status) )
			return array();

		$status_links = array();
		$num_posts = $stats;
		$class = '';
		$allposts = '';
		$total_posts = array_sum( (array) $num_posts );


		foreach ( get_post_stati( array('show_in_admin_all_list' => false) ) as $state )
			$total_posts -= $num_posts->$state;

		$class = empty( $class ) && empty( $_REQUEST['post_status'] ) && empty( $_REQUEST['show_sticky'] ) ? ' class="current"' : '';
		$status_links['all'] = "<a href='edit.php?post_type=$post_type{$allposts}'$class>" . sprintf( _nx( 'All <span class="count">(%s)</span>', 'All <span class="count">(%s)</span>', $total_posts, 'posts' , 'metrodir'), number_format_i18n( $total_posts ) ) . '</a>';

		foreach ( get_post_stati(array('show_in_admin_status_list' => true), 'objects') as $status ) {
			$class = '';

			$status_name = $status->name;

			if ( !in_array( $status_name, $avail_post_stati ) )
				continue;

			if ( empty( $num_posts->$status_name ) )
				continue;

			if ( isset($_REQUEST['post_status']) && $status_name == $_REQUEST['post_status'] )
				$class = ' class="current"';

			$status_links[$status_name] = "<a href='edit.php?post_status=$status_name&amp;post_type=$post_type'$class>" . sprintf( translate_nooped_plural( $status->label_count, $num_posts->$status_name ), number_format_i18n( $num_posts->$status_name ) ) . '</a>';
		}
		return $status_links;
	} else {
		return $views;
	}
}

/**
 * Show errormessage max items and expired
 */
function admin_notices() {
	global $registerMessages;

	if(isset($_GET['notification_message']) && $_GET['notification_message'] == '1'){
		echo '<div class="error"><p>'.__('You have maximum items for your account type. Upgrade your account to insert more items!','metrodir').'</p></div>';
	}
    if(isset($_GET['notification_message']) && $_GET['notification_message'] == '2'){
        echo '<div class="error"><p>'.__('Your account has expired. Upgrade your account.','metrodir').'</p></div>';
    }
    if(isset($_GET['notification_message']) && $_GET['notification_message'] == '3'){
        echo '<div class="error"><p>'.__('Forbidden to publish this post type. Please, upgrade your account.','metrodir').'</p></div>';
    }
	if(isset($registerMessages)){
		echo '<div class="updated"><p>'.$registerMessages.'</p></div>';
	}
}

function item_remove_field() {
	global $current_user;

	if (ismetrodirUser()) {
		$usrRoles = $current_user->roles;
		$roleNumber = substr(array_shift(array_values($usrRoles)), 12);
	}
}

function shw_att_role( $query ) {
	global $current_user, $pagenow;
	if (ismetrodirUser()) {
		if( 'upload.php' == $pagenow || 'admin-ajax.php' == $pagenow || 'media-upload.php' == $pagenow) {
			$query->set('author', $current_user->ID );
		}
	}
	return $query;
}

function metrodir_Users_Show_Details($columns) {
	$columns['items'] = __('User items','metrodir');
    $columns['activation_time'] = __('Activation time','metrodir');
    $columns['recurring_profile_id'] = __('PayPal Recurring Profile ID','metrodir');
    $columns['days_before_expiration'] = __('Expiry date','metrodir');
    $columns['transaction_id'] = __('Last PayPal transaction ID','metrodir');
	return $columns;
}


/**
 *  Display information
 **/

function shw_extr_data($empty='', $column_name, $id) {
    if( $column_name == 'items' ) {
		return metrodir_company_count($id);
	}
	if( $column_name == 'activation_time' ) {
		$data = get_user_meta( $id, 'metrodir_activation_time', true );
		if ($data) {
			$dateFormat = get_option( 'date_format', 'm/d/Y' );
			return date($dateFormat,$data['time']);
		}
	}
	if( $column_name == 'days_before_expiration' ) {
		$user = new WP_User($id);
		if (ismetrodirUser($user)) {
			return metrodir_get_days_left($user->ID);
		} else {
			return '';
		}
	}
	if( $column_name == 'transaction_id' ) {
		$data = get_user_meta( $id, 'paypal_transaction_id', true );
		if ($data) {
			return $data;
		}
	}
	if( $column_name == 'recurring_profile_id' ) {
		$data = get_user_meta( $id, 'paypal_recurring_profile_id', true );
		if ($data) {
			return $data;
		}
	}
}

function metrodir_company_count($id) {
	global $wpdb;
    	$count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = 'company' AND post_status = 'publish' AND post_author = ".$id );
	return $count;
}


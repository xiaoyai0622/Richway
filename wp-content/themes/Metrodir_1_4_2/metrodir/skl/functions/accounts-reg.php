<?php global $paypal, $wp_roles, $registerErrors, $registerMessages, $register_error_string;
//Get variables metrodir_Options
global $UouPlugins;
//PayPal options
$opt_metrodir_pp_act = get_option('opt_metrodir_pp_act');
$opt_metrodir_pp_api =  get_option('opt_metrodir_pp_api');
$opt_metrodir_pp_type =  get_option('opt_metrodir_pp_type');
$opt_metrodir_pp_username =  trim(get_option('opt_metrodir_pp_username'));
$opt_metrodir_pp_pass =  trim(get_option('opt_metrodir_pp_pass'));
$opt_metrodir_pp_signature =  trim(get_option('opt_metrodir_pp_signature'));
$opt_metrodir_pp_currency =  trim(get_option('opt_metrodir_pp_currency'));
$opt_metrodir_pp_name =  get_option('opt_metrodir_pp_name');
//Account options
$account[1][1] = $UouPlugins->acc->settings->role1->on;
$account[1][2] = $UouPlugins->acc->settings->role1->name;
$account[1][3] = $UouPlugins->acc->settings->role1->price;
$account[1][4] = $UouPlugins->acc->settings->role1->period;
$account[1][5] = $UouPlugins->acc->settings->role1->expr;
$account[2][1] = $UouPlugins->acc->settings->role2->on;
$account[2][2] = $UouPlugins->acc->settings->role2->name;
$account[2][3] = $UouPlugins->acc->settings->role2->price;
$account[2][4] = $UouPlugins->acc->settings->role2->period;
$account[2][5] = $UouPlugins->acc->settings->role2->expr;
$account[3][1] = $UouPlugins->acc->settings->role3->on;
$account[3][2] = $UouPlugins->acc->settings->role3->name;
$account[3][3] = $UouPlugins->acc->settings->role3->price;
$account[3][4] = $UouPlugins->acc->settings->role3->period;
$account[3][5] = $UouPlugins->acc->settings->role3->expr;
$account[4][1] = $UouPlugins->acc->settings->role4->on;
$account[4][2] = $UouPlugins->acc->settings->role4->name;
$account[4][3] = $UouPlugins->acc->settings->role4->price;
$account[4][4] = $UouPlugins->acc->settings->role4->period;
$account[4][5] = $UouPlugins->acc->settings->role4->expr;


//PayPal var
$credentials = array();
$credentials['USER'] = (isset($opt_metrodir_pp_username)) ? $opt_metrodir_pp_username : '';
$credentials['PWD'] = (isset($opt_metrodir_pp_pass)) ? $opt_metrodir_pp_pass : '';
$credentials['SIGNATURE'] = (isset($opt_metrodir_pp_signature)) ? $opt_metrodir_pp_signature : '';
$sandbox = (isset($opt_metrodir_pp_api) && $opt_metrodir_pp_api == 'live') ? '' : 'sandbox.';
$sandboxBool = (!empty($sandbox)) ? true : false;

//
//Start magic
$paypal = new Paypal($credentials,$sandboxBool); //wrum-wrum PayPal
//End magic
//

/**
 *
 * Registration and upgrade users engine
 * (if functions)
 *
 */

if(isset($_GET['submit-listing']) && ($_GET['submit-listing'] == 'register' || $_GET['submit-listing'] == 'upgrade') && isset($_POST['user-submit'])) {

	$upgrade = false;
	if($_GET['submit-listing'] == 'upgrade'){
		$upgrade = true;
		$currentRolePriceName =  $_POST['role-current-price'];
		$userId = $_POST['user_id'];
	} else {
		$userId = metrodir_register_users($_POST['user_login'],$_POST['user_email']);
	}

	if(is_wp_error( $userId )){
        $register_error_string = $userId->get_error_message(); 	// register errors string
    } else {
		$roleNum = 1; $rolePrice = '0'; $free = true; $price = '0'; $packageName = '';

		// set role
		if(isset($_POST['metrodir-role'])){
			$role = $_POST['metrodir-role'];
			if (($role == "metrodir_role_1") || ($role == "metrodir_role_2") || ($role == "metrodir_role_3") || ($role == "metrodir_role_4")){
				$roleNum = intval(substr($role, 14));
				switch ($role) {
					case "metrodir_role_1":
						if(isset($account[1][3]) && trim($account[1][3]) !== '0') {
							$rolePrice = $account[1][3];
							$free = false;
							$price = trim($account[1][3]);
							$packageName = $wp_roles->role_names[$role];
						}
						break;
					case "metrodir_role_2":
						if(isset($account[2][3]) && trim($account[2][3]) !== '0') {
							$rolePrice = $account[2][3];
							$free = false;
							if($upgrade && $currentRolePriceName != 'none'){
								$price = floatval(trim($account[2][3]));
							} else {
								$price = trim($account[2][3]);
							}
							$packageName = $wp_roles->role_names[$role];
						}
						break;
					case "metrodir_role_3":
						if(isset($account[3][3]) && trim($account[3][3]) !== '0') {
							$rolePrice = $account[3][3];
							$free = false;
							if($upgrade && $currentRolePriceName != 'none'){
								$price = floatval(trim($account[3][3]));
							} else {
								$price = trim($account[3][3]);
							}
							$packageName = $wp_roles->role_names[$role];
						}
						break;
                    case "metrodir_role_4":
                        if(isset($account[4][3]) && trim($account[4][3]) !== '0') {
                            $rolePrice = $account[4][3];
                            $free = false;
                            if($upgrade && $currentRolePriceName != 'none'){
                                $price = floatval(trim($account[4][3]));
                            } else {
                                $price = trim($account[4][3]);
                            }
                            $packageName = $wp_roles->role_names[$role];
                        }
                        break;
					default:
						break;
				}
				// paid account
				if(($opt_metrodir_pp_act == "true") && (!$free) ){

					$currencyCode = (isset($opt_metrodir_pp_currency)) ? $opt_metrodir_pp_currency : 'USD';
					$sandbox = (isset($opt_metrodir_pp_api) && $opt_metrodir_pp_api == 'live') ? '' : 'sandbox.';
					$paymentName = (isset($opt_metrodir_pp_name)) ? $opt_metrodir_pp_name : __('metrodir package','metrodir');
					$paymentDescription = ($upgrade) ? __('Upgrade to ','metrodir') . $packageName : $packageName;

					if($upgrade){
						$paymentName .= __(' Upgrade','metrodir');
					}

					$returnUrl = ($upgrade) ? admin_url("/profile.php?submit-listing=success&upgrade=1&role=".$role) : home_url("/?submit-listing=success&role=".$role);
					$cancelUrl = ($upgrade) ? admin_url("/profile.php?submit-listing=cancel&upgrade=1") : home_url("/?submit-listing=cancel");
					$urlParams = array(
						'RETURNURL' => $returnUrl,
						'CANCELURL' => $cancelUrl
					);

					if (isset($opt_metrodir_pp_type) && ($opt_metrodir_pp_type == 'recurr')) {

						$periodName = $account[$roleNum][4];
						$period = __('year','metrodir');
						switch ($periodName) {
							case 'Year':
								$period = __('year','metrodir');
								break;
							case 'Month':
								$period = __('month','metrodir');
								break;
							case 'Week':
								$period = __('week','metrodir');
								break;
							case 'Day':
								$period = __('day','metrodir');
								break;
						}
						$recurringDescription = $rolePrice.' '.$currencyCode.' '.__('per','metrodir').' '.$period;
						$recurringDescriptionFull = $rolePrice.' '.$currencyCode.' '.__('per','metrodir').' '.$period.' '.__('for','metrodir').' '.$packageName;

						// If recurring
						$recurring = array(
							'L_BILLINGTYPE0' => 'RecurringPayments',
							'L_BILLINGAGREEMENTDESCRIPTION0' => $recurringDescriptionFull
						);
						$params = $urlParams + $recurring;

					} else {

						// If single
						$orderParams = array(
							'PAYMENTREQUEST_0_AMT' => $price,
							'PAYMENTREQUEST_0_SHIPPINGAMT' => '0',
							'PAYMENTREQUEST_0_CURRENCYCODE' => $currencyCode,
							'PAYMENTREQUEST_0_ITEMAMT' => $price
						);
						$itemParams = array(
							'L_PAYMENTREQUEST_0_NAME0' => $paymentName,
							'L_PAYMENTREQUEST_0_DESC0' => $paymentDescription,
							'L_PAYMENTREQUEST_0_AMT0' => $price,
							'L_PAYMENTREQUEST_0_QTY0' => '1'
						);
						$params = $urlParams + $orderParams + $itemParams;

					}

					$response = $paypal -> request('SetExpressCheckout',$params);

					$errors = new WP_Error();

					if(!$response){

                        $errorMessage = __( 'ERROR: Check paypal API settings!', 'metrodir' );
                        $detailErrorMessage = array_shift(array_values($paypal->getErrors()));
                        $errors->add( 'bad_paypal_api', $errorMessage . ' ' . $detailErrorMessage );

                        $register_error_string = $errors;
					}

					// Successful response
					if(is_array($response) && $response['ACK'] == 'Success') {

						// write token
						$token = $response['TOKEN'];
						update_user_meta($userId, 'reg_paypal_token', $token);
						update_user_meta($userId, 'metrodir_reg_paypal_role', $role);

						// write data recurring payments
						if (isset($opt_metrodir_pp_type) && ($opt_metrodir_pp_type == 'recurr')) {
							$type = ($upgrade) ? 'upgrade' : 'register';

							update_user_meta($userId, 'paypal_recurring_profile_type',$type);
							update_user_meta($userId, 'paypal_recurring_profile_amt',$rolePrice);
							update_user_meta($userId, 'paypal_recurring_profile_init_amt',$price);
							update_user_meta($userId, 'paypal_recurring_profile_period',$periodName);
							update_user_meta($userId, 'paypal_recurring_profile_desc_full',$recurringDescriptionFull);
							update_user_meta($userId, 'paypal_recurring_profile_desc',$recurringDescription);
						}

						// go to payment site
						header( 'Location: https://www.'.$sandbox.'paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token) );
						die();

					} else {
						$errorMessage = __( 'ERROR: Check paypal API settings!', 'metrodir' );
						$detailErrorMessage = (isset($response['L_LONGMESSAGE0'])) ? $response['L_LONGMESSAGE0'] : '';
						$errors->add( 'bad_paypal_api', $errorMessage . ' ' . $detailErrorMessage );
                        $register_error_string = $errors;
					}

				} else {

					// If free
					$user = new WP_User( $userId );
					$user->set_role( $role );

					set_activation_time( $userId, $role );

					if($upgrade){
						$registerMessages = __('Your account was upgraded!','metrodir');
					} else {
						$registerMessages = __('Your account was activated! Check your email address for password!','metrodir');
					}

				}
			}
		}
	}
	unset($_POST);
}

// check token paypal authorization
if(isset($_GET['submit-listing']) && ($_GET['submit-listing'] == 'success') && !empty($_GET['token'])) {


	global $wpdb, $registerErrors, $registerMessages;
	$token = $_GET['token'];
	$tokenRow = $wpdb->get_row( "SELECT * FROM $wpdb->usermeta WHERE meta_value = '$token'" );
	if($tokenRow){

		$userId = $tokenRow->user_id;
		$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->usermeta WHERE meta_value = %s", $token ) );
		$role = get_user_meta($userId,'metrodir_reg_paypal_role',true);
		$checkoutDetails = $paypal -> request('GetExpressCheckoutDetails', array('TOKEN' => $_GET['token']));

		if( is_array($checkoutDetails) && ($checkoutDetails['ACK'] == 'Success') ) {

			// check if payment is recurring
            if (isset($checkoutDetails['BILLINGAGREEMENTACCEPTEDSTATUS']) && $checkoutDetails['BILLINGAGREEMENTACCEPTEDSTATUS']) {

				// Cancel old profile
				$oldProfile = get_user_meta($userId,'paypal_recurring_profile_id',true);
				if (!empty($oldProfile)) {
					$cancelParams = array(
						'PROFILEID' => $oldProfile,
						'ACTION' => 'Cancel'
					);
					$paypal -> request('ManageRecurringPaymentsProfileStatus',$cancelParams);
				}

				$initAmt = get_user_meta($userId,'paypal_recurring_profile_init_amt',true);
				$amt = get_user_meta($userId,'paypal_recurring_profile_amt',true);
				$currencyCode = (isset($opt_metrodir_pp_currency)) ? $opt_metrodir_pp_currency : 'USD';
				$description = get_user_meta($userId,'paypal_recurring_profile_desc_full',true);
				$desc = get_user_meta($userId,'paypal_recurring_profile_desc',true);
				$period = get_user_meta($userId,'paypal_recurring_profile_period',true);

				$periodNum = (60 * 60 * 24 * 365);
				switch ($period) {
					case 'Year':
						$periodNum = (60 * 60 * 24 * 365);
						break;
					case 'Month':
						$periodNum = (60 * 60 * 24 * 30);
						break;
					case 'Week':
						$periodNum = (60 * 60 * 24 * 7);
						break;
					case 'Day':
						$periodNum = (60 * 60 * 24);
						break;
				}

				$timeToBegin = time() + $periodNum;
				$begins = date('Y-m-d',$timeToBegin).'T'.'00:00:00Z';

				// Recurring payment
				$recurringParams = array(
					'TOKEN' => $checkoutDetails['TOKEN'],
					'PAYERID' => $checkoutDetails['PAYERID'],
					'INITAMT' => $initAmt,
					'AMT' => $amt,
					'CURRENCYCODE' => $currencyCode,
					'DESC' => $description,
					'BILLINGPERIOD' => $period,
					'BILLINGFREQUENCY' => '1',
					'PROFILESTARTDATE' => $begins,
					'FAILEDINITAMTACTION' => 'CancelOnFailure',
					'AUTOBILLOUTAMT' => 'NoAutoBill',
					'MAXFAILEDPAYMENTS' => '0'
				);
				$recurringPayment = $paypal -> request('CreateRecurringPaymentsProfile', $recurringParams);

				// recurring profile created
				if( is_array($recurringPayment) && $recurringPayment['ACK'] == 'Success' ) {


					update_user_meta( $userId, 'paypal_recurring_profile_id', $recurringPayment['PROFILEID'] );
					// set role
					$user = new WP_User( $userId );
					$user->set_role($role);
					update_user_meta( $userId, 'paypal_recurring_profile_active_desc', $desc );

					// show notice
					if(isset($_GET['upgrade'])){
						$registerMessages = __('PayPal recurring payments profile created. Your account was upgraded!','metrodir');
					} else {
						$registerMessages = __('PayPal recurring payments profile created. Your account was activated! Check your email address for password!','metrodir');
					}
				}

			} else {

				//  If single payment
				$params = array(
					'TOKEN' => $checkoutDetails['TOKEN'],
					'PAYERID' => $checkoutDetails['PAYERID'],
					'PAYMENTACTION' => 'Sale',
					'PAYMENTREQUEST_0_AMT' => $checkoutDetails['PAYMENTREQUEST_0_AMT'], // Same amount as in the original request
					'PAYMENTREQUEST_0_CURRENCYCODE' => $checkoutDetails['CURRENCYCODE'] // Same currency as the original request
				);
				$singlePayment = $paypal -> request('DoExpressCheckoutPayment',$params);

				// IF PAYMENT OK
				if( is_array($singlePayment) && $singlePayment['ACK'] == 'Success') {

					// set role
					$user = new WP_User( $userId );
					$user->set_role($role);

					// write activation time
					set_activation_time( $userId, $role );

					$transactionId = $singlePayment['PAYMENTINFO_0_TRANSACTIONID'];
					update_user_meta( $userId, 'paypal_transaction_id', $transactionId );

					// show messages
					if(isset($_GET['upgrade'])){
						$registerMessages = __('Your account was upgraded!','metrodir');
					} else {
						$registerMessages = __('Your account was activated! Check your email address for password!','metrodir');
					}
				}
			}
		}
	}
}

// if user cancel payment delete token
if(isset($_GET['submit-listing']) && ($_GET['submit-listing'] == 'cancel') && isset($_GET['token'])){

	// delete token
	global $wpdb;
	$token = $_GET['token'];
	$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->usermeta WHERE meta_value = %s", $token ) );

	// show message
	global $registerErrors;
	$errors = new WP_Error();
	if (isset($_GET['upgrade'])) {
		$message = __("You canceled payment. Your account wasn't changed.","metrodir");
		$errors->add( 'cancel_payment', $message);
		$registerErrors = $errors;
	} else {
		$message = __("You canceled payment. Your account was create but without function to add new companies. Login and upgrade your account.","metrodir");
		$errors->add( 'cancel_payment', $message);
		$registerErrors = $errors;
	}
}

// get recurring payment details
if(isset($_GET['metrodir-recurr-check'])) {
	$registerMessages = (metrodir_check_PayPal_subscription($_GET['metrodir-recurr-check'])) ? __('PayPal recurring payments profile is active.','metrodir') : __("PayPal recurring payments profile isn't active.",'metrodir');
}

// check if recurring payment profile is active
function metrodir_check_PayPal_subscription($profileId) {
	global $paypal;
	$recurringCheck = $paypal -> request('GetRecurringPaymentsProfileDetails',array('PROFILEID' => $profileId));
	if( is_array($recurringCheck) && ($recurringCheck['ACK'] == 'Success') && ($recurringCheck['STATUS'] == 'Active' || $recurringCheck['STATUS'] == 'Pending')) {
		return true;
	} else {
		return false;
	}
}

/**
 * metrodir account page
 */

add_action('admin_menu', 'metrodir_upgrade_menu_acc');
function metrodir_upgrade_menu_acc() {
    add_users_page('My Account', 'My Account', 'metrodir_account_upgrade', 'metrodir-account', 'metrodir_account_page');
}


function metrodir_account_page() {
	global $account, $current_user, $opt_metrodir_pp_type, $opt_metrodir_pp_currency;
	$user = new WP_User($current_user->ID);
	$usrRoles = $user->roles;

    echo '<div class="wrap">';
    echo '<div id="icon-users" class="icon32"><br></div>';
    echo '<h2>'.__('My Account','metrodir').'</h2>';

	$firstRole = array_shift(array_values($usrRoles));

	if($firstRole){
		if (strpos($firstRole,'metrodir_role_') !== false) {
			$roleName = $GLOBALS['wp_roles']->role_names[$firstRole];
			$roleNumber = intval(substr($firstRole, 14));
			$roleCodePrice = 'role'.$roleNumber.'Price';
		} else {
			$roleName = __('None','metrodir');
			$roleNumber = 0;
			$roleCodePrice = 'none';
		}

		if (isset($opt_metrodir_pp_type) && ($opt_metrodir_pp_type == 'recurr')) {
			$recurringProfileId = get_user_meta($user->ID,'paypal_recurring_profile_id',true);
			$recurringDescription = get_user_meta($user->ID,'paypal_recurring_profile_active_desc',true);
			global $paypal;
			$recurringCheck = $paypal -> request('GetRecurringPaymentsProfileDetails',array('PROFILEID' => $recurringProfileId));
			if( is_array($recurringCheck) && ($recurringCheck['ACK'] == 'Success') ) {
				$recurringStatus = $recurringCheck['STATUS'];
			} else {
				$recurringStatus = __('Non-active','metrodir');
			}
		}

 ?>
		<form method="post" action="<?php echo admin_url('/profile.php?submit-listing=upgrade'); ?>" class="wp-user-form">

		<input type="hidden" name="user_id" value="<?php echo $user->ID; ?>">
		<table class="form-table">
		<tbody>
			<tr>
				<th><label for="user_account_type"><?php echo __('Account type','metrodir'); ?></label></th>
				<td><input type="text" name="user_account_type" id="user_account_type" value="<?php echo $roleName; ?>" disabled="disabled" class="regular-text"></td>
			</tr>
			<?php if (isset($opt_metrodir_pp_type) && ($opt_metrodir_pp_type == 'recurr')) { ?>
				<?php if (!empty($recurringDescription) && ismetrodirUser()) { ?>
				<tr>
					<th><label for="user_account_recurring_profile_desc"><?php echo __('PayPal profile','metrodir'); ?></label></th>
					<td><input type="text" name="user_account_recurring_profile_desc" id="user_account_recurring_profile_desc" value="<?php echo $recurringDescription; ?>" disabled="disabled" class="regular-text"></td>
				</tr>
				<?php } ?>
				<?php if (!empty($recurringProfileId) && ismetrodirUser()) { ?>
				<tr>
					<th><label for="user_account_recurring_profile_id"><?php echo __('PayPal profile ID','metrodir'); ?></label></th>
					<td><input type="text" name="user_account_recurring_profile_id" id="user_account_recurring_profile_id" value="<?php echo $recurringProfileId; ?>" disabled="disabled" class="regular-text"></td>
				</tr>
				<?php } ?>
				<tr>
					<th><label for="user_account_recurring_status"><?php echo __('PayPal profile status','metrodir'); ?></label></th>
					<td><input type="text" name="user_account_recurring_status" id="user_account_recurring_status" value="<?php echo $recurringStatus; ?>" disabled="disabled" class="regular-text"></td>
				</tr>
			<?php }  ?>
            <tr>
                <th><label for="user_account_expiration"><?php echo __('Days left before expiration','metrodir'); ?></label></th>
                <td><input type="text" name="user_account_expiration" id="user_account_expiration" value="<?php echo metrodir_get_days_left(); ?>" disabled="disabled" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="user_account_items"><?php echo __('Company items (now/max) ','metrodir'); ?></label></th>
                <td><input type="text" name="user_account_items" id="user_account_items" value="<?php echo metrodir_get_items_left(); ?>" disabled="disabled" class="regular-text"></td>
            </tr>
            <?php if ( is_plugin_active('events-manager/events-manager.php') ): ?>
                <tr>
                    <th><label for="user_account_items"><?php echo __('Event Items (now/max) ','metrodir'); ?></label></th>
            <td><input type="text" name="user_account_items" id="user_account_items" value="<?php echo metrodir_get_events_items_left(); ?>" disabled="disabled" class="regular-text"></td>
            </tr>
            <?php endif; ?>
            <?php if ( is_plugin_active('woocommerce/woocommerce.php') ): ?>
                <tr>
                    <th><label for="user_account_items"><?php echo __('Product Items (now/max) ','metrodir'); ?></label></th>
                    <td><input type="text" name="user_account_items" id="user_account_items" value="<?php echo metrodir_get_products_items_left(); ?>" disabled="disabled" class="regular-text"></td>
                </tr>
            <?php endif; ?>
            <tr>
                <th><label for="user_account_items"><?php echo __('Post Items (now/max) ','metrodir'); ?></label></th>
                <td><input type="text" name="user_account_items" id="user_account_items" value="<?php echo metrodir_get_post_items_left(); ?>" disabled="disabled" class="regular-text"></td>
            </tr>
			<?php if (!(isset($opt_metrodir_pp_type) && ($opt_metrodir_pp_type == 'recurr') && ($recurringStatus == 'Pending'))) { ?>
			<tr>
				<input type="hidden" name="role-current-price" value="<?php echo $roleCodePrice; ?>">
				<?php
				$output = '<th><label for="metrodir-role">'.__('Upgrade account','metrodir').'</label></th><td><select name="metrodir-role" id="user_account_update">';
				$currency = (isset($opt_metrodir_pp_currency)) ? $opt_metrodir_pp_currency : 'USD';

                $current_price = $account[$roleNumber][3];
 				$upCount = 0;
				for ($i=1; $i <= 4; $i++) {

					if (isset($opt_metrodir_pp_type) && ($opt_metrodir_pp_type == 'recurr')) {
						$rolePeriod = __('year','metrodir');
						switch ($account[$i][4]) {
							case 'Year':
								$rolePeriod = __('year','metrodir');
								break;
							case 'Month':
								$rolePeriod = __('month','metrodir');
								break;
							case 'Week':
								$rolePeriod = __('week','metrodir');
								break;
							case 'Day':
								$rolePeriod = __('day','metrodir');
								break;
						}
					}

					$free = (trim($account[$i][3]) == '0') ? true : false;
 					if(isset($account[$i][1]) AND $account[$i][1] == "true"){

						if($roleNumber == $i){} else {
                            $output.= '<option value="metrodir_role_'.$i.'"';
                            if($free) { $output .= ' class="free"'; }
                            $output .= '>'.$account[$i][2];

                            if(!$free) {
                                if($roleCodePrice == 'none'){
                                    $upgradePrice = trim($account[$i][3]);
                                } else {
                                    $upgradePrice = floatval(trim($account[$i][3])) - floatval(trim($current_price));
                                }
                                if (isset($opt_metrodir_pp_type) && ($opt_metrodir_pp_type == 'recurr')) {
                                    $output .= ' - '.trim($account[$i][3]).' '.$currency.' '.__('per','metrodir').' '.$rolePeriod;
                                } else {
                                    $output .= ' ('.$upgradePrice.' '.$currency.')';
                                }
                            } else {
                                $output .= ' ('.__('Free','metrodir').')';
                            }
                            $output .= '</option>';
                            $upCount++;
					    }
                    }

				}
				$output .= '</select></td>';
				if($upCount > 0) { echo $output; }
				?>
			</tr>
			<?php } ?>
		</tbody>
		</table>
		<?php if (!(isset($opt_metrodir_pp_type) && ($opt_metrodir_pp_type == 'recurr') && ($recurringStatus == 'Pending'))) { ?>
		<?php if($upCount > 0) {
			echo '<p class="submit"><input type="submit" name="user-submit" data-form-url="'.admin_url('/profile.php?submit-listing=upgrade').'" value="'.__('Upgrade Account', 'metrodir').'" class="user-submit button button-primary" /></p>';
		} }
 ?>
			</form>
		<?php
	} else {
	}
}

// write activation time
add_action('set_user_role', 'set_activation_time',1,2);
function set_activation_time($id, $role) {

	global $wpdb;
	if($role == 'metrodir_role_1' || $role == 'metrodir_role_2' || $role == 'metrodir_role_3'){
		update_user_meta( $id, 'metrodir_activation_time', array( 'role' => $role, 'time' => time()) );
		$wpdb->query($wpdb->prepare( "UPDATE $wpdb->posts SET post_status = 'publish' WHERE post_author = %d AND post_status = 'expired'", intval($id)) );
	}
}

// chcek paypal subscription at startup
add_action('admin_init','metrodir_check_account_loged_user');
function metrodir_check_account_loged_user() {
	global $opt_metrodir_pp_type, $current_user;
	if (ismetrodirUser() && isset($opt_metrodir_pp_type) && ($opt_metrodir_pp_type == 'recurr')) {
		$profileId = get_user_meta($current_user->ID,'paypal_recurring_profile_id',true);
		if ((!empty($profileId)) && (!metrodir_check_PayPal_subscription($profileId))) {
            metrodir_expire_user($current_user->ID);
		}
	}
}

function metrodir_expire_user($userId) {
	global $wpdb;
	$wpdb->query($wpdb->prepare( "UPDATE $wpdb->posts SET post_status = 'expired' WHERE post_author = %d AND post_status = 'publish'", intval($userId)) );
	$user = new WP_User( $userId );
	$user->set_role('subscriber');
}


function metrodir_get_items_left() {
    global $current_user, $account;
    $params = array(
        'post_type'			=> 'company',
        'nopaging'			=> true,
        'author'			=> $current_user->ID
    );
    $itemsQuery = new WP_Query();
    $items = $itemsQuery->query($params);
    $items = count($items);

    $usrRoles = $current_user->roles;
    $roleNumber = substr(array_shift(array_values($usrRoles)), 14);
    $ream_items = $account[$roleNumber][6];
    if($ream_items == 0){
        $ream_items = "∞";
    } elseif ($ream_items == -1){
        $ream_items = __('forbidden','metrodir');
    }
    $reaming_items = $items.'/'.$ream_items;
    return $reaming_items;
}

function metrodir_get_events_items_left() {
    global $current_user, $account;
    $params = array(
        'post_type'			=> 'event',
        'nopaging'			=> true,
        'author'			=> $current_user->ID
    );
    $itemsQuery = new WP_Query();
    $items = $itemsQuery->query($params);
    $items = count($items);

    $usrRoles = $current_user->roles;
    $roleNumber = substr(array_shift(array_values($usrRoles)), 14);
    $ream_items = $account[$roleNumber][8];
    if($ream_items == 0){
        $ream_items = "∞";
    } elseif ($ream_items == -1){
        $ream_items = __('forbidden','metrodir');
    }
    $reaming_items = $items.'/'.$ream_items;
    return $reaming_items;
}

function metrodir_get_products_items_left() {
    global $current_user, $account;
    $params = array(
        'post_type'			=> 'product',
        'nopaging'			=> true,
        'author'			=> $current_user->ID
    );
    $itemsQuery = new WP_Query();
    $items = $itemsQuery->query($params);
    $items = count($items);

    $usrRoles = $current_user->roles;
    $roleNumber = substr(array_shift(array_values($usrRoles)), 14);
    $ream_items = $account[$roleNumber][9];
    if($ream_items == 0){
        $ream_items = "∞";
    } elseif ($ream_items == -1){
        $ream_items = __('forbidden','metrodir');
    }
    $reaming_items = $items.'/'.$ream_items;
    return $reaming_items;
}

function metrodir_get_post_items_left() {
    global $current_user, $account;
    $params = array(
        'post_type'			=> 'post',
        'nopaging'			=> true,
        'author'			=> $current_user->ID
    );
    $itemsQuery = new WP_Query();
    $items = $itemsQuery->query($params);
    $items = count($items);

    $usrRoles = $current_user->roles;
    $roleNumber = substr(array_shift(array_values($usrRoles)), 14);
    $ream_items = $account[$roleNumber][7];
    if($ream_items == 0){
        $ream_items = "∞";
    } elseif ($ream_items == -1){
        $ream_items = __('forbidden','metrodir');
    }
    $reaming_items = $items.'/'.$ream_items;
    return $reaming_items;
}

function metrodir_get_days_left($userIdToTest = null) {
	global $wpdb, $current_user, $account;

	$userId = (isset($userIdToTest)) ? intval($userIdToTest) : $current_user->ID;

	$data = $wpdb->get_row("SELECT meta_value FROM $wpdb->usermeta WHERE meta_key = 'metrodir_activation_time' AND user_id = ".$userId);
	$data = unserialize($data->meta_value);


    $roleNumber = substr($data['role'], 14);
	$limit = intval($account[$roleNumber][5]);

	if($limit > 0){
		$timeInSec = $data['time'];
		$differenceInSec = ($limit * 60 * 60 * 24) - (time() - $timeInSec);
		$differenceInDays = ceil($differenceInSec / 60 / 60 / 24);
		if($differenceInDays <= 0){
			$differenceInDays = __('Expired account','metrodir');
		}
	} else {
		$differenceInDays = 'Unlimited';
	}

	return $differenceInDays;
}

/**
 *
 * Registration users engine
 *
 */

function metrodir_register_users( $user_login, $user_email ) {
	$errors = new WP_Error();

	// check registrations disabled
	if (!get_option( 'users_can_register' )){
		$errors->add( 'registrations_disabled',__('ERROR: User registration is disabled.', 'metrodir') );
		return $errors;
	}

	$sanitized_user_login = sanitize_user( $user_login );
	$user_email = apply_filters( 'user_registration_email', $user_email );

	// check username

	if ( $sanitized_user_login == '' ) {
		$errors->add( 'empty_username', __( 'ERROR: Please enter a username.' , 'metrodir') );
	} elseif ( ! validate_username( $user_login ) ) {
		$errors->add( 'invalid_username', __( 'ERROR: Please enter a valid username.' , 'metrodir') );
		$sanitized_user_login = '';
	} elseif ( username_exists( $sanitized_user_login ) ) {
		$errors->add( 'username_exists', __( 'ERROR: This username is already registered.', 'metrodir' ) );
	}

	// check e-mail
	if ( $user_email == '' ) {
		$errors->add( 'empty_email', __( 'ERROR: Please type your e-mail address.', 'metrodir' ) );
	} elseif ( ! is_email( $user_email ) ) {
		$errors->add( 'invalid_email', __( 'ERROR: The email address isn&#8217;t correct.', 'metrodir' ) );
		$user_email = '';
	} elseif ( email_exists( $user_email ) ) {
		$errors->add( 'email_exists', __( 'ERROR: This email is already registered.', 'metrodir' ) );
	}

	do_action( 'register_post', $sanitized_user_login, $user_email, $errors );

	$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );

	if ( $errors->get_error_code() )
		return $errors;

	$user_pass = wp_generate_password( 12, false);
	$user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email );
	if ( ! $user_id ) {
		$errors->add( 'registerfail', sprintf( __( 'ERROR: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !', 'metrodir' ), get_option( 'admin_email' ) ) );
		return $errors;
	}

	update_user_option( $user_id, 'default_password_nag', true, true ); //Set up the Password change nag.

	wp_new_user_notification( $user_id, $user_pass );

	return $user_id;
}
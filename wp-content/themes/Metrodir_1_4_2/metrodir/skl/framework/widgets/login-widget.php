<?php
/**
 * Creates widget with login or register to direcotry portal theme
 */
class Widget_login_metrodir extends WP_Widget {
	/**
	 * Widget constructor
     *
	 * @desc sets default options and controls for widget
	 */
	function Widget_login_metrodir () {

		$tourTheme = (defined('THEME_CODE_NAME') && THEME_CODE_NAME == 'touroperator') ? true : false;

		if ($tourTheme) {
			/* Widget settings */
			$widget_ops = array (
				'classname' => 'widget_directory',
				'description' => __( 'Register or login TourOperator users form', 'metrodir')
			);

			/* Create the widget */
			$this->WP_Widget( 'ait-directory-widget', __( 'Theme &rarr; TourOperator Login', 'metrodir'), $widget_ops );
		} else {
			/* Widget settings */
			$widget_ops = array (
				'classname' => 'widget_directory',
				'description' => __( 'Register or login metrodir users form', 'metrodir')
			);

			/* Create the widget */
			$this->WP_Widget( 'ait-directory-widget', __( '!Beta! metrodir &rarr; Login-Register Form', 'metrodir'), $widget_ops );
		}
		
	}

	/**
	 * Displaying the widget
	 *
	 * Handle the display of the widget
	 * @param array
	 * @param array
	 */
	function widget( $args, $instance ) {

		$tourTheme = (defined('THEME_CODE_NAME') && THEME_CODE_NAME == 'touroperator') ? true : false;

		extract( $args );
		$title = (!empty($instance['title'])) ? do_shortcode($instance['title']) : '';
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		echo $before_widget;
		if ( $title) {
			echo $before_title . $title . $after_title;
		}

		if ( is_user_logged_in() ){
			echo '<div class="logged">';
			global $wp_roles;
			$currUser = wp_get_current_user();
			echo $instance['description_logout'];
			echo '<div class="profile-info clear">';
			echo '<div class="profile-avatar">'.get_avatar( $currUser->ID ).'</div>';
			echo '<div class="profile-name"><span>'.__('Username: ','metrodir').'</span>'.$currUser->user_nicename .'</div>';
			if(isset($currUser->roles[0])){
				echo '<div class="profile-role"><span>'.__('Account: ','metrodir').'</span>'.$wp_roles->role_names[$currUser->roles[0]] .'</div>';
			}

			if (!in_array('subscriber', $currUser->roles)) {
				echo '<a href="'.admin_url('edit.php?post_type=company').'" title="My Items" class="widgetlogin-button-myitems">'.__('My Items','metrodir').'</a>';
				if ($tourTheme) {
					echo '<a href="'.admin_url('edit.php?post_type=ait-dir-item-offer').'" title="Ratings" class="widgetlogin-button-item-offers">'.__('Item Offers','metrodir').'</a>';
					echo '<a href="'.admin_url('edit.php?post_type=ait-tour-reservation').'" title="Ratings" class="widgetlogin-button-reservations">'.__('Reservations','metrodir').'</a>';
				}
				echo '<a href="'.admin_url('edit.php?post_type=ait-rating').'" title="Ratings" class="widgetlogin-button-ratings">'.__('Ratings','metrodir').'</a>';
			}
			echo '<a href="'.admin_url('profile.php').'" title="Account" class="widgetlogin-button-account">'.__('Account','metrodir').'</a>';

			echo '<a href="'.wp_logout_url(get_permalink()).'" title="Logout" class="widgetlogin-button-logout">'.__('Logout','metrodir').'</a>';
			echo '</div></div>';
		} else {
			?>
			<div class="not-logged">
			<div id="ait-login-tabs">
				<ul>
					<li><a class="login" href="#ait-dir-login-tab"><?php echo __('Login','metrodir'); ?></a></li>
					<li class="active"><a class="register" href="#ait-submit-listing-tab"><?php echo __('Register','metrodir'); ?></a></li>
				</ul>

				<!-- login -->
				<div id="ait-dir-login-tab" style="display: none;">
				<p><?php echo $instance['description_login']; ?></p>
				<?php wp_login_form( array( 'form_id' => 'ait-login-form-widget' ) ); ?>
				</div>

				<!-- register -->
				<div id="ait-submit-listing-tab">
				<p><?php echo $instance['description_register']; ?></p>
				<form method="post" action="<?php echo home_url('/?submit-listing=register'); ?>" class="wp-user-form">
					<div class="register-username">
						<label for="user_login"><?php _e('Username','metrodir'); ?> </label>
						<input type="text" name="user_login" value="" size="20" id="user_login_register_widget" tabindex="101" />
					</div>
					<div class="register-email">
						<label for="user_email"><?php _e('Email','metrodir'); ?> </label>
						<input type="text" name="user_email" value="" size="25" id="user_email_register_widget" tabindex="102" />
					</div>
					<div class="register-role">
						<label for="metrodir-role"><?php _e('Package','metrodir'); ?> </label>
						<select name="metrodir-role">

                    <?php
                        $pp_currency = get_option('opt_metrodir_pp_currency');
                        $currency = (isset($pp_currency)) ? $pp_currency : 'USD';

                        $pp_type = get_option('opt_metrodir_pp_type');

                        $account[1][1] = get_option('opt_metrodir_acc_1_active');
                        $account[1][2] = get_option('opt_metrodir_acc_1_name');
                        $account[1][3] =  get_option('opt_metrodir_acc_1_price');
                        $account[1][4] = get_option('opt_metrodir_acc_1_period');
                        $account[2][1] = get_option('opt_metrodir_acc_2_active');
                        $account[2][2] = get_option('opt_metrodir_acc_2_name');
                        $account[2][3] = get_option('opt_metrodir_acc_2_price');
                        $account[2][4] = get_option('opt_metrodir_acc_2_period');
                        $account[3][1] = get_option('opt_metrodir_acc_3_active');
                        $account[3][2] = get_option('opt_metrodir_acc_3_name');
                        $account[3][3] = get_option('opt_metrodir_acc_3_price');
                        $account[3][4] = get_option('opt_metrodir_acc_3_period');

                        for ($i=1; $i <= 3; $i++) {

                            $free = (trim($account[$i][3]) == '0') ? true : false;
                            if(isset($account[$i][1])){
                                echo '<option value="metrodir_role_'.$i.'"'; if($free) { echo ' class="free"'; } echo '>'.$account[$i][2];
                                if(!$free) {
                                    if (isset($pp_type) && ($pp_type == 'recurr')) {
                                        echo ' - '.trim($account[$i][3]).' '.$currency.' '.__('per','metrodir').' '.$account[$i][4];
                                    } else {
                                        echo ' ('.$account[$i][3].' '.$currency.')';
                                    }
                                } else {
                                echo ' ('.__('Free','metrodir').')';
                                }
                                echo '</option>';
                            }
                        }
                    ?>
						</select>
					</div>
					<div class="login-fields">
						<?php do_action('register_form'); ?>
						<input type="submit" name="user-submit" value="<?php _e('Sign up!', 'metrodir'); ?>" class="user-submit" tabindex="103" />
						<input type="hidden" name="redirect_to" value="<?php echo home_url(); ?>" />
						<input type="hidden" name="user-cookie" value="1" />
					</div>
				</form>
				</div>

				<script>
				jQuery(document).ready(function($) {
					var tabRegister = $('#ait-submit-listing-tab'),
						tabLogin =  $('#ait-dir-login-tab'),
						linkLogin = $('#ait-login-tabs .login'),
						linkRegister = $('#ait-login-tabs .register');
					linkLogin.click(function(event) {
						linkRegister.parent().removeClass('active');
						tabRegister.hide();
						linkLogin.parent().addClass('active');
						tabLogin.show();
						event.preventDefault();
					});
					linkRegister.click(function(event) {
						linkLogin.parent().removeClass('active');
						tabLogin.hide();
						linkRegister.parent().addClass('active');
						tabRegister.show();
						event.preventDefault();
					});
					// init and change
					var select = tabRegister.find('select[name=metrodir-role]'),
						buttonSubmit = tabRegister.find('input[name=user-submit]'),
						freeTitle = '<?php _e('Sign up','metrodir'); ?>',
						buyTitle = '<?php _e('Buy with PayPal','metrodir'); ?>';
					if(select.find('option:selected').hasClass('free')){
						buttonSubmit.val(freeTitle);
					} else {
						buttonSubmit.val(buyTitle);
					}
					select.change(function(event) {
						if(select.find('option:selected').hasClass('free')){
							buttonSubmit.val(freeTitle);
						} else {
							buttonSubmit.val(buyTitle);
						}
					});
				});
				</script>

			</div>
			</div>
			<?php
		}

		echo $after_widget;

	}

	/**
	 * Update and save widget
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array New widget values
	 */
	function update ( $new_instance, $old_instance ) {
		$old_instance['title'] = strip_tags( $new_instance['title'] );
		$old_instance['description_login'] = $new_instance['description_login'];
		$old_instance['description_logout'] = $new_instance['description_logout'];
		$old_instance['description_register'] = $new_instance['description_register'];

		return $old_instance;
	}

	/**
	 * Creates widget controls or settings
	 *
	 * @param array Return widget options form
	 */
	function form ( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
        	'title' => '',
        	'description_login' => '',
        	'description_logout' => '',
        	'description_register' => ''
        ) );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title', 'metrodir' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"class="widefat" style="width:100%;" />
			<label for="<?php echo $this->get_field_id( 'description_login' ); ?>"><?php echo __( 'Login Description', 'metrodir' ); ?>:</label>
			<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'description_login' ); ?>" name="<?php echo $this->get_field_name( 'description_login' ); ?>"><?php echo htmlspecialchars($instance['description_login']); ?></textarea>
			<label for="<?php echo $this->get_field_id( 'description_logout' ); ?>"><?php echo __( 'Logout Description', 'metrodir' ); ?>:</label>
			<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'description_logout' ); ?>" name="<?php echo $this->get_field_name( 'description_logout' ); ?>"><?php echo htmlspecialchars($instance['description_logout']); ?></textarea>
			<label for="<?php echo $this->get_field_id( 'description_register' ); ?>"><?php echo __( 'Register Description', 'metrodir' ); ?>:</label>
			<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'description_register' ); ?>" name="<?php echo $this->get_field_name( 'description_register' ); ?>"><?php echo htmlspecialchars($instance['description_register']); ?></textarea>
        </p>
        <?php
	}
}
register_widget( 'Widget_login_metrodir' );

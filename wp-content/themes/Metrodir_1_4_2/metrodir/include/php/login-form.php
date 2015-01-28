<?php //Get variables
$opt_metrodir_home_subscribe = get_option('opt_metrodir_home_subscribe');
?>

<ul class="user-links">
    <li class="login">
        <a href="#" id="login-link" class="login-link"><i class="fa fa-power-off"></i><span><?php echo __('Login','metrodir'); ?></span></a>
        <form id="login-form" action="<?php echo wp_login_url(home_url()); ?>" class="login-form" name="loginform" method="post">
            <div id="login-form-container">
                <input type="text" id="user_login" class="text-input-grey" name="log" placeholder="<?php echo __('Login','metrodir'); ?>">
                <input type="password" id="user_pass" class="text-input-grey" name="pwd" placeholder="<?php echo __('Password','metrodir'); ?>">
                <input type="submit" name="wp-submit" value="<?php echo __('Login','metrodir'); ?>">
                <a class="password-restore" href="<?php echo wp_lostpassword_url(); ?>"><?php echo __('Forgot Password?','metrodir'); ?></a>
                <div class="clear"></div>
            </div>
        </form>
    </li>
    <?php if ($opt_metrodir_home_subscribe == "true"): ?>
        <li class="register">
            <a id="register-link" class="register-link" href="<?php echo home_url(); ?>/#subscribe"><i class="fa fa-plus-circle"></i><span><?php echo __('Register','metrodir'); ?></span></a>
        </li>
    <?php endif; ?>
</ul>
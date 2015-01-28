<?php global $UouPlugins; ?>

<div id="register">
    <div class="title">
        <h2><?php echo __('Register Now!','metrodir'); ?></h2>
    </div>

    <div class="subscription-table">
        <form class="subscription-table" action="<?php echo home_url('/?submit-listing=register'); ?>" method="post">

            <div class="subscription-column">
                <div class="subscription-header"><?php echo __('Step','metrodir'); ?> 1: <?php echo __('Register','metrodir'); ?></div>
                <div class="subscription-body">
                    <label><?php echo __('Login details:','metrodir'); ?></label>
                    <input type="text" class="text-input-grey" name="user_login"  placeholder="<?php echo __('Login','metrodir'); ?>" />
                    <input type="text" class="text-input-grey" name="user_email" placeholder="<?php echo __('E-Mail','metrodir'); ?>" />
                </div>
            </div>

            <div class="subscription-column">
                <div class="subscription-header"><?php echo __('Step','metrodir'); ?> 2: <?php echo __('Package','metrodir'); ?></div>
                <div class="subscription-body">
                    <label><?php echo __('Choose Package:','metrodir'); ?></label>
                    <ul class="radio-buttons">
                        <?php
                        $pp_currency = get_option('opt_metrodir_pp_currency');
                        $currency = (isset($pp_currency)) ? $pp_currency : 'USD';

                        $pp_type = get_option('opt_metrodir_pp_type');

                        $account[1][1] = $UouPlugins->acc->settings->role1->on;
                        $account[1][2] = $UouPlugins->acc->settings->role1->name;
                        $account[1][3] = $UouPlugins->acc->settings->role1->price;
                        $account[1][4] = $UouPlugins->acc->settings->role1->period;
                        $account[2][1] = $UouPlugins->acc->settings->role2->on;
                        $account[2][2] = $UouPlugins->acc->settings->role2->name;
                        $account[2][3] = $UouPlugins->acc->settings->role2->price;
                        $account[2][4] = $UouPlugins->acc->settings->role2->period;
                        $account[3][1] = $UouPlugins->acc->settings->role3->on;
                        $account[3][2] = $UouPlugins->acc->settings->role3->name;
                        $account[3][3] = $UouPlugins->acc->settings->role3->price;
                        $account[3][4] = $UouPlugins->acc->settings->role3->period;
                        $account[4][1] = $UouPlugins->acc->settings->role4->on;
                        $account[4][2] = $UouPlugins->acc->settings->role4->name;
                        $account[4][3] = $UouPlugins->acc->settings->role4->price;
                        $account[4][4] = $UouPlugins->acc->settings->role4->period;

                        for ($i=1; $i <= 4; $i++) {

                            $free = (trim($account[$i][3]) == '0') ? true : false;
                            if($account[$i][1] == "true"){
                                echo '<li><input id="metrodir_role_'.$i.'" type="radio" name="metrodir-role" value="metrodir_role_'.$i.'"'; if($free) { echo ' class="free"'; } echo '><label for="metrodir_role_'.$i.'">'.$account[$i][2];
                                if(!$free) {
                                    if (isset($pp_type) && ($pp_type == 'recurr')) {
                                        echo ' ('.trim($account[$i][3]).' '.$currency.'/'.$account[$i][4].')';
                                    } else {
                                        echo ' ('.$account[$i][3].' '.$currency.')';
                                    }
                                } else {
                                    echo ' ('.__('Free','metrodir').')';
                                }
                                echo '</label></li>';
                            }
                        }
                        ?>

                    </ul>
                </div>
            </div>

            <div class="clear"></div>

            <div class="subscription-footer">

                <input type="hidden" name="redirect_to" value="<?php echo home_url(); ?>" />
                <div class="submit"><i class="fa fa-arrow-circle-right"></i><input type="submit" class="button-green" value="Subscribe" name="user-submit" /></div>

            </div>

        </form>
    </div>

</div>
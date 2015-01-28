<div class="field field_type-checkbox">
    <p class="label">
        <label for="stars-activate"><?php echo __('Activate account control','metrodir'); ?></label>
        <span><?php echo __('Enable MetroDir Users Role Capabilities','metrodir'); ?></span>
    </p>

    <div class="acf-input-wrap">
        <label for="stars-activate">
            <input type="checkbox" value="enable" name="uou_opt_plugins[acc][status]" id="stars-activate" <?php if ($UouPlugins->acc->status == "enable"){echo "checked";};?>/>
            <span><?php echo __('Yes','metrodir'); ?></span>
        </label>
    </div>
</div>

<!-- 1 role settings-->
<div class="postbox closed">
    <div title="" class="handlediv"><br></div><h3><span><?php echo '1 - '.__('Account settings','metrodir'); ?></span></h3>
        <div class="inside">
        <table class="form-table">
        <tbody>

        <tr valign="top">
            <th scope="row"><?php echo __('Activate','metrodir').' 1 '.__('account','metrodir'); ?></th>
            <td>
                <span><?php echo __('Yes','metrodir'); ?></span> <input type="radio" <?php if ($UouPlugins->acc->settings->role1->on == "true"){echo "checked";};?> value="true" name="uou_opt_plugins[acc][settings][role1][on]"/>
                <span><?php echo __('No','metrodir'); ?></span> <input type="radio"  <?php if ($UouPlugins->acc->settings->role1->on == "false"){echo "checked";};?> value="false" name="uou_opt_plugins[acc][settings][role1][on]"/>
                <br/><em><?php echo __('Select yes to enable this account.','metrodir'); ?></em>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php echo __('Account name','metrodir'); ?></th>
            <td>
                <input type="text"  value="<?php echo $UouPlugins->acc->settings->role1->name;?>" name="uou_opt_plugins[acc][settings][role1][name]"/>
                <em><?php echo __('Name for role','metrodir'); ?></em>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php echo __('Price','metrodir'); ?></th>
            <td>
                <input type="text"  value="<?php echo $UouPlugins->acc->settings->role1->price;?>" name="uou_opt_plugins[acc][settings][role1][price]"/>
                <em><?php echo __('set 0 for free','metrodir'); ?></em>
            </td>
        </tr>

        <tr>
            <th scope="row"><?php echo __('Payment period','metrodir'); ?></th>
            <td>
                <select class=""  name="uou_opt_plugins[acc][settings][role1][period]">
                    <option <?php if ($UouPlugins->acc->settings->role1->period == "Year"){echo "selected";};?> value="Year"><?php echo __('Year','metrodir'); ?></option>
                    <option <?php if ($UouPlugins->acc->settings->role1->period == "Month"){echo "selected";};?> value="Month" class="level-0"><?php echo __('Month','metrodir'); ?></option>
                    <option <?php if ($UouPlugins->acc->settings->role1->period == "Week"){echo "selected";};?> value="Week" class="level-0"><?php echo __('Week','metrodir'); ?></option>
                    <option <?php if ($UouPlugins->acc->settings->role1->period == "Day"){echo "selected";};?> value="Day" class="level-0"><?php echo __('Day','metrodir'); ?></option>
                </select>
        </tr>
        <tr valign="top">
            <th scope="row"><?php echo __('Expires period days','metrodir'); ?></th>
            <td>
                <input type="text"  value="<?php echo $UouPlugins->acc->settings->role1->expr;?>" name="uou_opt_plugins[acc][settings][role1][expr]"/>
                <em><?php echo __('Payment period','metrodir'); ?>set 0 for unlimited</em>
            </td>
        </tr>

        </tbody>
        </table>
        </div> <!-- . inside -->
</div>

<!-- 1 role capabilities-->
<div class="postbox closed">
    <div title="" class="handlediv"><br></div><h3><span><?php echo '1 - '.__('Account capabilities','metrodir'); ?></span></h3>
    <div class="inside">
        <table class="form-table">
            <tbody>

            <tr valign="top">
                <th scope="row"><?php echo __('Enable set featured company','metrodir'); ?></th>
                <td>
                    <label for="r1f-activate">
                        <input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][role1][caps][featured]" id="r1f-activate" <?php if (isset($UouPlugins->acc->settings->role1->caps->featured) && $UouPlugins->acc->settings->role1->caps->featured == "enable"){echo "checked";};?>>
                        <span><?php echo __('Yes','metrodir'); ?></span>
                    </label>
                </td>
            </tr>

            <?php  if ($UouPlugins->stars->restriction == "enable"): ?>
                <tr valign="top">
                    <th scope="row"><?php echo __('Enable capability for Rating System','metrodir'); ?></th>
                    <td>
                        <label for="r1f-rat-activate">
                            <input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][role1][caps][rating]" id="r1f-rat-activate" <?php if (isset($UouPlugins->acc->settings->role1->caps->rating) && $UouPlugins->acc->settings->role1->caps->rating == "enable"){echo "checked";};?>>
                            <?php echo __('Yes','metrodir'); ?>
                        </label>
                    </td>
                </tr>
            <?php endif; ?>

            <tr valign="top">
                <th scope="row"><?php echo __('Max company items','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role1->caps->maxcompany;?>" name="uou_opt_plugins[acc][settings][role1][caps][maxcompany]"/>
                    <em><?php echo __('Set 0 for Unlimited OR -1 for Block','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Max blog post items','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role1->caps->maxpost;?>" name="uou_opt_plugins[acc][settings][role1][caps][maxpost]"/>
                    <em><?php echo __('Set 0 for Unlimited OR -1 for Block','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Max events items','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role1->caps->maxevent;?>" name="uou_opt_plugins[acc][settings][role1][caps][maxevent]"/>
                    <em><?php echo __('Set 0 for Unlimited OR -1 for Block','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Max product items','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role1->caps->maxproduct;?>" name="uou_opt_plugins[acc][settings][role1][caps][maxproduct]">
                    <em><?php echo __('Set 0 for Unlimited OR -1 for Block','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Submit for Review Before Publish','metrodir'); ?></th>
                <td>
                    <label for="r1f-approve">
                        <input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][role1][caps][approve]" id="r1f-approve" <?php if (isset($UouPlugins->acc->settings->role1->caps->approve) && $UouPlugins->acc->settings->role1->caps->approve == "enable"){echo "checked";};?>>
                        <em><?php echo __('Yes','metrodir'); ?></em>
                    </label>
                </td>
            </tr>

            </tbody>
        </table>
    </div> <!-- . inside -->
</div>

<!-- 2 role settings-->
<div class="postbox closed">
    <div title="" class="handlediv"><br></div><h3><span><?php echo '2 - '.__('Account settings','metrodir'); ?></span></h3>
    <div class="inside">
        <table class="form-table">
            <tbody>

            <tr valign="top">
                <th scope="row"><?php echo __('Activate','metrodir').' 2 '.__('account','metrodir'); ?></th>
                <td>
                    <span><?php echo __('Yes','metrodir'); ?></span> <input type="radio" <?php if ($UouPlugins->acc->settings->role2->on == "true"){echo "checked";};?> value="true" name="uou_opt_plugins[acc][settings][role2][on]"/>
                    <span><?php echo __('No','metrodir'); ?></span> <input type="radio"  <?php if ($UouPlugins->acc->settings->role2->on == "false"){echo "checked";};?> value="false" name="uou_opt_plugins[acc][settings][role2][on]"/>
                    <br/><em><?php echo __('Select yes to enable this account.','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Account name','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role2->name;?>" name="uou_opt_plugins[acc][settings][role2][name]"/>
                    <em><?php echo __('Name for role','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Price','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role2->price;?>" name="uou_opt_plugins[acc][settings][role2][price]"/>
                    <em><?php echo __('set 0 for free','metrodir'); ?></em>
                </td>
            </tr>

            <tr>
                <th scope="row"><?php echo __('Payment period','metrodir'); ?></th>
                <td>
                    <select class=""  name="uou_opt_plugins[acc][settings][role2][period]">
                        <option <?php if ($UouPlugins->acc->settings->role2->period == "Year"){echo "selected";};?> value="Year"><?php echo __('Year','metrodir'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->role2->period == "Month"){echo "selected";};?> value="Month" class="level-0"><?php echo __('Month','metrodir'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->role2->period == "Week"){echo "selected";};?> value="Week" class="level-0"><?php echo __('Week','metrodir'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->role2->period == "Day"){echo "selected";};?> value="Day" class="level-0"><?php echo __('Day','metrodir'); ?></option>
                    </select>
            </tr>
            <tr valign="top">
                <th scope="row"><?php echo __('Expires period days','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role2->expr;?>" name="uou_opt_plugins[acc][settings][role2][expr]"/>
                    <em><?php echo __('set 0 for unlimited','metrodir'); ?></em>
                </td>
            </tr>

            </tbody>
        </table>
    </div> <!-- . inside -->
</div>

<!-- 2 role capabilities-->
<div class="postbox closed">
    <div title="" class="handlediv"><br></div><h3><span><?php echo '2 - '.__('Account capabilities','metrodir'); ?></span></h3>
    <div class="inside">
        <table class="form-table">
            <tbody>

            <tr valign="top">
                <th scope="row"><?php echo __('Enable set featured company','metrodir'); ?></th>
                <td>
                    <label for="r2f-activate">
                        <input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][role2][caps][featured]" id="r2f-activate" <?php if (isset($UouPlugins->acc->settings->role2->caps->featured) && $UouPlugins->acc->settings->role2->caps->featured == "enable"){echo "checked";};?>>
                        <span><?php echo __('Yes','metrodir'); ?></span>
                    </label>
                </td>
            </tr>

            <?php  if ($UouPlugins->stars->restriction == "enable"): ?>
                <tr valign="top">
                    <th scope="row"><?php echo __('Enable capability for Rating System','metrodir'); ?></th>
                    <td>
                        <label for="r2f-rat-activate">
                            <input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][role2][caps][rating]" id="r2f-rat-activate" <?php if (isset($UouPlugins->acc->settings->role2->caps->rating) && $UouPlugins->acc->settings->role2->caps->rating == "enable"){echo "checked";};?>>
                            <?php echo __('Yes','metrodir'); ?>
                        </label>
                    </td>
                </tr>
            <?php endif; ?>

            <tr valign="top">
                <th scope="row"><?php echo __('Max company items','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role2->caps->maxcompany;?>" name="uou_opt_plugins[acc][settings][role2][caps][maxcompany]"/>
                    <em><?php echo __('Set 0 for Unlimited OR -1 for Block','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Max blog post items','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role2->caps->maxpost;?>" name="uou_opt_plugins[acc][settings][role2][caps][maxpost]"/>
                    <em><?php echo __('Set 0 for Unlimited OR -1 for Block','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Max events items','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role2->caps->maxevent;?>" name="uou_opt_plugins[acc][settings][role2][caps][maxevent]"/>
                    <em><?php echo __('Set 0 for Unlimited OR -1 for Block','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Max product items','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role2->caps->maxproduct;?>" name="uou_opt_plugins[acc][settings][role2][caps][maxproduct]">
                    <em><?php echo __('Set 0 for Unlimited OR -1 for Block','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Submit for Review Before Publish','metrodir'); ?></th>
                <td>
                    <label for="r2f-approve">
                        <input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][role2][caps][approve]" id="r1f-approve" <?php if (isset($UouPlugins->acc->settings->role2->caps->approve) && $UouPlugins->acc->settings->role2->caps->approve == "enable"){echo "checked";};?>>
                        <em><?php echo __('Yes','metrodir'); ?></em>
                    </label>
                </td>
            </tr>

            </tbody>
        </table>
    </div> <!-- . inside -->
</div>


<!-- 3 role settings-->
<div class="postbox closed">
    <div title="" class="handlediv"><br></div><h3><span><?php echo '3 - '.__('Account settings','metrodir'); ?></span></h3>
    <div class="inside">
        <table class="form-table">
            <tbody>

            <tr valign="top">
                <th scope="row"><?php echo __('Activate','metrodir').' 3 '.__('account','metrodir'); ?></th>
                <td>
                    <span><?php echo __('Yes','metrodir'); ?></span> <input type="radio" <?php if ($UouPlugins->acc->settings->role3->on == "true"){echo "checked";};?> value="true" name="uou_opt_plugins[acc][settings][role3][on]"/>
                    <span><?php echo __('No','metrodir'); ?></span> <input type="radio"  <?php if ($UouPlugins->acc->settings->role3->on == "false"){echo "checked";};?> value="false" name="uou_opt_plugins[acc][settings][role3][on]"/>
                    <br/><em><?php echo __('Select yes to enable this account.','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Account name','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role3->name;?>" name="uou_opt_plugins[acc][settings][role3][name]"/>
                    <em><?php echo __('Name for role','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Price','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role3->price;?>" name="uou_opt_plugins[acc][settings][role3][price]"/>
                    <em><?php echo __('set 0 for free','metrodir'); ?></em>
                </td>
            </tr>

            <tr>
                <th scope="row"><?php echo __('Payment period','metrodir'); ?></th>
                <td>
                    <select class=""  name="uou_opt_plugins[acc][settings][role3][period]">
                        <option <?php if ($UouPlugins->acc->settings->role3->period == "Year"){echo "selected";};?> value="Year"><?php echo __('Year','metrodir'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->role3->period == "Month"){echo "selected";};?> value="Month" class="level-0"><?php echo __('Month','metrodir'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->role3->period == "Week"){echo "selected";};?> value="Week" class="level-0"><?php echo __('Week','metrodir'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->role3->period == "Day"){echo "selected";};?> value="Day" class="level-0"><?php echo __('Day','metrodir'); ?></option>
                    </select>
            </tr>
            <tr valign="top">
                <th scope="row"><?php echo __('Expires period days','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role3->expr;?>" name="uou_opt_plugins[acc][settings][role3][expr]"/>
                    <em><?php echo __('set 0 for unlimited','metrodir'); ?></em>
                </td>
            </tr>

            </tbody>
        </table>
    </div> <!-- . inside -->
</div>

<!-- 3 role capabilities-->
<div class="postbox closed">
    <div title="" class="handlediv"><br></div><h3><span><?php echo '3 - '.__('Account capabilities','metrodir'); ?></span></h3>
    <div class="inside">
        <table class="form-table">
            <tbody>

            <tr valign="top">
                <th scope="row"><?php echo __('Enable set featured company','metrodir'); ?></th>
                <td>
                    <label for="r3f-activate">
                        <input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][role3][caps][featured]" id="r3f-activate" <?php if (isset($UouPlugins->acc->settings->role3->caps->featured) && $UouPlugins->acc->settings->role3->caps->featured == "enable"){echo "checked";};?>>
                        <span><?php echo __('Yes','metrodir'); ?></span>
                    </label>
                </td>
            </tr>

            <?php  if ($UouPlugins->stars->restriction == "enable"): ?>
                <tr valign="top">
                    <th scope="row"><?php echo __('Enable capability for Rating System','metrodir'); ?></th>
                    <td>
                        <label for="r3f-rat-activate">
                            <input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][role3][caps][rating]" id="r3f-rat-activate" <?php if (isset($UouPlugins->acc->settings->role3->caps->rating) && $UouPlugins->acc->settings->role3->caps->rating == "enable"){echo "checked";};?>>
                            <?php echo __('Yes','metrodir'); ?>
                        </label>
                    </td>
                </tr>
            <?php endif; ?>

            <tr valign="top">
                <th scope="row"><?php echo __('Max company items','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role3->caps->maxcompany;?>" name="uou_opt_plugins[acc][settings][role3][caps][maxcompany]"/>
                    <em><?php echo __('Set 0 for Unlimited OR -1 for Block','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Max blog post items','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role3->caps->maxpost;?>" name="uou_opt_plugins[acc][settings][role3][caps][maxpost]"/>
                    <em><?php echo __('Set 0 for Unlimited OR -1 for Block','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Max events items','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role3->caps->maxevent;?>" name="uou_opt_plugins[acc][settings][role3][caps][maxevent]"/>
                    <em><?php echo __('Set 0 for Unlimited OR -1 for Block','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Max product items','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role3->caps->maxproduct;?>" name="uou_opt_plugins[acc][settings][role3][caps][maxproduct]">
                    <em><?php echo __('Set 0 for Unlimited OR -1 for Block','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Submit for Review Before Publish','metrodir'); ?></th>
                <td>
                    <label for="r3f-approve">
                        <input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][role3][caps][approve]" id="r1f-approve" <?php if (isset($UouPlugins->acc->settings->role3->caps->approve) && $UouPlugins->acc->settings->role3->caps->approve == "enable"){echo "checked";};?>>
                        <em><?php echo __('Yes','metrodir'); ?></em>
                    </label>
                </td>
            </tr>

            </tbody>
        </table>
    </div> <!-- . inside -->
</div>



<!-- 4 role settings-->
<div class="postbox closed">
    <div title="" class="handlediv"><br></div><h3><span><?php echo '4 - '.__('Account settings','metrodir'); ?></span></h3>
    <div class="inside">
        <table class="form-table">
            <tbody>

            <tr valign="top">
                <th scope="row"><?php echo __('Activate','metrodir').' 4 '.__('account','metrodir'); ?></th>
                <td>
                    <span><?php echo __('Yes','metrodir'); ?></span> <input type="radio" <?php if ($UouPlugins->acc->settings->role4->on == "true"){echo "checked";};?> value="true" name="uou_opt_plugins[acc][settings][role4][on]"/>
                    <span><?php echo __('No','metrodir'); ?></span> <input type="radio"  <?php if ($UouPlugins->acc->settings->role4->on == "false"){echo "checked";};?> value="false" name="uou_opt_plugins[acc][settings][role4][on]"/>
                    <br/><em><?php echo __('Select yes to enable this account.','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Account name','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role4->name;?>" name="uou_opt_plugins[acc][settings][role4][name]"/>
                    <em><?php echo __('Name for role','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Price','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role4->price;?>" name="uou_opt_plugins[acc][settings][role4][price]"/>
                    <em><?php echo __('set 0 for free','metrodir'); ?></em>
                </td>
            </tr>

            <tr>
                <th scope="row"><?php echo __('Payment period','metrodir'); ?></th>
                <td>
                    <select class=""  name="uou_opt_plugins[acc][settings][role4][period]">
                        <option <?php if ($UouPlugins->acc->settings->role4->period == "Year"){echo "selected";};?> value="Year"><?php echo __('Year','metrodir'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->role4->period == "Month"){echo "selected";};?> value="Month" class="level-0"><?php echo __('Month','metrodir'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->role4->period == "Week"){echo "selected";};?> value="Week" class="level-0"><?php echo __('Week','metrodir'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->role4->period == "Day"){echo "selected";};?> value="Day" class="level-0"><?php echo __('Day','metrodir'); ?></option>
                    </select>
            </tr>
            <tr valign="top">
                <th scope="row"><?php echo __('Expires period days','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role4->expr;?>" name="uou_opt_plugins[acc][settings][role4][expr]"/>
                    <em><?php echo __('set 0 for unlimited','metrodir'); ?></em>
                </td>
            </tr>

            </tbody>
        </table>
    </div> <!-- . inside -->
</div>

<!-- 3 role capabilities-->
<div class="postbox closed">
    <div title="" class="handlediv"><br></div><h3><span><?php echo '4 - '.__('Account capabilities','metrodir'); ?></span></h3>
    <div class="inside">
        <table class="form-table">
            <tbody>

            <tr valign="top">
                <th scope="row"><?php echo __('Enable set featured company','metrodir'); ?></th>
                <td>
                    <label for="r4f-activate">
                        <input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][role4][caps][featured]" id="r4f-activate" <?php if (isset($UouPlugins->acc->settings->role4->caps->featured) && $UouPlugins->acc->settings->role4->caps->featured == "enable"){echo "checked";};?>>
                        <span><?php echo __('Yes','metrodir'); ?></span>
                    </label>
                </td>
            </tr>

            <?php  if ($UouPlugins->stars->restriction == "enable"): ?>
                <tr valign="top">
                    <th scope="row"><?php echo __('Enable capability for Rating System','metrodir'); ?></th>
                    <td>
                        <label for="r4f-rat-activate">
                            <input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][role4][caps][rating]" id="r4f-rat-activate" <?php if (isset($UouPlugins->acc->settings->role4->caps->rating) && $UouPlugins->acc->settings->role4->caps->rating == "enable"){echo "checked";};?>>
                            <?php echo __('Yes','metrodir'); ?>
                        </label>
                    </td>
                </tr>
            <?php endif; ?>

            <tr valign="top">
                <th scope="row"><?php echo __('Max company items','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role4->caps->maxcompany;?>" name="uou_opt_plugins[acc][settings][role4][caps][maxcompany]"/>
                    <em><?php echo __('Set 0 for Unlimited OR -1 for Block','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Max blog post items','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role4->caps->maxpost;?>" name="uou_opt_plugins[acc][settings][role4][caps][maxpost]"/>
                    <em><?php echo __('Set 0 for Unlimited OR -1 for Block','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Max events items','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role4->caps->maxevent;?>" name="uou_opt_plugins[acc][settings][role4][caps][maxevent]"/>
                    <em><?php echo __('Set 0 for Unlimited OR -1 for Block','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Max product items','metrodir'); ?></th>
                <td>
                    <input type="text"  value="<?php echo $UouPlugins->acc->settings->role4->caps->maxproduct;?>" name="uou_opt_plugins[acc][settings][role4][caps][maxproduct]">
                    <em><?php echo __('Set 0 for Unlimited OR -1 for Block','metrodir'); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Submit for Review Before Publish','metrodir'); ?></th>
                <td>
                    <label for="r4f-approve">
                        <input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][role4][caps][approve]" id="r1f-approve" <?php if (isset($UouPlugins->acc->settings->role4->caps->approve) && $UouPlugins->acc->settings->role4->caps->approve == "enable"){echo "checked";};?>>
                        <em><?php echo __('Yes','metrodir'); ?></em>
                    </label>
                </td>
            </tr>

            </tbody>
        </table>
    </div> <!-- . inside -->
</div>

<div class="field field_type-checkbox">
    <p class="label">
        <label for="claim-activate"><?php echo __('Claim Listing','metrodir'); ?></label>
        <span><?php echo __('Enable Claim Listing','metrodir'); ?></span>
    </p>

    <div class="acf-input-wrap">
        <label for="claim-activate">
            <input type="checkbox" value="enable" name="uou_opt_plugins[claim][status]" id="claim-activate" <?php if (isset($UouPlugins->claim->status) && $UouPlugins->claim->status == "enable"){echo "checked";};?>>
            <?php echo __('Yes','metrodir'); ?>
        </label>
    </div>

    <div class="acf-input-wrap">

        <label for="claim-activate"><?php echo __('Default Role For Aprove Claim:','metrodir'); ?></label>
        <select class=""  name="uou_opt_plugins[claim][role]">
            <option <?php if ($UouPlugins->claim->role == "metrodir_role_1"){echo "selected";};?> value="metrodir_role_1"><?php echo $UouPlugins->acc->settings->role1->name; ?></option>
            <option <?php if ($UouPlugins->claim->role == "metrodir_role_2"){echo "selected";};?> value="metrodir_role_2" class="level-0"><?php echo $UouPlugins->acc->settings->role2->name; ?></option>
            <option <?php if ($UouPlugins->claim->role == "metrodir_role_3"){echo "selected";};?> value="metrodir_role_3" class="level-0"><?php echo $UouPlugins->acc->settings->role3->name; ?></option>
            <option <?php if ($UouPlugins->claim->role == "metrodir_role_4"){echo "selected";};?> value="metrodir_role_4" class="level-0"><?php echo $UouPlugins->acc->settings->role4->name; ?></option>
        </select>
        </label>
    </div>

</div>

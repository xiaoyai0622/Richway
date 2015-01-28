<div class="field field_type-checkbox">
    <p class="label">
        <label for="stars-activate">Activate rating system</label>
        Enable rating system
    </p>

    <div class="acf-input-wrap">
        <label for="stars-activate">
            <input type="checkbox" value="enable" name="uou_opt_plugins[stars][status]" id="stars-activate" <?php if ($UouPlugins->stars->status == "enable"){echo "checked";};?>>
            Yes
        </label>
    </div>
</div>

<div class="field field_type-checkbox">
    <p class="label">
        <label for="stars-restr">Introduce restrictions for package</label>
        If activate set restrictions options for package at <a href="<?php echo admin_url('admin.php?page=siteoptions-plugins&tabs=acc'); ?>">Metrodir CP -> UOU addons -> Account Settings</a>
    </p>

    <div class="acf-input-wrap">
        <label for="stars-restr">
            <input type="checkbox" value="enable" name="uou_opt_plugins[stars][restriction]" id="stars-restr" <?php if (isset($UouPlugins->stars->restriction) && $UouPlugins->stars->restriction == "enable"){echo "checked";};?>>
            Yes
        </label>
    </div>
</div>

<div class="field field_type-text">
    <p class="label">
        <label for="stars-holdtime">IP hold time</label>
        Time (minutes) hold IP-address for vote
    </p>

    <div class="acf-input-wrap">
        <input id="stars-holdtime" type="text" class="text" name="uou_opt_plugins[stars][settings][holdtime]" value="<?php echo $UouPlugins->stars->settings->holdtime;?>" placeholder="">
    </div>
</div>


<div class="field field_type-text">
    <p class="label">
        <label>Stars settings</label>
    </p>

    <table class="uou-input-table row_layout">
        <tbody>
        <tr class="row">
            <td class="order">1 rating</td>

            <td>
                <table class="widefat">
                    <tbody>
                    <tr>
                        <td class="label">
                            <label for="stars-star-1-activate">Activate</label>
                        </td>
                        <td>
                            <label for="stars-star-1-activate">
                                <input type="checkbox" value="enable" name="uou_opt_plugins[stars][settings][rating][n1][on]" id="stars-star-1-activate" <?php if ($UouPlugins->stars->settings->rating->n1->on == "enable"){echo "checked";};?>>
                                Yes
                            </label>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">
                            <label for="stars-star-1-name">Name</label>
                        </td>

                        <td>
                            <input id="stars-star-1-name" type="text" class="text" name="uou_opt_plugins[stars][settings][rating][n1][name]" value="<?php echo $UouPlugins->stars->settings->rating->n1->name;?>" placeholder="">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>

        <tr class="row">
            <td class="order">2 rating</td>

            <td>
                <table class="widefat">
                    <tbody>
                    <tr>
                        <td class="label">
                            <label for="stars-star-2-activate">Activate</label>
                        </td>
                        <td>
                            <label for="stars-star-2-activate">
                                <input type="checkbox" value="enable" name="uou_opt_plugins[stars][settings][rating][n2][on]" id="stars-star-2-activate" <?php if ($UouPlugins->stars->settings->rating->n2->on == "enable"){echo "checked";};?>>
                                Yes
                            </label>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">
                            <label for="stars-star-2-name">Name</label>
                        </td>

                        <td>
                            <input id="stars-star-2-name" type="text" class="text" name="uou_opt_plugins[stars][settings][rating][n2][name]" value="<?php echo $UouPlugins->stars->settings->rating->n2->name;?>" placeholder="">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>

        <tr class="row">
            <td class="order">3 rating</td>

            <td>
                <table class="widefat">
                    <tbody>
                    <tr>
                        <td class="label">
                            <label for="stars-star-3-activate">Activate</label>
                        </td>
                        <td>
                            <label for="stars-star-3-activate">
                                <input type="checkbox" value="enable" name="uou_opt_plugins[stars][settings][rating][n3][on]" id="stars-star-3-activate" <?php if ($UouPlugins->stars->settings->rating->n3->on == "enable"){echo "checked";};?>>
                                Yes
                            </label>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">
                            <label for="stars-star-3-name">Name</label>
                        </td>

                        <td>
                            <input id="stars-star-3-name" type="text" class="text" name="uou_opt_plugins[stars][settings][rating][n3][name]" value="<?php echo $UouPlugins->stars->settings->rating->n3->name;?>" placeholder="">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>

        <tr class="row">
            <td class="order">4 rating</td>

            <td>
                <table class="widefat">
                    <tbody>
                    <tr>
                        <td class="label">
                            <label for="stars-star-4-activate">Activate</label>
                        </td>
                        <td>
                            <label for="stars-star-4-activate">
                                <input type="checkbox" value="enable" name="uou_opt_plugins[stars][settings][rating][n4][on]" id="stars-star-4-activate" <?php if ($UouPlugins->stars->settings->rating->n4->on == "enable"){echo "checked";};?>>
                                Yes
                            </label>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">
                            <label for="stars-star-4-name">Name</label>
                        </td>

                        <td>
                            <input id="stars-star-4-name" type="text" class="text" name="uou_opt_plugins[stars][settings][rating][n4][name]" value="<?php echo $UouPlugins->stars->settings->rating->n4->name;?>" placeholder="">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>

        </tbody>
    </table>

</div>
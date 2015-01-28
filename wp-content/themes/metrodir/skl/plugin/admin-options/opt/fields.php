<div class="psdg-header"></div>
<div id="psdgraphics-com-table">
    <table border="0" cellspacing="2" cellpadding="2">
        <caption><span class="psdg-bold">Restriction Fields for Company</span><br/>View and modify restrictions field associates with each Glocal role.</caption>
        <tbody>
            <tr id="psdg-top">
                <th class="psdg-top-cell">Name</th>
                <th class="psdg-top-cell">Options</th>
                <th class="psdg-top-cell"><?php if ($UouPlugins->acc->settings->role1->on == "false"){echo '<i class="fa fa-times" style="color: red;"></i>';} echo $UouPlugins->acc->settings->role1->name;?></th>
                <th class="psdg-top-cell"><?php if ($UouPlugins->acc->settings->role2->on == "false"){echo '<i class="fa fa-times" style="color: red;"></i>';} echo $UouPlugins->acc->settings->role2->name;?></th>
                <th class="psdg-top-cell"><?php if ($UouPlugins->acc->settings->role3->on == "false"){echo '<i class="fa fa-times" style="color: red;"></i>';} echo $UouPlugins->acc->settings->role3->name;?></th>
                <th class="psdg-top-cell"><?php if ($UouPlugins->acc->settings->role4->on == "false"){echo '<i class="fa fa-times" style="color: red;"></i>';} echo $UouPlugins->acc->settings->role4->name;?></th>
            </tr>
            <tr id="psdg-middle">
                <td class="psdg-left"><?php echo __('Founded','glocal'); ?></td>
                <td class="psdg-right">
                    <select class=""  name="uou_opt_plugins[acc][settings][fields][founded][options]">
                        <option <?php if ($UouPlugins->acc->settings->fields->founded->options == "public"){echo "selected";};?> value="public"><?php echo __('Public','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->founded->options == "private"){echo "selected";};?> value="private" class="level-0"><?php echo __('Private','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->founded->options == "custom"){echo "selected";};?> value="custom" class="level-0"><?php echo __('Custom option','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->founded->options == "remove"){echo "selected";};?> value="remove" class="level-0"><?php echo __('Remove','uou_admin'); ?></option>
                    </select>
                </td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][founded][role1]" <?php if (isset($UouPlugins->acc->settings->fields->founded->role1) && $UouPlugins->acc->settings->fields->founded->role1 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][founded][role2]" <?php if (isset($UouPlugins->acc->settings->fields->founded->role2) && $UouPlugins->acc->settings->fields->founded->role2 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][founded][role3]" <?php if (isset($UouPlugins->acc->settings->fields->founded->role3) && $UouPlugins->acc->settings->fields->founded->role3 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][founded][role4]" <?php if (isset($UouPlugins->acc->settings->fields->founded->role4) && $UouPlugins->acc->settings->fields->founded->role4 == "enable"){echo "checked";};?>></td>
            </tr>
            <tr id="psdg-middle">
                <td class="psdg-left"><?php echo __('Legal Entity','glocal'); ?></td>
                <td class="psdg-right">
                    <select class=""  name="uou_opt_plugins[acc][settings][fields][legal][options]">
                        <option <?php if ($UouPlugins->acc->settings->fields->legal->options == "public"){echo "selected";};?> value="public"><?php echo __('Public','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->legal->options == "private"){echo "selected";};?> value="private" class="level-0"><?php echo __('Private','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->legal->options == "custom"){echo "selected";};?> value="custom" class="level-0"><?php echo __('Custom option','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->legal->options == "remove"){echo "selected";};?> value="remove" class="level-0"><?php echo __('Remove','uou_admin'); ?></option>
                    </select>
                </td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][legal][role1]" <?php if (isset($UouPlugins->acc->settings->fields->legal->role1) && $UouPlugins->acc->settings->fields->legal->role1 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][legal][role2]" <?php if (isset($UouPlugins->acc->settings->fields->legal->role2) && $UouPlugins->acc->settings->fields->legal->role2 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][legal][role3]" <?php if (isset($UouPlugins->acc->settings->fields->legal->role3) && $UouPlugins->acc->settings->fields->legal->role3 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][legal][role4]" <?php if (isset($UouPlugins->acc->settings->fields->legal->role4) && $UouPlugins->acc->settings->fields->legal->role4 == "enable"){echo "checked";};?>></td>
            </tr>
            <tr id="psdg-middle">
                <td class="psdg-left"><?php echo __('Turnover','glocal'); ?></td>
                <td class="psdg-right">
                    <select class=""  name="uou_opt_plugins[acc][settings][fields][turnover][options]">
                        <option <?php if ($UouPlugins->acc->settings->fields->turnover->options == "public"){echo "selected";};?> value="public"><?php echo __('Public','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->turnover->options == "private"){echo "selected";};?> value="private" class="level-0"><?php echo __('Private','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->turnover->options == "custom"){echo "selected";};?> value="custom" class="level-0"><?php echo __('Custom option','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->turnover->options == "remove"){echo "selected";};?> value="remove" class="level-0"><?php echo __('Remove','uou_admin'); ?></option>
                    </select>
                </td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][turnover][role1]" <?php if (isset($UouPlugins->acc->settings->fields->turnover->role1) && $UouPlugins->acc->settings->fields->turnover->role1 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][turnover][role2]" <?php if (isset($UouPlugins->acc->settings->fields->turnover->role2) && $UouPlugins->acc->settings->fields->turnover->role2 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][turnover][role3]" <?php if (isset($UouPlugins->acc->settings->fields->turnover->role3) && $UouPlugins->acc->settings->fields->turnover->role3 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][turnover][role4]" <?php if (isset($UouPlugins->acc->settings->fields->turnover->role4) && $UouPlugins->acc->settings->fields->turnover->role4 == "enable"){echo "checked";};?>></td>
            </tr>
            <tr id="psdg-middle">
                <td class="psdg-left"><?php echo __('Number of Employees','glocal'); ?></td>
                <td class="psdg-right">
                    <select class=""  name="uou_opt_plugins[acc][settings][fields][nempls][options]">
                        <option <?php if ($UouPlugins->acc->settings->fields->nempls->options == "public"){echo "selected";};?> value="public"><?php echo __('Public','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->nempls->options == "private"){echo "selected";};?> value="private" class="level-0"><?php echo __('Private','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->nempls->options == "custom"){echo "selected";};?> value="custom" class="level-0"><?php echo __('Custom option','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->nempls->options == "remove"){echo "selected";};?> value="remove" class="level-0"><?php echo __('Remove','uou_admin'); ?></option>
                    </select>
                </td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][nempls][role1]" <?php if (isset($UouPlugins->acc->settings->fields->nempls->role1) && $UouPlugins->acc->settings->fields->nempls->role1 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][nempls][role2]" <?php if (isset($UouPlugins->acc->settings->fields->nempls->role2) && $UouPlugins->acc->settings->fields->nempls->role2 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][nempls][role3]" <?php if (isset($UouPlugins->acc->settings->fields->nempls->role3) && $UouPlugins->acc->settings->fields->nempls->role3 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][nempls][role4]" <?php if (isset($UouPlugins->acc->settings->fields->nempls->role4) && $UouPlugins->acc->settings->fields->nempls->role4 == "enable"){echo "checked";};?>></td>
            </tr>
            <tr id="psdg-middle">
                <td class="psdg-left"><?php echo __('Phone','glocal'); ?></td>
                <td class="psdg-right">
                    <select class=""  name="uou_opt_plugins[acc][settings][fields][phone][options]">
                        <option <?php if ($UouPlugins->acc->settings->fields->phone->options == "public"){echo "selected";};?> value="public"><?php echo __('Public','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->phone->options == "private"){echo "selected";};?> value="private" class="level-0"><?php echo __('Private','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->phone->options == "custom"){echo "selected";};?> value="custom" class="level-0"><?php echo __('Custom option','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->phone->options == "remove"){echo "selected";};?> value="remove" class="level-0"><?php echo __('Remove','uou_admin'); ?></option>
                    </select>
                </td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][phone][role1]" <?php if (isset($UouPlugins->acc->settings->fields->phone->role1) && $UouPlugins->acc->settings->fields->phone->role1 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][phone][role2]" <?php if (isset($UouPlugins->acc->settings->fields->phone->role2) && $UouPlugins->acc->settings->fields->phone->role2 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][phone][role3]" <?php if (isset($UouPlugins->acc->settings->fields->phone->role3) && $UouPlugins->acc->settings->fields->phone->role3 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][phone][role4]" <?php if (isset($UouPlugins->acc->settings->fields->phone->role4) && $UouPlugins->acc->settings->fields->phone->role4 == "enable"){echo "checked";};?>></td>
            </tr>
            <tr id="psdg-middle">
                <td class="psdg-left"><?php echo __('Fax','glocal'); ?></td>
                <td class="psdg-right">
                    <select class=""  name="uou_opt_plugins[acc][settings][fields][fax][options]">
                        <option <?php if ($UouPlugins->acc->settings->fields->fax->options == "public"){echo "selected";};?> value="public"><?php echo __('Public','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->fax->options == "private"){echo "selected";};?> value="private" class="level-0"><?php echo __('Private','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->fax->options == "custom"){echo "selected";};?> value="custom" class="level-0"><?php echo __('Custom option','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->fax->options == "remove"){echo "selected";};?> value="remove" class="level-0"><?php echo __('Remove','uou_admin'); ?></option>
                    </select>
                </td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][fax][role1]" <?php if (isset($UouPlugins->acc->settings->fields->fax->role1) && $UouPlugins->acc->settings->fields->fax->role1 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][fax][role2]" <?php if (isset($UouPlugins->acc->settings->fields->fax->role2) && $UouPlugins->acc->settings->fields->fax->role2 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][fax][role3]" <?php if (isset($UouPlugins->acc->settings->fields->fax->role3) && $UouPlugins->acc->settings->fields->fax->role3 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][fax][role4]" <?php if (isset($UouPlugins->acc->settings->fields->fax->role4) && $UouPlugins->acc->settings->fields->fax->role4 == "enable"){echo "checked";};?>></td>
            </tr>
            <tr id="psdg-middle">
                <td class="psdg-left"><?php echo __('E-mail','glocal'); ?></td>
                <td class="psdg-right">
                    <select class=""  name="uou_opt_plugins[acc][settings][fields][email][options]">
                        <option <?php if ($UouPlugins->acc->settings->fields->email->options == "public"){echo "selected";};?> value="public"><?php echo __('Public','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->email->options == "private"){echo "selected";};?> value="private" class="level-0"><?php echo __('Private','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->email->options == "custom"){echo "selected";};?> value="custom" class="level-0"><?php echo __('Custom option','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->email->options == "remove"){echo "selected";};?> value="remove" class="level-0"><?php echo __('Remove','uou_admin'); ?></option>
                    </select>
                </td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][email][role1]" <?php if (isset($UouPlugins->acc->settings->fields->email->role1) && $UouPlugins->acc->settings->fields->email->role1 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][email][role2]" <?php if (isset($UouPlugins->acc->settings->fields->email->role2) && $UouPlugins->acc->settings->fields->email->role2 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][email][role3]" <?php if (isset($UouPlugins->acc->settings->fields->email->role3) && $UouPlugins->acc->settings->fields->email->role3 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][email][role4]" <?php if (isset($UouPlugins->acc->settings->fields->email->role4) && $UouPlugins->acc->settings->fields->email->role4 == "enable"){echo "checked";};?>></td>
            </tr>
            <tr id="psdg-middle">
                <td class="psdg-left"><?php echo __('Website','glocal'); ?></td>
                <td class="psdg-right">
                    <select class=""  name="uou_opt_plugins[acc][settings][fields][website][options]">
                        <option <?php if ($UouPlugins->acc->settings->fields->website->options == "public"){echo "selected";};?> value="public"><?php echo __('Public','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->website->options == "private"){echo "selected";};?> value="private" class="level-0"><?php echo __('Private','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->website->options == "custom"){echo "selected";};?> value="custom" class="level-0"><?php echo __('Custom option','uou_admin'); ?></option>
                        <option <?php if ($UouPlugins->acc->settings->fields->website->options == "remove"){echo "selected";};?> value="remove" class="level-0"><?php echo __('Remove','uou_admin'); ?></option>
                    </select>
                </td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][website][role1]" <?php if (isset($UouPlugins->acc->settings->fields->website->role1) && $UouPlugins->acc->settings->fields->website->role1 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][website][role2]" <?php if (isset($UouPlugins->acc->settings->fields->website->role2) && $UouPlugins->acc->settings->fields->website->role2 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][website][role3]" <?php if (isset($UouPlugins->acc->settings->fields->website->role3) && $UouPlugins->acc->settings->fields->website->role3 == "enable"){echo "checked";};?>></td>
                <td class="psdg-right"><input type="checkbox" value="enable" name="uou_opt_plugins[acc][settings][fields][website][role4]" <?php if (isset($UouPlugins->acc->settings->fields->website->role4) && $UouPlugins->acc->settings->fields->website->role4 == "enable"){echo "checked";};?>></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="psdg-footer">
    *Public: the information is visible to everyone<br/>
    *Private: the information is visible to members or to specific to a membership plan<br/>
    *Custom option: the information can only be published if the user has the selected a specific package<br/>
</div>
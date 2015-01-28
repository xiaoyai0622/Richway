<?php
$import = CompanyImport::get_instance();
?>
<div class="wrap">

	<h2> <img src="<?php echo get_template_directory_uri().'/skl/framework/img/skl.png' ?>" alt=""><?php echo __(' metrodir CSV Companies Bulk Import','metrodir_import'); ?></h2>
	
	<?php 
	// settings update
	if(isset($_POST["encoding"]) AND isset($_POST["delim"])) {
		update_option( 'import_encoding', $_POST["encoding"] );
        update_option( 'import_delim', $_POST["delim"] );
		echo '<div class="updated"><p>'.__('Settings successfully saved','metrodir_import').'</p></div>';
	}
	// uploaded company file
	if(isset($_FILES["posts_csv"]) && isset($_POST["type"])) {
		if ($_FILES["posts_csv"]["error"] > 0) {
			echo '<div class="error"><p>'.__('Incorrect CSV filem, please check file.','metrodir_import').'</p></div>';
		} else {
			$import->import_csv($_POST["type"],$_FILES["posts_csv"]['tmp_name'],$_POST["duplicate"]);
		}
		
	}
	// uploaded categories file
	if(isset($_FILES["categories_csv"]) && isset($_POST["type"])) {
		if ($_FILES["categories_csv"]["error"] > 0) {
            echo '<div class="error"><p>'.__('Incorrect CSV filem, please check file.','metrodir_import').'</p></div>';
		} else {
			$import->import_terms_csv($_POST["type"],$_FILES["categories_csv"]['tmp_name'],$_POST["duplicate"]);
		}
	}
	?>
    <div id="admin-tabs">

        <ul class="tabs">
            <li class="bpanel-tab current" style="padding-left: 5px;"><a href="#company"><i class="fa fa-map-marker fa-lg"></i>Company import</a></li>
            <li class="bpanel-tab" style="padding-left: 5px;"><a href="#category"><i class="fa fa-sitemap fa-lg"></i>Category import</a></li>
            <li class="bpanel-tab" style="padding-left: 5px;"><a href="#settings"><i class="fa fa-wrench fa-lg"></i>Settings</a></li>
        </ul>

        <div id="company">
            <?php
            foreach ($import->post_types as $type) { ?>
                <div class="import-custom-type metabox-holder" style="padding-top: 38px;">
                    <div class="import-options postbox">
                        <div class="handlediv" title="Click to toggle"><br></div>
                        <h3 class="hndle"><span>Company Post Type</span></h3>
                        <div class="inside">
                            <form action="admin.php?page=company-import" method="post" enctype="multipart/form-data">
                                <h4><?php _e('Import companies from CSV file','metrodir_import'); ?></h4>
                                <input type="hidden" name="type" value="<?php echo $type->id; ?>">
                                <input type="file" name="posts_csv"><br><br>
                                <input type="radio" name="duplicate" value="1" checked="checked"> <?php _e("Replace existing name/slug","metrodir_import"); ?> <br>
                                <input type="radio" name="duplicate" value="2"> <?php _e("Update existing name/slug","metrodir_import"); ?> <br><br>
                                <input type="submit" value="<?php _e("Import companies from CSV","metrodir_import"); ?>" class="upload button-primary">
                            </form>
                            <form action="<?php echo get_template_directory_uri() . '/skl/plugin/import-company/download.php'; ?>" method="post">
                                <h4><?php _e("Create template csv files:","metrodir_import"); ?></h4>
                                <table style="width: 100%;">
                                    <tr style="text-align: left;">
                                        <th><?php _e('Parameter','metrodir_import'); ?></th><th><?php _e('Column name','metrodir_import'); ?></th><th><?php _e('Variable','metrodir_import'); ?></th>
                                    </tr>
                                    <?php foreach ($type->default_options as $param_name => $option) { ?>
                                        <tr>
                                            <td><input type="checkbox" name="<?php echo $param_name; ?>" checked="checked"> <?php echo $option['label']; ?></td>
                                            <td><?php echo $param_name; ?></td>
                                            <td><?php echo $option['notice']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if(isset($type->meta_options)) { foreach ($type->meta_options as $param_name => $option) { ?>
                                        <tr>
                                            <td><input type="checkbox" name="<?php echo $param_name; ?>" checked="checked"> <?php echo $option['label']; ?></td>
                                            <td><?php echo $param_name; ?></td>
                                            <td><?php echo $option['notice']; ?></td>
                                        </tr>
                                    <?php } } ?>
                                    <?php if(isset($type->taxonomies)) { foreach ($type->taxonomies as $key => $tax) { ?>
                                        <tr>
                                            <td><input type="checkbox" name="tax-<?php echo $key; ?>" checked="checked"> <?php echo $tax->name; ?></td>
                                            <td><?php echo 'tax-'.$key; ?></td>
                                            <td><?php __('Taxonomy (example: cat1,cat2)','metrodir_import'); ?></td>
                                        </tr>
                                    <?php } } ?>
                                </table>
                                <input type="hidden" name="company-post-type" value="<?php echo $type->id; ?>">
                                <input type="hidden" name="company-metrodir-type" value="yes">
                                <input type="submit" value="<?php _e('Generate sample CSV file', "metrodir_import"); ?>" class="download button">
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>


        <div id="category">
            <?php
            foreach ($import->post_types as $type) { ?>
                <div class="import-custom-type metabox-holder" style="padding-top: 38px;">
                    <div class="import-options postbox">
                        <h3 class="hndle"><span>Company Categories</span></h3>
                        <div class="inside">
                            <?php if(isset($type->taxonomies)) { foreach ($type->taxonomies as $key => $tax) { ?>
                                <form action="admin.php?page=company-import" method="post" enctype="multipart/form-data">

                                    <h4><?php _e('Import companies categories from CSV file', 'metrodir_import'); ?></h4>
                                    <input type="hidden" name="type" value="<?php echo $tax->id; ?>">
                                    <input type="radio" name="duplicate" value="1" checked="checked"> <?php _e("Replace existing name/slug","metrodir_import"); ?> <br>
                                    <input type="radio" name="duplicate" value="2"> <?php _e("Update existing name/slug","metrodir_import"); ?> <br>
                                    <input type="file" name="categories_csv">
                                    <input type="submit" value="<?php _e('Import categories from CSV','metrodir_import'); ?>" class="upload button-primary">

                                </form>
                                <form action="<?php echo get_template_directory_uri() . '/skl/plugin/import-company/download.php'; ?>" method="post">
                                    <h4><?php _e("Create template csv files:","metrodir_import"); ?></h4>
                                    <table style="width: 100%;">
                                        <tr style="text-align: left;">
                                            <th><?php _e('Parameter', 'metrodir_import'); ?></th><th><?php _e('Column name', 'metrodir_import'); ?></th><th><?php _e('Variable', 'metrodir_import'); ?></th>
                                        </tr>
                                        <?php foreach ($tax->default_options as $param_name => $option) { ?>
                                            <tr>
                                                <td><input type="checkbox" name="<?php echo $param_name; ?>" checked="checked"> <?php echo $option['label']; ?></td>
                                                <td><?php echo $param_name; ?></td>
                                                <td><?php echo $option['notice']; ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if(isset($tax->meta_options)) { foreach ($tax->meta_options as $param_name => $option) { ?>
                                            <tr>
                                                <td><input type="checkbox" name="<?php echo $param_name; ?>" checked="checked"> <?php echo $option; ?></td>
                                                <td><?php echo $param_name; ?></td>
                                                <td></td>
                                            </tr>
                                        <?php } } ?>
                                    </table>
                                    <input type="hidden" name="company-post-type" value="<?php echo $tax->id; ?>">
                                    <input type="submit" value="<?php _e('Generate sample CSV file', "metrodir_import"); ?>" class="download button">
                                </form>
                            <?php } } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>


        <div id="settings">
            <div class="import-settings metabox-holder" style="padding-top: 37px;">
                <div class="import-options postbox">
                    <div class="handlediv" title="Click to toggle"><br></div>
                    <h3 class="hndle"><span><?php _e('Import settings','metrodir_import'); ?></span></h3>
                    <div class="inside">
                        <?php
                              $read_encoding = get_option( 'import_encoding', '25' );
                              $read_delim = get_option( 'import_delim' );
                        ?>
                        <form action="admin.php?page=company-import" method="post">
                            <label for="import-encoding"><?php _e('Encoding CSV file: ', 'metrodircp_bulk'); ?></label>
                            <select name="encoding" id="import-encoding">
                                <?php foreach (mb_list_encodings() as $key => $value) {
                                    if($key == intval($read_encoding)) {
                                        echo "<option selected='selected' value='$key'>$value</option>";
                                    } else {
                                        echo "<option value='$key'>$value</option>";
                                    }
                                } ?>
                            </select> <br/>
                            <label for="import-delim"><?php _e('Delimiter CSV file: ', 'metrodircp_bulk'); ?></label>
                            <select name="delim" id="mport-delim">
                                <option value=";" <?php if($read_delim == ";"): echo "selected"; endif; ?>>;</option>
                                <option value="," <?php if($read_delim == ","): echo "selected"; endif; ?>>,</option>
                            </select> <br/>
                            <input type="submit" value="<?php _e('Save settings', 'metrodircp_bulk'); ?>" class="save button">
                        </form>
                    </div>
                </div>
        </div>
    </div>
</div>
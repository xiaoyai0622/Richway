<?php
if(isset($_GET['specification'])) $metrodir_megasearch_spec = $_GET['specification']; else $metrodir_megasearch_spec = '';
if(isset($_GET['s']) AND isset($_GET['search_megasearch'])) $words = $_GET['s']; else $words = '';

//Check icon for megasearch
if($metrodir_megasearch_spec == "all")
    $icon = "fa-globe";
elseif($metrodir_megasearch_spec == "company")
    $icon = "fa-briefcase";
elseif($metrodir_megasearch_spec == "event")
    $icon = "fa-plane";
elseif($metrodir_megasearch_spec == "product")
    $icon = "fa-gift";
elseif($metrodir_megasearch_spec == "post")
    $icon = "fa-file-o";
else
    $icon = "fa-align-justify";

?>
<div class="megasearch-container">

    <div class="megasearch-container-inner">

        <div class="megasearch-select">
            <div class="megasearch-select-button"><i class="fa <?php if ($icon == "fa-align-justify") echo $icon; else echo $icon.' fa-lg'; ?>"></i></div>
            <ul class="megasearch-select-list">
                <li class="all<?php if($metrodir_megasearch_spec == "all") echo " active";?>"><i class="fa fa-globe"></i><?php echo __('General Search', 'metrodir_site'); ?></li>
                <li class="company<?php if($metrodir_megasearch_spec == "company") echo " active";?>"><i class="fa fa-briefcase"></i><?php echo __('Companies', 'metrodir_site'); ?></li>
                <?php if ( is_plugin_active('events-manager/events-manager.php') ): ?>
                <li class="event<?php if($metrodir_megasearch_spec == "event") echo " active";?>"><i class="fa fa-plane"></i><?php echo __('Events', 'metrodir_site'); ?></li>
                <?php endif; ?>
                <?php if ( is_plugin_active('woocommerce/woocommerce.php') ): ?>
                <li class="product<?php if($metrodir_megasearch_spec == "product") echo " active";?>"><i class="fa fa-gift"></i><?php echo __('Products & Services', 'metrodir_site'); ?></li>
                <?php endif; ?>
                <li class="post<?php if($metrodir_megasearch_spec == "post") echo " active";?>"><i class="fa fa-file-o"></i><?php echo __('Blogs', 'metrodir_site'); ?></li>
            </ul>
        </div>
        <form action="<?php echo home_url(); ?>">
            <input id="megasearch-keywords" type="text" name="s" value="<?php echo $words; ?>" placeholder="<?php echo __('Search...', 'metrodir_site'); ?>"/>
            <input id="megasearch-specification" type="hidden" name="specification"  value="<?php if($metrodir_megasearch_spec){echo $metrodir_megasearch_spec;}else{echo "all";} ?>"/>
            <input id="search_megasearch" type="hidden" name="search_megasearch"  value="search"/>
            <input type="submit"/>
        </form>
        <div class="search-button-fake"><i class="fa fa-search"></i></div>

    </div>

</div>
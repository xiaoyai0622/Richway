<?php

get_header();

//Sidebar options
$opt_metrodir_sidebar = get_option('opt_metrodir_sidebar');
?>

<!-- Content --><div id="content" class="caterogy-list">

    <?php if(!is_front_page()): ?>
        <?php get_template_part('/include/html/frame','breadcrumbs')?>
    <?php endif; ?>

    <!-- Content Inner --><div id="content-inner" class="sidebar-<?php echo $opt_metrodir_sidebar; ?>"><div class="box-container">

        <!-- Sidebar --><div id="sidebar">

            <?php get_template_part('/include/html/frame','sidebar-blog'); ?>

        </div><!-- /Sidebar -->

        <!-- Content Center --><div id="content-center">

            <div id="caterogy-list-block">
                <?php get_template_part('loop-blog') ;?>
            </div>

        </div><!-- /Content Center -->

        <div class="clear"></div>

    </div></div><!-- /Content Inner -->

</div><!-- /Content -->

<?php get_template_part ('footer');



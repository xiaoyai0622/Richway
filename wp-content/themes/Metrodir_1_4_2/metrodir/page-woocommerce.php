<?php
get_header();
//Sidebar options
$opt_metrodir_sidebar = get_option('opt_metrodir_sidebar');
?>

    <!-- Content --><div id="content" class="sample">

    <?php get_template_part('/include/html/frame','breadcrumbs')?>

    <!-- Content Inner --><div id="content-inner" class="sidebar-<?php echo $opt_metrodir_sidebar; ?>"><div class="box-container">

            <!-- Sidebar --><div id="sidebar"><?php get_template_part('/include/html/frame','sidebar-single'); ?></div><!-- /Sidebar -->

            <!-- Content Center --><div id="content-center">

                <div class="project-body body">
                    <?php woocommerce_content(); ?>
                </div>

            </div><!-- /Content Center -->

            <div class="clear"></div>

        </div></div><!-- /Content Inner -->

</div><!-- /Content -->

<?php get_template_part ('footer');
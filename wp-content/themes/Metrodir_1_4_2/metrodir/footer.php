<?php
// Get variables metrodir_Options
//Site options
$opt_metrodir_footer_text = get_option('opt_metrodir_footer_text');
$opt_metrodir_footer_copyright = get_option('opt_metrodir_footer_copyright');
$opt_metrodir_footer_widget = get_option('opt_metrodir_footer_widget');
$opt_metrodir_scroll_top = get_option('opt_metrodir_site_scroll_top');
//Social links
$opt_metrodir_social_fb = get_option('opt_metrodir_social_fb');
$opt_metrodir_social_gp = get_option('opt_metrodir_social_gp');
$opt_metrodir_social_tw = get_option('opt_metrodir_social_tw');
$opt_metrodir_social_li = get_option('opt_metrodir_social_li');
$opt_metrodir_social_pt = get_option('opt_metrodir_social_pt');
$opt_metrodir_social_dr = get_option('opt_metrodir_social_dr');
//flickr_id
$opt_metrodir_flickr_id = get_option('opt_metrodir_flickr_id');
//twitter variables
$opt_metrodir_twitter_id = get_option('opt_metrodir_twitter_id');
$opt_metrodir_twitter_text = get_option('opt_metrodir_twitter_text');
$opt_metrodir_twitter_link = get_option('opt_metrodir_twitter_link');
if ($opt_metrodir_twitter_id && $opt_metrodir_twitter_text && $opt_metrodir_twitter_link ) $twitter_block = true; else $twitter_block = false;
// Class

$opt_metrodir_boxed_version = get_option('opt_metrodir_boxed_version');
$opt_metrodir_custom_css = get_option('opt_metrodir_custom_css');
$opt_metrodir_custom_js = get_option('opt_metrodir_custom_js');
$opt_metrodir_rtl = get_option('opt_metrodir_site_rtl');
$footer_class = '';
if (($opt_metrodir_boxed_version == 'yes') && ($opt_metrodir_rtl == "true")) {
    $footer_class = ' class="boxed rtl"';
} else if ($opt_metrodir_boxed_version == 'yes') {
    $footer_class = ' class="boxed no-rtl"';
} else if ($opt_metrodir_rtl == "true") {
    $footer_class = ' class="rtl"';
} else {
    $footer_class = ' class="no-rtl"';
}
?>

    <!-- Footer Mirror --><div id="footer-mirror"></div><!-- /Footer Mirror -->

</section><!-- /Section Wrapper --></section><!-- /Section Main -->

<!-- Footer --><footer<?php echo $footer_class; ?>>

    <!-- Footer Blocks --><div id="footer"><div class="box-container">
        <?php if($opt_metrodir_footer_widget == 'false'): ?>

            <?php if ($opt_metrodir_footer_text): ?>
            <!-- Description --><div class="description-text block">
                <div class="title"><h3><?php echo __('About Us', 'metrodir'); ?></h3></div>
                <div class="block-content"><p><?php echo $opt_metrodir_footer_text; ?></p></div>
            </div><!-- /Description -->
            <?php endif; ?>

            <?php if ($twitter_block): ?>
            <!-- Twitter Block --><div class="twitter-feed block">
                <div class="title"><h3><?php echo __('Recent Tweets','metrodir'); ?></h3></div>
                <div id="twitter-feed" class="block-content">
                    <?php  get_template_part ('/include/php/twitter') ;?>
                </div>
            </div><!-- /Twitter Block -->
            <?php endif; ?>

            <!-- Recent Posts --><div class="recent-posts block">
                <div class="title"><h3><?php echo __('Recent Posts','metrodir'); ?></h3></div>
                <div class="block-content">

                    <?php
                        global $wp_query;
                        query_posts(array(
                            'post_type' => array('post'),
                            'posts_per_page' => 3
                        ));
                    ?>

                    <?php get_template_part('loop-footer-post'); ?>

                    <?php wp_reset_query(); wp_reset_postdata(); ?>

                </div>
            </div><!-- /Recent Posts-->

            <?php if ($opt_metrodir_flickr_id): ?>
                <!-- Flickr Feed --><div class="flickr-feed block">
                    <div class="title"><h3><?php echo __('Flickr Feed','metrodir'); ?></h3></div>
                    <div id="flickr-feed" class="block-content"><?php echo $opt_metrodir_flickr_id; ?></div>
                </div><!-- /Flickr Feed -->
            <?php endif; ?>

        <?php else: ?>

            <?php if ($opt_metrodir_footer_text): ?>
                <!-- Description --><div class="description-text block">
                    <div class="title"><h3><?php echo __('About Us', 'metrodir'); ?></h3></div>
                    <div class="block-content"><p><?php echo $opt_metrodir_footer_text; ?></p></div>
                </div><!-- /Description -->
            <?php endif; ?>

            <!-- Dynamic Footer Content --><?php if ( !dynamic_sidebar( 'footer-widget-area' ) ) : ?><?php endif; ?><!-- /Dynamic Footer Content -->

        <?php endif; ?>
    </div></div><!-- /Footer Blocks -->

    <?php if ($opt_metrodir_footer_copyright): ?>
    <!-- Copyright --><div id="copyright"><div class="box-container">
        <!-- Copyright Text --><div class="copyright-text"><?php echo $opt_metrodir_footer_copyright; ?></div><!-- /Copyright Text -->
        <!-- Social Links --><ul class="social-links">
            <?php if($opt_metrodir_social_fb): ?>
                <li class="facebook"><a href="<?php echo $opt_metrodir_social_fb; ?>" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <?php endif; ?>
            <?php if($opt_metrodir_social_gp): ?>
                <li class="google"><a href="<?php echo $opt_metrodir_social_gp; ?>" title="Google +" target="_blank"><i class="fa fa-google-plus"></i></a></li>
            <?php endif; ?>
            <?php if($opt_metrodir_social_tw): ?>
                <li class="twitter"><a href="<?php echo $opt_metrodir_social_tw; ?>" title="Twitter" target="_blank"><i class="fa fa-twitter fa-lg"></i></a></li>
            <?php endif; ?>
            <?php if($opt_metrodir_social_li): ?>
                <li class="linkedin"><a href="<?php echo $opt_metrodir_social_li; ?>" title="Linkedin" target="_blank"><i class="fa fa-linkedin-square fa-lg"></i></a></li>
            <?php endif; ?>
            <?php if($opt_metrodir_social_pt): ?>
                <li class="pinterest"><a href="<?php echo $opt_metrodir_social_pt; ?>" title="Pinterest" target="_blank"><i class="fa fa-pinterest fa-lg"></i></a></li>
            <?php endif; ?>
            <?php if($opt_metrodir_social_dr): ?>
                <li class="dribbble"><a href="<?php echo $opt_metrodir_social_dr; ?>" title="Dribbble" target="_blank"><i class="fa fa-dribbble fa-lg"></i></a></li>
            <?php endif; ?>
        </ul><!-- /Social Links -->
    </div></div><!-- /Copyright -->
    <?php endif; ?>

</footer><!-- /Footer -->

<?php if ($opt_metrodir_scroll_top == "true"): ?>
    <!-- Scroll Top --><a class="scrollTop" href="#header" style="display: none;">
        <div id = "up_container">
            <span><i class="fa fa-chevron-up fa-2x"></i></span>
        </div>
    </a><!-- /Scroll Top -->
<?php endif; ?>

<?php if (isset($opt_metrodir_custom_css) AND $opt_metrodir_custom_css): ?>
    <style type="text/css">
        <?php echo $opt_metrodir_custom_css; ?>
    </style>
<?php endif; ?>

<?php wp_footer(); ?>

<?php if (isset($opt_metrodir_custom_js) AND $opt_metrodir_custom_js): ?>
    <script type="text/javascript">
        <?php echo $opt_metrodir_custom_js; ?>
    </script>
<?php endif; ?>

</body>
</html>



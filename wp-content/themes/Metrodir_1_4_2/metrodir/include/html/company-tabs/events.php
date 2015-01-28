<script>

    jQuery(function() {
        var $homeurl = jQuery('#get_homeurl').data('homeurl');
        var $divlist = jQuery('#events_list');
        var contentDiv  = jQuery('#ajax_load_event');
        var eventlink = $divlist.find('ul li a');
        var eventlinkid = $divlist.find('ul li');
        var eventdaylink = $divlist.find('a');

        jQuery(document).ready(function(){

                eventlink.click(function(data){
                var idevent = $(this).parent('div').parent('div').parent('li').attr('class');
                var loadingwheel = $('<img class="event-trobber" src="'+$homeurl+'/images/trobber.gif"/>');
                var ajaxdiv = jQuery('.ajax-content');
                var urlpost = '?get=event';

                ajaxContent = $('<div class="ajax-content"></div>').append(loadingwheel);
                contentDiv.find('>').hide();
                contentDiv.append(ajaxContent);

                jQuery.post(
                    urlpost,
                    {
                        action : 'get_event',
                        idevent : idevent

                    },
                    function( response ) {
                        ajaxContent = $('<div class="ajax-content"></div>').append(response);
                        contentDiv.find('>').hide();
                        contentDiv.append(ajaxContent);
                    }
                )
            return false;
            });

        });
    });
</script>

<?php
$events_array = json_decode(htmlspecialchars_decode(get_post_meta(get_the_ID(), 'metro_event', true)));
$count_events_arr = count((array)$events_array);
$post_event_id = array();
for($i=0; $i < $count_events_arr; $i++) {
    $post_event_id[$i] = $events_array->$i;
}
$main_event_id = $post_event_id[0];
?>

<?php if ($main_event_id): ?>

    <div id="get_homeurl" data-homeurl="<?php echo get_template_directory_uri(); ?>"></div>

    <div id="sidebar">

        <div id="events_list">
            <div class="title">
                <h2><?php echo __('Upcoming Events','metrodir'); ?></h2>
            </div>
            <?php
            $format = '
            <li class="#_EVENTPOSTID">
                <div class="event-date">
                    <div class="event-day-month">
                        <div class="event-day">#_uouDateday</div>
                        <div class="event-month">#_uouDatemonth</div>
                    </div>
                    <div class="event-year">#_uouDateyear</div>
                </div>
                <div class="event-desc">
                    <div class="event-desc-title">#_EVENTLINK</div>
                    <div class="event-desc-place">{has_location}<i>#_LOCATIONNAME, #_LOCATIONTOWN #_LOCATIONSTATE</i>{/has_location}</div>
                    <div class="event-desc-autor">by #_uouCompany</div>
                </div>
                <div style="clear: both;"></div>
            </li>
        ';
            $arg =   array(
                'post_id'=> $post_event_id,
                'format_header' => '<ul>',
                'format' => $format,
                'format_footer' => '</ul>',
            );
            if($post_event_id){
                echo EM_Events::output($arg);
            }
            ?>
        </div>

        <div class="company-social block">
            <div class="title">
                <h2><?php echo __('Share This Listing','metrodir'); ?></h2>
            </div>
            <?php get_template_part ('/include/php/share','social'); ?>
            <ul class="social-links">
                <li class="facebook"><a href="#social" title="Facebook" onClick="metrodir_share_FB()"><i class="fa fa-facebook"></i></a></li>
                <li class="google"><a href="#social" title="Google +"  onClick="metrodir_share_GP()"><i class="fa fa-google-plus"></i></a></li>
                <li class="twitter"><a href="#social" title="Twitter" onClick="metrodir_share_TW()"><i class="fa fa-twitter fa-lg"></i></a></li>
                <li class="linkedin"><a href="#social" title="Linkedin" onClick="metrodir_share_LI()"><i class="fa fa-linkedin-square fa-lg"></i></a></li>
                <li class="pinterest"><a href="#social" title="Pinterest" onClick="metrodir_share_PI()"><i class="fa fa-pinterest fa-lg"></i></a></li>
                <li class="dribbble"><a href="#social" title="Dribbble" onClick="metrodir_share_DB()"><i class="fa fa-dribbble fa-lg"></i></a></li>
            </ul>
        </div>

    </div>

    <div id="ajax_load_event" class="content-center">

        <div class="ajax-content">

            <?php
            if(isset($_POST['idevent'])) $post_event_id = $_POST['idevent'];

            $arg_single =   array(
                'post_id'=> $main_event_id,
                'format_header' => '<div class="blog-list-preview">',
                'format' => $format_single,
                'format_footer' => '</div>',
            );
            ?>

            <?php if($main_event_id): ?>
                <?php echo EM_Events::output($arg_single); ?>
            <?php endif; ?>

        </div>

    </div>

    <div class="clear"></div>

<?php else: ?>

    <!-- Message --><div id="message" class="notification-notice"><div class="box-container"><i class="fa fa-exclamation-circle"></i> <?php echo __('No Events','metrodir');?></div></div><!-- /Message -->

<?php endif; ?>
<?php // Get variables metrodir_Options
//Partners image and link
$opt_metrodir_partner[1]['img'] = get_option('opt_metrodir_partner_1');
$opt_metrodir_partner[1]['url'] = get_option('opt_metrodir_partner_1_url');
$opt_metrodir_partner[1]['dsp']= get_option('opt_metrodir_partner_1_dsp');
$opt_metrodir_partner[2]['img'] = get_option('opt_metrodir_partner_2');
$opt_metrodir_partner[2]['url'] = get_option('opt_metrodir_partner_2_url');
$opt_metrodir_partner[2]['dsp'] = get_option('opt_metrodir_partner_2_dsp');
$opt_metrodir_partner[3]['img'] = get_option('opt_metrodir_partner_3');
$opt_metrodir_partner[3]['url'] = get_option('opt_metrodir_partner_3_url');
$opt_metrodir_partner[3]['dsp'] = get_option('opt_metrodir_partner_3_dsp');
$opt_metrodir_partner[4]['img'] = get_option('opt_metrodir_partner_4');
$opt_metrodir_partner[4]['url'] = get_option('opt_metrodir_partner_4_url');
$opt_metrodir_partner[4]['dsp'] = get_option('opt_metrodir_partner_4_dsp');
$opt_metrodir_partner[5]['img'] = get_option('opt_metrodir_partner_5');
$opt_metrodir_partner[5]['url'] = get_option('opt_metrodir_partner_5_url');
$opt_metrodir_partner[5]['dsp'] = get_option('opt_metrodir_partner_5_dsp');
$opt_metrodir_partner[6]['img'] = get_option('opt_metrodir_partner_6');
$opt_metrodir_partner[6]['url'] = get_option('opt_metrodir_partner_6_url');
$opt_metrodir_partner[6]['dsp'] = get_option('opt_metrodir_partner_6_dsp');
$opt_metrodir_partner[7]['img'] = get_option('opt_metrodir_partner_7');
$opt_metrodir_partner[7]['url'] = get_option('opt_metrodir_partner_7_url');
$opt_metrodir_partner[7]['dsp'] = get_option('opt_metrodir_partner_7_dsp');
$opt_metrodir_partner[8]['img'] = get_option('opt_metrodir_partner_8');
$opt_metrodir_partner[8]['url'] = get_option('opt_metrodir_partner_8_url');
$opt_metrodir_partner[8]['dsp'] = get_option('opt_metrodir_partner_8_dsp');
$opt_metrodir_partner[9]['img'] = get_option('opt_metrodir_partner_9');
$opt_metrodir_partner[9]['url'] = get_option('opt_metrodir_partner_9_url');
$opt_metrodir_partner[9]['dsp'] = get_option('opt_metrodir_partner_9_dsp');
$opt_metrodir_partner[10]['img'] = get_option('opt_metrodir_partner_10');
$opt_metrodir_partner[10]['url'] = get_option('opt_metrodir_partner_10_url');
$opt_metrodir_partner[10]['dsp'] = get_option('opt_metrodir_partner_10_dsp');
?>


<?php if($opt_metrodir_partner[1]['dsp'] == "true" OR
         $opt_metrodir_partner[2]['dsp'] == "true" OR
         $opt_metrodir_partner[3]['dsp'] == "true" OR
         $opt_metrodir_partner[4]['dsp'] == "true" OR
         $opt_metrodir_partner[5]['dsp'] == "true" OR
         $opt_metrodir_partner[6]['dsp'] == "true" OR
         $opt_metrodir_partner[7]['dsp'] == "true" OR
         $opt_metrodir_partner[8]['dsp'] == "true" OR
         $opt_metrodir_partner[9]['dsp'] == "true" OR
         $opt_metrodir_partner[10]['dsp'] == "true"): ?>

    <!-- Partners --><div id="partners"><div class="box-container">

        <div class="title"><h2><?php echo __('Our Partners','metrodir'); ?></h2></div>

        <div id="partners-carusel" class="carusel"><ul class="slides">
            <?php
                $index=0;
                for ($i=1; $i<=10; $i++) {
                    if ($opt_metrodir_partner[$i]['dsp'] == 'true') {
                        $index++;
                        if ($index == 1) echo '<li>';
                        if ($index == 6) echo '</li><li>';
                        if ($opt_metrodir_partner[$i]['url']) echo '<a rel="nofollow" target="_blank" href="'.$opt_metrodir_partner[$i]['url'].'" class="partner opacity" style="background: url('.$opt_metrodir_partner[$i]['img'].') center center no-repeat;"></a>';
                        else echo '<span class="partner" style="background: url('.$opt_metrodir_partner[$i]['img'].') center center no-repeat;"></span>';
                    }
                }
                echo '</li>';
            ?>
        </ul></div>

        <!-- Clear --><div class="clear"></div><!-- /Clear -->

    </div></div><!-- /Partners -->

<?php endif; ?>
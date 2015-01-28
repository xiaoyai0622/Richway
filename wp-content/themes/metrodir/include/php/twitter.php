<?php
// Get variables
$opt_metrodir_twitter_id = get_option('opt_metrodir_twitter_id');
$opt_metrodir_twitter_text = get_option('opt_metrodir_twitter_text');
$opt_metrodir_twitter_link = get_option('opt_metrodir_twitter_link');
?>

<a class="twitter-timeline"  href="<?php echo $opt_metrodir_twitter_link; ?>"  data-widget-id="<?php echo $opt_metrodir_twitter_id; ?>"><?php echo $opt_metrodir_twitter_text; ?></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
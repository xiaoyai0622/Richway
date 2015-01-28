<?php
if (isset($custom[$shortname . '_company_gallery'][0])) $item_gallery = $custom[$shortname . '_company_gallery'][0];
if (isset($custom[$shortname . '_company_portfolio_grid'][0])) $grid_gallery = $custom[$shortname . '_company_portfolio_grid'][0];

if(!isset($grid_gallery)){ $grid_gallery = "column-1"; }
else if($grid_gallery == "1 column") $grid_gallery = "column-1";
else if($grid_gallery == "2 columns") $grid_gallery = "column-2";
else if($grid_gallery == "3 columns") $grid_gallery = "column-3";
else if($grid_gallery == "4 columns") $grid_gallery = "column-4";
?>

<?php
$gallery_images = json_decode(htmlspecialchars_decode(get_post_meta(get_the_ID(), 'metrodir_company_gallery', true)));
$count_arr = count((array)$gallery_images);
?>

<div id="portfolio-container" class="<?php echo $grid_gallery; ?>">

    <?php if(is_object($gallery_images) && $count_arr >= 1): ?>
        <?php $i = 1; $k = 1; ?>
        <?php foreach($gallery_images as $_img) { if($k == $i) { $main = wp_get_attachment_image_src($_img); } $k++; } $k = 1; ?>
        <?php foreach($gallery_images as $_img): ?>
            <?php $image = wp_get_attachment_image_src($_img, 'full'); ?>

                <div class="portfolio-item">

                    <div class="portfolio-image" style="background-image: url(<?php echo vt_resizer($image[0], '940', '460'); ?>);"></div>

                    <div class="portfolio-description">

                        <div class="portfolio-title"><?php the_title() ?></div>

                        <div class="portfolio-link"><a href="<?php echo $image[0]; ?>" target="_blank"><i class="fa fa-link"></i></a></div>

                        <div class="portfolio-zoom"><a href="<?php echo $image[0]; ?>" class="colorbox" target="_blank"><i class="fa fa-search-plus"></i></a></div>

                    </div>

                </div>

            <?php $k++; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="clear"></div>

</div>
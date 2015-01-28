<div id="company-<?php the_ID(); ?>" class="company-listing-thumb">

    <?php $custom_fields = get_post_custom(); ?>

    <div class="company-listing-thumb-image">

        <?php if ($custom_fields['metro_company_image1_url'][0]): ?>
            <div class="company-listing-thumb-photo" style="background-image: url(<?php echo $custom_fields['metro_company_image1_url'][0]; ?>);"></div>
        <?php elseif ( has_post_thumbnail()): ?>
            <?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large'); ?>
            <div class="company-listing-thumb-photo" style="background-image: url(<?php echo $large_image_url[0]; ?>);"></div>
        <?php else: ?>
            <div class="company-listing-thumb-photo"></div>
        <?php endif; ?>

        <?php if ($custom_fields['metro_featured'][0] == "on"): ?>
            <?php echo '<div class="company-listing-featured">'.__('Featured','metrodir').'</div>'; ?>
        <?php endif; ?>

        <div class="company-listing-thumb-overlay">
            <a href="<?php echo get_permalink(); ?>"><span><i class="fa fa-arrow-circle-right"></i><?php echo __('Read More','metrodir'); ?></span></a>
        </div>

        <?php //Get Rating variable
        $id = get_the_ID();
        $item = new stdClass();
        $item->rating = get_post_meta( $id, 'rating', true );
        ?>

        <?php if ($item->rating): ?>
            <div class="company-listing-thumb-rating">
                <?php for ($i = 1; $i <= $item->rating['max']; $i++): ?>
                    <i class="fa <?php if (($item->rating['val'] + 1 - $i) >= 1) echo "fa-star"; else if (($item->rating['val'] + 1 - $i) >= 0.5) echo "fa-star-half-o"; else echo 'fa-star-o'; ?> fa-lg"></i>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

    </div>

    <div class="company-listing-thumb-body">

        <div class="company-listing-thumb-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

        <?php
        $terms = get_the_terms( $post->ID, 'company_category' );
        $item_cats = ''; $i=0;
        if (!empty($terms)) {
            foreach ($terms as $term ) {
                $i++;
                if ($i == 1) { $item_cats = '<a href="'.get_term_link(intval($term->term_id), 'company_category').'" title="'.$term->name.'">'.$term->name.'</a>'; } else { $item_cats .= '<span>, </span><a href="'.get_term_link(intval($term->term_id), 'company_category').'" title="'.$term->name.'">'.$term->name.'</a>'; }
            }
        }
        ?>

        <div class="company-listing-thumb-categories">
            <?php echo $item_cats; ?>
        </div>

    </div>

</div>
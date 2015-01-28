<div id="company-<?php the_ID(); ?>" class="company-listing<?php if ( has_post_thumbnail()) echo ' with-image'; ?>">

    <?php $custom_fields = get_post_custom(); ?>

    <?php if( has_post_thumbnail()): ?>
        <div class="company-listing-image">
            <a class="opacity" href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail(array(140,140)); ?>
                <?php if ($custom_fields['metro_featured'][0] == "on"): ?>
                    <?php echo '<div class="company-listing-featured">'.__('Featured','metrodir').'</div>'; ?>
                <?php endif; ?>
            </a>
        </div>
    <?php endif; ?>

    <?php //Get Rating variable
        $id = get_the_ID();
        $item = new stdClass();
        $item->rating = get_post_meta( $id, 'rating', true );
    ?>

    <div class="company-listing-body<?php if ($item->rating) echo ' with-rating'; ?>">

        <?php // edit_post_link( __( 'Edit', 'metrodir' ), '<div class="company-listing-edit-link">', '</div>' ); ?>

        <div class="company-listing-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

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

        <div class="company-listing-categories">
            <?php echo $item_cats; ?>
        </div>

        <?php if ($item->rating): ?>
            <div class="company-listing-rating">
                <?php for ($i = 1; $i <= $item->rating['max']; $i++): ?>
                    <i class="fa <?php if (($item->rating['val'] + 1 - $i) >= 1) echo "fa-star"; else if (($item->rating['val'] + 1 - $i) >= 0.5) echo "fa-star-half-o"; else echo 'fa-star-o'; ?> fa-lg"></i>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

        <?php
        if(isset($custom_fields['metro_company_doc_desc'][0])){
            $company_desc = $custom_fields['metro_company_doc_desc'][0];
        }
        ?>

        <div class="company-listing-text">
            <?php echo $company_desc; ?>
        </div>

        <div class="company-listing-more"><a href="<?php echo get_permalink(); ?>"><i class="fa fa-arrow-circle-right"></i><?php echo __('Read More','metrodir'); ?></a></div>

    </div>

    <div class="clear"></div>

</div>
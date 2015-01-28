<?php
// Get variables
$opt_metrodir_home_featured = get_option('opt_metrodir_home_featured');
$opt_metrodir_home_featured_count = get_option('opt_metrodir_home_featured_count');

$opt_metrodir_home_latest = get_option('opt_metrodir_home_latest');
$opt_metrodir_home_latest_count = get_option('opt_metrodir_home_latest_count');

global $wp_query;

?>

<?php if ($opt_metrodir_home_featured == "true" OR $opt_metrodir_home_latest == "true"): ?>
<!-- Featured And Latest Companies --><div id="featured-and-latest-companies" class="home-companies<?php if ($opt_metrodir_home_featured == "true" AND $opt_metrodir_home_latest == "true") echo ' both'; ?>"><div class="box-container">

        <?php
            query_posts(array(
                'post_type' => array('company'),
                'meta_key' => 'metro_featured',
                'meta_query' => array(
                    array(
                        'key' => 'metro_featured',
                        'value' => 'on',
                        'compare' => '=',
                    )
                ),
                'posts_per_page' => $opt_metrodir_home_featured_count
            ));
        ?>

        <?php if ($opt_metrodir_home_featured == "true" AND have_posts() ): ?><!-- Featured Companies --><div id="featured-carusel">

            <div class="title"><h2><?php echo __('Featured Companies','metrodir'); ?></h2></div>

            <div class="home-companies-carusel carusel-auto"><ul class="slides">

                <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

                    <?php if( has_post_thumbnail() ): ?>
                        <li class="with-image"><div class="home-companies-image"><a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>" class="opacity"><?php echo get_the_post_thumbnail(get_the_ID(),array(220,220)); ?></a></div>
                    <?php else: ?>
                        <li>
                    <?php endif; ?>

                        <?php //Get Rating variable
                            $id = get_the_ID();
                            $item = new stdClass();
                            $item->rating = get_post_meta( $id, 'rating', true );
                        ?>

                        <?php if ($item->rating): ?>
                            <div class="home-companies-desc with-rating">
                        <?php else: ?>
                            <div class="home-companies-desc">
                        <?php endif ?>

                            <div class="home-companies-title"><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></div>

                            <?php
                                $terms = get_the_terms( $post->ID, 'company_category' );
                                $item_cats = ''; $i=0;
                                if(isset($terms) && !empty($terms)){
                                    foreach ($terms as $term ) {
                                        $i++;
                                        if ($i == 1) { $item_cats = '<a href="'.get_term_link(intval($term->term_id), 'company_category').'" title="'.$term->name.'">'.$term->name.'</a>'; } else { $item_cats .= '<span>, </span><a href="'.get_term_link(intval($term->term_id), 'company_category').'" title="'.$term->name.'">'.$term->name.'</a>'; }
                                    }
                                }
                            ?>

                            <div class="home-companies-categories"><?php echo $item_cats; ?></div>

                            <?php if ($item->rating): ?>
                                <div class="home-companies-rating">
                                    <?php for ($i = 1; $i <= $item->rating['max']; $i++): ?>
                                        <i class="fa <?php if (($item->rating['val'] + 1 - $i) >= 1) echo "fa-star"; else if (($item->rating['val'] + 1 - $i) >= 0.5) echo "fa-star-half-o"; else echo 'fa-star-o'; ?> fa-lg"></i>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>

                            <?php $custom_fields = get_post_custom(); ?>
                            <div class="home-companies-description">
                                <?php if(isset($custom_fields['metro_company_doc_desc'][0])) echo $custom_fields['metro_company_doc_desc'][0]; ?>
                            </div>

                            <div class="home-companies-more"><a href="<?php echo get_permalink(); ?>"><i class="fa fa-arrow-circle-right"></i><?php echo __('Read More','metrodir'); ?></a></div>

                        </div>

                    </li>

                <?php endwhile; ?>

            </ul></div>

        </div><!-- /Featured Companies --><!-- Clear --><div class="clear"></div><!-- /Clear --><?php endif; ?>

        <?php wp_reset_query(); wp_reset_postdata(); ?>

        <?php
            query_posts(array(
                'post_type' => array('company'),
                'posts_per_page' => $opt_metrodir_home_latest_count
            ));
        ?>

        <?php if ($opt_metrodir_home_latest == "true" AND have_posts() ): ?><!-- Latest Companies --><div id="latest-carusel">

            <div class="title"><h2><?php echo __('Latest Companies','metrodir'); ?></h2></div>

            <div class="home-companies-carusel carusel-auto"><ul class="slides">

                    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

                        <?php if( has_post_thumbnail() ): ?>
                            <li class="with-image"><div class="home-companies-image"><a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>" class="opacity"><?php echo get_the_post_thumbnail(get_the_ID(),array(220,220)); ?></a></div>
                        <?php else: ?>
                            <li>
                        <?php endif; ?>

                        <?php //Get Rating variable
                        $id = get_the_ID();
                        $item = new stdClass();
                        $item->rating = get_post_meta( $id, 'rating', true );
                        ?>

                        <?php if ($item->rating): ?>
                        <div class="home-companies-desc with-rating">
                    <?php else: ?>
                        <div class="home-companies-desc">
                    <?php endif ?>

                        <div class="home-companies-title"><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></div>

                        <?php
                        $terms = get_the_terms( $post->ID, 'company_category' );
                        $item_cats = ''; $i=0;
                        if(isset($terms) && !empty($terms)){
                            foreach ($terms as $term ) {
                                $i++;
                                if ($i == 1) { $item_cats = '<a href="'.get_term_link(intval($term->term_id), 'company_category').'" title="'.$term->name.'">'.$term->name.'</a>'; } else { $item_cats .= '<span>, </span><a href="'.get_term_link(intval($term->term_id), 'company_category').'" title="'.$term->name.'">'.$term->name.'</a>'; }
                            }
                        }
                        ?>

                        <div class="home-companies-categories"><?php echo $item_cats; ?></div>

                        <?php if ($item->rating): ?>
                            <div class="home-companies-rating">
                                <?php for ($i = 1; $i <= $item->rating['max']; $i++): ?>
                                    <i class="fa <?php if (($item->rating['val'] + 1 - $i) >= 1) echo "fa-star"; else if (($item->rating['val'] + 1 - $i) >= 0.5) echo "fa-star-half-o"; else echo 'fa-star-o'; ?> fa-lg"></i>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?>

                        <?php $custom_fields = get_post_custom(); ?>
                        <div class="home-companies-description">
                            <?php if(isset($custom_fields['metro_company_doc_desc'][0])) echo $custom_fields['metro_company_doc_desc'][0]; ?>
                        </div>

                        <div class="home-companies-more"><a href="<?php echo get_permalink(); ?>"><i class="fa fa-arrow-circle-right"></i><?php echo __('Read More','metrodir'); ?></a></div>

                        </div>

                        </li>

                    <?php endwhile; ?>

                </ul></div>

        </div><!-- /Latest Companies --><!-- Clear --><div class="clear"></div><!-- /Clear --><?php endif; ?>

        <?php wp_reset_query(); wp_reset_postdata(); ?>

</div></div><!-- /Featured And Latest Companies -->
<?php endif; ?>
<?php

$tab_products_cart =  $custom[$shortname . '_products_cart_act'][0];

$product_array = json_decode(htmlspecialchars_decode(get_post_meta(get_the_ID(), 'metro_product', true)));

?>

<?php if($product_array): ?>

    <?php
    $count_product_arr = count((array)$product_array);
    $product_string = '';
    foreach($product_array as $_post) {
        $product_string .= $_post.', ';
    }
    ?>

    <!-- Products --><div id="products"<?php if ($tab_products_cart == "Display") echo ' class="with-card"'; ?>>

        <?php if ($tab_products_cart == "Display"): ?>

            <div class="title">
                <h2><?php echo __('Products','metrodir'); ?></h2>
            </div>

        <?php endif; ?>

        <?php echo do_shortcode('[products ids="'.$product_string.'" columns="3"]'); ?>

    </div><!-- /Products -->

    <?php if ($tab_products_cart == "Display"): ?>

        <!-- Card --><div id="card">

            <div class="title">
                <h2><?php echo __('Cart','metrodir'); ?></h2>
            </div>

            <?php echo do_shortcode( '[woocommerce_cart]' ); ?>

        </div><!-- /Card -->

    <?php endif; ?>

    <div class="clear"></div>

<?php else: ?>

    <!-- Message --><div id="message" class="notification-notice"><div class="box-container"><i class="fa fa-exclamation-circle"></i> <?php echo __("Company haven't yet any product.","metrodir"); ?></div></div><!-- /Message -->

<?php endif;

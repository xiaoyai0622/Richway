<?php if ( is_single() ): ?>

    <?php get_template_part ('single-product'); ?>

<?php else: ?>

    <?php get_template_part ('page-woocommerce'); ?>

<?php endif;
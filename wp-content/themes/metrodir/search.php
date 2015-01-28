<?php if (isset($_GET['adv_search'])): ?>

    <?php get_template_part ('page-search'); ?>

<?php elseif (isset($_GET['search_simple'])): ?>

    <?php get_template_part ('page-search-default'); ?>

<?php elseif (isset($_GET['search_megasearch'])): ?>

    <?php get_template_part ('page-search-mega'); ?>

<?php elseif (isset($_GET['s']) OR isset($_GET['search_blog'])): ?>

    <?php get_template_part ('page-search-blog'); ?>

<?php endif;
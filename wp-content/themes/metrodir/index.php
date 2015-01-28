<?php if (isset($_GET['s']) OR isset($_GET['search_blog']) OR isset($_GET['search_simple']) OR isset($_GET['adv_search']) OR isset($_GET['search_megasearch'])): ?>

    <?php get_template_part ('search'); ?>

<?php elseif (is_tag()): ?>

    <?php get_template_part ('category'); ?>

<?php else: ?>

    <?php get_template_part ('page-blog'); ?>

<?php endif;
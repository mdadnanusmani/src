<?php get_header(); ?>

<?php get_template_part('components/header/small'); ?>

<div class="content">
  <?php

    get_template_part('components/sections/search/desc');
    get_template_part('components/sections/search/list');

  ?>
</div>

<?php get_footer();
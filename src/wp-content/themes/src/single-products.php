<?php get_header(); ?>

<?php get_template_part('components/header/product'); ?>

<div class="content">
  <?php

    get_template_part('components/sections/product/info');
    get_template_part('components/sections/product/contact');
    get_template_part('components/sections/product/related');

  ?>
</div>

<?php get_footer();
<?php get_header(); ?>

<?php get_template_part('components/header/small'); ?>

<div class="content">
  <?php

    get_template_part('components/sections/jobs/offer');
    get_template_part('components/sections/jobs/contact');

  ?>
</div>

<?php get_footer();
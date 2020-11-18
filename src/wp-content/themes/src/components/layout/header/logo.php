<div class="header__logo">
  <a href="<?= home_url('/') ?>">
    <?php if (is_front_page()) : ?>
      <h1 class="header__logoInner">
    <?php else : ?>
      <h2 class="header__logoInner">
    <?php endif; ?>

      <img src="<?= get_field('header_logo', 'option'); ?>" class="header__logoImage" alt="<?php bloginfo('name'); ?>">

    <?php if (is_front_page()) : ?>
      </h1>
    <?php else : ?>
      </h2>
    <?php endif; ?>
  </a>
</div>
<style>
    .footer__social:before {
    color: #5f5a5a !important;
}
</style>
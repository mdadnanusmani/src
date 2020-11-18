<?php

  $header      = get_field('header');
  $breadcrumbs = apply_filters('wpf_helper_breadcrumbs', null);

  if ($header && $breadcrumbs) :

?>
  <section class="pageHeader pageHeader--box">
    <div class="pageHeader__bg" style="background-image: url(<?= $header['bg_image']['sizes']['image-full']; ?>);"></div>
    <div class="pageHeader__inner">
      <div class="container">
       <div class="pageHeader__wrapper">
        <div class="pageHeader__breadcrumbs pageHeader__breadcrumbs--<?= $header['breadcrumbs_style']; ?> hideScroll hideScroll--left">
          <?php foreach ($breadcrumbs as $item) : ?>
            <a href="<?= $item['url']; ?>" class="pageHeader__breadcrumbsItem"><?= $item['title']; ?></a>
          <?php endforeach; ?>
        </div>
        <div class="pageHeader__box pageHeader__box--small">
          <h1 class="pageHeader__title hideScroll hideScroll--right"><?= $header['title']; ?></h1>
          <?php if ($header['desc']) : ?>
            <div class="pageHeader__desc hideScroll"><?= $header['desc']; ?></div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif;
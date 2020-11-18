<?php

  $header      = get_field('header');
  $data        = apply_filters('news_data', $post);
  $breadcrumbs = apply_filters('wpf_helper_breadcrumbs', null);

  if ($header && $data && $breadcrumbs) :

?>
  <section class="pageHeader <?= $header['bg_image'] ? 'pageHeader--box' : ''; ?>">
    <?php if ($header['bg_image']) : ?>
      <div class="pageHeader__bg" style="background-image: url(<?= $header['bg_image']['sizes']['image-full']; ?>);"></div>
    <?php else : ?>
      <div class="pageHeader__bg hideScroll hideScroll--right"></div>
    <?php endif; ?>
    <div class="pageHeader__inner">
      <div class="container">
        <div class="pageHeader__wrapper">
          <div class="pageHeader__breadcrumbs hideScroll hideScroll--left">
            <?php foreach ($breadcrumbs as $item) : ?>
              <a href="<?= $item['url']; ?>" class="pageHeader__breadcrumbsItem"><?= $item['title']; ?></a>
            <?php endforeach; ?>
          </div>
          <div class="<?= $header['bg_image'] ? 'pageHeader__box' : 'pageHeader__content'; ?>">
            <h1 class="pageHeader__title hideScroll hideScroll--right"><?= $data['title']; ?></h1>
            <div class="pageHeader__info hideScroll hideScroll--left">
              <div class="pageHeader__infoItem icon-<?= $data['category_icon']; ?>"><?= $data['category']; ?></div>
              <div class="pageHeader__infoItem"><?= $data['date']; ?></div>
              <div class="pageHeader__infoItem"><?= $data['author']; ?></div>
            </div>
            <div class="pageHeader__desc hideScroll"><?= $data['desc_full']; ?></div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif;
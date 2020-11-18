<?php

  $header        = get_field('header');
  $contactHeader = get_field('header_contact');
  $breadcrumbs   = apply_filters('wpf_helper_breadcrumbs', null);

  if ($header && $contactHeader && $breadcrumbs) :

?>
  <section class="pageHeader pageHeader--box">
    <div class="pageHeader__bg" style="background-image: url(<?= $header['bg_image']['sizes']['image-full']; ?>);"></div>
    <div class="pageHeader__inner">
      <div class="container">
       <div class="pageHeader__wrapper pageHeader__wrapper--padding">
          <div class="pageHeader__breadcrumbs hideScroll hideScroll--left">
            <?php foreach ($breadcrumbs as $item) : ?>
              <a href="<?= $item['url']; ?>" class="pageHeader__breadcrumbsItem"><?= $item['title']; ?></a>
            <?php endforeach; ?>
          </div>
          <div class="pageHeader__content">
            <h1 class="pageHeader__title hideScroll hideScroll--left"><?= $item['title']; ?></h1>
            <div class="pageHeader__desc pageHeader__desc--large hideScroll"><?= $header['desc']; ?></div>
          </div>
          <div class="pageHeader__box pageHeader__box--small pageHeader__box--bottom">
            <div class="pageHeader__contactTitle"><?= $contactHeader['title']; ?></div>
            <a href="tel:<?= preg_replace('/[^0-9]/', '', $contactHeader['phone']); ?>" style="direction: ltr;" class="pageHeader__contactPhone">
              <span><?= $contactHeader['phone']; ?></span>
            </a>
            <div class="pageHeader__contactLocation"><?= $contactHeader['location']; ?></div>
            <ul class="pageHeader__contactItems">
              <li class="pageHeader__contactItem icon-home"><?= $contactHeader['address']; ?></li>
              <li class="pageHeader__contactItem icon-email">
                <p>
                  <a href="mailto:<?= $contactHeader['email']; ?>"><?= $contactHeader['email']; ?></a>
                </p>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif;
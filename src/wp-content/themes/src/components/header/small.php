<?php

  $breadcrumbs = apply_filters('wpf_helper_breadcrumbs', null);

  if ($breadcrumbs) :

?>
  <section class="pageHeader pageHeader--small">
    <div class="pageHeader__inner">
      <div class="container">
        <div class="pageHeader__wrapper">
          <div class="pageHeader__breadcrumbs hideScroll hideScroll--left">
            <?php foreach ($breadcrumbs as $item) : ?>
              <a href="<?= $item['url']; ?>" class="pageHeader__breadcrumbsItem"><?= $item['title']; ?></a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif;
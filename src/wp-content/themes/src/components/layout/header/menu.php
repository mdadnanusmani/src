<?php

  $menuTop    = apply_filters('wpf_helper_menu', 'nav_top');
  $menuMain   = apply_filters('wpf_helper_menu', 'nav_main');
  $menuMobile = array_merge($menuTop, $menuMain);
  $langs      = apply_filters('wpf_helper_langs', 'slug');

?>
<div class="header__content">
  <div class="header__contentInner">
    <div class="header__menuWrapper">
      <ul class="header__menu header__menu--small">
        <li class="header__menuItem">
          <form action="<?= home_url('/') ?>" method="get" class="header__menuSearch">
            <input type="text" name="s" class="header__menuSearchInput" placeholder="<?= __('Search...'); ?>">
            <button type="submit" class="header__menuSearchButton"></button>
          </form>
        </li>
        <?php foreach ($menuTop as $item) : ?>
          <li class="header__menuItem">
            <a href="<?= $item['url']; ?>" target="<?= $item['target']; ?>" class="header__menuLink <?= $item['active'] ? 'header__menuLink--active' : ''; ?>"><?= $item['title']; ?></a>
          </li>
        <?php endforeach; ?>
        <?php if ($langs['others']) : ?>
          <?php foreach ($langs['others'] as $lang) : ?>
            <li class="header__menuItem header__menuItem--lang">
              <a href="<?= $lang['url']; ?>" class="header__menuLink"><?= $lang['title']; ?></a>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>
    <div class="header__menuWrapper">
      <ul class="header__menu header__menu--large">
        <?php foreach ($menuMain as $item) : ?>
          <li class="header__menuItem">
            <a href="<?= $item['url']; ?>" target="<?= $item['target']; ?>" class="header__menuLink <?= $item['active'] ? 'header__menuLink--active' : ''; ?>"><?= $item['title']; ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>
<a href="#" class="header__toggle">
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
</a>
<div class="header__menuMobile">
  <ul class="header__menu header__menu--small">
    <?php foreach ($menuMobile as $item) : ?>
      <li class="header__menuItem">
        <a href="<?= $item['url']; ?>" target="<?= $item['target']; ?>" class="header__menuLink <?= $item['active'] ? 'header__menuLink--active' : ''; ?>"><?= $item['title']; ?></a>
      </li>
    <?php endforeach; ?>
    <li class="header__menuItem">
      <form action="<?= home_url('/') ?>" method="get" class="header__menuSearch header__menuSearch--active">
        <input type="text" name="s" class="header__menuSearchInput" placeholder="<?= __('Search...'); ?>">
        <button type="submit" class="header__menuSearchButton"></button>
      </form>
    </li>
    <?php if ($langs['others']) : ?>
      <?php foreach ($langs['others'] as $lang) : ?>
        <li class="header__menuItem header__menuItem--lang">
          <a href="<?= $lang['url']; ?>" class="header__menuLink"><?= $lang['title']; ?></a>
        </li>
      <?php endforeach; ?>
    <?php endif; ?>
  </ul>
</div>
<?php

  $menu = apply_filters('wpf_helper_menu', 'nav_footer');

?>
<div class="footer__menu hideScroll">
  <?php foreach ($menu as $group) : ?>
    <div class="footer__menuColumn">
      <h5 class="footer__menuTitle"><?= $group['title']; ?></h5>
      <ul class="footer__menuItems">
        <?php foreach ($group['children'] as $item) : ?>
          <li class="footer__menuItem">
            <a href="<?= $item['url']; ?>" target="<?= $item['target']; ?>" class="footer__menuLink <?= $item['active'] ? 'footer__menuLink--active' : ''; ?>"><?= $item['title']; ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endforeach; ?>
</div>
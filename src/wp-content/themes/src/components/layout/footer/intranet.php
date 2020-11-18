<?php

  $title = get_field('contact_text',  'option');
  $items = get_field('contact_items', 'option');

  if ($items) :

?> 
  <h3 class="footer__contactsTitle hideScroll hideScroll--left"><?= __('Intranet helpdesk', 'lang'); ?></h3>
  <div class="footer__contacts hideScroll">
    <?php foreach ($items as $index => $item) : ?>
      <a href="<?= $item['link']['url']; ?>" target="<?= $item['link']['target']; ?>" class="footer__contact">
        <div class="footer__contactIcon icon-<?= $item['icon']; ?>"></div>
        <div class="footer__contactValue"><?= $item['link']['title']; ?></div>
      </a>
    <?php endforeach; ?>
  </div>
<?php endif;
<?php

  $items = get_field('footer_socials', 'option');
  if ($items) :

?>
  <div class="footer__socials">
    <?php foreach ($items as $item) : ?>
      <a href="<?= $item['url']; ?>" target="_blank" class="footer__social icon-<?= $item['icon']; ?>"></a>
    <?php endforeach; ?>
  </div>
<?php endif;
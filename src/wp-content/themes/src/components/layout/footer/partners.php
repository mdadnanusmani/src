<?php

  $items = get_field('footer_partners', 'option');
  if ($items) :

?>
  <div class="footer__partners">
    <?php foreach ($items as $item) : ?>
      <a href="<?= $item['url']; ?>" target="_blank" class="footer__partner">
        <img src="<?= $item['image']['url']; ?>" class="footer__partnerLogo" alt="<?= $item['image']['alt']; ?>">
      </a>
    <?php endforeach; ?>
  </div>
<?php endif;
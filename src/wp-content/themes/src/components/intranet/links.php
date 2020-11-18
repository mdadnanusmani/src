<?php

  $items = get_field('intranet_links', 'option');

  if ($items) :

?>
  <div class="intranetProfile__linksTitle"><?= __('Quick links', 'lang'); ?></div>
  <div class="intranetProfile__linksItems">
    <?php foreach ($items as $item) : ?>
      <a href="<?= $item['link']['url']; ?>" target="<?= $item['link']['target']; ?>" class="intranetProfile__linksItem button button--border button--blue"><?= $item['link']['title']; ?></a>
    <?php endforeach; ?>
  </div>
<?php endif;
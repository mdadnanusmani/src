<?php

  if (!isset($count))
    $count = 0;

  $limit = get_field('archive_news_limit', 'option');

  if (have_posts()) :

    while (have_posts()) :

      the_post();
      $count++;
      $data = apply_filters('search_item', $post);

?>
  <a href="<?= $data['url']; ?>" class="contentBox newsCategories__item <?= ($count > $limit) ? 'newsCategories__item--hidden' : ''; ?>">
    <div class="contentBox__outer">
      <div class="contentBox__inner">
        <div class="contentBox__header">
          <div class="contentBox__category"><?= $data['category']; ?></div>
          <div class="contentBox__date"><?= $data['date']; ?></div>
        </div>
        <h4 class="contentBox__title"><?= $data['title']; ?></h4>
        <div class="contentBox__button button button--inline"><?= __('See more', 'lang'); ?></div>
      </div>
    </div>
  </a>
<?php

    endwhile;
  endif;
<?php

  $cats  = apply_filters('wpf_helper_terms', 'news-category');
  $count = 0;
  $limit = get_field('archive_news_limit', 'option');

  if ($wp_query->found_posts) :

?>
  <section class="newsCategories section">
    <div class="newsCategories__inner">
      <div class="container">
        <div class="newsCategories__wrapper">
          <div class="newsCategories__items hideScroll" data-limit="<?= $limit; ?>">
            <?php include 'posts.php'; ?>
          </div>
          <div class="newsCategories__moreWrapper hideScroll">
            <a href="#" class="newsCategories__more <?= ($count <= $limit) ? 'newsCategories__more--hidden' : ''; ?> button button--border button--blue"><?= __('Load more', 'lang'); ?></a>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif;
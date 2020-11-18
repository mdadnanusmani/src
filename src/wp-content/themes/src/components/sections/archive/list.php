<?php

  $cats  = apply_filters('wpf_helper_terms', 'news-category');
  $count = 0;
  $limit = get_field('archive_news_limit', 'option');

  if ($cats) :

?>
  <section class="newsCategories section">
    <div class="newsCategories__inner">
      <div class="container">
        <div class="newsCategories__wrapper">
          <div class="row">
            <div class="col-4 col-mdl-12">
              <div class="newsCategories__categoriesWrapper">
                <ul class="newsCategories__categories hideScroll hideScroll--left">
                  <!--<li class="newsCategories__category">
                    <a href="<?= get_post_type_archive_link('news'); ?>" class="newsCategories__categoryLink <?= is_post_type_archive('news') ? 'newsCategories__categoryLink--active' : ''; ?>"><?= __('All publications', 'lang'); ?></a>
                  </li> -->
                  <?php foreach ($cats as $cat) : ?>
                    <li class="newsCategories__category">
                      <a href="<?= $cat['url']; ?>" class="newsCategories__categoryLink <?= is_tax('news-category', $cat['id']) ? 'newsCategories__categoryLink--active' : ''; ?>"><?= $cat['title']; ?></a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
            <div class="col-8 col-mdl-12">
              <div class="newsCategories__items hideScroll" data-limit="<?= $limit; ?>">
                <?php include 'posts.php'; ?>
              </div>
              <div class="newsCategories__moreWrapper hideScroll">
                <a href="#" class="newsCategories__more <?= ($count <= $limit) ? 'newsCategories__more--hidden' : ''; ?> button button--border button--blue"><?= __('Load more', 'lang'); ?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif;